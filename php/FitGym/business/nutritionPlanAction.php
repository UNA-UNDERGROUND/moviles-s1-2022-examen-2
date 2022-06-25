<?php

require_once '../domain/nutritionPlan.php';
require_once '../domain/nutritionPlanDetails.php';
require_once '../business/nutritionPlanBusiness.php';
require_once '../business/logicGenerateNutritionalPlanQr.php';

if (isset($_POST['create'])) {

    $action = $_POST['create'];

    $success = 0;
    $message = "";

    if (strcasecmp($action, "Crear") == 0) { // Ingresa a registrar datos del plan de nutricion

        if (
            isset($_POST['idNutrition']) &&
            isset($_POST['nutritionDescription']) // && 

        ) {

            $nutritionPlanBusiness = new NutritionPlanBusiness();

            // Variables a usar vacias para datos de plan de nutricion

            $idNutrition = '';
            $nutritionDescription = '';
            $selectDay = null;
            $foodTime = null;

            // Contiene los datos enviados por el usuario

            $idNutrition = $_POST['idNutrition'];
            $nutritionDescription = $_POST['nutritionDescription'];
            if (
                isset($_POST['selectDay']) &&
                isset($_POST['foodTime'])
            ) {
                $selectDay = $_POST['selectDay'];
                $foodTime = $_POST['foodTime'];
            }


            if (
                strlen($idNutrition) > 0 &&
                strlen($nutritionDescription) > 0

            ) {

                if ($nutritionPlanBusiness->verifyExistIdNutritionPlan($idNutrition)) { // Ingresa si ya existe el id en el plan de nutricion
                    if (

                        $selectDay != null &&
                        $foodTime != null &&
                        strlen($selectDay) > 0  &&
                        strlen($foodTime) > 0
                    ) {
                        if ($nutritionPlanBusiness->verifyExistDayAndFoodTime(
                            $idNutrition,
                            $selectDay,
                            $foodTime
                        )) {
                            $message = "Ya se registró antes el día " . $selectDay . " con el tiempo de comida de " . $foodTime;
                        } else {

                            $nutritionPlanDetails = new NutritionPlanDetails(0, $idNutrition, $selectDay, $foodTime, $nutritionDescription);

                            $result = $nutritionPlanBusiness->insertDetailsNutritionPlan($nutritionPlanDetails);

                            if ($result == 1) {

                                $message = "Registro exitoso";
                                $success = 1;
                            } else {

                                $message = "Error al registrar en la base de datos";
                            }
                        }
                    } else {
                        $message = "Seleccione un día y un tiempo de comida para el plan de nutrición";
                    }
                } else { // Ingresa por que no existe el id en el plan de nutricion

                    $logicGenerateNutritionalPlanQr = new LogicGenerateNutritionalPlanQr();

                    // Genera y almacena el nombre de la imagen QR del plan de nutricion
                    $routeQR = $logicGenerateNutritionalPlanQr->generateCodeQrNutritional($idNutrition);

                    $nameImage = "Plan de nutricion #" . $idNutrition;

                    $nutritionPlan = new NutritionPlan($idNutrition, $nameImage, $routeQR);

                    // Ingresa los datos del plan de nutricion
                    $result = $nutritionPlanBusiness->insertNutritionPlan($nutritionPlan);

                    if (
                        $result == 1
                    ) {
                        if (
                            $selectDay != null &&
                            $foodTime != null
                        ) {
                            $nutritionPlanDetails = new NutritionPlanDetails(0, $idNutrition, $selectDay, $foodTime, $nutritionDescription);

                            // Ingresa los datos de los detalles del plan de nutricion
                            $result = $nutritionPlanBusiness->insertDetailsNutritionPlan($nutritionPlanDetails);

                            if ($result == 1) {

                                $message = "Registro exitoso";
                                $success = 1;
                            } else {

                                $message = "Error al registrar en la base de datos";
                            }
                        } else {
                            $message = "registro exitoso";
                        }
                    } else {

                        $message = "Error al registrar en la base de datos";
                    }
                }
            } else {

                // ---- Indica que la informacion de examenes y analisis radiograficos viene completamente vacia en los issets ----

                $message = "LLene al menos un campo del formulario";
            }
        }

        header('Content-Type: application/json');
        $arrayInfo = array();
        $arrayAux = array("success" => $success, "message" => $message);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);
    }
} else if (isset($_POST['update'])) { // Modifica la descripcion del detalle de un plan de nutricion seleccionado

    $action = $_POST['update'];

    $success = 0;
    $message = "";

    if (strcasecmp($action, "Actualizar") == 0) {

        if (isset($_POST['nutritionDescription']) && isset($_POST['idDetailNutritionPlan'])) {

            $nutritionPlanBusiness = new NutritionPlanBusiness();

            // Variables a usar vacias para datos de plan de nutricion

            $idDetailNutritionPlan = '';
            $nutritionDescription = '';

            // Contiene los datos enviados por el usuario

            $idDetailNutritionPlan = $_POST['idDetailNutritionPlan'];
            $nutritionDescription = $_POST['nutritionDescription'];

            if (strlen($idDetailNutritionPlan) > 0 || strlen($nutritionDescription) > 0) {

                $result = $nutritionPlanBusiness->updateNutritionPlanDetail($idDetailNutritionPlan, $nutritionDescription);

                if ($result == 1) {

                    $message = "Actualización exitosa";
                    $success = 1;
                } else {

                    $message = "Error al actualizar en la base de datos";
                }
            }
        }

        header('Content-Type: application/json');
        $arrayInfo = array();
        $arrayAux = array("success" => $success, "message" => $message);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);
    }
} else if (isset($_GET['delete'])) {

    $action = $_GET['delete'];
    $idDetailNutritionPlan = null;
    $day = null;
    $idNutritionPlan = null;
    if (isset($_GET['idDetailNutritionPlan'])) {
        $idDetailNutritionPlan = $_GET['idDetailNutritionPlan'];
    }
    if (
        isset($_GET['day']) &&
        isset($_GET['idNutritionPlan'])
    ) {
        $day = $_GET['day'];
        $idNutritionPlan = $_GET['idNutritionPlan'];
    }

    $message = $action;
    $success = false;
    $nutritionPlanBusiness = new NutritionPlanBusiness();
    if (strcasecmp($action, "Eliminar") == 0) {

        if (isset($_GET['idDetailNutritionPlan'])) {

            if (
                $idDetailNutritionPlan != null &&
                strlen($idDetailNutritionPlan) > 0
            ) {

                $result = $nutritionPlanBusiness->deleteNutritionPlanDetail($idDetailNutritionPlan);
                if ($result == 1) {
                    $message = "Se borraron los datos";
                    $success = true;
                } else {
                    $message = "Error al borrar en la base de datos";
                }
            }
        } else if (
            $day != null &&
            $idNutritionPlan != null &&
            strlen($day) > 0 &&
            strlen($idNutritionPlan) > 0
        ) {
            $result = $nutritionPlanBusiness->deleteNutritionPlanDetailByDay($idNutritionPlan, $day);
            if ($result == 1) {
                $message = "Se borraron los datos";
                $success = true;
            } else {
                $message = "Error al borrar en la base de datos";
            }
        } else {
            $message = "no se indico ningun parametro";
        }
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);

    //header("Location:".$_SERVER[HTTP_REFERER]);


} else if (isset($_GET['deleteFullNutrition'])) {

    $action = $_GET['deleteFullNutrition'];

    $message = $action;
    $success = false;

    if (strcasecmp($action, "Eliminar") == 0) {

        $nutritionPlanBusiness = new NutritionPlanBusiness();

        $idNutritionPlan = $_GET['idNutritionPlan'];

        if (strlen($idNutritionPlan) > 0) {

            // Obtiene la direccion del codigo qr para borrar la imagen QR
            $directionCodeQR = $nutritionPlanBusiness->extractDirCodeQr($idNutritionPlan);

            // Elimina los detalles de un plan de nutricion y el propio plan tambien
            $result = $nutritionPlanBusiness->deleteAllNutritionPlan($idNutritionPlan);

            if ($result == 1) {

                // Borra la imagen de codigo QR una ves borrado los datos del plan de nutricion de la base de datos
                if ($directionCodeQR != null) {
                    unlink($directionCodeQR);
                }
                $success = true;
                $message = "Se borraron los datos";
            } else {
                $message = "Error al borrar en la base de datos";
            }
        }
    }

    header('Content-Type: application/json');
    $arrayInfo = array("success" => $success, "message" => $message);
    echo json_encode($arrayInfo);

    //header("Location:".$_SERVER[HTTP_REFERER]);

} else if (isset($_POST['searchDataFilterPlanNutrition'])) {

    // Ingresa a extraer los datos de los planes por medio del filtro

    $namePlan = $_POST['searchDataFilterPlanNutrition'];

    $nutritionPlanBusiness = new NutritionPlanBusiness();

    $dataPlanFilter = $nutritionPlanBusiness->getAllFilterPlanNutrition($namePlan);

    // Envio de datos por medio del JSON
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("allPlanFilter" => $dataPlanFilter);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} else if (isset($_POST['insertFavoritePlanNutrition'])) {

    // Inserta un plan a una lista de favoritos a seguir

    $message = '';
    $success = false;
    $idplan = $_POST['idplan'];
    $iduser = $_POST['iduser'];

    $nutritionPlanBusiness = new NutritionPlanBusiness();

    if ($nutritionPlanBusiness->insertFavoritePlan($idplan, $iduser)) {
        $success = true;
        $message = "Plan agregado a favoritos exitosamente";
    } else {
        $message = "Ya tienes el plan en favoritos";
    }

    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} else if (isset($_POST['getAllFavoritePlanNutrition'])) {

    // Extrae los planes favoritos de un usuario

    $iduser = $_POST['getAllFavoritePlanNutrition'];

    $nutritionPlanBusiness = new NutritionPlanBusiness();

    $datafavoriteplan  = $nutritionPlanBusiness->getAllDataFavoritePlanNutrition($iduser); // Extrae los planes favoritos

    // Envio de datos por medio del JSON
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("allDataPlanFavorite" => $datafavoriteplan);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} else if (isset($_POST['getAllDataPlanNutrition'])) {

    // Extrae los datos de un plan por medio de idfavoriteplan

    $idfavoriteplan = $_POST['getAllDataPlanNutrition'];

    $nutritionPlanBusiness = new NutritionPlanBusiness();

    $dataPlan = $nutritionPlanBusiness->getDataPlanByIdFavoritePlan($idfavoriteplan);

    $idplan = explode('-', $dataPlan)[0];
    $name = explode('-', $dataPlan)[1];
    $codeqr = explode('-', $dataPlan)[2];

    // Envio de datos por medio del JSON
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("idplan" => $idplan, "name" => $name, "codeqr" => $codeqr);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} else if (isset($_POST['deleteFavoritePlanNutrition'])) {

    // Elimina plan favorito de un usuario

    $message = '';
    $success = false;

    $idfavoriteplan = $_POST['deleteFavoritePlanNutrition'];

    $nutritionPlanBusiness = new NutritionPlanBusiness();

    if ($nutritionPlanBusiness->deleteFavoritePlan($idfavoriteplan)) {
        $success = true;
        $message = "Eliminado con exito";
    } else {
        $message = "Error al eliminar";
    }

    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} else if (isset($_GET['action'])) {

    // Se aplican partes para el WEB SERVICE - ANDROID

    $action = $_GET['action'];

    $nutritionPlanBusiness = new NutritionPlanBusiness();

    if (strcmp($action, 'getDataNutrition') == 0) {

        // Extrae los datos de nutricion

        $jsonAction = 'action_getdata_nutrition';

        $json = $nutritionPlanBusiness->getDataNutritionWS();

        $jsoninfo = array();
        $jsoninfo['info'][0] = $jsonAction;
        $jsoninfo['info'][1] = $json;

        echo json_encode($jsoninfo);
    } else if ($action == 'getDataNutritionPlan') {
        $idPlan = null;
        if (isset($_GET['idPlan'])) {
            $idPlan = $_GET['idPlan'];
        }
        $data = $nutritionPlanBusiness->getDataNutrition();
        if ($idPlan != null) {
            for ($i = 0; $i < count($data); $i++) {
                $nutritionPlan = $data[$i];
                if ($nutritionPlan->getIdNutritionPlan() == $idPlan) {
                    $data = $data[$i];
                    break;
                }
            }
        }
        $json = json_encode($data);
        echo $json;
    }
}
