<?php
namespace App\User;

use App\Connexion\Connexion;
use App\User\User;

class UserManager
{
    static function addUser(User $user)
    {
        $name = $user->get_name();
        $email = $user->get_email();
        $password = $user->get_password();
        // var_dump($name, $email, $password);
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