<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Faq extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('faq_model', 'faq');
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
    public function faq_view()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        } else {

             $data['active_link'] = 'Contact_list';
            $data['content'] = $this->load->view('faq_list', $data, true);
            load_admin_template($data);
        }
    }
    public function faq_view_list(){
        $contact_status = $this->input->post('contact_status');
        $this->faq->faq_list_ajax($contact_status);
    }
    public function  deactive_faq(){
          $res_arr = array();
        $status = $this->input->post('status');
        $id = $this->input->post('id');
        if (isset($id) && !empty($id) && isset($status)) {
            $condition = array('id' => $id);
            $up_arr = array('status' => $status);
            $up_data = $this->sql->update_data('faq_tbl', $condition, $up_arr);
            if ($up_data == 1) {
                $result = $this->faq->get_faq_status_byid($id);
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
    public function delete_faq(){
        $res_arr = array();
        $id = $this->input->post('id');
       $result =  $this->sql->update_data('faq_tbl',array('id'=>$id),array('status' => '2'));
       if($result == true){
        $res_arr = array(
                'msg' => 'Delete Faq successfully',
                'status' => 1,
            );
       }else{
        $res_arr = array(
                'msg' => 'something went wrong',
                'status' => 0,
            );
       }
       
       echo json_encode($res_arr);
        exit;
    }
    public function add_faq(){
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        } else {
            if($_POST){
               $question = $this->input->post('question');
               $ans = $this->input->post('ansfaq');
               $this->form_validation->set_rules('question', 'Question', 'required');
               $this->form_validation->set_rules('ansfaq', 'Answer', 'required');
               if($this->form_validation->run() == TRUE){
                $ins = array(
                    'question' => $question,
                    'ans' => $ans,
                    'created' => time(),
                    'status' => "1"

                );
                    $result  = $this->sql->insert_data('faq_tbl',$ins);
                    if($result == 1){
                        redirect('admin/faq_view');
                    }
                }

            }

             $data['active_link'] = 'Add Faq';
            $data['content'] = $this->load->view('add_faq', $data, true);
            load_admin_template($data);
        }
    }
}
