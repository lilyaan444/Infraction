<?php
    class Infraction{
        private $id;
        private $date;
        private $immat;
        private $permis;

        function __construct(string $id = "", string $date = "", string $immat = "", string $permis = ""){
            $this->id = $id;
            $this->date = $date;
            $this->immat = $immat;
            $this->permis = $permis;
        }
        
        function getId():string{
            return $this->id;
        }    

        function setId(string $id): void{
            $this->id = $id;
        }

        function getDate():string{
            return $this->date;
        }

        function setDate(string $date): void{
            $this->date = $date;
        }


        function getImmat():string{
            return $this->immat;
        }    

        function setImmat(string $immat): void{
            $this->immat = $immat;
        }

        function getPermis():string{
            return $this->permis;
        }    

        function setPermis(string $permis): void{
            $this->permis = $permis;
        }
        
    }

?>