# Simple Student Management System

A modern, responsive, and beginner-friendly **Student Management System** built with **Laravel 12 (PHP 8.2+)**, **MySQL 8**, **Bootstrap 5**, and fully containerized using **Docker Compose**.

---

## 1. Project Overview

This project demonstrates core Laravel concepts and best practices:
- **MVC Architecture**: Clean separation of Models, Views, and Controllers.
- **RESTful Resource Routes**: Complete CRUD for students (`GET`, `POST`, `PUT`, `DELETE`).
- **Eloquent ORM**: Type-safe model relations, queries, mass assignment protection, and casts.
- **Form Validation**: Server-side request validation with custom rules and unique email checks.
- **Search & Pagination**: Live searching across student names, emails, and phone numbers with paginated results.
- **Bootstrap 5 Admin UI**: Responsive sidebar, statistics cards, data tables, and modal confirmation dialogs.
- **Docker Compose**: Pre-configured environment with PHP 8.2-FPM, Nginx, MySQL 8, and phpMyAdmin.

---

## 2. Technology Stack

- **Backend**: PHP 8.2+, Laravel 12, Eloquent ORM
- **Database**: MySQL 8.0
- **Frontend**: Blade Templates, Bootstrap 5.3, Bootstrap Icons
- **Web Server**: Nginx (Alpine)
- **Database Administration**: phpMyAdmin
- **Containerization**: Docker & Docker Compose

---

## 3. Folder Structure

```
laravelprojectone/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── DashboardController.php   # Dashboard analytics & statistics
│   │       └── StudentController.php     # Full CRUD logic & validation
│   └── Models/
│       └── Student.php                   # Student Eloquent Model with fillable fields
├── database/
│   ├── factories/
│   │   └── StudentFactory.php            # Model factory for dummy student generation
│   ├── migrations/
│   │   └── 2026_11_23_153455_create_students_table.php # Schema definition
│   └── seeders/
│       ├── DatabaseSeeder.php            # Main database seeder
│       └── StudentSeeder.php             # Seeds realistic sample students
├── docker-compose.yml                    # Multi-container orchestration (app, nginx, mysql, phpmyadmin)
├── Dockerfile                            # PHP 8.2-FPM + extensions + Composer
├── nginx/
│   └── default.conf                      # Nginx virtual host configuration
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php             # Master layout with responsive sidebar & topnav
│       ├── dashboard.blade.php           # Admin dashboard with metric cards & recent records
│       └── students/
│           ├── index.blade.php           # Student listing, search, pagination & delete modal
│           ├── create.blade.php          # Student registration form
│           └── edit.blade.php            # Student edit & update form
├── routes/
│   └── web.php                           # Route definitions (resource route & dashboard)
├── tests/
│   └── Feature/
│       └── StudentCrudTest.php           # Automated feature tests for all CRUD operations
├── .dockerignore                         # Files excluded from Docker builds
├── .env.example                          # Dockerized environment template
└── README.md                             # Comprehensive project documentation
```

---

## 4. Docker Architecture

The application runs using four linked Docker services on a bridge network:

| Service | Image / Base | Internal Port | Host Port | Description |
|---|---|---|---|---|
| **app** | `Dockerfile` (PHP 8.2-FPM) | `9000` | - | Runs Laravel application, Eloquent, artisan commands |
| **nginx** | `nginx:alpine` | `80` | `8000` | Reverse proxy forwarding PHP requests to `app:9000` |
| **mysql** | `mysql:8.0` | `3306` | `3309` | MySQL 8 database with persistent named volume |
| **phpmyadmin** | `phpmyadmin/phpmyadmin` | `80` | `8082` | Web UI for inspecting MySQL database |

---

## 5. Quick Installation & Execution

### Step 1: Clone / Navigate to Project Directory
```bash
cd ~/Downloads/laravelprojectone
```

### Step 2: Configure Environment File
If `.env` does not exist, copy `.env.example`:
```bash
cp .env.example .env
```

### Step 3: Build and Start Containers
```bash
docker compose up -d --build
```

### Step 4: Install Dependencies (if vendor is not already generated)
```bash
docker compose exec app composer install
```

### Step 5: Generate Application Key
```bash
docker compose exec app php artisan key:generate
```

### Step 6: Run Database Migrations & Seed Sample Data
```bash
docker compose exec app php artisan migrate --seed
```

### Step 7: Access the Application
- **Student Management Dashboard**: [http://localhost:8000](http://localhost:8000)
- **Students List & CRUD**: [http://localhost:8000/students](http://localhost:8000/students)
- **phpMyAdmin**: [http://localhost:8082](http://localhost:8082)
  - **Server**: `mysql`
  - **Username**: `student_user` (or `root`)
  - **Password**: `student_password` (or `root_password`)

---

## 6. Database Configuration

Inside the container, Laravel communicates with MySQL over Docker's internal DNS using service name `mysql`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=student_management
DB_USERNAME=student_user
DB_PASSWORD=student_password
```

> **Note:** The host port `3309` is mapped to container port `3306` to prevent conflicts with any local MySQL server running on host port `3306`.

---

## 7. Features & CRUD Functionality

1. **Dashboard (`/`)**:
   - Total registered students count.
   - Male, Female, and Other gender breakdowns.
   - 5 most recently registered students with direct action links.
2. **Create Student (`/students/create`)**:
   - Fields: Name, Email (unique), Phone, Gender, Date of Birth, Address, Course, Enrollment Date.
   - Strict validation with error reporting.
3. **View & Search Students (`/students`)**:
   - Responsive Bootstrap table with badges for courses and genders.
   - Search by name, email, or phone.
   - Clean Bootstrap 5 pagination.
4. **Edit Student (`/students/{id}/edit`)**:
   - Pre-populates existing data.
   - Email uniqueness validation ignores current student ID.
5. **Delete Student (`DELETE /students/{id}`)**:
   - Secure deletion using POST/DELETE form method and CSRF protection.
   - Interactive Bootstrap modal confirmation before deleting.

---

## 8. Running Automated Tests

Run the full PHPUnit / Pest test suite inside the container:
```bash
docker compose exec app php artisan test
```

---

## 9. Stopping the Application

To stop the containers without deleting database data:
```bash
docker compose down
```

To stop and remove containers including the database volume:
```bash
docker compose down -v
```
