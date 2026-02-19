# 🎓 EdTech Platform - Laravel Application

A comprehensive Learning Management System (LMS) built with Laravel, featuring JWT authentication, role-based access control, course management, and interactive frontend.

## ✨ Features

### 🚀 Authentication & Authorization
- JWT-based authentication system
- Role-based access (Admin, Instructor, Student)
- Secure login/registration flow
- Token refresh mechanism

### 📚 Course Management
- Browse courses with search and filters
- Course details with lessons
- Enrollment system
- Review and rating system
- Progress tracking for students

### 👥 User Roles

#### 🛡️ Admin
- Full system access
- Manage all courses and users
- View analytics and reports

#### 👨‍🏫 Instructor
- Create and manage courses
- Add/edit lessons
- View enrolled students
- Track course performance

#### 🧑‍🎓 Student
- Browse and search courses
- Enroll in courses
- Track learning progress
- Write reviews
- Access enrolled courses

### 🎯 Navigation Menu

The application features a dynamic navigation bar that changes based on user authentication status:

#### 🔓 Guest Users

### 🖥️ Frontend Features
- Responsive Bootstrap 5 UI
- AJAX/Axios for seamless interactions
- Real-time search and filters
- Pagination for course listings
- Toast notifications
- Loading indicators

## 📋 Prerequisites

- **PHP** >= 8.1
- **Composer** - PHP dependency manager
- **MySQL** >= 5.7
- **Node.js** >= 16.x & **NPM** - For frontend assets
- **Git** - Version control

## 🚀 Installation Guide

### Step 1: Clone the Repository

git clone <https://github.com/Sadi-Ori/edTechPlatform.git>
cd edtech-platform

run command:

composer install
npm install
npm run dev
php arisan migrate
php artisan serve

copy .env.example .env
php artisan key:generate
php artisan migrate

Frontend Components
Authentication Flow
User registers/logs in

JWT token stored in localStorage

Token attached to all subsequent requests

Navigation updates based on user role

Course Listing
Search by title

Filter by level (beginner/intermediate/advanced)

Sort by price, date, title

Pagination

Real-time updates via AJAX

Course Details
Course information

Lesson list

Enrollment button

Review section

Progress tracking

📊 Database Schema
Tables
users - id, name, email, password, role

courses - id, title, description, price, level, instructor_id

lessons - id, course_id, title, content, order

enrollments - user_id, course_id, enrolled_at, status

reviews - id, user_id, course_id, rating, comment

🚀 Deployment
Production Checklist
Set APP_ENV=production in .env

Set APP_DEBUG=false

Generate new APP_KEY

Configure database for production

Set up SSL certificate

Configure queue worker (if using)

Set up backup system

Configure error monitoring (Sentry, etc.)

Server Requirements
PHP 8.1+

MySQL 5.7+

Composer

Node.js & NPM (for building assets)

Redis (optional, for caching)


## 🎯 Summary of Navigation Features

The README now clearly shows:

1. **Initial Load** - Shows "Loading..." spinner while checking authentication
2. **After Auth Check** - Updates to proper menu based on user role
3. **Guest Users** - See: Courses, Login, Register
4. **Logged-in Students** - See: Courses, My Courses, [Username]
5. **Logged-in Instructors** - See: Courses, Dashboard, Create Course, [Username]

This comprehensive README will help anyone set up and understand your EdTech platform perfectly! 🚀