# Sistem Layanan Masyarakat Kebencanaan

Sistem berbasis web untuk **pelaporan bencana oleh masyarakat** dan **pengelolaan respon oleh admin**, termasuk koordinasi relawan dan pemantauan progres penanganan bencana.

Aplikasi ini dirancang sebagai **core system layanan kebencanaan** dengan alur sederhana, transparan, dan siap dikembangkan.

---

## 🎯 Tujuan Sistem
- Menyediakan sarana pelaporan bencana yang mudah bagi masyarakat
- Membantu admin memverifikasi dan merespon laporan secara terstruktur
- Mengelola relawan dan penugasannya secara efisien
- Menyajikan progres penanganan bencana secara transparan

---

## 👥 Role Pengguna

### 1. User (Masyarakat)
- Login menggunakan Google
- Membuat laporan bencana
- Melihat riwayat laporan
- Melihat status laporan (`pending / verified / resolved`)
- Membaca respon admin
- Melihat timeline progres penanganan
- Melihat relawan yang ditugaskan (read-only)

### 2. Admin
- Mengelola laporan masyarakat
- Memberikan respon laporan
- Mengubah status laporan
- Mengelola data relawan
- Menugaskan relawan ke respon
- Monitoring status relawan secara otomatis

---

---

## 🧱 Teknologi yang Digunakan
- Laravel (Backend Framework)
- Tailwind CSS + DaisyUI (Frontend)
- MySQL / PostgreSQL (Database)
- Laravel Socialite (Login Google)
- Blade Template
- Eloquent ORM

---

## 📂 Modul Utama Sistem
- Laporan Bencana
- Respon Laporan
- Timeline Progres
- Manajemen Relawan
- Penugasan Relawan
- Monitoring Status Relawan

---

# ⚙️ TATA CARA INSTALASI

## 1️⃣ Persyaratan Sistem
Pastikan sistem memiliki:
- PHP ≥ 8.2
- Composer
- Node.js & NPM
- MySQL / PostgreSQL
- Web Server (Apache / Nginx / Laravel Herd)

---

## 2️⃣ Clone Repository
```bash
git clone <repository-url>
cd nama-project


composer install

npm install
npm run build

cp .env.example .env
php artisan key:generate

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=

php artisan migrate

php artisan storage:link

php artisan serve

http://127.0.0.1:8000
