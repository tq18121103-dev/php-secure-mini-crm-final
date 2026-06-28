# Secure Mini CRM - PHP MVC Final Project

## Overview

Secure Mini CRM is a PHP MVC web application for managing leads and orders.  
The project focuses on secure form handling, session login, PDO database access, CRUD, search, pagination, sorting, and error handling.

## Features

- Login / Logout
- Session authentication
- Session timeout
- Session regenerate after login
- Role-based access control
- Lead CRUD
- Order CRUD
- Search
- Pagination
- Sort whitelist
- CSRF protection
- Duplicate key handling
- Safe error pages
- PDO prepared statements
- MySQL database with indexes

## Tech Stack

- PHP
- MySQL
- PDO
- Composer PSR-4 Autoload
- MVC Pattern

## Folder Structure

```text
app/
  Controllers/
  Core/
  Repositories/
  Services/
  Views/
config/
database/
public/
storage/
docs/

```

## Database

Database name:

secure_crm

Import schema:

mysql -u root < database/schema.sql

Import seed:

mysql -u root < database/seed.sql

## Run Project
php -S localhost:8000 -t public

Open:

http://localhost:8000

## Demo Account
Username: admin
Password: 123456
Role: admin
Username: staff1
Password: 123456
Role: staff
tus
## Main Routes
```text
/login
/dashboard
/leads
/orders
/health
