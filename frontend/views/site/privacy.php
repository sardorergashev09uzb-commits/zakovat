<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Maxfiylik Siyosati va Foydalanish Shartlari';
?>

<div class="container py-5" style="max-width: 920px;">

  <!-- Sahifa sarlavhasi -->
  <div class="mb-5 text-center">
    <span class="badge badge--info mb-2" style="font-size: 0.85rem; padding: 6px 14px;">🛡️ Yuridik & Xavfsizlik hujjati</span>
    <h1 style="font-size: 2.2rem; font-weight: 800; margin-top: 8px; color: var(--color-text);">
      Maxfiylik Siyosati va Foydalanish Shartlari
    </h1>
    <p class="text-muted" style="font-size: 0.95rem; max-width: 620px; margin: 8px auto 0;">
      Ushbu hujjat <strong>Zakovat</strong> platformasida foydalanuvchilarning shaxsiy ma'lumotlari qanday to'planishi, saqlanishi, himoyalanishi va platformadan foydalanish qoidalarini belgilaydi.
    </p>
    <div class="text-muted mt-2" style="font-size: 0.82rem;">
      📅 Oxirgi yangilangan sana: <?= date('d.m.Y') ?>
    </div>
  </div>

  <!-- Portfolio / Ta'limiy Loyiha Bildirishnomasi -->
  <div class="card p-4 mb-4" style="background: #f0f9ff; border: 1.5px solid #bae6fd; border-radius: 12px;">
    <div class="d-flex align-items-start gap-3">
      <div style="font-size: 1.8rem; line-height: 1;">🎓</div>
      <div>
        <h5 style="color: #0369a1; font-weight: 700; margin-bottom: 4px;">Portfolio va Ta'lim Loyihasi Haqida</h5>
        <p style="color: #0c4a6e; font-size: 0.9rem; line-height: 1.55; margin: 0;">
          Ushbu platforma dasturlash, veb-xavfsizlik, Yii2 freymvorki arxitekturasi va zamonaviy intellektual tizimlarni amaliyotda qo'llash tajribasini oshirish maqsadida <strong>portfolio va ta'limiy loyiha</strong> sifatida ishlab chiqilgan. Tizim tijoriy maqsadlarni ko'zlamaydi va foydalanuvchilar ma'lumotlarini uchinchi shaxslarga sotmaydi.
        </p>
      </div>
    </div>
  </div>

  <!-- Asosiy Mundarija -->
  <div class="card p-4 mb-4" style="box-shadow: var(--shadow-sm); border-radius: 12px;">
    <h4 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 12px;">📑 Mundarija</h4>
    <div class="row g-2" style="font-size: 0.92rem;">
      <div class="col-md-6">
        <ul class="mb-0" style="padding-left: 20px;">
          <li><a href="#kirish" class="text-decoration-none">1. Umumiy qoidalar</a></li>
          <li><a href="#malumotlar" class="text-decoration-none">2. Qanday ma'lumotlar to'planadi?</a></li>
          <li><a href="#maqsad" class="text-decoration-none">3. Ma'lumotlardan foydalanish maqsadi</a></li>
          <li><a href="#cookie" class="text-decoration-none">4. Cookie va Texnik fayllar</a></li>
        </ul>
      </div>
      <div class="col-md-6">
        <ul class="mb-0" style="padding-left: 20px;">
          <li><a href="#xavfsizlik" class="text-decoration-none">5. Axborot xavfsizligi va himoya</a></li>
          <li><a href="#telegram" class="text-decoration-none">6. Telegram Bot integratsiyasi</a></li>
          <li><a href="#shartlar" class="text-decoration-none">7. Foydalanish shartlari va Mas'uliyat</a></li>
          <li><a href="#huquqlar" class="text-decoration-none">8. Foydalanuvchi huquqlari va Bog'lanish</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- 1. Umumiy qoidalar -->
  <div class="card p-4 mb-4" id="kirish" style="border-radius: 12px; box-shadow: var(--shadow-sm);">
    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-primary); margin-bottom: 14px;">
      1. Umumiy Qoidalar
    </h3>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      1.1. Ushbu Maxfiylik siyosati (bundan keyin — «Siyosat») foydalanuvchi (bundan keyin — «Foydalanuvchi») tomonidan <strong>Zakovat</strong> veb-sayti va unga ulangan rasmiy Telegram boti xizmatlaridan foydalanish jarayonida olinadigan barcha ma'lumotlarga nisbatan tatbiq etiladi.
    </p>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text); margin-bottom: 0;">
      1.2. Platformada ro'yxatdan o'tish yoki sayt xizmatlaridan foydalanish orqali Foydalanuvchi mazkur Siyosat shartlarini to'liq va hech qanday istisnolarsiz qabul qilgan hisoblanadi.
    </p>
  </div>

  <!-- 2. Qanday ma'lumotlar to'planadi? -->
  <div class="card p-4 mb-4" id="malumotlar" style="border-radius: 12px; box-shadow: var(--shadow-sm);">
    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-primary); margin-bottom: 14px;">
      2. Qanday Ma'lumotlar To'planadi?
    </h3>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      Platforma faqat xizmatlarning to'g'ri ishlashi va hisobni identifikatsiyalash uchun zarur bo'lgan minimal miqdordagi ma'lumotlarni so'raydi:
    </p>
    <ul style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      <li><strong>Foydalanuvchi nomi (Username):</strong> Tizimda profilingizni ko'rsatish va natijalarni qayd etish uchun;</li>
      <li><strong>Elektron pochta (Email):</strong> Hisobingizni identifikatsiyalash, xavfsizlik va parolni tiklash imkoniyati uchun;</li>
      <li><strong>Parol (shifrlangan ko'rinishda):</strong> Parollar ochiq holda saqlanmaydi, balki <code>generatePasswordHash</code> (Bcrypt/Argon2) xavfsiz algoritmi orqali shifrlangan holatda saqlanadi;</li>
      <li><strong>O'yin va Test natijalari:</strong> Testlarda yechilgan savollar soni, to'plangan ballar va o'tgan vaqt statistikasi;</li>
      <li><strong>Telegram Chat ID (ixtiyoriy):</strong> Telegram bot orqali bog'lanilganda foydalanuvchiga savol va natijalarni yetkazish uchun xizmat qiladi.</li>
    </ul>
    <div class="p-3 bg-light rounded" style="font-size: 0.88rem; color: var(--color-text-muted);">
      🔒 <em>Biz hech qachon pasport ma'lumotlari, bank kartalari, telefon raqamlari yoki boshqa nozik shaxsiy ma'lumotlarni so'ramaymiz va to'plamaymiz.</em>
    </div>
  </div>

  <!-- 3. Ma'lumotlardan foydalanish maqsadi -->
  <div class="card p-4 mb-4" id="maqsad" style="border-radius: 12px; box-shadow: var(--shadow-sm);">
    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-primary); margin-bottom: 14px;">
      3. Ma'lumotlardan Foydalanish Maqsadi
    </h3>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      To'plangan ma'lumotlar quyidagi aniq maqsadlarda qo'llaniladi:
    </p>
    <ol style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text); margin-bottom: 0;">
      <li>Foydalanuvchini platformaga kiritish (avtorizatsiya) va shaxsiy profilni yuritish;</li>
      <li>Zakovat savollari va 4 variantli testlarni interaktiv taqdim etish hamda yakuniy natijalarni hisoblash;</li>
      <li>Platformaning xavfsizligini ta'minlash, ruxsatsiz kirishlar (Brute-force, spam) va xatoliklarni oldini olish;</li>
      <li>Sayt funksionalligini va foydalanuvchi interfeysini takomillashtirish.</li>
    </ol>
  </div>

  <!-- 4. Cookie va Texnik fayllar -->
  <div class="card p-4 mb-4" id="cookie" style="border-radius: 12px; box-shadow: var(--shadow-sm);">
    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-primary); margin-bottom: 14px;">
      4. Cookie va Sessiya Fayllari
    </h3>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      4.1. Sayt foydalanuvchi sessiyasini saqlash uchun standart <code>_csrf-frontend</code> va <code>_identity-frontend</code> nomli cookie fayllaridan foydalanadi.
    </p>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      4.2. <strong>CSRF Himoyasi:</strong> Har bir so'rov sayt xavfsizligini ta'minlovchi maxsus token orqali kiberhujumlardan (Cross-Site Request Forgery) himoyalangan.
    </p>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text); margin-bottom: 0;">
      4.3. Foydalanuvchi o'z brauzer sozlamalari orqali cookie fayllarini bloklashi mumkin, biroq bu holda saytning ayrim avtorizatsiyaga bog'liq qismlari to'liq ishlamasligi mumkin.
    </p>
  </div>

  <!-- 5. Axborot xavfsizligi va himoya -->
  <div class="card p-4 mb-4" id="xavfsizlik" style="border-radius: 12px; box-shadow: var(--shadow-sm);">
    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-primary); margin-bottom: 14px;">
      5. Axborot Xavfsizligi va Himoya Mexanizmlari
    </h3>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      Loyihada zamonaviy axborot xavfsizligi choralari va eng yaxshi dasturlash amaliyotlari qo'llanilgan:
    </p>
    <div class="row g-3">
      <div class="col-md-6">
        <div class="p-3 border rounded h-100 bg-white">
          <h6 class="fw-bold mb-2">🔐 RBAC va Ruxsatlar nazorati</h6>
          <p class="text-muted mb-0" style="font-size: 0.85rem;">
            Admin panelga kirish faqat <code>admin</code> huquqiga ega bo'lgan autentifikatsiya qilingan hisoblar uchun cheklangan (Broken Access Control himoyasi).
          </p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="p-3 border rounded h-100 bg-white">
          <h6 class="fw-bold mb-2">🛡️ SQL Injection & XSS himoyasi</h6>
          <p class="text-muted mb-0" style="font-size: 0.85rem;">
            Barcha ma'lumotlar bazasi so'rovlari PDO Prepared Statements orqali, chiqariladigan ma'lumotlar esa <code>Html::encode</code> orqali to'liq filtrlanadi.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- 6. Telegram Bot integratsiyasi -->
  <div class="card p-4 mb-4" id="telegram" style="border-radius: 12px; box-shadow: var(--shadow-sm);">
    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-primary); margin-bottom: 14px;">
      6. Telegram Bot Integratsiyasi
    </h3>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      6.1. Platformaning rasmiy boti (<code>@zakovat_savol_007_bot</code>) foydalanuvchilarga Telegram orqali testlar yechish va savollarni ko'rish imkonini beradi.
    </p>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text); margin-bottom: 0;">
      6.2. Bot faqat Telegram messenjeri taqdim etgan ochiq identifikatorlar (Chat ID, First Name) doirasida ishlaydi va foydalanuvchining shaxsiy yozishmalari yoki kontaktlariga kirish huquqiga ega emas.
    </p>
  </div>

  <!-- 7. Foydalanish shartlari va Mas'uliyat -->
  <div class="card p-4 mb-4" id="shartlar" style="border-radius: 12px; box-shadow: var(--shadow-sm);">
    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-primary); margin-bottom: 14px;">
      7. Foydalanish Shartlari va Mas'uliyatni Cheklash (Disclaimer)
    </h3>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      7.1. Saytdagi intellektual savollar, izohlar va test materiallari ma'rifiy, o'quv va madaniy-intellektual rivojlanish uchun mo'ljallangan.
    </p>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      7.2. <strong>Taqiqlangan harakatlar:</strong> Tizimga avtomatlashtirilgan kiberhujumlar uyushtirish, boshqa foydalanuvchilarning hisoblariga buzib kirishga urinish, spam yoki noqonuniy kod kiritish qat'iyan taqiqlanadi.
    </p>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text); margin-bottom: 0;">
      7.3. Ushbu platforma portfolio va tajriba loyihasi sifatida "qanday bo'lsa shunday" (as-is) taqdim etiladi. Muallif platformaning uzluksiz ishlashiga nisbatan mutlaq kafolat bermaydi, biroq tizim sifatini doimiy qo'llab-quvvatlaydi.
    </p>
  </div>

  <!-- 8. Foydalanuvchi huquqlari va Bog'lanish -->
  <div class="card p-4 mb-4" id="huquqlar" style="border-radius: 12px; box-shadow: var(--shadow-sm);">
    <h3 style="font-size: 1.3rem; font-weight: 700; color: var(--color-primary); margin-bottom: 14px;">
      8. Foydalanuvchi Huquqlari va Bog'lanish
    </h3>
    <p style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      Har bir foydalanuvchi quyidagi huquqlarga ega:
    </p>
    <ul style="font-size: 0.94rem; line-height: 1.6; color: var(--color-text);">
      <li>Istalgan vaqtda o'z <a href="<?= Url::to(['/site/profil']) ?>" class="fw-bold">Profil sahifasi</a> orqali shaxsiy ma'lumotlarini (foydalanuvchi nomi, email, parol) tahrirlash va yangilash;</li>
      <li>Hisobini o'chirish yoki ma'lumotlarini tozalash bo'yicha ma'muriyatga murojaat qilish;</li>
      <li>Platformadan bepul va erkin foydalanish.</li>
    </ul>

    <div class="p-3 border rounded bg-light mt-3" style="font-size: 0.9rem;">
      <h6 class="fw-bold mb-1">📩 Bog'lanish va Savollar:</h6>
      <p class="mb-0 text-muted">
        Agar sizda maxfiylik siyosati, tizim xavfsizligi yoki loyiha bo'yicha takliflar bo'lsa, loyiha muallifi bilan quyidagi manzil orqali bog'lanishingiz mumkin: <br>
        <strong>Email:</strong> <a href="mailto:admin@example.com">admin@example.com</a> &middot; <strong>Telegram:</strong> <a href="https://t.me/zakovat_savol_007_bot" target="_blank">@zakovat_savol_007_bot</a>
      </p>
    </div>
  </div>

  <!-- Orqaga qaytish tugmasi -->
  <div class="text-center mt-4">
    <a href="<?= Url::to(['/site/index']) ?>" class="btn btn-primary px-4 py-2">
      🏠 Bosh sahifaga qaytish
    </a>
  </div>

</div>
