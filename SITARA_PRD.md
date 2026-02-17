# Product Requirements Document (PRD)

# SITARA - Sistem Informasi TPA Ramadan

**Version:** 2.0  
**Tanggal:** 6 Februari 2026  
**Penyelenggara:** REIMAKE (Remaja Islam Masjid Kemasan)  
**Stack:** Laravel 11, MySQL, Tailwind CSS, Alpine.js/Livewire

---

## 1. Executive Summary

SITARA adalah platform web manajemen TPA (Taman Pendidikan Al-Quran) yang dikembangkan oleh **REIMAKE (Remaja Islam Masjid Kemasan)** untuk menggantikan pencatatan manual selama bulan Ramadan. Platform ini fokus pada:

- **Gamifikasi** - Meningkatkan motivasi santri melalui sistem poin dan leaderboard
- **Transparansi** - Dashboard yang mudah diakses untuk orang tua dan donatur
- **Efisiensi** - QR-based attendance untuk mengurangi antrean

---

## 2. Target Pengguna (User Personas)

| Role                | Deskripsi                     | Kebutuhan Utama                                 | Akses                |
| ------------------- | ----------------------------- | ----------------------------------------------- | -------------------- |
| **Admin (REIMAKE)** | Anggota REIMAKE pengelola TPA | Scan QR, input nilai, kelola kas, upload materi | Full access (login)  |
| **Santri**          | Peserta kegiatan TPA          | Lihat poin dan posisi leaderboard               | View only (public)   |
| **Orang Tua**       | Wali dari santri              | Pantau kehadiran anak, lihat progress           | Link unik per santri |
| **Donatur**         | Warga penyumbang dana         | Lihat laporan keuangan transparan               | View only (public)   |

---

## 3. Spesifikasi Fitur

### F1: Manajemen Santri & QR Authentication

| Fitur              | Deskripsi                                | Prioritas |
| ------------------ | ---------------------------------------- | --------- |
| Generate QR Code   | QR unik otomatis saat santri didaftarkan | 🔴 High   |
| Printable ID Card  | Cetak kartu ID (nama + QR) format PDF    | 🟡 Medium |
| Mobile Scanner     | Akses kamera HP via browser (tanpa app)  | 🔴 High   |
| Parent Portal Link | Generate link unik untuk orang tua       | 🟡 Medium |

**Technical Notes:**

- QR Token: UUID v4 (36 karakter)
- Scanner: Gunakan library `html5-qrcode` atau `instascan`
- Validasi: Token + timestamp untuk anti-replay attack

---

### F2: Gamifikasi (Point System)

| Aktivitas         | Poin Default | Trigger                            |
| ----------------- | ------------ | ---------------------------------- |
| Kehadiran (hadir) | +10          | Auto saat scan QR                  |
| Kehadiran (izin)  | +5           | Input manual admin                 |
| Hafalan surah     | +15 - +30    | Input manual (berdasarkan panjang) |
| Perilaku terpuji  | +5 - +10     | Input manual admin                 |
| Bonus mingguan    | +25          | Hadir 7 hari berturut              |

**Leaderboard Rules:**

- Diurutkan berdasarkan `total_points` descending
- Tampilkan Top 10 di homepage
- Full leaderboard di halaman terpisah
- Refresh setiap 5 menit (cache)

---

### F3: Transparansi Keuangan

| Fitur              | Deskripsi                                              | Prioritas |
| ------------------ | ------------------------------------------------------ | --------- |
| Digital Ledger     | Catat pemasukan (donasi) & pengeluaran (takjil/hadiah) | 🔴 High   |
| Saldo Widget       | Tampilkan saldo real-time di homepage                  | 🔴 High   |
| Laporan Bulanan    | Export rekap keuangan (PDF)                            | 🟢 Low    |
| Kategori Transaksi | Tag: donasi, takjil, hadiah, operasional               | 🟡 Medium |

---

### F4: Repositori Materi & Galeri

