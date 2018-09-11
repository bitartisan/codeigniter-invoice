<?php
class Provider extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_provider($id = FALSE)
    {
        if ($id === FALSE)
        {
                $query = $this->db->get("PROVIDER");
                return $query->result_array();
        }

        $query = $this->db->get_where('PROVIDER', array('provider_id' => $id));
        return $query->row_array();
    }
}
