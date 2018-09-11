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
        $this->db->order_by("service_name", "ASC");
        $this->db->select("service_id, service_name");
        $query = $this->db->get("service");

        $data = [
            '-1' => '-- Select Service --',
        ];
        foreach ($query->result_array() as $row) {
            $data[$row['service_id']] = $row['service_name'];
        }

        return $data;
    }
}