| Fitur          | Deskripsi                            | Prioritas |
| -------------- | ------------------------------------ | --------- |
| Daily Material | Upload teks/embed YouTube            | 🟡 Medium |
| Photo Gallery  | Upload foto kegiatan (auto compress) | 🟡 Medium |
| Arsip Materi   | Akses materi hari-hari sebelumnya    | 🟢 Low    |

**Technical Notes:**

- Max image size: 2MB (compress ke 500KB)
- Format: JPG/PNG/WebP
- Storage: Local disk atau S3-compatible

---

## 4. Database Schema

### Tabel Utama

```
┌─────────────────────────────────────────────────────────────┐
│                          users                               │
├─────────────────────────────────────────────────────────────┤
│ id, name, email, password, role (admin), timestamps          │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                         santris                              │
├─────────────────────────────────────────────────────────────┤
│ id, name, parent_name, parent_phone, address,                │
│ birth_date, qr_token (unique), parent_access_token,          │
│ total_points (default: 0), avatar, timestamps, deleted_at    │
└─────────────────────────────────────────────────────────────┘
          │                    │
          ▼                    ▼
┌──────────────────┐  ┌──────────────────┐
│   attendances    │  │   achievements   │
├──────────────────┤  ├──────────────────┤
│ id               │  │ id               │
│ santri_id (FK)   │  │ santri_id (FK)   │
│ date             │  │ type (enum)      │
│ status (enum)    │  │ description      │
│ check_in_time    │  │ points           │
│ points_gained    │  │ created_by (FK)  │
│ timestamps       │  │ timestamps       │
└──────────────────┘  └──────────────────┘

┌──────────────────┐  ┌──────────────────┐
│    finances      │  │    materials     │
├──────────────────┤  ├──────────────────┤
│ id               │  │ id               │
│ type (enum)      │  │ title            │
│ category         │  │ content (text)   │
│ amount           │  │ video_url        │
│ description      │  │ date             │
│ date             │  │ created_by (FK)  │
│ created_by (FK)  │  │ timestamps       │
│ timestamps       │  └──────────────────┘
└──────────────────┘
                      ┌──────────────────┐
                      │    galleries     │
                      ├──────────────────┤
                      │ id               │
                      │ image_path       │
                      │ caption          │
                      │ date             │
                      │ created_by (FK)  │
                      │ timestamps       │
                      └──────────────────┘
```

### Enum Values

| Tabel        | Field    | Values                                                 |
| ------------ | -------- | ------------------------------------------------------ |
| attendances  | status   | `hadir`, `izin`, `sakit`, `alpha`                      |
| achievements | type     | `hafalan`, `adab`, `partisipasi`, `lainnya`            |
| finances     | type     | `income`, `expense`                                    |
| finances     | category | `donasi`, `takjil`, `hadiah`, `operasional`, `lainnya` |

---

## 5. User Stories

### Admin Stories

> **US-01:** Sebagai Admin, saya ingin scan QR santri dalam waktu < 2 detik agar tidak terjadi antrean saat pembukaan TPA.

> **US-02:** Sebagai Admin, saya ingin input poin hafalan dengan cepat agar tidak mengganggu jadwal kegiatan.

> **US-03:** Sebagai Admin, saya ingin mencatat setiap transaksi keuangan agar laporan transparan.

### Santri Stories

> **US-04:** Sebagai Santri, saya ingin melihat posisi saya di leaderboard agar termotivasi untuk hadir setiap hari.

> **US-05:** Sebagai Santri, saya ingin melihat poin harian saya agar tahu progress saya.

### Orang Tua Stories

> **US-06:** Sebagai Orang Tua, saya ingin melihat kehadiran anak via link khusus agar bisa memantau tanpa login.

> **US-07:** Sebagai Orang Tua, saya ingin melihat posisi anak di leaderboard agar bisa memberikan semangat di rumah.

### Donatur Stories

> **US-08:** Sebagai Donatur, saya ingin melihat laporan penggunaan dana agar yakin donasi saya digunakan dengan baik.

---

