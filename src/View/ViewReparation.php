<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['optionRole'])) {
    $role = $_POST['optionRole'];
} else {
    $role = 'client';
}
?>

<html>
<body>
    <h1>Car Workshop: Menú de reparación</h1>
    
    <?php if ($role === 'employee'): ?>
        <h2>Registrar reparación de coche:</h2>
        <form method="POST" action="../Controller/ControllerReparation.php" enctype="multipart/form-data">
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
        
    <?php else: ?>
        <h2>Buscar reparación de coche</h2>
        <form method="POST" action="../Controller/ControllerReparation.php" name="formSearchReparation">
            <label for="uuid">ID de reparación: </label>
            <input type="text" id="uuid" name="uuid" required><br><br>
            <input type="submit" value="Buscar" name="getReparation">
        </form>

    <?php endif; ?>

</body>
</html>