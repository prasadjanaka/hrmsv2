<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table = 'employees';

    public function __construct() {
        parent::__construct();
    }




    public function authenticate($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        $user = $query->row();
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    public function update_password($user_id, $new_password) {
        $hash = password_hash($new_password, PASSWORD_BCRYPT);
        $this->db->where('id', $user_id);
        return $this->db->update('users', array('password' => $hash));
    }

}