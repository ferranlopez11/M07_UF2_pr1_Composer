<?php

namespace App\View;

//require '../../vendor/autoload.php';

use App\Model\Reparation;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViewReparation</title>
</head>
<body>
    <h2>Car Workshop: Menú de reparación</h2>
    <form action="../Controller/ControllerReparation.php" method="POST">
        <label for="idReparation">ID de reparación:</label>
        <input type="text" id="idReparation" name="idReparation">
    
        <input type="submit" value="Buscar" name="getReparation">
    </form>

    <?php
    class ViewReparation {

        function render(Reparation | null $result) {
            if ($result != null) {
                echo "<h2>Detalles de la reparación</h2>";
                echo "<ul>
                <li>ID de reparación: " . $result->getIdReparation() . "</li>
                <li>ID de la Workshop: " . $result->getIdWorkshop() . "</li>
                <li>Nombre del taller: " . $result->getNameWorkshop() . "</li>
                <li>Fecha de registro: " . $result->getRegisterDate() . "</li>
                <li>Matricula: " . $result->getLicenseVehicle() . "</li>
                </ul><br>";
                echo '<img src="data:image/png;base64,' . $result->getPhotoVehicle() . '" alt="Vehicle Image">';
            } else {
                echo "<h1>Reparación no encontrada</h1>";
            }
        }
    }

    ?>
    
    <?php
    session_start();
    $_SESSION["role"] = $_GET["role"] ?? $_SESSION["role"] ?? null;
        if($_SESSION["role"] == "employee") {
        ?>
        <h2>Registrar reparación de coche:</h2>
        <form action="../Controller/ControllerReparation.php" method="POST" name="formSearchReparation" enctype="multipart/form-data">
                
        <label for="idWorkshop">ID del Taller:</label>
        <input type="text" id="idWorkshop" name="idWorkshop" maxlength="4" required><br><br>

        <label for="nameWorkshop">Nombre del Taller:</label>
        <input type="text" id="nameWorkshop" name="nameWorkshop" maxlength="12" required><br><br>

        <label for="registerDate">Fecha de Registro:</label>
        <input type="text" id="registerDate" name="registerDate" placeholder="yyyy-mm-dd" pattern="\d{4}-\d{2}-\d{2}" required><br><br>

        <label for="licenseVehicle">Matrícula del Vehículo:</label>
        <input type="text" id="licenseVehicle" name="licenseVehicle" placeholder="9999-XXX" pattern="\d{4}-[A-Za-z]{3}" required><br><br>

        <label for="photoVehicle">Foto del Vehículo:</label>
        <input type="file" id="photoVehicle" name="photoVehicle" accept="image/*" required><br><br>

        <input type="submit" value="Crear" name="insertReparation">
    </form>
    <?php
        }
    ?>

</body>
</html>