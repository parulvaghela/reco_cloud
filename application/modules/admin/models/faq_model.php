<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Faq_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function faq_list_ajax() {
        $aColumns = array('id', 'question', 'ans','status');
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
        if(empty($sWhere))
        {
            $sWhere = "WHERE status != 2";
        }else{
            $sWhere .= " AND status != 2";
        }
        if (isset($_POST['faq_status'])) {
            $faq_status = $_POST['faq_status'];
            if ($_POST['faq_status'] != '') {
                if ($sWhere == '') {
                    $sWhere .= " WHERE status ='" . $faq_status . "'";
                } else {
                    $sWhere .= " AND status ='" . $faq_status . "'";
                }
            }
        }
        $sQuery = "SELECT * FROM `faq_tbl`
                    $sWhere
                    $sOrder
                    $sLimit";
        $data = $this->db->query($sQuery);
        $rResult = $data->result_array();
        $sQuery = "SELECT * FROM `faq_tbl`
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
        $aColumns = array('Sl.No', 'question', 'ans','status','action');
        $j = 0;
        foreach ($rResult as $aRow) {
            $j++;
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'Sl.No') {
                    $row[] = $j;
                } else if ($aColumns[$i] == 'question') {
                    $question = ucfirst($aRow['question']);
                    $row[] = $question;
                } else if ($aColumns[$i] == 'ans') {
                    $ans = ucfirst($aRow['ans']);
                    $row[] = $ans;
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
                        $html .= '<a data-id ="'.$aRow['id'].'" class="delete_faq" onclick="delete_faq('.$aRow['id'].')" style="cursor: pointer;"><i class="fas fa-trash">delete</i></a> ';
                        $status = 0;
                        if ($aRow['status'] == 1) {
                            $status = 0;
                            $html .= '<a onclick="faq_status_change(' . $aRow['id'] . ',' . $status . ');" href="javascript:void(0);" title="Active item" style="cursor: pointer;font-size: 20px;"><i class="fa fa-toggle-on"></i></a>';
                        } else {
                            $status = 1;
                            $html .= '<a onclick="faq_status_change(' . $aRow['id'] . ',' . $status . ');" href="javascript:void(0);" title="Active item" style="cursor: pointer;font-size: 20px;"><i class="fa fa-toggle-off"></i></a>';
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
    public function get_faq_status_byid($id) {
        $sql = "SELECT id,status FROM faq_tbl WHERE id = " . $id;
        $query = $this->db->query($sql);
        if ($query->num_rows() == 1) {
            return (array) $query->row();
        } else {
            return 0;
        }
    }
    

    
}
