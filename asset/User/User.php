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
        $this->_password = $password;
    }

    /**
     * Set the value of _email
     */ 
    public function set_email(string $email)
    {
        $this->_email = $email;
    }

    /**
     * Set the value of _name
     */ 
    public function set_name(string $name)
    {
        $this->_name = $name;
    }

    /**
     * Set the value of _id
     */ 
    public function set_id(int $id)
    {
        $this->_id = $id;
    }
}