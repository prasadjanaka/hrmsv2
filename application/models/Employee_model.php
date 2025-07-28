<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    private $table = 'employees';

    public function __construct() {
        parent::__construct();
    }

    /* ------------------ CRUD ------------------ */
    public function get_all($keyword = null, $department_id = null, $designation_id = null) {
        $this->db->select('employees.*, departments.name as department_name, designations.title as designation_title');
        $this->db->from($this->table);
        $this->db->join('departments', 'departments.id = employees.department_id', 'left');
        $this->db->join('designations', 'designations.id = employees.designation_id', 'left');

        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('employees.first_name', $keyword);
            $this->db->or_like('employees.last_name', $keyword);
            $this->db->or_like('employees.employee_id', $keyword);
            $this->db->group_end();
        }
        if (!empty($department_id)) {
            $this->db->where('employees.department_id', $department_id);
        }
        if (!empty($designation_id)) {
            $this->db->where('employees.designation_id', $designation_id);
        }

        return $this->db->get()->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    /* ------------------ Helpers ------------------ */
    public function get_departments() {
        return $this->db->get('departments')->result();
    }

    public function get_designations() {
        return $this->db->get('designations')->result();
    }

    public function get_cadres() {
        return $this->db->get('cadres')->result();
    }

    public function get_shifts() {
        return $this->db->get('shifts')->result();
    }
}