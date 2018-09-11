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
            $query = $this->db->get("CLIENT");
            return $query->result_array();
        }

        $query = $this->db->get_where('CLIENT', array('client_id' => $id));
        return $query->row_array();
    }
}
