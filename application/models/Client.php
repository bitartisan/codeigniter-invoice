<?php
class Client extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_client($id = FALSE)
    {
        if ($id === FALSE)
        {
            $this->db->order_by("client_name", "ASC");
            $this->db->select("client_id, client_name");
            $query = $this->db->get("client");

            $data = [
                '-1' => '-- Select Client --',
            ];
            foreach ($query->result_array() as $row) {
                $data[$row['client_id']] = $row['client_name'];
            }

            return $data;
        }

        $query = $this->db->get_where('CLIENT', array('client_id' => $id));
        return $query->row_array();
    }

    public function get_client_for_table() {

        $this->db->order_by("client_name", "ASC");
        $query = $this->db->get("client");

        $data = [];
        foreach ($query->result_array() as $row) {
            $data[] = [
                '<a href="' . base_url('/') . 'index.php/form/edit_client?client_id=' . $row['client_id'] . '">' . $row['client_name'] . '</a>',
                $row['client_cui'],
                $row['client_orc'],
                $row['client_phone'],
                $row['client_email'],
                $row['client_address'],
                $row['client_bank'],
                $row['client_account'],
                '<div style="width: 80px;"><a class="btn btn-sm btn-success" href="' . base_url('/') . 'index.php/form/edit_client?client_id=' . $row['client_id'] . '"><span class="fas fa-edit"></span></a>' .
                '<a class="btn btn-sm btn-danger mx-2" onclick="return confirm(\'Are you sure you want to delete this record?\');" href="' . base_url('/') . 'index.php/form/delete_client?client_id=' . $row['client_id'] . '"><span class="fas fa-trash"></span></a></div>'
            ];
        }

        return $data;
    }
}
