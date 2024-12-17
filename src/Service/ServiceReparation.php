<?php

namespace App\Service;

use App\Model\Reparation;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Intervention\Image\ImageManagerStatic as Image;
use Ramsey\Uuid\Uuid;

class ServiceReparation {
    private $db;
    private $logger;
}