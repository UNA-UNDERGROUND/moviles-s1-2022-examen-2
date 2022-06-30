<?php
require_once '../domain/day.php';
require_once '../domain/activity.php';
require_once '../domain/trainingPlan.php';

$path_dboilerplate = realpath(dirname(__FILE__).'/../vendor/una-ouroboros/DBoilerplate').'/';
require_once $path_dboilerplate. 'MySqlConnectionProvider.php';

use una_ouroboros\DBoilerplate\MySqlConnectionProvider;


class DataTrainingPlan extends MySqlConnectionProvider{

    // constructor
    function __construct()
    {
        parent::__construct("FitGym", "local");
    }

    public function getLastIdTbTrainingPlan(){

        $connection = parent::getConnection();
        

        //get the last id
        $queryGetLastId = "SELECT MAX(idtrainingplan) AS idtrainingplan FROM tbtrainingplan";
        $idCount = mysqli_query($connection, $queryGetLastId);
        $nextId = 1;
        if ($row = mysqli_fetch_row($idCount)){

            $nextId = intval(trim($row[0]), 10) + 1;
        }
        return $nextId;
    }
    
    public function insertTrainingPlan($trainingPlan, $user){
        $conn = parent::getConnection();
        $conn->set_charset('utf8');
        $string_values_activities = "";
        $result = true;
        $array_days = $trainingPlan->getDays();
        $array_activities = [];
        for ($i = 0; $i < count($array_days); $i++){
            $array_activities = $array_days[$i]->getActivities();
            for ($j = 0; $j < count($array_activities); $j++){
                $string_values_activities .= "('" . $array_days[$i]->getId() . "','" . $trainingPlan->getId(). "','" . $array_activities[$j]->getName() . "','" . $array_activities[$j]->getRepetitions() . "','" . 
                    $array_activities[$j]->getBreaks() . "','" . $array_activities[$j]->getSeries() . "','" . $array_activities[$j]->getCadence() . "','" . $array_activities[$j]->getWeight() . "'),";
            }
        }
        $queryInsertTrainingPlan = "INSERT INTO tbtrainingplan (idtrainingplan,username,nametrainingplan,qrcodetrainingplan) VALUES ('" . $trainingPlan->getId() .
            "','" . $user .
            "','" . $trainingPlan->getName() .
            "','" . $trainingPlan->getQrCode() . "');";//inserta el plan de entrenamiento
        $queryInsertAtivity = "INSERT INTO tbactivity (idday,idtrainingplan,nameactivity,repetitionsactivity,breaksactivity,seriesactivity,cadenceactivity,weightactivity) VALUES " 
            . substr($string_values_activities, 0, strlen($string_values_activities) - 1)  . ";";
        mysqli_autocommit($conn, false);
        mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);
        mysqli_query($conn, $queryInsertTrainingPlan)? null: $result = false;
        mysqli_query($conn, $queryInsertAtivity)? null: $result= false;
        $result? mysqli_commit($conn) : mysqli_rollback($conn);
        
