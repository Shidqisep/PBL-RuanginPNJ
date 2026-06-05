# 🏛️ RuanginPNJ

> Sistem informasi peminjaman ruangan Perpustakaan Politeknik Negeri Jakarta (PNJ) berbasis web.

---

## 📋 Tentang Proyek

**RuanginPNJ** adalah aplikasi web untuk manajemen booking/peminjaman ruangan di Perpustakaan PNJ. Aplikasi ini dikembangkan sebagai bagian dari mata kuliah **Project Based Learning (PBL)**.

Fitur utama meliputi:
- Pembuatan dan manajemen booking ruangan
- Sistem reschedule dengan validasi konflik
- Auto-cancel dan auto-complete booking secara otomatis
- Email reminder sebelum waktu mulai dan selesai
- Panel admin untuk pengelolaan ruangan dan pengguna

### Aturan Booking

- Setiap pengguna hanya boleh terlibat dalam **1 booking per minggu** (berlaku untuk ketua maupun anggota)
- Jika anggota sudah terdaftar di reschedule orang lain, booking baru yang menyertakan anggota tersebut akan ditolak
- Jika ketua sudah terdaftar sebagai anggota di reschedule orang lain, maka reschedule tersebut akan ditolak saat ketua mencoba membuat booking baru

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
|---|---|
| Backend | PHP (native, PSR-4 autoload) |
| Database | MySQL 8.0 |
| Email | PHPMailer + Mailpit (dev) |
| Scheduler | Ofelia (cron berbasis Docker) |
| Containerization | Docker & Docker Compose |
| Environment | `vlucas/phpdotenv` |

---

## ⚙️ Cara Menjalankan

### Prasyarat

Pastikan sudah terinstall:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Composer](https://getcomposer.org/)

### Langkah Instalasi

**1. Clone repository**

```bash
git clone https://github.com/Shidqisep/PBL-RuanginPNJ.git
cd PBL-RuanginPNJ
```

**2. Buat file environment**

```bash
cp env-example .env
```

Lalu sesuaikan isi `.env` dengan konfigurasi lokal kamu:

```env
DB_HOST=db
DB_DATABASE=ruanginpnj
DB_USERNAME=your_username
DB_PASSWORD=your_password
DB_ROOT_PASSWORD=your_root_password
```

**3. Install dependensi PHP**

```bash
composer install
```

**4. Jalankan Docker**

```bash
docker compose up -d
```

**5. Import database**

```bash
# Jalankan DDL terlebih dahulu
docker exec -i ruanginPNJ_database mysql -u root -p your_root_password ruanginpnj < ddl.sql

# Lalu import data awal
docker exec -i ruanginPNJ_database mysql -u root -p your_root_password ruanginpnj < data.sql
```

**6. Akses aplikasi**

| Layanan | URL |
|---|---|
| Aplikasi Web | http://localhost:8082 |
| Mailpit (email dev) | http://localhost:8025 |
| Database (opsional) | `localhost:3307` |

---

## 🐳 Arsitektur Docker

Proyek ini terdiri dari 4 service Docker:

| Service | Container | Keterangan |
|---|---|---|
| `web` | `ruanginPNJ_server` | Apache + PHP, menjalankan aplikasi |
| `db` | `ruanginPNJ_database` | MySQL 8.0 |
| `mailpit` | `ruanginPNJ_mail` | Simulasi email untuk development |
| `ofelia` | `ruanginPNJ_scheduler` | Cron job otomatis |

### Scheduled Jobs (Ofelia)

Dijalankan setiap **2 menit**:

| Job | Command | Fungsi |
|---|---|---|
| `bookings:autocancel` | `cli.php bookings:autocancel` | Auto-cancel booking yang melewati batas waktu |
| `bookings:autocomplete` | `cli.php bookings:autocomplete` | Auto-complete booking yang sudah selesai |
| `reminders:start` | `cli.php reminders:start` | Kirim reminder mendekati waktu mulai |
| `reminders:end` | `cli.php reminders:end` | Kirim reminder mendekati waktu selesai |

---

## 📁 Struktur Direktori

```
PBL-RuanginPNJ/
├── .docker/php/        # Konfigurasi Dockerfile untuk PHP/Apache
├── app/                # Source code utama (PSR-4, namespace App\)
├── public/             # Web root, asset publik
├── storage/            # File upload, log, dll.
├── cli.php             # Entry point untuk cron job CLI
├── ddl.sql             # Skema database
├── data.sql            # Data awal (seeder)
├── docker-compose.yaml
├── composer.json
└── .env                # Konfigurasi environment (tidak di-commit)
```

---

## 👥 Tim Pengembang

Proyek ini dikembangkan oleh mahasiswa PNJ dalam rangka mata kuliah Project Based Learning.

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan akademik.
