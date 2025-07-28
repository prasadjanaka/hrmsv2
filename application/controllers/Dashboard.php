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
        $data['attendance_trend'] = $this->Dashboard_model->get_attendance_trend();
        $data['department_distribution'] = $this->Dashboard_model->get_department_distribution();
        $data['recent_activities'] = $this->Dashboard_model->get_recent_activities();
        $this->load->view('dashboard/index', $data);
    }
}