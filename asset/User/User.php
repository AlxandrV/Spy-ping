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
    private function set_validated(bool $validated)
    {
        $this->_validated = $validated;
    }

    /**
     * Set the value of _password
     */ 
    private function set_password(string $password)
    {
        $password = htmlspecialchars(filter_var($password, FILTER_SANITIZE_STRING));
        $this->_password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Set the value of _email
     */ 
    private function set_email(string $email)
    {
        $email = htmlspecialchars(filter_var($email, FILTER_SANITIZE_EMAIL));
        $email = (!filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 320) ? false : $email;
        if($email !== false) {
            $this->_email = $email;
        }
    }

    /**
     * Set the value of _name
     */ 
    private function set_name(string $name)
    {
        $name = htmlspecialchars(filter_var($name, FILTER_SANITIZE_STRING));
        $name = (strlen($name) <= 60) ? $name : false;
        if($name !== false) {
            $this->_name = $name;            
        }
    }

    /**
     * Set the value of _id
     */ 
    private function set_id(int $id)
    {
        $this->_id = $id;
    }

    /**
     * Get the value of _id
     */ 
    public function get_id()
    {
        return $this->_id;
    }

    /**
     * Get the value of _name
     */ 
    public function get_name()
    {
        return $this->_name;
    }

    /**
     * Get the value of _email
     */ 
    public function get_email()
    {
        return $this->_email;
    }

    /**
     * Get the value of _password
     */ 
    public function get_password()
    {
        return $this->_password;
    }

    /**
     * Get the value of _validated
     */ 
    public function get_validated()
    {
        return $this->_validated;
    }
}