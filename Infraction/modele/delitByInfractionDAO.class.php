<?php
    require_once("../modele/connexion.php");
    require_once("../modele/delitByInfraction.class.php");
    require_once("../modele/delitDAO.class.php");

    class DelitByInfractionDAO{
        private $db;
        private $select;

        function __construct(){
            $this->db = new Connexion();
            $this->select = "SELECT id_inf, id_delit FROM comprend ";
        }

        function insert (DelitByInfraction $delitByInfraction) : void {
            $this->db->execSQL("INSERT INTO comprend (id_inf, id_delit)
                                VALUES (:id_inf, :id_delit)",
                                [':id_inf'=>$delitByInfraction->getId_inf(), 
                                ':id_delit'=>$delitByInfraction->getDelit()->getId()]);
        }

        function delete (string $id_inf, string $id_delit): void{
            $this->db->execSQL("DELETE FROM comprend WHERE id_inf=:idInf AND id_delit=:idDelit", [':idInf'=>$id_inf, ':idDelit'=>$id_delit]);
        }

        function deleteByInfraction(string $id_inf):void{
            $this->db->execSQL("DELETE FROM comprend WHERE id_inf = :idInf", [':idInf'=>$id_inf]);
        }

        function loadQuery(array $result):array{
            $delitDAO = new DelitDAO(); 
            $lesDelitsByInfraction = []; 
            foreach($result as $row) {
                $delit = $delitDAO->getById($row['id_delit']);
                $lesDelitsByInfraction[]= new DelitByInfraction($row['id_inf'], $delit);
            }
            return $lesDelitsByInfraction;
        }

        function getAll () : array {
            return ($this->loadQuery($this->db->execSQLselect($this->select)));
        }

        function getByInfraction(string $id_inf):array{
            return $this->loadQuery($this->db->execSQLselect($this->select . " WHERE id_inf = :idInf", [":idInf" => $id_inf]));
        }

        function existe (string $id_inf, string $id_delit) : bool {
            $req = "SELECT * 
                    FROM    comprend 
                    WHERE   id_delit = :idDelit
                    AND     id_inf = :idInf";
            $res = ($this->loadQuery($this->db->execSQLselect($req,[':idDelit'=>$id_delit, ':idInf'=>$id_inf])));
            return (count($res) > 0);
        }

        function totalByInfraction(string $id_inf): int{
            $tab = $this->loadQuery($this->db->execSQLselect($this->select . " WHERE id_inf = :idInf", [":idInf" => $id_inf]));
            $total = 0;
            foreach($tab as $row){
                $total += $row->getDelit()->getTarif();
            }
            return $total;
        }

    }


?>