<?php
namespace App\Extraction;

class Extraction
{
    /**
     * Properties
     * 
     * @var int $_id
     * @var int $_userId
     * @var string $_url
     * @var int $_categorieId
     * @var string $_json
     */
    private $_id;
    private $_userId;
    private $_url;
    private $_categorieId;
    private $_json;

    /**
     * Construct call function hydrate
     * 
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }
    
    /**
     * Hydrate call for each setter exist in @param
     * 
     * @param array $data
     */
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
     * Set the value of _userId
     * 
     * @param int $userId
     */ 
    private function set_userId(int $userId)
    {
        $this->_id = $userId;
    }

    /**
     * Set the value of _url
     * 
     * @param string $url
     */ 
    private function set_url(string $url)
    {
        $this->_url = htmlspecialchars(filter_var($url, FILTER_VALIDATE_URL));
    }

    /**
     * Set the value of _categorieId
     * 
     * @param int $categorieId
     */ 
    private function set_categorieId(int $categorieId)
    {
        $this->_categorieId = $categorieId;
    }

    /**
     * Set the value of _json
     * 
     * @param string $json
     */ 
    private function set_json(string $json)
    {
        $correct = (is_string($json) && is_array(json_decode($json, true)) && (json_last_error() == JSON_ERROR_NONE)) ? true : false;
        if($correct === true) {
            $this->_json = $json;            
        }
    }

    /**
     * Set the value of _id
     * 
     * @param int $id
     */ 
    private function set_id(int $id)
    {
        $this->_id = $id;
    }

    /**
     * Get the value of _id
     * 
     * @return int $this->_id
     */ 
    public function get_id()
    {
        return $this->_id;
    }

    /**
     * Get the value of _userId
     * 
     * @return int $this->_userId
     */ 
    public function get_userId()
    {
        return $this->_userId;
    }

    /**
     * Get the value of _email
     * 
     * @return string $this->_url
     */ 
    public function get_url()
    {
        return $this->_url;
    }

    /**
     * Get the value of _categorieId
     * 
     * @return int $this->_categorieId
     */ 
    public function get_categorieId()
    {
        return $this->_categorieId;
    }

    /**
     * Get the value of _json
     * 
     * @return string $this->_json
     */ 
    public function get_json()
    {
        return $this->_json;
    }
}