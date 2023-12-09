<?php
    require_once("../modele/delit.class.php");

    class DelitByInfraction{
        private $id_inf;
        private $delit;

        function __construct(string $id_inf = "", Delit $delit = null){
            $this->id_inf = $id_inf;
            $this->delit = $delit;
        }

        function getId_inf(): string{
            return $this->id_inf;
        }

        function setId_inf(string $id): void{
            $this->id_inf = $id;
        }

        function getDelit(): Delit{
            return $this->delit;
        }

        function setDelit(Delit $delit): void{
            $this->delit = $delit;
        }
    }

?>