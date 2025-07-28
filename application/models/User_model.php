
    public function update_password($user_id, $new_password) {
        $hash = password_hash($new_password, PASSWORD_BCRYPT);
        $this->db->where('id', $user_id);
        return $this->db->update('users', array('password' => $hash));
    }