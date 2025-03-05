<html>
<body>
    <h1>Car Workshop: Menú Principal</h1>
    <h2>Escoge un rol:</h2>
    <form action="../src/View/ViewReparation.php" method="GET">
        <select name="optionRole">
            <option value="client">Cliente</option>
            <option value="employee" selected>Empleado</option>
        </select>
        <br><br>
        <input type="submit" value="Entrar">
    </form>
</body>
</html>