<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');	

	//User Permission
    function load_package_permission($permission_code) {
		$ci =& get_instance();
	
		$login_user_data = $ci->session->userdata('logged_in');
		if($ci->session->userdata('user_logged_in') && !$ci->session->userdata('logged_in')) {
			$login_user_data = $ci->session->userdata('user_logged_in');
		}
		$user_id = $login_user_data['id'];
				
		//get data from database
		$query = $ci->db->get_where('master_role',array('master_id'=>$user_id));
		if($query->num_rows() > 0){
			$result = $query->row_array();
			if($result['status'] == 1){
				$permission_array = (array) json_decode($result['plan_permission']);								
				$permission_sql = $ci->db->get_where('permission', array('code_name' => $permission_code));
				if($permission_sql->num_rows() > 0) {					
					$permission_data = $permission_sql->row_array();					
					if(in_array($permission_data['id'], $permission_array)) {
						return true; 
					}
					else {
						return false; 
					}					
				} 
				else {		
					return false;
				}
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
    }
?>