        mysqli_close($conn);
        return $result;
    }

    public function updateTrainingPlan($trainingPlan){
        $conn = parent::getConnection();
        $conn->set_charset('utf8');
        $string_values_activities = "";
        $result = true;
        $array_days = $trainingPlan->getDays();
        $array_activities = [];
        for ($i = 0; $i < count($array_days); $i++){
            $array_activities = $array_days[$i]->getActivities();
            for ($j = 0; $j < count($array_activities); $j++){
                $string_values_activities .= "('" . $array_days[$i]->getId() . "','" . $trainingPlan->getId(). "','" . $array_activities[$j]->getName() . "','" . $array_activities[$j]->getRepetitions() . "','" . 
                    $array_activities[$j]->getBreaks() . "','" . $array_activities[$j]->getSeries() . "','" . $array_activities[$j]->getCadence() . "','" . $array_activities[$j]->getWeight() . "'),";
            }
        }
        $queryDelete = "DELETE FROM tbactivity WHERE idtrainingplan='" . $trainingPlan->getId() . "'";
        $queryInsertAtivity = "INSERT INTO tbactivity (idday,idtrainingplan,nameactivity,repetitionsactivity,breaksactivity,seriesactivity,cadenceactivity,weightactivity) VALUES " 
            . substr($string_values_activities, 0, strlen($string_values_activities) - 1)  . ";";
        mysqli_autocommit($conn, false);
        mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);
        mysqli_query($conn, $queryDelete)? null: $result = false;
        mysqli_query($conn, $queryInsertAtivity)? null: $result= false;
        $result? mysqli_commit($conn) : mysqli_rollback($conn);

        mysqli_close($conn);
        return $result;
    }

    public function deleteTrainingPlan($idTrainingPlan){
        $conn = parent::getConnection();
        $conn->set_charset('utf8');
        $result = true;
        $queryDeleteActivities = "DELETE FROM tbactivity WHERE idtrainingplan='" . $idTrainingPlan . "'";
        $queryDeleteTrainingPlan = "DELETE FROM tbtrainingplan WHERE idtrainingplan='" .  $idTrainingPlan . "'";
        mysqli_autocommit($conn, false);
        mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);
        mysqli_query($conn, $queryDeleteActivities)? null: $result = false;
        mysqli_query($conn, $queryDeleteTrainingPlan)? null: $result= false;
        $result? mysqli_commit($conn) : mysqli_rollback($conn);

        mysqli_close($conn);
        return $result;
    }

    public function getTrainingPlanList(){
        $connection = parent::getConnection();
        

        $querySelect = "SELECT * FROM tbtrainingplan;";

        $result = mysqli_query($connection, $querySelect);
        mysqli_close($connection);

        $trainingPlanList = [];// se declara un vector

        while ($row = mysqli_fetch_array($result)){

            $trainingPlan = new TrainingPlan($row['idtrainingplan'], $row['nametrainingplan'], $row['qrcodetrainingplan'],  null);
            array_push($trainingPlanList, $trainingPlan);
        }

        return $trainingPlanList;
    }

    public function getSpecificTrainingPlan($idTrainingPlan){
        $connection = parent::getConnection();
        
        $querySelect = "SELECT * FROM tbtrainingplan WHERE idtrainingplan ='" . $idTrainingPlan . "';";
        $querySelectActivities = "SELECT * FROM tbactivity WHERE idtrainingplan ='" . $idTrainingPlan . "';";
        $querySelectDays = "SELECT * FROM tbday WHERE idday IN (SELECT DISTINCT idday FROM `tbactivity` WHERE idtrainingplan ='" . $idTrainingPlan . "');";
        $result = mysqli_query($connection, $querySelect);
        $activities = mysqli_query($connection, $querySelectActivities);
        $days = mysqli_query($connection, $querySelectDays);
        mysqli_close($connection);
        $trainingPlan = null;
        $activity = null;
        $day = null;
        $array_days = [];
        $array_activities = [];
        $arrayAux = [];
        while ($day_row = mysqli_fetch_array($days)){
            $day = new Day($day_row['idday'], $day_row['nameday'], null);
            array_push($array_days, $day);
        }
        while ($row = mysqli_fetch_array($result)){
            $trainingPlan = new TrainingPlan($row['idtrainingplan'], $row['nametrainingplan'], $row['qrcodetrainingplan'],  null);
        }
        while ($activity_row = mysqli_fetch_array($activities)){
            $activity = new Activity($activity_row['nameactivity'], $activity_row['seriesactivity'], $activity_row['repetitionsactivity'], $activity_row['weightactivity'], $activity_row['cadenceactivity'], $activity_row['breaksactivity']);
            $arrayAux = array("idDay"=>$activity_row['idday'], "activity"=>$activity);
            array_push($array_activities, $arrayAux);
        }
        for ($i = 0; $i < count($array_days); $i++){
            $arrayAux = [];
            for ($j = 0; $j < count($array_activities); $j++){
                if ($array_days[$i]->getId() == $array_activities[$j]['idDay']){
                    array_push($arrayAux, $array_activities[$j]['activity']);
                }
            }
            $array_days[$i]->setActivities($arrayAux);
        }
        $trainingPlan->setDays($array_days);
        return $trainingPlan;
    }

    // Metodo para extraer el siguiente id de un plan de entrenamiento
    public function getNextIdTraining(){

        $connection = parent::getConnection();

        //Obtiene el siguiente id
        $queryGetLastId = "SELECT MAX(idtrainingplan) AS idtrainingplan FROM tbtrainingplan";
        $idCont = mysqli_query($connection, $queryGetLastId);
        $nextId = 1;
        if ($row = mysqli_fetch_row($idCont)) {
            if(trim($row[0]) != null){ $nextId = trim($row[0]) + 1; }
        }

        mysqli_close($connection);

        return $nextId;
    }

    // Registra SOLO un plan de entrenamiento
    public function insertOnlyTrainingPlan($trainingPlan){

        $connection = parent::getConnection();

        $user = $trainingPlan->getName();

        // Inserta el plan de entrenamiento
        $queryInsertTrainingPlan = "INSERT INTO tbtrainingplan (idtrainingplan,username,nametrainingplan,qrcodetrainingplan) VALUES ('" .
        $trainingPlan->getId()."','" . $user ."','" . $trainingPlan->getName() ."','" . $trainingPlan->getQrCode() . "');";

        $result = mysqli_query($connection, $queryInsertTrainingPlan);

        mysqli_close($connection);

        return $result;
    }

    // Extrae los ids de entrenamiento
    public function getDataTraining(){
        
        $connection = parent::getConnection();

        $json = array();

        $query = "SELECT * FROM tbtrainingplan";

        $result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_array($result)){
            $json['list_data_training'][] = $row;
        }

        mysqli_close($connection);

        return $json;
    }

    // Registra una rutina/actividad
    public function insertOnlyRoutines($activity, $day, $idtraining){
        
        $connection = parent::getConnection();

        // Verifica que no se repita un dia en un plan de entrenamiento
        $result = true;
        $queryConsult = "SELECT * FROM tbactivity WHERE idtrainingplan = '".$idtraining."' AND idday = '".$day."';";
        $resultConsult = mysqli_query($connection, $queryConsult);
        while(mysqli_fetch_array($resultConsult)) { $result = false; }

        if($result){

            $query = "INSERT INTO tbactivity VALUES ('".$day."', '".$idtraining."', '".$activity->getName()."', '".$activity->getRepetitions().
            "', '".$activity->getBreaks()."', '".$activity->getSeries()."', '".$activity->getCadence()."', '".$activity->getWeight()."');";

            $result = mysqli_query($connection, $query);
        }

        mysqli_close($connection);

        return $result;
    }

    // Extrae los datos de una rutina por medio del id de un plan de entrenamiento
    public function getRoutineByTraining($idtraining){

        $connection = parent::getConnection();

        $json = array();

        $query = "SELECT * FROM tbactivity WHERE idtrainingplan = '".$idtraining."';";

        $result = mysqli_query($connection, $query);

        while($row = mysqli_fetch_array($result)){
            $json['list_data_routines'][] = $row;
        }

        mysqli_close($connection);

        return $json;
    }

    // Borra la rutina de un plan de entrenamiento
    public function deleteRoutineByTraining($idtraining, $idday){

        $connection = parent::getConnection();

        $query = "DELETE FROM tbactivity WHERE idday = '".$idday."' AND idtrainingplan = '".$idtraining."';";

        $result = mysqli_query($connection, $query);

        mysqli_close($connection);
        
        return $result;
    }

    // Actualiza la rutina de un plan de entrenamiento
    public function updateRoutine($activity, $idday, $idtraining){
        
        $connection = parent::getConnection();

        $query = "UPDATE tbactivity SET nameactivity = '".$activity->getName()."', repetitionsactivity = '".$activity->getRepetitions().
        "', breaksactivity = '".$activity->getBreaks()."', seriesactivity = '".$activity->getSeries()."', cadenceactivity = '".$activity->getCadence().
        "', weightactivity = '".$activity->getWeight()."' WHERE idday = '".$idday."' AND idtrainingplan = '".$idtraining."';";

        $result = mysqli_query($connection, $query);

        mysqli_close($connection);

        return $result;
    }

    // Extrae los planes de entrenamiento por el filtro del nombre
    public function getAllFilterPlanTraining($namePlan){
        
        // Inicio de conexion
        $conn = parent::getConnection();

        $query = "SELECT * FROM tbtrainingplan WHERE nametrainingplan LIKE '%".$namePlan."%'";

        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $data;
    }

    // Inserta un plan de entrenamiento a favoritos
    public function insertFavoritePlanTraining($idplan, $iduser){
        
        // Inicio de conexion
        $conn = parent::getConnection();

        $flag = true; $result = false;

        $queryConsult = "SELECT * FROM tbfavoriteplan WHERE idplan = '".$idplan."' AND iduser = '".$iduser."' AND typeplan = '1';";

        $resultConsult = mysqli_query($conn, $queryConsult);

        while ($row = mysqli_fetch_array($resultConsult)) { $flag = false; }

        if($flag){

            $queryGetLastId = "SELECT MAX(idfavoriteplan) AS idfavoriteplan FROM tbfavoriteplan";
            $idCont = mysqli_query($conn, $queryGetLastId);
            $nextId = 1;

            if ($row = mysqli_fetch_row($idCont)) {
                if(trim($row[0]) != null){
                    $nextId = trim($row[0]) + 1;
                }
            }

            // Prepara la consulta
            $queryInsert = "INSERT INTO tbfavoriteplan VALUES ('".$nextId."', '".$idplan."', '".$iduser."', '1');";

            // Ejecuta la consulta 
            $result = mysqli_query($conn, $queryInsert);
        }

        mysqli_close($conn); //cierra la conexion

        return $result;
    }

    // Extrae los planes favoritos de entrenamiento de un usuario
    public function getAllDataFavoritePlanNutrition($iduser){

        // Inicio de conexion
        $conn = parent::getConnection();

        $queryConsult = "SELECT * FROM tbfavoriteplan WHERE iduser = '".$iduser."' AND typeplan = '1';";

        $result = mysqli_query($conn, $queryConsult);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $data;
    }

    // Extrae los detalles de un plan de entrenamiento favorito
    public function getDataPlanByIdFavoritePlan($idfavoriteplan){
        
        // Inicio de conexion
        $conn = parent::getConnection();

        $idplan = 0; $data = '';
        $queryConsult = "SELECT idplan FROM tbfavoriteplan WHERE idfavoriteplan = '".$idfavoriteplan."';";
        $resultConsult = mysqli_query($conn, $queryConsult);
        while ($row = mysqli_fetch_array($resultConsult)) { $idplan = $row['idplan']; }

        $query = "SELECT * FROM tbtrainingplan WHERE idtrainingplan = '".$idplan."'";
        $result = mysqli_query($conn, $query);
        while ($row2 = mysqli_fetch_array($result)) {

            $data = $row2['idtrainingplan']."|".$row2['nametrainingplan']."|".$row2['qrcodetrainingplan'];
        }

        return $data;
    }

    // Elimina el plan de entrenamiento de un favorito
    public function deleteFavoritePlan($idfavoriteplan){
        
        // Inicio de conexion
        $conn = parent::getConnection();

        $query = "DELETE FROM tbfavoriteplan WHERE idfavoriteplan = '".$idfavoriteplan."' AND typeplan = '1';";
        $result = mysqli_query($conn, $query);

        return $result;
    }

    // Extrae los datos de actividad de un plan de entrenamientos
    public function getAllDataActivityTraining($idTrainingPlan){

        // Inicio de conexion
        $conn = parent::getConnection();

        $queryConsult = "SELECT * FROM tbactivity WHERE idtrainingplan = '".$idTrainingPlan."';";

        $result = mysqli_query($conn, $queryConsult);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $data;
    }
}
