<?php

namespace App\Model;

class Reparation {
    private $idReparacion;
    private $idTaller;
    private $nombreTaller;
    private $fechaRegistro;
    private $matricula;
    private $fotoPath;

    public function __construct($idReparacion, $idTaller, $nombreTaller, $fechaRegistro, $matricula, $fotoPath) {
        $this->idReparacion = $idReparacion;
        $this->idTaller = $idTaller;
        $this->nombreTaller = $nombreTaller;
        $this->fechaRegistro = $fechaRegistro;
        $this->matricula = $matricula;
        $this->fotoPath = $fotoPath;
    }

    public function getIdReparacion() 
    { 
        return $this->idReparacion; 
    }
    public function setIdReparacion($idReparacion) 
    { 
        $this->idReparacion = $idReparacion;
        return $this; 
    }
    
    public function getIdTaller() 
    { 
        return $this->idTaller; 
    }

    public function getNombreTaller() 
    { 
        return $this->nombreTaller; 
    }

    public function getFechaRegistro() 
    { 
        return $this->fechaRegistro; 
    }

    public function getMatricula() 
    { 
        return $this->matricula; 
    }
    public function setMatricula($matricula) 
    { 
        $this->matricula = $matricula; 
        return $this;
    }

    public function getFotoPath() 
    { 
        return $this->fotoPath; 
    }
    public function setFotoPath($fotoPath) 
    { 
        $this->fotoPath = $fotoPath; 
        return $this;
    }
}