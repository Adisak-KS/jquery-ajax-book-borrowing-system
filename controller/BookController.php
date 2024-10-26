<?php

class BookController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        // echo "<p>เรียกใช้ Book Controller สำเร็จ</p>";
    }

    function getBookList($start, $length, $search, $orderColumn, $orderDir)
    {
        try {
            // เริ่มสร้าง SQL Query
            $sql = "SELECT  lib_books.bk_id, 
                        lib_books.bk_img,
                        lib_books.bk_name, 
                        lib_books.bk_quantity,
                        lib_books.bk_student_loan_period,
                        lib_books.bk_teacher_loan_period,
                        lib_books.bk_detail, 
                        lib_books.bk_publisher, 
                        lib_books.bk_author, 
                        lib_books.bt_id, 
                        lib_books.bk_show,
                        lib_books_types.bt_name,
                        CASE 
                            WHEN lib_books.bk_show = 1 THEN 'แสดง' 
                            ELSE 'ไม่แสดง' 
                        END AS bk_show_text
                FROM lib_books
                LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id";

            // ตรวจสอบว่ามีการค้นหาหรือไม่
            if (!empty($search)) {
                // แปลงคำว่า "แสดง" หรือ "ไม่แสดง" กลับเป็น 1 หรือ 0 เพื่อใช้ในการค้นหา
                $sql .= " WHERE lib_books.bk_name LIKE :search 
                       OR lib_books.bk_quantity LIKE :search 
                       OR lib_books_types.bt_name LIKE :search 
                       OR (CASE 
                             WHEN lib_books.bk_show = 1 THEN 'แสดง' 
                             ELSE 'ไม่แสดง' 
                           END) LIKE :search";
            }

            // เพิ่มเงื่อนไขการจัดเรียง
            $columns = ['lib_books.bk_name', 'lib_books.bk_quantity', 'lib_books_types.bt_name', 'lib_books.bk_show', 'lib_books.bk_show']; // รายการจัดเรียงได้

            if (isset($columns[$orderColumn])) {
                $sql .= " ORDER BY " . $columns[$orderColumn] . " " . strtoupper($orderDir);
            }

            // เพิ่มเงื่อนไข limit
            $sql .= " LIMIT :start, :length";

            // เตรียม query
            $stmt = $this->conn->prepare($sql);

            // ถ้ามีการค้นหา ให้ bind ค่า %search%
            if (!empty($search)) {
                $searchParam = "%$search%";
                $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }

            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':length', $length, PDO::PARAM_INT);
            $stmt->execute();

            // ดึงผลลัพธ์
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // นับจำนวนข้อมูลทั้งหมด
            $totalSql = "SELECT COUNT(*) as total FROM lib_books";
            $totalStmt = $this->conn->query($totalSql);
            $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

            // นับจำนวนข้อมูลที่ค้นหาได้
            $filteredSql = "SELECT COUNT(*) as totalFiltered 
                        FROM lib_books
                        LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id";
            if (!empty($search)) {
                $filteredSql .= " WHERE lib_books.bk_name LIKE :search 
                              OR lib_books.bk_quantity LIKE :search 
                              OR lib_books_types.bt_name LIKE :search 
                              OR (CASE 
                                    WHEN lib_books.bk_show = 1 THEN 'แสดง' 
                                    ELSE 'ไม่แสดง' 
                                  END) LIKE :search";
            }
            $filteredStmt = $this->conn->prepare($filteredSql);

            if (!empty($search)) {
                $filteredStmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }

            $filteredStmt->execute();
            $totalFilteredCount = $filteredStmt->fetch(PDO::FETCH_ASSOC)['totalFiltered'];

            return [
                'data' => $result,
                'total' => $totalCount,
                'totalFiltered' => $totalFilteredCount
            ];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }


    function getBookType()
    {
        try {
            $sql = "SELECT bt_id, bt_name FROM lib_books_types";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function checkBookExists($bkName, $bkId = NULL)
    {
        try {
            $sql = "SELECT bk_name FROM lib_books 
                    WHERE bk_name = :bk_name ";

            if ($bkId != NULL) {
                $sql .= " AND bk_id != :bkId";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bk_name', $bkName, PDO::PARAM_STR);

            if ($bkId != NULL) {
                $stmt->bindParam(':bkId', $bkId, PDO::PARAM_INT);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function insertBook($bkName, $bkQuantity, $bkStudentLoanPeriod, $bkTeacherLoanPeriod, $bkDetail, $bkPublisher, $bkAuthor, $btId, $bkShow)
    {
        try {
            $sql = "INSERT INTO lib_books (bk_name, bk_quantity, bk_student_loan_period, bk_teacher_loan_period, bk_detail, bk_publisher, bk_author, bt_id, bk_show)
                    VALUES (:bk_name, :bk_quantity, :bk_student_loan_period, :bk_teacher_loan_period, :bk_detail, :bk_publisher, :bk_author, :bt_id, :bk_show)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':bk_name', $bkName, PDO::PARAM_STR);
            $stmt->bindParam(':bk_quantity', $bkQuantity, PDO::PARAM_INT);
            $stmt->bindParam(':bk_student_loan_period', $bkStudentLoanPeriod, PDO::PARAM_INT);
            $stmt->bindParam(':bk_teacher_loan_period', $bkTeacherLoanPeriod, PDO::PARAM_INT);
            $stmt->bindParam(':bk_detail', $bkDetail, PDO::PARAM_STR);
            $stmt->bindParam(':bk_publisher', $bkPublisher, PDO::PARAM_STR);
            $stmt->bindParam(':bk_author', $bkAuthor, PDO::PARAM_STR);
            $stmt->bindParam(':bt_id', $btId, PDO::PARAM_INT);
            $stmt->bindParam(':bk_show', $bkShow, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }


    function updateBook($bkId, $bkName, $bkQuantity, $bkStudentLoanPeriod, $bkTeacherLoanPeriod, $bkDetail, $bkPublisher, $bkAuthor, $btId, $bkShow, $bookImage)
    {
        try {
            $sql = "UPDATE lib_books
                   SET bk_name = :bk_name,
                       bk_quantity = :bk_quantity,
                       bk_student_loan_period = :bk_student_loan_period,
                       bk_teacher_loan_period = :bk_teacher_loan_period,
                       bk_detail = :bk_detail,
                       bk_publisher = :bk_publisher,
                       bk_author = :bk_author,
                       bt_id = :bt_id,
                       bk_show = :bk_show,
                       bk_img = :bk_img
                   WHERE bk_id = :bk_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bk_name', $bkName, PDO::PARAM_STR);
            $stmt->bindParam(':bk_quantity', $bkQuantity, PDO::PARAM_INT);
            $stmt->bindParam(':bk_student_loan_period', $bkStudentLoanPeriod, PDO::PARAM_INT);
            $stmt->bindParam(':bk_teacher_loan_period', $bkTeacherLoanPeriod, PDO::PARAM_INT);
            $stmt->bindParam(':bk_detail', $bkDetail, PDO::PARAM_STR);
            $stmt->bindParam(':bk_publisher', $bkPublisher, PDO::PARAM_STR);
            $stmt->bindParam(':bk_author', $bkAuthor, PDO::PARAM_STR);
            $stmt->bindParam(':bt_id', $btId, PDO::PARAM_INT);
            $stmt->bindParam(':bk_show', $bkShow, PDO::PARAM_INT);
            $stmt->bindParam(':bk_img', $bookImage, PDO::PARAM_STR);
            $stmt->bindParam(':bk_id', $bkId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function deleteBook($bkId)
    {
        try {
            $sql = "DELETE FROM lib_books WHERE bk_id = :bk_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bk_id', $bkId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function getNewBooks()
    {
        try {
            $sql = "SELECT  lib_books.bk_id, 
                            lib_books.bk_name, 
                            lib_books.bk_img,
                            lib_books_types.bt_name
                    FROM lib_books
                    LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id
                    WHERE lib_books.bk_show = 1
                    ORDER BY lib_books.bk_id DESC
                    LIMIT 8";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function getBookTypeCount()
    {
        try {
            $sql = "SELECT  lib_books_types.bt_id, 
                            lib_books_types.bt_name, 
                            COUNT(lib_books.bk_id) as book_count 
                    FROM lib_books_types
                    LEFT JOIN lib_books ON lib_books.bt_id = lib_books_types.bt_id
                    GROUP BY lib_books_types.bt_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function getBooks($limit, $offset, $btId = [], $search = '')
    {
        try {
            // คำสั่ง SQL เริ่มต้น
            $sql = "SELECT lib_books.bk_id, 
                            lib_books.bk_name, 
                            lib_books.bk_img,
                            lib_books_types.bt_name
                    FROM lib_books
                    LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id
                    WHERE lib_books.bk_show = 1";

            // ถ้ามีคำค้นหาจาก $search ให้เพิ่มเงื่อนไขการค้นหา
            if (!empty($search)) {
                $sql .= " AND lib_books.bk_name LIKE ?";
            }

            // ถ้ามีค่า $btId ให้เพิ่มคำสั่ง WHERE สำหรับประเภทหนังสือ
            if (!empty($btId)) {
                $placeholders = implode(',', array_fill(0, count($btId), '?'));
                $sql .= " AND lib_books.bt_id IN ($placeholders)";
            }

            // จัดลำดับข้อมูลและกำหนด LIMIT และ OFFSET
            $sql .= " ORDER BY lib_books.bk_id DESC LIMIT ? OFFSET ?";

            // เตรียม statement
            $stmt = $this->conn->prepare($sql);

            $bindIndex = 1;

            // ถ้ามีค่า $search ให้ผูกค่าลงใน statement
            if (!empty($search)) {
                $stmt->bindValue($bindIndex, '%' . $search . '%', PDO::PARAM_STR);
                $bindIndex++;
            }

            // ถ้ามีค่า $btId ให้ผูกค่าใน array ลงใน query
            if (!empty($btId)) {
                foreach ($btId as $id) {
                    $stmt->bindValue($bindIndex, $id, PDO::PARAM_INT);
                    $bindIndex++;
                }
            }

            // ผูกค่า limit และ offset
            $stmt->bindValue($bindIndex, $limit, PDO::PARAM_INT);
            $stmt->bindValue($bindIndex + 1, $offset, PDO::PARAM_INT);

            // Execute statement
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function countBooks($btId = [], $search = '')
    {
        try {
            // คำสั่ง SQL เริ่มต้น
            $sql = "SELECT COUNT(*) AS total FROM lib_books WHERE bk_show = 1";

            // ถ้ามีคำค้นหาจาก $search ให้เพิ่มเงื่อนไขการค้นหา
            if (!empty($search)) {
                $sql .= " AND bk_name LIKE ?";
            }

            // ถ้ามีค่า $btId ให้เพิ่ม WHERE ตามประเภทหนังสือ
            if (!empty($btId)) {
                $placeholders = implode(',', array_fill(0, count($btId), '?'));
                $sql .= " AND bt_id IN ($placeholders)";
            }

            // เตรียม statement
            $stmt = $this->conn->prepare($sql);

            $bindIndex = 1;

            // ถ้ามีค่า $search ให้ผูกค่าลงใน statement
            if (!empty($search)) {
                $stmt->bindValue($bindIndex, '%' . $search . '%', PDO::PARAM_STR);
                $bindIndex++;
            }

            // ผูกค่าใน array $btId (ถ้ามี)
            if (!empty($btId)) {
                foreach ($btId as $id) {
                    $stmt->bindValue($bindIndex, $id, PDO::PARAM_INT);
                    $bindIndex++;
                }
            }

            // Execute statement
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function getBookDetail($bkId)
    {
        try {
            $sql = "SELECT lib_books.bk_id, 
                        lib_books.bk_name, 
                        lib_books.bk_img,
                        lib_books.bk_quantity,
                        lib_books.bk_student_loan_period,
                        lib_books.bk_teacher_loan_period,
                        lib_books.bk_detail,
                        lib_books.bk_publisher,
                        lib_books.bk_author,
                        lib_books_types.bt_name
                    FROM lib_books 
                    LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id
                    WHERE bk_id = :bk_id AND bk_show = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bk_id', $bkId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function checkBookBorrow($usrId, $bkId)
    {
        try {
            $sql = "SELECT COUNT(bk_id) AS total_borrow 
                    FROM lib_books_borrow 
                    WHERE br_status = 'borrow' AND usr_id = :usr_id AND bk_id = :bk_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);
            $stmt->bindParam(':bk_id', $bkId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // ตรวจสอบว่ามีการยืมหนังสือเล่มนี้ไปแล้วหรือไม่
            if ($result['total_borrow'] > 0) {
                return false; // มีการยืมแล้ว
            } else {
                return true; // ยังไม่ได้ยืม
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function insertBookBorrow($usrId, $bkId)
    {
        try {
            $this->conn->beginTransaction();

            $sql = "INSERT INTO lib_books_borrow (usr_id, bk_id)
                    VALUES (:usr_id, :bk_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);
            $stmt->bindParam(':bk_id', $bkId, PDO::PARAM_INT);
            $stmt->execute();

            $sql = "UPDATE lib_books 
                    SET bk_quantity = bk_quantity - 1
                    WHERE bk_id = :bk_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bk_id', $bkId, PDO::PARAM_INT);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }


    function getAccountHistoryBorrow($start, $length, $search, $orderColumn, $orderDir, $usrId)
    {
        try {
            // เริ่มสร้าง SQL Query
            $sql = "SELECT  lib_books_borrow.br_borrow_date,
                        lib_books_borrow.br_return_date,
                        lib_books_borrow.br_amount,
                        lib_books_borrow.br_status,
                        lib_books.bk_name
                FROM lib_books_borrow
                LEFT JOIN lib_books ON lib_books.bk_id = lib_books_borrow.bk_id
                WHERE lib_books_borrow.usr_id = :usr_id";

            // ตรวจสอบว่ามีการค้นหาหรือไม่
            if (!empty($search)) {
                $sql .= " AND (lib_books_borrow.br_borrow_date LIKE :search 
                        OR lib_books.bk_name LIKE :search 
                        OR lib_books_borrow.br_amount LIKE :search
                        OR lib_books_borrow.br_status LIKE :search
                        OR lib_books_borrow.br_return_date LIKE :search)";
            }

            // เพิ่มเงื่อนไขการจัดเรียง
            $columns = ['lib_books_borrow.br_borrow_date', 'lib_books.bk_name', 'lib_books_borrow.br_amount', 'lib_books_borrow.br_status', 'lib_books_borrow.br_return_date',]; // รายการจัดเรียงได้

            if (isset($columns[$orderColumn])) {
                $sql .= " ORDER BY " . $columns[$orderColumn] . " " . strtoupper($orderDir);
            }

            // เพิ่มเงื่อนไข limit
            $sql .= " LIMIT :start, :length";

            // เตรียม query
            $stmt = $this->conn->prepare($sql);

            // ถ้ามีการค้นหา ให้ bind ค่า %search%
            if (!empty($search)) {
                $searchParam = "%$search%";
                $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }

            $stmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':length', $length, PDO::PARAM_INT);
            $stmt->execute();

            // ดึงผลลัพธ์
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // นับจำนวนข้อมูลทั้งหมด (lib_books_borrow ที่เกี่ยวข้องกับ usr_id)
            $totalSql = "SELECT COUNT(*) as total FROM lib_books_borrow WHERE usr_id = :usr_id";
            $totalStmt = $this->conn->prepare($totalSql);
            $totalStmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);
            $totalStmt->execute();
            $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

            // นับจำนวนข้อมูลที่ค้นหาได้
            $filteredSql = "SELECT COUNT(*) as totalFiltered 
                        FROM lib_books_borrow
                        LEFT JOIN lib_books ON lib_books.bk_id = lib_books_borrow.bk_id
                        WHERE lib_books_borrow.usr_id = :usr_id";
            if (!empty($search)) {
                $filteredSql .= " AND (lib_books.bk_name LIKE :search 
                              OR lib_books_borrow.br_borrow_date LIKE :search
                              OR lib_books_borrow.br_amount LIKE :search
                              OR lib_books_borrow.br_status LIKE :search
                              OR lib_books_borrow.br_return_date LIKE :search)";
            }

            $filteredStmt = $this->conn->prepare($filteredSql);
            $filteredStmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);

            if (!empty($search)) {
                $filteredStmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }

            $filteredStmt->execute();
            $totalFilteredCount = $filteredStmt->fetch(PDO::FETCH_ASSOC)['totalFiltered'];

            return [
                'data' => $result,
                'total' => $totalCount,
                'totalFiltered' => $totalFilteredCount
            ];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }
    function getBookBorrowList($start, $length, $search, $orderColumn, $orderDir)
    {
        try {
            // เริ่มสร้าง SQL Query
            $sql = "SELECT lib_books_borrow.br_id,  
                        lib_books_borrow.br_borrow_date,
                        lib_books_borrow.br_amount,
                        lib_books.bk_id,
                        lib_books.bk_name,
                        lib_books.bk_img,
                        lib_users.usr_fname,
                        lib_users.usr_lname
                FROM lib_books_borrow
                INNER JOIN lib_users ON lib_users.usr_id = lib_books_borrow.usr_id
                LEFT JOIN lib_books ON lib_books.bk_id = lib_books_borrow.bk_id
                WHERE lib_books_borrow.br_status = 'Borrow' ";

            // ตรวจสอบว่ามีการค้นหาหรือไม่
            if (!empty($search)) {
                $sql .= " AND (lib_books.bk_name LIKE :search 
                        OR lib_users.usr_fname LIKE :search 
                        OR lib_users.usr_lname LIKE :search
                        OR lib_books_borrow.br_borrow_date LIKE :search)";
            }

            // เพิ่มเงื่อนไขการจัดเรียง
            $columns = ['lib_books.bk_img', 'lib_books.bk_name', 'lib_users.usr_fname', 'lib_users.usr_lname', 'lib_books_borrow.br_borrow_date']; // รายการจัดเรียงได้

            if (isset($columns[$orderColumn])) {
                $sql .= " ORDER BY " . $columns[$orderColumn] . " " . strtoupper($orderDir);
            }

            // เพิ่มเงื่อนไข limit
            $sql .= " LIMIT :start, :length";

            // เตรียม query
            $stmt = $this->conn->prepare($sql);

            // ถ้ามีการค้นหา ให้ bind ค่า %search%
            if (!empty($search)) {
                $searchParam = "%$search%";
                $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }

            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':length', $length, PDO::PARAM_INT);
            $stmt->execute();

            // ดึงผลลัพธ์
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // นับจำนวนข้อมูลทั้งหมด (lib_books_borrow ที่เกี่ยวข้องกับ usr_id)
            $totalSql = "SELECT COUNT(*) as total FROM lib_books_borrow WHERE lib_books_borrow.br_status = 'Borrow'";
            $totalStmt = $this->conn->prepare($totalSql);
            $totalStmt->execute();
            $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

            // นับจำนวนข้อมูลที่ค้นหาได้
            $filteredSql = "SELECT COUNT(*) as totalFiltered 
                            FROM lib_books_borrow
                            INNER JOIN lib_users ON lib_users.usr_id = lib_books_borrow.usr_id
                            LEFT JOIN lib_books ON lib_books.bk_id = lib_books_borrow.bk_id
                            WHERE lib_books_borrow.br_status = 'Borrow'";


            if (!empty($search)) {
                $filteredSql .= " AND (lib_books.bk_name LIKE :search 
                        OR lib_users.usr_fname LIKE :search 
                        OR lib_users.usr_lname LIKE :search
                        OR lib_books_borrow.br_borrow_date LIKE :search)";
            }

            $filteredStmt = $this->conn->prepare($filteredSql);


            if (!empty($search)) {
                $filteredStmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
            }

            $filteredStmt->execute();
            $totalFilteredCount = $filteredStmt->fetch(PDO::FETCH_ASSOC)['totalFiltered'];

            return [
                'data' => $result,
                'total' => $totalCount,
                'totalFiltered' => $totalFilteredCount
            ];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function updateBookBorrowStatusReturn($brId, $bkId)
    {
        try {

            $this->conn->beginTransaction();

            $sql = "UPDATE lib_books_borrow 
                    SET br_status = 'Return',
                        br_return_date = NOW()
                    WHERE br_id = :br_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':br_id', $brId, PDO::PARAM_INT);
            $stmt->execute();

            $sql = "UPDATE lib_books 
                    SET bk_quantity = bk_quantity + 1
                    WHERE bk_id = :bk_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bk_id', $bkId, PDO::PARAM_INT);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function deleteBookBorrow($brId, $bkId)
    {
        try {

            $this->conn->beginTransaction();

            $sql = "DELETE FROM lib_books_borrow 
                    WHERE br_id = :br_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':br_id', $brId, PDO::PARAM_INT);
            $stmt->execute();

            $sql = "UPDATE lib_books 
                    SET bk_quantity = bk_quantity + 1
                    WHERE bk_id = :bk_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bk_id', $bkId, PDO::PARAM_INT);
            $stmt->execute();

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }
}
