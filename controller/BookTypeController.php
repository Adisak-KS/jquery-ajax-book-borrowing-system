<?php

class bookTypeController
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        // echo "<p>เรียกใช้ BookType Controller สำเร็จ</p>";
    }

    function getBookTypeList($start, $length, $search, $orderColumn, $orderDir)
    {
        try {
            // เริ่มสร้าง SQL Query
            $sql = "SELECT bt_id, bt_name
                    FROM lib_books_types";

            // ตรวจสอบว่ามีการค้นหาหรือไม่
            if (!empty($search)) {
                $sql .= " WHERE bt_id LIKE :search OR bt_name LIKE :search";
            }

            // เพิ่มเงื่อนไขการจัดเรียง
            $columns = ['bt_id', 'bt_name']; // คอลัมน์ที่จัดเรียงได้
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
            $totalSql = "SELECT COUNT(*) as total FROM lib_books_types";
            $totalStmt = $this->conn->query($totalSql);
            $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

            // นับจำนวนข้อมูลที่ค้นหาได้
            $filteredSql = "SELECT COUNT(*) as totalFiltered FROM lib_books_types";
            if (!empty($search)) {
                $filteredSql .= " WHERE bt_id LIKE :search OR bt_name LIKE :search";
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

    function checkBookTypeExists($btName, $btId = NULL)
    {
        try {
            $sql = "SELECT COUNT(bt_id) as amount_book_type
                    FROM lib_books_types
                    WHERE bt_name = :bt_name ";

            if ($btId != NULL) {
                $sql .= " AND bt_id != :bt_id";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bt_name', $btName, PDO::PARAM_STR);

            if ($btId != NULL) {
                $stmt->bindParam(':bt_id', $btId, PDO::PARAM_INT);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['amount_book_type'] > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function insertBookType($btName)
    {
        try {
            $sql = "INSERT INTO lib_books_types (bt_name)
                    VALUES (:bt_name)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bt_name', $btName, PDO::PARAM_STR);
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

    function updateBookType($btId, $btName)
    {
        try {
            $sql = "UPDATE lib_books_types
                    SET bt_name = :bt_name
                    WHERE bt_id = :bt_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bt_id', $btId, PDO::PARAM_INT);
            $stmt->bindParam(':bt_name', $btName, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function deleteBookType($btId)
    {
        try {
            $sql = "DELETE FROM lib_books_types
                    WHERE bt_id = :bt_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':bt_id', $btId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }
}
