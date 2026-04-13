# Online Exam System

**Repository:** `online_exam`

## Overview

The **Online Exam System** is a web-based examination platform designed for high schools to manage and conduct exams digitally. The system supports multiple roles including **Super Admin, Admin, Teachers, and Students**, each with their own dashboard and permissions.

The platform allows administrators to manage students, subjects, branches, and exams, while teachers can create questions and monitor results. Students can log in to take exams and view their performance.

The project is built using **Laravel 12**, **Bootstrap**, and **MySQL**, following a modular and scalable architecture.

---

# Features

## Role-Based Dashboards

### Super Admin

* Full system access
* Manage admins and teachers
* Manage students
* Manage subjects and branches
* System-wide configuration

### Admin

* Manage students
* Manage student login accounts
* Manage subjects
* Manage branches
* Create and manage exams
* Import students in bulk via Excel

### Teacher

* Create and manage exam questions
* Edit or delete questions
* Assign questions to exams
* View student results and exam insights

### Student

* Secure login
* View assigned exams
* Take exams with timer
* View results and attempt history

---

# System Modules

## Authentication

Two authentication systems are implemented.

### Staff Authentication

Used by:

* Super Admin
* Admin
* Teacher

Tables used:

* `admin`
* `users`

### Student Authentication

Students authenticate using:

* `login_information`

The student account links to the student profile using:

```
students.profile_ID = login_information.profileID
```

---

# Exam Management

Admins and teachers can:

* Create exams
* Define exam duration
* Set number of questions
* Assign questions automatically
* Activate or deactivate exams

### Question Assignment

Questions are automatically selected based on:

* Subject
* Grade level
* Requested number of questions

---

# Question Management

Teachers can:

* Create questions using a rich text editor
* Add multiple choice answers
* Define correct answers
* Edit or delete questions

---

# Student Examination

Students can:

* View available exams based on their **class and section**
* Start an exam session
* Answer multiple-choice questions
* Submit exams before the timer expires

Answers are recorded in:

```
exam_record
```

---

# Exam Security

The system includes:

* Exam session tracking
* Timer enforcement
* Automatic submission when time expires
* Prevention of multiple attempts
* Attempt history tracking

---

# Student Management

Administrators can:

* Add students manually
* Import students using Excel
* Manage student login accounts
* Reset student passwords
* Activate or deactivate accounts

---

# Bulk Student Import

Students can be imported through an Excel file.

### Excel Format

| fullname | gender | age | phone | class | section | branch |
| -------- | ------ | --- | ----- | ----- | ------- | ------ |

During import the system:

1. Creates student records
2. Creates login accounts
3. Prevents duplicate accounts

---

# Technology Stack

### Backend

* Laravel 12
* PHP 8.2+

### Frontend

* Bootstrap
* JavaScript
* CKEditor 5

### Database

* MySQL / MariaDB

### Libraries

* PhpSpreadsheet (Excel import)

---

# Installation

## 1. Clone Repository

```
git clone https://github.com/your-username/online_exam.git
cd online_exam
```

---

## 2. Install Dependencies

```
composer install
```

---

## 3. Configure Environment

```
cp .env.example .env
```

Update database configuration inside `.env`.

---

## 4. Generate Application Key

```
php artisan key:generate
```

---

## 5. Run Migrations

```
php artisan migrate
```

---

## 6. Start Development Server

```
php artisan serve
```

The application will be available at:

```
http://localhost:8000
```

---

# Database Tables

Main tables used by the system:

```
admin
users
students
login_information
subjects
branches
questions
options
quiz
exam_questions
exam_record
history
rank
feedback
```

---

# Pagination & Data Tables

All management modules support:

* Server-side pagination
* Search and filtering
* Responsive tables

---

# Security

The system implements:

* Role-based access control
* Password hashing
* Session validation
* Exam session tracking

---

# Future Improvements

Planned improvements include:

* Bulk question import via Excel
* Advanced exam analytics
* Real-time exam monitoring
* Result export to Excel or PDF
* Anti-cheating detection
* Mobile-friendly exam interface

---

# Author

Developed by:

**Mohammedbrhan Abdelkadr**
Software Engineer
