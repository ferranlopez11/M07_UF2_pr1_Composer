<?php

namespace App\Controller;

require_once __DIR__. '/../../vendor/autoload.php';

use App\Model\Reparation;
use App\View\ViewReparation;
use App\Service\ServiceReparation;
use Intervention\Image\ImageManager;

require_once __DIR__ . '/../Service/ServiceReparation.php';
require_once __DIR__ . '/../Model/Reparation.php';
require_once __DIR__ . '/../View/ViewReparation.php';

$controller = new ControllerReparation();


if (isset($_POST["insertReparation"])) {
    $controller->insertReparation();
} elseif (isset($_POST["getReparation"])) {
    $controller->getReparation();
}

class ControllerReparation {
    
    function insertReparation() {
        if($_SESSION["role"] === "employee") {
            if (isset($_POST["idWorkshop"]) && isset($_POST["nameWorkshop"]) && isset($_POST["registerDate"]) && isset($_POST["licenseVehicle"]) && isset($_FILES['photoVehicle']) ) {
                $idWorkshop = $_POST["idWorkshop"];
                $nameWorkshop = $_POST["nameWorkshop"];
                $registerDate = $_POST["registerDate"];
                $licenseVehicle = $_POST["licenseVehicle"];
                $image = $_FILES['photoVehicle']['tmp_name'];
                $photoVehicle = base64_encode(file_get_contents($image));
            
                $reparation = new Reparation(null, $idWorkshop, $nameWorkshop, $registerDate, $licenseVehicle, $photoVehicle);

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

    function getReparation() {
        $idReparation = $_POST['idReparation'];
        $role = $_SESSION['role'];
        $service = new ServiceReparation();
        $result = $service->getReparation($role, $idReparation);
        $view = new ViewReparation();
        $view->render($result);
    }
}