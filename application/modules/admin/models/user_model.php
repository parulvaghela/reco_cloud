<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function user_list_ajax() {
        $aColumns = array('m.id','m.first_name','m.last_name','m.image','m.email','m.status');
        $sLimit = "";
        if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_POST['iDisplayStart']) . ", " . intval($_POST['iDisplayLength']);
        }
        //echo $sLimit; die();
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
            if ($sOrder == "OsRDER BY") {
                $sOrder = "";
            }
        }
        // echo $sOrder; exit;
        $sWhere = "where( m.status = 1";
        if (isset($_POST['sSearch']) && $_POST['sSearch'] != "") {
            $sWhere .= " AND ";
            for ($i = 0; $i < count($aColumns); $i++) {
                if (isset($_POST['bSearchable_' . $i]) && $_POST['bSearchable_' . $i] == "true") {
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $_POST['sSearch'] . "%' OR ";
                }
            }
            $sWhere = substr_replace($sWhere, "", -3);
        }
        $sWhere .= ')';
        
//        echo $sWhere;
//        exit;
        $sQuery = "SELECT m.id,m.first_name,m.last_name,m.image,m.email,m.status FROM members as m LEFT JOIN master_user_role as mr ON m.id = mr.members_id LEFT JOIN role as r ON mr.role_id= r.id 
                    $sWhere
                    $sOrder
                    $sLimit";
        //echo $sQuery; exit;
        $data = $this->db->query($sQuery);
        $rResult = $data->result_array();
//        echo '<pre>';
//        print_r($rResult);
//        exit;
        /* Data set length after filtering */
        $sQuery = "SELECT m.id,m.first_name,m.last_name,m.image,m.email,m.status FROM members as m LEFT JOIN master_user_role as mr ON m.id = mr.members_id LEFT JOIN role as r ON mr.role_id= r.id
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
//        print_r($output);
//        exit();
        $aColumns = array('id', 'first_name', 'last_name', 'profile_pic', 'email', 'status', 'action');
        $j = 0;
        foreach ($rResult as $aRow) {
            $j++;
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'id') {
                    $row[] = $j;
                } else if ($aColumns[$i] == 'first_name') {
                    $first_name = $aRow['first_name'];
                    $row[] = $first_name;
                } else if ($aColumns[$i] == 'last_name') {
                    $last_name = $aRow['last_name'];
                    $row[] = $last_name;
                } else if ($aColumns[$i] == 'profile_pic') {
                    $profile_pic = '<img src=' . base_url() . 'uploads/profile/' . $aRow['image'] . ' style="height:50px;width:50px;">';
                    $row[] = $profile_pic;
                } else if ($aColumns[$i] == 'email') {
                    $email_id = $aRow['email'];
                    $row[] = $email_id;
                } else if ($aColumns[$i] == 'status') {
                    $status = $aRow['status'];
                    if ($status == 1) {
                        $html = 'Active';
                    } else {
                        $html = 'Deactive';
                    }
                    $row[] = $html;
                } else if ($aColumns[$i] == 'action') {
                    //$html = '<button  class="show_transaction" ><i class="fas fa-edit" ></i></button> ';
                    $html = '<a href=' . BASE_URL . 'admin/user_edit/' . $aRow['id'] . ' style="cursor: pointer;"><i class="fas fa-edit">edit</i></a> ';
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
    public   function   get_role_data(){
       $sql = "select * from role where status = 1";
        $query = $this->db->query($sql);
        if($query->num_rows() != 0)
        {
            return $query->result_array();
        }
        else{
            return 0;
        }


    }
    public function check_unique_email($email){
        $sql = "SELECT id,email FROM members WHERE email = '" . $email . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }

    }
    public function insert_query_master($table,$data){
        $result = $this->db->insert($table,$data);
        $id = $this->db->insert_id();
        //print_r($result); exit;
        if($result == TRUE)
        {
             return  $id;
        }
        else{
                return 0;
        }
    }
    public function insert_query($table,$data){
        $result = $this->db->insert($table,$data);
        if($result == TRUE)
        {
             return  1;
        }
        else{
                return 0;
        }
    }
    public function get_member_data($id){
        $sql = "SELECT * FROM `master_user_role` as mr LEFT JOIN members as m ON m.id = mr.members_id
                    where m.id = '".$id."'";
        $query = $this->db->query($sql);
        if($query->num_rows() != 0)
        {
            return (array) $query->row();
        }
        else{
            return 0;
        }

    }
    public function update_users($table,$data,$wh){
        $result = $this->db->update($table,$data,$wh);
        if($result == TRUE){
            return 1;
        }
        else{
            return 0;
        }
    }
     public function email_is_unique($id) {
        $sql = "SELECT email FROM members WHERE id='" . $id . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            $result = $query->row();
            return $result->email;
        } else {
            return false;
        }
    }
      public function get_partent_permission(){
        $sql = "SELECT * FROM permission WHERE parent_status = 'parent' AND status = 1";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }else{
            return 0;
        }
    }
    public function parent_sub_permissions($parent_id){
        $sql = "SELECT * FROM permission WHERE parent_status = ".$parent_id;
        $res = $this->db->query($sql);
        return $res->result_array();
    }
    public function get_roll_all_permissions(){
        $sql = "SELECT * FROM permission WHERE status = 1";
        $res = $this->db->query($sql);
        return $res->result_array();
    }
    public function get_parent_permissions(){
        $sql = "SELECT * FROM permission WHERE parent_status = 'parent' AND status = 1";
        $res = $this->db->query($sql);
        return $res->result_array();
    }
      
}
