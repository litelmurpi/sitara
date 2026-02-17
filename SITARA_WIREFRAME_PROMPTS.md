# SITARA Wireframe Prompts untuk Stitch

Gunakan prompt di bawah ini untuk generate wireframe di Stitch. Sesuaikan style dengan preferensi (modern, minimal, Islamic-themed, dll).

---

## 🎨 Design Guidelines

- **Style:** Modern, clean, mobile-first
- **Colors:** Hijau/teal (Islamic nuance) + putih + aksen emas
- **Font:** Sans-serif (Inter, Poppins)
- **Mood:** Ramadan, anak-anak, semangat

---

## 📱 Halaman Publik

### 1. Homepage / Landing Page

```
Mobile landing page for TPA Ramadan management app called "SITARA".

Include:
- Hero section with Ramadan-themed illustration (mosque, crescent moon)
- App name "SITARA" with tagline "Sistem Informasi TPA Ramadan"
- Quick stats widget: "Total Santri: 45 | Hari ke: 12 | Saldo Kas: Rp 2.500.000"
- Top 5 Leaderboard preview with avatar, name, and points
- "Lihat Semua" button
- Navigation: Home, Leaderboard, Galeri, Login
```

### 2. Leaderboard Page

```
Mobile leaderboard page for kids TPA competition.

Include:
- Top 3 podium with avatar, name, and total points (gold/silver/bronze styling)
- Full ranking list below (position, avatar, name, points)
- Search/filter by name
- Current user highlight (jika ada)
- Gamification badges next to names
- Refresh indicator
```

### 3. Financial Transparency Page

```
Mobile page showing financial report for donors.

Include:
- Current balance card: "Saldo Kas: Rp 2.500.000"
- Income/Expense summary (pie chart or bar)
- Transaction list: date, description, amount (green for income, red for expense)
- Filter by: All, Income, Expense
- Category tags: Donasi, Takjil, Hadiah
```

### 4. Gallery Page

```
Mobile photo gallery page for TPA activities.

Include:
- Grid layout (2 columns)
- Photo thumbnails with date overlay
- Lightbox preview on tap
- Filter by date
- Lazy loading indicator
```

---

## 🔐 Halaman Admin

### 5. Admin Login

```
Mobile login page for admin dashboard.

Include:
- SITARA logo
- Email/username input
- Password input with show/hide toggle
- "Masuk" button (primary color)
- Forgot password link
- Clean, minimal design
```

### 6. Admin Dashboard

```
Mobile admin dashboard for TPA management.

Include:
- Welcome message: "Selamat datang, Admin"
- Today's date (Hijri + Masehi)
- Quick action cards:
  - "Scan Kehadiran" (camera icon)
  - "Input Poin" (star icon)
  - "Catat Keuangan" (wallet icon)
  - "Upload Materi" (book icon)
- Stats: Hadir hari ini, Total poin diberikan
- Bottom navigation: Dashboard, Santri, Keuangan, Settings
```

### 7. QR Scanner Page

```
Mobile QR scanner interface for attendance.

Include:
- Full-screen camera viewfinder
- QR frame overlay (corners highlighted)
- Flash toggle button
- "Arahkan kamera ke QR santri" instruction
- Success popup: "✓ Ahmad Faiz - Hadir (+10 poin)"
- Recent scans list below
```

### 8. Santri List Page (Admin)

```
Mobile list view of all students.

Include:
- Search bar
- Student cards: avatar, name, total points, last attendance
- FAB button: "Tambah Santri"
- Swipe actions: Edit, Delete
- Filter: Active, All
```

### 9. Santri Detail / Add Point

```
Mobile student detail page for admin.

Include:
- Student profile card: avatar, name, parent name, address
- QR code preview
- Point history list
- "Tambah Poin" button
- Modal: Select type (Hafalan, Adab, dll), input points, description
- Total points summary
```

### 10. Financial Input Page

```
Mobile form to record financial transaction.

Include:
- Toggle: Pemasukan / Pengeluaran
- Amount input (large, numeric keyboard)
- Category dropdown: Donasi, Takjil, Hadiah, Operasional
- Description text input
- Date picker (default: today)
- "Simpan" button
```

---

## 👨‍👩‍👧 Halaman Orang Tua (Parent Portal)

### 11. Parent View (via unique link)

```
Mobile page for parents to monitor their child.

Include:
- Child profile card: avatar, name, rank position
- Attendance calendar (green = hadir, yellow = izin, red = alpha)
- Point breakdown: Kehadiran, Hafalan, Adab
- Total points with progress bar
- Recent achievements list
- No login required (accessed via unique link)
```

---

## 📐 Component Library

### Common Components

```
Design system components for SITARA app:

1. Primary Button - Green/teal, rounded, full width
2. Secondary Button - Outlined, green border
3. Input Field - Rounded corners, floating label
4. Card - White, subtle shadow, rounded
5. Avatar - Circle, 40px, with fallback initials
6. Badge - Small pill for categories/status
7. Bottom Navigation - 4 items with icons
8. Modal/Popup - Centered, overlay background
9. Toast/Snackbar - Success (green), Error (red)
10. Loading Spinner - Circular, brand color
```

---

## 💡 Tips untuk Stitch

1. **Generate per halaman** - Jangan sekaligus, hasilnya lebih fokus
2. **Tambahkan "mobile UI"** di setiap prompt
3. **Sebutkan warna** jika ingin konsisten (green, teal, gold accent)
4. **Minta variasi** - "Give me 2 variations" untuk opsi
5. **Iterate** - Perbaiki hasil dengan follow-up prompt

---

**Total Halaman:** 11 screens + Component Library
