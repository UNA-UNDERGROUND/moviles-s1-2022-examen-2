<?php

include_once '../domain/nutritionPlan.php';
include_once '../domain/nutritionPlanDetails.php';

$path_dboilerplate = realpath(dirname(__FILE__) . '/../vendor/una-ouroboros/DBoilerplate') . '/';
require_once $path_dboilerplate . 'MySqlConnectionProvider.php';

use una_ouroboros\DBoilerplate\MySqlConnectionProvider;

class NutritionPlanData extends MySqlConnectionProvider
{

    // constructor
    function __construct()
    {
        parent::__construct("FitGym", "local");
    }

    // Verifica si ya existe un id registrado en el plan de nutricion

    public function verifyExistIdNutritionPlan($idNutritionPlan)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $querySelect = "SELECT idnutritionplan FROM tbnutritionplan WHERE idnutritionplan = " . $idNutritionPlan;
        $result = mysqli_query($conn, $querySelect);

        $flag = false;

        if (mysqli_num_rows($result) > 0) { // Ingresa si nota que ya existe el id en la tabla

            $flag = true;
        }

        return $flag;
    }

    // Verifica si ya existe el dia con el tiempo de comida juntos en un plan de nutricion

    public function verifyExistDayAndFoodTime($idNutritionPlan, $selectDay, $foodTime)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $querySelect = "SELECT * FROM tbnutritionplandetails WHERE idnutritionplan = " . $idNutritionPlan;
        $result = mysqli_query($conn, $querySelect);

        $flag = false;

        if (mysqli_num_rows($result) > 0) { // Ingresa si nota que ya existe el id en la tabla

            while ($row = mysqli_fetch_row($result)) {

                $fDay = $row[2];
                $fTime = $row[3];

                if (strcasecmp($fDay, $selectDay) == 0 && strcasecmp($fTime, $foodTime) == 0) {

                    $flag = true;
                }
            }
        }

        return $flag;
    }

    // Registra detalles de un plan de nutricion en la base de datos

    public function insertDetailsNutritionPlan($nutritionPlanDetails)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $queryGetLastId = "SELECT MAX( idnutritionplandetails ) AS idnutritionplandetails  FROM tbnutritionplandetails";
        $idCont = mysqli_query($conn, $queryGetLastId);
        $nextId = 1;

        if ($row = mysqli_fetch_row($idCont)) {
            if (trim($row[0]) != null) {
                $nextId = trim($row[0]) + 1;
            }
        }

        $queryInsert = "INSERT INTO tbnutritionplandetails (idnutritionplandetails, idnutritionplan,foodday,foodtime,description) VALUES ('" . $nextId .
            "','" . $nutritionPlanDetails->getIdNutritionPlan() . "', '" . $nutritionPlanDetails->getFoodDay() . "', '" . $nutritionPlanDetails->getFoodTime() .
            "', '" . $nutritionPlanDetails->getDescription() . "')";

        //ejecuta la consulta 
        $result = mysqli_query($conn, $queryInsert);

        mysqli_close($conn); //cierra la conexion

        return $result;
    }

    // Registra un nuevo plan de nutricion en la base de datos

    public function insertNutritionPlan($nutritionPlan)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $queryInsert = "INSERT INTO tbnutritionplan (idnutritionplan , name, imagecodeqr) VALUES ('" . $nutritionPlan->getIdNutritionPlan() .
            "', '" . $nutritionPlan->getName() . "', '" . $nutritionPlan->getImagecodeqr() . "')";

        //ejecuta la consulta 
        $result = mysqli_query($conn, $queryInsert);

        mysqli_close($conn); //cierra la conexion

        return $result;
    }

    // Metodo para obtener los planes de nutricion registrados

    public function getNutritionPlans()
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $query = "SELECT idnutritionplan, name, imagecodeqr FROM tbnutritionplan";

        $result = mysqli_query($conn, $query);
        mysqli_close($conn);
        $nutritionalPlans = [];

        while ($row = mysqli_fetch_array($result)) {

            $currentNutritionalPlans = new NutritionPlan($row['idnutritionplan'], $row['name'], $row['imagecodeqr']);

            array_push($nutritionalPlans, $currentNutritionalPlans);
        }

        return $nutritionalPlans;
    }

    // Metodo para obtener los detalles de un plan de nutricion

    public function getAllDetailsNutritionPlan($idNutritionPlan)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $query = "SELECT * FROM tbnutritionplandetails WHERE idnutritionplan = '" . $idNutritionPlan . "'";

        $result = mysqli_query($conn, $query);
        mysqli_close($conn);
        $nutritionalPlanDetails = [];

        while ($row = mysqli_fetch_array($result)) {

            $currentNutritionPlanDetails = new NutritionPlanDetails(
                $row['idnutritionplandetails'],
                $row['idnutritionplan'],
                $row['foodday'],
                $row['foodtime'],
                $row['description']
            );

            array_push($nutritionalPlanDetails, $currentNutritionPlanDetails);
        }

        return $nutritionalPlanDetails;
    }

    // Metodo para obtener el datelle de una instruccion en un plan de nutricion

    public function getDetailNutrition($idNutritionPlanDetails)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $query = "SELECT * FROM tbnutritionplandetails WHERE idnutritionplandetails  = '" . $idNutritionPlanDetails . "'";

        $result = mysqli_query($conn, $query);
        mysqli_close($conn);

        while ($row = mysqli_fetch_array($result)) {

            $currentNutritionPlanDetails = new NutritionPlanDetails(
                $row['idnutritionplandetails'],
                $row['idnutritionplan'],
                $row['foodday'],
                $row['foodtime'],
                $row['description']
            );
        }

        return $currentNutritionPlanDetails;
    }

    // Metodo para actualizar un plan de nutricion seleccionado

    public function updateNutritionPlanDetail($idDetailNutritionPlan, $nutritionDescription)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $queryUpdate = "UPDATE tbnutritionplandetails SET description = '" . $nutritionDescription . "' WHERE idnutritionplandetails = " . $idDetailNutritionPlan . ";";

        //ejecucion de la consulta
        $result = mysqli_query($conn, $queryUpdate);

        //cierre de la conexion
        mysqli_close($conn);

        return $result;
    }

    // Metodo para borra los detalles de un plan de nutricion

    public function deleteNutritionPlanDetail($idDetailNutritionPlan)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $queryDelete = "DELETE FROM tbnutritionplandetails WHERE idnutritionplandetails = " . $idDetailNutritionPlan . ";";

        //ejecucion de la consulta
        $result = mysqli_query($conn, $queryDelete);

        //cierre de la conexion
        mysqli_close($conn);

        return $result;
    }

    // Metodo para borra los detalles de un plan de nutricion por dia

    public function deleteNutritionPlanDetailByDay($idNutritionPlan, $day)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $queryDelete = "DELETE FROM tbnutritionplandetails ".
        "WHERE idnutritionplan = " . $idNutritionPlan . " ".
        "and foodday = '" . $day . "';";

        //ejecucion de la consulta
        $result = mysqli_query($conn, $queryDelete);

        //cierre de la conexion
        mysqli_close($conn);

        return $result;
    }

    // Metodo para extraer la direccion del codigo QR de un plan de nutricion para ser borrada

    public function extractDirCodeQr($idNutritionPlan)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $query = "SELECT imagecodeqr FROM tbnutritionplan WHERE idnutritionplan   = '" . $idNutritionPlan . "'";

        $result = mysqli_query($conn, $query);
        $currentCodQR = null;
        while ($row = mysqli_fetch_array($result)) {
            $currentCodQR = $row['imagecodeqr'];
        }
        mysqli_close($conn);
        return $currentCodQR;
    }

    // Metodo para borra TODO un plan de nutricion

    public function deleteAllNutritionPlan($idNutritionPlan)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        // Borra los detalles de dia y tiempo de comida de un plan de nutricion
        $queryDeleteDetailsNutrition = "DELETE FROM tbnutritionplandetails WHERE idnutritionplan = " . $idNutritionPlan . ";";

        //ejecucion de la consulta
        $result1 = mysqli_query($conn, $queryDeleteDetailsNutrition);


        // Borra los planes de nutricion (EN GENERAL)
        $queryDeleteNutrition = "DELETE FROM tbnutritionplan WHERE idnutritionplan = " . $idNutritionPlan . ";";

        //ejecucion de la consulta
        $result2 = mysqli_query($conn, $queryDeleteNutrition);

        //cierre de la conexion
        mysqli_close($conn);

        if ($result1 && $result2) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    // Metodo para extraer planes de nutricion por medio de un filtro

    public function getAllFilterPlanNutrition($namePlan)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $query = "SELECT * FROM tbnutritionplan WHERE name LIKE '%" . $namePlan . "%'";

        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $data;
    }

    // Metodo para registrar un plan a favoritos

    public function insertFavoritePlan($idplan, $iduser)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $flag = true;
        $result = false;

        $queryConsult = "SELECT * FROM tbfavoriteplan WHERE idplan = '" . $idplan . "' AND iduser = '" . $iduser . "' AND typeplan = '2';";

        $resultConsult = mysqli_query($conn, $queryConsult);

        while ($row = mysqli_fetch_array($resultConsult)) {
            $flag = false;
        }

        if ($flag) {

            $queryGetLastId = "SELECT MAX(idfavoriteplan) AS idfavoriteplan FROM tbfavoriteplan";
            $idCont = mysqli_query($conn, $queryGetLastId);
            $nextId = 1;

            if ($row = mysqli_fetch_row($idCont)) {
                if (trim($row[0]) != null) {
                    $nextId = trim($row[0]) + 1;
                }
            }

            // Prepara la consulta
            $queryInsert = "INSERT INTO tbfavoriteplan VALUES ('" . $nextId . "', '" . $idplan . "', '" . $iduser . "', '2');";

            // Ejecuta la consulta 
            $result = mysqli_query($conn, $queryInsert);
        }

        mysqli_close($conn); //cierra la conexion

        return $result;
    }

    // Metodo para extraer planes favorito por medio de id de usuario

    public function getAllDataFavoritePlanNutrition($iduser)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $queryConsult = "SELECT * FROM tbfavoriteplan WHERE iduser = '" . $iduser . "' AND typeplan = '2';";

        $result = mysqli_query($conn, $queryConsult);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $data;
    }

    // Metodo para extraer los datos del propio plan

    public function getDataPlanByIdFavoritePlan($idfavoriteplan)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $idplan = 0;
        $data = '';
        $queryConsult = "SELECT idplan FROM tbfavoriteplan WHERE idfavoriteplan = '" . $idfavoriteplan . "';";
        $resultConsult = mysqli_query($conn, $queryConsult);
        while ($row = mysqli_fetch_array($resultConsult)) {
            $idplan = $row['idplan'];
        }

        $query = "SELECT * FROM tbnutritionplan WHERE idnutritionplan = '" . $idplan . "'";
        $result = mysqli_query($conn, $query);
        while ($row2 = mysqli_fetch_array($result)) {

            $data = $row2['idnutritionplan'] . "-" . $row2['name'] . "-" . $row2['imagecodeqr'];
        }

        return $data;
    }

    // Metodo para elimar el plan favorito de un usuario

    public function deleteFavoritePlan($idfavoriteplan)
    {

        // Inicio de conexion
        $conn = parent::getConnection();
        

        $query = "DELETE FROM tbfavoriteplan WHERE idfavoriteplan = '" . $idfavoriteplan . "' AND typeplan = '2';";
        $result = mysqli_query($conn, $query);

        return $result;
    }

    // Metodo para extraer los planes de entrenamiento por WS
    public function getDataNutritionWS(){
        
        $conn = parent::getConnection();

        $json = array();

        $query = "SELECT * FROM tbnutritionplan";

        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_array($result)){
            $json['list_data_nutrition'][] = $row;
        }

        mysqli_close($conn);

        return $json;
    }

    // Metodo para extraer los planes de entrenamiento por WS
    public function getDataNutrition(){
        
        $conn = parent::getConnection();

        $json = array();

        $query = "SELECT * FROM tbnutritionplan";

        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_array($result)){
            // add a new person into the array
            $nutritionPlan = new NutritionPlan(
                $row["idnutritionplan"],
                $row["name"],
                $row["imagecodeqr"]
            );
            // get the days of the plan
            $queryDays 
                = "SELECT * FROM tbnutritionplandetails ".
                "WHERE idnutritionplan = " . $row["idnutritionplan"] . ";";
            $resultDays = mysqli_query($conn, $queryDays);
            $days = array();
            while($rowDays = mysqli_fetch_array($resultDays)){
                $day = $rowDays["foodday"];
                $time = array(
                    "idnutritionplandetails" => $rowDays["idnutritionplandetails"],
                    "time" => $rowDays["foodtime"],
                    "description" => $rowDays["description"]
                );
                if(in_array($day, $days)){
                    $index = array_search($day, $days);
                    $days[$index]["times"][] = $time;
                } else {
                    $days[] = array(
                        "day" => $day,
                        "times" => array($time)
                    );
                }
            }
            
            $nutritionPlan->setDays($days);
            $json[] = $nutritionPlan;
        }

        mysqli_close($conn);

        return $json;
    }
}
