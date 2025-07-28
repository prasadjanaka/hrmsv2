<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_statistics() {
        $stats = array();
        // Total employees
        $stats['total_employees'] = $this->db->count_all('employees');
        // Total departments
        $stats['total_departments'] = $this->db->count_all('departments');
        // Present today (attendance records where date = today and status present)
        $today = date('Y-m-d');
        $this->db->where('date', $today);
        $this->db->where('status', 'present');
        $stats['present_today'] = $this->db->count_all_results('attendances');
        // Employees on leave today (leaves where today between start_date and end_date and status approved)
        $this->db->where('status', 'approved');
        $this->db->where('start_date <=', $today);
        $this->db->where('end_date >=', $today);
        $stats['on_leave_today'] = $this->db->count_all_results('leaves');
        return $stats;
    }
}