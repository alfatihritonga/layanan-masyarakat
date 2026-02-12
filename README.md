# Sistem Layanan Masyarakat Kebencanaan

Aplikasi web untuk pelaporan bencana oleh masyarakat dan pengelolaan respon oleh admin. Sistem mencakup verifikasi laporan, penugasan relawan, monitoring progres, serta statistik bencana untuk transparansi penanganan.

## Tujuan Sistem
- Memudahkan masyarakat melaporkan kejadian bencana secara cepat
- Membantu admin memverifikasi, mengelola, dan merespon laporan secara terstruktur
- Mengelola relawan dan penugasan secara efisien
- Menyajikan status dan statistik penanganan bencana secara ringkas

## Fitur Utama
- Pelaporan bencana dengan detail lokasi, jenis bencana, urgensi, dan kontak
- Status laporan: `pending`, `verified`, `in_progress`, `resolved`, `rejected`
- Komentar laporan (publik) dan catatan internal admin
- Penugasan relawan serta update status penugasan
- Manajemen relawan (ketersediaan, skill, wilayah)
- Manajemen jenis bencana
- Dashboard statistik laporan dan relawan
- Login via Google OAuth dan login email (opsional)
- API terproteksi dengan Laravel Sanctum (role-based)

## Role Pengguna

### 1) User (Masyarakat)
- Login menggunakan Google atau email
- Membuat laporan bencana
- Mengedit/menghapus laporan saat status masih `pending`
- Menambah lampiran laporan (maks. 3 file)
- Melihat riwayat dan komentar laporan

### 2) Admin
- Verifikasi atau menolak laporan
- Mengubah tingkat urgensi dan menambah catatan
- Menugaskan relawan dan memantau progres penugasan
- Menambahkan komentar internal
- Mengelola data relawan dan jenis bencana
- Melihat statistik laporan dan relawan

## Modul Utama
- Laporan Bencana
- Verifikasi & Respon Laporan
- Penugasan Relawan
- Komentar & Riwayat Perubahan
- Statistik & Dashboard
- Manajemen Relawan
- Manajemen Jenis Bencana

## Teknologi
- Laravel 12 (Backend)
- Laravel Sanctum (API Auth)
- Laravel Socialite (Google OAuth)
- Blade Template + Eloquent ORM
- Tailwind CSS v4 + DaisyUI
- Vite + Chart.js
- MySQL / PostgreSQL

## Instalasi

### 1) Persyaratan
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / PostgreSQL
- Web Server (Apache/Nginx/Laravel Herd)

### 2) Clone Repository
```bash
git clone <repository-url>
cd nama-project
```

### 3) Install Dependency
```bash
composer install
npm install
```

### 4) Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database di `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

Jika menggunakan Google OAuth, set:
```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=
```

### 5) Migrasi & Seed Data
```bash
php artisan migrate --seed
```

### 6) Storage Link
```bash
php artisan storage:link
```

### 7) Build Asset
```bash
npm run build
```

### 8) Jalankan Aplikasi
```bash
php artisan serve
```

Akses aplikasi:
```
http://127.0.0.1:8000
```

## Perintah Cepat (Opsional)
```bash
composer run setup
composer run dev
```

## Akun Demo (Seeder)
Admin:
- admin@gmail.com / password
- admin2@gmail.com / password

User:
- budi@gmail.com / password
- siti@gmail.com / password
- ahmad@gmail.com / password
