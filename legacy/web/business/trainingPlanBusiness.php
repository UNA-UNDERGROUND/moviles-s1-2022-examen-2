<?php
require_once '../data/dataTrainingPlan.php';
require_once 'logicTrainingPlan.php';

class TrainingPlanBusiness{

    private $dataTrainingPlan;
    private $logicTrainingPlan;

    public function __construct(){ 
        $this->dataTrainingPlan = new DataTrainingPlan();
        $this->logicTrainingPlan = new LogicTrainingPlan();
    }

    public function insert_training_plan($trainingPlan, $user){
        return $this->dataTrainingPlan->insertTrainingPlan($trainingPlan, $user);
    }

    public function getLastIdTrainingPlan(){
        return $this->dataTrainingPlan->getLastIdTbTrainingPlan();
    }

    public function getTrainingPlanList(){
        return $this->dataTrainingPlan->getTrainingPlanList();
    }

    public function getSpecificTrainingPlan($idTrainingPlan){
        return $this->dataTrainingPlan->getSpecificTrainingPlan($idTrainingPlan);
    }

    public function updateTrainingPlan($trainingPlan){
        return $this->dataTrainingPlan->updateTrainingPlan($trainingPlan);
    }

    public function deleteTrainingPlan($idTrainingPlan){
        return $this->dataTrainingPlan->deleteTrainingPlan($idTrainingPlan);
    }

    public function generateQrTrainingPlan($fileName, $content_trainingPlan){
        $this->logicTrainingPlan->generateQr($fileName, $content_trainingPlan);
    }

    // Metodo para extraer el siguiente id de un plan de entrenamiento
    public function getNextIdTraining(){
        return $this->dataTrainingPlan->getNextIdTraining();
    }

    // Registra SOLO un plan de entrenamiento
    public function insertOnlyTrainingPlan($trainingPlan){
        return $this->dataTrainingPlan->insertOnlyTrainingPlan($trainingPlan);
    }

    // Extrae los ids de entrenamiento
    public function getDataTraining(){
        return $this->dataTrainingPlan->getDataTraining();
    }

    // Registra una rutina/actividad
    public function insertOnlyRoutines($activity, $day, $idtraining){
        return $this->dataTrainingPlan->insertOnlyRoutines($activity, $day, $idtraining);
    }

    // Extrae los datos de una rutina por medio del id de un plan de entrenamiento
    public function getRoutineByTraining($idtraining){
        return $this->dataTrainingPlan->getRoutineByTraining($idtraining);
    }

    // Borra la rutina de un plan de entrenamiento
    public function deleteRoutineByTraining($idtraining, $idday){
        return $this->dataTrainingPlan->deleteRoutineByTraining($idtraining, $idday);
    }

    // Actualiza la rutina de un plan de entrenamiento
    public function updateRoutine($activity, $idday, $idtraining){
        return $this->dataTrainingPlan->updateRoutine($activity, $idday, $idtraining);
    }

    // Extrae los planes de entrenamiento por el filtro del nombre
    public function getAllFilterPlanTraining($namePlan){
        return $this->dataTrainingPlan->getAllFilterPlanTraining($namePlan);
    }

    // Inserta un plan de entrenamiento a favoritos
    public function insertFavoritePlanTraining($idplan, $iduser){
        return $this->dataTrainingPlan->insertFavoritePlanTraining($idplan, $iduser);
    }

    // Extrae los planes favoritos de entrenamiento de un usuario
    public function getAllDataFavoritePlanNutrition($iduser){
        return $this->dataTrainingPlan->getAllDataFavoritePlanNutrition($iduser);
    }

    // Extrae los detalles de un plan de entrenamiento favorito
    public function getDataPlanByIdFavoritePlan($iduser){
        return $this->dataTrainingPlan->getDataPlanByIdFavoritePlan($iduser);
    }

    // Elimina el plan de entrenamiento de un favorito
    public function deleteFavoritePlan($idfavoriteplan){
        return $this->dataTrainingPlan->deleteFavoritePlan($idfavoriteplan);
    }

    // Extrae los datos de actividad de un plan de entrenamientos
    public function getAllDataActivityTraining($idTrainingPlan){
        return $this->dataTrainingPlan->getAllDataActivityTraining($idTrainingPlan);
    }
}
?>