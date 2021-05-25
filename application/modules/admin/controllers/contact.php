<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Contact extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('contact_model', 'contact');
        $this->load->model('sql_model', 'sql');
    }
    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        } else {
            redirect('admin/dashboard');
        }
    }
    public function contact_view()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        } else {

        	 $data['active_link'] = 'Contact_list';
            $data['content'] = $this->load->view('contact_view', $data, true);
            load_admin_template($data);
        }
    }
    public function contact_view_list(){
    	$contact_status = $this->input->post('contact_status');
    	$this->contact->contact_list_ajax($contact_status);
    }
    public function  deactive_contact(){
    	  $res_arr = array();
        $status = $this->input->post('status');
        $id = $this->input->post('id');
        if (isset($id) && !empty($id) && isset($status)) {
            $condition = array('id' => $id);
            $up_arr = array('status' => $status);
            $up_data = $this->sql->update_data('tbl_contact', $condition, $up_arr);
            if ($up_data == 1) {
                $result = $this->contact->get_contact_status_byid($id);
                if ($result != 0) {
                    if ($result['status'] == 0) {
                        $res_arr = array(
                            'msg' => 'User deactive successfully',
                            'status' => 1,
                        );
                    } else {
                        $res_arr = array(
                            'msg' => 'User active successfully',
                            'status' => 1,
                        );
                    }
                } else {
                    $res_arr = array(
                        'msg' => 'something went wrong',
                        'status' => 0,
                    );
                }
            } else {
                $res_arr = array(
                    'msg' => 'something went wrong',
                    'status' => 0,
                );
            }
        } else {
            $res_arr = array(
                'msg' => 'data not found',
                'status' => 0,
            );
        }
        echo json_encode($res_arr);
        exit;
    }
}
