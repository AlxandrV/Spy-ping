<?php
namespace App\Extraction;

use App\Connexion\Connexion;
use App\Extraction\Extraction;
use App\User\User;

class ExtractionManager
{
    /**
     * Add new extraction in database
     * 
     * @param object $extraction
     * @param object $user
     */
    static function addExtraction(Extraction $extraction, User $user)
    {
        $userId = $user->get_id();
        $urlExtraction = $extraction->get_url();

        $connexion = new Connexion();

        // If table "extraction" not exist, create table
        $existTable = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'extraction' AND TABLE_SCHEMA = 'spyping'";
        $req = $connexion->query($existTable);

        if(!isset($req[0]->TABLE_NAME)){
            $createExtractionTable = "CREATE TABLE `extraction` 
                (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `userId` int(11) NOT NULL,
                    `url` varchar(2048) NOT NULL,
                    `categireId` int(11) NOT NULL,
                    `json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`json`)),
                    PRIMARY KEY (`id`)
                ) 
                ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $req = $connexion->query($createExtractionTable);        
        }

        // Add new extraction in table
        $addExtraction = "INSERT INTO extraction(userId, url) VALUES (:userId, :url)";
        $params = [
            ['userId', $userId, \PDO::PARAM_INT],
            ['url', $urlExtraction, \PDO::PARAM_STR],
        ];
        $req = $connexion->query($addExtraction, $params);

        // Return id of the last extraction inserted
        $lastId = "SELECT id FROM extraction ORDER BY id DESC LIMIT 1";
        $req = $connexion->query($lastId);
        $id = (int) $req[0]->id;

        $dataHydrate = [
            "id" => $id,
        ];

        // Hydrate extraction
        $extraction->hydrate($dataHydrate);

        $connexion = null;       
    }

    /**
     * List of extraction of a user
     * 
     * @param int $userId
     * @return array $req
     */
    static function listExtraction(int $userId)
    {
        $connexion = new Connexion();

        $listExtraction = "SELECT id, url FROM extraction WHERE userId = :id";
        $param = [['id', $userId, \PDO::PARAM_INT]];

        $req = $connexion->query($listExtraction, $param);

        $connexion = null;

        return $req;
    }
}