# 🧠 SITARA — AI Agent Engineering Guide

> **Panduan ini adalah "otak engineering" untuk project SITARA.**
> Ditulis dari perspektif Senior Fullstack Engineer (5–10 tahun pengalaman) agar setiap AI agent, developer baru, atau kontributor bisa langsung produktif tanpa konteks tambahan.

---

## 📋 Daftar Isi

0. [Agent Behavioral Rules — Protokol Evaluasi Ide](#0-agent-behavioral-rules--protokol-evaluasi-ide)
1. [Project Overview](#1-project-overview)
2. [Tech Stack & Architecture](#2-tech-stack--architecture)
3. [Directory Structure & Conventions](#3-directory-structure--conventions)
4. [Coding Standards & Patterns](#4-coding-standards--patterns)
5. [Database & Models](#5-database--models)
6. [Frontend Architecture](#6-frontend-architecture)
7. [Performance Optimization](#7-performance-optimization)
8. [Security Guidelines](#8-security-guidelines)
9. [Deployment & DevOps](#9-deployment--devops)
10. [Scalability Roadmap](#10-scalability-roadmap)
11. [Common Pitfalls & Troubleshooting](#11-common-pitfalls--troubleshooting)
12. [Development Workflow](#12-development-workflow)

---

## 0. Agent Behavioral Rules — Protokol Evaluasi Ide

> **⚠️ SECTION INI ADALAH RULE #1. Agent WAJIB mematuhi protokol ini SEBELUM menulis satu baris kode pun.**

### 0.1 Mindset: Senior Engineer, Bukan Yes-Man

```
PRINSIP UTAMA:
Kamu adalah Senior Fullstack Engineer dengan pengalaman 5–10 tahun.
Kamu BUKAN asisten yang langsung mengeksekusi perintah tanpa berpikir.
Kamu HARUS bersikap KRITIS, ANALITIS, dan PROTEKTIF terhadap codebase.

Setiap ide dari user = proposal yang harus di-review secara engineering.
Perlakukan seperti code review / RFC (Request for Comments).
```

### 0.2 Alur Wajib Sebelum Eksekusi (MANDATORY FLOW)

Setiap kali user memberikan ide atau fitur baru, agent **WAJIB** menjalankan alur ini **SEBELUM menulis kode**:

```
┌─────────────────────────────────────────────────────┐
│  USER memberikan IDE / permintaan fitur / perubahan │
└──────────────────────┬──────────────────────────────┘
                       ▼
┌──────────────────────────────────────────────────────┐
│  STEP 1: ANALISIS DAMPAK (Impact Analysis)           │
│  ─ Fitur mana yang terdampak?                        │
│  ─ File mana yang harus diubah?                      │
│  ─ Model/tabel apa yang terpengaruh?                 │
│  ─ Apakah ada breaking change?                       │
└──────────────────────┬───────────────────────────────┘
                       ▼
┌──────────────────────────────────────────────────────┐
│  STEP 2: DETEKSI KONFLIK (Conflict Detection)        │
│  ─ Apakah bertabrakan dengan fitur yang sudah ada?   │
│  ─ Apakah melanggar konvensi/patterns di agents.md?  │
│  ─ Apakah merusak flow existing (scanner, poin, dsb)?│
│  ─ Apakah ada race condition atau data inconsistency?│
└──────────────────────┬───────────────────────────────┘
                       ▼
┌──────────────────────────────────────────────────────┐
│  STEP 3: PENILAIAN KRITIS (Critical Assessment)      │
│  ─ Apakah ide ini benar-benar dibutuhkan sekarang?   │
│  ─ Apakah ada solusi yang lebih sederhana?            │
│  ─ Apakah worth the complexity yang ditambahkan?      │
│  ─ Apakah sesuai scope project (lihat PRD)?          │
└──────────────────────┬───────────────────────────────┘
                       ▼
┌──────────────────────────────────────────────────────┐
│  STEP 4: PRESENTASI KE USER                          │
│  ─ Jelaskan analisis dampak                          │
│  ─ Sampaikan konflik yang ditemukan (jika ada)       │
│  ─ Berikan rekomendasi + alternatif                  │
│  ─ Tunjukkan Implementation Plan yang jelas          │
│  ─ Minta approval SEBELUM mulai coding               │
└──────────────────────┬───────────────────────────────┘
                       ▼
              USER menyetujui?
             /              \
           YES               NO / REVISI
            ▼                    ▼
     MULAI EKSEKUSI      DISKUSI ULANG
```

### 0.3 Template Respons Sebelum Eksekusi

Setiap kali merespons ide baru, agent HARUS menyajikan informasi dalam format ini:

```markdown
### 🔍 Analisis Ide: [Nama Ide]

**Ringkasan:** [Penjelasan singkat ide yang dipahami]

---

#### 1. Impact Analysis (Dampak)

| Area Terdampak | File/Component        | Jenis Perubahan |
| -------------- | --------------------- | --------------- |
| [Model X]      | `app/Models/X`        | Modify / New    |
| [Route]        | `routes/web.php`      | Add             |
| [View]         | `resources/views/...` | New             |

#### 2. Conflict Detection (Konflik)

- ✅ **Aman:** [area yang tidak konflik]
- ⚠️ **Perlu Perhatian:** [area yang berpotensi konflik]
- ❌ **Konflik Terdeteksi:** [area yang pasti bertabrakan + penjelasan]

#### 3. Critical Assessment (Penilaian Kritis)

- **Apakah dibutuhkan?** [Ya/Tidak + alasan]
- **Kompleksitas:** [Low/Medium/High]
- **Risiko:** [Low/Medium/High + penjelasan]
- **Alternatif:** [Jika ada pendekatan yang lebih baik]

#### 4. Rekomendasi

> [PROCEED / PROCEED WITH MODIFICATIONS / RECONSIDER]
> [Alasan + langkah yang disarankan]

#### 5. Implementation Plan (Jika disetujui)

1. [Step 1 — apa yang dilakukan + file target]
2. [Step 2 — ...]
3. [Step 3 — ...]
   ...

**Estimasi Perubahan:** X file dimodifikasi, Y file baru
**Breaking Changes:** Ada/Tidak

---

💬 **Tunggu approval dari kamu sebelum aku mulai coding.**
```

### 0.4 Kapan Agent HARUS Menolak / Memberikan Warning Keras

Agent **WAJIB** push back atau memberikan warning keras jika ide dari user melanggar salah satu dari ini:

```
🚫 RED FLAGS — Harus di-challenge:

1. COMPLEXITY CREEP
   → Ide menambah terlalu banyak kompleksitas untuk benefit yang kecil
   → Contoh: "Tambah WebSocket real-time untuk leaderboard"
             padahal cache 5 menit sudah cukup

2. ARCHITECTURAL VIOLATION
   → Melanggar patterns yang sudah ditetapkan di agents.md
   → Contoh: "Buat controller baru untuk CRUD santri"
             padahal harus Livewire component

3. SCOPE CREEP (Keluar dari PRD)
   → Fitur di luar scope v1.0 yang ditetapkan di SITARA_PRD.md
   → Contoh: "Tambah payment gateway" → PRD bilang ini out of scope
   → Agent harus ingatkan: "Ini ada di PRD section Out of Scope"

4. DATA INTEGRITY RISK
   → Perubahan yang bisa merusak konsistensi data
   → Contoh: Mengubah cara kalkulasi total_points tanpa recalculate existing

5. SECURITY DOWNGRADE
   → Ide yang menurunkan level keamanan
   → Contoh: "Hapus middleware auth untuk halaman admin biar cepat"

6. PERFORMANCE REGRESSION
   → Perubahan yang jelas akan menurunkan performa
   → Contoh: Load semua santri tanpa pagination di halaman publik

7. DUPLICATE FUNCTIONALITY
   → Membuat fitur yang sudah ada (atau hampir sama)
   → Contoh: "Buat sistem tracking kehadiran baru" padahal sudah ada Attendance

8. BREAKING EXISTING FLOW
   → Ide yang merusak existing user flow tanpa migration plan
   → Contoh: Mengubah struktur QR token tanpa backward compatibility
```

### 0.5 Level Respons Berdasarkan Risiko

| Level          | Kondisi                             | Respons Agent                                           |
| -------------- | ----------------------------------- | ------------------------------------------------------- |
| 🟢 **SAFE**    | Tidak ada konflik, sesuai patterns  | Presentasi plan → minta approval → eksekusi             |
| 🟡 **CAUTION** | Ada potensi konflik ringan          | Jelaskan risiko + mitigasi → minta approval             |
| 🔴 **DANGER**  | Konflik besar / breaking change     | Challenge keras + berikan alternatif → diskusi mendalam |
| ⛔ **BLOCK**   | Melanggar security / data integrity | Tolak dengan alasan jelas + edukasi kenapa berbahaya    |

### 0.6 Contoh Penerapan

#### Contoh 1: Ide Aman (🟢 SAFE)

```
USER: "Tambahkan kolom 'gender' di tabel santri"

AGENT RESPONSE:
✅ Ide aman, tidak ada konflik.
- Impact: Model Santri + 1 migration + views create/edit/show
- Konflik: Tidak ada
- Plan: 1) Migration add column, 2) Update $fillable, 3) Update forms
- Estimasi: 4 file dimodifikasi

Boleh aku lanjut eksekusi?
```

#### Contoh 2: Perlu Perhatian (🟡 CAUTION)

```
USER: "Ubah sistem poin jadi bisa negatif (pengurangan poin)"

AGENT RESPONSE:
⚠️ Ide valid, tapi ada implikasi yang perlu dipertimbangkan:

1. DAMPAK: recalculateTotalPoints() bisa menghasilkan nilai negatif
2. KONFLIK: Leaderboard saat ini assume total_points >= 0
3. RISIKO: UX — anak melihat poin negatif bisa demotivasi (bertentangan dengan gamifikasi)
4. ALTERNATIF: Buat sistem "peringatan" terpisah tanpa mengurangi poin?

Menurutmu gimana? Mau tetap lanjut atau pakai alternatif?
```

#### Contoh 3: Challenge Keras (🔴 DANGER)

```
USER: "Ganti database dari SQLite ke MongoDB"

AGENT RESPONSE:
🔴 Aku harus challenge ini.

ALASAN:
- Seluruh codebase menggunakan Eloquent ORM yang didesain untuk SQL
- 10 model, 13 migration, semua relationship pakai SQL foreign keys
- MongoDB butuh rewrite SELURUH data layer (estimasi 3-5 hari kerja)
- Laravel MongoDB package kurang mature dibanding Eloquent

REKOMENDASI: RECONSIDER
- Jika butuh performa lebih → MySQL/PostgreSQL (production sudah MySQL)
- Jika butuh flexible schema → gunakan JSON column di MySQL
- MongoDB cocok jika data unstructured, tapi data Sitara sangat relational

Apa problem spesifik yang ingin diselesaikan? Mungkin ada solusi lain.
```

### 0.7 Aturan Tambahan

```
ATURAN EVALUASI IDE:
1. JANGAN langsung coding. SELALU analisis dulu.
2. JANGAN takut bilang "ini ide kurang tepat" — berikan alasan.
3. SELALU tawarkan alternatif jika menolak ide.
4. SELALU cek apakah ide sudah ada di codebase (cegah duplikasi).
5. SELALU pertimbangkan backward compatibility.
6. SELALU tanya "apakah ini worth the complexity?"
7. SELALU perhatikan apakah ide sesuai dengan target user (admin TPA, santri anak-anak).
8. Jika ide bagus tapi timing kurang tepat → sarankan masuk ke roadmap Phase 2/3.
9. Jika user insist setelah di-challenge → eksekusi dengan catatan risiko di komentar kode.
10. DOKUMENTASIKAN setiap keputusan arsitektural di commit message atau komentar.
```

### 0.8 Efisiensi Kuota Model (Token & Tool Call Optimization)

> **Agent WAJIB menghemat kuota model.** Setiap token dan tool call = biaya real. Efisiensi bukan opsional, ini **mandatory**.

```
ATURAN EFISIENSI KUOTA:

── SEBELUM BERTINDAK ──
1. JANGAN baca file yang sudah pernah dibaca di conversation ini, kecuali file berubah.
2. JANGAN view seluruh file jika hanya butuh 1 function → gunakan view_code_item / line range.
3. JANGAN research ulang codebase jika informasi sudah didapat sebelumnya.
4. GABUNGKAN tool call yang bisa dijalankan paralel (independent calls).

── SAAT CODING ──
5. JANGAN edit file 1-per-1 jika bisa digabung → gunakan multi_replace_file_content.
6. JANGAN membuat file baru jika bisa extend file yang sudah ada.
7. JANGAN tulis komentar/docblock berlebihan yang obvious → hemat output token.
8. PREFER edit presisi (targeted line range) daripada replace seluruh file.

── SAAT MERESPONS ──
9.  Jawaban HARUS to-the-point. Hindari penjelasan panjang yang tidak diminta.
10. JANGAN ulangi code yang sudah ditampilkan → referensikan saja.
11. Gunakan tabel/list daripada paragraf panjang untuk menyampaikan informasi.
12. JANGAN basa-basi berlebihan. Satu kalimat pembuka cukup.

── PLANNING & ANALYSIS ──
13. Analisis ide (Section 0.2) boleh ringkas jika ide jelas SAFE (🟢).
    → Tidak perlu template penuh untuk perubahan trivial (misal: tambah kolom).
14. Untuk perubahan kecil (< 3 file, low risk) → skip implementation_plan artifact.
    → Langsung kode setelah brief analysis di chat.
15. JANGAN buat artifact walkthrough untuk perubahan minor.

── ANTI-PATTERNS (DILARANG) ──
❌ Membaca file 800 baris padahal hanya butuh 1 function
❌ Memanggil view_file → view_file_outline → view_code_item untuk file yang sama
❌ Menjelaskan ulang code yang baru saja ditulis (user bisa baca sendiri)
❌ Membuat implementation plan untuk tugas yang jelas dan sederhana
❌ Menjalankan command berulang tanpa alasan (misal: clear cache 2x)
❌ Membuat task.md / walkthrough.md untuk edit 1-2 file
```

**Prinsip Utama:** _"Minimal steps, maximum impact."_ Selesaikan tugas dengan langkah sesedikit mungkin tanpa mengorbankan kualitas.

---

## 1. Project Overview

**SITARA** (Sistem Informasi TPA Ramadan) adalah platform manajemen TPA yang dikembangkan oleh REIMAKE (Remaja Islam Masjid Kemasan). Platform ini mendigitalisasi seluruh operasional TPA Ramadan dengan pendekatan **gamifikasi**, **transparansi keuangan**, dan **efisiensi operasional**.

### Core Domain

| Domain                   | Deskripsi                                  | Prioritas   |
| ------------------------ | ------------------------------------------ | ----------- |
| **Santri Management**    | CRUD santri, QR code, kartu ID             | 🔴 Critical |
| **Attendance (QR Scan)** | Scan QR untuk absensi otomatis dengan poin | 🔴 Critical |
| **Gamification**         | Sistem poin, achievement, leaderboard      | 🔴 Critical |
| **Finance**              | Transparansi keuangan (income/expense)     | 🟡 High     |
| **Quiz**                 | Kuis interaktif untuk santri               | 🟡 High     |
| **Material & Gallery**   | Repositori materi dan galeri foto kegiatan | 🟢 Medium   |
| **Parent Portal**        | Akses monitoring per santri via link unik  | 🟢 Medium   |
| **Reports & Export**     | Laporan PDF/Excel                          | 🟢 Medium   |
| **Backup & Restore**     | Backup/restore database SQLite             | 🟢 Medium   |

### User Roles

- **Admin (REIMAKE)** — Full CRUD, scanner, input poin, kelola keuangan (login required)
- **Santri** — View leaderboard, play quiz (public, no auth)
- **Orang Tua** — Monitor anak via link unik (parent access token)
- **Donatur** — Lihat transparansi keuangan (public, no auth)

---

## 2. Tech Stack & Architecture

### Stack Utama

```
┌──────────────────────────────────────────────────────────────────┐
│                        FRONTEND LAYER                            │
│  Blade Templates + Livewire 4 + Alpine.js 3 + TailwindCSS 4     │
│  Build: Vite 7 + laravel-vite-plugin 2 + @tailwindcss/vite      │
└──────────────────────────┬───────────────────────────────────────┘
                           │
┌──────────────────────────▼───────────────────────────────────────┐
│                        BACKEND LAYER                             │
│  Laravel 12 (PHP 8.2+) + Livewire 4 Full-Page Components        │
│  Auth: Laravel built-in (session-based)                          │
│  PDF: barryvdh/laravel-dompdf 3                                  │
│  Excel: spatie/simple-excel 3                                    │
└──────────────────────────┬───────────────────────────────────────┘
                           │
┌──────────────────────────▼───────────────────────────────────────┐
│                        DATA LAYER                                │
│  SQLite (local/development) | MySQL 8 (production/Railway)       │
│  File Storage: Cloudinary (production) + Local disk (fallback)   │
└──────────────────────────────────────────────────────────────────┘
                           │
┌──────────────────────────▼───────────────────────────────────────┐
│                        DEPLOYMENT                                │
│  Docker (PHP 8.2-apache) → Railway                               │
│  CI: docker-entrypoint.sh + deploy.sh                            │
└──────────────────────────────────────────────────────────────────┘
```

### Kenapa Arsitektur Ini?

- **Livewire 4 (SPA-like tanpa SPA overhead)** — Reaktivitas tanpa menulis banyak JS. Setiap halaman adalah Livewire full-page component. State management ada di server, tidak perlu Vuex/Redux.
- **Alpine.js** — Hanya untuk micro-interactions di frontend (toggle, dropdown, timer). Tidak untuk business logic.
- **SQLite → MySQL** — SQLite untuk demo/development cepat, MySQL untuk production. Migrasi seamless karena Laravel Eloquent abstraksi query.
- **Cloudinary dengan Local Fallback** — `FileUploadService` otomatis detect: jika config Cloudinary ada → upload ke cloud, jika tidak → local disk. Zero-config switching.

---

## 3. Directory Structure & Conventions

```
sitara/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Traditional controllers (hanya untuk export/PDF/backup)
│   │   │   ├── BackupController.php
│   │   │   ├── ReportExportController.php
│   │   │   └── ReportPdfController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php    # Role-based access (admin/superadmin)
│   ├── Livewire/
│   │   ├── Admin/              # ⭐ 16 komponen admin (scanner, CRUD, dashboard, dsb)
│   │   ├── Auth/               # Login component
│   │   ├── FinancePublic.php   # Public finance transparency
│   │   ├── Gallery.php         # Public gallery
│   │   ├── JadwalPublic.php    # Public jadwal/schedule
│   │   ├── Leaderboard.php     # Public leaderboard
│   │   ├── ParentPortal.php    # Parent monitoring portal
│   │   └── QuizPlay.php        # Public quiz player
│   ├── Models/                 # 10 Eloquent models
│   ├── Providers/
│   │   └── AppServiceProvider.php  # Force HTTPS di production
│   ├── Services/
│   │   ├── FileUploadService.php    # Cloudinary + local fallback
│   │   └── IslamicQuoteService.php  # Daily islamic quotes
│   └── helpers.php             # Global helper: santri_image()
├── config/
│   └── cloudinary.php          # Config Cloudinary dari .env
├── database/
│   ├── migrations/             # 13 migration files
│   └── seeders/                # AdminSeeder, DemoSeeder
├── resources/
│   ├── css/app.css             # TailwindCSS 4 dengan @theme & custom animations
│   ├── js/app.js               # Minimal — Alpine.js loaded by Livewire
│   └── views/
│       ├── components/layouts/  # Layout templates (admin, public, app)
│       ├── livewire/           # 22 Blade views untuk Livewire components
│       ├── pdf/                # 3 PDF templates (finance, attendance, leaderboard)
│       └── welcome.blade.php   # Landing page
├── routes/
│   └── web.php                 # All routes (public, auth, admin)
├── Dockerfile                  # PHP 8.2-apache + Node 20 multi-stage
├── deploy.sh                   # Post-deploy script
└── docker-entrypoint.sh        # Container entrypoint
```

### Konvensi Penamaan

| Kategori                  | Konvensi                                  | Contoh                                    |
| ------------------------- | ----------------------------------------- | ----------------------------------------- |
| **Model**                 | Singular, PascalCase                      | `Santri`, `QuizQuestion`                  |
| **Migration**             | `create_{table}_table`                    | `create_santris_table`                    |
| **Livewire Component**    | PascalCase di `app/Livewire/`             | `SantriIndex`, `QuizEditor`               |
| **Blade View (Livewire)** | kebab-case di `resources/views/livewire/` | `santri-index.blade.php`                  |
| **Route Name**            | dot notation dengan prefix                | `admin.santri.index`, `admin.quiz.editor` |
| **URL Path**              | kebab-case, Bahasa Indonesia untuk public | `/keuangan`, `/galeri`, `/jadwal`         |
| **Service Class**         | PascalCase + `Service` suffix             | `FileUploadService`                       |
| **Controller**            | PascalCase + `Controller` suffix          | `ReportPdfController`                     |

---

## 4. Coding Standards & Patterns

### 4.1 Arsitektur Pattern

```
ATURAN UTAMA:
1. Livewire Full-Page Component untuk SEMUA halaman (bukan controller + view)
2. Traditional Controller HANYA untuk: file download, PDF export, backup import
3. Business logic di MODEL atau SERVICE, BUKAN di Livewire component
4. Gunakan Service class untuk logic yang shared antar component
```

#### ✅ Pattern yang Benar

```php
// Livewire component — handle UI state + delegate ke model/service
class Scanner extends Component
{
    public function processScan(string $token): void
    {
        $santri = Santri::where('qr_token', $token)->firstOrFail();
        // Delegate ke model
        $santri->checkWeeklyBonus();
        $santri->recalculateTotalPoints();
    }
}

// Model — business logic
class Santri extends Model
{
    public function recalculateTotalPoints(): void { ... }
    public function checkWeeklyBonus(): bool { ... }
}

// Service — reusable utility
class FileUploadService
{
    public static function upload(UploadedFile $file, string $folder): string { ... }
}
```

#### ❌ Anti-Pattern yang Harus Dihindari

```php
// JANGAN: Business logic di Livewire component
class Scanner extends Component
{
    public function processScan($token)
    {
        // SALAH — query + logic langsung di component
        $santri = DB::table('santris')->where('qr_token', $token)->first();
        DB::table('santris')->where('id', $santri->id)->update([
            'total_points' => $santri->total_points + 10
        ]);
    }
}

// JANGAN: Buat controller baru untuk CRUD biasa
// Gunakan Livewire component

// JANGAN: Raw SQL queries
// Gunakan Eloquent relationships dan scopes
```

### 4.2 General PHP Conventions

```php
// ✅ Selalu gunakan type hints
public function upload(UploadedFile $file, string $folder = 'uploads'): string

// ✅ Gunakan named parameters untuk readability (PHP 8.2+)
$santri->achievements()->create([
    'type' => 'hafalan',
    'description' => $description,
    'points' => $points,
    'created_by' => auth()->id(),
]);

// ✅ Gunakan match() daripada switch
return match ($placeholder) {
    'avatar' => 'https://ui-avatars.com/...',
    default => 'https://placehold.co/...',
};

// ✅ Null-safe operator
$user = auth()->user()?->name;

// ✅ Arrow functions untuk simple callbacks
$signatureString = collect($params)
    ->map(fn($v, $k) => "{$k}={$v}")
    ->implode('&');
```

### 4.3 Livewire Component Standards

```php
// WAJIB: Property ordering
class SantriIndex extends Component
{
    // 1. Public properties (bound ke UI)
    public string $search = '';
    public int $perPage = 10;

    // 2. Lifecycle hooks
    public function mount(): void { }

    // 3. Computed properties atau query methods
    public function getSantrisProperty() { }

    // 4. Action methods (user interactions)
    public function deleteSantri(int $id): void { }

    // 5. Render (selalu terakhir)
    public function render(): View { }
}
```

### 4.4 Blade View Standards

```blade
{{-- ✅ Gunakan layout component --}}
<x-layouts.admin>
    {{-- Content --}}
</x-layouts.admin>

{{-- ✅ Alpine.js HANYA untuk UI micro-interactions --}}
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open" x-transition>Content</div>
</div>

{{-- ✅ Gunakan helper function untuk image --}}
<img src="{{ santri_image($santri->avatar) }}" alt="{{ $santri->name }}">

{{-- ✅ Wire directives untuk Livewire interaction --}}
<input wire:model.live.debounce.300ms="search" placeholder="Cari santri...">
```

---

## 5. Database & Models

### 5.1 Schema Overview

```
users              → Admin authentication (role: admin/superadmin)
santris            → Core entity, soft-deletes, QR token, parent token
  ├── attendances  → Daily attendance records (hadir/izin/sakit/alpha)
  └── achievements → Point-based achievements (hafalan/adab/partisipasi/lainnya)
finances           → Income/expense ledger (donasi/takjil/hadiah/operasional)
materials          → Daily learning materials (text + YouTube embed)
galleries          → Photo gallery with categories
quizzes            → Quiz metadata
  └── quiz_questions → Quiz questions (JSON options + correct answer)
settings           → Key-value application settings
```

### 5.2 Model Rules

```
ATURAN DATABASE:
1. SELALU gunakan Eloquent relationships, JANGAN raw joins
2. SELALU gunakan $fillable, JANGAN $guarded = []
3. SELALU gunakan $casts untuk date, integer, boolean, array/json
4. Soft deletes HANYA untuk data penting (santri)
5. UUID tokens di-generate otomatis di boot() event
6. Recalculate total_points via model method, JANGAN manual increment
7. Gunakan eager loading (with()) untuk prevent N+1 queries
```

### 5.3 Migration Standards

```php
// ✅ Naming: YYYY_MM_DD_HHMMSS_verb_table_table.php
// contoh: 2026_02_06_000001_create_santris_table.php
//         2026_02_07_000001_add_category_to_galleries_table.php

// ✅ Selalu ada down() method
// ✅ Gunakan ->constrained()->cascadeOnDelete() untuk foreign keys
// ✅ Index pada kolom yang sering di-query (qr_token, parent_access_token, date)
```

### 5.4 Relationship Cheatsheet

```php
// Santri → Attendances (one-to-many)
$santri->attendances()->whereDate('date', today())->first();

// Santri → Achievements (one-to-many)
$santri->achievements()->where('type', 'hafalan')->sum('points');

// Quiz → QuizQuestions (one-to-many)
$quiz->questions()->orderBy('order')->get();

// Selalu eager load utk menghindari N+1
$santris = Santri::with(['attendances', 'achievements'])
    ->orderByDesc('total_points')
    ->get();
```

---

## 6. Frontend Architecture

### 6.1 Stack Detail

| Layer              | Tech                | Version | Peran                                               |
| ------------------ | ------------------- | ------- | --------------------------------------------------- |
| CSS Framework      | TailwindCSS         | 4.x     | Utility-first styling, `@theme` untuk design tokens |
| Build Tool         | Vite                | 7.x     | HMR, asset bundling, manifest.json                  |
| Vite Plugin        | laravel-vite-plugin | 2.x     | Laravel integration                                 |
| Reactivity         | Livewire            | 4.x     | Server-side reactivity, full-page components        |
| Micro-interactions | Alpine.js           | 3.x     | Client-side UI toggles, modals, timers              |
| Font               | Instrument Sans     | —       | Premium modern feel                                 |

### 6.2 TailwindCSS 4 Configuration

TailwindCSS 4 menggunakan CSS-native config (`@theme` di `app.css`), **bukan** `tailwind.config.js`:

```css
@import "tailwindcss";

@theme {
    --font-sans: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
    --animate-blob: blob 7s infinite;

    @keyframes blob { ... }
}
```

> **⚠️ PENTING:** Jangan buat `tailwind.config.js`. Semua konfigurasi via `@theme` di `app.css`.

### 6.3 Layout System

```
resources/views/components/layouts/
├── admin.blade.php      → Layout admin panel (sidebar + topbar)
├── app.blade.php        → Layout umum aplikasi
├── guest.blade.php      → Layout halaman login/guest
├── public.blade.php     → Layout halaman publik (leaderboard, keuangan)
└── (lainnya)
```

Semua Livewire component **WAJIB** menggunakan layout via attribute:

```php
#[Layout('components.layouts.admin')]
class Dashboard extends Component { ... }

#[Layout('components.layouts.public')]
class Leaderboard extends Component { ... }
```

### 6.4 Asset Management

```
Entry points (Vite):
  resources/css/app.css  → TailwindCSS + custom styles
  resources/js/app.js    → Bootstrap (axios) — Alpine.js loaded by Livewire

Penggunaan di Blade:
  @vite(['resources/css/app.css', 'resources/js/app.js'])

Build output:
  public/build/manifest.json
  public/build/assets/*.css
  public/build/assets/*.js
```

---

## 7. Performance Optimization

### 7.1 Current Optimizations

| Area              | Implementasi                                    | Status |
| ----------------- | ----------------------------------------------- | ------ |
| Autoloader        | `optimize-autoloader: true` di composer.json    | ✅     |
| Vite Build        | Production bundle dengan minification           | ✅     |
| Livewire Debounce | `wire:model.live.debounce.300ms`                | ✅     |
| File Watcher      | Ignore `storage/framework/views` di Vite config | ✅     |
| PHP Memory        | 256MB limit di Dockerfile                       | ✅     |

### 7.2 Yang Harus Diterapkan

#### A. Laravel Caching (CRITICAL untuk Production)

```php
// Di deploy.sh atau docker-entrypoint.sh — SELALU jalankan:
php artisan config:cache    // Cache konfigurasi
php artisan route:cache     // Cache routes
php artisan view:cache      // Cache compiled Blade views
php artisan event:cache     // Cache event/listener mappings
```

#### B. Eager Loading (Mencegah N+1 Query Problem)

```php
// ❌ N+1 — DILARANG
$santris = Santri::all();
foreach ($santris as $santri) {
    echo $santri->attendances->count();  // Query per santri!
}

// ✅ Eager loaded — WAJIB
$santris = Santri::with('attendances')->get();
foreach ($santris as $santri) {
    echo $santri->attendances->count();  // Sudah loaded!
}

// ✅ Gunakan withCount() untuk aggregate
$santris = Santri::withCount('attendances')
    ->withSum('achievements', 'points')
    ->get();
```

#### C. Database Query Optimization

```php
// ✅ Gunakan chunking untuk data besar
Santri::chunk(100, function ($santris) {
    foreach ($santris as $santri) {
        $santri->recalculateTotalPoints();
    }
});

// ✅ Gunakan database index
Schema::table('attendances', function (Blueprint $table) {
    $table->index(['santri_id', 'date']);
});

Schema::table('santris', function (Blueprint $table) {
    $table->index('total_points');  // Untuk leaderboard sorting
});
```

#### D. Leaderboard Caching

```php
// ✅ Cache leaderboard 5 menit (sesuai PRD requirement)
use Illuminate\Support\Facades\Cache;

public function getLeaderboard()
{
    return Cache::remember('leaderboard', 300, function () {
        return Santri::orderByDesc('total_points')
            ->limit(50)
            ->get(['id', 'name', 'total_points', 'avatar']);
    });
}

// ✅ Invalidate cache saat poin berubah
public function recalculateTotalPoints(): void
{
    $this->update([
        'total_points' => $this->attendances()->sum('points_gained')
                        + $this->achievements()->sum('points')
    ]);
    Cache::forget('leaderboard');
}
```

#### E. Livewire Performance

```php
// ✅ Lazy loading untuk komponen berat
<livewire:admin.report-index lazy />

// ✅ Pagination daripada load all
public function render()
{
    return view('livewire.admin.santri-index', [
        'santris' => Santri::search($this->search)
            ->paginate($this->perPage),
    ]);
}

// ✅ Wire:key untuk list rendering
@foreach($santris as $santri)
    <div wire:key="santri-{{ $santri->id }}">
@endforeach
```

### 7.3 Image Optimization Pipeline

```
Upload Flow:
1. User upload via Livewire (max 10MB — lihat Dockerfile php.ini)
2. FileUploadService.upload() dipanggil
3. Jika Cloudinary configured → upload ke Cloudinary (auto-optimize)
4. Jika tidak → simpan ke local disk (storage/app/public/)
5. Display via santri_image() helper (handles both URL types)

⚠️ TODO: Tambahkan server-side image compression sebelum upload
   sebelum upload lokal (Intervention Image atau GD)
```

---

## 8. Security Guidelines

### 8.1 Current Security Measures

| Measure           | Implementation                                | Status |
| ----------------- | --------------------------------------------- | ------ |
| CSRF Protection   | Laravel default `@csrf`                       | ✅     |
| Auth Guard        | Session-based + `AdminMiddleware`             | ✅     |
| Role Check        | `in_array(role, ['admin', 'superadmin'])`     | ✅     |
| HTTPS Enforcement | `URL::forceScheme('https')` di production     | ✅     |
| UUID Tokens       | QR token + parent access token auto-generated | ✅     |
| Soft Deletes      | Data santri tidak dihapus permanen            | ✅     |
| Bcrypt Rounds     | 12 rounds (`.env`)                            | ✅     |

### 8.2 Security Rules untuk Development

```
ATURAN SECURITY:
1. JANGAN pernah expose .env file — sudah ada di .gitignore
2. JANGAN hardcode credentials di source code
3. SELALU gunakan $fillable di model, JANGAN $guarded = []
4. SELALU validasi input di Livewire component (rules property atau validate())
5. SELALU gunakan parameterized queries (Eloquent handles ini otomatis)
6. Rate limit di scanner: max 30 scan/menit per admin
7. Parent token HARUS UUID v4 — tidak bisa di-bruteforce
8. Upload file: validasi MIME type + max size di Livewire rules
9. JANGAN expose internal error di production (APP_DEBUG=false)
10. Session lifetime: 120 menit (sesuai .env)
```

### 8.3 Input Validation Pattern

```php
// ✅ Validasi di Livewire component
class SantriCreate extends Component
{
    #[Validate('required|string|max:100')]
    public string $name = '';

    #[Validate('required|string|max:100')]
    public string $parent_name = '';

    #[Validate('required|regex:/^08[0-9]{8,13}$/')]
    public string $parent_phone = '';

    #[Validate('nullable|image|max:2048')]
    public $avatar;

    public function save(): void
    {
        $this->validate();
        // ... create santri
    }
}
```

---

## 9. Deployment & DevOps

### 9.1 Arsitektur Deployment

```
Local Development:
  composer dev → concurrently runs:
    1. php artisan serve (Laravel dev server)
    2. php artisan queue:listen (queue worker)
    3. php artisan pail (log tailing)
    4. npm run dev (Vite HMR)

Production (Railway):
  Dockerfile → PHP 8.2-apache + Node 20
  docker-entrypoint.sh → migrate + cache + serve
  deploy.sh → post-deploy tasks
```

### 9.2 Docker Build Pipeline

```dockerfile
# Multi-step (single-stage, bukan multi-stage):
1. Install system deps (gd, zip, mbstring, pdo_mysql, bcmath)
2. Install Node.js 20
3. Install Composer
4. Copy source code
5. composer install --no-dev --optimize-autoloader
6. npm ci && npm run build
7. Configure permissions (storage, bootstrap/cache)
8. Configure PHP limits (upload 10MB, memory 256MB)
9. Run docker-entrypoint.sh (migrate + artisan optimizations)
```

### 9.3 Environment Variables

```env
# REQUIRED untuk production
APP_KEY=                    # Generate: php artisan key:generate
APP_ENV=production
APP_DEBUG=false
APP_URL=https://xxx.up.railway.app

# Database (Railway MySQL)
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

# Optional (Cloudinary)
CLOUDINARY_CLOUD_NAME=
CLOUDINARY_API_KEY=
CLOUDINARY_API_SECRET=
```

### 9.4 Deployment Checklist

```
Pre-Deploy:
  [ ] APP_DEBUG=false
  [ ] APP_ENV=production
  [ ] All .env variables set di Railway dashboard
  [ ] npm run build berhasil (no errors)
  [ ] Migrations up-to-date

Post-Deploy (auto via docker-entrypoint.sh):
  [ ] php artisan migrate --force
  [ ] php artisan config:cache
  [ ] php artisan route:cache
  [ ] php artisan view:cache
  [ ] php artisan storage:link
```

---

## 10. Scalability Roadmap

### 10.1 Short-term Improvements (Quick Wins)

| #   | Improvement                                                                       | Impact    | Effort    |
| --- | --------------------------------------------------------------------------------- | --------- | --------- |
| 1   | Add database indexes (`santri_id+date` on attendances, `total_points` on santris) | 🔴 High   | 🟢 Low    |
| 2   | Implement leaderboard caching (5 min TTL)                                         | 🔴 High   | 🟢 Low    |
| 3   | Add Livewire `lazy` loading untuk dashboard widgets                               | 🟡 Medium | 🟢 Low    |
| 4   | Laravel cache commands di production deploy script                                | 🔴 High   | 🟢 Low    |
| 5   | Add server-side image compression before upload (max 500KB)                       | 🟡 Medium | 🟡 Medium |

### 10.2 Medium-term Architecture (Jika User Base Tumbuh)

```
JIKA santri > 500 atau TPA > 1:
1. Pindah dari SQLite ke MySQL/PostgreSQL (production sudah MySQL)
2. Implementasi Redis untuk caching (leaderboard, sessions)
3. Queue jobs untuk: PDF generation, image processing, email notifications
4. Database: Model Settings → gunakan cache, bukan query setiap request
5. API endpoints (RESTful) untuk integrasi mobile app di masa depan

JIKA concurrent users > 100:
1. Horizontal scaling via multiple containers (Railway memiliki fitur ini)
2. Session storage pindah dari file ke Redis/database
3. Cloudinary CDN untuk semua static assets
4. Database connection pooling
```

### 10.3 Long-term Feature Roadmap

```
Phase 2 (Post-Ramadan):
  - Multi-TPA support (multi-tenant architecture)
  - REST API + API authentication (Sanctum)
  - WhatsApp notification integration
  - PWA support (offline QR scanner)
  - Advanced analytics dashboard

Phase 3 (Year 2):
  - Mobile app (React Native / Flutter)
  - Payment gateway integration (untuk donasi online)
  - AI-powered progress tracking
  - Multi-language support
```

### 10.4 Multi-tenant PrepWork (Untuk Multi-TPA)

```php
// Persiapan jika nanti support multi-TPA:
// 1. Tambahkan tpa_id di semua tabel
// 2. Gunakan global scope untuk auto-filter
// 3. Middleware untuk set tenant context

// Contoh future implementation:
class Santri extends Model
{
    protected static function booted()
    {
        static::addGlobalScope('tpa', function ($query) {
            $query->where('tpa_id', session('current_tpa_id'));
        });
    }
}
```

---

## 11. Common Pitfalls & Troubleshooting

### 11.1 Issue yang Sering Muncul

| Problem                     | Root Cause                                          | Solution                                                              |
| --------------------------- | --------------------------------------------------- | --------------------------------------------------------------------- |
| `Multiple Alpine instances` | Alpine.js di-import manual + Livewire auto-load     | **JANGAN** import Alpine di `app.js` — Livewire 4 sudah include       |
| `500 Error di Railway`      | `.env` tidak ada atau `APP_KEY` belum set           | Set semua env vars di Railway dashboard                               |
| `Foto tidak muncul`         | `storage:link` belum dijalankan, atau path salah    | Jalankan `php artisan storage:link` + gunakan `santri_image()` helper |
| `Livewire upload gagal`     | PHP `upload_max_filesize` terlalu kecil             | Sudah diset di Dockerfile (10MB), pastikan juga di php.ini            |
| `Vite manifest not found`   | `npm run build` belum dijalankan di production      | Sudah handled di Dockerfile (`npm ci && npm run build`)               |
| `More than one MPM loaded`  | Apache config conflict di Docker                    | Disable `mpm_event`, enable `mpm_prefork`                             |
| `Session lost after deploy` | Session di file storage, container restart = hilang | Switch ke database session driver di production                       |
| `Leaderboard lambat`        | No index + no caching + N+1 queries                 | Add index + cache + eager loading                                     |

### 11.2 Debugging Workflow

```bash
# 1. Cek logs
php artisan pail                          # Real-time log tailing
tail -f storage/logs/laravel.log          # Log file langsung

# 2. Cek database state
php artisan tinker
> Santri::count()
> Attendance::whereDate('date', today())->count()

# 3. Reset state
php artisan migrate:fresh --seed          # ⚠️ DEV ONLY — hapus semua data
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# 4. Cek Livewire
php artisan livewire:discover             # Re-discover components

# 5. Cek Vite build
npm run build                             # Rebuild frontend assets
```

---

## 12. Development Workflow

### 12.1 Local Setup

```bash
# 1. Clone & install
git clone [repo-url] && cd sitara
composer install
cp .env.example .env
php artisan key:generate

# 2. Database (SQLite untuk local)
touch database/database.sqlite
# Set di .env: DB_CONNECTION=sqlite
php artisan migrate --seed

# 3. Frontend
npm install

# 4. Run everything
composer dev
# → Opens: http://localhost:8000
```

### 12.2 Feature Development Flow

```
1. Buat branch: git checkout -b feature/nama-fitur
2. Jika perlu model baru:
   → php artisan make:model NamaModel -m (model + migration)
   → Definisikan $fillable, $casts, relationships
3. Jika perlu halaman baru:
   → php artisan make:livewire NamaComponent
   → Buat Blade view di resources/views/livewire/
   → Tambahkan route di web.php
4. Test locally:  composer dev
5. Commit + push
6. Merge ke main → auto-deploy ke Railway (jika CI/CD aktif)
```

### 12.3 Adding New Features Checklist

```
Untuk setiap fitur baru, pastikan:
  [ ] Model + Migration sudah benar (fillable, casts, relationships)
  [ ] Livewire component + Blade view sudah dibuat
  [ ] Route sudah ditambahkan di web.php (dengan middleware yang tepat)
  [ ] Validasi input sudah diterapkan
  [ ] Eager loading digunakan (no N+1)
  [ ] Mobile responsive (TailwindCSS responsive classes)
  [ ] Error handling + user feedback (flash messages/toasts)
  [ ] Kompatibel dengan layout yang ada (admin/public)
```

### 12.4 Testing Strategy

```
CURRENT STATE: Testing masih minimal (default Laravel PHPUnit scaffold).

TARGET:
  - Feature tests untuk setiap Livewire component (Livewire::test())
  - Unit tests untuk model methods (checkWeeklyBonus, recalculateTotalPoints)
  - Unit tests untuk services (FileUploadService)
  - Browser tests untuk critical flows (QR scan, login)

PRIORITAS TESTING:
  1. Scanner flow (QR scan → attendance → points)
  2. Leaderboard calculation
  3. Finance CRUD + summary
  4. Authentication + authorization
```

---

## Quick Reference Card

```
┌─────────────────── SITARA CHEATSHEET ───────────────────┐
│                                                          │
│  🚀 Run:          composer dev                           │
│  🔨 Build:        npm run build                          │
│  🧪 Test:         php artisan test                       │
│  📦 Deploy:       git push (auto via Railway/Docker)     │
│                                                          │
│  📄 New Page:     php artisan make:livewire Feature/Name │
│  📊 New Model:    php artisan make:model Name -m         │
│  🔍 Debug:        php artisan pail                       │
│  💾 DB Reset:     php artisan migrate:fresh --seed       │
│                                                          │
│  📁 Views:        resources/views/livewire/              │
│  📁 Components:   app/Livewire/                          │
│  📁 Models:       app/Models/                            │
│  📁 Routes:       routes/web.php                         │
│  📁 Styles:       resources/css/app.css                  │
│                                                          │
│  ⚡ Motto: "Livewire-first, model-heavy, controller-    │
│            light, cache-smart"                           │
└──────────────────────────────────────────────────────────┘
```

---

> **Terakhir diperbarui:** 9 Maret 2026
> **Maintainer:** REIMAKE Engineering Team
