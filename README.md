### 📖 ระบบยืม-คืนหนังสือ ในห้องสมุด

###### ✍️แก้ไขเมื่อ : 26/10/2567

###### 👨‍💻ผู้จัดทำ : Adisak

---

จัดทำขึ้นเพื่อศึกษาการใช้ PHP(PDO) ร่วมกับ JQUERY และ AJAX สามารถดูตัวอย่างได้ [ที่นี่](https://github.com/Adisak-KS/jquery-ajax-book-borrowing-system/tree/main/previews)


---

### ⭐ ระบบภายในเว็บไซต์

        1. 👮ผู้ใช้ระดับผู้ดูแลระบบ (Admin)
            ✅ สามารถ login เข้าสู่ระบบได้
            ✅ สามารถแก้ไขข้อมูลส่วนตัวได้
            ✅ สามารถแก้ไข Password ตนเองได้
            ✅ สามารถเพิ่ม ลบ แก้ไข ข้อมูลผู้ดูแลระบบได้
            ✅ สามารถเพิ่ม ลบ แก้ไข ข้อมูลผู้ใช้งานได้
            ✅ สามารถเพิ่ม ลบ แก้ไข ข้อมูลประเภทหนังสือได้
            ✅ สามารถเพิ่ม ลบ แก้ไข ข้อมูลหนังสือได้
            ✅ สามารถยืนยันรายการคืนหนังสือได้
            ✅ สามารถตรวจสอบรายงานการยืมได้
            ✅ สามารถ Logout ได้

        2. 👮ผู้ใช้ระดับนักเรียนและครู (Student, Teacher)
            ✅ สามารถ login เข้าสู่ระบบได้
            ✅ สามารถแก้ไขข้อมูลส่วนตัวได้
            ✅ สามารถแก้ไข Password ตนเองได้
            ✅ สามารถยืมหนังสือได้
            ✅ สามารถตรวจสอบ ประวัติการยืมหนังสือ ของตนเองได้
            ✅ สามารถค้นหาหนังสือได้
            ✅ สามารถดูรายละเอียดหนังสือได้

        3. 👮ผู้ใช้ระดับทั่วไป
            ✅ สามารถค้นหาหนังสือได้
            ✅ สามารถดูรายละเอียดหนังสือได้

---

### ✍️ ภาษาที่ใช้ในการพัฒนาระบบ

        1. HTML
        2. BootStrap4.6
        3. Jquery
        4. AJAX
        5. PHP (PDO)
        6. DataTable
        7. SweetAlert2
        8. Jquery Validate
        9. Chart.js

---

### 🛠️ เครื่องมือที่ใช้

        1. Visual Studio Code
        2. XAMPP
        3. Microsoft Edge

---

### 📥วิธีติดตั้งเว็บไซต์

    1. นำ Database ในโฟลเดอร์ db/library.sql ไปติดตั้งใน XAMPP
    2. นำ โฟลเดอร์งาน ไปวางไว้ภายในเครื่องตนเอง
    3. หากมี Error เกี่ยวกับ Database ให้ตรวจสอบที่ connect.php ที่ username หรือ password

---

### 🕯️วิธีเข้าใช้งาน

1.  เข้าใช้งานได้ที่ : http:// localhost / ชื่อ folder งาน /

---

### 💻 ตัวอย่างเว็บไซต์

Admin

1. หน้าแรก
   ![index](https://github.com/Adisak-KS/jquery-ajax-book-borrowing-system/blob/main/previews/admin/02_index.png)

2. หน้าจัดการหนังสือ
   ![index](https://github.com/Adisak-KS/jquery-ajax-book-borrowing-system/blob/main/previews/admin/15_book_show.png)

3. หน้ารายงาน
   ![index](https://github.com/Adisak-KS/jquery-ajax-book-borrowing-system/blob/main/previews/admin/22_report.png)

๊User

1. หน้าแรก
    ![index](https://github.com/Adisak-KS/jquery-ajax-book-borrowing-system/blob/main/previews/user/01_index.png)

2. หนังสือทั้งหมด
    ![index](https://github.com/Adisak-KS/jquery-ajax-book-borrowing-system/blob/main/previews/user/02_books.png)

3. หน้าประวัติการยืม
    ![index](https://github.com/Adisak-KS/jquery-ajax-book-borrowing-system/blob/main/previews/user/04_history_borrow.png)

4. หน้ารายละเอียดหนังสือ
    ![index](https://github.com/Adisak-KS/jquery-ajax-book-borrowing-system/blob/main/previews/user/05_book_detail.png)
