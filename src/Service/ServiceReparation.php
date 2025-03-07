<?php

namespace App\Service;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Model\Reparation;
use Intervention\Image\ImageManager;
use mysqli;
use Intervention\Image\Drivers\Gd\Driver;
use Ramsey\Uuid\Nonstandard\Uuid;
use App\Utils\LoggerManager;
use Intervention\Image\Decoders\Base64ImageDecoder;
use Intervention\Image\Typography\FontFactory;
use Exception;


class ServiceReparation {

    function connect() {
        $logger = LoggerManager::getLogger();
        $db = parse_ini_file(__DIR__ . "/../../config/db_config.ini", true)["params_db_sql"];

        try {
            $mysqli = new mysqli($db["host"], $db["user"], $db["password"], $db["db_name"]);
        } catch (Exception $e) {
            $logger->error("Error connecting to the database" . $e->getMessage());
            exit;
        }
        return $mysqli;
    }

    function insertReparation(Reparation $reparation) {
        $logger = LoggerManager::getLogger();

        try {
            $conn = $this->connect();
            $query = "INSERT INTO workshop.reparation(idReparation, idWorkshop, nameWorkshop, registerDate, licenseVehicle, photoVehicle) VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                $logger->error("Error preparing the statement: " . $conn->error);
                echo "Error preparing the statement: " . $conn->error;
                return false;
            }

            $idReparation = $this->generateUUID();
            $idWorkshop = $reparation->getIdWorkshop();
            $nameWorkshop = $reparation->getNameWorkshop();
            $registerDate = $reparation->getRegisterDate();
            $licenseVehicle = $reparation->getLicenseVehicle();
            $photoVehicle = $reparation->getPhotoVehicle();
            //$photovehicleWaterMark = $this->addWatermark($photoVehicle, $licenseVehicle, $idReparation);

            $stmt->bind_param('ssssss', $idReparation, $idWorkshop, $nameWorkshop, $registerDate, $licenseVehicle, $photovehicle);
            
            if ($stmt->execute()) {
                $reparation->setIdReparation($idReparation);
                //$photoVehicle = base64_encode($photoVehicle);
                $logger->info("Record inserted successfully" . $reparation->getIdReparation());
                $stmt->close();
                $conn->close();
                return $reparation;
            } else {
                $logger->error("Error inserting the record: " . $stmt->error);
                $stmt->close();
                $conn->close();
                return null;
            }

        } catch (Exception $e) {
            $logger->error("Error inserting the record: " . $e->getMessage());
        }
    }

    function getReparation($role, $idReparation) {
        $logger = LoggerManager::getLogger();

        try {
            $conn = $this->connect();
            $query = "SELECT * FROM workshop.reparation WHERE idReparation = ?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error preparing the statement: " . $conn->error);
            }

            $stmt->bind_param('s', $idReparation);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $photoVehicle = $row['photoVehicle'];
                $licenseVehicle = $row['licenseVehicle'];

                if ($role === 'client' && $photoVehicle !== null) {
                    //$photoVehicle = $this->pixelateImage($photoVehicle);
                }
                if ($role === 'client' && $licenseVehicle !== null) {
                    $licenseVehicle = str_repeat('*', strlen($licenseVehicle));
                }

                $reparation = new Reparation(
                    $row['idReparation'],
                    $row['idWorkshop'],
                    $row['nameWorkshop'],
                    $row['registerDate'],
                    $licenseVehicle,
                    $photoVehicle
                );

                $logger->info("Record found successfully");
                $stmt->close();
                $conn->close();
                return $reparation;
            } else {
                $logger->warning("Record not found for ID: " . $idReparation);
                $stmt->close();
                $conn->close();
                return null;
            }
        } catch (Exception $e) {
            $logger->warning("Error getting the record: " . $e->getMessage());
            exit;
        }
    }


    function generateUUID() {
        return Uuid::uuid4()->toString();
    }

    /*function pixelateImage($imageVehicle) {
        if (!$imageVehicle) {
            return null;
        }

        $imagePixelate = new ImageManager(new Driver());

        $newImage = $imagePixelate->read($imageVehicle, Base64ImageDecoder::class);
        $newImage->pixelate(20);

        return base64_encode($newImage->encode());
    }

    function addWatermark($photo, $licensePlate, $idReparation) {
        $manager = new ImageManager(new Driver);
        $imageWithWatermark = $manager->read($photo, Base64ImageDecoder::class);

        $imageWithWatermark->text($licensePlate . " , " . $idReparation, 20, 50, function (FontFactory $font) {
            $font->size(30);
            $font->color('#000000');
            $font->align('center');
            $font->valign('bottom');
        });

        return base64_encode($imageWithWatermark->encode());
    }*/

}
