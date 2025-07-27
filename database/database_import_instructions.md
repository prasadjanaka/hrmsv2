# HRMS Database Setup Instructions

## Prerequisites
- MySQL 5.7 or higher installed
- MySQL command line client or phpMyAdmin access

## Method 1: Using MySQL Command Line

### 1. Create Database
```bash
mysql -u root -p
CREATE DATABASE hrms_db CHARACTER SET utf8 COLLATE utf8_general_ci;
exit
```

### 2. Import Schema
```bash
mysql -u root -p hrms_db < database/hrms_schema.sql
```

## Method 2: Using phpMyAdmin

### 1. Open phpMyAdmin in browser
- Usually: http://localhost/phpmyadmin

### 2. Create Database
- Click "New" in the left sidebar
- Database name: `hrms_db`
- Collation: `utf8_general_ci`
- Click "Create"

### 3. Import Schema
- Select `hrms_db` database
- Click "Import" tab
- Choose file: `database/hrms_schema.sql`
- Click "Go"

## Default Login Credentials

After importing the schema, you can login with:
- **Username**: admin
- **Password**: admin123
- **Role**: Administrator

## Verify Installation

### Check Tables Created:
```sql
USE hrms_db;
SHOW TABLES;
```

You should see these tables:
- attendances
- cadres
- departments
- designations
- employees
- holidays
- leaves
- leave_types
- salary_payments
- settings
- shifts
- users

### Test Login
1. Navigate to your HRMS URL: http://localhost/hrms/
2. You should see the login page
3. Login with admin/admin123

## Database Configuration

Make sure your `application/config/database.php` matches your MySQL setup:
```php
'hostname' => 'localhost',
'username' => 'root',        // Your MySQL username
'password' => '',            // Your MySQL password
'database' => 'hrms_db',
```

## Troubleshooting

### Connection Issues:
- Verify MySQL service is running
- Check username/password in database.php
- Ensure hrms_db database exists

### Permission Issues:
- Make sure MySQL user has access to hrms_db
- Grant privileges if needed:
```sql
GRANT ALL PRIVILEGES ON hrms_db.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
```