# Hệ thống Quản lý Tài liệu ISO

Hệ thống quản lý tài liệu ISO được xây dựng bằng Laravel Framework, hỗ trợ quản lý các loại tài liệu ISO, văn bản nội bộ, thông báo và quy trình mới.

## Tính năng chính

- **Quản lý tài liệu ISO**: Tài liệu chỉ thị ISO, tài liệu hệ thống ISO
- **Quản lý văn bản nội bộ**: Văn bản cơ quan và phân xưởng
- **Quản lý tài liệu điều hành**: Tài liệu quản lý cấp cao
- **Hệ thống thông báo**: Thông báo nội bộ cho nhân viên
- **Quy trình mới**: Quản lý các quy trình mới trong tổ chức
- **Phân quyền người dùng**: Admin, Ban ISO, Cơ quan-Phân xưởng
- **Quản lý phòng ban**: Tổ chức cấu trúc phòng ban

## Yêu cầu hệ thống

- **PHP**: >= 8.2
- **Laravel**: 12.x
- **MySQL**: >= 8.0 hoặc MariaDB >= 10.4
- **Node.js**: >= 18.x (cho việc build frontend)
- **Composer**: Latest version
- **Web Server**: Nginx

## Cài đặt dự án

### 1. Tải và giải nén dự án

```bash
# Giải nén file zip vào thư mục dự án
unzip iso-system.zip
cd iso-system
```

### 2. Cấu hình môi trường

```bash
# Copy file cấu hình môi trường
cp .env.example .env
```

### 3. Cài đặt dependencies

```bash
# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies (cho frontend)
npm install
```

### 4. Tạo khóa ứng dụng

```bash
php artisan key:generate
```

### 5. Cấu hình database

Chỉnh sửa file `.env` với thông tin database của bạn:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iso_system
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Tạo database và chạy migrations

```bash
# Tạo database (nếu chưa có)
mysql -u root -p -e "CREATE DATABASE iso_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Chạy migrations để tạo bảng
php artisan migrate

# Chạy seeders để tạo dữ liệu mẫu
php artisan db:seed
```

### 7. Tạo symbolic link cho storage

```bash
php artisan storage:link
```

### 8. Build frontend assets

```bash
# Build cho development
npm run dev

# Hoặc build cho production
npm run build
```

### 9. Chạy ứng dụng

```bash
# Chạy development server
php artisan serve
```

Truy cập ứng dụng tại: `http://localhost:8000`

## Thông tin đăng nhập mặc định

Sau khi chạy seeders, hệ thống sẽ tạo các tài khoản mặc định:

```
Admin:
Username: admin
Password: admin123

Ban ISO:
Username: baniso
Password: baniso123

Cơ quan-Phân xưởng:
Username: vanphong
Password: coquan123

Người sử dụng:
Username: nvnam
Password: user123
```

## Production Deployment với Nginx + MySQL

### 1. Cấu hình Nginx

Tạo file cấu hình Nginx (`/etc/nginx/sites-available/iso-system`):

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/iso-system/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 2. Kích hoạt site

```bash
sudo ln -s /etc/nginx/sites-available/iso-system /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 3. Tối ưu hóa cho production

```bash
# Cấu hình môi trường production
cp .env.example .env
# Chỉnh sửa .env với APP_ENV=production, APP_DEBUG=false

# Tối ưu hóa Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Build assets cho production
npm run build
```

### 4. Cấu hình quyền thư mục

```bash
sudo chown -R www-data:www-data /var/www/iso-system
sudo chmod -R 755 /var/www/iso-system
sudo chmod -R 775 /var/www/iso-system/storage
sudo chmod -R 775 /var/www/iso-system/bootstrap/cache
```

## Các lệnh hữu ích

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rollback migrations
php artisan migrate:rollback

# Refresh database với seeders
php artisan migrate:refresh --seed

# Tạo symbolic link
php artisan storage:link
```

## Hỗ trợ

Nếu gặp vấn đề trong quá trình cài đặt hoặc sử dụng, vui lòng kiểm tra:

1. **Log files**: `storage/logs/laravel.log`
2. **Web server logs**: Nginx error logs
3. **PHP configuration**: `php -m` để kiểm tra extensions
4. **File permissions**: Đảm bảo `storage/` và `bootstrap/cache/` có quyền ghi
