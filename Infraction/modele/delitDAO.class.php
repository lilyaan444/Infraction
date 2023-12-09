<?php
    include_once("../modele/connexion.php");
    include_once("../modele/delit.class.php");

    class DelitDAO{
        private $db;
        private $select;

        function __construct(){
            $this->db = new Connexion();
            $this->select = "SELECT id_delit, nature, tarif FROM delit";
        }

        private function loadQuery(array $result): array{
            $delits = [];
            foreach($result as $row){
                $delit = new Delit();
                $delit->setId($row["id_delit"]);
                $delit->setNature($row["nature"]);
                $delit->setTarif($row["tarif"]);
                $delits [] = $delit;
            }
            return $delits;
        }

        function getAll(): array{
            return $this->loadQuery($this->db->execSQLselect($this->select));
        }

        function getById(string $id): Delit{
            $unDelit = new Delit();
            $lesDelits = $this->loadQuery($this->db->execSQLselect($this->select . " WHERE id_delit = :ID", [":ID"=>$id]));
            if(count($lesDelits) > 0){ $unDelit = $lesDelits[0]; }
            return $unDelit;
        }
    }

?>