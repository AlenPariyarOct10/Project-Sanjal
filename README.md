# 🎓 ProjectSanjal

**ProjectSanjal** is an academic project showcase platform built for students and institutions in Nepal. It allows students to submit, discover, and share their academic projects — connecting talent with visibility across colleges and universities.

---

## 📋 Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Features](#features)
  - [Public-Facing Features](#public-facing-features)
  - [Client (Student) Portal](#client-student-portal)
  - [Admin Panel](#admin-panel)
- [Database Structure](#database-structure)
- [Installation & Setup](#installation--setup)
- [Running the Application](#running-the-application)
- [Project Structure](#project-structure)
- [Environment Variables](#environment-variables)
- [License](#license)

---

## Overview

ProjectSanjal is a Laravel-based platform where students can:
- Submit academic projects with source code and documentation
- Discover projects from other students filtered by course, subject, algorithm, college, and tags
- Engage with projects via likes and comments
- Form teams and collaborate on projects
- Get recognised by their institutions and peers

Administrators can manage all entities — users, colleges, universities, courses, subjects, algorithms, tags, and projects — through a full-featured admin panel.

---

## Tech Stack

| Layer | Technology |
|---|---|
| **Framework** | Laravel 12 (PHP 8.2+) |
| **Frontend** | Blade Templates, TailwindCSS (CDN + Vite) |
| **Auth** | Laravel Breeze (multi-guard: `web`, `client`, `admin`) |
| **Database** | MySQL / SQLite |
| **Datatables** | Yajra Laravel DataTables |
| **Toasts** | tall-toasts |
| **File Storage** | Laravel Storage (local `public` disk) |
| **ZIP Export** | PHP ZipArchive (built-in) |
| **Build Tool** | Vite + PostCSS |

---

## Features

### Public-Facing Features

#### 🏠 Homepage
- Displays **popular projects** ranked by likes count (top 6)
- Shows **top technologies / tags** with project counts (top 10)
- Highlights **active institutions** (colleges with the most members, top 6)

#### 🔍 Browse Projects (`/projects`)
- Paginated project listing (12 per page)
- **Search** by project name or description
- **Filter** by: Tag, Course, Subject, Algorithm, College
- **Sort** by: Latest (default) or Most Liked
- Query string preserved across pagination

#### 📄 Project Detail Page (`/projects/{slug}`)
- Full project info: title, description, cover image, tags
- GitHub Repo and Live Demo links
- **File Downloads**:
  - Single file: served directly
  - Multiple files: packaged into a **ZIP archive** on-the-fly, organised into `documentation/` and `source_code/` subfolders
  - Download counter incremented on each download
- **Academic Context** section: Course, Subject, Algorithms implemented
- **Sidebar**: Submitter info, College link, Team(s), visibility, view & download counts
- **View counter** incremented on each page visit
- **Like / Unlike** button (AJAX, requires login) with live like count update
- **Edit Project** button visible to the project author only
- **Comments & Discussion** section:
  - Post comments (logged-in users)
  - Reply to comments (nested, one level)
  - Edit own comments / replies
  - Delete own comments / replies (admins can delete any)
- **Related Projects** section (same course or subject, up to 3)

#### 🏫 Colleges (`/colleges`, `/colleges/{id}`)
- Paginated college listing with search and university filter
- College profile page with:
  - College details (name, address, website, social links)
  - Associated university
  - **Innovators** (members) from the college with pagination
  - **Projects** from the college with search, filter (course, subject, algorithm), sort (latest/popular/oldest), and pagination
  - Total likes count across all college projects

#### 👤 User Profile (`/users/{user}`)
- Public profile page for each student
- Displays profile image, bio, contact, and social links

#### 🔗 Teams (`/teams/{team}`)
- Public team profile page

---

### Client (Student) Portal

Access via `/client/*` — requires student registration/login.

#### 🔐 Authentication
- Register (`/client/register`) and Login (`/client/login`)
- Session-based auth using the `client` guard
- Secure logout

#### 📊 Dashboard (`/client/dashboard`)
- **Statistics cards**: Total projects, Total likes received, Total files uploaded, Public vs Private project counts
- **Recent Projects** table showing the 5 latest projects with like counts

#### 📁 Project Management (`/client/projects`)
- **List** all projects the user owns or is a member of (via team membership)
- **Create Project** (`/client/projects/create`):
  - Project title, description
  - GitHub URL, Live Demo URL
  - Cover image upload (JPG/PNG/GIF, max 2 MB)
  - Technology / Tags selection (multi-select)
  - Course selection (dynamic Subject population via AJAX)
  - Subject selection (auto-loaded based on selected course)
  - Related Algorithms selection (multi-select)
  - Team assignment (multi-select)
  - **Documentation Files** upload (PDF, DOC, DOCX, PPT, PPTX — multiple, max 20 MB each — optional)
  - **Source Code Files** upload (ZIP, RAR, 7Z — multiple, max 20 MB each — optional)
  - Live file list preview (name + size) shown after selection
  - Public / Private visibility toggle
- **Edit Project** (`/client/projects/{id}/edit`):
  - All fields editable
  - Add new documentation or source code files
  - Delete existing files individually
- **Delete Project** — removes all associated files from storage
- **View** own projects (redirects to the public project show page)

#### 👥 Team Management (`/client/teams`)
- **Create / Edit / Delete** teams
- Team details: name, description, logo, website, social links
- **Invite members** to a team by user
- **Remove members** from a team
- **Team Invitations** (`/client/invitations`): view pending invitations and accept/decline them

#### 🧑‍💻 Profile Management (`/profile`)
- Edit name, email, phone, address, city, state, country
- Social links: website, Facebook, Twitter, Instagram, YouTube, LinkedIn, GitHub
- Bio/description
- Profile image upload
- College affiliation
- Account deletion

---

### Admin Panel

Access via `/admin/*` — separate `admin` guard with admin-only login.

#### 📊 Dashboard
- Platform-wide statistics overview

#### 👤 User Management (`/admin/users`)
- DataTables-powered user listing with search and pagination
- Create, edit, soft-delete users
- Assign roles to users

#### 🔑 Roles (`/admin/roles`)
- Create and manage roles assigned to users

#### 📁 Project Management (`/admin/projects`)
- View all submitted projects
- DataTables listing with project detail view
- Approve/manage project visibility and status

#### 🏫 Colleges (`/admin/colleges`)
- Full CRUD with soft-delete
- Link colleges to universities
- DataTables-powered listing

#### 🏛️ Universities (`/admin/universities`)
- Full CRUD with soft-delete
- Slug-based identification
- DataTables-powered listing

#### 📚 Courses (`/admin/courses`)
- Full CRUD with soft-delete
- Courses are linked to subjects and projects
- DataTables-powered listing

#### 📖 Subjects (`/admin/subjects`)
- Full CRUD with soft-delete
- Subjects belong to courses
- DataTables-powered listing

#### 🤖 Algorithms (`/admin/algorithms`)
- Full CRUD with soft-delete (slug-based)
- Linked to Algorithm Categories and Tags
- Resource URL and key fields

#### 🔖 Algorithm Categories (`/admin/algorithm-categories`)
- Full CRUD with soft-delete
- Groups related algorithms

#### 🏷️ Algorithm Tags (`/admin/algorithm-tags`)
- Full CRUD with soft-delete
- Tags specific to algorithms (separate from project tags)

#### 🏷️ Tags (`/admin/tags`)
- Full CRUD with soft-delete
- Technology tags used to label projects
- DataTables-powered listing

#### ⚙️ System Settings (`/admin/system-settings`)
- Configure **platform name** and **logo**
- Settings are loaded globally via a helper and shared to all views

#### 📋 System Info (`/admin/system-infos`)
- Manage system information entries (key-value style)

---

## Database Structure

### Core Tables

| Table | Description |
|---|---|
| `users` | Students with profile data, college, role, social links, soft-deleted |
| `admins` | Admin accounts (separate from users) |
| `roles` | User roles |
| `colleges` | College profiles, linked to universities |
| `universities` | University profiles |
| `projects` | Projects with slug, status, visibility, views, downloads, soft-deleted |
| `project_files` | Files attached to projects; `file_category` = `documentation` or `source_code` |
| `project_tag` | Many-to-many: projects ↔ tags |
| `project_likes` | Many-to-many: users who liked projects |
| `project_team` | Many-to-many: projects ↔ teams |
| `project_algorithm` | Many-to-many: projects ↔ algorithms |
| `comments` | Nested comments on projects (`parent_id` for replies) |
| `teams` | Student teams with social links |
| `team_members` | Team membership with approval status |
| `followers` | User follow relationships |
| `tags` | Technology/topic tags |
| `courses` | Academic courses |
| `subjects` | Subjects belonging to courses |
| `algorithms` | Algorithms with categories and tags |
| `algorithm_categories` | Algorithm groupings |
| `algorithm_tags` | Algorithm-specific tags |
| `system_info` | Platform configuration (name, logo, etc.) |
| `menus` | Navigation menu entries |

---

## Installation & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL (or SQLite for development)

### Quick Setup

```bash
# 1. Clone the repository
git clone <repository-url> ProjectSanjal
cd ProjectSanjal

# 2. Run the full setup script (installs deps, generates key, migrates, builds assets)
composer run setup
```

### Manual Setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate application key
php artisan key:generate

# 4. Configure your database in .env, then run migrations
php artisan migrate

# 5. Create the storage symlink
php artisan storage:link

# 6. Install Node dependencies and build assets
npm install
npm run build
```

---

## Running the Application

```bash
# Start all services concurrently (server + queue + vite hot reload)
composer run dev
```

This starts:
- **PHP dev server** on `http://127.0.0.1:8000`
- **Queue worker** (for background jobs)
- **Vite** (hot module replacement for assets)

Or run them individually:
```bash
php artisan serve          # Laravel dev server
php artisan queue:listen   # Queue worker
npm run dev                # Vite HMR
```

### Default Access URLs

| Portal | URL |
|---|---|
| Public Homepage | `http://127.0.0.1:8000/` |
| Browse Projects | `http://127.0.0.1:8000/projects` |
| Student Login | `http://127.0.0.1:8000/client/login` |
| Student Register | `http://127.0.0.1:8000/client/register` |
| Student Dashboard | `http://127.0.0.1:8000/client/dashboard` |
| Admin Login | `http://127.0.0.1:8000/admin/login` |
| Admin Dashboard | `http://127.0.0.1:8000/admin/dashboard` |

---

## Project Structure

```
ProjectSanjal/
├── app/
│   ├── Helpers/                    # Global helpers (SystemInfo, etc.)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Admin panel controllers
│   │   │   ├── Auth/               # Client auth controllers
│   │   │   ├── Client/             # Client portal controllers
│   │   │   ├── CollegeController.php
│   │   │   ├── CommentController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── ProjectController.php   # Public project browse/download
│   │   │   ├── TeamController.php
│   │   │   └── UserController.php
│   │   └── Requests/
│   └── Models/                     # Eloquent models
├── database/
│   ├── migrations/                 # 42 migrations
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── admin/                  # Admin panel views
│   │   ├── client/                 # Client portal views
│   │   │   └── projects/           # create, edit, index, show
│   │   ├── colleges/               # Public college pages
│   │   ├── components/             # Reusable Blade components
│   │   ├── layouts/                # App layouts
│   │   ├── profile/                # Profile edit views
│   │   ├── projects/               # Public project pages
│   │   ├── teams/                  # Public team pages
│   │   └── users/                  # Public user profile pages
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                     # Public routes
│   ├── client.web.php              # Client portal routes
│   ├── admin.web.php               # Admin panel routes
│   └── auth.php                    # Auth routes
└── storage/
    └── app/public/
        ├── projects/               # Cover images
        ├── project_files/
        │   ├── documentation/      # PDF, DOC, DOCX, PPT, PPTX
        │   └── source/             # ZIP, RAR, 7Z
        └── profile_images/
```

---

## Environment Variables

Key variables to configure in your `.env` file:

```env
APP_NAME=ProjectSanjal
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_sanjal
DB_USERNAME=root
DB_PASSWORD=

# File storage
FILESYSTEM_DISK=public

# Mail (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

---

## File Upload Rules

| Category | Accepted Formats | Max Size |
|---|---|---|
| Cover Image | JPG, PNG, GIF, WEBP | 2 MB |
| Documentation | PDF, DOC, DOCX, PPT, PPTX | 20 MB per file |
| Source Code | ZIP, RAR, 7Z | 20 MB per file |

- Both documentation and source code uploads are **optional**
- **Multiple files** can be uploaded in each category
- When downloading a project with multiple files, they are **automatically zipped** with files organized into subfolders by category

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
