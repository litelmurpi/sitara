# Deployment Guide untuk Railway

## 🚀 Quick Start

### 1. Set Environment Variables di Railway

Buka Railway dashboard → Project → Variables, lalu tambahkan:

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app  # Ganti dengan domain Railway Anda
LOG_CHANNEL=stderr
```

### 2. Database Configuration

Railway akan otomatis inject PostgreSQL variables. Pastikan di `.env` atau Railway variables:

```bash
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}
```

### 3. Deploy

Push ke repository yang terhubung dengan Railway:

```bash
git add .
git commit -m "Fix CSS loading in production"
git push origin main
```

Railway akan otomatis:

1. Build Docker image
2. Run `npm run build` untuk compile assets
3. Execute `deploy.sh` untuk setup Laravel
4. Start Apache server

## ✅ Verification Checklist

Setelah deployment selesai:

1. **Buka aplikasi** di browser
2. **Check CSS ter-load** - halaman harus tampil dengan styling yang benar
3. **Open DevTools** (F12) → Network tab
4. **Verify assets** - pastikan file CSS/JS load dengan status 200
5. **Check Console** - tidak ada error 404

## 🔍 Troubleshooting

### CSS Masih Tidak Ter-load

**Solusi 1: Clear Laravel Cache**

Jalankan di Railway console atau tambahkan ke `deploy.sh`:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Solusi 2: Verify APP_URL**

Pastikan `APP_URL` di Railway variables match dengan domain Railway Anda:

```bash
# BENAR
APP_URL=https://sitara-production.up.railway.app

# SALAH
APP_URL=http://localhost
```

**Solusi 3: Check Build Logs**

Di Railway dashboard → Deployments → View Logs, pastikan:

```
✓ 53 modules transformed.
public/build/.vite/manifest.json
public/build/assets/app-D49zB3mz.css
public/build/assets/app-DIuewKhF.js
✓ built in 398ms
```

### Error 404 pada Assets

Jika mendapat 404 pada `/build/assets/app-xxx.css`:

1. **Verify manifest exists**:

    ```bash
    ls -la public/build/.vite/manifest.json
    ```

2. **Check Apache config** - pastikan DocumentRoot mengarah ke `/var/www/html/public`

3. **Verify permissions**:
    ```bash
    chmod -R 755 public/build
    ```

### Build Failed

Jika `npm run build` gagal:

1. **Check Node version** - pastikan menggunakan Node 20 (sudah di-set di Dockerfile)
2. **Verify package.json** - pastikan semua dependencies terinstall
3. **Check build logs** untuk error spesifik

## 📝 File Changes Summary

Berikut file yang telah diubah untuk fix CSS loading:

1. **`vite.config.js`** - Added build configuration
2. **`public/.htaccess`** - Added MIME types & caching headers
3. **`deploy.sh`** - Added Vite manifest verification
4. **`RAILWAY_ENV_GUIDE.md`** - Environment variables documentation

## 🎯 Next Steps

Setelah deployment sukses:

1. Monitor aplikasi untuk memastikan tidak ada error
2. Test semua fitur untuk memastikan berfungsi dengan baik
3. Setup monitoring/logging jika diperlukan
4. Configure custom domain jika ada

## 💡 Tips

- **Always check Railway logs** saat troubleshooting
- **Use `APP_DEBUG=false`** di production untuk security
- **Enable caching** untuk performance (sudah di-set di `.htaccess`)
- **Monitor resource usage** di Railway dashboard
