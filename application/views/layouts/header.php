<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - HRMS' : 'HRMS'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-width-collapsed: 80px;
            --header-height: 60px;
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #1a252f 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        /* Sidebar Brand */
        .sidebar-brand {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }

        .sidebar-brand .brand-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .sidebar-brand .brand-text {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .brand-text {
            opacity: 0;
            display: none;
        }

        /* Sidebar Menu */
        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            margin-bottom: 0.5rem;
            position: relative;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .menu-link:hover {
            background-color: var(--sidebar-hover);
            color: white;
            text-decoration: none;
        }

        .menu-link.active {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .menu-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: white;
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .menu-text {
            transition: opacity 0.3s ease;
            white-space: nowrap;
        }

        .sidebar.collapsed .menu-text {
            display: none;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center !important;
            padding: 1rem 0;
            margin: 0.2rem 0.8rem;
            border-radius: 10px;
            text-align: center;
        }

        .sidebar.collapsed .menu-icon {
            margin-right: 0 !important;
            font-size: 1.3rem;
            width: auto;
            height: auto;
        }

        .sidebar.collapsed .menu-link.active::before {
            display: none;
        }

        .sidebar.collapsed .menu-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        /* Tooltip for collapsed sidebar */
        .sidebar.collapsed .menu-item {
            position: relative;
        }

        .sidebar.collapsed .menu-link:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 15px;
            padding: 8px 12px;
            background: #333;
            color: white;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 1001;
            opacity: 1;
            pointer-events: none;
        }

        .sidebar.collapsed .menu-link:hover::before {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 9px;
            border: 6px solid transparent;
            border-right-color: #333;
            z-index: 1001;
        }

        /* Top Header */
        .top-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: white;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            z-index: 999;
            transition: left 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed + .top-header {
            left: var(--sidebar-width-collapsed);
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #6c757d;
            cursor: pointer;
            margin-right: 1rem;
            padding: 0.5rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-menu {
            position: relative;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .user-dropdown:hover {
            background-color: #f8f9fa;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 0.5rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 2rem;
            min-height: calc(100vh - var(--header-height));
            transition: margin-left 0.3s ease;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-width-collapsed);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .top-header {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .sidebar-overlay.show {
                opacity: 1;
                visibility: visible;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .page-title {
                font-size: 1.1rem;
            }
        }

        /* Content Cards */
        .content-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        /* Breadcrumb */
        .breadcrumb-nav {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-nav .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="fas fa-users-cog"></i>
            </div>
            <h5 class="brand-text">HRMS</h5>
        </div>
        
        <nav class="sidebar-menu">
            <div class="menu-item">
                <a href="<?php echo site_url('dashboard'); ?>" class="menu-link <?php echo ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') ? 'active' : ''; ?>" data-tooltip="Dashboard">
                    <i class="fas fa-tachometer-alt menu-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="<?php echo site_url('employees'); ?>" class="menu-link <?php echo ($this->uri->segment(1) == 'employees') ? 'active' : ''; ?>" data-tooltip="Employees">
                    <i class="fas fa-users menu-icon"></i>
                    <span class="menu-text">Employees</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="<?php echo site_url('departments'); ?>" class="menu-link <?php echo ($this->uri->segment(1) == 'departments') ? 'active' : ''; ?>" data-tooltip="Departments">
                    <i class="fas fa-building menu-icon"></i>
                    <span class="menu-text">Departments</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="<?php echo site_url('designations'); ?>" class="menu-link <?php echo ($this->uri->segment(1) == 'designations') ? 'active' : ''; ?>" data-tooltip="Designations">
                    <i class="fas fa-briefcase menu-icon"></i>
                    <span class="menu-text">Designations</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="<?php echo site_url('attendance'); ?>" class="menu-link <?php echo ($this->uri->segment(1) == 'attendance') ? 'active' : ''; ?>" data-tooltip="Attendance">
                    <i class="fas fa-clock menu-icon"></i>
                    <span class="menu-text">Attendance</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="<?php echo site_url('leaves'); ?>" class="menu-link <?php echo ($this->uri->segment(1) == 'leaves') ? 'active' : ''; ?>" data-tooltip="Leave Management">
                    <i class="fas fa-calendar-alt menu-icon"></i>
                    <span class="menu-text">Leave Management</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="<?php echo site_url('salary'); ?>" class="menu-link <?php echo ($this->uri->segment(1) == 'salary') ? 'active' : ''; ?>" data-tooltip="Salary">
                    <i class="fas fa-money-bill-wave menu-icon"></i>
                    <span class="menu-text">Salary</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="<?php echo site_url('reports'); ?>" class="menu-link <?php echo ($this->uri->segment(1) == 'reports') ? 'active' : ''; ?>" data-tooltip="Reports">
                    <i class="fas fa-chart-bar menu-icon"></i>
                    <span class="menu-text">Reports</span>
                </a>
            </div>
            
            <div class="menu-item">
                <a href="<?php echo site_url('settings'); ?>" class="menu-link <?php echo ($this->uri->segment(1) == 'settings') ? 'active' : ''; ?>" data-tooltip="Settings">
                    <i class="fas fa-cog menu-icon"></i>
                    <span class="menu-text">Settings</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Top Header -->
    <header class="top-header">
        <div class="header-left">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title"><?php echo isset($title) ? $title : 'Dashboard'; ?></h1>
        </div>
        
        <div class="header-right">
            <?php if ($this->session->userdata('logged_in')): ?>
                <div class="user-menu">
                    <div class="dropdown">
                        <button class="user-dropdown" type="button" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <?php echo strtoupper(substr($this->session->userdata('username'), 0, 1)); ?>
                            </div>
                            <span class="d-none d-md-inline"><?php echo $this->session->userdata('username'); ?></span>
                            <i class="fas fa-chevron-down ms-1"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo site_url('profile'); ?>"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('change_password'); ?>"><i class="fas fa-key me-2"></i>Change Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('logout'); ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">