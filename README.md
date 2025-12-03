# Hướng Dẫn Khôi Phục Dự Án (Restore Guide)

Tài liệu này hướng dẫn cách khôi phục dự án từ các bản backup được tạo ra bởi script `backup-project.ps1` hoặc từ Git.

## 1. Khôi Phục Từ File Backup (Local Backup)

Các bản backup được lưu trữ tại:
`D:\OneDrive - THPT Bui Thi Xuan\C3DRIVE\IgiveTest\Backup`

### Các bước thực hiện:

1.  **Xác định file backup cần khôi phục**:
    *   Tìm file `.zip` có thời gian gần nhất hoặc mong muốn trong thư mục backup.
    *   Ví dụ: `full_2025-12-04_060451.zip`

2.  **Giải nén file backup**:
    *   Click chuột phải vào file zip -> chọn **Extract All...** (hoặc dùng phần mềm giải nén như 7-Zip/WinRAR).
    *   Giải nén ra một thư mục tạm thời.

3.  **Copy dữ liệu vào thư mục dự án**:
    *   Truy cập vào thư mục vừa giải nén.
    *   Copy toàn bộ nội dung bên trong.
    *   Paste (Dán) đè vào thư mục gốc của dự án: `C:\laragon\www`.
    *   Chọn **Replace the files in the destination** nếu được hỏi.

4.  **Khôi phục các thư mục bị loại trừ (nếu cần)**:
    *   Lưu ý rằng bản backup **không bao gồm** các thư mục như `node_modules`, `.next`, `.git`, `vendor`.
    *   Nếu bạn khôi phục trên một máy mới hoàn toàn, bạn cần chạy lại lệnh cài đặt:
        *   Với PHP (nếu có Composer): `composer install`
        *   Với Next.js: `cd next-app` sau đó chạy `npm install`

---

## 2. Khôi Phục Từ Git (GitHub)

Nếu bạn muốn khôi phục về trạng thái code mới nhất trên GitHub.

### Các bước thực hiện:

1.  **Mở Terminal** tại thư mục dự án (`C:\laragon\www`).

2.  **Reset code về trạng thái của remote**:
    *   Lệnh này sẽ xóa các thay đổi chưa commit ở local và đồng bộ hoàn toàn với remote.
    ```bash
    git fetch origin
    git reset --hard origin/main
    ```

3.  **Lưu ý**:
    *   Cách này sẽ làm mất các file chưa được track hoặc chưa commit.
    *   Git không lưu trữ các file cấu hình nhạy cảm (như `.env`) nếu chúng nằm trong `.gitignore`. Bạn có thể cần copy lại chúng từ bản backup local nếu bị mất.

---

## 3. Khôi Phục Database (Nếu cần)

Nếu dự án có đi kèm Database, bạn cần khôi phục Database riêng biệt.

*   Kiểm tra thư mục backup xem có file `.sql` dump không (nếu script backup có hỗ trợ dump DB).
*   Nếu không, hãy đảm bảo bạn có backup Database định kỳ bằng phpMyAdmin hoặc công cụ quản lý Database khác.
