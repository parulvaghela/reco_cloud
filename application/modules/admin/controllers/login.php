<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model', 'l_model');
    }
    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        } else if ($this->session->userdata('user_logged_in')) {
            redirect('user/dashboard');
        } else {
            $resp = array();
            $data['content'] = $this->load->view('login', $resp, true);
            load_admin_template($data);
        }
    }
    public function check_login()
    {
        $this->form_validation->set_rules('email', 'Email Address', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            $username = $this->input->post('email');
            $password = $this->input->post('password');
            $result = $this->l_model->check_login($username, md5($password));
            // echo '<pre>'; print_r($result);exit;
            if ($result == 0) {
                $this->session->set_flashdata('login_error', '<div class="alert alert-danger">Email Address/Username or Password is Wrong.A minimum 8 characters password contains a combination of uppercase and lowercase letter, spacial character and number.</div>');
                redirect('admin/login', 'refresh');
            } else if (!empty($result) && $result['status'] != 1) {
                $this->session->set_flashdata('login_error', '<div class="alert alert-danger">Your account is De-Activated. please contact your system administrator</div>');
                redirect('admin/login', 'refresh');
            } else {
                if (!empty($result) && $result['role_id'] == 1) {
                    /* admin */
                    $sess_array = array(
                        'id' => $result['id'],
                        'email' => $result['email'],
                        'phone_no' => $result['mobile'],
                        'username' => $result['first_name'] . " " . $result['last_name'],
                        'role_id' => $result['role_id'],
                        'is_login' => true,
                    );
                    $this->session->set_userdata('logged_in', $sess_array);
                    redirect('admin/dashboard');
                }else{
                    $this->session->set_flashdata('login_error', '<div class="alert alert-danger">Email Address/Username or Password is Wrong.A minimum 8 characters password contains a combination of uppercase and lowercase letter, spacial character and number.</div>');
                    redirect('admin/login', 'refresh');
                }
            }
        } else {
            $this->session->set_flashdata('login_error', '<div class="alert alert-danger">Something went wrong.</div>');
            redirect('admin/login', 'refresh');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        redirect('admin/login', 'refresh');
    }
}
