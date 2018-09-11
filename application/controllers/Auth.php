<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public $loggedin = 0;

    public function login() {
        $this->load->library('google');

        $data['app'] = [
            'base_url' => base_url('/'),
            'assets' => base_url('assets'),
            'loginurl' => $this->google->getLoginUrl()
        ];

        $data['title'] = 'Home';
        $this->load->view('templates/header', $data);
        $this->load->view('pages/login', $data);
        $this->load->view('templates/footer', $data);
    }

    public function logout() {
        $this->load->library('google');
        $this->google->logout();
        $this->session->unset_userdata('pfainvoice_loggedin');
        redirect('home', 'location', 301);
        die();
    }

    public function oauth2callback() {
        $login = false;
        $this->load->library('google');
        $this->google->setAccessToken($_GET['code']);
        $this->load->model('user');
        foreach ($this->user->get_user() as $user) {
            if ($user['email'] == $this->google->getUserInfo()->email) {
                $login = true;
                $this->load->library('session');
                $this->session->set_userdata('pfainvoice_loggedin', $login);
                break;
            }
        }

        redirect('home', 'location', 301);
        die();
    }
}
