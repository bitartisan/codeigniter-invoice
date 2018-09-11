<?php
class Service extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_service_by_id($service_id)
    {
        $query = $this->db->get_where('SERVICE', array('service_id' => $service_id));

        return $query->row_array();
    }

    public function get_service()
    {
        $query = $this->db->get('SERVICE');

        return $query->result_array();
    }
}
