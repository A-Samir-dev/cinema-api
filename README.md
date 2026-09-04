# 🎬 Cinema Management System

A full-stack Laravel application for managing a cinema's movie collection, built with a Blade-based admin dashboard and a RESTful API for mobile app integration.

## Overview

This project consists of two main parts:

1. **Admin Dashboard (Laravel Blade)** — allows the cinema admin to manage the movie catalog: add, view, edit, and delete movies, with authentication and role-based access.
2. **REST API (Laravel API)** — allows a mobile application to browse movies and manage a device-based watchlist, without requiring user login.

---

## Features

### Admin Dashboard
- ✅ Full CRUD for movies (Add / View / Edit / Delete)
- ✅ Authentication (Login) protected by an Admin middleware (RBAC)
- ✅ Search, filter (title, year, rating) and pagination
- ✅ Soft Deletes with a Trash Bin (restore / permanently delete)
- ✅ Dashboard statistics (total movies, average rating)
- ✅ AI-powered description generator (Google Gemini API) when adding/editing a movie

### REST API (for mobile team)
- ✅ `GET /api/movies` — list all movies (search, filter, pagination)
- ✅ `GET /api/movies/{id}` — movie details + similar movies
- ✅ `POST /api/watchlist` — add a movie to a device's watchlist (duplicate prevention)
- ✅ `GET /api/watchlist?device_id=...` — view a device's watchlist
- ✅ `DELETE /api/watchlist` — remove a movie from the watchlist
- ✅ Consistent JSON response format (`status`, `message`, `data`) across all endpoints
- ✅ Validation handled via Form Request classes
- ✅ Responses formatted via API Resources

### Architecture
- Clean separation between `Admin` controllers (Blade) and `Api` controllers (JSON)
- Form Request classes for validation (`StoreMovieRequest`, `UpdateMovieRequest`, `StoreWatchlistRequest`, `DeleteWatchlistRequest`)
- API Resources for consistent JSON formatting (`MovieResource`, `WatchlistResource`)

---

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2
- **Database:** MySQL
- **Frontend (Admin):** Blade + Bootstrap 5
- **Auth:** Laravel Breeze
- **AI Integration:** Google Gemini API (`gemini-3.6-flash`)

---

## Entities

**Movie**
| Field | Type |
|---|---|
| id | bigint |
| title | string |
| description | text |
| release_year | smallint |
| rating | decimal(3,1) |
| image | string (nullable) |
| deleted_at | timestamp (soft delete) |

**Watchlist**
| Field | Type |
|---|---|
| id | bigint |
| device_id | string |
| movie_id | foreign key → movies |

> A unique constraint on `(device_id, movie_id)` prevents duplicate watchlist entries.

---

## Setup Instructions

### 1. Requirements
- PHP >= 8.2
- Composer
- MySQL (e.g. via XAMPP)

### 2. Install dependencies
```bash
composer install
```

### 3. Environment setup
Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```

Update the database settings in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cinema_db
DB_USERNAME=root
DB_PASSWORD=
```

(Optional) Add a Gemini API key to enable the AI description generator:
```env
GEMINI_API_KEY=your_gemini_api_key_here
```

### 4. Generate app key
```bash
php artisan key:generate
```

### 5. Run migrations and seed the database
```bash
php artisan migrate:fresh --seed
```
This creates the tables and seeds 15 real movies plus a default admin account:
- **Email:** `admin@cinema.com`
- **Password:** `password123`

### 6. Link storage (for movie posters)
```bash
php artisan storage:link
```

### 7. Run the server
```bash
php artisan serve
```

The app will be available at: `http://127.0.0.1:8000`

---

## Usage

### Admin Dashboard
| Page | URL |
|---|---|
| Login | `http://127.0.0.1:8000/login` |
| Dashboard | `http://127.0.0.1:8000/admin/dashboard` |
| Movies List | `http://127.0.0.1:8000/admin/movies` |
| Add Movie | `http://127.0.0.1:8000/admin/movies/create` |
| Trash Bin | `http://127.0.0.1:8000/admin/movies/trash` |

