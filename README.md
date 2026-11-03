# 🎓 Zakovat — Advanced Intellectual Quiz & Question Platform

<p align="center">
  <a href="https://zakovat-ktmg.onrender.com"><b>🌐 Live Demo: zakovat-ktmg.onrender.com</b></a> •
  <a href="https://t.me/zakovat_savol_007_bot"><b>🤖 Telegram Bot: @zakovat_savol_007_bot</b></a>
</p>

<p align="center">
  <a href="README.md">🇬🇧 English Version</a> •
  <a href="README.de.md">🇩🇪 Deutsche Version (Ausbildung-Portfolio)</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/Yii2-Advanced%20MVC-0073AA?style=for-the-badge&logo=yii&logoColor=white" alt="Yii2" />
  <img src="https://img.shields.io/badge/MySQL-CleverCloud%20InnoDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Telegram_Bot-24%2F7%20Webhook-2CA5E0?style=for-the-badge&logo=telegram&logoColor=white" alt="Telegram Bot" />
  <img src="https://img.shields.io/badge/Docker-Production%20Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker" />
  <img src="https://img.shields.io/badge/Deployment-Render.com-46E3B7?style=for-the-badge&logo=render&logoColor=black" alt="Render" />
  <img src="https://img.shields.io/badge/License-MIT-success?style=for-the-badge" alt="License" />
</p>

---

## 📌 Live Deployments

