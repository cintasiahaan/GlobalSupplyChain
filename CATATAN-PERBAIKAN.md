# Catatan Perbaikan — Global Supply Chain Risk Monitoring

Project ini di-audit dan diperbaiki dari kondisi sebelumnya yang punya beberapa
bug fatal (aplikasi tidak akan bisa jalan tanpa perbaikan ini).

## Bug yang diperbaiki

1. **`app/Models/Country.php`** — relasi `riskAssessment()` ditambahkan.
   Dipakai di banyak controller & seeder tapi sebelumnya tidak ada sama sekali.
2. **`app/Http/Controllers/RiskAssessmentController.php`** — method `index()`
   ditambahkan (route admin mengarah ke method yang sebelumnya tidak ada).
3. **`app/Http/Controllers/DashboardController.php`** — menambahkan variabel
   `$globalRiskLevel` dan `$allCountries` yang dibutuhkan view dashboard
   (sebelumnya undefined variable).
4. **`routes/web.php`**
   - Halaman utama (`/`) sekarang memakai `DashboardController` (sebelumnya
     query-nya mengacu ke kolom `countries.risk_score` yang tidak pernah ada
     di database → akan SQL error).
   - `/countries` dan `/countries/{country}` sekarang memakai `CountryController`
     yang sudah punya fitur search, filter region/risk, dan pagination
     (sebelumnya controller ini dibuat tapi tidak pernah dipasang ke route).
   - Route `/countries/{country}/risk-assessment` (GET & POST) dihapus karena
     mengarah ke view yang tidak pernah ada dan field yang tidak cocok dengan
     model `RiskAssessment`. Fitur ini sudah digantikan oleh menu Admin →
     Risk Assessment Management yang lengkap (5 faktor risiko).
   - Route `/admin/settings` ditambahkan (view-nya sudah ada tapi belum
     pernah dirutekan).
5. **`resources/views/Dashboard.blade.php` → `dashboard.blade.php`** — nama
   file di-rename ke huruf kecil semua. Sebelumnya `view('dashboard')`
   memanggil file `Dashboard.blade.php`; ini kebetulan jalan di Windows
   (case-insensitive) tapi akan **500 error di server Linux** (case-sensitive).
   - Sekaligus diperbaiki bug tampilan: baris "Belum ada data" yang
     sebelumnya muncul berulang di setiap baris tabel (bug `@foreach` →
     diganti `@forelse`).
6. **`resources/views/countries/show.blade.php`** — tombol
   "Update/Add Risk Assessment" memakai nama route yang salah
   (`risk-assessments.create` → seharusnya `admin.risk-assessments.create`),
   sekarang diperbaiki dan dibatasi hanya tampil untuk admin.
7. **`database/seeders/DatabaseSeeder.php`** — ada 5 pemanggilan
   `Weather::create()` yang tertulis **di luar class** (bug fatal, akan
   tereksekusi setiap kali class di-autoload). Sudah dipindah ke dalam
   `run()` dengan pengecekan agar tidak duplikat. Seeder juga sekarang
   memanggil `CountrySeeder`, `RiskLevelSeeder`, `RiskAssessmentSeeder`
   otomatis lewat `$this->call([...])` — sebelumnya harus dijalankan manual
   satu per satu.
8. **`resources/views/layouts/app.blade.php`** — menu sidebar admin
   ditambahkan link ke "Admin Dashboard", "Risk Assessment Management", dan
   "Settings" (sebelumnya `href="#"`, dead link).

Semua pemanggilan `route(...)` dan `view(...)` di seluruh project sudah
diverifikasi ulang secara otomatis agar tidak ada lagi referensi yang rusak.

## Cara menjalankan

```bash
composer install
cp .env.example .env      # jika belum ada .env
php artisan key:generate
```

Atur `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` di `.env` sesuai database
MySQL lokal kamu (default nama DB: `global_supply_chain`), lalu:

```bash
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

## Akun default (dari seeder)

| Role  | Email             | Password  | Redirect setelah login |
|-------|-------------------|-----------|-------------------------|
| Admin | admin@gmail.com   | admin123  | `/admin/dashboard`      |
| User  | user@gmail.com    | user123   | `/user/dashboard`       |

## Catatan

- `vendor/`, `node_modules/`, dan `.git/` **tidak disertakan** di zip ini agar
  ukurannya kecil — jalankan `composer install` dan `npm install` setelah
  ekstrak.
- Perbaikan ini murni hasil audit kode statis (membaca & menelusuri seluruh
  route, controller, model, dan view). Saya tidak punya akses PHP/Composer/
  internet di lingkungan kerja saya untuk benar-benar menjalankan
  `php artisan serve`, jadi setelah `composer install` + `migrate --seed`,
  tolong coba jalankan dan kabari kalau masih ada error yang tersisa.