> Only accounts with `is_admin = true` can access `/admin/*` routes. Any other authenticated user will receive a `403 Unauthorized`.

### API Endpoints

Base URL: `http://127.0.0.1:8000/api`

#### 1. List Movies
```
GET /api/movies?search=inception&year=2010&rating=8
```

#### 2. Movie Details
```
GET /api/movies/{id}
```

#### 3. Add to Watchlist
```
POST /api/watchlist
Content-Type: application/json

{
  "device_id": "device-abc-123",
  "movie_id": 1
}
```

#### 4. View Watchlist
```
GET /api/watchlist?device_id=device-abc-123
```

#### 5. Remove from Watchlist
```
DELETE /api/watchlist
Content-Type: application/json

{
  "device_id": "device-abc-123",
  "movie_id": 1
}
```

**Example response format (all endpoints):**
```json
{
  "status": true,
  "message": "Movies fetched successfully",
  "data": { ... }
}
```

---

## Notes for Reviewers

- The `vendor/` folder is excluded from this submission — run `composer install` to restore it.
- The database is seeded automatically with real movie data (no Lorem Ipsum) via `php artisan migrate:fresh --seed`.
- A Postman collection is included for testing the API endpoints directly (see `postman_collection.json` if attached).

---


# 🎬 نظام إدارة السينما (Cinema Management System)

مشروع Full-Stack باستخدام Laravel لإدارة مجموعة أفلام سينما، مبني من جزئين: لوحة تحكم للأدمن (Laravel Blade) و REST API لفريق تطبيق الموبايل.

## نظرة عامة

المشروع مقسوم لجزئين رئيسيين:

1. **لوحة تحكم الأدمن (Laravel Blade)** — تتيح للأدمن إدارة الأفلام: إضافة، عرض، تعديل، حذف، مع نظام تسجيل دخول وصلاحيات.
2. **الـ REST API** — يتيح لتطبيق الموبايل عرض الأفلام وإدارة قائمة مشاهدة (Watchlist) مرتبطة بجهاز المستخدم من غير الحاجة لتسجيل دخول.

---

## الفيتشرز

### لوحة تحكم الأدمن
- ✅ CRUD كامل للأفلام (إضافة / عرض / تعديل / حذف)
- ✅ تسجيل دخول محمي بصلاحيات أدمن (RBAC)
- ✅ بحث وفلترة (بالاسم، السنة، التقييم) + Pagination
- ✅ حذف مؤقت (Soft Delete) مع سلة مهملات (استرجاع / حذف نهائي)
- ✅ صفحة إحصائيات (عدد الأفلام، متوسط التقييم)
- ✅ توليد وصف الفيلم تلقائيًا بالذكاء الاصطناعي (Google Gemini API)

### الـ API (لفريق الموبايل)
- ✅ `GET /api/movies` — عرض كل الأفلام (بحث، فلترة، pagination)
- ✅ `GET /api/movies/{id}` — تفاصيل فيلم + أفلام مشابهة
- ✅ `POST /api/watchlist` — إضافة فيلم لقائمة مشاهدة الجهاز (مع منع التكرار)
- ✅ `GET /api/watchlist?device_id=...` — عرض قائمة مشاهدة جهاز معين
- ✅ `DELETE /api/watchlist` — حذف فيلم من القائمة
- ✅ شكل استجابة موحّد (`status`, `message`, `data`) في كل الـ endpoints
- ✅ الـ Validation عن طريق Form Request classes منفصلة
- ✅ تنسيق الاستجابات عن طريق API Resources

### الـ Architecture
- فصل واضح بين الـ Controllers الخاصة بالأدمن (`Admin`) والخاصة بالـ API (`Api`)
- Form Requests للتحقق (`StoreMovieRequest`, `UpdateMovieRequest`, `StoreWatchlistRequest`, `DeleteWatchlistRequest`)
- API Resources لتوحيد شكل الـ JSON (`MovieResource`, `WatchlistResource`)

---

## التقنيات المستخدمة

