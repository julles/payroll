# STMIK DHARMA NEGARA

## Payroll 

Aplikasi Payroll skripsi saya :D

### Fiture :

- Role Access Management
- Minimalis Crud Code
- Login
- Forgot Password
- Etc

yang mau liat liat bisa diinstall ya :v

### Cara install 

clone project atau download source mybackend

```sh
clone https://github.com/julles/payroll.git
```

copy file .env.example menjadi .env

lalu setting koneksi databasenya

contoh 

``` sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=payroll
DB_USERNAME=root
DB_PASSWORD=

```
install depedencies

``` sh
composer install
```

Jalan kan artisan command berikut : 

``` sh
php artisan admin:install
```

By default url admin : 

https://yoururl.dev/login

email : admin@admin.com

password : admin

## stable : dev (masih tahap development)