
<?php
    class Vehicule{
        private $immat;
        private $date;
        private $modele;
        private $marque;
        private $permis;

        function __construct(string $immat = "", string $date = "", string $modele = "", string $marque = "", string $permis = ""){
            $this->immat = $immat;
            $this->date = $date;
            $this->modele = $modele;
            $this->marque = $marque;
            $this->permis = $permis;
        }
        
        function getImmat():string{
            return $this->immat;
        }    

        function setImmat(string $immat): void{
            $this->immat = $immat;
        }

        function getDate():string{
            return $this->date;
        }    

        function afficheDate():string{
            $tab = explode("-", $this->date);
            $date = $tab[2]."/".$tab[1]."/".$tab[0];
            return $date;
        }

        function setDate(string $date): void{
            $this->date = $date;
        }

        function getModele():string{
            return $this->modele;
        }    

        function setModele(string $modele): void{
            $this->modele = $modele;
        }

        function getMarque():string{
            return $this->marque;
        }    

        function setMarque(string $marque): void{
            $this->marque = $marque;
        }

        function getPermis():string{
            return $this->permis;
        }    

        function setPermis(string $permis): void{
            $this->permis = $permis;
        }
    }


?>