## 6. Non-Functional Requirements

### Performance

| Metric           | Target                 |
| ---------------- | ---------------------- |
| Page Load Time   | < 3 detik (3G network) |
| QR Scan Response | < 2 detik              |
| Concurrent Users | 50 users               |

### Security

- [ ] HTTPS enforcement
- [ ] CSRF protection (Laravel default)
- [ ] QR token validation + timestamp
- [ ] Rate limiting: 30 scans/menit per admin
- [ ] Parent access token: UUID + expire 90 hari

### Compatibility

- [ ] Mobile First (min 360px width)
- [ ] Browser: Chrome, Safari, Firefox (latest 2 versions)
- [ ] PWA ready (offline scanner - future)

### Hosting

- [ ] Support XAMPP/Laravel Sail (local demo)
- [ ] VPS friendly (1GB RAM minimum)
- [ ] SQLite fallback untuk demo

---

## 7. Roadmap Pengembangan

### Minggu 1: Foundation

| Hari | Task                                                        |
| ---- | ----------------------------------------------------------- |
| 1-2  | Setup Laravel 11, konfigurasi database, auth scaffolding    |
| 3-4  | Migration + Model: `santris`, `attendances`, `achievements` |
| 5-6  | CRUD Santri + QR Generator                                  |
| 7    | Testing + Bug fixing                                        |

### Minggu 2: Core Features

| Hari | Task                                        |
| ---- | ------------------------------------------- |
| 1-2  | Mobile Scanner (JS-based) + Scan API        |
| 3-4  | Point System logic + Auto attendance points |
| 5-6  | Achievement input + Point calculation       |
| 7    | Leaderboard public page                     |

### Minggu 3: Dashboard & Content

| Hari | Task                              |
| ---- | --------------------------------- |
| 1-2  | Financial CRUD + Summary widget   |
| 3-4  | Materials module + Gallery upload |
| 5-6  | Parent portal (view-only link)    |
| 7    | UI/UX polish dengan Tailwind      |

### Minggu 4: Launch Prep

| Hari | Task                                   |
| ---- | -------------------------------------- |
| 1-2  | Internal testing + Bug fixing          |
| 3-4  | Input data santri awal                 |
| 5    | Soft launch (trial run)                |
| 6-7  | Buffer untuk fixes + Go live 1 Ramadan |

---

## 8. Success Metrics

| Metric                 | Target                  | Cara Ukur                       |
| ---------------------- | ----------------------- | ------------------------------- |
| Adoption Rate          | 90% santri terdaftar    | Count santris with QR           |
| Daily Active Scans     | 80% kehadiran           | attendances / santris \* 100    |
| Parent Engagement      | 50% link diakses        | Track parent_access_token usage |
| Financial Transparency | 100% transaksi tercatat | Zero unrecorded transactions    |

---

## 9. Out of Scope (v1.0)

Berikut fitur yang **tidak** termasuk dalam versi pertama:

- ❌ Mobile app (Android/iOS)
- ❌ Notifikasi WhatsApp/SMS
- ❌ Multi-TPA support
- ❌ Payment gateway integration
- ❌ Advanced analytics dashboard

---

## 10. Appendix

### A. Wireframe References

_To be added_

### B. API Endpoints (Draft)

```
POST   /api/auth/login
POST   /api/scan/{qr_token}
GET    /api/leaderboard
GET    /api/santri/{parent_token}
GET    /api/finances/summary
```

### C. Tech Stack Detail

| Layer         | Technology                       |
| ------------- | -------------------------------- |
| Backend       | Laravel 11                       |
| Database      | MySQL 8.0 / SQLite               |
| Frontend      | Blade + Tailwind CSS             |
| Interactivity | Alpine.js / Livewire             |
| QR Library    | `simplesoftwareio/simple-qrcode` |
| Scanner       | `html5-qrcode` (npm)             |

---

**Document Owner:** REIMAKE (Remaja Islam Masjid Kemasan)  
**Last Updated:** 6 Februari 2026
