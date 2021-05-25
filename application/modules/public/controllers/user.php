<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class User extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        include_once APPPATH . "libraries/vendor/autoload.php";
        $this->load->library('image_lib');
        $this->load->model('sql_model', 'sql');
        $this->load->model('user_model', 'user');
    }
    public function user_register()
    {
        if (!$this->session->userdata('user_logged_in')) {
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[members.email_id]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required|matches[password]');
            if ($this->form_validation->run() == true) {
                $dir_name = "profile/";
                $config['upload_path'] = './uploads/' . $dir_name;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = '500'; // max_size in kb
                $config['file_name'] = $_FILES['profile_pic']['name'];
                //Load upload library
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('profile_pic')) {
                    $res_array = array(
                        $data['img_error'] = $this->upload->display_errors(),
                    );
                    $this->session->set_flashdata('reg_error', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
                    redirect('register');exit;
                } else {
                    $image_data = $this->upload->data();
                    $configer = array(
                        'image_library' => 'gd2',
                        'source_image' => $image_data['full_path'],
                        'create_thumb' => false,
                        'maintain_ratio' => false,
                        'width' => 100,
                        'height' => 100,
                    );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configer);
                    $this->image_lib->resize();
                    $register_user = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'email_id' => $this->input->post('email'),
                        'phone_no' => $this->input->post('phone_no'),
                        'password' => md5($this->input->post('password')),
                        'profile_pic' => $image_data['file_name'],
                        'added_date' => time(),
                        'status' => 1
                    );
                    $user_ins = $this->sql->last_insert_id('members', $register_user);
                    if ($user_ins != 0) {
                        $role_ins = array(
                            'master_id' => $user_ins,
                            'role_id' => 2,
                            'status' => 1,
                        );
                        $this->sql->insert_data('master_role', $role_ins);
                        $sess_array = array(
                            'id' => $user_ins,
                            'email' => $this->input->post('emali'),
                            'phone_no' => $this->input->post('phone_no'),
                            'username' => $this->input->post('first_name') . " " . $this->input->post('last_name'),
                            'role_id' => 2,
                            'is_login' => true,
                        );
                        $this->session->set_userdata('user_logged_in', $sess_array);
                        $mail_data = $this->sql->email_setting_data();
                        if ($mail_data != 0) {
                            $to = strtolower($this->input->post('email'));
                            $from = $mail_data['smtp_user'];
                            $fromName = 'newreputation';
                            $subject = "Service Manager - register success mail.";
                            $htmlContent = '<!DOCTYPE html>
                                <html>
                                <head>
                                        <title>Newreoutation</title>
                                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                </head>
                                <body style="background: #92D050;">
                                    <table style="width:100%; font-family:Verdana, Geneva, sans-serif;text-align:left;border:0px" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td style="font-size:14px;padding:10px 0;color:#000;">Dear ' . $this->input->post('first_name') . ' ' . $this->input->post('last_name') . ',</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:14px;padding:10px 0;color:#000;">register success</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </body>
                                </html>';
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                            $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";
                           // mail($to, $subject, $htmlContent, $headers);
                        }
                        $this->session->set_flashdata('reg_error', '<div class="alert alert-success">You have sccessfully register now you can login</div>');
                        redirect('user/dashboard');
                    } else {
                        $this->session->set_flashdata('reg_error', '<div class="alert alert-danger">Somthing want to wrong</div>');
                        redirect('register');
                    }
                }
            } else {
                $data = array();
                $data['content'] = $this->load->view('register', $data, true);
                load_public_template($data);
            }
        } else {
            redirect('user/dashboard');
        }
    }
   /************************facebook register ***************************************** */
   public function fb_register()
   {
       if (!session_id()) {
           session_start();
       }
       $social_data = $this->user->get_fb_credential();
       $app_id = "";
       $app_secret = "";
       if($social_data != 0)
       {
           $app_id = $social_data['client_id'];
           $app_secret = $social_data['client_secret'];
       }
       $fb = new Facebook\Facebook([
           'app_id' => $app_id,
           'app_secret' => $app_secret,
           'default_graph_version' => facebook_graph_version,
       ]);
       $helper = $fb->getRedirectLoginHelper();
       $permissions = facebook_permissions;
       // For more permissions like user location etc you need to send your application for review
       $loginUrl = $helper->getLoginUrl(facebook_login_redirect_url, $permissions);
       //  echo $loginUrl;exit;
       header("location: " . $loginUrl);
   }
   public function fbcallback()
   {
       if (!session_id()) {
           session_start();
       }
       $social_data = $this->user->get_fb_credential();
       $app_id = "";
       $app_secret = "";
       if($social_data != 0)
       {
           $app_id = $social_data['client_id'];
           $app_secret = $social_data['client_secret'];
       }
       $fb = new Facebook\Facebook([
           'app_id' => $app_id,
           'app_secret' => $app_secret,
           'default_graph_version' => facebook_graph_version,
       ]);
       $helper = $fb->getRedirectLoginHelper();
       try {
           $accessToken = $helper->getAccessToken();
       } catch (Facebook\Exceptions\FacebookResponseException $e) {
           echo 'Graph returned an error: ' . $e->getMessage();
           exit;
       } catch (Facebook\Exceptions\FacebookSDKException $e) {
           echo 'Facebook SDK returned an error: ' . $e->getMessage();
           exit;
       }
       try {
           $response = $fb->get('/me?fields=id,name,email,first_name,last_name,picture', $accessToken);
       } catch (Facebook\Exceptions\FacebookResponseException $e) {
           echo 'ERROR: Graph ' . $e->getMessage();
           exit;
       } catch (Facebook\Exceptions\FacebookSDKException $e) {
           echo 'ERROR: validation fails ' . $e->getMessage();
           exit;
       }
       // User Information Retrival begins................................................
       $me = $response->getGraphUser();
       $email = $me->getProperty('email');
       $result = $this->user->get_user_by_email($email);
       if ($result != 0) {
           $sess_array = array(
               'id' =>  $result['id'],
               'email' => $result['email_id'],
               'username' => $result['first_name'] . " " . $result['last_name'],
               'role_id' => 2,
               'is_login' => true,
           );
           $this->session->set_userdata('user_logged_in', $sess_array);
           redirect('user/dashboard');
       } else {
           //$location = $me->getProperty('location');
           $name = $me->getProperty('name');
           $f_name = $me->getProperty('first_name');
           $l_name = $me->getProperty('last_name');
           //$gender =$me->getProperty('gender');
           $email = $me->getProperty('email');
           //$location_name = $location['name'];
           //$dob = $me->getProperty('birthday')->format('d/m/Y');
           $fb_id = $me->getProperty('id');
           $picture = $me->getProperty('picture');
           $profile_pic = $picture['url'];
           $register_user = array(
               'first_name' => $f_name,
               'last_name' => $l_name,
               'email_id' => $email,
               'profile_pic' => $profile_pic,
                'social_id' => $fb_id,
               'added_date' => time(),
               'status' => 1,
               'register_type' => 2,
           );
           $user_ins = $this->sql->last_insert_id('members', $register_user);
           if ($user_ins != 0) {
               $role_ins = array(
                   'master_id' => $user_ins,
                   'role_id' => 2,
                   'status' => 1,
               );
               $this->sql->insert_data('master_role', $role_ins);
               $sess_array = array(
                   'id' => $user_ins,
                   'email' => $email,
                   'username' => $f_name . " " . $l_name,
                   'role_id' => 2,
                   'is_login' => true,
               );
               $this->session->set_userdata('user_logged_in', $sess_array);
                $mail_data = $this->sql->email_setting_data();
                if($mail_data != 0)
                {
                    $to = strtolower($email);
                    $from = $mail_data['smtp_user'];
                        $fromName = 'newreputation';
                       $subject = "Service Manager - Registration Mail.";
                        $htmlContent = '<!DOCTYPE html>
                        <html>
                        <head>
                                <title>Newreoutation</title>
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        </head>
                        <body style="background: #92D050;">
                            <table style="width:100%; font-family:Verdana, Geneva, sans-serif;text-align:left;border:0px" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td style="font-size:14px;padding:10px 0;color:#000;">Dear ' . $f_name.' '.  $l_name. ',</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;padding:10px 0;color:#000;">register success</td>
                                </tr>
                            </tbody>
                            </table>
                        </body>
                        </html>';
                       $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";
                       mail($to, $subject, $htmlContent, $headers);
                }
                $this->session->set_flashdata('reg_error', '<div class="alert alert-success">You have sccessfully register now you can login</div>');
                redirect('user/dashboard');
           }
       }
   }
   /*****************************************************google register **************************************** */
   public function google_register()
   {
        $social_data = $this->user->get_google_credential();
       $client_id = "";
       $client_secret = "";
       if($social_data != 0)
       {
           $client_id = $social_data['client_id'];
           $client_secret = $social_data['client_secret'];
       }
       // Google Client Configuration
       $gClient = new Google_Client();
       $gClient->setApplicationName('Google Login');
       $gClient->setClientId($client_id);
       $gClient->setClientSecret($client_secret);
       $gClient->setRedirectUri(Google_redirectUrl);
        $gClient->addScope("email");
        $gClient->addScope("profile");
        //$gClient->addScope("https://www.googleapis.com/auth/business.manage");
        $google_oauthV2 = new Google_Service_Oauth2($gClient);
       $authUrl = $gClient->createAuthUrl();
        header('Location: ' . $authUrl);
    }
   public function google_auth()
   {
        $social_data = $this->user->get_google_credential();
        $client_id = "";
        $client_secret = "";
        if($social_data != 0)
       {
           $client_id = $social_data['client_id'];
           $client_secret = $social_data['client_secret'];
       }
       // Google Client Configuration
       $gClient = new Google_Client();
       $gClient->setApplicationName('Google Login');
       $gClient->setClientId($client_id);
       $gClient->setClientSecret($client_secret);
       $gClient->setRedirectUri(Google_redirectUrl);
        $gClient->addScope("email");
        $gClient->addScope("profile");
        //$gClient->addScope("https://www.googleapis.com/auth/business.manage");
       $google_oauthV2 = new Google_Service_Oauth2($gClient);
       if (isset($_REQUEST['code'])) {
           $gClient->authenticate($_REQUEST['code']);
           $this->session->set_userdata('token', $gClient->getAccessToken());
       }
       $token = $this->session->userdata('token');
       if (!empty($token)) {
           $gClient->setAccessToken($token);
       }
       if ($gClient->getAccessToken()) {
           $userProfile = (array)$google_oauthV2->userinfo->get();
            $auth_provider = 'google';
           $u_id = $userProfile['id'];
           $first_name = $userProfile['givenName'];
           $last_name = $userProfile['familyName'];
           $email = $userProfile['email'];
           $picture = $userProfile['picture'];
           $result = $this->user->get_user_by_email($email);
           if($result != 0)
           {
              
               $sess_array = array(
                   'id' =>  $result['id'],
                   'email' => $result['email_id'],
                   'username' => $result['first_name'] . " " . $result['last_name'],
                   'role_id' => 2,
                   'is_login' => true,
               );
               $this->session->set_userdata('user_logged_in', $sess_array);
               redirect('user/dashboard');
               
           }else{
               $register_user = array(
                   'first_name' => $first_name,
                   'last_name' => $last_name,
                   'email_id' => $email,
                   'profile_pic' => $picture,
                    'social_id' => $u_id,
                    'added_date' => time(),
                   'status' => 1,
                   'register_type' => 3,
               );
               $user_ins = $this->sql->last_insert_id('members', $register_user);
               if ($user_ins != 0) {
                   $role_ins = array(
                       'master_id' => $user_ins,
                       'role_id' => 2,
                       'status' => 1,
                   );
                   $this->sql->insert_data('master_role', $role_ins);
                   $sess_array = array(
                       'id' => $user_ins,
                       'email' => $email,
                       'username' => $first_name . " " . $last_name,
                       'role_id' => 2,
                       'is_login' => true,
                   );
                   $this->session->set_userdata('user_logged_in', $sess_array);
                    $mail_data = $this->sql->email_setting_data();
                        if($mail_data != 0)
                        {
                            $to = strtolower($email);
                            $from = $mail_data['smtp_user'];
                                $fromName = 'newreputation';
                               $subject = "Service Manager - Registration Mail.";
                                $htmlContent = '<!DOCTYPE html>
                                <html>
                                <head>
                                        <title>Newreoutation</title>
                                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                </head>
                                <body style="background: #92D050;">
                                    <table style="width:100%; font-family:Verdana, Geneva, sans-serif;text-align:left;border:0px" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td style="font-size:14px;padding:10px 0;color:#000;">Dear ' . $first_name.' '. $last_name. ',</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:14px;padding:10px 0;color:#000;">register success</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </body>
                                </html>';
                               $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";
                                mail($to, $subject, $htmlContent, $headers);
                        }
                        $this->session->set_flashdata('reg_error', '<div class="alert alert-success">You have sccessfully register now you can login</div>');
                        redirect('user/dashboard');
               }
           }
       }
   }
    public function email_check()
    {
        if (isset($_POST['email'])) {
            $email = $this->input->post('email');
            $result = $this->user->check_unique_email($email);
            if ($result == true) {
                $output = false;
            } else {
                $output = true;
            }
        }
        echo json_encode($output);exit;
    }
    public function forgot_key($length)
    {
        $pool = array_merge(range(0, 9), range("A", "Z"));
        $key = '';
        for ($i = 0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }
        return $key;
    }
    public function set_new_password_forgot()
    {
        if ($this->session->userdata('user_logged_in')) {
            redirect('user/dashboard');
        } elseif ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        } else {
            if ($_POST) {
                $this->form_validation->set_rules('newpwd', 'Password', 'trim|required');
                $this->form_validation->set_rules('cfpwd', 'Confirm Password', 'required|matches[newpwd]');
                $this->form_validation->set_rules('userid', 'User Id', 'required');
                $this->form_validation->set_rules('fcode', 'Forgot Code', 'required');
                $uid = $this->input->post('userid');
                $fcode = $this->input->post('fcode');
                $deript_uid = key_encrypt($uid);
                $deript_fcode = key_encrypt($fcode);
                $forgot_url = "forgot_new_password/" . $deript_fcode . '/' . $deript_uid;
                $validate = $this->form_validation->run();
                if ($validate == true) {
                    $dataArr = array(
                        'password' => md5($this->input->post('newpwd')),
                        'forgot_code' => '',
                    );
                    $condition = array('id' => $uid);
                    $this->sql->update_data("members", $condition, $dataArr);
                    $this->session->set_flashdata('login_error', '<div class="alert alert-success"> Password Successfully Updated </div>');
                    redirect('login');
                } else {
                    $this->session->set_flashdata('forgot_error', '<div class="alert alert-danger"> Enter Valid Password.</div>');
                    redirect($forgot_url);
                }
            } else {
                redirect('forgot_password');
            }
        }
    }
    public function forgot_new_password($fcode, $uid)
    {
        $deript_uid = key_decrypt($uid);
        $deript_fcode = key_decrypt($fcode);
        if ($this->session->userdata('user_logged_in')) {
            redirect('user/dashboard');
        } elseif ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        } else {
            if (!empty($fcode) && !empty($uid)) {
                $client_email = $this->input->post('email_id');
                $userinfo = $this->user->check_forgot_code_uid($deript_fcode, $deript_uid);
                if ($userinfo != 0) {
                    $user_status = $userinfo[0]['status'];
                    if ($user_status == 1) {
                        $resp = array();
                        $resp['userinfo'] = $userinfo[0];
                        $this->load->view('new_password', $resp);
                    } else {
                        $this->session->set_flashdata('forgot_error', 'Your account is inactive !! Please contact our support system.</div>');
                        redirect('forgot_password');
                    }
                } else {
                    $this->session->set_flashdata('forgot_error', '<div class="alert alert-danger">Link expire Please Try again .</div>');
                    redirect('forgot_password');
                }
            } else {
                $this->session->set_flashdata('forgot_error', '<div class="alert alert-danger">Please Forgot Password First.</div>');
                redirect('forgot_password');
            }
        }
    }
    public function forgot_password()
    {
        if ($this->session->userdata('user_logged_in')) {
            redirect('user/dashboard');
        } elseif ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        } else {
            if ($_POST) {
                $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email');
                $validate = $this->form_validation->run();
                if ($validate == true) {
                    $email_id = $this->input->post('email_id');
                    $userinfo = $this->user->get_forgot_client_info($email_id);
                    if ($userinfo != 0) {
                        $user_status = $userinfo[0]['status'];
                        if ($user_status == 1) {
                            $forgot_code = $this->forgot_key(8);
                            $id = $userinfo[0]['id'];
                            $forgot_code_encrypt = key_encrypt($forgot_code);
                            $id_encrypt = key_encrypt($id);
                            $dataArr = array(
                                'forgot_code' => $forgot_code,
                            );
                            $condition = array('id' => $id);
                            $this->sql->update_data("members", $condition, $dataArr);
                            $forgot_url = base_url() . "forgot_new_password/" . $forgot_code_encrypt . '/' . $id_encrypt;
                            /*********************************** Email *******************************************/
                            $mail_data = $this->sql->email_setting_data();
                            if ($mail_data != 0) {
                                $to = $email_id;
                                $from = $mail_data['smtp_user'];
                                $subject = "Forgot password";
                                $message = "<a href='" . $forgot_url . "'><button>Forgot Password</button></a>";
                                $headers = "MIME-Version: 1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $headers .= 'From: ' . $from . "\r\n";
                                $headers .= 'Reply-To: ' . $from . "\r\n";
                                $send_mail = mail($to, $subject, $message, $headers);
                                if ($send_mail == 1) {
                                    $this->session->set_flashdata('login_error', '<div class="alert alert-success">Dear user,<br> we have successfully sent email to your ' . $email_id . ' please check and easily change your password. </div>');
                                    redirect('login');
                                } else {
                                    $this->session->set_flashdata('login_error', '<div class="alert alert-danger">Mail not send Please Try Again</div>');
                                    redirect('login');
                                }
                            }
                            /*********************************** End Email *****************************************/
                        } else {
                            $this->session->set_flashdata('forgot_error', '<div class="alert alert-danger"> Your account is inactive !! Please contact our support system.</div>');
                        }
                    } else {
                        //Enter valid Email Id
                        $this->session->set_flashdata('forgot_error', '<div class="alert alert-danger">Invalid Email !! Please try again.</div>');
                    }
                    redirect('forgot_password');
                }
            }
            $this->load->view('forgot_password');
        }
    }
 
}
