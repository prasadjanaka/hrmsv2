<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
        $this->load->library(['form_validation', 'upload']);
        $this->require_auth = true; // ensure authentication
    }

    /* ------------------ List ------------------ */
    public function index() {
        $keyword = $this->input->get('keyword');
        $department_id = $this->input->get('department');
        $designation_id = $this->input->get('designation');

        $data['title'] = 'Employees';
        $data['employees'] = $this->Employee_model->get_all($keyword, $department_id, $designation_id);
        $data['departments'] = $this->Employee_model->get_departments();
        $data['designations'] = $this->Employee_model->get_designations();

        $this->load->view('employees/index', $data);
    }

    /* ------------------ Add ------------------ */
    public function add() {
        $data['title'] = 'Add Employee';
        $this->_handle_form($data);
    }

    /* ------------------ Edit ------------------ */
    public function edit($id) {
        $data['title'] = 'Edit Employee';
        $data['employee'] = $this->Employee_model->get($id);
        if (!$data['employee']) show_404();
        $this->_handle_form($data, $id);
    }

    /* ------------------ Delete ------------------ */
    public function delete($id) {
        $this->Employee_model->delete($id);
        redirect('employees');
    }

    /* ------------------ Private form handler ------------------ */
    private function _handle_form($data, $id = null) {
        $data['departments'] = $this->Employee_model->get_departments();
        $data['designations'] = $this->Employee_model->get_designations();
        $data['cadres'] = $this->Employee_model->get_cadres();
        $data['shifts'] = $this->Employee_model->get_shifts();

        // Validation rules
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('employee_id', 'Employee ID', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('salary_mode', 'Salary Mode', 'required');

        if ($this->form_validation->run() === TRUE) {
            $emp_data = $this->input->post();
            unset($emp_data['submit']);

            // Handle profile photo upload
            if (!empty($_FILES['profile_photo']['name'])) {
                $config = [
                    'upload_path'   => './assets/uploads/employees/',
                    'allowed_types' => 'jpg|jpeg|png',
                    'max_size'      => 2048,
                    'file_name'     => 'emp_' . time()
                ];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('profile_photo')) {
                    $uploadData = $this->upload->data();
                    $emp_data['profile_photo'] = 'assets/uploads/employees/' . $uploadData['file_name'];
                } else {
                    $data['error'] = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
                    return $this->load->view('employees/form', $data);
                }
            }

            // Insert or update
            if ($id) {
                $this->Employee_model->update($id, $emp_data);
            } else {
                $this->Employee_model->insert($emp_data);
            }
            redirect('employees');
        }

        $this->load->view('employees/form', $data);
    }
}