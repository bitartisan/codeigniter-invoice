<?php
class Invoice extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_invoice($id)
    {
        $query = $this->db->get_where('INVOICE', array('invoice_id' => $id));
        return $query->row_array();
    }

    public function get_invoice_by_contract($contract_id = null)
    {
        if ($contract_id != null) {
            $this->db->order_by("invoice_no", "DESC");
            $this->db->select("invoice_id, invoice_no, invoice_date");
            $query = $this->db->get_where('invoice', array('contract_id' => $contract_id));

            $data = [
                '-1' => '-- New Invoice --',
            ];
            foreach ($query->result_array() as $row) {
                $data[$row['invoice_id']] = '#' . $row['invoice_no'] . ' / ' . date($this->config->item('date_format'), strtotime($row['invoice_date']));
            }

            return $data;
        }

        return [];
    }

    public function get_invoice_lines($invoice_id = null, $add_empty_line=false)
    {
        if ($invoice_id != null) {
            $this->db->order_by("invoice_line_id", "ASC");
            $this->db->select('*');
            $this->db->from('invoice_line');
            $this->db->join('service', 'invoice_line.service_id = service.service_id');
            $this->db->join('invoice', 'invoice_line.invoice_id = invoice.invoice_id');
            $this->db->join('contract', 'invoice.contract_id = contract.contract_id');
            $this->db->where(array('invoice_line.invoice_id' => $invoice_id));
            $query = $this->db->get();

            $return_arr = $query->result_array();

            if(count($return_arr) == 0 || $add_empty_line) {

                // get contract
                $contract_id = $this->input->get('contract_id', true);
                $empty_line  = $this->generate_empty_line($contract_id, $invoice_id);

                array_push($return_arr, $empty_line);
            }

            return $return_arr;
        }

        return [];
    }

    public function get_last_invoice()
    {
        $query = $this->db->query('SELECT invoice_no, invoice_date FROM invoice ORDER BY invoice_id DESC LIMIT 1');
        $result = $query->row_array();

        return $result['invoice_no'] . ' / ' . date($this->config->item('date_format'), strtotime($result['invoice_date']));
    }

    public function generate_empty_line($contract_id, $invoice_id, $provider_id=1)
    {

        // get contract
        $this->load->model('contract');
        $contract_arr = $this->contract->get_contract_by_id($contract_id);

        $empty_line = [
            'invoice_line_id' => -1,
            'invoice_id' => $invoice_id,
            'service_id' => '',
            'qty' => 1,
            'price' => 0,
            'contract_no' => $contract_arr['contract_no'],
            'contract_date' => $contract_arr['contract_date'],
            'provider_id' => $provider_id
        ];

        return $empty_line;
    }

    public function save_invoice($data)
    {

        $invoice_id = $data['invoice']['invoice_id'];
        unset($data['invoice']['invoice_id']);

        try {
            // invoice
            if ($invoice_id > 0) {
                // update
                $this->db->where('invoice_id', $invoice_id);
                $this->db->update('invoice', $data['invoice']);
            } else {
                // insert
                $this->db->insert('invoice', $data['invoice']);
                $invoice_id = $this->db->insert_id(); // get last insert id
            }

            // invoice_line
            foreach ($data['invoice_line'] as $line) {
                $line_id = $line['invoice_line_id'];
                unset($line['invoice_line_id']);

                if ($line_id > 0) {
                    // update
                    $this->db->where('invoice_line_id', $line_id);
                    $this->db->update('invoice_line', $line);
                } else {
                    // insert
                    $line['invoice_id'] = $invoice_id;
                    $this->db->insert('invoice_line', $line);
                }
            }

            $save = [
                'type' => 'alert-success',
                'message' => '<strong>Success:</strong> invoice successfully saved',
                'insert_id' => $invoice_id
            ];

        } catch(Exception $e) {
            $save = [
                'type' => 'alert-danger',
                'message' => '<strong>Error:</strong> ' . $e->getMessage(),
                'insert_id' => -1
            ];
        }

        return $save;
    }

    public function delete_invoice($data)
    {

        try {
            $this->db->delete('invoice', array('invoice_id' =>  $data['invoice_id']));
            $this->db->delete('invoice_line', array('invoice_id' => $data['invoice_id']));
            $success = [
                'type' => 'alert-success',
                'message' => '<strong>Success:</strong> invoice has been successfully deleted'
            ];
        } catch(Exception $e) {
            $success = [
                'type' => 'alert-danger',
                'message' => '<strong>Error:</strong> ' . $e->getMessage()
            ];
        }

        return $success;
    }

    public function delete_invoice_line($data)
    {

        try {
            $this->db->delete('invoice_line', array('invoice_line_id' => $data['invoice_line_id']));
            $success = [
                'type' => 'alert-success',
                'message' => '<strong>Success:</strong> invoice line has been successfully deleted',
            ];
        } catch(Exception $e) {
            $success = [
                'type' => 'alert-danger',
                'message' => '<strong>Error:</strong> ' . $e->getMessage(),
            ];
        }

        return $success;
    }

    public function get_url_request($client_id="", $contract_id="", $invoice_id="")
    {

        $url = '';
        $sep = '&';
        if ($client_id !== false && ($this->input->get('client_id') || $client_id != "")) {
            $url .= 'client_id=' . ($this->input->get('client_id', true) == null ? $client_id : $this->input->get('client_id'));
        }
        if ($contract_id !== false && ($this->input->get('contract_id') || $contract_id != "")) {
            if ($url != "") {
                $url .= $sep;
            }
            $url .= 'contract_id=' . ($this->input->get('contract_id', true) == null ? $contract_id : $this->input->get('contract_id'));
        }
        if ($invoice_id !== false && ($this->input->get('invoice_id') || $invoice_id != "")) {
            if ($url != "") {
                $url .= $sep;
            }
            $url .= 'invoice_id=' . ($this->input->get('invoice_id', true) == null ? $invoice_id : $this->input->get('invoice_id'));
        }

        return $url;
    }
}
