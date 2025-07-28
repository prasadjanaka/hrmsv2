<?php $this->load->view('layouts/header', array('title' => 'Settings')); ?>

<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">System Settings</h3>
            <p class="text-muted mb-0">Configure system parameters and preferences</p>
        </div>
        <div class="badge bg-danger">Admin Only</div>
    </div>
    
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Access Control Demo:</strong> This page is only accessible to users with 'admin' role.
        Current user role: <strong><?php echo $this->session->userdata('role'); ?></strong>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Company Settings</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Configure company information and branding.</p>
                    <button class="btn btn-primary" disabled>
                        <i class="fas fa-cog me-2"></i>Configure
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">User Management</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Manage user accounts and permissions.</p>
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-users me-2"></i>Manage Users
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>