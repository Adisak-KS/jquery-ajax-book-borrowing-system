<?php
// require_once "../db/connect.php";

class AdminController
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        // echo "<p>เรียกใช้ Admin Controller สำเร็จ</p>";
    }

    function insertSuperAdminDefault()
    {
        try {
            $this->conn->beginTransaction();

            $sql = "SELECT COUNT(adm_id) as amount_super_admin
                    FROM lib_admins
                    WHERE adm_super_admin = 1
                    LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['amount_super_admin'] < 1) {

                $admFname = "super";
                $admLname = "admin";
                $admStaffId = "0000000000000";
                $admPassword = password_hash("0000000000000", PASSWORD_DEFAULT);
                $admSuperAdmin = 1;

                $sql = "INSERT INTO lib_admins (adm_fname, adm_lname, adm_staff_id, adm_password, adm_super_admin)
                        VALUES (:adm_fname, :adm_lname, :adm_staff_id, :adm_password, :adm_super_admin)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':adm_fname', $admFname);
                $stmt->bindParam(':adm_lname', $admLname);
                $stmt->bindParam(':adm_staff_id', $admStaffId);
                $stmt->bindParam(':adm_password', $admPassword);
                $stmt->bindParam(':adm_super_admin', $admSuperAdmin);
                $stmt->execute();

                $this->conn->commit();
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Error : " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    // function getAdminList($start, $length, $search, $orderColumn, $orderDir, $admId)
    // {
    //     try {
    //         // เริ่มสร้าง SQL Query
    //         $sql = "SELECT adm_id, adm_profile, adm_fname, adm_lname, adm_staff_id, adm_super_admin 
    //                 FROM lib_admins";

    //         // ตรวจสอบว่ามีการค้นหาหรือไม่
    //         if (!empty($search)) {
    //             $sql .= " WHERE adm_fname LIKE :search OR adm_lname LIKE :search OR adm_staff_id LIKE :search";
    //         }

    //         // เพิ่มเงื่อนไขการจัดเรียง
    //         $columns = ['adm_fname', 'adm_lname', 'adm_staff_id']; // คอลัมน์ที่จัดเรียงได้
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
    //         $totalSql = "SELECT COUNT(*) as total FROM lib_admins";
    //         $totalStmt = $this->conn->query($totalSql);
    //         $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

    //         // นับจำนวนข้อมูลที่ค้นหาได้
    //         $filteredSql = "SELECT COUNT(*) as totalFiltered FROM lib_admins";
    //         if (!empty($search)) {
    //             $filteredSql .= " WHERE adm_fname LIKE :search OR adm_lname LIKE :search OR adm_staff_id LIKE :search";
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

    function getAdminList($start, $length, $search, $orderColumn, $orderDir, $admId)
    {
        try {
            // เริ่มสร้าง SQL Query
            $sql = "SELECT adm_id, adm_profile, adm_fname, adm_lname, adm_staff_id, adm_super_admin 
                    FROM lib_admins WHERE adm_super_admin != 1 AND adm_id != :adm_id";

            // ตรวจสอบว่ามีการค้นหาหรือไม่
            if (!empty($search)) {
                $sql .= " AND (adm_fname LIKE :search OR adm_lname LIKE :search OR adm_staff_id LIKE :search)";
            }

            // เพิ่มเงื่อนไขการจัดเรียง
            $columns = ['adm_fname', 'adm_lname', 'adm_staff_id']; // คอลัมน์ที่จัดเรียงได้
            if (isset($columns[$orderColumn])) {
                $sql .= " ORDER BY " . $columns[$orderColumn] . " " . strtoupper($orderDir);
            }

            // เพิ่มเงื่อนไข limit
            $sql .= " LIMIT :start, :length";

            // เตรียม query
            $stmt = $this->conn->prepare($sql);

            // bind adm_id
            $stmt->bindParam(':adm_id', $admId, PDO::PARAM_INT);

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
            $totalSql = "SELECT COUNT(*) as total FROM lib_admins WHERE adm_super_admin != 1 AND adm_id != :adm_id";
            $totalStmt = $this->conn->prepare($totalSql);
            $totalStmt->bindParam(':adm_id', $admId, PDO::PARAM_INT);
            $totalStmt->execute();
            $totalCount = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];

            // นับจำนวนข้อมูลที่ค้นหาได้
            $filteredSql = "SELECT COUNT(*) as totalFiltered FROM lib_admins WHERE adm_super_admin != 1 AND adm_id != :adm_id";
            if (!empty($search)) {
                $filteredSql .= " AND (adm_fname LIKE :search OR adm_lname LIKE :search OR adm_staff_id LIKE :search)";
            }
            $filteredStmt = $this->conn->prepare($filteredSql);

            // bind adm_id
            $filteredStmt->bindParam(':adm_id', $admId, PDO::PARAM_INT);

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


    function checkAdminExists($admStaffId, $admId = NULL)
    {
        try {
            $sql = "SELECT COUNT(adm_id) as amount_admin
                    FROM lib_admins
                    WHERE adm_staff_id = :adm_staff_id ";

            if ($admId != NULL) {
                $sql .= " AND adm_id != :adm_id ";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':adm_staff_id', $admStaffId, PDO::PARAM_STR);

            if ($admId != NULL) {
                $stmt->bindParam(':adm_id', $admId, PDO::PARAM_INT);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['amount_admin'] > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function insertAdmin($admFname, $admLname, $admStaffId, $password, $admSuperAdmin)
    {
        try {

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO lib_admins (adm_fname, adm_lname, adm_staff_id, adm_password, adm_super_admin)
                    VALUES (:adm_fname, :adm_lname, :adm_staff_id, :adm_password, :adm_super_admin)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':adm_fname', $admFname, PDO::PARAM_STR);
            $stmt->bindParam(':adm_lname', $admLname, PDO::PARAM_STR);
            $stmt->bindParam(':adm_staff_id', $admStaffId, PDO::PARAM_STR);
            $stmt->bindParam(':adm_password', $passwordHash, PDO::PARAM_STR);
            $stmt->bindParam(':adm_super_admin', $admSuperAdmin, PDO::PARAM_INT);
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


    function updateAdmin($admId, $admFname, $admLname, $admStaffId, $profileImage)
    {
        try {
            $sql = "UPDATE lib_admins
                    SET adm_fname = :adm_fname,
                        adm_lname = :adm_lname,
                        adm_staff_id = :adm_staff_id,
                        adm_profile = :adm_profile
                    WHERE adm_id = :adm_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':adm_fname', $admFname, PDO::PARAM_STR);
            $stmt->bindParam(':adm_lname', $admLname, PDO::PARAM_STR);
            $stmt->bindParam(':adm_staff_id', $admStaffId, PDO::PARAM_STR);
            $stmt->bindParam(':adm_profile', $profileImage, PDO::PARAM_STR);
            $stmt->bindParam(':adm_id', $admId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function deleteAdmin($admId)
    {
        try {
            $sql = "DELETE FROM lib_admins 
                    WHERE adm_id = :adm_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':adm_id', $admId, PDO::PARAM_INT);
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

    function checkAdminLogin($admStaffId, $password)
    {
        try {
            $sql = "SELECT adm_id,adm_password
                    FROM lib_admins
                    WHERE adm_staff_id = :adm_staff_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':adm_staff_id', $admStaffId, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {

                if (password_verify($password, $result['adm_password'])) {
                    // รหัสผ่านถูกต้อง
                    return $result;
                } else {
                    // รหัสผ่านไม่ถูกต้อง
                    return false;
                }
            } else {
                // ไม่พบรหัสเจ้าหน้าที่
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "<hr>";
            return false;
        }
    }

    function getMyAccount($admId)
    {
        try {
            $sql = "SELECT adm_fname, adm_lname, adm_staff_id, adm_super_admin, adm_profile
                    FROM lib_admins
                    WHERE adm_id = :adm_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':adm_id', $admId, PDO::PARAM_INT);
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

    function checkAdminAccountPassword($admId, $admOldPassword)
    {
        try {
            $sql = "SELECT adm_password 
                    FROM lib_admins 
                    WHERE adm_id = :adm_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':adm_id', $admId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // ตรวจสอบว่าพบรหัสผ่านเก่าและเปรียบเทียบรหัสผ่าน
            if ($result && password_verify($admOldPassword, $result['adm_password'])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    function updateAdminPassword($admId, $admNewPassword)
    {
        try {
            $passwordHash = password_hash($admNewPassword, PASSWORD_DEFAULT);

            $sql = "UPDATE lib_admins 
                    SET adm_password = :adm_password 
                    WHERE adm_id = :adm_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':adm_password', $passwordHash, PDO::PARAM_STR);
            $stmt->bindParam(':adm_id', $admId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
