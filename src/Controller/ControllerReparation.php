<?php

namespace App\Controller;

use App\Service\ServiceReparation;



    require '../../vendor/autoload.php';

    function getReparation(): void
    {
        $role = $_SESSION['optionRole'];
        $idReparation = $_POST['uuid'];

        
    }