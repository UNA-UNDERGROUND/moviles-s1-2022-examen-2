<?php
    require_once 'trainingPlanBusiness.php';
    require_once '../domain/day.php';
    require_once '../domain/activity.php';
    require_once '../domain/trainingPlan.php';

    if(isset($_GET['action'])){

        $action = $_GET['action'];

        $trainingPlanBusiness = new TrainingPlanBusiness();

        if(strcmp($action, 'getNextIdTraining') == 0){

            // Extrae el siguiente id del plan de entrenamiento

            $jsonAction = 'action_get_next_idtraining';

            $json = $trainingPlanBusiness->getNextIdTraining();

            $jsoninfo = array();
            $jsoninfo['info'][0] = $jsonAction;
            $jsoninfo['info'][1] = $json;

            echo json_encode($jsoninfo);

        }else if(strcmp($action, 'insertTrainingPlan') == 0){

            // Registrar un plan de entrenamiento

            $jsonAction = 'action_insert_training';
            $jsonFlag = false;
            $jsonMessage = '';

            if(isset($_GET['codetraining']) && isset($_GET['nametraining'])){

                $idtraining = $_GET['codetraining'];
                $nametraining = $_GET['nametraining'];
                $username = $nametraining;

                $trainingPlan = new TrainingPlan($idtraining, $nametraining, $username.'-'.$idtraining.'-'.$nametraining, null);

                if($trainingPlanBusiness->insertOnlyTrainingPlan($trainingPlan)){

                    $jsonFlag = true;
                    $jsonMessage = "Plan entrenamiento registrado correctamente";
                }else{
                    $jsonMessage = 'Error en la escritura de datos';
                }
            }else{
                $jsonMessage = 'Error en la letura de datos';
            }

            $jsoninfo = array();
            $jsoninfo['info'][0] = $jsonAction;
            $jsoninfo['info'][1] = $jsonFlag;
            $jsoninfo['info'][2] = $jsonMessage;

            echo json_encode($jsoninfo);

        }else if(strcmp($action, 'getDataTraining') == 0){

            // Extrae los ids de entrenamiento

            $jsonAction = 'action_getdata_training';

            $json = $trainingPlanBusiness->getDataTraining();

            $jsoninfo = array();
            $jsoninfo['info'][0] = $jsonAction;
            $jsoninfo['info'][1] = $json;

            echo json_encode($jsoninfo);

        }else if(strcmp($action, 'insertRoutines') == 0){

            // Ingresa las rutinas de un plan de entrenamiento

            $jsonAction = 'action_insert_routine';
            $jsonFlag = false;
            $jsonMessage = '';

            $activity = new Activity($_GET['description'], $_GET['series'], $_GET['repetitions'], $_GET['weight'], 
            $_GET['cadence'], $_GET['breaks']);

            $idtraining = $_GET['idtraining']; $day = $_GET['day'];

            if(strcmp($day, 'Lunes') == 0){
                $day = 1;                
            }else if(strcmp($day, 'Martes') == 0){
                $day = 2;
            }else if(strcmp($day, 'Miércoles') == 0){
                 $day = 3;
            }else if(strcmp($day, 'Jueves') == 0){
                 $day = 4;
            }else if(strcmp($day, 'Viernes') == 0){
                $day = 5;
            }else if(strcmp($day, 'Sábado') == 0){
                $day = 6;
            }else{
                $day = 7;                
            }

            if($trainingPlanBusiness->insertOnlyRoutines($activity, $day, $idtraining)){
                $jsonFlag = true;
                $jsonMessage = "Rutina\Actividad registrada correctamente";
            }else{
                $jsonMessage = 'Error, el dia '.$_GET['day'].' ya esta registrado';
            }

            $jsoninfo = array();
            $jsoninfo['info'][0] = $jsonAction;
            $jsoninfo['info'][1] = $jsonFlag;
            $jsoninfo['info'][2] = $jsonMessage;

            echo json_encode($jsoninfo);

        }else if(strcmp($action, 'deleteTrainingPlan') == 0){

            $jsonAction = 'action_delete_training';
            $jsonFlag = false;
            $jsonMessage = '';

            if(isset($_GET['idtraining'])){

                $idtraining = $_GET['idtraining'];

                if(!empty($idtraining) && strlen($idtraining) > 0){
                    if($trainingPlanBusiness->deleteTrainingPlan($idtraining)){
                        $jsonFlag = true;
                        $jsonMessage = 'Plan de entrenamiento borrado correctamente';
                    }else{
                        $jsonMessage = 'Problema al eliminar en la BD';
                    }
                }else{
                    $jsonMessage = 'Datos referencia vacios para eliminar';
                }
            }else{
                $jsonMessage = 'Error en el envio de datos para eliminar';
            }

            $jsoninfo = array();
            $jsoninfo['info'][0] = $jsonAction;
            $jsoninfo['info'][1] = $jsonFlag;
            $jsoninfo['info'][2] = $jsonMessage;

            echo json_encode($jsoninfo);

        }else if(strcmp($action, 'getDataRoutineByIdTraining') == 0){

            // Extrae las rutinas de un plan de entrenamiento

            $jsonAction = 'action_getdata_routine';

            $idtraining = $_GET['idtraining'];

            $json = $trainingPlanBusiness->getRoutineByTraining($idtraining);

            $jsoninfo = array();
            $jsoninfo['info'][0] = $jsonAction;
            $jsoninfo['info'][1] = $json;

            echo json_encode($jsoninfo);

        }else if(strcmp($action, 'deleteRoutine') == 0){

            // Elimina la rutina de un plan de entrenamiento

            $jsonAction = 'action_delete_routine';
            $jsonFlag = false;
            $jsonMessage = '';
            
            if(isset($_GET['idtraining']) && isset($_GET['idday'])){

                $idtraining = $_GET['idtraining']; $idday = $_GET['idday'];

                if(!empty($idtraining) && !empty($idday) && strlen($idtraining) > 0 && strlen($idday) > 0){
                    if($trainingPlanBusiness->deleteRoutineByTraining($idtraining, $idday)){
                        $jsonFlag = true;
                        $jsonMessage = 'Rutina/Actividad eliminada correctamente';
                    }else{
                        $jsonMessage = 'Error al borrar en la BD';   
                    }
                }else{
                    $jsonMessage = 'Datos vacios al borrar';
                }
            }else{

                $jsonMessage = 'Error en el paso de datos al borrar';
            }

            $jsoninfo = array();
            $jsoninfo['info'][0] = $jsonAction;
            $jsoninfo['info'][1] = $jsonFlag;
            $jsoninfo['info'][2] = $jsonMessage;

            echo json_encode($jsoninfo);

        }else if(strcmp($action, 'updateRoutine') == 0){

            // Edita una rutina seleccionada

            $jsonAction = 'action_update_routine';
            $jsonFlag = false;
            $jsonMessage = '';

            $activity = new Activity($_GET['description'], $_GET['series'], $_GET['repetitions'], $_GET['weight'], 
            $_GET['cadence'], $_GET['breaks']);

            $idtraining = $_GET['idtraining']; $day = $_GET['day'];

            if($trainingPlanBusiness->updateRoutine($activity, $day, $idtraining)){
                $jsonFlag = true;
                $jsonMessage = "Rutina\Actividad actualizada correctamente";
            }else{
                $jsonMessage = 'Error al actualizar la rutina\actividad';
            }

            $jsoninfo = array();
            $jsoninfo['info'][0] = $jsonAction;
            $jsoninfo['info'][1] = $jsonFlag;
            $jsoninfo['info'][2] = $jsonMessage;

            echo json_encode($jsoninfo);
        }

    }else if(isset($_POST['searchDataFilterPlanTraining'])){ // CAMBIOS ACTUALES NUEVOS

        // Ingresa a extraer los datos de los planes por medio del filtro

        $namePlan = $_POST['searchDataFilterPlanTraining'];

        $trainingPlanBusiness = new TrainingPlanBusiness();

        $dataPlanFilter = $trainingPlanBusiness->getAllFilterPlanTraining($namePlan);

        // Envio de datos por medio del JSON
        header('Content-Type: application/json');
        $arrayInfo = array();
        $arrayAux = array("allPlanFilter"=>$dataPlanFilter);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);

    }else if(isset($_POST['insertFavoritePlanTraining'])){

        // Inserta un plan a una lista de favoritos a seguir

        $message = '';
        $success = false;
        $idplan = $_POST['idplan']; $iduser = $_POST['iduser'];
        
        $trainingPlanBusiness = new TrainingPlanBusiness();

        if($trainingPlanBusiness->insertFavoritePlanTraining($idplan, $iduser)){
            $success = true;
            $message = "Plan agregado a favoritos exitosamente";
        }else{
            $message = "Ya tienes el plan en favoritos";
        }

        header('Content-Type: application/json');
        $arrayInfo = array();
        $arrayAux = array("success"=>$success, "message"=>$message);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);

    }else if(isset($_POST['getAllFavoritePlanTraining'])){

        // Extrae los planes favoritos de un usuario

        $iduser = $_POST['getAllFavoritePlanTraining'];

        $trainingPlanBusiness = new TrainingPlanBusiness();

        $datafavoriteplan  = $trainingPlanBusiness->getAllDataFavoritePlanNutrition($iduser); // Extrae los planes favoritos

        // Envio de datos por medio del JSON
        header('Content-Type: application/json');
        $arrayInfo = array();
        $arrayAux = array("allDataPlanFavorite"=>$datafavoriteplan);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);

    }else if(isset($_POST['getAllDataPlanTraining'])){

        // Extrae los datos de un plan por medio de idfavoriteplan

        $idfavoriteplan = $_POST['getAllDataPlanTraining'];

        $trainingPlanBusiness = new TrainingPlanBusiness();

        $dataPlan = $trainingPlanBusiness->getDataPlanByIdFavoritePlan($idfavoriteplan);

        $idplan = explode('|',$dataPlan)[0];
        $name = explode('|',$dataPlan)[1];
        $codeqr = explode('|',$dataPlan)[2];

        // Envio de datos por medio del JSON
        header('Content-Type: application/json');
        $arrayInfo = array();
        $arrayAux = array("idplan"=>$idplan, "name"=>$name, "codeqr"=>$codeqr);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);

    }else if(isset($_POST['deleteFavoritePlanTraining'])){

        // Elimina plan favorito de un usuario

        $message = '';
        $success = false;

        $idfavoriteplan = $_POST['deleteFavoritePlanTraining'];

        $trainingPlanBusiness = new TrainingPlanBusiness();

        if($trainingPlanBusiness->deleteFavoritePlan($idfavoriteplan)){
            $success = true;
            $message = "Eliminado con exito";
        }else{
            $message = "Error al eliminar";
        }

        header('Content-Type: application/json');
        $arrayInfo = array();
        $arrayAux = array("success"=>$success, "message"=>$message);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);

    }else if(isset($_POST['getAllDataTraining'])){

        // Obtiene los detalles de un plan de entrenamiento

        $idTrainingPlan = $_POST['getAllDataTraining'];

        $trainingPlan = new TrainingPlanBusiness();

        $dataTraining = $trainingPlan->getAllDataActivityTraining($idTrainingPlan);

        // Envio de datos por medio del JSON
        header('Content-Type: application/json');
        $arrayInfo = array();
        $arrayAux = array("allDataTraining"=>$dataTraining);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);
    }
?>