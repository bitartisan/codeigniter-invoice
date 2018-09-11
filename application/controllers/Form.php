<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

    function save_invoice() {

        $form = $this->input->post();
        $this->load->model('invoice');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('invoice_no', '<strong>Invoice Name</strong>', 'required');
        $this->form_validation->set_rules('invoice_date', '<strong>Invoice Date</strong>', 'required');
        $this->form_validation->set_rules('invoice_line[service_id][]', '<strong>Service</strong>', 'required|greater_than[0]');
        $this->form_validation->set_rules('invoice_line[price][]', '<strong>Price</strong>', 'required');

        if ($this->form_validation->run() != false)
        {
            $invoice = [
                'invoice_id'   => $form['invoice_id'],
                'invoice_no'   => $form['invoice_no'],
                'invoice_date' => date('Y-m-d', strtotime($form['invoice_date'])),
                'contract_id'  => $form['contract_id'],
            ];

            $invoice_line = [];

            for ($i = 0; $i < count($form['invoice_line']['price']); $i++) {
                $invoice_line[] = [
                    'invoice_id' => $invoice['invoice_id'],
                    'invoice_line_id' => $form['invoice_line']['invoice_line_id'][$i],
                    'service_id' => $form['invoice_line']['service_id'][$i],
                    'qty' => $form['invoice_line']['qty'][$i],
                    'price' => $form['invoice_line']['price'][$i],
                ];
            }

            $data = [
                'invoice' => $invoice,
                'invoice_line' => $invoice_line,
                'contract' => [
                    'contract_id' => $form['contract_id'],
                    'client_id'   => $form['client_id'],
                    'provider_id' => $form['provider_id'],
                ]
            ];

            $save = $this->invoice->save_invoice($data);
        } else {
            $save = [
                'insert_id' => ($form['invoice_id'] ? $form['invoice_id'] : -1),
                'type' => 'alert-danger',
                'message' => '<strong>Error:</strong>' . validation_errors()
            ];
        }

        $this->alert->set($save['type'], $save['message']);
        redirect('home?' . $this->invoice->get_url_request($form['client_id'], $form['contract_id'],  $save['insert_id']) , 'location', 301);
        die();
    }

    function delete_invoice() {

        $data = [
            'invoice_id'  => $this->input->get('invoice_id', true),
            'client_id'   => $this->input->get('client_id', true),
            'contract_id' => $this->input->get('contract_id', true),
        ];

        $this->load->model('invoice');
        $success = $this->invoice->delete_invoice($data);

        $this->alert->set($success['type'], $success['message']);
        redirect('home?' . $this->invoice->get_url_request($data['client_id'], $data['contract_id']) , 'location', 301);
        die();
    }

    function delete_invoice_line() {

        $data = [
            'invoice_id'  => $this->input->get('invoice_id', true),
            'client_id'   => $this->input->get('client_id', true),
            'contract_id' => $this->input->get('contract_id', true),
            'invoice_line_id' => $this->input->get('invoice_line_id', true),
        ];

        $this->load->model('invoice');
        $success = $this->invoice->delete_invoice_line($data);

        $this->alert->set($success['type'], $success['message']);
        redirect('home?' . $this->invoice->get_url_request($data['client_id'], $data['contract_id'], $data['invoice_id']) , 'location', 301);
        die();
    }
}
