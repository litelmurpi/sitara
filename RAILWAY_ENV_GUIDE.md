# Railway Environment Variables Guide

## Required Environment Variables

Untuk memastikan aplikasi berjalan dengan baik di Railway, set environment variables berikut di Railway dashboard:

### Core Application Settings

```bash
# Application Environment
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-app-key-here

# Application URL (ganti dengan domain Railway Anda)
APP_URL=https://your-app.railway.app

# Database (Railway PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

# Logging
LOG_CHANNEL=stderr
LOG_LEVEL=error
```

### Optional Settings

```bash
# Asset URL (jika menggunakan CDN)
ASSET_URL=https://your-cdn.com

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

## Cara Set Environment Variables di Railway

1. Buka Railway dashboard
2. Pilih project Anda
3. Klik tab **"Variables"**
4. Tambahkan environment variables di atas
5. Deploy ulang aplikasi

## Troubleshooting

### CSS Tidak Ter-load

Jika CSS masih tidak ter-load setelah deployment:

1. **Pastikan `APP_URL` sudah di-set** dengan domain Railway yang benar
2. **Check browser console** untuk error 404 pada asset files
3. **Verify build folder** ada di `public/build/`
4. **Clear cache** dengan command:
    ```bash
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    ```

### Asset 404 Errors

Jika mendapat error 404 pada asset files:

1. Pastikan `npm run build` berjalan sukses di Dockerfile
2. Check bahwa `public/build/manifest.json` exists
3. Verify Apache serving static files dengan benar

## Verification Checklist

Setelah deployment, verify:

- [ ] Homepage ter-load dengan CSS yang benar
- [ ] Browser console tidak ada error 404
- [ ] Asset files ter-load dari `/build/assets/`
- [ ] Tailwind CSS classes berfungsi dengan baik
