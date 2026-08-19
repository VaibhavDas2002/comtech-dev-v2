# Project Brain: comtech-dev

A centralized reference and active memory bank for the **Comtech Information Services (Sales)** & **Comtech Infosys (Service)** full-stack modern application.

---

## 1. Business Identity & Overview

- **Sales Division:** Comtech Information Services
- **Service Division:** Comtech Infosys
- **Location:** Beside A.B.T.A Building, New DangalPara, Suri, Birbhum, West Bengal, India – 731101
- **Phones:** +91 94341 97268 (Sales) | +91 94743 06951 (Service) | 03462-255555
- **Emails:** sales@comtechis.in | service@comtechinfosys.in | info@comtechis.in
- **Business Scope:**
  1. CCTV Surveillance Systems (Hikvision & CP Plus HD/IP, DVR/NVR, ColorVu Night Vision)
  2. Tally Prime Sales, Licensing, Custom TDL & Support (Certified Partner)
  3. Chip-Level Laptop, Desktop & Printer Motherboard Lab
  4. Custom Website & Web Application Development
  5. Antivirus & Enterprise Cybersecurity (Quick Heal, Seqrite, Kaspersky)
  6. Corporate IT AMC, Structured Fiber Networking & Server Deployments

---

## 2. Tech Stack & Architecture

### Backend
- **Framework:** Laravel 13.x (PHP 8.3+ / 8.4)
- **Database:** PostgreSQL (production/dev) / SQLite supported
- **Authentication:** Laravel Fortify (2FA, Passkeys, Session Guard)
- **Reactive Engine:** Livewire 4.x
- **UI Components:** Livewire Flux UI & Tailwind CSS v4
- **API Layer:** REST APIs with full JSON resources & pagination

### Frontend
- **Design:** Modern glassmorphism, responsive mobile-first, dark/light theme
- **Icons & Typography:** Font Awesome 6.5, Heroicons, Outfit & Plus Jakarta Sans
- **Interactive Widgets:** Sticky call & WhatsApp widgets, interactive Google Maps embed, Livewire lead capture forms with instant ticket generation (`COM-XXXXXX`)

---

## 3. Database Schema & Models

1. **`services`** ([`Service`](file:///d:/Projects/comtech-dev/app/Models/Service.php)): Division (`sales`/`service`/`both`), title, slug, category, short & detailed description, features array, price, image, active & featured flags.
2. **`product_categories`** & **`products`** ([`Product`](file:///d:/Projects/comtech-dev/app/Models/Product.php), [`ProductCategory`](file:///d:/Projects/comtech-dev/app/Models/ProductCategory.php)): Hardware & software catalog with SKU, brand, pricing, discount, warranty, in-stock status, and gallery.
3. **`blog_categories`** & **`blogs`** ([`Blog`](file:///d:/Projects/comtech-dev/app/Models/Blog.php), [`BlogCategory`](file:///d:/Projects/comtech-dev/app/Models/BlogCategory.php)): Knowledge base, tutorials, tags, reading time, view counter, SEO meta fields.
4. **`promotions`** ([`Promotion`](file:///d:/Projects/comtech-dev/app/Models/Promotion.php)): Active discounts, bundle packages, validity periods, claim CTAs.
5. **`gallery_items`** ([`GalleryItem`](file:///d:/Projects/comtech-dev/app/Models/GalleryItem.php)): Real project photos, CCTV installations, network racks, showroom photos.
6. **`enquiries`** ([`Enquiry`](file:///d:/Projects/comtech-dev/app/Models/Enquiry.php)): Lead capture CRM tickets with status tracking (`pending`, `contacted`, `quoted`, `in_progress`, `resolved`, `cancelled`), urgency levels, admin internal notes, and direct WhatsApp links.
7. **`testimonials`** ([`Testimonial`](file:///d:/Projects/comtech-dev/app/Models/Testimonial.php)): Verified client reviews from Suri/Birbhum businesses.
8. **`site_settings`** ([`SiteSetting`](file:///d:/Projects/comtech-dev/app/Models/SiteSetting.php)): Centralized key-value store for contact information and address.

---

## 4. Application Routes

### Public Pages
- `GET /` — Home page with Hero, Service cards, Featured products, Testimonials, Promotions, and fast quote lead capture.
- `GET /about` — Company history, dual business model, mission/vision, infrastructure.
- `GET /services` — Categorized service catalog with live search and category filters.
- `GET /products` — Product catalog with brand & category filtering, search, and quote trigger.
- `GET /promotions` — Special offers & combo deals.
- `GET /gallery` — Photo gallery with Alpine.js lightbox zoom.
- `GET /blogs` — Blog listing with search and category filters.
- `GET /blogs/{slug}` — Full article reading view with related posts.
- `GET /contact` — Interactive contact page, enquiry ticket generator, and Suri Google Maps.

### Authenticated Admin Panel (`auth`, `verified`)
- `GET /dashboard` — Live KPI metrics, lead status summaries, quick actions, and recent enquiries.
- `GET /admin/enquiries` — Comprehensive Leads & Enquiries CRM with filters, internal notes, and WhatsApp chat.
- `GET /admin/services` — Full CRUD for IT services.
- `GET /admin/products` — Full CRUD for hardware/software products.
- `GET /admin/promotions` — Full CRUD for discount offers.
- `GET /admin/blogs` — Full CRUD for publishing knowledge articles.
- `GET /admin/gallery` — Manage gallery images and categories.
- `GET /admin/testimonials` — Manage customer reviews and ratings.

### REST API Endpoints (`/api/*` and `/api/v1/*`)
- `GET /api/services` & `GET /api/services/{slug}`
- `GET /api/products` & `GET /api/products/{slugOrId}`
- `GET /api/blogs` & `GET /api/blogs/{slug}`
- `GET /api/promotions`
- `GET /api/gallery`
- `GET /api/testimonials`
- `POST /api/enquiries` (Payload: `name`, `phone`, `email`, `type`, `subject`, `message`, `urgency`)

---

## 5. Development & Testing Commands

```bash
# Seed database with sample authentic Suri data
php artisan db:seed --no-interaction

# Run PHPUnit test suite (57 tests)
php artisan test --compact

# Format PHP code with Pint
vendor/bin/pint --format agent

# Build production frontend assets
npm.cmd run build

# Start local development server
composer run dev
```
