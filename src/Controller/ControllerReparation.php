<?php
    namespace App\Controller;

    require '../../vendor/autoload.php';

    function getReparation(): void
    {
        $role = $_SESSION['optionRole'];
        $idReparation = $_POST['uuid'];

        $service = new ServiceReparation();
        $reparation = $service->getReparation($role, $idReparation);

        $view = new ViewReparation();
        $view->render($reparation);
    }