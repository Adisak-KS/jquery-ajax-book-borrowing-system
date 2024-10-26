<?php

class UserController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        // echo "<p>เรียกใช้ User Controller สำเร็จ</p>";
    }

    function getUserList($start, $length, $search, $orderColumn, $orderDir)
    {
        try {
            // เริ่มสร้าง SQL Query
            $sql = "SELECT usr_id, usr_profile, usr_fname, usr_lname, usr_username, usr_type 
                    FROM lib_users";

            // ตรวจสอบว่ามีการค้นหาหรือไม่
            if (!empty($search)) {
                $sql .= " WHERE usr_fname LIKE :search OR usr_lname LIKE :search OR usr_username LIKE :search OR usr_type LIKE :search";
            }

            // เพิ่มเงื่อนไขการจัดเรียง
            $columns = ['usr_fname', 'usr_lname', 'usr_username', 'usr_type', 'usr_type']; // คอลัมน์ที่จัดเรียงได้
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

            // Bind ค่า start และ length
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':length', $length, PDO::PARAM_INT);
            $stmt->execute();

            // ดึงผลลัพธ์
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // นับจำนวนข้อมูลทั้งหมด
            $totalSql = "SELECT COUNT(*) as total FROM lib_users";
            $totalStmt = $this->conn->query($totalSql);
            $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

            // นับจำนวนข้อมูลที่ค้นหาได้
            $filteredSql = "SELECT COUNT(*) as totalFiltered FROM lib_users";
            if (!empty($search)) {
                $filteredSql .= " WHERE usr_fname LIKE :search OR usr_lname LIKE :search OR usr_username LIKE :search OR usr_type LIKE :search";
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

    function checkUserExists($usrUsername, $usrId = NULL)
    {
        try {
            $sql = "SELECT COUNT(usr_id) as amount_user
                    FROM lib_users
                    WHERE usr_username = :usr_username ";

            if ($usrId != NULL) {
                $sql .= " AND usr_id != :usr_id ";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usr_username', $usrUsername, PDO::PARAM_STR);

            if ($usrId != NULL) {
                $stmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['amount_user'] > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function insertUser($usrFname, $usrLname, $usrUsername, $usrPassword, $usrType)
    {
        try {

            $usrPasswordHash = password_hash($usrPassword, PASSWORD_DEFAULT);

            $sql = "INSERT INTO lib_users (usr_fname, usr_lname, usr_username, usr_password, usr_type)
                    VALUES (:usr_fname, :usr_lname, :usr_username, :usr_password, :usr_type)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usr_fname', $usrFname, PDO::PARAM_STR);
            $stmt->bindParam(':usr_lname', $usrLname, PDO::PARAM_STR);
            $stmt->bindParam(':usr_username', $usrUsername, PDO::PARAM_STR);
            $stmt->bindParam(':usr_password', $usrPasswordHash, PDO::PARAM_STR);
            $stmt->bindParam(':usr_type', $usrType, PDO::PARAM_STR);
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

    function updateUser($usrId, $usrFname, $usrLname, $usrUsername, $usrType, $profileImage)
    {
        try {
            $sql = "UPDATE lib_users
                    SET usr_fname = :usr_fname,
                        usr_lname = :usr_lname,
                        usr_username = :usr_username,
                        usr_type = :usr_type,
                        usr_profile = :usr_profile
                    WHERE usr_id = :usr_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usr_fname', $usrFname, PDO::PARAM_STR);
            $stmt->bindParam(':usr_lname', $usrLname, PDO::PARAM_STR);
            $stmt->bindParam(':usr_username', $usrUsername, PDO::PARAM_STR);
            $stmt->bindParam(':usr_type', $usrType, PDO::PARAM_STR);
            $stmt->bindParam(':usr_profile', $profileImage, PDO::PARAM_STR);
            $stmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function deleteUser($usrId)
    {
        try {
            $sql = "DELETE FROM lib_users 
                    WHERE usr_id = :usr_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }


    function checkUserLogin($usrUsername, $usrPassword)
    {
        try {
            $sql = "SELECT usr_id,usr_password
                    FROM lib_users
                    WHERE usr_username = :usr_username";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usr_username', $usrUsername, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {

                if (password_verify($usrPassword, $result['usr_password'])) {
                    // รหัสผ่านถูกต้อง
                    return $result;
                } else {
                    // รหัสผ่านไม่ถูกต้อง
                    return false;
                }
            } else {
                // ไม่พบ ีusername
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function getMyAccount($usrId)
    {
        try {
            $sql = "SELECT usr_fname, usr_lname, usr_username, usr_type, usr_profile
                    FROM lib_users
                    WHERE usr_id = :usr_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    function checkUserAccountPassword($usrId, $usrOldPassword)
    {
        try {
            $sql = "SELECT usr_password 
                    FROM lib_users 
                    WHERE usr_id = :usr_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // ตรวจสอบว่าพบรหัสผ่านเก่าและเปรียบเทียบรหัสผ่าน
            if ($result && password_verify($usrOldPassword, $result['usr_password'])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    function updateUserPassword($usrId, $usrNewPassword)
    {
        try {
            $passwordHash = password_hash($usrNewPassword, PASSWORD_DEFAULT);

            $sql = "UPDATE lib_users 
                    SET usr_password = :usr_password 
                    WHERE usr_id = :usr_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usr_password', $passwordHash, PDO::PARAM_STR);
            $stmt->bindParam(':usr_id', $usrId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    function getHistoryBorrow($start, $length, $search, $orderColumn, $orderDir, $usrId)
    {
        try {
            // เริ่มสร้าง SQL Query
            $sql = "SELECT 	lib_borrow.br_borrow_date,
                            lib_borrow.br_return_date,
                            lib_borrow.br_amount,
                            lib_books.bk_name,
                            lib_books.bk_student_loan_period,
                            lib_books.bk_teacher_loan_period,
                            lib_user.usr_id,
                            lib_user.usr_type,
                    FROM lib_borrow
                    INNER JOIN lib_users ON lib_users.usr_id = lib_borrow.usr_id
                    INNER JOIN lib_books ON lib_books.bk_id = lib_borrow.bk_id";

            // ตรวจสอบว่ามีการค้นหาหรือไม่
            if (!empty($search)) {
                $sql .= " WHERE usr_fname LIKE :search OR usr_lname LIKE :search OR usr_username LIKE :search OR usr_type LIKE :search";
            }

            // เพิ่มเงื่อนไขการจัดเรียง
            $columns = ['usr_fname', 'usr_lname', 'usr_username', 'usr_type', 'usr_type']; // คอลัมน์ที่จัดเรียงได้
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

            // Bind ค่า start และ length
            $stmt->bindParam(':start', $start, PDO::PARAM_INT);
            $stmt->bindParam(':length', $length, PDO::PARAM_INT);
            $stmt->execute();

            // ดึงผลลัพธ์
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // นับจำนวนข้อมูลทั้งหมด
            $totalSql = "SELECT COUNT(*) as total FROM lib_users";
            $totalStmt = $this->conn->query($totalSql);
            $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

            // นับจำนวนข้อมูลที่ค้นหาได้
            $filteredSql = "SELECT COUNT(*) as totalFiltered FROM lib_users";
            if (!empty($search)) {
                $filteredSql .= " WHERE usr_fname LIKE :search OR usr_lname LIKE :search OR usr_username LIKE :search OR usr_type LIKE :search";
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
}
