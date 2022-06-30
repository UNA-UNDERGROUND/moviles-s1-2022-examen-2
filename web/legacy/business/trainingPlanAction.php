<?php
require_once 'trainingPlanBusiness.php';
require_once '../domain/day.php';
require_once '../domain/activity.php';
require_once '../domain/trainingPlan.php';


if (isset($_POST['create'])){
    if (isset($_POST['trainingPlanName']) && isset($_POST['dataTrainingPlan'])){

        $trainingPlanName = filter_var($_POST['trainingPlanName'], FILTER_SANITIZE_STRING);
        $dataTrainingPlan = json_decode($_POST['dataTrainingPlan'], true);
        $array_days = [];
        $activity_objet = null;
        $array_activities = [];
        $array_days = [];
        $trainingPlanBusiness = new TrainingPlanBusiness();
        $success = false;
        $message = "No se ha podido realizar el registro, por favor intente de nuevo";
        foreach ($dataTrainingPlan as $day):
            $activities = json_decode($day['activities'], true);
            foreach($activities as $activity):
                foreach ($activity as $key => $val):
                    if (strcasecmp($key, "activity") == 0){
                        $activity_objet = new Activity($val, "", "", "", "", "");
                        $falg =true;
                    }
                    if (strcasecmp($key, "Repeticiones") == 0){
                        $activity_objet->setRepetitions($val);
                    }elseif (strcasecmp($key, "Descansos") == 0){
                        $activity_objet->setBreaks($val);
                    }elseif (strcasecmp($key, "Cadencia") == 0){
                        $activity_objet->setCadence($val);
                    }elseif (strcasecmp($key, "Peso") == 0){
                        $activity_objet->setWeight($val);
                    }elseif (strcasecmp($key, "Series") == 0){
                        $activity_objet->setSeries($val);
                    }
                endforeach;
                array_push($array_activities, $activity_objet);
            endforeach;
            $day = new Day($day['idDay'], $day['day'], $array_activities);
            $array_activities = [];
            array_push($array_days, $day);

        endforeach;
        $trainingPlan = new TrainingPlan($trainingPlanBusiness->getLastIdTrainingPlan(), $trainingPlanName, "qr", $array_days);
        $trainingPlanBusiness->generateQrTrainingPlan( "chinox701-" . $trainingPlan->getId() . "-" . $trainingPlan->getName(), json_encode($dataTrainingPlan));
        $trainingPlan->setQrCode("chinox701-" . $trainingPlan->getId() . "-" . $trainingPlan->getName());
        if ($trainingPlanBusiness->insert_training_plan($trainingPlan, "chinox701")){
            $success = true;
            $message = "Plan de entrenamiento registrado correctamente";
        }
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success"=>$success, "message"=>$message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
}elseif (isset($_POST['update'])){
    if (isset($_POST['trainingPlanName']) && isset($_POST['dataTrainingPlan']) && isset($_POST['idTrainingPlan'])){

        $trainingPlanName = filter_var($_POST['trainingPlanName'], FILTER_SANITIZE_STRING);
        $dataTrainingPlan = json_decode($_POST['dataTrainingPlan'], true);
        $idTrainingPlan = filter_var($_POST['idTrainingPlan'], FILTER_SANITIZE_STRING);

        $array_days = [];
        $activity_objet = null;
        $array_activities = [];
        $array_days = [];
        $trainingPlanBusiness = new TrainingPlanBusiness();
        $success = false;
        $message = "No se ha podido realizar la actualización del registro, por favor intente de nuevo";
        foreach ($dataTrainingPlan as $day):
            $activities = json_decode($day['activities'], true);
            foreach($activities as $activity):
                foreach ($activity as $key => $val):
                    if (strcasecmp($key, "activity") == 0){
                        $activity_objet = new Activity($val, "", "", "", "", "");
                        $falg =true;
                    }
                    if (strcasecmp($key, "Repeticiones") == 0){
                        $activity_objet->setRepetitions($val);
                    }elseif (strcasecmp($key, "Descansos") == 0){
                        $activity_objet->setBreaks($val);
                    }elseif (strcasecmp($key, "Cadencia") == 0){
                        $activity_objet->setCadence($val);
                    }elseif (strcasecmp($key, "Peso") == 0){
                        $activity_objet->setWeight($val);
                    }elseif (strcasecmp($key, "Series") == 0){
                        $activity_objet->setSeries($val);
                    }
                endforeach;
                array_push($array_activities, $activity_objet);
            endforeach;
            $day = new Day($day['idDay'], $day['day'], $array_activities);
            $array_activities = [];
            array_push($array_days, $day);
        endforeach;
        $trainingPlan = new TrainingPlan($idTrainingPlan, $trainingPlanName, "qr", $array_days);
        $trainingPlanBusiness->generateQrTrainingPlan( "chinox701-" . $trainingPlan->getId() . "-" . $trainingPlan->getName(), json_encode($dataTrainingPlan));
        $trainingPlan->setQrCode("chinox701-" . $trainingPlan->getId() . "-" . $trainingPlan->getName());
        if ($trainingPlanBusiness->updateTrainingPlan($trainingPlan)){
            $success = true;
            $message = "Plan de entrenamiento actualizado correctamente";
        }
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success"=>$success, "message"=>$message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
}elseif (isset($_POST['delete'])){
    if (isset($_POST['idTrainingPlan'])){
        $success = false;
        $message = "No se ha podido realizar la transacción, por favor intente de nuevo";
        $idTrainingPlan = filter_var($_POST['idTrainingPlan'], FILTER_SANITIZE_STRING);
        if (!empty($idTrainingPlan)){
            $trainingPlanBusiness = new TrainingPlanBusiness();
            $trainingPlan = $trainingPlanBusiness->getSpecificTrainingPlan($idTrainingPlan);
            if ($trainingPlanBusiness->deleteTrainingPlan($idTrainingPlan) && unlink("../resources/trainingPlansQr/" . $trainingPlan->getQrCode() . ".png")){
                $success = true;
                $message = "Elmiminado correctamente";
            }
        }
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success"=>$success, "message"=>$message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
}elseif (isset($_POST['getTrainingPlans'])){
    $trainingPlanBusiness = new TrainingPlanBusiness();
    $array_training_plan = $trainingPlanBusiness->getTrainingPlanList();
    header('Content-Type: application/json');
    $arrayInfo = array();
    for ($i = 0; $i < count($array_training_plan); $i++){
        $arrayAux = array("id"=>$array_training_plan[$i]->getId(), "name"=>$array_training_plan[$i]->getName(),
        "qrCode"=>$array_training_plan[$i]->getQrCode());
        array_push($arrayInfo, $arrayAux);
    }
    echo json_encode($arrayInfo);
}elseif (isset($_POST['getSpecificTrainingPlan'])){
    if (isset($_POST["idTrainingPlan"])){
        $idTrainingPlan = $_POST['idTrainingPlan'];
        if (!empty($idTrainingPlan)){
            $trainingPlanBusiness = new TrainingPlanBusiness();
            $trainingPlan = $trainingPlanBusiness->getSpecificTrainingPlan($idTrainingPlan);
            $array_days = $trainingPlan->getDays();
            $arrayInfo = [];
            for ($i = 0; $i < count($array_days); $i++){
                $array_activities = $array_days[$i]->getActivities();
                $array_activities_to_send = [];
                $stringJson = '[';
                for ($j = 0; $j < count($array_activities); $j++){
                    $stringJson .= '{"activity":"' . $array_activities[$j]->getName() . '","Repeticiones":"'. $array_activities[$j]->getRepetitions() . '", "Descansos":"' .
                        $array_activities[$j]->getBreaks() . '", "Series":"' . $array_activities[$j]->getSeries() . '", "Cadencia":"' . $array_activities[$j]->getCadence() . '", "Peso":"' . 
                        $array_activities[$j]->getWeight() . '"},';
                }
                $stringJson = substr($stringJson, 0, strlen($stringJson) - 1) . ']';
                array_push($array_activities, $array_activities_to_send);
                $arrayAux = array("idDay"=>$array_days[$i]->getId(), "day"=>$array_days[$i]->getName(), "activities"=>$stringJson);
                array_push($arrayInfo, $arrayAux);
            }
        }
    }
    header('Content-Type: application/json');
    echo json_encode($arrayInfo);
}
?>
