<?php $this->load->view('layouts/header', array('title' => 'Dashboard')); ?>
    <h3 class="mb-4">Dashboard</h3>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Employees</h5>
                    <p class="card-text fs-3"><?php echo $stats['total_employees']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Departments</h5>
                    <p class="card-text fs-3"><?php echo $stats['total_departments']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Present Today</h5>
                    <p class="card-text fs-3"><?php echo $stats['present_today']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">On Leave</h5>
                    <p class="card-text fs-3"><?php echo $stats['on_leave_today']; ?></p>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('layouts/footer'); ?>