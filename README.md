# Library Information System

Library Information System adalah sebuah aplikasi perpustakaan yang dibangun menggunakan Laravel. Aplikasi ini mencakup manajemen peminjaman buku, manajemen inventaris, dan pelaporan aktivitas perpustakaan secara real-time.

## Fitur

-   Manajemen peminjaman buku
-   Manajemen inventaris buku
-   Pelaporan aktivitas perpustakaan secara real-time
-   Manajemen user
-   Antarmuka pengguna yang intuitif

## Prasyarat

Sebelum Anda memulai, pastikan Anda memiliki persyaratan berikut:

-   PHP >= 7.4
-   Composer
-   Node.js dan NPM
-   MySQL atau database lain yang didukung Laravel

## Instalasi

Ikuti langkah-langkah berikut untuk mengkloning dan menjalankan proyek Laravel ini di lingkungan lokal Anda.

### 1. Clone Repository

Clone repository ini ke mesin lokal Anda dengan menggunakan perintah berikut:

git clone link https://github.com/stevenchan7/si-library.git

### 2. Install Dependencies

Instal semua dependensi PHP menggunakan Composer:
[composer install]

### 3. Konfigurasi Environment

Salin file .env.example menjadi .env:
[cp .env.example .env]

Setelah menyalin file .env, konfigurasi nama database dan password agar sesuai dengan database anda.

### 4. Generate Application Key

Generate application key dengan perintah berikut:
[php artisan key:generate]

### 5. Migrasi dan Seed Database

Jalankan migrasi untuk membuat tabel-tabel database:
[php artisan migrate]

Jika diperlukan, jalankan seeder untuk mengisi data awal:
[php artisan db:seed]

### 6. Jalankan Server

[php artisan serve]
