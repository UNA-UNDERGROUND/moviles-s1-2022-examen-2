<?php

    require_once '../data/nutritionPlanData.php';

    class NutritionPlanBusiness{

        private $nutritionPlanData;

        public function __construct(){

            $this->nutritionPlanData = new NutritionPlanData();
        }

        // Verifica si ya existe un id registrado en el plan de nutricion

        public function verifyExistIdNutritionPlan($idNutritionPlan){

            return $this->nutritionPlanData->verifyExistIdNutritionPlan($idNutritionPlan);
        }

        // Verifica si ya existe el dia con el tiempo de comida juntos en un plan de nutricion

        public function verifyExistDayAndFoodTime($idNutritionPlan, $selectDay, $foodTime){

            return $this->nutritionPlanData->verifyExistDayAndFoodTime($idNutritionPlan, $selectDay, $foodTime);
        }

        // Registra detalles de un plan de nutricion en la base de datos

        public function insertDetailsNutritionPlan($nutritionPlanDetails){

            return $this->nutritionPlanData->insertDetailsNutritionPlan($nutritionPlanDetails);
        }

        // Registra un nuevo plan de nutricion en la base de datos

        public function insertNutritionPlan($nutritionPlan){

            return $this->nutritionPlanData->insertNutritionPlan($nutritionPlan);
        }

        // Metodo para obtener los planes de nutricion registrados

        public function getNutritionPlans(){

            return $this->nutritionPlanData->getNutritionPlans();
        }

        // Metodo para obtener los detalles de un plan de nutricion

        public function getAllDetailsNutritionPlan($idNutritionPlan){

            return $this->nutritionPlanData->getAllDetailsNutritionPlan($idNutritionPlan);
        }

        // Metodo para obtener el datelle de una instruccion en un plan de nutricion
        public function getDetailNutrition($idNutritionPlanDetails){
            return $this->nutritionPlanData->getDetailNutrition($idNutritionPlanDetails);
        }

        // Metodo para actualizar un plan de nutricion seleccionado
        public function updateNutritionPlanDetail($idDetailNutritionPlan, $nutritionDescription){
            return $this->nutritionPlanData->updateNutritionPlanDetail($idDetailNutritionPlan, $nutritionDescription);
        }

        // Metodo para borra los detalles de un plan de nutricion
        public function deleteNutritionPlanDetail($idDetailNutritionPlan){
            return $this->nutritionPlanData->deleteNutritionPlanDetail($idDetailNutritionPlan);
        }

        // Metodo para borra los detalles de un plan de nutricion por dia
        public function deleteNutritionPlanDetailByDay($idNutritionPlan, $day){
            return $this->nutritionPlanData->deleteNutritionPlanDetailByDay($idNutritionPlan, $day);
        }

        // Metodo para extraer la direccion del codigo QR de un plan de nutricion para ser borrada
        public function extractDirCodeQr($idNutritionPlan){
            return $this->nutritionPlanData->extractDirCodeQr($idNutritionPlan);
        }

        // Metodo para borra TODO un plan de nutricion
        public function deleteAllNutritionPlan($idNutritionPlan){
            return $this->nutritionPlanData->deleteAllNutritionPlan($idNutritionPlan);
        }

        // Metodo para extraer planes de nutricion por medio de un filtro
        public function getAllFilterPlanNutrition($namePlan){
            return $this->nutritionPlanData->getAllFilterPlanNutrition($namePlan);
        }

        // Metodo para registrar un plan a favoritos
        public function insertFavoritePlan($idplan, $iduser){
            return $this->nutritionPlanData->insertFavoritePlan($idplan, $iduser);
        }

        // Metodo para extraer los planes favoritos por medio de id de usuario
        public function getAllDataFavoritePlanNutrition($iduser){
            return $this->nutritionPlanData->getAllDataFavoritePlanNutrition($iduser);
        }

        // Metodo para extraer los datos del propio plan
        public function getDataPlanByIdFavoritePlan($idfavoriteplan){
            return $this->nutritionPlanData->getDataPlanByIdFavoritePlan($idfavoriteplan);
        }

        // Metodo para elimar el plan favorito de un usuario
        public function deleteFavoritePlan($idfavoriteplan){
            return $this->nutritionPlanData->deleteFavoritePlan($idfavoriteplan);
        }

        // Metodo para extraer los planes de entrenamiento por WS
        public function getDataNutritionWS(){
            return $this->nutritionPlanData->getDataNutritionWS();
        }

        // Metodo para extraer los planes de entrenamiento por WS
        public function getDataNutrition(){
            return $this->nutritionPlanData->getDataNutrition();
        }
    }
?>