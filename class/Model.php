<?php
require_once ("DB.php");

class Model{

    private $mysql;
    private $currPage;

    //  public $dataPerPage = 4; указал в конфиге

    public function __construct(){
        $this->mysql = new DB();
    }

    //  количество страниц
    public function countPages(){
        $countPages = $this->mysql->devicesCount();
        $result = ceil($countPages / dataPerPage);
        return $result;
    }

    //  текущая страница
    public function currPage(){
        $this->currPage = intval($_GET['page'] ?? 1);
        if ($this->currPage < 1 || $this->currPage > $this->countPages()) {
            echo "$this->currPage";
            die("Запрошенная Вами страница не найдена");
            //  страница 404
        }
        return $this->currPage;
    }

    //  начальная позиция диапазона выборки
    public function startRange(){
        $start = ($this->currPage() - 1) * dataPerPage;
        return $start;
    }

    public function responseToAjax($result = false, $message = "Ошибка добавления") {
        $response = array("result" => $result, "response" => $message);
        echo json_encode($response);
    }

    public function saveStaff() {
        $request = $_POST;
        $this->mysql->setStaff($request);
        return $this->responseToAjax(true, "Пользователь успешно добавлен");
    }

    public function saveDevice() {
        $request = $_POST;

        $this->mysql->setDevice($request);

        return $this->responseToAjax(true, "Устройство успешно добавлено");
    }

    public function updateStaff() {
        $request = $_POST;
        $this->mysql->updateStaff($request);
        return $this->responseToAjax(true, "Пользователь успешно обновлен");
    }

    public function updateDevice() {
        $request = $_POST;
        $this->mysql->updateDevice($request);
        return $this->responseToAjax(true, "Устройство успешно обновлено");

    }

    public function deleteDevice() {
        $request = $_POST;
        $this->mysql->deleteDevice($request);
        return $this->responseToAjax(true, "Устройство успешно удалено");
    }

    public function loginUser() {
        $request = $_POST;
        $idAdmin = $this->mysql->loginUser($request);

        if ($idAdmin) {
            $_SESSION["id_admin"] = $idAdmin;
            return $this->responseToAjax(true, "Пользователь успешно авторизован");
        }
        return $this->responseToAjax(false, "Логин или пароль неверный");
    }
}
