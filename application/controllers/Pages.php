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
            'client_id' => $this->input->get('client_id', TRUE),
            'contract_id' => $this->input->get('contract_id', TRUE),
            'invoice_id' => $this->input->get('invoice_id', TRUE)
        ];

        $this->load->model('app');
        $this->load->model('provider');
        $this->load->model('client');
        $this->load->model('contract');
        $this->load->model('invoice');
        $this->load->model('service');

        if ($page == 'print') {
            $this->load->view('pages/' . $page, $data);
        } else {
            $data['title'] = ucfirst($page);
            $this->load->view('templates/header', $data);
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer', $data);
        }
    }
}
