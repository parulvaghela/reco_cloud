<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Setting_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function email_setting_data()
    {
        $sql = "SELECT * FROM email_settings WHERE status = 1";
        $query = $this->db->query($sql);
        if($query->num_rows() == 1)
        {
            return (array) $query->row();
        }else{
            return 0;
        }
    }

    //forgot pass
    public function get_forgot_client_info($email_id)
    {
        $role_id = 1;
        $qry = "SELECT meb.*,mst.forgot_code
                        FROM members as meb
                        LEFT JOIN master_user_role as mst on mst.members_id = meb.id
                        WHERE meb.email = '" . $email_id . "' AND mst.role_id = ".$role_id.""; //Admin Role
        $data = $this->db->query($qry);
        if ($data->num_rows() > 0) {
            //return 1;
            return $data->result_array();
        } else {
            return 0;
        }
    }
    public function check_forgot_code_uid($deript_fcode, $deript_uid)
    {
       $role_id = 1;
        $qry = "SELECT meb.*,mst.forgot_code
                        FROM members as meb
                        LEFT JOIN master_user_role as mst on mst.members_id = meb.id
                            WHERE mst.forgot_code ='" . $deript_fcode . "' AND meb.id='" . $deript_uid . "' AND mst.role_id = ".$role_id."";
        $data = $this->db->query($qry);
        if ($data->num_rows() > 0) {
            //return 1;
            return $data->result_array();
        } else {
            return 0;
        }
    }

    public function get_admin_old_password($member_id, $role_id) {
        $sql = "SELECT meb.*,mst.forgot_code
                FROM members as meb
                LEFT JOIN master_user_role as mst on mst.members_id = meb.id
                WHERE meb.id = '" . $member_id . "' AND mst.role_id = ".$role_id."";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return (array) $query->row();
        } else {
            return 0;
        }
    }
    public function check_admin_old_pass() {
        $res = $this->session->userdata('logged_in');
        $sql = "SELECT * FROM `members` where id= '" . $res['id'] . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return (array) $query->row();
        } else {
            return 0;
        }
    }

}