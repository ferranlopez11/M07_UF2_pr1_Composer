<?php
namespace App\View;

require '../../vendor/autoload.php';

use App\Config\Roles;
use App\Model\Reparation;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $_SESSION['optionRole'] = $_POST['optionRole'];
}

class ViewReparation {
    public Reparation $reparation;

    public function render($reparation) {
        $this->reparation = $reparation;

        echo '
        <html>
        <body>
        <h1>Detalles de la reparación</h1>
        <br>
        <ul>
        <li>ID de reparación: ' . $reparation->getIdReparation() . '</li>
        <li>ID de la Workshop: ' . $reparation->getIdWorkshop() . '</li>
        <li>Nombre del taller: ' . $reparation->getNameWorkshop() . '</li>
        <li>Fecha de registro: ' . $reparation->getRegisterDate() . '</li>
        <li>Matricula: ' . $reparation->getLicensePlate() . '</li>
        </ul>
        <br>
        <img src="data:image/png;base64,' . base64_encode($reparation->getPhotoVehicle()) . '" alt="Image" />
        </body>
        </html>
        ';
    }

}
?>

<html>
<body>
    <h1>Car Workshop: Menú de reparación</h1>

    <form method="GET" action="../Controller/ControllerReparation.php" name="formSearchReparation">
        <h2>Buscar reparación de coche</h2>
        
        <label for="uuid">ID de reparación: </label>
        <input type="text" id="uuid" name="uuid" required><br><br>
        <input type="submit" value="Buscar" name="getReparation">
    </form>
    <?php
    
    if (isset($_POST["optionRole"]) && $_POST["optionRole"] == Roles::ROLE_EMPLOYEE) {?>
    <form method="POST" action="../Controller/ControllerReparation.php" name="formSearchReparation" enctype="multipart/form-data">
        <h2>Registrar reparación de coche:</h2>
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
    } ?>
</body>
</html>