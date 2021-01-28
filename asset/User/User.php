<?php
namespace App\User;

class User
{
    private $_id;
    private $_name;
    private $_email;
    private $_password;
    private $_validated;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }
    
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set_'.$key;
            if(method_exists($this, $method))
            {
                $this->$method($value);
            }    
        }
    }

    /**
     * Set the value of _validated
     */ 
    public function set_validated(bool $validated)
    {
        $this->_validated = $validated;
    }

    /**
     * Set the value of _password
     */ 
    public function set_password(string $password)
    {
        $password = htmlspecialchars(filter_var($password, FILTER_SANITIZE_STRING));
        $this->_password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Set the value of _email
     */ 
    public function set_email(string $email)
    {
        $email = htmlspecialchars(filter_var($email, FILTER_SANITIZE_EMAIL));
        $email = (!filter_var((strlen($email) <= 320), FILTER_VALIDATE_EMAIL)) ? false : $email;
        if($email !== false) {
            $this->_email = $email;
        }
    }

    /**
     * Set the value of _name
     */ 
    public function set_name(string $name)
    {
        $name = htmlspecialchars(filter_var($name, FILTER_SANITIZE_STRING));
        $name = (strlen($name) <= 60) ? false : $name;
        if($name !== false) {
            $this->_name = $name;            
        }
    }

    /**
     * Set the value of _id
     */ 
    public function set_id(int $id)
    {
        $this->_id = $id;
    }
}