<?php
require_once ("Model.php");
require_once ("DB.php");
class View{

    private $mysql;
    private $model;

    public function __construct(){
        $this->mysql = new DB();
        $this->model = new Model();
    }

    private function pageHeaderStart(){
        echo "
            <!DOCTYPE html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <title>Инвентаризация</title>
                <link rel=\"stylesheet\" href=\"style.css\">
                <script src=\"https://code.jquery.com/jquery-3.6.0.min.js\" integrity=\"sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=\" crossorigin=\"anonymous\"></script>
            </head>
            <body>       
            <div class='title'>
                УЧЕТ ОСНОВНЫХ СРЕДСТВ НОВОПОЛОЦКОГО ФИЛИАЛА УП \"ИНСТИТУТ ВИТЕБСКГРАЖДАНРОЕКТ\" 
            </div>
            <div class='wrap'> 
        ";
    }

    private function pageHeaderEnd(){
            echo "</div><script src=\"scripts.js\"></script></body></html>";
    }

    private function navigation ($page, $pages){
        ?><div class="general"><?
        for ($i = 1; $i <= $pages; $i++) {
            if ($i == $page) {
                echo "<div class='nav nav_active'>".$i."</div>";
            } else {
                echo "
                <div class='nav' onclick='location.href=\"".$_SERVER["SCRIPT_NAME"]."?page=".$i."\"'>".$i."</div>";
            }
        }
        ?></div><?
    }

    // вывод главной таблицы на страницу
    public function contentPage($isEmptyDevices){
        $this->pageHeaderStart();

        $start = $this->model->startRange();
        $count = dataPerPage;
        $content = $this->mysql->devicesData($start, $count, $isEmptyDevices);
        echo "
        <label for='empty_device'>
            <input type='checkbox' id='empty_device' onclick='location.href=\"?empty_devices=".($isEmptyDevices ? 0 : 1)."\"' ".($isEmptyDevices ? "checked" : "").">Показать свободные устройства
        </label>
        <div class='tab'>    
            <table>
                <tr>
                    <th>Инв.№</th>
                    <th>Название</th>
                    <th>Тип</th>
                    <th>ip адрес</th>
                    <th>Фамилия</th>
                    <th>Имя</th>
                    <th>Отчество</th>
                    <th>Должность</th>
                    <th>Отдел</th>
                    <th>Кабинет</th>
                    <th>Дата регистрации</th>
                    <th>Картридж</th>
                </tr>";
        foreach ($content as $row) {
            echo "
                    <tr>
                        <td class='td1'>" . $row["inventory_num"] . "</td>
                        <td class='td2'><a href='?action=edit_device&id=" . urlencode($row["inventory_num"]) . "'>" . $row["device_name"] . "</a></td>
                        <td class='td3'>" . $row["type_name"] . "</td>
                        <td class='td4'>" . $row["ip_adress"] . "</td>
                        <td class='td5'><a href='?action=edit_staff&id=" . urlencode($row["personnel_num"]) . "'>" . $row["surname"] . "</a></td>
                        <td class='td6'>" . $row["name"] . "</td>
                        <td class='td7'>" . $row["patronymic"] . "</td>
                        <td class='td8'>" . $row["post"] . "</td>
                        <td class='td9'>" . $row["dept_name"] . "</td>
                        <td class='td10'>" . $row["room"] . "</td>
                        <td class='td11'>" . $row["registration_date"] . "</td>
                        <td class='td12'>" . $row["cartrige"] . "</td>
                    </tr>";
        }
        echo "
            </table>
        </div>";

        echo "
        <div class='add_button'>
            <button class='gbtn-success' onclick='location.href=\"?action=add_staff\"'>
                Добавить пользователя
            </button>
            <button class='gbtn-success' onclick='location.href=\"?action=add_device\"'>
                Добавить устройство
            </button>
            <button class='gbtn-success gbtn-exit' onclick='location.href=\"?action=exit\"'>
                Выход
            </button>
        </div>
        ";
        //button_fix
        $this->navigation ($this->model->currPage(), $this->model->countPages());

        // закрыл pageHeader
        $this->pageHeaderEnd();
    }

