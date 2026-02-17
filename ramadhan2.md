Siap! Ini adalah **Product Requirements Document (PRD)** yang lebih detail dan terstruktur untuk proyek **SITARA**. Dokumen ini dirancang agar kamu punya *roadmap* yang jelas saat mulai melakukan `php artisan make:model` di terminal Pop!_OS kamu.

---

# **Product Requirements Document (PRD): SITARA**

**Project Name:** Sistem Informasi TPA Ramadan (SITARA)

**Version:** 1.0

**Stack Recommendation:** Laravel 11, MySQL, Tailwind CSS, Alpine.js (TALL Stack) atau Livewire.

---

## **1. Executive Summary**

SITARA adalah platform web manajemen TPA yang bertujuan untuk menggantikan pencatatan manual selama bulan Ramadan. Fokus utamanya adalah meningkatkan motivasi santri melalui **Gamifikasi (Leaderboard)** dan transparansi kepada orang tua serta donatur melalui dashboard yang mudah diakses.

---

## **2. Target Pengguna (User Personas)**

| Role | Deskripsi | Kebutuhan Utama |
| --- | --- | --- |
| **Admin (Remaja)** | Panitia pengelola TPA | Scan QR kehadiran, input nilai hafalan, kelola kas. |
| **Santri** | Peserta kegiatan TPA | Lihat total poin dan posisi di leaderboard. |
| **Orang Tua** | Wali dari santri | Memantau kehadiran anak dan melihat galeri kegiatan. |
| **Donatur** | Warga desa penyumbang dana | Melihat laporan penggunaan uang secara transparan. |

---

## **3. Spesifikasi Fitur (Functional Requirements)**

### **F1: Manajemen Santri & QR Auth**

* **Generate Unique QR:** Sistem otomatis membuat QR Code unik untuk setiap santri saat data diinput.
* **Printable ID Card:** Fitur untuk mencetak kartu ID santri yang berisi nama dan QR Code.
* **Mobile Scanner:** Dashboard admin yang bisa mengakses kamera HP untuk scanning tanpa aplikasi tambahan.

### **F2: Mesin Gamifikasi (Point System)**

* **Daily Points:** Poin otomatis bertambah saat scan kehadiran (misal: 10 poin).
* **Achievement Points:** Input manual untuk hafalan (20 poin) atau perilaku terpuji (5-10 poin).
* **Leaderboard:** Halaman publik yang diurutkan berdasarkan `total_points` secara *descending*.

### **F3: Transparansi Keuangan**

* **Ledger Digital:** Pencatatan setiap rupiah yang masuk (donasi) dan keluar (takjil/hadiah).
* **Summary Widget:** Menampilkan saldo kas saat ini secara *real-time* di homepage.

### **F4: Repositori Materi & Galeri**

* **Daily Material:** Admin bisa upload teks atau embed video YouTube untuk dipelajari santri di rumah.
* **Photo Feed:** Galeri foto kegiatan harian yang ringan (kompresi otomatis agar hemat storage).

---

## **4. Arsitektur Data (Database Schema)**

Karena kamu suka desain database yang terorganisir, berikut adalah gambaran tabel utamanya:

* **`users`**: Auth standar Laravel (untuk login Admin/Remaja).
* **`santris`**: `id`, `name`, `parent_name`, `address`, `qr_token`, `total_points`.
* **`attendances`**: `id`, `santri_id`, `date`, `check_in_time`, `points_gained`.
* **`achievements`**: `id`, `santri_id`, `type` (hafalan/adab), `description`, `points`.
* **`finances`**: `id`, `amount`, `category` (income/expense), `description`, `date`.

---

## **5. Kebutuhan Non-Fungsional**

1. **Mobile First:** 90% akses akan menggunakan smartphone (terutama saat scanning).
2. **Lightweight:** Website harus cepat dibuka meski di jaringan 3G/pedesaan.
3. **Local Development:** Mendukung dijalankan di local server (XAMPP/Laravel Sail) jika ingin demo offline.

---

## **6. User Stories**

> **Sebagai Admin,** saya ingin melakukan scan QR anak-anak dalam waktu kurang dari 2 detik per anak agar tidak terjadi antrean saat pembukaan TPA.

> **Sebagai Orang Tua,** saya ingin melihat posisi anak saya di leaderboard agar saya bisa memberikan semangat tambahan di rumah.

---

## **7. Roadmap Pengembangan (1 Bulan)**

* **Minggu 1:** Setup Laravel, Migrasi Database, & CRUD Santri + QR Generator.
* **Minggu 2:** Fitur Scanner (JS-based) & Logika Penambahan Poin.
* **Minggu 3:** Dashboard Finansial, Leaderboard, & UI/UX Styling.
* **Minggu 4:** Testing di lapangan, Input data awal, & Launching saat 1 Ramadan.

---

Bagaimana menurutmu? Jika PRD ini sudah "oke", apakah kamu ingin saya buatkan **file Migration Laravel** atau **Logic di Controller** untuk fitur **Scan QR dan Point System**-nya?
