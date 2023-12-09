<?php
    require_once("../modele/vehicule.class.php");
    require_once("../modele/connexion.php");

    class VehiculeDAO{
        private $db;
        private $select;

        function __construct(){
            $this -> db = new Connexion();
            $this -> select = 'SELECT no_immat, date_immat, modele, marque, no_permis FROM vehicule ';
        }

        private function loadQuery (array $result) : array	{
			$vehicules = [];
			foreach($result as $row){
				$vehicule = new Vehicule();
				$vehicule->setImmat($row['no_immat']);
				$vehicule->setDate($row['date_immat']);
				$vehicule->setModele($row['modele']);
                $vehicule->setMarque($row['marque']);
                $vehicule->setPermis($row['no_permis']);
				$vehicules[] = $vehicule; 
			}
			return $vehicules;
		}

        function getAll () : array	{
			return	($this->loadQuery($this->db->execSQLselect($this->select)));	
		}

		function immatExiste(string $immat): bool{
			if(count($this->loadQuery($this->db->execSQLselect($this->select." WHERE no_immat = :immat", [":immat"=>$immat]))) > 0) return true;
			else return false;
		}

        function getByImmat (string $immat) : Vehicule	{
			$unVehicule = new Vehicule();
			$lesVehicules = $this->loadQuery($this->db->execSQLselect($this->select ." WHERE no_immat=:immat", [':immat'=>$immat]) );
			if (count($lesVehicules)>0) { $unVehicule = $lesVehicules[0]; }
			return $unVehicule;
		}

    }

?>