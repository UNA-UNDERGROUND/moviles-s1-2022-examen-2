<?php

require_once "../../controller/trainingPlanController.php";

function sendResponse($response, $status = 200)
{
    header("Content-Type: application/json");
    // if is a JsonSerializableException put the error code and the message as the response
    if ($response instanceof JsonSerializableException) {
        $status = $response->getCode();
        $status = $status ? $status : 500;
        $response = $response->jsonSerialize();
    } else if ($response instanceof Throwable) {
        // check whether the response is an Throwable object
        $status = $response->getCode();
        $arr = [
            "Exception" => get_class($response),
            "Message" => $response->getMessage()
        ];
        // check if there is a inner exception
        if ($response->getPrevious()) {
            $arr['InnerException'] = $response->getPrevious()->getMessage();
        }

        $response = $arr;

        // set the http status code to the exception code, if not set, use 500
        $status = $status ? $status : 500;
    }

    http_response_code($status);
    echo json_encode($response);
    exit();
}

try {
    $controller = new TrainingPlanController();
    // check whether verb is beign used
    $verb = $_SERVER['REQUEST_METHOD'];
    $id = null;
    $trainingPlan = null;


    // initialize parameters
    if (
        $verb == "GET" ||
        $verb == "DELETE"
    ) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // check is is a valid integer
            if (!is_numeric($id)) {
                throw new Exception("Id must be a number", 422);
            }
            $id = intval($id);
        }
    } else if (
        $verb == "POST" ||
        $verb == "PUT"
    ) {
        // get the body of the request
        $body = file_get_contents('php://input');
        // decode the body of the request
        $json = json_decode($body, true);
        // check whether the body is a valid TrainingPlan object
        if ($json == null) {
            throw new Exception("Invalid TrainingPlan object", 400);
        }
        $trainingPlan = TrainingPlan::fromArray($json);
        // destroy the body of the request
        unset($body);
        unset($json);
    }


    if ($verb == "OPTIONS") {
        // show the allowed methods (GET, POST, PUT, DELETE, OPTIONS)
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Origin: *");
        exit();
    } else if ($verb == "GET") {
        $result = $id == null ? $controller->getAll() : $controller->getById($id);
    } else if ($verb == "POST") {
        $controller->insertTrainingPlan($trainingPlan);
        $result = $trainingPlan;
    } else if ($verb == "PUT") {
        $result = $controller->updateTrainingPlan($trainingPlan);
    } else if ($verb == "DELETE") {
        // check if there is a valid id
        if ($id == null) {
            throw new Exception("Missing Id", 409);
        }
        $trainingPlan = $controller->getById($id);
        $result = $controller->deleteTrainingPlan($trainingPlan);
    } else {
        throw new Exception("Method not allowed", 405);
    }
    sendResponse($result);
} catch (Throwable $e) {
    sendResponse($e);
}
