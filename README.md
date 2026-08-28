# 🎓 Zakovat — Intellektual Savol-Javob va Test Platformasi

![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue?logo=php)
![Yii2](https://img.shields.io/badge/Yii2-Advanced%20Template-0073AA?logo=yii)
![MySQL](https://img.shields.io/badge/Database-MySQL-4479A1?logo=mysql)
![Telegram](https://img.shields.io/badge/Telegram_Bot-Integrated-2CA5E0?logo=telegram)
![License](https://img.shields.io/badge/License-MIT-green)

**Zakovat** — foydalanuvchilarning intellektual salohiyatini sinash, bilim darajasini oshirish va turli sohalarda o'zaro bilim bellashuvlarini o'tkazish uchun mo'ljallangan zamonaviy veb-platforma.

---

## 🌟 Asosiy Imkoniyatlar (Features)

1. 💡 **2 Xil Rejimdagi Intellektual Sinov:**
   - **Zakovat rejimi (Ochiq savol):** 60 soniyalik aylanma "Bilim halqasi" taymeri bilan muhokama qilish va to'g'ri javobni ochish.
   - **Variantli Test rejimi (A, B, C, D):** Interaktiv testlar, to'g'ri/noto'g'ri javoblarni darhol aniqlash va ballarni hisoblash.
2. 🤖 **Telegram Bot Integratsiyasi:**
   - Rasmiy Telegram bot (`@zakovat_savol_007_bot`) orqali tasodifiy savollar, Quiz Poll testlar, kun savolini olish.
   - Webhook va Polling rejimlari qo'llab-quvvatlanadi.
3. 📥 **Savollarni CSV / Excel orqali Import va Eksport qilish:**
   - Admin panel orqali yuzlab savollarni bir necha soniyada CSV fayldan bazaga yuklash va barcha savollarni yuklab olish.
4. 🛡️ **Kuchli Xavfsizlik va RBAC:**
   - Rolga asoslangan ruxsatlar boshqaruvi (`Admin` va `User` rollari).
   - SQL Injection (PDO Prepared Statements), XSS (`Html::encode`) va CSRF himoyasi.
   - Broken Access Control xavfsizlik himoyasi.
5. 📜 **Maxfiylik Siyosati va Foydalanish Shartlari:**
   - Portfolio va ta'limiy loyiha talablariga moslangan keng qamrovli `Privacy Policy & Terms` sahifasi.

---

## 🛠️ Texnologiyalar Steki

- **Backend:** PHP 8.2+, Yii 2 Advanced Framework
- **Frontend:** HTML5, CSS3 (Modern Variables & Responsive Grid), JavaScript (Vanilla ES6), Bootstrap 5
- **Ma'lumotlar bazasi:** MySQL / MariaDB (InnoDB)
- **API & Integratsiya:** Telegram Bot API (cURL)
- **Arxitektura:** MVC (Model-View-Controller), RBAC

---

## 🚀 Loyihani O'rnatish va Ishga Tushirish

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
# Muhitni tanlang (0 - Development yoki 1 - Production)
```

### 4. Ma'lumotlar bazasi sozlamalari:
`common/config/main-local.php` faylida DB ulanish parametrlarini kiriting:
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

### 6. Telegram Botni ulash (ixtiyoriy):
`common/config/params-local.php` ga Bot tokeningizni kiriting:
```php
return [
    'telegramBotToken' => 'YOUR_BOT_TOKEN_HERE',
];
```

Lokalda botni ishga tushirish:
```bash
php yii telegram/poll
```

---

## 👨‍💻 Muallif & Portfolio

- **Loyiha turi:** Portfolio & Ta'limiy amaliyot loyihasi
- **Dasturchi:** Sardorbek
- **GitHub:** [@sardorergashev09uzb-commits](https://github.com/sardorergashev09uzb-commits)

---
&copy; 2026 Zakovat Intellektual Platformasi. Barcha huquqlar himoyalangan.
