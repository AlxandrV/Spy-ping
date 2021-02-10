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
     */
    static function addExtraction(Extraction $extraction)
    {

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