<?php



/**

 * Description of crud

 *

 * @author abc

 */

class sql_model extends CI_Model

{



    public function __construct()

    {

        parent::__construct();

    }

    public function last_insert_id($tbl, $data)

    {

        $this->db->insert($tbl, $data);

        return $this->db->insert_id();

    }

    public function insert_data($tbl, $data)

    {

        return $this->db->insert($tbl, $data);

    }

    public function update_data($tbl, $condition, $data)

    { //table_name,condition,data

        return $this->db->where($condition)->update($tbl, $data);

    }

    public function delete_data($tbl, $condition)

    {

        return $this->db->where($condition)->delete($tbl);

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

}