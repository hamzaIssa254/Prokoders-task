# 🚀 Task Management System - Laravel API

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

## 📑 Table of Contents
- [Project Overview](#-project-overview)
- [Key Features](#-key-features)
- [API Endpoints](#-api-endpoints)
- [Installation Guide](#-installation-guide)
- [Environment Variables](#-environment-variables)
- [Database Structure](#-database-structure)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Contributing](#-contributing)

## 🌐 Project Overview

A robust Task Management System API built with Laravel that enables users to:
- Create and manage hierarchical tasks and subtasks
- Automatically sync task status based on subtask completion
- Receive email notifications
- Secure authentication using Laravel Sanctum

## 💡 Key Features

### Core Functionality
- **JWT Authentication** (Register/Login/Logout)
- **Full CRUD Operations** for Tasks and Subtasks
- **Automatic Status Propagation** (Parent task updates when subtasks change)
- **Email Notifications** upon subtask completion
- **Caching** for optimal performance
- **Advanced Filtering** with pagination

### Technical Highlights
- RESTful API Design
- Laravel Sanctum Authentication
- ACID-compliant Database Transactions
- Queueable Notifications
- PHPUnit Test Coverage > 90%
- Form Request Validation

## 🔗 API Endpoints

### Authentication
| Method | Endpoint       | Description                | Auth Required |
|--------|----------------|----------------------------|---------------|
| POST   | `/api/register`| User registration          | No            |
| POST   | `/api/login`   | User login                 | No            |
| POST   | `/api/logout`  | User logout                | Yes           |

### Tasks Management
| Method | Endpoint          | Description                     | Auth Required |
|--------|-------------------|---------------------------------|---------------|
| GET    | `/api/tasks`      | List tasks with filters         | Yes           |
| POST   | `/api/tasks`      | Create new task                 | Yes           |
| GET    | `/api/tasks/{id}` | Get task details                | Yes           |
| PUT    | `/api/tasks/{id}` | Update task                     | Yes           |
| DELETE | `/api/tasks/{id}` | Delete task                     | Yes           |

### Subtasks Management
| Method | Endpoint                     | Description                          | Auth Required |
|--------|------------------------------|--------------------------------------|---------------|
| GET    | `/api/tasks/{task}/subtasks` | List subtasks                        | Yes           |
| POST   | `/api/tasks/{task}/subtasks` | Create subtask                       | Yes           |
| PUT    | `/api/subtasks/{id}`         | Update subtask                       | Yes           |
| DELETE | `/api/subtasks/{id}`         | Delete subtask                       | Yes           |

## 🛠 Installation Guide

### Prerequisites
- PHP 8.1+
- Composer 2.0+
- MySQL 8.0+ or MariaDB 10.3+


### Setup Instructions
1. Clone repository:
   git clone https://github.com/hamzaIssa254/Prokoders-task.git
   cd task-management-api

2-Install dependencies:
    composer install
    npm install

3-Configure environment:
    cp .env.example .env
    php artisan key:generate

4-Setup database:
    php artisan migrate --seed

5-Start development server:
    php artisan serve

🧪 Testing
Run the test suite:
php artisan test.

try this project with postman: https://documenter.getpostman.com/view/34383133/2sB2qZFiEB
