<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class User_dashboard extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('user_model','user');
        $this->load->model('sql_model','sql');
    }
    public function index()
    {
        if (!$this->session->userdata('user_logged_in')) {
            redirect('login');
        } else {
            $data = array();
            $user_id = $this->session->userdata('user_logged_in')['id'];
            $data['active_link'] = 'dashboard';
            $data['content'] = $this->load->view('dashboard', $data, true);
            load_public_template($data);
        }
    }
    public function edit_profile()
    {
        if ($this->session->userdata('user_logged_in')) {     
            $user_id = $this->session->userdata('user_logged_in')['id'];
            if($_POST)
            {
                $email = $this->input->post('email');
                $org_email = $this->user->email_is_unique($user_id);
                if ($this->input->post('email') != $org_email) {
                    $is_unique = '|is_unique[members.email_id]';
                } else {
                    $is_unique = '';
                }
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
                $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email'.$is_unique);
                $validate = $this->form_validation->run();
                if($validate == true)
                {
                    if ($_FILES['s_image']['name'] != "") {
                        // Set preference
                        $dir_name = "profile/";
                        $config['upload_path'] = './uploads/' . $dir_name;
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
                        $config['max_size'] = '500'; // max_size in kb
                        $config['file_name'] = $_FILES['s_image']['name'];
                        //Load upload library
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('s_image')) {
                            $error = array('error' => $this->upload->display_errors());
                        } else {
                            $image_data = $this->upload->data();
                            $configer = array(
                                'image_library' => 'gd2',
                                'source_image' => $image_data['full_path'],
                                'maintain_ratio' => false,
                                'width' => 500,
                                'height' => 600,
                            );
                            $this->image_lib->clear();
                            $this->image_lib->initialize($configer);
                            $this->image_lib->resize();
                            $image_name = $image_data['file_name'];
                        }
                    } else {
                        $image_name = $this->input->post('old_image');
                    }
                    $up_profile = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'phone_no' => $this->input->post('phone_number'),
                        'email_id' => $this->input->post('email'),
                        'profile_pic' => $image_name
                    );
                    $condition = array('id' => $user_id);
                    $up_img = $this->sql->update_data('members', $condition, $up_profile);
                    $this->session->set_flashdata('profile_error', '<div class="alert alert-success">Profile Update Successfully</div>');
                    redirect('user/profile-edit');
                }
            }
            $data = array();
            $data['user_data'] = $this->user->get_current_userdata($user_id);
            $data['active_link'] = 'settings';
            $data['content'] = $this->load->view('profile_edit', $data, true);
            load_public_template($data);
        }else{
            redirect('login');
        }  
    }
    public function change_password()
    {
        if ($this->session->userdata('user_logged_in')) {
            $id = $this->session->userdata('user_logged_in')['id'];
            $row = $this->user->get_current_userdata($id);
           if($row['register_type'] == 1)
           {
               $this->form_validation->set_rules('current_password', 'Current Password', 'required');
               $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]|max_length[20]');
               $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
               $validate = $this->form_validation->run();
               if ($validate == true) {
                   $current_password = md5($this->input->post('current_password'));
                   $new_password = md5($this->input->post('new_password'));
                   $confirm_password = md5($this->input->post('confirm_password'));
                   if ((!strcmp($current_password, $row['password'])) && (!strcmp($new_password, $confirm_password))) {
                       $up_arr = array(
                                        'password' => $new_password
                                    );
                        $condition = array("id" => $id);
                       $this->sql->update_data("members", $condition, $up_arr);
                       $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">password change successfully </div>');
                        $this->session->set_userdata('change_arr','<div class="alert alert-success">Password successfully change</div>');
                        redirect('logout');
                   } else {
                       $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> password not match </div>');
                       redirect('user/changepassword');
                   }
               }
           }else{
               $this->form_validation->set_rules('new_password', 'New Password', 'required');
               $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
               $validate = $this->form_validation->run();
               if ($validate == true) {
                   $new_password = md5($this->input->post('new_password'));
                   $confirm_password = md5($this->input->post('confirm_password'));
                   $up_arr = array(
                        'password' => $new_password
                    );
                   $condition = array("id" => $id);
                   $this->sql->update_data("members", $condition, $up_arr);
                   $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">password change successfully </div>');
                    $this->session->set_userdata('change_arr','<div class="alert alert-success">Password successfully change</div>');
                    redirect('logout');
               }
           }
            $data = array();
            $data['active_link'] = 'settings';
            $data['content'] = $this->load->view('change_password', $data, true);
            load_public_template($data);
        } else {
            redirect('login');
        }
    }
   public function check_current_password() {
        $this->input->post('current_password');
        $old_password = md5($this->input->post('current_password'));
        $data = $this->user->check_user_old_pass();
        if ($data['password'] != $old_password) {
            $output = false;
        } else {
            $output = true;
        }
        echo json_encode($output);
        exit;
    }
}