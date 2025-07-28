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

    public function get_attendance_trend($days = 7) {
        $start_date = date('Y-m-d', strtotime('-'.($days-1).' days'));
        $this->db->select('date, COUNT(*) as cnt');
        $this->db->from('attendances');
        $this->db->where('status', 'present');
        $this->db->where('date >=', $start_date);
        $this->db->group_by('date');
        $query = $this->db->get();
        $result = $query->result();

        // Build array with all dates to ensure zeros
        $trend = [];
        for ($i = $days-1; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime('-'.$i.' days'));
            $trend[$d] = 0;
        }
        foreach ($result as $row) {
            $trend[$row->date] = (int)$row->cnt;
        }
        return $trend; // associative array date => count
    }

    public function get_department_distribution() {
        $this->db->select('departments.name as department, COUNT(employees.id) as cnt');
        $this->db->from('departments');
        $this->db->join('employees', 'employees.department_id = departments.id', 'left');
        $this->db->group_by('departments.id');
        $query = $this->db->get();
        $data = [];
        foreach ($query->result() as $row) {
            $data[$row->department] = (int)$row->cnt;
        }
        return $data; // associative array department => count
    }

    public function get_recent_activities($limit = 5) {
        // For demo: last attendance entries
        $this->db->select('attendances.*, employees.first_name, employees.last_name');
        $this->db->from('attendances');
        $this->db->join('employees', 'employees.id = attendances.employee_id', 'left');
        $this->db->order_by('attendances.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
}