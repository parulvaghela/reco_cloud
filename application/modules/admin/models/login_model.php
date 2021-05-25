<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    //Login
    public function check_login($username, $password)
    {
        $role_id = 1;
        $sql = "SELECT meb.*,mst.members_id,mst.role_id
                    FROM members as meb
                        LEFT JOIN master_user_role as mst on mst.members_id = meb.id
                        WHERE meb.email = '" . $username . "' AND meb.password = '" . $password . "' AND mst.role_id = ".$role_id."";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return (array)$query->row();
        } else {
            return 0;
        }
    } 
}
