<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function index() {
        $data['title'] = 'Dashboard';
        $data['stats'] = $this->Dashboard_model->get_statistics();
        $this->load->view('dashboard/index', $data);
    }
}