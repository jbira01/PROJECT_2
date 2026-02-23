# 🚗 PROJECT_2 – Car Rental Management System

![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange?logo=mysql)
![HTML5](https://img.shields.io/badge/HTML5-Markup-red?logo=html5)
![CSS3](https://img.shields.io/badge/CSS3-Styling-blue?logo=css3)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow?logo=javascript)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📊 GitHub Statistics

### 🔹 Repository Insights

![Repo Size](https://img.shields.io/github/repo-size/jbira01/PROJECT_2?style=for-the-badge\&color=blue)
![Last Commit](https://img.shields.io/github/last-commit/jbira01/PROJECT_2?style=for-the-badge\&color=green)
![Issues](https://img.shields.io/github/issues/jbira01/PROJECT_2?style=for-the-badge\&color=orange)
![Pull Requests](https://img.shields.io/github/issues-pr/jbira01/PROJECT_2?style=for-the-badge\&color=purple)

### 🔹 Language & Activity

![Top Language](https://img.shields.io/github/languages/top/jbira01/PROJECT_2?style=for-the-badge\&color=red)
![Languages Count](https://img.shields.io/github/languages/count/jbira01/PROJECT_2?style=for-the-badge\&color=yellow)
![Contributors](https://img.shields.io/github/contributors/jbira01/PROJECT_2?style=for-the-badge\&color=brightgreen)

### 🔹 Social Stats

![Stars](https://img.shields.io/github/stars/jbira01/PROJECT_2?style=for-the-badge)
![Forks](https://img.shields.io/github/forks/jbira01/PROJECT_2?style=for-the-badge)
![Watchers](https://img.shields.io/github/watchers/jbira01/PROJECT_2?style=for-the-badge)

---

## 📖 Overview

**PROJECT_2** is a full-stack Car Rental Management System developed using **PHP and MySQL**.

The application provides secure user authentication, vehicle management, and reservation handling. It demonstrates backend logic implementation, database integration, and structured CRUD operations within a real-world business scenario.

This version represents the dynamic evolution of the initial static prototype (PROJET_1).

---

## ✨ Key Features

### 👤 User Features

* Secure registration and authentication
* Vehicle browsing system
* Online reservation functionality
* Contact interface
* Responsive user interface

### 🛠️ Admin Features

* Add, update, and delete vehicles
* Manage registered users
* View and control reservations
* Role-based access management

---

## 🧰 Tech Stack

| Technology | Purpose                       |
| ---------- | ----------------------------- |
| PHP        | Server-side logic             |
| MySQL      | Relational database           |
| HTML5      | Structure                     |
| CSS3       | Styling                       |
| JavaScript | Client-side interactivity     |
| XAMPP      | Local development environment |

---

## 🗂️ Project Structure

```bash
PROJECT_2/
│
├── index.php
├── login.php
├── signup.php
├── reservation.php
├── vehicules.php
├── contact.php
│
├── admin/
├── includes/
├── assets/
├── img/
│
├── database.sql
└── README.md
```

---

## 🗄️ Database Setup

1. Start **Apache** and **MySQL** (XAMPP recommended).
2. Create a database (e.g., `car_rental`).
3. Import the file `database.sql`.
4. Configure the database connection:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "car_rental";
```

---

## 🚀 Installation

Clone the repository:

```bash
git clone https://github.com/jbira01/PROJECT_2.git
```

Move the folder to:

```
C:/xampp/htdocs/
```

Access the application in your browser:

```
http://localhost/PROJECT_2/
```

---

## 🔐 Security Considerations

* Password hashing using `password_hash()`
* Prepared statements for SQL queries
* Session-based authentication
* Input validation and sanitization
* Role-based authorization control

---

## 📈 Future Enhancements

* Payment gateway integration
* Email verification system
* Advanced filtering & search functionality
* Analytics dashboard
* RESTful API development

---

## 📄 License

Distributed under the MIT License.

---

## 👨‍💻 Author

**Yasser Jabir**
Full-Stack Developer

---

