<?php

namespace App\Service;

use App\Model\Reparation;
use App\Config\Roles;
use Intervention\Image\ImageManager;
use Ramsey\Uuid\Uuid;



class ServiceReparation {
    private $db;
    private $logger;

    function getReparation($role, $idReparation): Reparation {
        $stmt = $this->mysqli->prepare("SELECT * FROM reparation WHERE idReparation = ?");
        $stmt->bind_param('s', $idReparation);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();

        $stmt->close();

        $reparation = new Reparation(
            $result['idReparation'],
            $result['idWorkshop'],
            $result['nameWorkshop'],
            $result['registerDate'],
            $result['licensePlate'],
            $result['photoVehicle']
        );

        if ($role == Roles::ROLE_CLIENT) {
            $managerImage = new \Intervention\Image\ImageManager();

            $imageObject = $managerImage->make($result['photoVehicle']);
            $imageObject->pixelate(20);
            $imageObject->save("../../resources/outputImg/tmp.png");
            $reparation->sethPhotoVehicle($imageObject);
            $reparation->setLicensePlate("XXXX XXX");
        }
        return $reparation;
    }

    function insertReparation($workshopId, $workshopName, $registerDate, $licensePlate): Reparation {
        $uuid4 = Uuid::uuid4();

        $watermarkText = $licensePlate . "+" . $uuid4;

        $managerImage = new \Intervention\Image\ImageManager();

        $imageObject = $managerImage->make($_FILES["photo"]["tmp_name"]);
        $imageObject->save("../../resources/inputImg/" . $_FILES["photo"]["name"]);

        $imageObject->text($watermarkText, 10, 20, function ($font) {
            $font->file('../../resources/arial.ttf');
            $font->size(30);
            $font->color(array(0, 255, 0, 1));
            $font->align('left');
            $font->valign('top');
        });

        $imageObject->save(path: "../../resources/outputImg/" . $_FILES["photo"]["name"]);
        $imageData = $imageObject;
        $imageData = $this->mysqli->real_escape_string($imageData);

        $reparation = new Reparation($uuid4, $workshopId, $workshopName, $registerDate, $licensePlate, $imageObject);

        $sql_sentence = "INSERT INTO reparation(idReparation, idWorkshop, nameWorkshop, registerDate, licensePlate, photoVehicle)
        VALUES('$uuid4', $workshopId, '$workshopName', '$registerDate', '$licensePlate', '$imageData')";
        try {
            $this->mysqli->query($sql_sentence);
            $this->log->info("Record inserted successfully");
        } catch (\Throwable $th) {
            $this->log->error("Error inserting a record" . $th->getMessage());
        }
        $this->mysqli->close();

        return $reparation;
    }





/*    public function __construct() {
        // Crear instancia de Logger de Monolog
        $this->logger = new Logger('ReparationService');
        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/repair_log.log', Logger::DEBUG));  // Definir dónde almacenar los logs

        $database = new Database();
        $this->db = $database->connect();
    }

    // Método para insertar una reparación
    public function insertReparation($data) {
        try {
            $sql = "INSERT INTO Reparation (id_reparation, id_taller, nombre_taller, fecha_registro, matricula, foto_path) 
                    VALUES (:id_reparation, :id_taller, :nombre_taller, :fecha_registro, :matricula, :foto_path)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id_reparation', $data['id_reparation']);
            $stmt->bindParam(':id_taller', $data['id_taller']);
            $stmt->bindParam(':nombre_taller', $data['nombre_taller']);
            $stmt->bindParam(':fecha_registro', $data['fecha_registro']);
            $stmt->bindParam(':matricula', $data['matricula']);
            $stmt->bindParam(':foto_path', $data['foto_path']);

            $stmt->execute();
            $this->logger->info("Reparación insertada exitosamente.", $data);  // Registrar en los logs
            return true;
        } catch (PDOException $e) {
            // Registrar error en los logs
            $this->logger->error("Error al insertar reparación: " . $e->getMessage());
            return false;
        }
    }

    // Método para buscar una reparación por ID
    public function getReparationById($id) {
        try {
            $sql = "SELECT * FROM Reparation WHERE id_reparation = :id_reparation";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_reparation', $id);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new Reparation($result);
            } else {
                $this->logger->warning("Reparación no encontrada con el ID: " . $id);  // Registrar advertencia
                return null;  // No se encontró la reparación
            }
        } catch (PDOException $e) {
            // Registrar error en los logs
            $this->logger->error("Error al buscar reparación: " . $e->getMessage());
            return null;
        }
    }*/
}
