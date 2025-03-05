<?php

namespace App\Model;

class Reparation {
    private $id_reparation;
    private $id_taller;
    private $nombre_taller;
    private $fecha_registro;
    private $matricula;
    private $foto_path;

    public function __construct($data) {
        $this->id_reparation = $data['id_reparation'];
        $this->id_taller = $data['id_taller'];
        $this->nombre_taller = $data['nombre_taller'];
        $this->fecha_registro = $data['fecha_registro'];
        $this->matricula = $data['matricula'];
        $this->foto_path = $data['foto_path'];
    }

    public function getIdReparation() { return $this->id_reparation; }
    public function setIdReparation($id_reparation) { $this->id_reparation = $id_reparation; }
    public function getIdTaller() { return $this->id_taller; }
    public function getNombreTaller() { return $this->nombre_taller; }
    public function getFechaRegistro() { return $this->fecha_registro; }
    public function getMatricula() { return $this->matricula; }
    public function setMatricula($matricula) { $this->matricula = $matricula; }
    public function getFotoPath() { return $this->foto_path; }
    public function setFotoPath($foto_path) { $this->foto_path = $foto_path; }
}