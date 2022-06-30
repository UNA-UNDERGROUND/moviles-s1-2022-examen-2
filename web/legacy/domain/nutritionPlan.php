<?php

    class NutritionPlan implements JsonSerializable{

        private $idnutritionplan;
        private $name;
        private $imagecodeqr;
        private $daysNutritionPlan;

        function __construct($idnutritionplan, $name, $imagecodeqr){

            $this->idnutritionplan = $idnutritionplan;
            $this->name = $name;
            $this->imagecodeqr = $imagecodeqr;
        }

        // FUNCIONES GET

        function getIdNutritionPlan() {
            return $this->idnutritionplan; // Id del plan de nutricion
        }

        function getName() {
            return $this->name; // Nombre del plan de nutricion
        }
    
        function getImagecodeqr() {
            return $this->imagecodeqr; // Ruta de la imagen del codigo QR
        }

        function getDays(){
            return $this->daysNutritionPlan; // Array de dias del plan de nutricion
        }

        // FUNCIONES SET

        function setIdNutritionPlan($idnutritionplan) {
            $this->idnutritionplan = $idnutritionplan; // Id del plan de nutricion
        }

        function setName($name) {
            $this->name = $name; // Nombre del plan de nutricion
        }
    
        function setImagecodeqr($imagecodeqr) {
            $this->imagecodeqr = $imagecodeqr; // Ruta de la imagen del codigo QR
        }

        function setDays($daysNutritionPlan){
            $this->daysNutritionPlan = $daysNutritionPlan; // Array de dias del plan de nutricion
        }

        public function jsonSerialize() {
            return [
                'idnutritionplan' => $this->idnutritionplan,
                'name' => $this->name,
                'days' => $this->daysNutritionPlan
            ];
        }
    }
