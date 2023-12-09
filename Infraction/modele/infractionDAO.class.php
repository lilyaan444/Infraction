<?php
    require_once("../modele/infraction.class.php");
    require_once("../modele/connexion.php");

    class InfractionDAO{
        private $db;
        private $select;

        function __construct(){
            $this -> db = new Connexion();
            $this -> select = 'SELECT id_inf, date_inf, no_immat, no_permis FROM infraction ';
        }

        function insert(Infraction $infraction){
            $this -> db -> execSQL("INSERT INTO `infraction`(id_inf, date_inf, no_immat, no_permis)
                                    VALUES(:id, :date_inf, :immat, :permis)",
                                    [':id'=>$this->newId(), 
                                    ':date_inf'=>$infraction->getDate(),
                                    ':immat'=>$infraction->getImmat(), 
                                    ':permis' => $infraction->getPermis()] );
        }

        function delete(string $id): void{
            //delete from infraction mais aussi from comprend
            $this->db->execSQL("DELETE FROM comprend WHERE id_inf=:id", [':id'=>$id]);
            $this->db->execSQL("DELETE FROM infraction WHERE id_inf=:id", [':id'=>$id]);
        }

        function update(Infraction $infraction): void{
            $this->db->execSQL("UPDATE infraction SET date_inf = :date, no_immat=:immat, no_permis=:permis WHERE id_inf=:id"
								,[':immat'=>$infraction->getImmat(), ':permis'=>$infraction->getPermis(), ':date' => $infraction->getDate()
									,':id'=>$infraction->getId() ] );	
        }

        private function loadQuery (array $result) : array	{
			$infractions = [];
			foreach($result as $row){
				$infraction = new Infraction();
				$infraction->setId($row['id_inf']);
				$infraction->setDate($row['date_inf']);
				$infraction->setImmat($row['no_immat']);
                $infraction->setPermis($row['no_permis']);
				$infractions[] = $infraction; 
			}
			return $infractions;
		}


        function getAllAsc () : array	{
			return	($this->loadQuery($this->db->execSQLselect($this->select. " ORDER BY id_inf ASC")));	
		}

        function getById (string $id) : Infraction	{
			$uneInfraction = new Infraction();
			$lesInfractions = $this->loadQuery($this->db->execSQLselect($this->select ." WHERE id_inf=:id", [':id'=>$id]) );
			if (count($lesInfractions)>0) { $uneInfraction = $lesInfractions[0]; }
			return $uneInfraction;
		}

        function getByPermis(string $permis): array{
            return ($this->loadQuery($this->db->execSQLselect($this->select . "WHERE no_permis = :permis", [":permis" => $permis])));
        }
        
        function newId(): string{
            $id = $this->db->execSQLselect("SELECT MAX(id_inf) FROM infraction")[0]['MAX(id_inf)'];
            if($id == null) return "1";
            else return strval(intval($id)+1);
        }

        function getInfractionsByConducteur (string $noPermis) : array	{
            return	($this->loadQuery($this->db->execSQLselect($this->select ." WHERE no_permis=:noPermis", [':noPermis'=>$noPermis]) ));
        }

        function getLastInsertId() : string{
            return	($this->loadQuery($this->db->execSQLselect($this->select ." ORDER BY id_inf DESC LIMIT 1"))[0]->getId());
        }
        

    }

?>