# Web Praktikum Basis Data TI Udayana

Website platform praktikum basis data yang dikembangkan oleh Inti Praktikum Basis Data 2026, Teknologi Informasi Universitas Udayana.

Platform ini bertujuan untuk menguji kemampuan mahasiswa dalam menulis query SQL melalui soal-soal interaktif yang dilengkapi dengan sistem penilaian otomatis dan leaderboard real-time.

## Tech Stack

- **Backend** — Laravel 11
- **Frontend** — Blade + Tailwind CSS
- **Database** — MySQL
- **SQL Editor** — Monaco Editor

## Instalasi

### Minimum Requirement
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL

### Langkah Instalasi

1. Clone repository
```bash
git clone https://github.com/username/web-praktikum-basisdata.git
cd web-praktikum-basisdata
```

2. Install dependencies
```bash
composer install
npm install
```

3. Buat file .env
```bash
cp .env.example .env
php artisan key:generate
```

4. Buat 2 database di MySQL
```sql
CREATE DATABASE web_praktikum_basisdata;
CREATE DATABASE sql_sandbox;
```

5. Jalankan migration dan seeder
```bash
php artisan migrate
php artisan db:seed
```

6. Jalankan aplikasi
```bash
npm run dev
php artisan serve
```

## Struktur Project

```
app/
├── Http/Controllers/
│   ├── Admin/          # Controller untuk admin
│   ├── ParticipantController.php
│   ├── SubmissionController.php
│   └── LeaderboardController.php
├── Models/
│   ├── Participant.php
│   ├── Question.php
│   └── Submission.php
└── Services/
    ├── SqlSandboxService.php
    ├── SqlValidatorService.php
```

<p align="center">Praktikum Basis Data 2026 · Teknologi Informasi Universitas Udayana</p>