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
            $query = $this->db->get_where('INVOICE', array('contract_id' => $contract_id));
            return $query->result_array();
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

    public function generate_empty_line($contract_id, $invoice_id, $provider_id=1) {

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

    public function save_invoice($data) {

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

            $this->alert->set('alert-success', '<strong>Success:</strong> invoice has been successfully saved');

        } catch(Exception $e) {
            $this->alert->set('alert-danger', '<strong>Error:</strong> ' . $e->getMessage());
        }

        redirect('home?' . $this->get_url_request($data['contract']['client_id'], $data['contract']['contract_id'], $invoice_id) , 'location', 301);
    }

    public function delete_invoice($data) {

        try {
            $this->db->delete('invoice', array('invoice_id' =>  $data['invoice_id']));
            $this->db->delete('invoice_line', array('invoice_id' => $data['invoice_id']));

            $this->alert->set('alert-success', '<strong>Success:</strong> invoice has been successfully deleted');
        } catch(Exception $e) {
            $this->alert->set('alert-danger', '<strong>Error:</strong> ' . $e->getMessage());
        }

        redirect('home?' . $this->get_url_request($data['client_id'], $data['contract_id']) , 'location', 301);
    }

    public function delete_invoice_line($data) {

        try {
            $this->db->delete('invoice_line', array('invoice_line_id' => $data['invoice_line_id']));

            $this->alert->set('alert-success', '<strong>Success:</strong> invoice line has been successfully deleted');
        } catch(Exception $e) {
            $this->alert->set('alert-danger', '<strong>Error:</strong> ' . $e->getMessage());
        }

        redirect('home?' . $this->get_url_request($data['client_id'], $data['contract_id'], $data['invoice_id']) , 'location', 301);
    }

    public function get_url_request($client_id="", $contract_id="", $invoice_id="") {

        $url = '';
        $sep = '&';
        if ($this->input->get('client_id') || $client_id != "") {
            $url .= 'client_id=' . ($this->input->get('client_id', true) == null ? $client_id : $this->input->get('client_id'));
        }
        if ($this->input->get('contract_id') || $contract_id != "") {
            if ($url != "") {
                $url .= $sep;
            }
            $url .= 'contract_id=' . ($this->input->get('contract_id', true) == null ? $contract_id : $this->input->get('contract_id'));
        }
        if ($this->input->get('invoice_id') || $invoice_id != "") {
            if ($url != "") {
                $url .= $sep;
            }
            $url .= 'invoice_id=' . ($this->input->get('invoice_id', true) == null ? $invoice_id : $this->input->get('invoice_id'));
        }

        return $url;
    }
}
