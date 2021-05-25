<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function email_is_unique($id) {
        $sql = "SELECT email_id FROM members WHERE id='" . $id . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            $result = $query->row();
            return $result->email_id;
        } else {
            return false;
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
    public function edit_admin_profile_data() {
        $res = $this->session->userdata('logged_in');
        $sql = "SELECT m.*  FROM `master_role` as mr
                            LEFT JOIN members as m ON mr.master_id = m.id 
                            left JOIN role as r on mr.role_id=r.id where r.id=" . $res['role_id'] . " and m.id=" . $res['id'] . "";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return (array) $query->row();
        } else {
            return 0;
        }
    }
    public function get_admin_old_password($member_id, $role_id) {
        $sql = "SELECT r.id as role_id,m.id, m.password  FROM `master_role` as mr
                        LEFT JOIN members as m ON mr.master_id = m.id 
                        left JOIN role as r on mr.role_id=r.id where r.id=" . $role_id . " and m.id=" . $member_id . "";
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
    public function get_user_status_byid($id) {
        $sql = "SELECT id,status FROM members WHERE id = " . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return (array) $query->row();
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

    /************************************************user payment history ********************************** */
    public function user_list_ajax() {
        $aColumns = array('m.id', 'm.first_name', 'm.last_name', 'm.email_id', 'm.status');
        $sLimit = "";
        if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_POST['iDisplayStart']) . ", " . intval($_POST['iDisplayLength']);
        }
        $sOrder = "";
        if (isset($_POST['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_POST['iSortingCols']); $i++) {
                if ($_POST['bSortable_' . intval($_POST['iSortCol_' . $i])] == "true") {
                    $post_data = $_POST;
                    $sOrder .= $aColumns[intval($post_data['iSortCol_' . $i])] . " " . ($post_data['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }
        $sWhere = "";
        if (isset($_POST['sSearch']) && $_POST['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                if (isset($_POST['bSearchable_' . $i]) && $_POST['bSearchable_' . $i] == "true") {
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $_POST['sSearch'] . "%' OR ";
                }
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }
        if (isset($_POST['data_id'])) {
            $data_id = $_POST['data_id'];
            if ($_POST['data_id'] != '') {
                if ($sWhere == '') {
                    $sWhere .= " WHERE r.id !='" . $data_id . "'";
                } else {
                    $sWhere .= " AND r.id !='" . $data_id . "'";
                }
            }
        }
        if (isset($_POST['user_status'])) {
            $user_status = $_POST['user_status'];
            if ($_POST['user_status'] != '') {
                if ($sWhere == '') {
                    $sWhere .= " WHERE m.status ='" . $user_status . "'";
                } else {
                    $sWhere .= " AND m.status ='" . $user_status . "'";
                }
            }
        }
        $sQuery = "SELECT m.id,m.first_name, m.last_name, m.email_id,m.status FROM `master_role` as mr
	                    LEFT JOIN members as m ON mr.master_id = m.id 
	                    left JOIN role as r on mr.role_id=r.id
                    $sWhere
                    $sOrder
                    $sLimit";
        $data = $this->db->query($sQuery);
        $rResult = $data->result_array();
        $sQuery = "SELECT m.id, m.first_name, m.last_name, m.email_id,m.status FROM `master_role` as mr
	                    LEFT JOIN members as m ON mr.master_id = m.id 
	                    left JOIN role as r on mr.role_id=r.id
                    $sWhere";
        $rResultFilterTotal = $this->db->query($sQuery);
        $aResultFilterTotal = $rResultFilterTotal->result_array();
        $iFilteredTotal = count($aResultFilterTotal);
        $iTotal = count($aResultFilterTotal);
        $output = array(
            "sEcho" => intval($_POST['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array(),
        );
        $aColumns = array('Sl.No', 'first_name', 'last_name', 'email_id', 'status', 'action');
        $j = 0;
        foreach ($rResult as $aRow) {
            $j++;
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'Sl.No') {
                    $row[] = $j;
                } else if ($aColumns[$i] == 'first_name') {
                    $first_name = ucfirst($aRow['first_name']);
                    $row[] = $first_name;
                } else if ($aColumns[$i] == 'last_name') {
                    $last_name = ucfirst($aRow['last_name']);
                    $row[] = $last_name;
                } else if ($aColumns[$i] == 'email_id') {
                    $email_id = $aRow['email_id'];
                    $row[] = $email_id;
                } else if ($aColumns[$i] == 'status') {
                    $status = $aRow['status'];
                    if ($status == 1) {
                        $html = 'Active';
                    }else if ($status == 0) {
                        $html = 'Deactive';
                    }else{
                        $html = 'Deleted';
                    }
                    $row[] = $html;
                } else if ($aColumns[$i] == 'action') {
                     if($aRow['status'] == 2)
                     {
                        $html = "Deleted";
                     }else{
                        $html = '<a href=' . BASE_URL . 'admin/user-edit/' . $aRow['id'] . ' style="cursor: pointer;"><i class="fas fa-edit"></i></a> ';
                        $html .= '<a data-id ="'.$aRow['id'].'" class="delete_user" style="cursor: pointer;"><i class="fas fa-trash"></i></a> ';
                        $status = 0;
                        if ($aRow['status'] == 1) {
                            $status = 0;
                            $html .= '<a onclick="status_change(' . $aRow['id'] . ',' . $status . ');" href="javascript:void(0);" title="Active item" style="cursor: pointer;font-size: 20px;"><i class="fa fa-toggle-on"></i></a>';
                        } else {
                            $status = 1;
                            $html .= '<a onclick="status_change(' . $aRow['id'] . ',' . $status . ');" href="javascript:void(0);" title="Active item" style="cursor: pointer;font-size: 20px;"><i class="fa fa-toggle-off"></i></a>';
                        }
                     }
                    $row[] = $html;
                } else {
                    $row[] = ucfirst($aRow[$aColumns[$i]]);
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
        exit;
    }

    public function get_role(){
        $sql = "SELECT * from role WHERE status = 1";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }else{
            return 0;
        }
    }

    public function get_user_profile_data($id) {
        $sql = "SELECT meb.*,mst.role_id
                    FROM members as meb 
                    LEFT JOIN master_role as mst ON meb.id = mst.master_id
                    WHERE meb.id =".$id." AND meb.status != 2";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return (array) $query->row();
        } else {
            return 0;
        }
    }
}
