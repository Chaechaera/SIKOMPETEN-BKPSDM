# 🔄 Multi-User Testing Guide

## 📋 Overview

Aplikasi ini telah dikonfigurasi untuk mendukung testing dengan multiple users/roles sekaligus. Anda bisa:
1. **Login dengan multiple browser tabs** menggunakan credentials berbeda
2. **Switch users tanpa logout** menggunakan fitur Role Switcher (DEV MODE)

---

## 🚀 Quick Start

### 1. Setup Database & Seed Test Users
```bash
# Jalankan migrations (jika belum)
php artisan migrate

# Seed database dengan test users
php artisan db:seed
```

### 2. Test Users Tersedia
Semua test users menggunakan password: `password123`

| Role | Email | Dashboard |
|------|-------|-----------|
| 🔴 BKPSDM (Superadmin) | `superadmin@bkpsdm.local` | `/superadmin/dashboard` |
| 🟠 OPD - Pendidikan (Admin) | `admin.pendidikan@opd.local` | `/admin/dashboard` |
| 🟠 OPD - Kesehatan (Admin) | `admin.kesehatan@opd.local` | `/admin/dashboard` |
| 🟢 Peserta (User) | `peserta@example.local` | `/user/dashboard` |

---

## 💡 Cara Menggunakan

### Opsi 1: Dua Browser Tab Berbeda ✨ (Direkomendasikan)

**Paling mudah untuk testing multiple roles sekaligus**

```
1. Buka Tab 1: http://localhost/login
   - Login dengan: superadmin@bkpsdm.local / password123
   - Akan redirect ke: /superadmin/dashboard

2. Buka Tab 2: http://localhost/login (atau Incognito window)
   - Login dengan: admin.pendidikan@opd.local / password123
   - Akan redirect ke: /admin/dashboard

3. Sekarang Anda bisa test interaksi antara BKPSDM dan OPD sekaligus!
```

### Opsi 2: Gunakan Role Switcher (DEV MODE) 🔄

**Lebih cepat untuk switch berganti-ganti role tanpa membuka tab baru**

```
1. Login dengan salah satu test account
2. Kunjungi: http://localhost/dev/switch-user
3. Pilih user lain dari list
4. Klik "Switch to Selected User"
5. Otomatis akan login dan redirect ke dashboard sesuai role
```

---

## 🔧 Konfigurasi Tambahan

### Tambah Test User Baru
Edit file: `database/seeders/DatabaseSeeder.php`

```php
// Tambahkan user baru:
User::firstOrCreate(
    ['email' => 'admin.custom@opd.local'],
    [
        'nip' => '1985010120000005',
        'nama' => 'Admin Custom OPD',
        'password' => Hash::make('password123'),
        'role' => 'admin',
        'status' => 'aktif',
        'email_verified_at' => now(),
        'subunitkerja_id' => 3, // Sesuaikan ID
    ]
);
```

Lalu jalankan:
```bash
php artisan db:seed
```

### Ubah Password Test User
```bash
# Login ke Tinker
php artisan tinker

# Ubah password user
$user = User::find(1);
$user->password = Hash::make('newpassword');
$user->save();
```

---

## 🚫 Fitur DEV-ONLY

- **Role Switcher** (`/dev/switch-user`) hanya tersedia jika `APP_ENV=local`
- Otomatis tersembunyi saat deploy ke production
- Bersifat aman untuk development testing

---

## 📝 Notes
- Semua test data akan direset saat menjalankan `php artisan migrate:fresh --seed`
- Untuk development, gunakan credentials test ini, jangan gunakan di production
- Email tidak perlu diverifikasi karena sudah di-seed sebagai verified

---

## ❓ Troubleshooting

### "500 Error" saat seed
```bash
# Pastikan migrations sudah jalan
php artisan migrate

# Clear cache dan seed
php artisan cache:clear
php artisan db:seed
```

### Role Switcher tidak muncul
```bash
# Pastikan APP_ENV=local di .env
APP_ENV=local
```

### User tidak bisa login
```bash
# Pastikan password benar (case-sensitive)
# Default: password123
```
