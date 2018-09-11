<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public $loggedin = 0;

    public function view($page = 'home') {

        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php')) {
            show_404();
        }

        $this->loggedin = $this->session->userdata('pfainvoice_loggedin');
        if (! $this->loggedin) {
            redirect('auth/login', 'location', 301);
            die();
        }

        $data['app'] = [
            'base_url' => base_url('/'),
            'assets' => base_url('assets'),
            'login_info' => $this->google->getUserInfo()->email,
            'client_id' => $this->input->get('client_id', true),
            'contract_id' => $this->input->get('contract_id', true),
            'invoice_id' => $this->input->get('invoice_id', true)
        ];

        $this->load->model('provider');
        $this->load->model('client');
        $this->load->model('contract');
        $this->load->model('invoice');
        $this->load->model('service');

        switch($page) {
            case 'client';
                $this->load->library('table');
                $this->table->set_heading('Client Name', 'CUI', 'ORC', 'Phone #', 'Email', 'Address', 'Bank', 'Account', 'Action');
                $template = array(
                    'table_open' => '<table class="table table-bordered table-lookup">',
                );

                $this->table->set_template($template);
                $data['app']['client'] = $this->client->get_client_for_table();
            break;

            case 'print':
                $this->load->helper('pdf');
                $invoice = $this->invoice->get_invoice($data['app']['invoice_id']);
                $lines = $this->invoice->get_invoice_lines($data['app']['invoice_id']);
                $contract = $this->contract->get_contract_by_id($invoice['contract_id']);
                $client = $this->client->get_client($contract['client_id']);
                $provider = $this->provider->get_provider($contract['provider_id']);

                $data['app']['data'] = [
                    'invoice' => $invoice,
                    'lines' => $lines,
                    'contract' => $contract,
                    'client' => $client,
                    'provider' => $provider,
                ];

                $this->load->view('pages/print', $data);
                return true;
            break;
        }

        $data['title'] = ucfirst($page);
        $this->load->view('templates/header', $data);
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }
}
