<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'u_model');
    }
    public function user_view()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        } else {
            $resp = array();
            $data['content'] = $this->load->view('user_list', $resp, true);
            load_admin_template($data);
        }
    }
    public function user_list_view() {
        $this->u_model->user_list_ajax();
    }
    public function user_add(){
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        } else if ($this->session->userdata('user_logged_in')) {
            redirect('user/dashboard');
        } else {
            if($_POST){
                 $urole = $this->input->post('urole');
                 $ufirst_name = $this->input->post('ufirst_name');
                 $ulast_name = $this->input->post('ulast_name');
                 $umobile = $this->input->post('umobile');
                 $uemail = $this->input->post('uemail');
                 $ustatus = $this->input->post('ustatus');
                 $upassword = $this->input->post('upassword');
                 $ugender = $this->input->post('ugender');
                 $udob = $this->input->post('udob');
                 $permission = json_encode($this->input->post('permission'));
                $this->form_validation->set_rules('urole', 'Role', 'required');
                $this->form_validation->set_rules('ufirst_name', 'First Name', 'required');
                $this->form_validation->set_rules('ulast_name', 'Last Name', 'required');
                $this->form_validation->set_rules('umobile', 'Mobile', 'required');
                $this->form_validation->set_rules('uemail', 'Email', 'required|is_unique[members.email]');
                $this->form_validation->set_rules('ustatus', 'Status', 'required');
                $this->form_validation->set_rules('upassword', 'Password', 'required');
                $this->form_validation->set_rules('ugender', 'Gender', 'required');
                $this->form_validation->set_rules('udob', 'Date Of Birth', 'required');
                $this->form_validation->set_rules('permission[]', 'Permission', 'required');

                if($this->form_validation->run() == TRUE){
                  if($_FILES['ufile']['name'] != 0){
                   // print_r($_FILES); exit;
                        $dir_name = "profile/";
                        $config['upload_path'] = './uploads/' . $dir_name;
                        $config['allowed_types'] = 'jpg|jpeg|png';
                        $config['max_size'] = '1000'; // max_size in kb
                        $config['file_name'] = $_FILES['ufile']['name'];
                       $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('ufile'))
                        {
                             $data_res = $this->upload->data();
                              $memeber_insert_file_array = array(
                                    'first_name' => $ufirst_name,
                                    'last_name' => $ulast_name,
                                    'mobile' => $umobile,
                                    'email' => $uemail,
                                    'dob' => $udob,
                                    'gender' => $ugender,
                                    'alternate_mobile' => 0,
                                    'password' => key_encrypt($upassword),
                                    'og_password' => $upassword,
                                    'image' => $data_res['file_name'],
                                    'added_date' => time(),
                                    'status' => $ustatus,

                                 );
                                $master_file_id = $this->u_model->insert_query_master('members',$memeber_insert_file_array);
                                 $master_user_rolefile = array(
                                    'members_id' => $master_file_id,
                                    'role_id' => $urole,
                                    'permission' => $permission
                                 );
                                 $result = $this->u_model->insert_query('master_user_role',$master_user_rolefile);
                                 if($result == 1){
                                    redirect('admin/user_view','refresh');
                                 }
                        }
                        else
                        {
                              $error = $this->upload->display_errors();
                              $this->session->set_flashdata('file_error',$error);
                        }

                }
                else{
                     $memeber_insert_array = array(
                    'first_name' => $ufirst_name,
                    'last_name' => $ulast_name,
                    'mobile' => $umobile,
                    'email' => $uemail,
                    'dob' => $udob,
                    'gender' => $ugender,
                    'alternate_mobile' => 0,
                    'password' => key_encrypt($upassword),
                    'og_password' => $upassword,
                    'image' => '',
                    'added_date' => time(),
                    'status' => $ustatus,

                 );
                    $master_id = $this->u_model->insert_query_master('members',$memeber_insert_array);
                     $master_user_role = array(
                        'members_id' => $master_id,
                        'role_id' => $urole,
                        'permission' => $permission
                     );
                     $result = $this->u_model->insert_query('master_user_role',$master_user_role);
                     if($result == 1){
                        redirect('admin/user_view','refresh');
                     }

                }









                }
            }
            $resp = array();
             // $resp['parent_permission'] = $this->u_model->get_partent_permission();
             //    foreach($resp['parent_permission'] as $key => $value)
             //    {
             //        $resp['sub_permission'][$value['id']] = $this->u_model->parent_sub_permissions($value['id']);
             //    }
            $resp['role_data'] = $this->u_model->get_role_data(); 
            $data['content'] = $this->load->view('users_add', $resp, true);
            load_admin_template($data);
        }

    }
    public function email_check()
    {
        if (isset($_POST['uemail'])) {
             $email = $this->input->post('uemail');
            $result = $this->u_model->check_unique_email($email);
            if ($result == true) {
                $output = false;
            } else {
                $output = true;
            }
        }
        echo json_encode($output);exit;
    }
    public function user_edit($id){
         if (!$this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }  else {
            if($_POST){
                $e_urole = $this->input->post('e_urole');
                 $e_ufirst_name = $this->input->post('e_ufirst_name');
                 $e_ulast_name = $this->input->post('e_ulast_name');
                 $e_umobile = $this->input->post('e_umobile');
                 $e_uemail = $this->input->post('e_uemail');
                 $e_ustatus = $this->input->post('e_ustatus');
                 $e_upassword = $this->input->post('e_upassword');
                 $e_ugender = $this->input->post('e_ugender');
                 $e_udob = $this->input->post('e_udob');
                 $permission = json_encode($this->input->post('permission'));
                 $org_email = $this->u_model->email_is_unique($id);
                if ($this->input->post('e_uemail') != $org_email) {
                    $is_unique = '|is_unique[members.email]';
                } else {
                    $is_unique = '';
                }
                $this->form_validation->set_rules('e_urole', 'Role', 'required');
                $this->form_validation->set_rules('e_ufirst_name', 'First Name', 'required');
                $this->form_validation->set_rules('e_ulast_name', 'Last Name', 'required');
                $this->form_validation->set_rules('e_umobile', 'Mobile', 'required');
                $this->form_validation->set_rules('e_uemail', 'Email', 'required'.$is_unique.'');
                $this->form_validation->set_rules('e_ustatus', 'Status', 'required');
                $this->form_validation->set_rules('e_upassword', 'Password', 'required');
                $this->form_validation->set_rules('e_ugender', 'Gender', 'required');
                $this->form_validation->set_rules('e_udob', 'Date Of Birth', 'required');
                $this->form_validation->set_rules('permission[]', 'Permission', 'required');

                if($this->form_validation->run() == TRUE){
                    if($_FILES['e_ufile']['name'] != 0){
                   // print_r($_FILES); exit;
                        $dir_name = "profile/";
                        $config['upload_path'] = './uploads/' . $dir_name;
                        $config['allowed_types'] = 'jpg|jpeg|png';
                        $config['max_size'] = '1000'; // max_size in kb
                        $config['file_name'] = $_FILES['e_ufile']['name'];
                       $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if($this->upload->do_upload('e_ufile'))
                        {
                           $unlink_path = $this->u_model->get_member_data($id);
                           //print_r($unlink_path);exit;
                              if($unlink_path['image'] != ""){
                                 unlink('./uploads/' . $dir_name.'/'.$unlink_path['image']);
                             }
                             $e_data_res = $this->upload->data();
                              $memeber_update_file_array = array(
                                    'first_name' => $e_ufirst_name,
                                    'last_name' => $e_ulast_name,
                                    'mobile' => $e_umobile,
                                    'email' => $e_uemail,
                                    'dob' => $e_udob,
                                    'gender' => $e_ugender,
                                    'alternate_mobile' => 0,
                                    'password' => key_encrypt($e_upassword),
                                    'og_password' => $e_upassword,
                                    'image' => $e_data_res['file_name'],
                                    'added_date' => time(),
                                    'status' => $e_ustatus,

                                 );
                                $master_file_eid = $this->u_model->update_users('members',$memeber_update_file_array,array('id'=>$id));
                                 $user_role_id = array(
                                    'members_id' => $id,
                                    'role_id' => $e_urole,
                                    'permission' => $permission
                                 );
                                 $result = $this->u_model->update_users('master_user_role',$user_role_id,array('id'=>$id));
                                 if($result == 1){
                                    redirect('admin/user_view','refresh');
                                 }
                        }
                        else
                        {
                              $error = $this->upload->display_errors();
                              $this->session->set_flashdata('file_error',$error);
                        }

                }else{
                    $memeber_update_file_array = array(
                                    'first_name' => $e_ufirst_name,
                                    'last_name' => $e_ulast_name,
                                    'mobile' => $e_umobile,
                                    'email' => $e_uemail,
                                    'dob' => $e_udob,
                                    'gender' => $e_ugender,
                                    'alternate_mobile' => 0,
                                    'password' => key_encrypt($e_upassword),
                                    'og_password' => $e_upassword,
                                    'image' => '',
                                    'added_date' => time(),
                                    'status' => $e_ustatus,

                                 );
                                $master_file_eid = $this->u_model->update_users('members',$memeber_update_file_array,array('id'=>$id));
                                 $user_role_id = array(
                                    'members_id' => $id,
                                    'role_id' => $e_urole,
                                    'permission' => $permission
                                 );
                                 $result = $this->u_model->update_users('master_user_role',$user_role_id,array('id'=>$id));
                                 if($result == 1){
                                    redirect('admin/user_view','refresh');
                                 }

                }

            }
                 
                }
            $resp = array();
            $resp['member_data'] = $this->u_model->get_member_data($id);
            $resp['role_data'] = $this->u_model->get_role_data(); 
            $resp['parent_permission'] = $this->u_model->get_partent_permission();
                foreach($resp['parent_permission'] as $key => $value)
                {
                    $resp['sub_permission'][$value['id']] = $this->u_model->parent_sub_permissions($value['id']);
                }
            $data['content'] = $this->load->view('users_edit', $resp, true);
            load_admin_template($data);
       
        }

    }
    public function dob_check(){
        if (isset($_POST['e_dob'])) {
              $today = date('Y-m-d');
        if($this->input->post('e_dob') > $today){
             $output = false;
            } else {
                $output = true;
             }
            
        }
        echo json_encode($output);exit;

    }
     public function get_permission_data(){
        $res_arr = array(
            'msg' => 'something went wrong',
            'status' => 0,
        );
        $id = $this->input->post('role_id');
        if($this->session->userdata('logged_in')){
            $login_user_id = $this->session->userdata('logged_in');
            //print_r($login_user_id);          
            $role_id = $login_user_id['role_id'];
            if($role_id == 1){
                $data['all_permissions'] = $this->u_model->get_roll_all_permissions();
                $data['role_data'] = $this->db->get_where('role', array('id' => $id))->result_array();
                //$role_data = $this->db->get_where('role', array('id' => $id))->result_array();
                $data['parent_permission'] = $this->u_model->get_parent_permissions();
                //$parent_permission = $this->admin->get_parent_permissions();
                //echo "<pre>";print_r($data['parent_permission']);die;
                //$parent_sub =array();
                foreach($data['parent_permission'] AS $k => $v){
                    //foreach($parent_permission AS $k => $v) {
                    $data['parent_sub'][$v['id']] = $this->u_model->parent_sub_permissions($v['id']);
                    //$parent_sub[$v['id']] = $this->admin->parent_sub_permissions($v['id']);
                }
                $res_arr = array(
                    'data' => $this->load->view('admin/load_permission', $data,TRUE),
                    'status' => 1,
                );
                
            }else{
               // echo 0;
                $res_arr = array(
                    'msg' => 'something went wrong',
                    'status' => 0,
                );
            }
        }
        else{
           // echo 0;
            $res_arr = array(
            'msg' => 'something went wrong',
            'status' => 0,
        );
        }  
        echo json_encode($res_arr);exit; 
    }
}
