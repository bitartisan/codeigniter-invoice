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

        $this->load->model('provider');
        $this->load->model('client');
        $this->load->model('contract');
        $this->load->model('invoice');
        $this->load->model('service');

        $data['app'] = [
            'base_url' => base_url('/'),
            'assets' => base_url('assets'),
            'login_info' => $this->google->getUserInfo()->email,
            'client_id' => $this->input->get('client_id', true),
            'contract_id' => $this->input->get('contract_id', true),
            'invoice_id' => $this->input->get('invoice_id', true),
            'invoice' => $this->invoice->get_invoice_by_contract($this->input->get('contract_id', true)),
            'sel_invoice' => $this->invoice->get_invoice($this->input->get('invoice_id', true)),
            'last_invoice' => $this->invoice->get_last_invoice(),
            'provider' => $this->provider->get_provider(1),
            'clients' => $this->client->get_client(false, 'client_name', 'ASC'),
            'client_arr' => $this->client->get_client($this->input->get('client_id', true)),
            'contracts' => $this->contract->get_contract($this->input->get('client_id', true)),
            'services' => $this->service->get_service(),
        ];

        // check if we're adding a new empty invoice line
        $add_empty_line = false;
        if ($this->input->get('add_line')) {
            $add_empty_line = true;
        }
        $data['app']['lines_arr'] = $this->invoice->get_invoice_lines($this->input->get('invoice_id', true), $add_empty_line);

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

            case 'client_form';
                $this->load->library('form_builder');
                $this->form_builder->assign_vars('client', $this->input->get('client_id', true), 'client_id');
                /*
                $this->form_builder->exclude_form_values(
    				array('timestamp', 'lastModifiedBy')
    			);
                */
                $this->form_builder->hide_form_values(
    				array('client_id')
    			);
                $data['app']['client_form'] = $this->form_builder->build_form();

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
