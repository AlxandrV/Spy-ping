<?php
namespace App\Connexion;

class Connexion {
	private $_login;
	private $_pass;
	private $_connec;

	public function __construct($db = 'spyping', $login ='root', $pass='root'){
		$this->_login = $login;
		$this->_pass = $pass;
		$this->_db = $db;
		$this->connexion();
	}

	private function connexion(){
		try
		{
	         $bdd = new \PDO(
                            'mysql:host=localhost;dbname='.$this->_db.';charset=utf8mb4', 
                             $this->_login, 
                             $this->_pass
                 );
			$bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
			$bdd->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
			$this->_connec = $bdd;
		}
		catch (\PDOException $e)
		{
			$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
			die($msg);
		}
	}

	public function query($sql,Array $cond = null){
		$stmt = $this->_connec->prepare($sql);

		if($cond){
			foreach ($cond as $v) {
				$stmt->bindParam($v[0],$v[1],$v[2]);
			}
		}

		$stmt->execute();

		return $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt=NULL;
	}


}