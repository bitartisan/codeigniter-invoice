<?php
class App extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_last_invoice()
    {
        $query = $this->db->query('SELECT invoice_no, invoice_date FROM invoice ORDER BY invoice_id DESC LIMIT 1');
        $result = $query->row_array();

        return $result['invoice_no'] . ' / ' . date($this->config->item('date_format'), strtotime($result['invoice_date']));
    }
}
