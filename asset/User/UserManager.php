<?php
namespace App\User;

use App\Connexion\Connexion;
use App\User\User;

class UserManager
{
    /**
     * Add new user in database
     * 
     * @param object $user
     */
    static function addUser(User $user)
    {
        $name = $user->get_name();
        $email = $user->get_email();
        $password = $user->get_password();

        $connexion = new Connexion();

        // If table "user" not exist, create table
        $existTable = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'user' AND TABLE_SCHEMA = 'spyping'";
        $req = $connexion->query($existTable);

        if(!isset($req[0]->TABLE_NAME)){
            $createUserTable = "CREATE TABLE `user` 
                (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(60) NOT NULL,
                    `email` varchar(320) NOT NULL,
                    `password` varchar(255) NOT NULL,
                    `validated` tinyint(1) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                ) 
                ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $req = $connexion->query($createUserTable);        
        }

        // Add new user in table
        $addUser = "INSERT INTO user(name, email, password, validated) VALUES (:name, :email, :password, :bool)";
        $params = [
            ['name', $name, \PDO::PARAM_STR],
            ['email', $email, \PDO::PARAM_STR],
            ['password', $password, \PDO::PARAM_STR],
            ['bool', false, \PDO::PARAM_BOOL]
        ];
        $req = $connexion->query($addUser, $params);

        // Return id of the last user inserted
        $lastId = "SELECT id FROM user ORDER BY id DESC LIMIT 1";
        $req = $connexion->query($lastId);
        $id = (int) $req[0]->id;

        $dataHydrate = [
            "id" => $id,
            "validated" => false
        ];

        // Hydrate user
        $user->hydrate($dataHydrate);
    }

    static function deleteUser(User $user)
    {
        
    }

    static function updateUser(User $user)
    {
        
    }

    static function getUser(string $email, string $password)
    {
        
    }

}