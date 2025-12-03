# 📦 Hướng Dẫn Restore Dự Án IgiveTest

## 🎯 Mục đích
Hướng dẫn khôi phục dự án trên máy tính mới sau khi backup từ `backup-project.ps1`

---

## 📋 Điều kiện tiên quyết

### Phần mềm cần cài đặt:
- [ ] **Laragon** hoặc **XAMPP** (cho PHP + MySQL)
- [ ] **Node.js** (phiên bản 18+ cho Next.js)
- [ ] **Git** (tùy chọn, cho version control)

---

## 🚀 Các bước restore

### **Bước 1: Giải nén backup**
1. Tìm file backup mới nhất trong:
   ```
   D:\OneDrive - THPT Bui Thi Xuan\C3DRIVE\IgiveTest\Backup\
   ```
2. Giải nén file `full_YYYY-MM-DD_HHMMSS.zip` vào:
   ```
   C:\laragon\www\
   ```

---

### **Bước 2: Cài đặt dependencies**

#### **A. Dự án Next.js (next-app/)**
```powershell
# Mở PowerShell tại thư mục dự án
cd C:\laragon\www\next-app

# Cài đặt các package từ package.json
npm install

# Hoặc dùng pnpm (nhanh hơn)
pnpm install
```

#### **B. Dự án PHP - Nếu dùng Composer**
```powershell
cd C:\laragon\www\textbtx2025

# Cài đặt PHP dependencies (nếu có composer.json)
composer install
```

---

### **Bước 3: Restore Database**

#### **A. Export database từ máy cũ**
```sql
-- Chạy lệnh này trên máy cũ trong MySQL/phpMyAdmin
mysqldump -u root testbtx2025 > testbtx2025_backup.sql
```

#### **B. Import database vào máy mới**
1. Mở **phpMyAdmin** hoặc **MySQL Workbench**
2. Tạo database mới:
   ```sql
   CREATE DATABASE testbtx2025 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
3. Import file `.sql`:
   ```powershell
   mysql -u root testbtx2025 < testbtx2025_backup.sql
   ```

---

### **Bước 4: Cấu hình kết nối Database**

#### **A. Cấu hình cho dự án PHP**
Chỉnh sửa file `config.php`:
```php
$g_db_type = 'mysql';
$g_hostname = '127.0.0.1';  // hoặc 'localhost'
$g_db_username = 'root';
$g_db_password = '';        // Cập nhật mật khẩu MySQL mới (nếu có)
$g_database_name = 'testbtx2025';
$g_db_port = 3306;
```

#### **B. Cấu hình cho Next.js + Prisma**
Chỉnh sửa file `next-app/.env`:
```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/testbtx2025"
```

Sau đó chạy:
```powershell
cd next-app
npx prisma generate
npx prisma db pull  # Đồng bộ schema từ database
```

---

### **Bước 5: Kiểm tra và chạy ứng dụng**

#### **A. Chạy dự án PHP**
1. Start Laragon
2. Truy cập: `http://localhost/index.php`

#### **B. Chạy dự án Next.js**
```powershell
cd next-app
npm run dev
```
Truy cập: `http://localhost:3000`

---

## 🔧 Xử lý sự cố thường gặp

### ❌ Lỗi: "Module not found"
**Nguyên nhân:** Chưa cài đặt dependencies  
**Giải pháp:**
```powershell
cd next-app
rm -rf node_modules package-lock.json
npm install
```

### ❌ Lỗi: "Cannot connect to database"
**Nguyên nhân:** Thông tin kết nối database sai  
**Giải pháp:**
1. Kiểm tra MySQL đã chạy chưa
2. Xác nhận username/password trong `config.php` hoặc `.env`
3. Test kết nối:
   ```powershell
   mysql -u root -p
   SHOW DATABASES;
   ```

### ❌ Lỗi: "Port 3000 already in use"
**Nguyên nhân:** Port đã được sử dụng  
**Giải pháp:**
```powershell
# Chạy ở port khác
npm run dev -- -p 3001
```

---

## 📌 Checklist hoàn thành

- [ ] Giải nén backup vào `C:\laragon\www`
- [ ] Chạy `npm install` trong `next-app/`
- [ ] Import database `testbtx2025`
- [ ] Cập nhật `config.php` với thông tin database mới
- [ ] Cập nhật `next-app/.env` với DATABASE_URL
- [ ] Chạy `npx prisma generate` và `npx prisma db pull`
- [ ] Test dự án PHP: `http://localhost/index.php`
- [ ] Test dự án Next.js: `npm run dev`

---

## 💡 Tips

1. **Lưu file `.env` riêng**: File `.env` có thể khác giữa các máy, nên backup riêng
2. **Backup database định kỳ**: Nên export database ra file `.sql` thường xuyên
3. **Ghi chú phiên bản**: Ghi lại phiên bản Node.js, PHP đang dùng để tránh incompatibility
4. **Test ngay sau restore**: Luôn test ứng dụng ngay sau khi restore

---

## 📞 Thông tin bổ sung

- Script backup: `backup-project.ps1`
- Thư mục backup: `D:\OneDrive - THPT Bui Thi Xuan\C3DRIVE\IgiveTest\Backup\`
- Database name: `testbtx2025`
- PHP project: `textbtx2025/`
- Next.js project: `next-app/`
