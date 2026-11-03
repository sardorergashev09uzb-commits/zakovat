# 🎓 Zakovat — Intelligente Quiz- & Wissensplattform (Full-Stack Web & Bot)

<p align="center">
  <a href="README.md">🇬🇧 English Version</a> •
  <a href="README.de.md">🇩🇪 Deutsche Version</a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/Yii2-Advanced%20MVC-0073AA?style=for-the-badge&logo=yii&logoColor=white" alt="Yii2" />
  <img src="https://img.shields.io/badge/MySQL-CleverCloud%20InnoDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Telegram_Bot-24%2F7%20Webhook-2CA5E0?style=for-the-badge&logo=telegram&logoColor=white" alt="Telegram Bot" />
  <img src="https://img.shields.io/badge/Docker-Cloud%20Native-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker" />
  <img src="https://img.shields.io/badge/Deployment-Render.com-46E3B7?style=for-the-badge&logo=render&logoColor=black" alt="Render" />
  <img src="https://img.shields.io/badge/Portfolio-Ausbildung%202026-blueviolet?style=for-the-badge" alt="Ausbildung" />
</p>

---

## 📌 Live-Demonstrationen (Demos im Produktivbetrieb)

| Komponente | Beschreibung | Live-Link |
| :--- | :--- | :--- |
| 🌐 **Haupt-Webanwendung** | Interaktive Quiz-Spiele, Kategorien und Benutzerprofil | [zakovat-ktmg.onrender.com](https://zakovat-ktmg.onrender.com) |
| 👑 **Admin-Dashboard** | Fragenverwaltung, Filter, CSV-Import/Export & Nutzerverwaltung | [zakovat-ktmg.onrender.com/admin](https://zakovat-ktmg.onrender.com/admin) |
| 🤖 **Telegram Bot (24/7)** | Wissensfragen, Multiple-Choice Quiz-Polls und Tagesfragen | [@zakovat_savol_007_bot](https://t.me/zakovat_savol_007_bot) |
| ☁️ **Cloud-Datenbank** | Skalierbare MySQL 8 Instanz mit InnoDB auf Clever Cloud | `Clever Cloud (EU Paris)` |

> [!NOTE]
> **Wichtiger Hinweis zum Hosting (Kaltstart / Cold Start):**  
> Die Webanwendung wird auf der kostenlosen Free-Tier-Infrastruktur von Render.com betrieben. Aus Ressourcengründen wird der Container bei längerer Inaktivität vorübergehend heruntergefahren. Beim ersten Aufruf der Live-Demo kann es daher **ca. 30 bis 50 Sekunden** dauern, bis der Docker-Container aufgeweckt wird ("Cold Start"). Danach arbeitet die Plattform gewohnt performant und ohne Verzögerung.

---

## 📖 Projektübersicht & Zielsetzung

**Zakovat** ist eine moderne, cloudbasierte Full-Stack-Webplattform für intellektuelle Denkspiele, Multiple-Choice-Prüfungen und automatisierte Wissensabfragen über Telegram. 

Das Projekt wurde im Rahmen meiner praktischen Vorbereitung auf eine **Ausbildung zum Fachinformatiker für Anwendungsentwicklung** konzipiert und realisiert. Es demonstriert fundierte Kenntnisse in moderner Softwarearchitektur, relationalem Datenbankdesign, API-Integrationen, Containerisierung mit Docker und zukunftsorientierter Nutzung moderner Entwicklungswerkzeuge (KI-gestützte Entwicklung).

---

## 💡 Technische Kernleistungen & Eigenleistung (Was ich selbst beherrsche und umgesetzt habe)

Für Ausbilder und technische Prüfer: Nachfolgend sind die konkreten architektonischen und programmiertechnischen Komponenten aufgeführt, die mein technisches Verständnis und meine eigenständige Umsetzungsfähigkeit belegen:

### 1. 🏗️ MVC-Architektur & Mehrschichtiges Design (Yii2 Advanced)
- Aufteilung der Codebasis in drei isolierte, aber modulare Schichten:
  - **`frontend/`**: Öffentliche Benutzeroberfläche, Quiz-Dienste und Nutzerinteraktion.
  - **`backend/`**: Geschützter Administrationsbereich mit rollenbasierter Zugriffskontrolle (RBAC).
  - **`common/`**: Wiederverwendbare Datenmodelle (`ActiveRecord`), Geschäftslogik und Bot-Komponenten.
  - **`console/`**: CLI-Befehle, Cron-Daemon und Long-Polling-Option für lokale Bot-Tests.

### 2. 🤖 Autonome Telegram-Bot-Integration (`common/components/TelegramBot.php`)
- **Native cURL-Komponente:** Eigenständig implementierte Anbindung an die offizielle Telegram Bot API ohne schwere externe Drittanbieter-Bibliotheken.
- **Webhook-Architektur:** Sichere Verarbeitung asynchroner HTTP POST-Anfragen von den Telegram-Servern (`/telegram/webhook`) mit CSRF-Ausnahmeregelung und JSON-Dekodierung.
- **Native Quiz-Polls:** Versand von Quiz-Fragen via Telegram-API (`sendPoll`, `type: quiz`) inklusive Antwortvalidierung und automatischer Erklärung.
- **Inline-Keyboards & Callbacks:** Interaktive Menüsteuerung und Ereignisverarbeitung (`callback_query`) für nahtlose Bot-Bedienung.

### 3. 📊 Administrationsbereich mit dynamischer Filterung & CSV-Engine
- **`QuestionSearch` & `UserSearch`:** Implementierung von Yii2 `ActiveDataProvider` mit parametergebundenen Suchabfragen (Schutz vor SQL-Injektionen).
- **Mehrkriterielle Live-Filter:** Dynamische Dropdowns nach Kategorie, Schwierigkeitsgrad (Leicht, Mittel, Schwer), Fragetyp und Status.
- **Robuster CSV-Massenimport & -Export:**
  - Importieren hunderter Fragen mit einem Klick.
  - Automatische Validierung, UTF-8-BOM-Bereinigung und dynamische Zuordnung existierender Kategorien.
  - Automatisches Erstellen neuer Kategorien inklusive URL-konformer Slugs bei unbekannten Einträgen.

### 4. 🧠 Interaktive Quiz-Engines im Frontend
- **Zakovat-Modus (Offene Denkfrage):** Dynamischer 60-Sekunden-Countdown mit SVG-Kreisanimation ("Wissensring") und zeitgesteuerter Antwortaufdeckung.
- **Choice-Quiz-Modus:** 4-Optionen-Single-Choice-Engine mit sofortigem visuellen Feedback (Grün/Rot) und Ergebnisberechnung.

### 5. 🐳 Cloud-Deployment & Docker-VirtualHost-Konfiguration
- **Containerisierung:** Erstellung eines optimierten Multi-Environment `Dockerfile` auf Basis von PHP 8.2 Apache.
- **VirtualHost-Architektur (`apache-zakovat.conf`):** Konfiguration, die die Domain-Wurzel `/` auf `frontend/web` leitet und `/admin` als Alias auf `backend/web` auflöst – alles in einer einzigen Render-Instanz.
- **Produktionsoptimierung:** Automatisiertes `php init --env=Production`, `composer install --optimize-autoloader` und Schema-Caching (`enableSchemaCache => true`) für maximale Reaktionsgeschwindigkeit.

---

## 🤖 Einsatz von Künstlicher Intelligenz (Transparenz & Moderne Arbeitsweise)

In der modernen Softwareentwicklung ist KI ein unverzichtbares Werkzeug zur Effizienzsteigerung. Für dieses Projekt wurde KI bewusst und transparent eingesetzt:

| Bereich | Eigene Leistung (Mensch) | KI-Unterstützung (Werkzeug) |
| :--- | :--- | :--- |
| **Architektur & Struktur** | Festlegung der Schichtenarchitektur (Yii2 Advanced), Design der relationalen Datenbanktabellen, Sicherheitskonzept (RBAC). | Verifikation von Best Practices und Dokumentationsentwürfe. |
| **Geschäftslogik & Code** | Vollständiges Verständnis jeder Zeile, Implementierung von Controller-Aktionen, CSV-Parsing-Logik, Webhook-Routing, Fehlerbehandlung. | Beschleunigte Generierung von Boilerplate-Code und Syntax-Feinschliff. |
| **Frontend & UI/UX** | Konzeption des Layouts, Strukturierung der Views, Auswahl von Farbpaletten und Design-Komponenten. | Entwurf von modernen CSS-Gradienten, Glassmorphism-Klassen und responsiven Flex/Grid-Regeln. |
| **Inhalte & Testdaten** | Kategoriensystem (Geschichte, IT, Naturwissenschaften), Validierung von Fakten und Logikfragen. | Unterstützung bei der Zusammenstellung anspruchsvoller Zakovat-Denkfragen. |
| **Fehleranalyse (Debugging)** | Identifikation des 404-Routing-Fehlers auf Render.com, Analyse der Apache-VHost-Konfiguration und Berechtigungen. | Unterstützung beim gezielten Testen von cURL-Endpunkten und schnellen iterativen Fixes. |

> **Fazit für Ausbilder:** Ich kann den gesamten Code des Projekts im technischen Interview im Detail erklären, anpassen und schrittweise erweitern. KI diente als Produktivitätsverstärker, nicht als Ersatz für technisches Verständnis.

---

## 🛡️ Sicherheits- und Qualitätsstandards

- **Schutz vor SQL-Injektion:** Durchgängige Nutzung von Yii2 `ActiveRecord` und PDO Prepared Statements; keine unsicheren String-Verkettungen in SQL-Befehlen.
- **XSS-Prävention (Cross-Site-Scripting):** Strikte Ausgabe-Maskierung über `yii\helpers\Html::encode()`.
- **CSRF-Schutz:** Automatische CSRF-Token-Prüfung für alle zustandsverändernden HTTP-POST-Anfragen (mit bewusster Ausnahme für den externen Telegram-Webhook-Endpunkt).
- **Broken Access Control & RBAC:** Zugriff auf den Administrationsbereich ist über rollenbasierte `AccessControl`-Filter und `isAdmin()`-Prüfungen abgesichert.
- **12-Factor-App-Konformität:** Trennung von Konfiguration und Code; sensible Daten (Datenbank-Passwörter, Bot-Tokens) werden über Umgebungsvariablen (`getenv`) geladen.

---

## 🏗️ Systemarchitektur & Datenfluss

```
                         ┌────────────────────────────────────┐
                         │   Benutzer / Browser & Telegram    │
                         └─────────────────┬──────────────────┘
                                           │ HTTPS (Port 443)
                                           ▼
                         ┌────────────────────────────────────┐
                         │   Render.com Web-Service (Docker)  │
                         │   PHP 8.2 + Apache2 (mod_rewrite)  │
                         └────────┬───────────────────┬───────┘
                                  │                   │
         ┌────────────────────────┴───────┐   ┌───────┴────────────────────────┐
         ▼                                ▼   ▼                                ▼
┌──────────────────┐    ┌──────────────────┐  ┌────────────────────────────────┐
│ / (Frontend Web) │    │  /admin (Backend)│  │ /telegram/webhook (Controller) │
│ - Quiz & Test UI │    │  - CRUD Savollar │  └──────────────▲─────────────────┘
│ - Profil & Auth  │    │  - CSV Import    │                 │ JSON Webhook Updates
└────────┬─────────┘    └────────┬─────────┘  ┌──────────────┴─────────────────┐
         │                       │            │    Offizielle Telegram API     │
         └───────────────┬───────┘            │   (@zakovat_savol_007_bot)     │
                         │                    └────────────────────────────────┘
                         ▼
        ┌──────────────────────────────────┐
        │   Clever Cloud MySQL 8 (InnoDB)  │
        │  Tabellen: user, category,       │
        │  question, site_setting          │
        └──────────────────────────────────┘
```

---

## 🗄️ Relationales Datenbankschema (ER-Modell)

| Tabelle | Wesentliche Spalten | Beschreibung |
| :--- | :--- | :--- |
| **`user`** | `id`, `username`, `email`, `password_hash`, `role`, `status`, `created_at` | Nutzer- und Administratorkonten mit Rollenprüfung |
| **`category`** | `id`, `name`, `slug`, `icon`, `status`, `created_at` | Wissensgebiete (IT, Geschichte, Naturwissenschaften) |
| **`question`** | `id`, `category_id`, `type`, `question_text`, `answer`, `option_a..d`, `correct_option`, `difficulty`, `status` | Fragenkatalog für offene Fragen und 4-fach-Multiple-Choice |
| **`site_setting`**| `id`, `key`, `value`, `description`, `updated_at` | Dynamische Portal-Konfigurationsparameter |

---

## 💻 Lokale Installation & Ausführung

Voraussetzungen: PHP 8.2+, Composer, MySQL (z. B. via Laragon, XAMPP oder Docker).

```bash
# 1. Repository klonen
git clone https://github.com/sardorergashev09uzb-commits/zakovat.git
cd zakovat

# 2. Abhängigkeiten installieren
composer install

# 3. Projektumgebung initialisieren (Entwicklung)
php init --env=Development

# 4. Datenbank in common/config/main-local.php anpassen
# 5. Datenbankmigrationen ausführen
php yii migrate

# 6. Telegram Bot im lokalen Polling-Modus starten (optional)
php yii telegram/poll
```

---

## 👨‍💻 Über den Entwickler (Bewerberprofil)

- **Name:** **Sardorbek Ergashev**
- **GitHub:** [@sardorergashev09uzb-commits](https://github.com/sardorergashev09uzb-commits)
- **Angestrebtes Ziel:** Ausbildung zum Fachinformatiker für Anwendungsentwicklung (Start 2026 / 2027)
- **Schwerpunkte:** Backend-Entwicklung (PHP, Yii2, Laravel-Prinzipien), Relationale Datenbanken (MySQL), API-Design, Docker & Linux Grundlagen.

---

<p align="center">
  <b>© 2026 Zakovat Plattform • Entwickelt mit Leidenschaft für sauberen Code und innovative Softwarelösungen.</b>
</p>
