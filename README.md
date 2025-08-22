# 📦 Laravel Livewire Project

Projek ini dibangunkan menggunakan **Laravel 10**, **Livewire 3**, **TailwindCSS**, dan **Spatie Permission**.

## 🚀 Teknologi Digunakan

-   **Laravel 10**
-   **Livewire 3**
-   **TailwindCSS**
-   **Spatie Laravel Permission**
-   **MySQL**

## 🛠 Keperluan Sistem

-   PHP >= 8.1
-   Composer
-   Node.js & NPM
-   MySQL >= 5.7

## ⚙️ Cara Pemasangan

### 1. Clone Repository

```bash
git clone project from github
cd nama-project
```

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install && npm run dev
```

### 4. Salin Fail `.env`

```bash
cp .env.example .env
```

### 5. Generate Key

```bash
php artisan key:generate
```

### 6. Setup Database

-   Buat database di MySQL
-   Update `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` dalam fail `.env`

### 7. Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

### 8. Jalankan Server

```bash
php artisan serve
```

### 9. Compile Asset (Production)

```bash
npm run build
```

---

## 👤 Login Default

| Role  | Email             | Password |
| ----- | ----------------- | -------- |
| Admin | admin@example.com | password |
| Staff | staff@example.com | password |

---

## 📂 Struktur Folder Penting

```
app/
    Http/
        Livewire/       # Komponen Livewire
    Models/             # Model Eloquent
resources/
    views/              # Fail Blade
    js/                 # JavaScript
    css/                # CSS/Tailwind
routes/
    web.php             # Route utama
database/
    migrations/         # Fail migrasi
    seeders/            # Data awal
```

---

## 🧪 Testing

```bash
php artisan test
```

---

## 📌 Nota Tambahan

-   Pastikan `storage` dan `bootstrap/cache` boleh ditulis (writable)
-   Jalankan `php artisan config:clear` jika berlaku isu cache

---

## 📜 Lesen

Projek ini dibangunkan untuk kegunaan dalaman. Hak cipta © 2025, **Nama Syarikat/Developer**.