- **Backend:** Laravel 12, PHP 8.2
- **Database:** MySQL
- **Frontend (Admin):** Blade + Bootstrap 5
- **Auth:** Laravel Breeze
- **AI:** Google Gemini API (`gemini-3.6-flash`)

---

## الكيانات (Entities)

**Movie**
| الحقل | النوع |
|---|---|
| id | bigint |
| title | string |
| description | text |
| release_year | smallint |
| rating | decimal(3,1) |
| image | string (nullable) |
| deleted_at | timestamp (soft delete) |

**Watchlist**
| الحقل | النوع |
|---|---|
| id | bigint |
| device_id | string |
| movie_id | foreign key → movies |

> فيه unique constraint على `(device_id, movie_id)` بيمنع تكرار نفس الفيلم في نفس الـ watchlist.

---

## خطوات التشغيل

### 1. المتطلبات
- PHP >= 8.2
- Composer
- MySQL (زي XAMPP مثلاً)

### 2. تثبيت المكتبات
```bash
composer install
```

### 3. إعداد ملف الـ .env
```bash
cp .env.example .env
```

عدّل بيانات الداتابيز في `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cinema_db
DB_USERNAME=root
DB_PASSWORD=
```

(اختياري) ضيف مفتاح Gemini API لتفعيل توليد الوصف بالذكاء الاصطناعي:
```env
GEMINI_API_KEY=your_gemini_api_key_here
```

### 4. توليد مفتاح التطبيق
```bash
php artisan key:generate
```

### 5. تشغيل الـ Migrations وتعبئة البيانات
```bash
php artisan migrate:fresh --seed
```
الأمر ده بينشئ الجداول ويحشي الداتابيز بـ 15 فيلم حقيقي، وبيعمل حساب أدمن جاهز:
- **الإيميل:** `admin@cinema.com`
- **الباسورد:** `password123`

### 6. ربط الـ Storage (لصور الأفلام)
```bash
php artisan storage:link
```

### 7. تشغيل السيرفر
```bash
php artisan serve
```

المشروع هيشتغل على: `http://127.0.0.1:8000`

---

## الاستخدام

### لوحة تحكم الأدمن
| الصفحة | الرابط |
|---|---|
| تسجيل الدخول | `http://127.0.0.1:8000/login` |
| الداشبورد | `http://127.0.0.1:8000/admin/dashboard` |
| قائمة الأفلام | `http://127.0.0.1:8000/admin/movies` |
| إضافة فيلم | `http://127.0.0.1:8000/admin/movies/create` |
| سلة المهملات | `http://127.0.0.1:8000/admin/movies/trash` |

> بس الحسابات اللي `is_admin = true` تقدر تدخل على `/admin/*`. أي حساب تاني هياخد `403 Unauthorized`.

### الـ API Endpoints

الرابط الأساسي: `http://127.0.0.1:8000/api`

#### 1. عرض كل الأفلام
```
GET /api/movies?search=inception&year=2010&rating=8
```

#### 2. تفاصيل فيلم
```
GET /api/movies/{id}
```

#### 3. إضافة لقائمة المشاهدة
```
POST /api/watchlist
Content-Type: application/json

{
  "device_id": "device-abc-123",
  "movie_id": 1
}
```

#### 4. عرض قائمة المشاهدة
```
GET /api/watchlist?device_id=device-abc-123
```

#### 5. حذف من قائمة المشاهدة
```
DELETE /api/watchlist
Content-Type: application/json

{
  "device_id": "device-abc-123",
  "movie_id": 1
}
```

**شكل الاستجابة (لكل الـ endpoints):**
```json
{
  "status": true,
  "message": "Movies fetched successfully",
  "data": { ... }
}
```

---

## ملاحظات لمراجعي المشروع

- فولدر `vendor/` متشال من التسليم — شغّل `composer install` عشان يترجع.
- الداتابيز بتتحشى تلقائيًا ببيانات أفلام حقيقية (مش Lorem Ipsum) عن طريق `php artisan migrate:fresh --seed`.
- فيه Postman Collection مرفقة لتجربة الـ API مباشرة (لو مرفوعة، هتلاقيها في ملف `postman_collection.json`).
