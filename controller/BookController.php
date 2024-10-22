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


    // function getBookList($start, $length, $search, $orderColumn, $orderDir)
    // {
    //     try {
    //         // เริ่มสร้าง SQL Query
    //         $sql = "SELECT  lib_books.bk_id, 
    //                         lib_books.bk_img,
    //                         lib_books.bk_name, 
    //                         lib_books.bk_quantity, 
    //                         lib_books.bk_detail, 
    //                         lib_books.bk_publisher, 
    //                         lib_books.bk_author, 
    //                         lib_books.bt_id, 
    //                         lib_books.bk_show,
    //                         lib_books_types.bt_name,
    //                         CASE 
    //                             WHEN lib_books.bk_show = 1 THEN 'แสดง' 
    //                             ELSE 'ไม่แสดง' 
    //                         END AS bk_show_text
    //                 FROM lib_books
    //                 LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id";

    //         // ตรวจสอบว่ามีการค้นหาหรือไม่
    //         if (!empty($search)) {
    //             $sql .= " WHERE lib_books.bk_name LIKE :search 
    //                        OR lib_books.bk_quantity LIKE :search 
    //                        OR lib_books_types.bt_name LIKE :search";
    //         }

    //         // เพิ่มเงื่อนไขการจัดเรียง
    //         $columns = ['lib_books.bk_name', 'lib_books.bk_quantity', 'lib_books_types.bt_name', 'lib_books.bk_show', 'lib_books.bk_show'];

    //         if (isset($columns[$orderColumn])) {
    //             $sql .= " ORDER BY " . $columns[$orderColumn] . " " . strtoupper($orderDir);
    //         }

    //         // เพิ่มเงื่อนไข limit
    //         $sql .= " LIMIT :start, :length";

    //         // เตรียม query
    //         $stmt = $this->conn->prepare($sql);

    //         // ถ้ามีการค้นหา ให้ bind ค่า %search%
    //         if (!empty($search)) {
    //             $searchParam = "%$search%";
    //             $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    //         }

    //         $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    //         $stmt->bindParam(':length', $length, PDO::PARAM_INT);
    //         $stmt->execute();

    //         // ดึงผลลัพธ์
    //         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //         // นับจำนวนข้อมูลทั้งหมด
    //         $totalSql = "SELECT COUNT(*) as total FROM lib_books";
    //         $totalStmt = $this->conn->query($totalSql);
    //         $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

    //         // นับจำนวนข้อมูลที่ค้นหาได้
    //         $filteredSql = "SELECT COUNT(*) as totalFiltered 
    //                         FROM lib_books
    //                         LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id";
    //         if (!empty($search)) {
    //             $filteredSql .= " WHERE lib_books.bk_name LIKE :search 
    //                               OR lib_books.bk_quantity LIKE :search 
    //                               OR lib_books_types.bt_name LIKE :search";
    //         }
    //         $filteredStmt = $this->conn->prepare($filteredSql);

    //         if (!empty($search)) {
    //             $filteredStmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    //         }

    //         $filteredStmt->execute();
    //         $totalFilteredCount = $filteredStmt->fetch(PDO::FETCH_ASSOC)['totalFiltered'];

    //         return [
    //             'data' => $result,
    //             'total' => $totalCount,
    //             'totalFiltered' => $totalFilteredCount
    //         ];
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage() . "<hr>";
    //         return false;
    //     }
    // }


    // function getBookList($start, $length, $search, $orderColumn, $orderDir)
    // {
    //     try {
    //         // เริ่มสร้าง SQL Query
    //         $sql = "SELECT  lib_books.bk_id, 
    //                         lib_books.bk_img,
    //                         lib_books.bk_name, 
    //                         lib_books.bk_quantity, 
    //                         lib_books.bk_detail, 
    //                         lib_books.bk_publisher, 
    //                         lib_books.bk_author, 
    //                         lib_books.bt_id, 
    //                         lib_books.bk_show,
    //                         lib_books_types.bt_name
    //                 FROM lib_books
    //                 LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id";

    //         // ตรวจสอบว่ามีการค้นหาหรือไม่
    //         if (!empty($search)) {
    //             $sql .= " WHERE lib_books.bk_name LIKE :search OR lib_books.bk_quantity LIKE :search OR lib_books_types.bt_name LIKE :search";
    //         }

    //         // เพิ่มเงื่อนไขการจัดเรียง
    //         // $columns = ['lib_books.bk_name', 'lib_books.bk_quantity', 'lib_books.bk_show', 'lib_books_types.bt_name']; // คอลัมน์ที่จัดเรียงได้
    //         $columns = ['lib_books.bk_name', 'lib_books.bk_quantity', 'lib_books.bk_show', 'lib_books_types.bt_name', 'lib_books.bk_show']; // เพิ่ม bk_show

    //         if (isset($columns[$orderColumn])) {
    //             $sql .= " ORDER BY " . $columns[$orderColumn] . " " . strtoupper($orderDir);
    //         }

    //         // เพิ่มเงื่อนไข limit
    //         $sql .= " LIMIT :start, :length";

    //         // เตรียม query
    //         $stmt = $this->conn->prepare($sql);

    //         // ถ้ามีการค้นหา ให้ bind ค่า %search%
    //         if (!empty($search)) {
    //             $searchParam = "%$search%";
    //             $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    //         }

    //         $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    //         $stmt->bindParam(':length', $length, PDO::PARAM_INT);
    //         $stmt->execute();

    //         // ดึงผลลัพธ์
    //         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //         // นับจำนวนข้อมูลทั้งหมด
    //         $totalSql = "SELECT COUNT(*) as total FROM lib_books";
    //         $totalStmt = $this->conn->query($totalSql);
    //         $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

    //         // นับจำนวนข้อมูลที่ค้นหาได้
    //         $filteredSql = "SELECT COUNT(*) as totalFiltered 
    //                         FROM lib_books
    //                         LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id";
    //         if (!empty($search)) {
    //             $filteredSql .= " WHERE lib_books.bk_name LIKE :search OR lib_books.bk_quantity LIKE :search OR lib_books_types.bt_name LIKE :search";
    //         }
    //         $filteredStmt = $this->conn->prepare($filteredSql);

    //         if (!empty($search)) {
    //             $filteredStmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    //         }

    //         $filteredStmt->execute();
    //         $totalFilteredCount = $filteredStmt->fetch(PDO::FETCH_ASSOC)['totalFiltered'];

    //         return [
    //             'data' => $result,
    //             'total' => $totalCount,
    //             'totalFiltered' => $totalFilteredCount
    //         ];
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage() . "<hr>";
    //         return false;
    //     }
    // }
    // function getBookList($start, $length, $search, $orderColumn, $orderDir)
    // {
    //     try {
    //         // เริ่มสร้าง SQL Query
    //         $sql = "SELECT  lib_books.bk_id, 
    //                         lib_books.bk_img,
    //                         lib_books.bk_name, 
    //                         lib_books.bk_quantity, 
    //                         lib_books.bk_detail, 
    //                         lib_books.bk_publisher, 
    //                         lib_books.bk_author, 
    //                         lib_books.bt_id, 
    //                         lib_books.bk_show,
    //                         lib_books_types.bt_name
    //                 FROM lib_books
    //                 LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id";

    //         // ตรวจสอบว่ามีการค้นหาหรือไม่
    //         if (!empty($search)) {
    //             $sql .= " WHERE lib_books.bk_name LIKE :search OR lib_books.bk_quantity LIKE :search OR lib_books_types.bt_name LIKE :search";
    //         }

    //         // เพิ่มเงื่อนไขการจัดเรียง
    //         // $columns = ['lib_books.bk_name', 'lib_books.bk_quantity', 'lib_books.bk_show', 'lib_books_types.bt_name']; // คอลัมน์ที่จัดเรียงได้
    //         $columns = ['lib_books.bk_name', 'lib_books.bk_quantity', 'lib_books.bk_show', 'lib_books_types.bt_name', 'lib_books.bk_show']; // เพิ่ม bk_show

    //         if (isset($columns[$orderColumn])) {
    //             $sql .= " ORDER BY " . $columns[$orderColumn] . " " . strtoupper($orderDir);
    //         }

    //         // เพิ่มเงื่อนไข limit
    //         $sql .= " LIMIT :start, :length";

    //         // เตรียม query
    //         $stmt = $this->conn->prepare($sql);

    //         // ถ้ามีการค้นหา ให้ bind ค่า %search%
    //         if (!empty($search)) {
    //             $searchParam = "%$search%";
    //             $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    //         }

    //         $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    //         $stmt->bindParam(':length', $length, PDO::PARAM_INT);
    //         $stmt->execute();

    //         // ดึงผลลัพธ์
    //         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //         // นับจำนวนข้อมูลทั้งหมด
    //         $totalSql = "SELECT COUNT(*) as total FROM lib_books";
    //         $totalStmt = $this->conn->query($totalSql);
    //         $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

    //         // นับจำนวนข้อมูลที่ค้นหาได้
    //         $filteredSql = "SELECT COUNT(*) as totalFiltered 
    //                         FROM lib_books
    //                         LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id";
    //         if (!empty($search)) {
    //             $filteredSql .= " WHERE lib_books.bk_name LIKE :search OR lib_books.bk_quantity LIKE :search OR lib_books_types.bt_name LIKE :search";
    //         }
    //         $filteredStmt = $this->conn->prepare($filteredSql);

    //         if (!empty($search)) {
    //             $filteredStmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    //         }

    //         $filteredStmt->execute();
    //         $totalFilteredCount = $filteredStmt->fetch(PDO::FETCH_ASSOC)['totalFiltered'];

    //         return [
    //             'data' => $result,
    //             'total' => $totalCount,
    //             'totalFiltered' => $totalFilteredCount
    //         ];
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage() . "<hr>";
    //         return false;
    //     }
    // }


    // function getBookList($start, $length, $search, $orderColumn, $orderDir)
    // {
    //     try {
    //         // เริ่มสร้าง SQL Query
    //         $sql = "SELECT  lib_books.bk_id, 
    //                         lib_books.bk_img,
    //                         lib_books.bk_name, 
    //                         lib_books.bk_quantity, 
    //                         lib_books.bk_detail, 
    //                         lib_books.bk_publisher, 
    //                         lib_books.bk_author, 
    //                         lib_books.bt_id, 
    //                         lib_books.bk_show,
    //                         lib_books_types.bt_name
    //                 FROM lib_books
    //                 LEFT JOIN lib_books_types ON lib_books.bt_id = lib_books_types.bt_id";

    //         // ตรวจสอบว่ามีการค้นหาหรือไม่
    //         if (!empty($search)) {
    //             $sql .= " WHERE lib_books.bk_name LIKE :search OR lib_books.bk_quantity LIKE :search OR lib_books_types.bt_name LIKE :search";
    //         }

    //         // เพิ่มเงื่อนไขการจัดเรียง
    //         $columns = ['lib_books.bk_name', 'lib_books.bk_quantity', 'lib_books.bk_show', 'lib_books_types.bt_name']; // คอลัมน์ที่จัดเรียงได้
    //         if (isset($columns[$orderColumn])) {
    //             $sql .= " ORDER BY " . $columns[$orderColumn] . " " . strtoupper($orderDir);
    //         }

    //         // เพิ่มเงื่อนไข limit
    //         $sql .= " LIMIT :start, :length";

    //         // เตรียม query
    //         $stmt = $this->conn->prepare($sql);

    //         // ถ้ามีการค้นหา ให้ bind ค่า %search%
    //         if (!empty($search)) {
    //             $searchParam = "%$search%";
    //             $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    //         }

    //         $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    //         $stmt->bindParam(':length', $length, PDO::PARAM_INT);
    //         $stmt->execute();

    //         // ดึงผลลัพธ์
    //         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //         // นับจำนวนข้อมูลทั้งหมด
    //         $totalSql = "SELECT COUNT(*) as total FROM lib_books";
    //         $totalStmt = $this->conn->query($totalSql);
    //         $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

    //         // นับจำนวนข้อมูลที่ค้นหาได้
    //         $filteredSql = "SELECT COUNT(*) as totalFiltered FROM lib_books";
    //         if (!empty($search)) {
    //             $filteredSql .= "  WHERE lib_books.bk_name LIKE :search OR lib_books.bk_quantity LIKE :search OR lib_books_types.bt_name LIKE :search";
    //         }
    //         $filteredStmt = $this->conn->prepare($filteredSql);

    //         if (!empty($search)) {
    //             $filteredStmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    //         }

    //         $filteredStmt->execute();
    //         $totalFilteredCount = $filteredStmt->fetch(PDO::FETCH_ASSOC)['totalFiltered'];

    //         return [
    //             'data' => $result,
    //             'total' => $totalCount,
    //             'totalFiltered' => $totalFilteredCount
    //         ];
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage() . "<hr>";
    //         return false;
    //     }
    // }


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


    function getBooks($limit, $offset, $btId = NULL)
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

            // ถ้ามีค่า $btId ให้เพิ่มคำสั่ง WHERE สำหรับประเภทหนังสือ
            if (!empty($btId)) {
                // สร้าง placeholder สำหรับค่าใน array ของ $btId
                $placeholders = implode(',', array_fill(0, count($btId), '?'));
                $sql .= " AND lib_books.bt_id IN ($placeholders)";
            }

            // จัดลำดับข้อมูลและกำหนด LIMIT และ OFFSET
            $sql .= " ORDER BY lib_books.bk_id DESC LIMIT ? OFFSET ?";

            // เตรียม statement
            $stmt = $this->conn->prepare($sql);

            // ผูกค่า limit และ offset
            $stmt->bindValue(count($btId) + 1, $limit, PDO::PARAM_INT);
            $stmt->bindValue(count($btId) + 2, $offset, PDO::PARAM_INT);

            // ถ้ามีค่า $btId ให้ผูกค่าใน array ลงใน query
            if (!empty($btId)) {
                foreach ($btId as $index => $id) {
                    // ใช้ bindValue สำหรับค่าของประเภทหนังสือใน array $btId
                    $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);
                }
            }

            // Execute statement
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    // ฟังก์ชันสำหรับการนับจำนวนหนังสือ
    function countBooks($btId = NULL)
    {
        try {
           
            $sql = "SELECT COUNT(*) AS total FROM lib_books WHERE bk_show = 1";

            // ถ้ามีค่า $btId ให้เพิ่ม WHERE ตามประเภทหนังสือ
            if (!empty($btId)) {
                // สร้าง placeholder สำหรับค่าของ $btId
                $placeholders = implode(',', array_fill(0, count($btId), '?'));
                $sql .= " AND bt_id IN ($placeholders)";
            }

            $stmt = $this->conn->prepare($sql);

            // ผูกค่าใน array $btId (ถ้ามี)
            if (!empty($btId)) {
                foreach ($btId as $index => $id) {
                    $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);
                }
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return 0;
        }
    }

    
}
