<?php
class Contract extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_contract_by_id($contract_id)
    {
        $query = $this->db->get_where('CONTRACT', array('contract_id' => $contract_id));

        return $query->row_array();
    }

    public function get_contract($client_id = FALSE, $provider_id=1, $status='enabled')
    {
        if ($client_id === FALSE)
        {
            $this->db->order_by("contract_date", "DESC");
            $query = $this->db->get("CONTRACT");
            return $query->result_array();
        }

        $this->db->order_by("contract_date", "DESC");
        $this->db->select("contract_id, contract_no, contract_date");
        $query = $this->db->get_where('CONTRACT', array(
                                            'client_id' => $client_id,
                                            'provider_id' => $provider_id,
                                            'status' => $status)
                                    );

        $data = [
            '-1' => '-- Select Contract --',
        ];
        foreach ($query->result_array() as $row) {
            $data[$row['contract_id']] = '#' . $row['contract_no'] . ' / ' . date($this->config->item('date_format'), strtotime($row['contract_date']));
        }

        return $data;
    }
}
