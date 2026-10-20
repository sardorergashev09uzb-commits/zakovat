# 🎓 Zakovat — Advanced Intellectual Quiz & Question Platform

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

## 📌 Jonli Havolalar (Live Demos)

| Xizmat | Tavsif | Havola |
| :--- | :--- | :--- |
| 🌐 **Asosiy Veb-sayt** | Intellektual o'yinlar, testlar va foydalanuvchi profili | [zakovat-ktmg.onrender.com](https://zakovat-ktmg.onrender.com) |
| 👑 **Admin Boshqaruv Paneli** | Savollar, toifalar va foydalanuvchilar monitoringi | [zakovat-ktmg.onrender.com/admin](https://zakovat-ktmg.onrender.com/admin) |
| 🤖 **Telegram Bot (24/7)** | Savol-javob, Quiz Poll va kun savollari | [@zakovat_savol_007_bot](https://t.me/zakovat_savol_007_bot) |
| ☁️ **Bulutli Ma'lumotlar Bazasi** | Yuqori tezlikdagi Clever Cloud MySQL hosting | `Clever Cloud Paris (EU)` |

---

## 📖 Loyiha Haqida

**Zakovat** — foydalanuvchilarning intellektual salohiyatini sinash, bilim darajasini yuksaltirish va turli sohalar (Tarix, Fan, IT, Adabiyot, Mantiq) bo'yicha interaktiv bilim bellashuvlarini o'tkazish uchun noldan to'liq arxitekturasi ishlab chiqilgan zamonaviy veb-platforma va ekotizimdir.

Loyiha **Yii2 Advanced** arxitekturasi asosida ishlab chiqilgan bo'lib, o'zaro bog'langan 3 ta asosiy bo'g'indan iborat:
1. **Frontend:** Foydalanuvchilar uchun qulay, zamonaviy UI va 2 xil intellektual o'yin rejimi;
2. **Backend (Admin Panel):** Kuchli filtrlash, qidiruv, monitoring hamda ommaviy CSV import/eksport tizimi;
3. **Console & Daemon:** Telegram Bot uchun 24/7 Webhook integratsiyasi va lokal Polling daemon tizimi.

---

## 🚀 Mualliflik Yechimlari va Asosiy Imkoniyatlar (Key Features)

Ushbu platforma faqat shablon yechim emas, balki real ishlab chiqarish (production) talablariga mos ravishda dasturlangan:

### 1. 🧠 2 Xil Interaktiv O'yin Dvigateli (Game Engines)
- **💡 Zakovat Rejimi (Ochiq Mantiqiy Savol):**
  - Aniq 60 soniyalik aylanma animatsiyali SVG **"Bilim halqasi"** teskari taymeri;
  - Jamoaviy yoki yakkaxon fikrlash uchun qulay interfeys, vaqt tugagach yoki tugma bosilgach to'g'ri javobni tahlili bilan ko'rsatish.
- **📝 Variantli Test Rejimi (A, B, C, D Tanlovli Test):**
  - Foydalanuvchi variantni bosishi bilan real vaqtda to'g'ri/noto'g'ri natijani ko'rsatish;
  - Toifalar (fanlar) bo'yicha saralash va ballar statistikasini hisoblash.

### 2. 🤖 Avtonom Telegram Bot Ekotizimi (`@zakovat_savol_007_bot`)
- **Noldan yozilgan API Komponent:** `common/components/TelegramBot.php` yordamida cURL orqali to'g'ridan-to'g'ri Telegram Bot API bilan tezkor va xavfsiz ulanish.
- **2 xil rejimda ishlash:**
  - *Webhook (Production):* Render.com da 24/7 doimiy avtonom rejimda kiruvchi JSON yangilanishlarni qabul qilish.
  - *Polling Daemon (CLI):* Dasturchi kompyuterida qulay sinash uchun `php yii telegram/poll` CLI buyrug'i.
- **Native Quiz Polls:** Telegramning rasmiy `sendPoll (type: quiz)` mexanizmi orqali foydalanuvchiga to'g'ridan-to'g'ri test yuborish va javob izohini ko'rsatish.
- **Interaktiv Inline Keyboard:** Savollar o'rtasida navigatsiya qilish (`Next`, `Categories`, `Reveal Answer`).

### 3. 📊 Kuchli Boshqaruv Paneli (Admin Dashboard)
- **Keng Qamrovli Dinamik Qidiruv & Filtrlash:**
  - `QuestionSearch` va `UserSearch` modellari orqali toifalar, qiyinlik darajalari (Oson, O'rta, Qiyin), savol turlari va holati bo'yicha tezkor live-filtrlar.
  - Xavfsiz parametrlangan so'rovlar (`ActiveDataProvider`) orqali optimallashtirilgan SQL navigatsiyasi va pagination.
- **Ommaviy CSV Import va Eksport:**
  - Yuzlab savollarni bitta tugma orqali CSV formatda bazaga import qilish;
  - Fayldagi toifa nomlarini avtomatik tahlil qilish, mavjud bo'lmagan toifalarni avtomatik yaratish (`slug` va UTF-8 xavfsizligi bilan);
  - Adminlar uchun shablon CSV faylini yuklab olish imkoniyati.

### 4. 🐳 Docker & Production Arxitekturasi (Cloud-Native)
- **Yagona VirtualHost Arxitekturasi (`apache-zakovat.conf`):**
  - Render.com bitta konteynerida asosiy domenni `frontend/web` ga, `/admin` prefiksini esa to'g'ridan-to'g'ri `backend/web` ga uzluksiz yo'naltiruvchi maxsus Apache konfiguratsiyasi.
- **Production Init Avtomatizatsiyasi:** Docker build vaqtida `composer install --optimize-autoloader` va `php init --env=Production` orqali tizimni to'liq himoyalangan, kesh yoqilgan holatda ishga tushirish.
- **Database Schema Caching:** MySQL so'rovlarini 24 soatga keshlab, bazaga bo'ladigan yuklamani keskin kamaytirish.

### 5. 🛡️ Xavfsizlik va Arxitektura Standartlari
- **RBAC (Role-Based Access Control):** Admin va User rollari o'rtasida qat'iy ajratilgan huquqlar (Broken Access Control himoyasi).
- **SQL Injection Himoyasi:** Yii2 Active Record va PDO Prepared Statements.
- **XSS & CSRF Himoyasi:** Barcha ma'lumotlar chiqishida `Html::encode`, barcha formalarda CSRF token tekshiruvi.
- **Parollar Xavfsizligi:** Bcrypt algoritmi orqali ishonchli xeshirlangan parollar.

---

## 🏗️ Tizim Arxitekturasi

```
                             ┌─────────────────────────────────┐
                             │    Foydalanuvchi & Brauzer      │
                             └───────────────┬─────────────────┘
                                             │ HTTPS
                                             ▼
                             ┌─────────────────────────────────┐
                             │       Render.com Web Service    │
                             │   (Docker PHP 8.2 + Apache)     │
                             └───────┬─────────────────┬───────┘
                                     │                 │
             ┌───────────────────────┴──────┐   ┌──────┴────────────────────────┐
             ▼                              ▼   ▼                               ▼
  ┌──────────────────────┐   ┌──────────────────────┐   ┌───────────────────────────────┐
  │   / (Frontend Web)   │   │  /admin (Backend Web)│   │ /telegram/webhook (Controller)│
  │  - Zakovat Quiz UI   │   │  - Savollar CRUD     │   └───────────────▲───────────────┘
  │  - Test (A,B,C,D)    │   │  - CSV Import/Export │                   │ Webhook Updates
  │  - Profil & Auth     │   │  - User Management   │   ┌───────────────┴───────────────┐
  └──────────┬───────────┘   └──────────┬───────────┘   │     Telegram Bot API Server   │
             │                          │               │   (@zakovat_savol_007_bot)    │
             └──────────────────┬───────┘               └───────────────────────────────┘
                                │
                                ▼
             ┌──────────────────────────────────────┐
             │       Clever Cloud MySQL 8 (SSL)     │
             │  (user, category, question, setting) │
             └──────────────────────────────────────┘
```

---

## 🗄️ Ma'lumotlar Bazasi Sxemasi (ER-Model)

| Jadval | Asosiy Ustunlar | Maqsadi |
| :--- | :--- | :--- |
| **`user`** | `id`, `username`, `email`, `password_hash`, `role`, `status`, `created_at` | Foydalanuvchilar va administratorlar hisoblari |
| **`category`** | `id`, `name`, `slug`, `icon`, `status`, `created_at` | Savollar yo'nalishlari (Tarix, IT, Geografiya va h.k.) |
| **`question`** | `id`, `category_id`, `type`, `question_text`, `answer`, `option_a..d`, `correct_option`, `difficulty`, `status` | Ochiq va test formatidagi barcha savollar bazasi |
| **`site_setting`**| `id`, `key`, `value`, `description`, `updated_at` | Dinamik platforma sozlamalari va sarlavhalari |

---

## 💻 Mahalliy Muhitda O'rnatish (Local Setup)

Loyiha lokal kompyuterda (Laragon, XAMPP yoki Docker) tezda ishga tushadi:

### 1. Repositoriyani klonlash:
```bash
git clone https://github.com/sardorergashev09uzb-commits/zakovat.git
cd zakovat
```

### 2. Bog'liqliklarni o'rnatish:
```bash
composer install
```

### 3. Loyihani initsializatsiya qilish:
```bash
php init
# Rivojlantirish muhiti uchun: 0 (Development)
```

### 4. Ma'lumotlar bazasini ulash:
`common/config/main-local.php` faylida o'z lokal MySQL bazangizni ko'rsating:
```php
'components' => [
    'db' => [
        'class' => \yii\db\Connection::class,
        'dsn' => 'mysql:host=localhost;dbname=zakovat',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ],
],
```

### 5. Migratsiyalarni ishga tushirish:
```bash
php yii migrate
```

### 6. Telegram Botni sinash:
`common/config/params-local.php` ga bot tokeningizni kiriting va konsolda ishga tushiring:
```bash
php yii telegram/poll
```

---

## ⚡ CLI Konsol Buyruqlari

Adminlar va tizim uchun qulay boshqaruv buyruqlari tayyorlangan:

```bash
# Telegram Webhook manzilini o'rnatish
php yii telegram/set-webhook https://sizning-domen.uz/telegram/webhook

# Botni Polling rejimida uzluksiz ishga tushirish (lokal test uchun)
php yii telegram/poll

# Istalgan chat yoki kanalga kun savolini yuborish
php yii telegram/daily-question @chat_yoki_id

# Bot ishlayotganini tekshirish uchun test xabari yuborish
php yii telegram/test @chat_yoki_id
```

---

## 👨‍💻 Muallif & Portfolio

- **Muallif va Arxitektor:** **Sardorbek Ergashev**
- **GitHub:** [@sardorergashev09uzb-commits](https://github.com/sardorergashev09uzb-commits)
- **Rol:** Full-Stack Developer (Yii2, PHP, MySQL, Telegram Bot, Docker, Cloud DevOps)
- **Loyihaning maqsadi:** Zamonaviy backend arxitekturasi, toza MVC yondashuvi, xavfsizlik va bulutli avtomatizatsiyani namoyish etuvchi portfolio loyihasi.

---

<p align="center">
  <b>© 2026 Zakovat Intellektual Platformasi. Barcha huquqlar himoyalangan.</b>
</p>
