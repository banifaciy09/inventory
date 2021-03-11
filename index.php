<?php
require_once ("config.php");
require_once ("class\View.php");
require_once ("class\Model.php");
//require_once ("class\Page.php");

function autoload() {

    $view = new View();
    $model = new Model();

    if (empty($_SESSION["id_admin"])) {
        switch ($_REQUEST["action"]) {
            case "login_user":
                return $model->loginUser();
                break;
        }
        return $view->login();
    }

    switch ($_REQUEST["action"]) {
        case "add_staff":
            return $view->addStaff();
            break;
        case "add_device":
            return $view->addDevice();
            break;
        case "edit_staff":
            return $view->editStaff($_REQUEST["id"]);
            break;
        case "edit_device":
            return $view->editDevice($_REQUEST["id"]);
            break;
        case "save_staff":
            return $model->saveStaff();
            break;
        case "save_device":
            return $model->saveDevice();
            break;
        case "update_staff":
            return $model->updateStaff();
            break;
        case "update_device":
            return $model->updateDevice();
            break;
        case "delete_device":
            return $model->deleteDevice();
            break;
        case "exit":
            session_destroy();
            echo header("Location: index.php");
            break;
        case "general_page":
            echo header("Location: index.php");
            break;
    }

    $isEmptyDevices = $_GET["empty_devices"];

    $view->contentPage($isEmptyDevices);
//  $page->actionProcessing($_GET);
}

autoload();
?>


