<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('admin_model', 'admin');
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
    public function manage_profile() {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        } else {
            $data = array();
            $where_id = $this->session->userdata('logged_in');
            if ($_POST) {
                $id = $this->session->userdata('logged_in')['id'];
                $email = $this->input->post('edit_email');
                $org_email = $this->admin->email_is_unique($id);
                if ($this->input->post('edit_email') != $org_email) {
                    $is_unique = '|is_unique[members.email_id]';
                } else {
                    $is_unique = '';
                }
                $this->form_validation->set_rules('efirst_name', 'First Name', 'trim|required');
                $this->form_validation->set_rules('elast_name', 'Last Name', 'trim|required');
                $this->form_validation->set_rules('edit_email', 'Email', 'trim|required' . $is_unique);
                $this->form_validation->set_rules('ephone', 'Password', 'trim|required');
                if ($this->form_validation->run() == TRUE) {
                    if (strlen($_FILES['edit_profile_pic']['name']) != 0) {
                        $dir_name = "profile/";
                        $config['upload_path'] = './uploads/' . $dir_name;
                        $config['allowed_types'] = 'jpg|jpeg|png';
                        $config['max_size'] = '500'; // max_size in kb
                        $config['file_name'] = $_FILES['edit_profile_pic']['name'];
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('edit_profile_pic')) {
                            $this->session->set_flashdata('reg_error', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
                            redirect('manage_profile');
                        } else {
                            $img_path = $this->admin->edit_admin_profile_data();
                            $path = "./uploads/profile/" . $img_path['profile_pic'];
                            if ($img_path['profile_pic'] != "") {
                                unlink($path);
                            }
                            $image_data = $this->upload->data();
                            $update_data = array(
                                'first_name' => $this->input->post('efirst_name'),
                                'last_name' => $this->input->post('elast_name'),
                                'email_id' => $this->input->post('edit_email'),
                                'phone_no' => $this->input->post('ephone'),
                                'profile_pic' => $image_data['file_name']
                            );
                            $update_success = $this->sql->update_data('members', array('id' => $where_id['id']), $update_data);
                            if ($update_success == 1) {
                                $this->session->set_flashdata('edit_success', '<div class="alert alert-success">Edit Profile Successfully</div>');
                                redirect('admin/manage_profile');
                            }
                        }
                    } else {
                        $update_data = array(
                            'first_name' => $this->input->post('efirst_name'),
                            'last_name' => $this->input->post('elast_name'),
                            'email_id' => $this->input->post('edit_email'),
                            'phone_no' => $this->input->post('ephone'),
                            'profile_pic' => $this->input->post('image_hidden')
                        );
                        $update_success = $this->sql->update_data('members', array('id' => $where_id['id']), $update_data);
                        if ($update_success == 1) {
                            $this->session->set_flashdata('edit_success', '<div class="alert alert-success">Edit Profile Successfully </div>');
                            redirect('admin/manage_profile');
                        }
                    }
                }
            }
            $data['edit_data'] = $this->admin->edit_admin_profile_data();
            $data['active_link'] = 'settings';
            $data['content'] = $this->load->view('manage_profile', $data, true);
            load_admin_template($data);
        }
    }
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
                    $data = $this->admin->get_admin_old_password($get_admin['id'], $get_admin['role_id']);
                    if ($data['password'] == md5($oldpassword)) {
                        $upadate_pass = $this->sql->update_data('members', array('id' => $data['id']), array('password' => md5($newpassword)));
                        if ($upadate_pass == 1) {
                            redirect('logout');
                        }
                    } else {
                        $this->session->set_flashdata('old_password_error', '<span class="errors">Old password can not be same</span>');
                        redirect('admin/change_password', 'refresh');
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
        $data = $this->admin->check_admin_old_pass();
        if ($data['password'] != $old_password) {
            $output = false;
        } else {
            $output = true;
        }
        echo json_encode($output);
        exit;
    }

    public function user_add()
    {
        if ($this->session->userdata('logged_in')) {
            if($_POST){
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
                        $this->session->set_flashdata('user_error', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
                        redirect('admin/user-add');exit;
                    }else{
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
                            'status' => 1,
                            'added_by' => $this->session->userdata('logged_in')['id']
                        );
                        $user_ins = $this->sql->last_insert_id('members', $register_user);
                        if ($user_ins != 0) {
                            $role_ins = array(
                                'master_id' => $user_ins,
                                'role_id' => $this->input->post('user_type'),
                                'status' => 1,
                            );
                            $this->sql->insert_data('master_role', $role_ins);
                            $this->session->set_flashdata('user_error', '<div class="alert alert-success">register success</div>');
                            redirect('admin/user-add');
                        }
                    }
                }
            }
            $data = array();
            $data['role_id'] = $this->session->userdata('logged_in')['role_id'];
            $data['active_link'] = 'user_list';
            $data['role_list'] = $this->admin->get_role();
            $data['content'] = $this->load->view('user_add', $data, true);
            load_admin_template($data);
        }else{
            redirect('admin/login');
        }
    }

    public function user_edit($id){
        if ($this->session->userdata('logged_in')) {
            if ($_POST) {
                $email = $this->input->post('email');
                $org_email = $this->admin->email_is_unique($id);
                if ($this->input->post('email') != $org_email) {
                    $is_unique = '|is_unique[members.email_id]';
                } else {
                    $is_unique = '';
                }
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
                $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email'.$is_unique);
                if ($this->form_validation->run() == true) {
                    if ($_FILES['profile_pic']['name'] != "") {
                        // Set preference
                        $dir_name = "profile/";
                        $config['upload_path'] = './uploads/' . $dir_name;
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
                        $config['max_size'] = '500'; // max_size in kb
                        $config['file_name'] = $_FILES['profile_pic']['name'];
                        //Load upload library
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('profile_pic')) {
                            $this->session->set_flashdata('user_error', '<div class="alert alert-danger">' . $this->upload->display_errors() . '</div>');
                            redirect('admin/user-edit/'.$id);exit;
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
                    $up_user = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'phone_no' => $this->input->post('phone_no'),
                        'email_id' => $this->input->post('email'),
                        'profile_pic' => $image_name,
                        'status' => $this->input->post('status')
                    );
                    $condition = array('id' => $id);
                    $up_img = $this->sql->update_data('members', $condition, $up_user);
                    $up_mst = array('role_id' => $this->input->post('user_type'));
                    $master_condition = array('master_id' => $id);
                    $this->sql->update_data('master_role', $master_condition, $up_mst);
                    $this->session->set_flashdata('user_error', '<div class="alert alert-success">User Update Successfully</div>');
                    redirect('admin/user-edit/'.$id);
                }
            }
            $data = array();
            $data['role_id'] = $this->session->userdata('logged_in')['role_id'];
            $data['edit_id'] = $id;
            $data['active_link'] = 'user_list';
            $data['user_data'] = $this->admin->get_user_profile_data($id);
            $data['role_list'] = $this->admin->get_role();
            $data['content'] = $this->load->view('user_edit', $data, true);
            load_admin_template($data);
        } else {
            redirect('admin/login');
        }

    }
    public function user_list() {
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        } else {
            $data = array();
            $data['role_id'] = $this->session->userdata('logged_in')['role_id'];
            $data['active_link'] = 'user_list';
            $data['content'] = $this->load->view('user_list', $data, true);
            load_admin_template($data);
        }
    }
    public function user_list_view() {
        $this->admin->user_list_ajax();
    }

    public function user_delete(){
        $res_arr = array(
            'msg' => 'something went wrong',
            'status' => false,
        );
        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'delete_data') {
                $id = $this->input->post('id');
                $status = 2;
                $up_member = array('status' => $status);
                $condition = array("id" => $id);
                $this->sql->update_data('members', $condition, $up_member);
                $up_master = array('status' => $status);
                $master_condition = array("master_id" => $id);
                $this->sql->update_data('master_role', $master_condition, $up_master);
                $res_arr = array(
                    'msg' => 'Delete User successfully',
                    'status' => true,
                );
            } else {
                $res_arr = array(
                    'msg' => 'Data Not Deleted',
                    'status' => false,
                );
            }
        }else{
            $res_arr = array(
                    'msg' => 'Data Not Deleted',
                    'status' => false,
                );
        }
        echo json_encode($res_arr);
        exit;
    }
    public function deactive_user() {
        $res_arr = array();
        $status = $this->input->post('status');
        $id = $this->input->post('id');
        if (isset($id) && !empty($id) && isset($status)) {
            $condition = array('id' => $id);
            $up_arr = array('status' => $status);
            $up_data = $this->sql->update_data('members', $condition, $up_arr);
            if ($up_data == 1) {
                $result = $this->admin->get_user_status_byid($id);
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

    public function email_check()
    {
        if (isset($_POST['email'])) {
            $email = $this->input->post('email');
            $result = $this->admin->check_unique_email($email);
            if ($result == true) {
                $output = false;
            } else {
                $output = true;
            }
        }
        echo json_encode($output);exit;
    }
}
