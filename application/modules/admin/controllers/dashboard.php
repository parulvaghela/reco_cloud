<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model', 'l_model');
    }
    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        } else {
            $data = array();
            $data['active_link'] = 'dashboard';
            $data['title'] = 'Dashboard';
            $data['meta_description'] = 'Dashboard';
            $data['meta_keyword'] = 'Dashboard';
            $data['content'] = $this->load->view('dashboard', $data, true);
            load_admin_template($data);
            //echo 'dashboard';exit;
        }
    }
}
