<?php
    include_once("../modele/connexion.php");
    include_once("../modele/conducteur.class.php");

    class ConducteurDAO{
        private $db;
        private $select;

        function __construct(){
            $this->db = new Connexion();
            $this->select = "SELECT no_permis, date_permis, nom, prenom, mdp FROM conducteur ";
        }

        private function loadQuery(array $result):array{
            $conducteurs = [];
            foreach($result as $row){
                $conducteur = new Conducteur();
                $conducteur->setPermis($row["no_permis"]);
                $conducteur->setNom($row["nom"]);
                $conducteur->setPrenom($row["prenom"]);
                $conducteur->setDate($row["date_permis"]);
                $conducteur->setMDP($row["mdp"]);
                $conducteurs[] = $conducteur;
            }
            return $conducteurs;
        }

        function getAll(): array{
            return	($this->loadQuery($this->db->execSQLselect($this->select)));
        }

        function permisExiste(string $permis): bool{
            if(count($this->loadQuery($this->db->execSQLselect($this->select . " WHERE no_permis = :permis", ["permis" => $permis]))) > 0) return true;
            else return false;
        }

        function getByPermis(string $permis): Conducteur{
            $unConducteur = new Conducteur();
            $lesConducteurs = $this->loadQuery($this->db->execSQLselect($this->select . " WHERE no_permis = :permis", ["permis" => $permis]));
            if(count($lesConducteurs) > 0) {$unConducteur = $lesConducteurs[0];}
            return $unConducteur;
        }

        function getAllPermis(): array{
            $permis = [];
            foreach($this->getAll() as $conducteur){
                $permis[] = $conducteur->getPermis();
            }
            return $permis;
        }
    }

?>