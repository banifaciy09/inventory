<?php
class DB{

    private $mysqli;

    public function __construct (){
        $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->mysqli->connect_errno){
            die("([DB __construct] Error " . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error);
        }else {
            //return $this->mysqli;
        }
    }

    //  запрос на количество строк (devices)
    public function devicesCount(){
        $stmt = $this->mysqli->stmt_init();
        $query = "SELECT COUNT(*) FROM devices";
        $stmt->prepare($query);
        if ($stmt->errno) {
            die("[devicesCount] (Error " . $stmt->errno . ") " . $stmt->error);
        }else{
            $stmt->execute();
            $stmt->bind_result($result);
            $stmt->fetch();
            $stmt->close();
            //echo "количество строк (devices): " . $result . "<br>";
            return $result;
        }
    }

    //  запрос на выборку (dept_name)
    public function getDepts() {
        $stmt = $this->mysqli->stmt_init();
        $query = "SELECT * FROM `departments`";
        $stmt->prepare($query);
        if ($stmt->errno) {
            die("[getDepts] (Error " . $stmt->errno . ") " . $stmt->error);
        } else {
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;
        }
    }

    //  запрос на выборку (type_name)
    public function getTypes() {
        $stmt = $this->mysqli->stmt_init();
        $query = "SELECT * FROM `types`";
        $stmt->prepare($query);
        if ($stmt->errno) {
            die("[getTypes] (Error " . $stmt->errno . ") " . $stmt->error);
        } else {
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;
        }
    }

    public function getStaff() {
        $stmt = $this->mysqli->stmt_init();
        $query = "SELECT * FROM `staff`";
        $stmt->prepare($query);
        if ($stmt->errno) {
            die("[getTypes] (Error " . $stmt->errno . ") " . $stmt->error);
        } else {
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;
        }
    }

    public function devicesData($start, $count, $isEmptyDevices = false){
        $stmt = $this->mysqli->stmt_init();
        $sqlAdd = "";
        if ($isEmptyDevices) $sqlAdd .= "WHERE d.personnel_num IS NULL";
        $query = "
            SELECT `d`.`inventory_num`, `d`.`device_name`, `d`.`room`, `d`.`ip_adress`, `d`.`cartrige`, `d`.`registration_date`, 
            `s`.`surname`, `s`.`name`, `s`.`patronymic`, `s`.`post`, `s`.`personnel_num`, `t`.`type_name`, `dp`.`dept_name`
            FROM `devices` `d` 
                LEFT JOIN `staff` `s`
                ON `d`.`personnel_num`=`s`.`personnel_num`
                INNER JOIN `types` `t`
                ON `d`.`id_type`=`t`.`id_type`
                LEFT JOIN `departments` `dp`
                ON `s`.`id_dept`=`dp`.`id_dept`
            ".$sqlAdd."
            ORDER BY `d`.`inventory_num` LIMIT ?, ?";
        $stmt->prepare($query);
        if ($stmt->errno) {
            die("[devicesData] (Error " . $stmt->errno . ") " . $stmt->error);
        }else{
            $stmt->bind_param("ii", $start, $count);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            //echo "массив строк (devices): " . var_dump($result) . "<br>";
            return $result;
        }
    }

    public function setStaff($post){
        $stmt = $this->mysqli->stmt_init();

        $query = "
            INSERT INTO `staff`
                (`personnel_num`, `surname`, `name`, `patronymic`, `post`, `id_dept`)
            VALUES
                (?, ?, ?, ?, ?, ?)
        ";
        $stmt->prepare($query);
        $stmt->bind_param("issssi", $post["personnel_num"], $post["surname"], $post["name"], $post["patronymic"], $post["post"], $post["dept"]);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function setDevice($post){
        $stmt = $this->mysqli->stmt_init();

        $query = "
            INSERT INTO `devices`
                (`inventory_num`, `device_name`, `room`, `ip_adress`, `cartrige`, `registration_date`, `id_type`)
            VALUES
                (?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt->prepare($query);
        $stmt->bind_param("isisssi", $post["inventory_num"], $post["device_name"], $post["room"], $post["ip_adress"], $post["cartrige"], $post["date"], $post["type"]);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function getStaffInfo($id) {
        $stmt = $this->mysqli->stmt_init();
        $query = "SELECT * FROM `staff` WHERE `personnel_num` = ?";
        $stmt->prepare($query);
        if ($stmt->errno) {
            die("[getStaffInfo] (Error " . $stmt->errno . ") " . $stmt->error);
        } else {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;
        }
    }

    public function getDeviceInfo($id) {
        $stmt = $this->mysqli->stmt_init();
        $query = "SELECT * FROM `devices` WHERE `inventory_num` = ?";
        $stmt->prepare($query);
        if ($stmt->errno) {
            die("[getDeviceInfo] (Error " . $stmt->errno . ") " . $stmt->error);
        } else {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;
        }
    }

    public function updateStaff($post) {
        $stmt = $this->mysqli->stmt_init();

        $query = "
            UPDATE `staff` 
                SET `personnel_num` = ?,
                `surname` = ?,
                `name` = ?,
                `patronymic` = ?,
                `post` = ?,
                `id_dept` = ?
            WHERE `personnel_num` = ?    
        ";
        $stmt->prepare($query);
        $stmt->bind_param("issssii", $post["personnel_num"], $post["surname"], $post["name"], $post["patronymic"], $post["post"], $post["dept"], $post["personnel_num"]);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function updateDevice($post) {
        $stmt = $this->mysqli->stmt_init();

        $query = "
            UPDATE `devices` 
                SET `inventory_num` = ?,
                `device_name` = ?,
                `room` = ?,
                `ip_adress` = ?,
                `cartrige` = ?,
                `registration_date` = ?,
                `personnel_num` = ?,
                `id_type` = ?  
            WHERE `inventory_num` = ?
        ";
        $stmt->prepare($query);
        $stmt->bind_param("isssssiii", $post["inventory_num"], $post["device_name"], $post["room"], $post["ip_adress"], $post["cartrige"], $post["date"], $post["personnel_num"], $post["type"], $post["inventory_num"]);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function deleteDevice($post) {
        $stmt = $this->mysqli->stmt_init();

        $query = "
            DELETE FROM `devices` 
            WHERE `inventory_num` = ?
        ";
        $stmt->prepare($query);
        $stmt->bind_param("i", $post["inventory_num"]);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function loginUser($post) {
        $stmt = $this->mysqli->stmt_init();

        $query = "
            SELECT `id_admin` 
                FROM `access` 
            WHERE `login` = ? 
                AND `pass` = ?
        ";
        $stmt->prepare($query);
        $stmt->bind_param("ss", $post["login"], $post["pass"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if ($result[0]["id_admin"]) return $result[0]["id_admin"];
        return false;
    }
}

