# Media TV (منصة ميديا تي في)

> **Integrated American TV Series & Anime Tracking Platform**  
> A bilingual, role-governed web application built with Laravel 11, Blade, and MySQL / SQLite for logging, tracking, and reviewing TV series, anime, and movies.

---

## 🌟 Overview

**Media TV** addresses catalog fragmentation and tracking fatigue across streaming services by providing a unified medium for:
- Exploring serialized TV shows (IMDb Top 250), Japanese Anime (Crunchyroll), and blockbuster movies.
- Tracking personal watchlist progression with per-episode logging.
- Community reviews and ratings.
- Native bilingual support for **Arabic (RTL)** and **English (LTR)** with dynamic locale switching.
- Multi-tiered **Role-Based Access Control (RBAC)** for Guests, Registered Users, Content Managers, and System Administrators.

---

## 🚀 Key Features

- **Personal Watchlists:** Categorize titles into `Plan to Watch`, `Watching`, `Completed`, `On Hold`, or `Dropped` with granular episode progress tracking.
- **Bilingual & Bidirectional (i18n):** Instant switching between Arabic (Right-to-Left) and English (Left-to-Right) layouts using CSS logical properties and localized language files.
- **Rating & Reviews System:** Submit 1–10 star scores and written reviews with moderation support.
- **Content Management Portal (`Manager`):** Dedicated dashboards to create, edit, and organize series, episode schedules, and bilingual genres.
- **Admin Control Center (`Admin`):** Comprehensive oversight dashboard to manage user accounts, assign roles, and monitor system metrics.
- **Responsive Layout:** Clean, decluttered design optimized across desktop, tablet, and mobile screens.

---

## 🛠️ Tech Stack

- **Backend:** PHP 8.2+ / 8.3+, Laravel 11.x (MVC Architecture, Eloquent ORM)
- **Frontend:** Laravel Blade, Vanilla CSS (Modular, RTL/LTR compatible), Vanilla ES6+ JavaScript
- **Database:** MySQL 8.x / SQLite
- **Asset Bundler:** Vite

---

## 📋 Prerequisites

Ensure you have the following installed on your machine:
- **PHP** >= 8.2 (with `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `curl`)
- **Composer** (Dependency manager for PHP)
- **Node.js** (v18+) and **npm**
- **Database Server:** MySQL 8.x or SQLite 3

---

## ⚙️ Installation & Setup Guide

Follow these steps to run the application locally:

### 1. Clone the Repository
```bash
git clone https://github.com/yo0sf/Media-TV.git
cd Media-TV
```

### 2. Install Backend Dependencies
```bash
composer install
```

### 3. Setup Environment File
Copy the example environment file and generate the application key:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database
Open your `.env` file and set up your database connection.

**Option A: SQLite (Quickest, no setup needed)**
```env
DB_CONNECTION=sqlite
```
*Note: Make sure `database/database.sqlite` exists (create an empty file if needed).*

**Option B: MySQL**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mediatv
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run Migrations and Seed Sample Data
Populate roles, genres, sample TV shows, anime, movies, and demo accounts:
```bash
php artisan migrate --seed
```

### 6. Install & Build Frontend Assets
```bash
npm install
npm run build
```
*(Alternatively, run `npm run dev` for local hot-reloading asset development).*

### 7. Start the Development Server
```bash
php artisan serve
```

Visit the application in your browser at:  
👉 **http://127.0.0.1:8000**

---

## 🔐 Default Demo Accounts

The database seeder automatically creates pre-configured accounts with sample data:

| Role | Email | Password | Access Level |
| :--- | :--- | :--- | :--- |
| **System Administrator** | `admin@mediatv.com` | `password123` | Full access (Admin dashboard, user management, role assignments) |
| **Content Manager** | `manager@mediatv.com` | `password123` | Manager portal, series & episode CRUD, genre management, review moderation |
| **Standard User** | `user@mediatv.com` | `password123` | Watchlist tracking, episode counters, review submission, profile |

*(Backwards-compatible legacy accounts `admin@anitrack.com`, `manager@anitrack.com`, and `user@anitrack.com` are also available with the same password).*

---

## 👥 User Roles & Permissions Matrix

| Feature / Action | Guest | Standard User | Content Manager | System Admin |
| :--- | :---: | :---: | :---: | :---: |
| Browse Catalog & Details | ✅ | ✅ | ✅ | ✅ |
| Search & Filter by Genre / Format | ✅ | ✅ | ✅ | ✅ |
| Switch Language (EN / AR RTL) | ✅ | ✅ | ✅ | ✅ |
| Add to Watchlist & Track Episodes | ❌ | ✅ | ✅ | ✅ |
| Post Ratings & Reviews | ❌ | ✅ | ✅ | ✅ |
| Manage Series & Episode Schedules | ❌ | ❌ | ✅ | ✅ |
| Moderate User Reviews | ❌ | ❌ | ✅ | ✅ |
| User Governance & Role Management | ❌ | ❌ | ❌ | ✅ |
| System Health Metrics Dashboard | ❌ | ❌ | ❌ | ✅ |

---

## 📁 Key Directory Structure

```text
app/
├── Http/
│   ├── Controllers/       # Catalog, Watchlist, Auth, Manager, Admin controllers
│   └── Middleware/        # EnsureUserRole, SetLocale (RTL/LTR switching)
├── Models/                # Series, Episode, Genre, Review, Watchlist, User, Role
lang/
├── ar/                    # Arabic translation strings
└── en/                    # English translation strings
resources/
├── views/
│   ├── admin/             # Admin dashboard & user management
│   ├── manager/           # Series, episode, genre & review management
│   ├── catalog/           # Public catalog & detailed series view
│   ├── watchlist/         # User watchlist interface
│   └── layouts/           # Master application layout (RTL & LTR dynamic styling)
database/
├── migrations/            # Relational database schema definitions
└── seeders/               # Pre-populated TV series, Anime, episodes & users
```

---

## 📄 License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
