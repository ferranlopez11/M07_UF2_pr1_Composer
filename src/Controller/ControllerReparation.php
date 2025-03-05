<?php

namespace App\Controller;

require_once __DIR__. '../../vendor/autoload.php';

use App\View\ViewReparation;
use App\Service\ServiceReparation;


$controller = new ControllerReparation();


if (isset($$_POST["getReparation"])) {
    $controller->getReparation();
} else if (isset($_POST["insertReparation"])) {
    $controller->insertReparation();
}

class ControllerReparation {
    function getReparation() {
        $idReparation = $_POST['idReparation'];
        $role = $_SESSION['optionRole'];
        $service = new ServiceReparation();
        $reparation = $service->getReparation($role, $idReparation);
        $view = new ViewReparation();
        $view->render($reparation);
    }
    
    function insertReparation() {
        if($_SESSION["role"] = "employee") {
            if (isset($_POST["workshopId"]) && isset($_POST["workshopName"]) && isset($_POST["registerDate"]) && isset($_POST["licensePlate"])) {
                $workshopId = $_POST["workshopId"];
                $workshopName = $_POST["workshopName"];
                $registerDate = $_POST["registerDate"];
                $licensePlate = $_POST["licensePlate"];
            
                $reparation = new Reparation($workshopId, $workshopName, $registerDate, $licensePlate);

                $service = new ServiceReparation();
                $reparationInserted = $service->insertReparation($reparation);

                if ($reparationInserted) {
                    $view = new ViewReparation();
                    $view->render($reparationInserted);
                } else {
                    echo "Error al insertar la reparación";
                }
            }
        } else {
            echo "No tienes permisos para insertar una reparación";
        }
    }
}