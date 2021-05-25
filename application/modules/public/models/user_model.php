<?php
/**
 * Description of crud
 *
 * @author abc
 */
class user_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_user_by_email($email)
    {
        $sql = "SELECT meb.*,mst.master_id,mst.role_id
        FROM members as meb
            LEFT JOIN master_role as mst on mst.master_id = meb.id
            WHERE meb.email_id = '" . $email . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return (array)$query->row();
        } else {
            return 0;
        }
    }
    public function get_userdata_byid($u_id)
    {
        $sql = "SELECT * FROM members WHERE id = " . $u_id . "";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return (array)$query->row();
        } else {
            return 0;
        }
    }
    public function check_unique_email($email){
        $sql = "SELECT id,email_id FROM members WHERE email_id = '" . $email . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function get_current_userdata($user_id)
    {
        $sql = "SELECT meb.*
                    FROM members as meb
                    WHERE meb.id = ".$user_id."";
        $query = $this->db->query($sql);
        if($query->num_rows() == 1)
        {
            return (array) $query->row();
        }else{
            return 0;
        }
    }
    public function email_is_unique($id)
    {
        $sql = "SELECT email_id FROM members WHERE id='".$id."'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            $result =$query->row();
            return $result->email_id;
        } else {
            return false;
        }
    }
        //forgot pass
    public function get_forgot_client_info($email_id)
    {
        $qry = "SELECT meb.*
                        FROM members as meb
                        LEFT JOIN master_role as mst on mst.master_id = meb.id
                        WHERE meb.email_id = '" . $email_id . "'"; //User Role
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
        $type = 2;
        $qry = "SELECT meb.*
                        FROM members as meb
                        LEFT JOIN master_role as mst on mst.master_id = meb.id
                            WHERE meb.forgot_code ='" . $deript_fcode . "' AND meb.id='" . $deript_uid . "' ";
        $data = $this->db->query($qry);
        if ($data->num_rows() > 0) {
            //return 1;
            return $data->result_array();
        } else {
            return 0;
        }
    }
   public function check_user_old_pass() {
        $res = $this->session->userdata('user_logged_in');
        $sql = "SELECT * FROM `members` where id= '" . $res['id'] . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return (array) $query->row();
        } else {
            return 0;
        }
    }
   public function get_fb_credential(){
       $sql = "SELECT * FROM socialmedial_setting WHERE type = 1 AND status = 1";
       $query = $this->db->query($sql);
       if($query->num_rows() == 1)
       {
           return (array) $query->row();
       }else{
           return 0;
       }
   }
   public function get_google_credential(){
       $sql = "SELECT * FROM socialmedial_setting WHERE type = 2 AND status = 1";
       $query = $this->db->query($sql);
       if($query->num_rows() == 1)
       {
           return (array) $query->row();
       }else{
           return 0;
       }
   }
}