    // вывод страницы добавления пользователя
    public function addStaff() {
        $this->pageHeaderStart();

        echo '
         <div id="error-body"></div>
         <form class="form" role="form" id="formAddUser" novalidate="" method="POST">
            <input type="text" name="action" id="action" value="save_staff" hidden>
            <div class="form-group text-left">
                <label for="personnel_num">Табельный номер:</label>
                <input type="number" class="form-control" name="personnel_num" id="personnel_num" required>
            </div>	
            <div class="form-group text-left">
                <label for="surname">Фамилия:</label>
                <input type="text" class="form-control" name="surname" id="surname" required>
            </div>
            <div class="form-group text-left">
                <label for="name">Имя:</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group text-left">
                <label for="patronymic">Отчество:</label>
                <input type="text" class="form-control" name="patronymic" id="patronymic" required>
            </div>
            <div class="form-group text-left">
                <label for="post">Должность:</label>
                <input type="text" class="form-control" name="post" id="post" required>
            </div>	
            <div class="form-group text-left">
                <label for="dept">Отдел:</label>
                <select name="dept" id="dept"  class="form-control select" required>';
                $depts = $this->mysql->getDepts();
                foreach($depts as $row) {
                    echo "<option value='".$row["id_dept"]."'>".$row["dept_name"]."</option>>";
                }
        echo '
                </select>
            </div>		
            <button type="submit" class="btn-success" id="btnAddUser">Добавить</button>
        </form>
        <button class="backbtn-success" onclick=\'location.href="?action=general_page"\'>Главная</button>
        ';

        // закрыл pageHeader
        $this->pageHeaderEnd();
    }

    // вывод страницы добавления устройства
    public function addDevice() {
        $this->pageHeaderStart();

        echo '
         <div id="error-body"></div>
         <form class="form" role="form" id="formAddDev" novalidate="" method="POST">
            <input type="text" name="action" id="action" value="save_device" hidden>
            <div class="form-group text-left">
                <label for="inventory_num">Инвентарный номер:</label>
                <input type="number" class="form-control" name="inventory_num" id="inventory_num" required>
            </div>	
            <div class="form-group text-left">
                <label for="device_name">Название устройства:</label>
                <input type="text" class="form-control" name="device_name" id="device_name" required>
            </div>
            <div class="form-group text-left">
                <label for="room">Комната:</label>
                <input type="text" class="form-control" name="room" id="room" required>
            </div>
            <div class="form-group text-left">
                <label for="ip_adress">ip-адресс:</label>
                <input type="text" class="form-control" name="ip_adress" id="ip_adress">
            </div>
            <div class="form-group text-left">
                <label for="cartrige">Картридж:</label>
                <input type="text" class="form-control" name="cartrige" id="cartrige">
            </div>	
            <div class="form-group text-left">
                <label for="date">Дата регистрации:</label>
                <input type="date" class="form-control" name="date" id="date" required>
            </div>	
            <div class="form-group text-left">
                <label for="type">Тип устройства:</label>
                <select name="type" id="type"  class="form-control select" required>';
        $types = $this->mysql->getTypes();
        foreach($types as $row) {
            echo "<option value='".$row["id_type"]."'>".$row["type_name"]."</option>>";
        }
        echo '
                </select>
            </div>		
            <button type="submit" class="btn-success" id="btnAddDev">Добавить</button>
        </form>
        <button class="backbtn-success" onclick=\'location.href="?action=general_page"\'>Главная</button>
        ';

        // закрыл pageHeader
        $this->pageHeaderEnd();
    }

    public function editStaff($id) {
        $this->pageHeaderStart();

        if (!$id) {
            echo "Пользователь не найден";
            return;
        }
        $info = $this->mysql->getStaffInfo($id)[0];

        echo '
         <div id="error-body"></div>
         <form class="form" role="form" id="formAddUser" novalidate="" method="POST">
            <input type="text" name="action" id="action" value="update_staff" hidden>
            <div class="form-group text-left">
                <label for="personnel_num">Персональный номер:</label>
                <input type="number" class="form-control" name="personnel_num" id="personnel_num" value="'.htmlspecialchars($info["personnel_num"]).'" required readonly>
            </div>  
            <div class="form-group text-left">
                <label for="surname">Фамилия:</label>
                <input type="text" class="form-control" name="surname" id="surname" value="'.htmlspecialchars($info["surname"]).'" required>
            </div>
            <div class="form-group text-left">
                <label for="name">Имя:</label>
                <input type="text" class="form-control" name="name" id="name" value="'.htmlspecialchars($info["name"]).'" required>
            </div>
            <div class="form-group text-left">
                <label for="patronymic">Отчество:</label>
                <input type="text" class="form-control" name="patronymic" id="patronymic" value="'.htmlspecialchars($info["patronymic"]).'" required>
            </div>
            <div class="form-group text-left">
                <label for="post">Должность:</label>
                <input type="text" class="form-control" name="post" id="post" value="'.htmlspecialchars($info["post"]).'" required>
            </div>  
            <div class="form-group text-left">
                <label for="dept">Отдел:</label>
                <select name="dept" id="dept"  class="form-control select" required>';
            $depts = $this->mysql->getDepts();
            foreach($depts as $row) {
                echo "<option value='".$row["id_dept"]."' ";
                if ($row["id_dept"] == $info["id_dept"]) echo "selected";
                echo ">".$row["dept_name"]."</option>>";
            }
        echo '
                </select>
                <div class="invalid-feedback">Введите отдел</div>
            </div>    
            <button type="submit" class="btn" id="btnAddUser">Обновить</button>
        </form>
        <button class="backbtn-success" onclick=\'location.href="?action=general_page"\'>Главная</button>
        ';

        // закрыл pageHeader
        $this->pageHeaderEnd();
    }

