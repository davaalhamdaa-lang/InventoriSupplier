<div align="center">

  <!-- Logo / Header Banner -->
  <img src="https://img.shields.io/badge/Sistem%20Inventori-Dapur%20MBG-1e40af?style=for-the-badge&logo=laravel&logoColor=white" alt="Dapur MBG Banner" width="100%" />

  # 📦 SIM-MBG (System Inventory & Distribution Management)
  
  **Platform Manajemen Inventori & Distribusi Bahan Pangan Berbasis Web SaaS Modern**

  [![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
  [![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
  [![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
  [![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

  <p align="center">
    <a href="#-tentang-proyek">Tentang Proyek</a> •
    <a href="#-fitur-unggulan">Fitur Utama</a> •
    <a href="#-arsitektur--skema-database">Arsitektur DB</a> •
    <a href="#-teknologi-yang-digunakan">Tech Stack</a> •
    <a href="#-panduan-instalasi">Instalasi</a> •
    <a href="#-kontak--portofolio">Kontak</a>
  </p>

</div>

---

## 🌟 Tentang Proyek

**SIM-MBG** adalah aplikasi pengelolaan inventori gudang dan distribusi bahan pangan yang dirancang khusus untuk memenuhi kebutuhan pengiriman material ke unit **SPPG (Satuan Pelayanan Pelanggan/Gizi)**. 

Aplikasi ini dibangun menggunakan arsitektur **Laravel Clean Code** dengan fokus utama pada ketepatan perhitungan stok otomatis, keamanan mutasi barang, integritas data terelasi, serta *User Interface (UI)* berbasis SaaS Enterprise dengan skema warna *Sea Blue Gradient & Glassmorphism*.

### 💡 Masalah yang Diselesaikan:
- ❌ **Human Error Perhitungan Stok:** Mencegah pencatatan stok negatif dan penghapusan item/kategori yang masih memiliki keterikatan data transaksi/stok aktif.
- ❌ **Fleksibilitas Satuan (Unit of Measurement):** Mendukung konversi otomatis stok desimal (Gram, KG, Ons, Mililiter, Liter) vs satuan utuh (Box, Pack, Pcs).
- ❌ **Data Inconsistency:** Penerapan validasi ketat di sisi server (Form Request & Eloquent Guard) serta *Soft Deletes* untuk mencegah data hilang tidak sengaja.

---

## ✨ Fitur Unggulan

### 🛍️ 1. Master Barang & Kategori Seamless (Unified UI)
- **Modal Overlay Form:** Penambahan kategori baru dapat dilakukan langsung di dalam halaman Master Barang tanpa perlu pindah halaman (*Seamless UX*).
- **Proteksi Hapus Kategori:** Kategori yang sedang digunakan oleh barang aktif tidak dapat dihapus dan akan memunculkan *alert warning* dinamis.

### ⚖️ 2. Smart UoM & Precision Stock Logic
- **Precision Decimal Support:** Tipe data `DECIMAL(10,3)` pada database mendukung akurasi stok hingga tingkat Gram dan Mililiter.
- **Strict Decimal Validation:** Mencegah pecahan desimal untuk satuan barang utuh (contoh: tidak bisa memasukkan 1.5 Box atau 2.3 Pack).
- **Proteksi Stok Aktif:** Barang yang masih memiliki `current_stock > 0` terlindungi dari aksi penghapusan.

### 🏢 3. Manajemen Database Klien (SPPG)
- Pencatatan unit penerima distribusi pangan lengkap dengan alamat pengiriman dan kontak.
- Integrasi penuh ke modul transaksi barang keluar.

### 🛡️ 4. Keamanan & Integritas Data Enterprise
- **CSRF Protection & HTTP Method Enforcement:** Menggunakan standar RESTful HTTP Method (`POST`, `DELETE`, `PUT`) untuk mencegah kerentanan keamanan pada operasi sensitif.
- **Soft Deletes:** Fitur penghapusan aman untuk riwayat data tanpa merusak dependensi relasi database.

---

## 🎨 Pratinjau Tampilan UI / UX

<details>
<summary>📸 <b>Klik untuk melihat Screenshot Antarmuka Modern</b></summary>

<br/>

| Halaman | Deskripsi |
| :--- | :--- |
| **Master Barang & Modal** | Tampilan *clean grid* dilengkapi indikator warna status stok kritis & modal form overlay |
| **Database Klien (SPPG)** | Tabel responsif modern dengan *Sea Blue Gradient Hero Header* |
| **Validasi & Notification** | Tampilan *Alert System* interaktif (Success, Danger, & Warning) |

</details>

---

## 🛠️ Arsitektur & Skema Database

Sistem ini dirancang menggunakan prinsip **Database Normalization (3NF)** dengan relasi antar tabel berikut:

```mermaid
erDiagram
    tb_categories ||--o{ tb_items : "memiliki"
    tb_items ||--o{ tb_transactions : "mencatat"
    tb_clients ||--o{ tb_transactions : "menerima"
    users ||--o{ tb_transactions : "mencatat"

    tb_categories {
        bigint category_id PK
        string category_name
        text description
    }

    tb_items {
        bigint item_id PK
        bigint category_id FK
        string sku
        string item_name
        enum jenis_satuan
        string satuan_dasar
        decimal current_stock
        decimal min_stock_alert
    }

    tb_clients {
        bigint client_id PK
        string nama_sppg
        text alamat_sppg
    }

    tb_transactions {
        bigint trx_id PK
        bigint item_id FK
        bigint client_id FK
        bigint user_id FK
        enum type
        decimal quantity
        date date_recorded
    }
