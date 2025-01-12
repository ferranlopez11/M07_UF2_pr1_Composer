<?php

namespace App\Controller;

require '../../vendor/autoload.php';

use App\View\ViewReparation;
use App\Service\ServiceReparation;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = new ControllerReparation();
if (isset($_GET["getReparation"])) {
    $controller->getReparation();
}

if (isset($_POST["insertReparation"])) {
    $controller->insertReparation();
}

class ControllerReparation {
    function getReparation() {
        $role = $_SESSION['optionRole'];
        $idReparation = $_POST['uuid'];
    
        $service = new ServiceReparation();
        $reparation = $service->getReparation($role, $idReparation);

    
        $view = new ViewReparation();
        $view->render($reparation);
    }
    
    function insertReparation() {
        $workshopId = $_POST["workshopId"];
        $workshopName = $_POST["workshopName"];
        $registerDate = $_POST["registerDate"];
        $licensePlate = $_POST["licensePlate"];
    
        $service = new ServiceReparation();
        $reparation = $service->insertReparation($workshopId, $workshopName, $registerDate, $licensePlate);
    
        $view = new ViewReparation();
        $view->render($reparation);
    }
}



/*session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = new ServiceReparation();

    if (isset($_POST['getReparation'])) {
        $idReparation = filter_var($_POST['uuid'], FILTER_SANITIZE_STRING);  // Sanitizar el ID de la reparación
        $reparation = $service->getReparationById($idReparation);

        if ($reparation) {
            echo "<h1>Reparación encontrada:</h1>";
            echo "<p>ID Reparación: " . htmlspecialchars($reparation->getIdReparation()) . "</p>";
            echo "<p>ID Taller: " . htmlspecialchars($reparation->getIdTaller()) . "</p>";
            echo "<p>Nombre Taller: " . htmlspecialchars($reparation->getNombreTaller()) . "</p>";
            echo "<p>Fecha Registro: " . htmlspecialchars($reparation->getFechaRegistro()) . "</p>";
            echo "<p>Matrícula: " . htmlspecialchars($reparation->getMatricula()) . "</p>";
            echo "<p>Foto Path: " . htmlspecialchars($reparation->getFotoPath()) . "</p>";
        } else {
            echo "<h1>No se encontró la reparación con el ID proporcionado.</h1>";
        }
    }

    if (isset($_POST['insertReparation'])) {
        // Validar y sanitizar datos
        $idTaller = filter_var($_POST['id_taller'], FILTER_SANITIZE_STRING);
        $nombreTaller = filter_var($_POST['nombre_taller'], FILTER_SANITIZE_STRING);
        $fechaRegistro = $_POST['fecha_registro'];
        $matricula = filter_var($_POST['matricula'], FILTER_SANITIZE_STRING);

        // Validación de archivo
        if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            echo "Error al subir la foto. Código de error: " . $_FILES['foto']['error'];
            exit;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['foto']['type'], $allowedTypes)) {
            echo "Error: Solo se permiten archivos de imagen (JPG, PNG, GIF).";
            exit;
        }

        $maxSize = 5 * 1024 * 1024; // 5 MB
        if ($_FILES['foto']['size'] > $maxSize) {
            echo "Error: El archivo es demasiado grande.";
            exit;
        }

        // Generar un ID único para la reparación
        $data = [
            'id_reparation' => uniqid(),
            'id_taller' => $idTaller,
            'nombre_taller' => $nombreTaller,
            'fecha_registro' => $fechaRegistro,
            'matricula' => $matricula,
            'foto_path' => 'uploads/' . $_FILES['foto']['name'], // Ruta de la imagen subida
        ];

        // Mover la foto al directorio deseado
        move_uploaded_file($_FILES['foto']['tmp_name'], '../uploads/' . $_FILES['foto']['name']);

        // Llamar al servicio para insertar la reparación
        if ($service->insertReparation($data)) {
            echo "<h1>Reparación registrada exitosamente.</h1>";
        } else {
            echo "<h1>Error al registrar la reparación.</h1>";
        }
    }
}*/