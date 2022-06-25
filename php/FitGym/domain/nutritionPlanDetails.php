<?php

    class NutritionPlanDetails{

        private $idNutritionPlanDetails;
        private $idNutritionPlan;
        private $foodDay;
        private $foodTime;
        private $description;

        function __construct($idNutritionPlanDetails, $idNutritionPlan, $foodDay , $foodTime, $description){

            $this->idNutritionPlanDetails = $idNutritionPlanDetails;
            $this->idNutritionPlan = $idNutritionPlan;
            $this->foodDay = $foodDay;
            $this->foodTime = $foodTime;
            $this->description = $description;
        }

        // FUNCIONES GET

        function getIdNutritionPlanDetails() {
            return $this->idNutritionPlanDetails; // Id de los detalles del plan de nutricion
        }

        function getIdNutritionPlan() {
            return $this->idNutritionPlan; // Id del plan de nutricion
        }
    
        function getFoodDay() {
            return $this->foodDay; // Dias de comida
        }
    
        function getFoodTime() {
            return $this->foodTime; // Temporalidades de comida
        }

        function getDescription() {
            return $this->description; // Descripcion del dia y del tiempo de comida
        }

        // FUNCIONES SET

        function setIdNutritionPlanDetails($idNutritionPlanDetails) {
            $this->idNutritionPlanDetails = $idNutritionPlanDetails; // Id de los detalles del plan de nutricion
        }

        function setIdNutritionPlan($idNutritionPlan) {
            $this->idNutritionPlan = $idNutritionPlan; // Id del plan de nutricion
        }
    
        function setFoodDay($foodDay) {
            $this->foodDay = $foodDay; // Dias de comida
        }
    
        function setFoodTime($foodTime) {
            $this->foodTime = $foodTime; // Temporalidades de comida
        }
    
        function setDescription($description) {
            $this->description = $description; // Descripcion del dia y del tiempo de comida
        }
    }
?>