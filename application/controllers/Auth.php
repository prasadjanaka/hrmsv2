<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

    /**
     * Login page & processing
     */
    public function login() {
        // Redirect if already logged in
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data = array('title' => 'Login');

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() === TRUE) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $user = $this->User_model->authenticate($username, $password);
                if ($user) {
                    $this->session->set_userdata(array(
                        'user_id'   => $user->id,
                        'username'  => $user->username,
                        'role'      => $user->role,
                        'logged_in' => TRUE
                    ));
                    // Redirect to dashboard or originally requested page
                    $redirect = $this->session->flashdata('redirect_after_login');
                    redirect($redirect ? $redirect : 'dashboard');
                } else {
                    $data['error'] = '<div class="alert alert-danger">Invalid username or password.</div>';
                }
            } else {
                $data['error'] = validation_errors('<div class="alert alert-danger">', '</div>');
            }
        }

        $this->load->view('auth/login', $data);
    }

    /**
     * Destroy session and logout
     */
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    /**
     * Placeholder for forgot/reset password flow
     */
    public function reset_password() {
        $data = array('title' => 'Reset Password');
        $this->load->view('auth/reset_password', $data);
    }

    /**
     * Change logged-in user password
     */
    public function change_password() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data = array('title' => 'Change Password');

        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('current_password', 'Current Password', 'required');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

            if ($this->form_validation->run() === TRUE) {
                $user_id = $this->session->userdata('user_id');
                $current_pass = $this->input->post('current_password');
                $new_pass = $this->input->post('new_password');

                // Verify current password
                $user = $this->User_model->authenticate($this->session->userdata('username'), $current_pass);
                if ($user) {
                    $this->User_model->update_password($user_id, $new_pass);
                    $data['success'] = '<div class="alert alert-success">Password changed successfully.</div>';
                } else {
                    $data['error'] = '<div class="alert alert-danger">Current password is incorrect.</div>';
                }
            } else {
                $data['error'] = validation_errors('<div class="alert alert-danger">', '</div>');
            }
        }

        $this->load->view('auth/change_password', $data);
    }
}