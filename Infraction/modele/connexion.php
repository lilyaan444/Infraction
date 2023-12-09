<?php
class Connexion {
	private $db;

	function __construct() {
		$db_config['SGBD']        = 'mysql';
        $db_config['HOST']        = 'devbdd.iutmetz.univ-lorraine.fr';
        $db_config['DB_NAME']    = 'muller968u_IHM';
        $db_config['USER']        = 'muller968u_appli';
        $db_config['PASSWORD']    = '32203872';
		try
		{
			$this->db = new PDO($db_config['SGBD'] .':host='. $db_config['HOST'] .';dbname='. $db_config['DB_NAME'],
								$db_config['USER'],	$db_config['PASSWORD'],
								array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			unset($db_config);
		}
		catch( Exception $exception )
		{
			die($exception->getMessage()) ;
		}
	}

	
public function getDB() {
	return $this->db;
}

	function execSQL(string $req, array $valeurs=[]) : void{
		try
		{	
			$sql=$this->db->prepare($req); 
			$sql->execute($valeurs);
		}
		catch( Exception $exception )
		{
			die($exception->getMessage()) ;
		}
	}

    function execSQLselect(string $req, array $valeurs=[]) : array{
        $res=[];
		try
		{	
			$sql=$this->db->prepare($req); 
			$sql->execute($valeurs);
            $res = $sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch( Exception $exception )
		{
			die($exception->getMessage()) ;
		}
		return $res;
	}
}	



?>
