<?php
    class Delit{
        private $id;
        private $nature;
        private $tarif;

        function __construct(string $id = "", string $nature = "", int $tarif = 0){
            $this->id = $id;
            $this->nature = $nature;
            $this->tarif = $tarif;
        }

        function getId(): string{
            return $this->id;
        }

        function setId(string $id):void{
            $this->id = $id;
        }

        function getNature(): string{
            return $this->nature;
        }

        function setNature(string $nature):void{
            $this->nature = $nature;
        }

        function getTarif(): int{
            return $this->tarif;
        }

        function setTarif(int $tarif):void{
            $this->tarif = $tarif;
        }
    }
?>