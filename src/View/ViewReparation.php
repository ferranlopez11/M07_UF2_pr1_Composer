<?php
namespace App\View;

//require '../../vendor/autoload.php';

use App\Config\Roles;
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
                echo "<h2>Detalles de la reparación</h2><br>";
                echo "<ul>
                <li>ID de reparación: " . $result->getIdReparacion() . "</li>
                <li>ID de la Workshop: " . $result->getIdTaller() . "</li>
                <li>Nombre del taller: " . $result->getNombreTaller() . "</li>
                <li>Fecha de registro: " . $result->getFechaRegistro() . "</li>
                <li>Matricula: " . $result->getMatricula() . "</li>
                </ul><br>";
                echo '<img src="data:image/png;base64,' . $result->getFotoPath() . '" alt="Vehicle Image">';
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
                
        <label for="workshopId">ID del Taller:</label>
        <input type="text" id="workshopId" name="workshopId" maxlength="4" required><br><br>

        <label for="workshopName">Nombre del Taller:</label>
        <input type="text" id="workshopName" name="workshopName" maxlength="12" required><br><br>

        <label for="registerDate">Fecha de Registro:</label>
        <input type="text" id="registerDate" name="registerDate" placeholder="yyyy-mm-dd" pattern="\d{4}-\d{2}-\d{2}" required><br><br>

        <label for="licensePlate">Matrícula del Vehículo:</label>
        <input type="text" id="licensePlate" name="licensePlate" placeholder="9999-XXX" pattern="\d{4}-[A-Za-z]{3}" required><br><br>

        <label for="photo">Foto del Vehículo:</label>
        <input type="file" id="photo" name="photo" accept="image/*" required><br><br>

        <input type="submit" value="create" name="insertReparation">
    </form>
    <?php
        }
    ?>

</body>
</html>