| Component | Description | Live URL |
| :--- | :--- | :--- |
| 🌐 **Main Web Application** | Interactive quiz games, category selection, and user profiles | [zakovat-ktmg.onrender.com](https://zakovat-ktmg.onrender.com) |
| 👑 **Admin Dashboard** | Question management, live filters, CSV import/export & user control | [zakovat-ktmg.onrender.com/admin](https://zakovat-ktmg.onrender.com/admin) |
| 🤖 **Telegram Bot (24/7)** | Autonomous knowledge bot, native Quiz Polls, and daily challenges | [@zakovat_savol_007_bot](https://t.me/zakovat_savol_007_bot) |
| ☁️ **Cloud Database** | High-performance managed MySQL 8 with InnoDB on Clever Cloud | `Clever Cloud Paris (EU)` |

> [!NOTE]
> **Hosting & Cold Start Notice:**  
> The web application is hosted on Render.com's Free Tier. To conserve resources, free instances spin down after periods of inactivity. If the service has been idle, the initial request may take **30–50 seconds** while the Docker container wakes up ("cold start"). Subsequent requests will load instantaneously.

---

## 📖 Project Overview & Purpose

**Zakovat** is a full-stack intellectual quiz and question platform designed to evaluate user knowledge, stimulate analytical thinking, and host competitive intellectual challenges across multiple disciplines (History, Science, IT, Literature, Logic).

Built on the **Yii2 Advanced** architecture, this project serves as a comprehensive portfolio application demonstrating real-world backend engineering skills, clean MVC structure, secure database modeling, containerization, and cloud deployment.

---

## 💡 Individual Contributions & Core Engineering Competencies

This project was built to demonstrate deep practical understanding of software engineering fundamentals:

### 1. 🏗️ Multi-Tier Architecture & Clean MVC
- **Separation of Concerns:**
  - `frontend/`: User-facing views, responsive quiz interfaces, and authentication.
  - `backend/`: Restricted administrative dashboard secured by Role-Based Access Control (RBAC).
  - `common/`: Core shared models (`ActiveRecord`), business logic, and reusable Telegram API components.
  - `console/`: Background daemons, webhook setup utilities, and CLI long-polling tools.

### 2. 🤖 Autonomous Telegram Bot Ecosystem (`common/components/TelegramBot.php`)
- **Custom API Component:** Built a standalone, zero-dependency cURL wrapper interacting directly with the official Telegram Bot API.
- **Webhook & Polling Dual-Mode:**
  - *Webhook (Production):* Handles incoming HTTP POST payloads asynchronously on Render.com with dedicated CSRF handling and JSON validation.
  - *Polling Daemon (CLI):* Enables local debugging via `php yii telegram/poll`.
- **Native Quiz Polls:** Utilizes Telegram’s native `sendPoll (type: quiz)` API with real-time answer verification and instant explanations.
- **Stateful Callback Queries:** Interactive Inline Keyboards enabling dynamic pagination, category browsing, and instant answer reveals.

### 3. 📊 Enterprise Admin Panel with Dynamic Filtering & CSV Engine
- **Search & Filtering Engine (`QuestionSearch`, `UserSearch`):** Parameterized `ActiveDataProvider` queries preventing SQL injection while supporting debounced live search and multi-criteria dropdown filters (Category, Type, Difficulty, Status).
- **High-Performance CSV Engine:**
  - Bulk import and export supporting hundreds of records in seconds.
  - Automatic UTF-8 BOM detection, sanitization, and category resolving.
  - Auto-generation of new categories with URL-friendly slugs on the fly.

### 4. 🧠 Dual Interactive Quiz Engines
- **Zakovat Mode (Open Question):** 60-second SVG circular countdown timer ("Ring of Knowledge") with timed answer reveal for team or solo brainstorming.
- **Choice Quiz Mode (Multiple Choice):** Real-time 4-option single-choice engine with instant feedback and scoring.

### 5. 🐳 Cloud-Native Docker & Unified VirtualHost Architecture
- **Multi-App Single Container Routing (`apache-zakovat.conf`):** Custom Apache virtual host configuration enabling the root URL `/` to serve the Frontend application while routing `/admin` to the Backend application within a single lightweight Render web service.
- **Production Automation:** Automated `composer install --optimize-autoloader`, `php init --env=Production`, and enabled MySQL schema caching (`enableSchemaCache => true`) for ultra-low database query overhead.

---

## 🤖 AI-Assisted Development & Engineering Transparency

In modern software engineering, AI is a powerful productivity amplifier. This project transparently highlights how AI was leveraged alongside core individual engineering:

| Domain | Human Developer Ownership | AI Tooling Assistance |
| :--- | :--- | :--- |
| **Architecture & Database** | Designed the multi-tier schema (`user`, `category`, `question`, `site_setting`), foreign key constraints, and RBAC security rules. | Assisted in formatting schemas and drafting initial migration templates. |
| **Business Logic & Core Code** | Implemented controller actions, CSV parsing algorithms, Webhook handling, and understands every line in depth. | Accelerated repetitive boilerplate code generation and syntax refinement. |
| **UI/UX & Styling** | Structured the user flows, responsive layout, and design system. | Generated modern CSS gradients, glassmorphism card styling, and SVG timer animations. |
| **Content & Testing** | Defined question categorization, difficulty weighting, and educational structure. | Generated diverse initial test question datasets for demonstration. |
| **Debugging & Problem Solving** | Diagnosed 404 routing anomalies on Render.com, adjusted Apache Rewrite rules, and fixed webhook update loops. | Provided quick reference syntax checks for Apache directives and Dockerfile best practices. |

> **Takeaway:** I have a comprehensive grasp of this entire codebase and can confidently explain, refactor, or extend any part of it during technical interviews. AI was used as a productivity enhancer, never as a substitute for technical competence.

---

## 🛡️ Security & Quality Standards

- **SQL Injection Prevention:** Strictly relies on Yii2 `ActiveRecord` and PDO Prepared Statements.
- **XSS Mitigation:** Universal data sanitization and output escaping via `Html::encode()`.
- **CSRF Protection:** Enabled on all user-facing state-changing HTTP forms, with safe, deliberate exemption for the external Telegram Webhook endpoint.
- **Role-Based Access Control (RBAC):** Dedicated access control filters preventing unauthorized access to the admin panel.
- **12-Factor App Compliance:** Zero hardcoded production credentials in version control; environment variables (`getenv`) are used for DB hosts, credentials, and bot tokens.

---

## 🏗️ System Architecture & Data Flow

```
                         ┌────────────────────────────────────┐
                         │   User / Web Browser & Telegram    │
                         └─────────────────┬──────────────────┘
                                           │ HTTPS (Port 443)
                                           ▼
                         ┌────────────────────────────────────┐
                         │   Render.com Web Service (Docker)  │
                         │   PHP 8.2 + Apache2 (mod_rewrite)  │
                         └────────┬───────────────────┬───────┘
                                  │                   │
         ┌────────────────────────┴───────┐   ┌───────┴────────────────────────┐
         ▼                                ▼   ▼                                ▼
┌──────────────────┐    ┌──────────────────┐  ┌────────────────────────────────┐
│ / (Frontend Web) │    │  /admin (Backend)│  │ /telegram/webhook (Controller) │
│ - Quiz & Test UI │    │  - Questions CRUD│  └──────────────▲─────────────────┘
│ - Profil & Auth  │    │  - CSV Engine    │                 │ JSON Webhook Updates
└────────┬─────────┘    └────────┬─────────┘  ┌──────────────┴─────────────────┐
         │                       │            │    Official Telegram API       │
         └───────────────┬───────┘            │   (@zakovat_savol_007_bot)     │
                         │                    └────────────────────────────────┘
                         ▼
        ┌──────────────────────────────────┐
        │   Clever Cloud MySQL 8 (InnoDB)  │
        │  Tables: user, category,         │
        │  question, site_setting          │
        └──────────────────────────────────┘
```

---

## 🗄️ Relational Database Schema (ER-Design)

| Table | Key Columns | Description |
| :--- | :--- | :--- |
| **`user`** | `id`, `username`, `email`, `password_hash`, `role`, `status`, `created_at` | Authenticated users and administrators |
| **`category`** | `id`, `name`, `slug`, `icon`, `status`, `created_at` | Question subjects (History, Science, IT, etc.) |
| **`question`** | `id`, `category_id`, `type`, `question_text`, `answer`, `option_a..d`, `correct_option`, `difficulty`, `status` | Repository of open-ended and 4-choice questions |
| **`site_setting`**| `id`, `key`, `value`, `description`, `updated_at` | Dynamic portal settings and metadata |

---

## 💻 Local Setup Guide

Requirements: PHP 8.2+, Composer, MySQL.

```bash
# 1. Clone the repository
git clone https://github.com/sardorergashev09uzb-commits/zakovat.git
cd zakovat

# 2. Install dependencies
composer install

# 3. Initialize environment (Development)
php init --env=Development

# 4. Configure local DB in common/config/main-local.php
# 5. Run database migrations
php yii migrate

# 6. Test Telegram Bot in local polling mode (optional)
php yii telegram/poll
```

---

## 👨‍💻 Developer Profile

- **Developer:** **Sardorbek Ergashev**
- **GitHub:** [@sardorergashev09uzb-commits](https://github.com/sardorergashev09uzb-commits)
- **Target Opportunity:** Apprenticeship / Ausbildung as *Fachinformatiker für Anwendungsentwicklung*
- **Core Skills:** PHP 8.2+, Yii2 / Laravel concepts, MySQL Relational Database Design, REST / Webhooks, Docker, Clean Code & Security.

---

<p align="center">
  <b>© 2026 Zakovat Platform • Built with passion for clean software architecture and modern web engineering.</b>
</p>
