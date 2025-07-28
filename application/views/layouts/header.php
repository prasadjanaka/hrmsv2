<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title . ' - HRMS' : 'HRMS'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">HRMS</a>
        <?php if ($this->session->userdata('logged_in')): ?>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">Logged in as <?php echo $this->session->userdata('username'); ?></span>
                <a href="<?php echo site_url('logout'); ?>" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        <?php endif; ?>
    </div>
</nav>
<div class="container my-4">