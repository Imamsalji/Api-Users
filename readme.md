# Laravel API Setup Guide

## 🚀 Clone & Setup Project

Ikuti langkah-langkah berikut untuk meng-clone dan menjalankan proyek Laravel dengan Docker.

### 1️⃣ Clone Repository

Jalankan perintah berikut di terminal:

```bash
git clone https://github.com/username/repository.git
cd repository
```

Ganti `username` dan `repository` dengan URL repo milikmu.

---

### 2️⃣ Buat File `.env` dan Konfigurasi

Salin `.env.example` ke `.env`:

```bash
cp .env.example .env
```

Lalu, sesuaikan konfigurasi database di `.env` jika diperlukan.

---

### 3️⃣ Jalankan Docker

Pastikan **Docker Desktop** sudah berjalan, lalu jalankan perintah:

```bash
docker-compose up -d --build
```

Ini akan membangun dan menjalankan container Laravel, MySQL, dan PHPMyAdmin.

---

### 4️⃣ Install Dependencies

Masuk ke dalam container Laravel dan jalankan perintah berikut:

```bash
docker exec -it app bash
composer install
```

---

### 5️⃣ Generate Key Laravel

```bash
php artisan key:generate
```

---

### 6️⃣ Jalankan Migrasi Database

```bash
php artisan migrate --seed
```

Jika menggunakan Docker, pastikan database sudah terhubung.

---

### 7️⃣ Jalankan Server Laravel (Jika Tanpa Docker)

Jika tidak menggunakan Docker, jalankan server secara manual:

```bash
php artisan serve
```

Akses API di: `http://127.0.0.1:8000`

---

### 8️⃣ Akses PHPMyAdmin (Jika Menggunakan Docker)

Buka browser dan akses:

```
http://localhost:8080
```

Gunakan kredensial dari `.env` (`DB_USERNAME` & `DB_PASSWORD`).

---

## ✅ Selesai!

Sekarang proyek Laravel sudah berjalan di lokal. Jika mengalami masalah, cek log dengan:

```bash
docker logs app -f
```

