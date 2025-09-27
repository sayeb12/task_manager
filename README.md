# Task Manager - Web Application

A simple and efficient Task Manager web application built with PHP and Bootstrap. This application features user authentication and full CRUD functionality for task management.

## Features

* User Authentication (Register, Login, Logout)
* Task Management (Add, Edit, Delete, View)
* Secure Password Hashing
* PHP with MySQL Database
* Responsive Bootstrap UI
* Input Validation & XSS Prevention
* User-specific Task Management
* Task Completion Status

## Technology Stack

* **Backend**: PHP
* **Database**: MySQL
* **Frontend**: Bootstrap 5, JavaScript
* **Security**: Prepared Statements, Password Hashing

## Project Structure

```
task_manager/
├── config/
│   └── database.php
├── includes/
│   ├── auth.php
│   ├── functions.php
│   ├── header.php
│   ├── footer.php
│   └── Task.php
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── tasks/
│   ├── index.php
│   ├── add.php
│   ├── edit.php
│   ├── delete.php
│   ├── update.php
│   └── get_task.php
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── script.js
└── index.php
```

## Installation & Setup

### Prerequisites

* XAMPP/WAMP/MAMP installed
* PHP 7.4 or higher
* MySQL 5.7 or higher
* Web browser

### Step 1: Database Setup

1. Start your MySQL server (through XAMPP/WAMP)
2. Create the database by running this SQL in phpMyAdmin:

```sql
CREATE DATABASE task_manager;
USE task_manager;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    due_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Step 2: File Setup

1. Clone or download the project files
2. Place the files in your web server directory (htdocs for XAMPP)
3. Configure database connection in `config/database.php`:

```php
private $host = "localhost";
private $db_name = "task_manager";
private $username = "root";
private $password = "";
```

### Step 3: Run the Application

1. Start Apache and MySQL in XAMPP/WAMP
2. Open your browser and navigate to:
   ```
   http://localhost/task_manager
   ```
3. Register a new account or login if you already have one

## Usage

### For Users

1. **Registration**: Create a new account with username, email, and password
2. **Login**: Access your personal task dashboard
3. **Add Tasks**: Click "Add New Task" to create tasks
4. **Manage Tasks**: Edit, delete, or mark tasks as complete/incomplete
5. **Logout**: Securely end your session

## Security Features

* Password hashing with `password_hash()`
* SQL injection prevention with prepared statements
* XSS prevention with `htmlspecialchars()`
* Session-based authentication
* User-specific data isolation

## File Descriptions

### Core Files
* `index.php` - Homepage with redirection
* `config/database.php` - Database configuration
* `includes/header.php` - Common header with navigation
* `includes/footer.php` - Common footer with scripts

### Authentication
* `auth/register.php` - User registration
* `auth/login.php` - User login
* `auth/logout.php` - Session destruction

### Task Management
* `tasks/index.php` - Main tasks dashboard
* `tasks/add.php` - Add new tasks
* `tasks/edit.php` - Edit existing tasks
* `tasks/delete.php` - Delete tasks
* `tasks/update.php` - Update task status

## Troubleshooting

### Common Issues

* **Database Connection Error**: Check MySQL server is running and credentials are correct
* **Page Not Found**: Verify file paths and server configuration
* **Session Issues**: Check PHP session configuration

## License

This project is open source and available under the MIT License.

---

**Built by**: Sayeb  
**For**: Dial Dynamic Ltd Hiring Process  
**Position**: In-house Web Developer
