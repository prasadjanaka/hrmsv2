<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Controller
 *
 * Acts as an application-wide base controller that enforces
 * authentication and optional role-based authorization.
 * All secure controllers should extend this class.
 */
class MY_Controller extends CI_Controller
{
    /** @var bool Whether a logged-in session is required */
    protected $require_auth = true;

    /**
     * @var array Allowed roles for the current controller/method.
     *            Leave empty to allow any authenticated user.
     */
    protected $allowed_roles = array();

    public function __construct()
    {
        parent::__construct();

        // Load session library in case it is not autoloaded
        $this->load->library('session');

        // Enforce authentication
        if ($this->require_auth) {
            if (!$this->session->userdata('logged_in')) {
                // Remember requested URL so we can redirect after login
                $this->session->set_flashdata('redirect_after_login', current_url());
                redirect('login');
            }

            // Optional role-based authorization
            if (!empty($this->allowed_roles)) {
                $user_role = $this->session->userdata('role');
                if (!in_array($user_role, $this->allowed_roles, true)) {
                    show_error('You are not authorised to access this page.', 403, 'Access denied');
                }
            }
        }
    }
}