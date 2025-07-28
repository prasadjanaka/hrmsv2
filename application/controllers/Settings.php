<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_auth = true;
        $this->allowed_roles = array('admin'); // Only admin can access settings
    }

    public function index() {
        $data['title'] = 'Settings';
        $this->load->view('settings/index', $data);
    }
}