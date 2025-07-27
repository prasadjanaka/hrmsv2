-- HRMS Database Schema
-- Human Resource Management System
-- CodeIgniter 3.1.13 + MySQL

CREATE DATABASE IF NOT EXISTS `hrms_db` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `hrms_db`;

-- --------------------------------------------------------
-- Table structure for users (Authentication)
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','hr','employee') NOT NULL DEFAULT 'employee',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for departments
-- --------------------------------------------------------
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for designations
-- --------------------------------------------------------
CREATE TABLE `designations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for cadres
-- --------------------------------------------------------
CREATE TABLE `cadres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `salary_scale` varchar(50),
  `description` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for shifts
-- --------------------------------------------------------
CREATE TABLE `shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `working_days` varchar(20) DEFAULT 'Mon-Fri',
  `late_minutes` int(11) DEFAULT 15,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for employees
-- --------------------------------------------------------
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL UNIQUE,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20),
  `address` text,
  `date_of_birth` date,
  `date_of_joining` date NOT NULL,
  `department_id` int(11),
  `designation_id` int(11),
  `cadre_id` int(11),
  `shift_id` int(11),
  `salary_mode` enum('monthly','daily') NOT NULL DEFAULT 'monthly',
  `monthly_salary` decimal(10,2) DEFAULT 0.00,
  `daily_rate` decimal(8,2) DEFAULT 0.00,
  `profile_photo` varchar(255),
  `status` enum('active','inactive','terminated') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`designation_id`) REFERENCES `designations`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`cadre_id`) REFERENCES `cadres`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`shift_id`) REFERENCES `shifts`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for attendance
-- --------------------------------------------------------
CREATE TABLE `attendances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `check_in` time,
  `check_out` time,
  `status` enum('present','absent','late','half_day') NOT NULL DEFAULT 'present',
  `is_late` tinyint(1) DEFAULT 0,
  `late_minutes` int(11) DEFAULT 0,
  `hours_worked` decimal(4,2) DEFAULT 0.00,
  `remarks` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_date` (`employee_id`, `date`),
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for leave types
-- --------------------------------------------------------
CREATE TABLE `leave_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `days_allowed` int(11) NOT NULL DEFAULT 0,
  `description` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for leaves
-- --------------------------------------------------------
CREATE TABLE `leaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `leave_type_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `days_requested` int(11) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `approved_by` int(11),
  `approved_at` timestamp NULL,
  `remarks` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`approved_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for salary payments
-- --------------------------------------------------------
CREATE TABLE `salary_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `days_worked` int(11) DEFAULT 0,
  `present_days` int(11) DEFAULT 0,
  `absent_days` int(11) DEFAULT 0,
  `late_days` int(11) DEFAULT 0,
  `deductions` decimal(10,2) DEFAULT 0.00,
  `bonuses` decimal(10,2) DEFAULT 0.00,
  `net_salary` decimal(10,2) NOT NULL,
  `payment_date` date,
  `status` enum('pending','paid','cancelled') NOT NULL DEFAULT 'pending',
  `remarks` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_month_year` (`employee_id`, `month`, `year`),
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for holidays
-- --------------------------------------------------------
CREATE TABLE `holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `description` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Table structure for settings
-- --------------------------------------------------------
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL UNIQUE,
  `setting_value` text,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- Insert default data
-- --------------------------------------------------------

-- Default admin user (password: admin123)
INSERT INTO `users` (`username`, `email`, `password`, `role`, `status`) VALUES
('admin', 'admin@hrms.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active');

-- Default departments
INSERT INTO `departments` (`name`, `description`) VALUES
('Human Resources', 'Human Resources Department'),
('Information Technology', 'IT Department'),
('Finance', 'Finance and Accounting'),
('Operations', 'Operations Department');

-- Default designations
INSERT INTO `designations` (`title`, `description`) VALUES
('Manager', 'Department Manager'),
('Assistant Manager', 'Assistant Manager'),
('Officer', 'Officer Level Position'),
('Executive', 'Executive Level Position'),
('Assistant', 'Assistant Level Position');

-- Default cadres
INSERT INTO `cadres` (`name`, `salary_scale`, `description`) VALUES
('Technical Officer', 'TO-1', 'Technical Officer Cadre'),
('Administrative Officer', 'AO-1', 'Administrative Officer Cadre'),
('Assistant', 'AS-1', 'Assistant Cadre'),
('Supervisor', 'SV-1', 'Supervisor Cadre');

-- Default shifts
INSERT INTO `shifts` (`name`, `start_time`, `end_time`, `working_days`, `late_minutes`) VALUES
('Morning Shift', '09:00:00', '17:00:00', 'Mon-Fri', 15),
('Evening Shift', '14:00:00', '22:00:00', 'Mon-Fri', 15),
('Night Shift', '22:00:00', '06:00:00', 'Mon-Fri', 15);

-- Default leave types
INSERT INTO `leave_types` (`name`, `days_allowed`, `description`) VALUES
('Annual Leave', 21, 'Annual vacation leave'),
('Sick Leave', 14, 'Medical leave'),
('Casual Leave', 10, 'Casual/Personal leave'),
('Maternity Leave', 90, 'Maternity leave'),
('Emergency Leave', 5, 'Emergency leave');

-- Default settings
INSERT INTO `settings` (`setting_key`, `setting_value`, `description`) VALUES
('company_name', 'HRMS Company', 'Company name'),
('company_address', '123 Business Street, City, Country', 'Company address'),
('company_phone', '+1234567890', 'Company phone number'),
('company_email', 'info@hrms.com', 'Company email address'),
('working_hours_per_day', '8', 'Standard working hours per day'),
('working_days_per_month', '22', 'Standard working days per month');