    public function editDevice($id) {
        $this->pageHeaderStart();

        if (!$id) {
            echo "Устройство не найдено";
            return;
        }
        $info = $this->mysql->getDeviceInfo($id)[0];

        echo '
         <div id="error-body"></div>
         <form class="form" role="form" id="formAddDev" novalidate="" method="POST">
            <input type="text" name="action" id="action" value="update_device" hidden>
            <div class="form-group text-left">
                <label for="inventory_num">Инвентарный номер:</label>
                <input type="number" class="form-control" name="inventory_num" id="inventory_num" value="'.htmlspecialchars($info["inventory_num"]).'" required readonly>
            </div>	
            <div class="form-group text-left">
                <label for="device_name">Название устройства:</label>
                <input type="text" class="form-control" name="device_name" id="device_name" value="'.htmlspecialchars($info["device_name"]).'" required>
            </div>
            <div class="form-group text-left">
                <label for="room">Комната:</label>
                <input type="text" class="form-control" name="room" id="room" value="'.htmlspecialchars($info["room"]).'" required>
            </div>
            <div class="form-group text-left">
                <label for="ip_adress">ip-адресс:</label>
                <input type="text" class="form-control" name="ip_adress" id="ip_adress" value="'.htmlspecialchars($info["ip_adress"]).'">
            </div>
            <div class="form-group text-left">
                <label for="cartrige">Картридж:</label>
                <input type="text" class="form-control" name="cartrige" id="cartrige" value="'.htmlspecialchars($info["cartrige"]).'">
            </div>	
            <div class="form-group text-left">
                <label for="date">Дата регистрации:</label>
                <input type="date" class="form-control" name="date" id="date" value="'.htmlspecialchars($info["registration_date"]).'" required>
            </div>	
            <div class="form-group text-left">
                <label for="type">Тип устройства:</label>
                <select name="type" id="type"  class="form-control select" required>';
            $types = $this->mysql->getTypes();
            foreach($types as $row) {
                echo "<option value='".$row["id_type"]."' ";
                if ($row["id_type"] == $info["id_type"]) echo "selected";
                echo ">".$row["type_name"]."</option>>";
            }
            echo '
                </select>
            </div>   
            <div class="form-group text-left">
                <label for="personnel_num">Пользователь:</label> 
                <select name="personnel_num" id="personnel_num"  class="form-control select">
                    <option value="null"></option>
            ';
            $staff = $this->mysql->getStaff();
            foreach($staff as $row) {
                echo "<option value='".$row["personnel_num"]."' ";
                if ($row["personnel_num"] == $info["personnel_num"]) echo "selected";
                echo ">".$row["surname"]." ".$row["name"]." ".$row["patronymic"]."</option>>";
            }
        echo '
                </select>
            </div>		
            <button type="submit" class="btn-success" id="btnAddDev">Обновить</button>
            <button type="submit" class="btn-success" id="btnDelDev">Удалить</button>
        </form>
        <button class="backbtn-success" onclick=\'location.href="?action=general_page"\'>Главная</button>
        ';

        // закрыл pageHeader
        $this->pageHeaderEnd();
    }

    public function login() {
        $this->pageHeaderStart();

        echo '
         <div id="error-body"></div>
         <form class="form" role="form" id="formLoginUser" novalidate="" method="POST">
            <input type="text" name="action" id="action" value="login_user" hidden>
            <div class="form-group text-left">
                <label for="login">Логин:</label>
                <input type="text" class="form-control" name="login" id="login" required>
            </div>	
            <div class="form-group text-left">
                <label for="pass">Пароль:</label>
                <input type="password" class="form-control" name="pass" id="pass" required>
            </div>
            <button type="submit" class="btn-success" id="btnLogin">Войти</button>
         </form>
         ';

        // закрыл pageHeader
        $this->pageHeaderEnd();
    }
}