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
        <li>ID de la Workshop: </li>
        <li></li>
        <li></li>
        <li></li>
        </ul>
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
        <label for="id_taller">ID del Taller:</label>
        <input type="text" id="id_taller" name="id_taller" maxlength="4" required><br><br>

        <label for="nombre_taller">Nombre del Taller:</label>
        <input type="text" id="nombre_taller" name="nombre_taller" maxlength="12" required><br><br>

        <label for="fecha_registro">Fecha de Registro:</label>
        <input type="date" id="fecha_registro" name="fecha_registro" required><br><br>

        <label for="matricula">Matrícula del Vehículo:</label>
        <input type="text" id="matricula" name="matricula" placeholder="9999-XXX" required><br><br>

        <label for="foto">Foto del Vehículo:</label>
        <input type="file" id="foto" name="foto" accept="image/*" required><br><br>

        <input type="submit" value="Registrar" name="insertReparation">
    </form>
    <?php
    } ?>
</body>
</html>
*/