<?php
namespace App;

class Autoloader
{
    static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
    
    static function autoload($className)
    {
        require __DIR__.'/../vendor/autoload.php';
        $className = str_replace(__NAMESPACE__.'\\', '', $className);
        $className = str_replace('\\', '/', $className);
        require $className.'.php';
    }
}