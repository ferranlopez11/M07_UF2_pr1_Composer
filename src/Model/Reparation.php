<?php

namespace App\Model;

class Reparation {
    private $idReparation;
    private $idWorkshop;
    private $nameWorkshop;
    private $registerDate;
    private $licenseVehicle;
    private $photoVehicle;

    public function __construct($idReparation, $idWorkshop, $nameWorkshop, $registerDate, $licenseVehicle, $photoVehicle) {
        $this->idReparation = $idReparation;
        $this->idWorkshop = $idWorkshop;
        $this->nameWorkshop = $nameWorkshop;
        $this->registerDate = $registerDate;
        $this->licenseVehicle = $licenseVehicle;
        $this->photoVehicle = $photoVehicle;
    }

    public function getIdReparation() 
    { 
        return $this->idReparation; 
    }
    public function setIdReparation($idReparation) 
    { 
        $this->idReparation = $idReparation;
        return $this; 
    }
    
    public function getIdWorkshop() 
    { 
        return $this->idWorkshop; 
    }

    public function getNameWorkshop() 
    { 
        return $this->nameWorkshop; 
    }

    public function getRegisterDate() 
    { 
        return $this->registerDate; 
    }

    public function getLicenseVehicle() 
    { 
        return $this->licenseVehicle; 
    }
    public function setLicenseVehicle($licenseVehicle) 
    { 
        $this->licenseVehicle = $licenseVehicle; 
        return $this;
    }

    public function getPhotoVehicle() 
    { 
        return $this->photoVehicle; 
    }
    public function setPhotoVehicle($photoVehicle) 
    { 
        $this->photoVehicle = $photoVehicle; 
        return $this;
    }
}