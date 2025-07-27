<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $data = array();
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->User_model->authenticate($username, $password);
            if ($user) {
                $this->session->set_userdata(array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'logged_in' => TRUE
                ));
                redirect('dashboard');
            } else {
                $data['error'] = 'Invalid username or password.';
            }
        }
        $this->load->view('auth/login', $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    public function reset_password() {
        // Placeholder for password reset logic
        $this->load->view('auth/reset_password');
    }
}