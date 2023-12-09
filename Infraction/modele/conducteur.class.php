<?php
    class Conducteur{
        private $permis;
        private $nom;
        private $prenom;
        private $date;
        private $mdp;

        function __construct(string $permis = "", string $nom = "", string $prenom = "", string $date = "", string $mdp = ""){
            $this->permis = $permis;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->date = $date;
            $this->mdp = $mdp;
        }

        function getPermis():string{
            return $this->permis;
        }

        function setPermis(string $permis): void{
            $this->permis = $permis;
        }

        function getNom():string{
            return $this->nom;
        }

        function setNom(string $nom): void{
            $this->nom = $nom;
        }

        function getPrenom():string{
            return $this->prenom;
        }

        function setPrenom(string $prenom): void{
            $this->prenom = $prenom;
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

        function getMDP():string{
            return $this->mdp;
        }

        function setMDP(string $mdp): void{
            $this->mdp = $mdp;
        }
    }

?>