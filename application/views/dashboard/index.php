<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?? 'Dashboard'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">HRMS</a>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">Logged in as <?php echo $this->session->userdata('username'); ?></span>
            <a href="<?php echo site_url('logout'); ?>" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>
<div class="container my-4">
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>