<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Setting extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('setting_model', 'setting');
        $this->load->model('sql_model', 'sql');
    }

    public function email_setting()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        } else {
            if ($_POST) {
                $this->form_validation->set_rules('name', "Name", "trim|required");
                $this->form_validation->set_rules('email', "Email", "trim|required|valid_email");
                $this->form_validation->set_rules('password', "Password", "trim|required");
                if ($this->form_validation->run() == true) {
                    $name = $this->input->post('name');
                    $email = $this->input->post('email');
                    $password = key_encrypt($this->input->post('password'));
                    $update_array = array(
                        'name' => $name,
                        'smtp_user' => $email,
                        'reply_to' => $email,
                        'smtp_pass' => $password,
                    );
                    $update = $this->sql->update_data('email_settings', array('status' => 1), $update_array);
                    if ($update == true) {
                        $this->session->set_flashdata('email_update_success', '<div class="alert alert-success">Email successfully update</div>');
                        redirect('admin\email_setting');
                    }
                }
            }
            $data['get_email_setting_data'] = $this->setting->email_setting_data();
            $data['active_link'] = 'settings';
            $data['content'] = $this->load->view('email_setting', $data, true);
            load_admin_template($data);
        }
    }

    // forgot password
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
       if ($this->session->userdata('logged_in')) {
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
                $forgot_url = "admin/forgot-new-password/" . $deript_fcode . '/' . $deript_uid;
                $validate = $this->form_validation->run();
                if ($validate == true) {
                    $dataArr = array(
                        'password' => md5($this->input->post('newpwd')),
                        
                    );
                    $condition = array('id' => $uid);
                    $this->sql->update_data("members", $condition, $dataArr);
                    $mst_arr = array('forgot_code' => '');
                    $mst_con =  array('members_id' => $uid);
                    $this->sql->update_data("master_user_role", $mst_con, $mst_arr);
                    $this->session->set_flashdata('login_error', '<div class="alert alert-success"> Password Successfully Updated </div>');
                    redirect('admin/login');
                } else {
                    $this->session->set_flashdata('forgot_error', '<div class="alert alert-danger"> Enter Valid Password.</div>');
                    redirect($forgot_url);
                }
            } else {
                redirect('admin/forgot-password');
            }
        }
    }
    public function forgot_new_password($fcode, $uid)
    {
        $deript_uid = key_decrypt($uid);
        $deript_fcode = key_decrypt($fcode);
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        } else {
            if (!empty($fcode) && !empty($uid)) {
                $client_email = $this->input->post('email_id');
                $userinfo = $this->setting->check_forgot_code_uid($deript_fcode, $deript_uid);
                if ($userinfo != 0) {
                    $user_status = $userinfo[0]['status'];
                    if ($user_status == 1) {
                        $resp = array();
                        $resp['userinfo'] = $userinfo[0];
                        $this->load->view('new_password', $resp);
                    } else {
                        $this->session->set_flashdata('forgot_error', 'Your account is inactive !! Please contact our support system.</div>');
                        redirect('admin/forgot-password');
                    }
                } else {
                    $this->session->set_flashdata('forgot_error', '<div class="alert alert-danger">Link expire Please Try again .</div>');
                    redirect('admin/forgot-password');
                }
            } else {
                $this->session->set_flashdata('forgot_error', '<div class="alert alert-danger">Please Forgot Password First.</div>');
                redirect('admin/forgot-password');
            }
        }
    }
    public function forgot_password()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        } else {
            if ($_POST) {
                $this->form_validation->set_rules('email_id', 'Email Id', 'trim|required|valid_email');
                $validate = $this->form_validation->run();
                if ($validate == true) {
                    $email_id = $this->input->post('email_id');
                    $userinfo = $this->setting->get_forgot_client_info($email_id);
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
                            $condition = array('members_id' => $id);
                            $this->sql->update_data("master_user_role", $condition, $dataArr);
                            $forgot_url = base_url() . "forgot-new-password/" . $forgot_code_encrypt . '/' . $id_encrypt;
                            echo  $forgot_url;exit;
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
                                    redirect('admin/login');
                                } else {
                                    $this->session->set_flashdata('login_error', '<div class="alert alert-danger">Mail not send Please Try Again</div>');
                                    redirect('admin/login');
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
                    redirect('admin/forgot-password');
                }
            }
            $this->load->view('forgot_password');
        }
    }

    /**********************change password ********************************* */
    public function change_password() {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        } else {
            $newpassword = $this->input->post('new_pass');
            $oldpassword = $this->input->post('old_pass');
            $data = array();
            if ($_POST) {
                $this->form_validation->set_rules('old_pass', 'Old password', 'trim|required');
                $this->form_validation->set_rules('new_pass', 'New password', 'trim|required');
                $this->form_validation->set_rules('con_pass', 'Confirm password', 'trim|required');
                if ($this->form_validation->run() == TRUE) {
                    $update_array = array();
                    $get_admin = $this->session->userdata('logged_in');
                    $data = $this->setting->get_admin_old_password($get_admin['id'], $get_admin['role_id']);
                    if ($data['password'] == md5($oldpassword)) {
                        $upadate_pass = $this->sql->update_data('members', array('id' => $data['id']), array('password' => md5($newpassword)));
                        if ($upadate_pass == 1) {
                            $this->session->set_userdata('change_arr', '<div class="alert alert-success">Password successfully change</div>');
                            redirect('logout');
                        }
                    } else {
                        $this->session->set_flashdata('old_password_error', '<span class="errors">Old password can not be same</span>');
                        redirect('admin/change-password', 'refresh');
                    }
                }
            }
            $data['active_link'] = 'settings';
            $data['content'] = $this->load->view('change_password', $data, true);
            load_admin_template($data);
        }
    }
    public function check_old_password() {
        $this->input->post('old_pass');
        $old_password = md5($this->input->post('old_pass'));
        $data = $this->setting->check_admin_old_pass();
        if ($data['password'] != $old_password) {
            $output = false;
        } else {
            $output = true;
        }
        echo json_encode($output);
        exit;
    }

}