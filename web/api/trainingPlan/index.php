<?php

require_once "../../controller/trainingPlanController.php";

function sendResponse($response, $status = 200)
{
    header("Content-Type: application/json");
    // check whether the response is an Throwable object
    if ($response instanceof Throwable) {
        $status = $response->getCode();
        $response = [
            "Exception" => get_class($response),
            "Message" => $response->getMessage(),
            "InnerException" => $response->getPrevious() ? $response->getPrevious()->getMessage() : null,
        ];
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
        sendResponse($result);
    } else if ($verb == "POST") {
        $result = $controller->insertTrainingPlan($body);
        sendResponse($result);
    } else if ($verb == "PUT") {
        $result = $controller->updateTrainingPlan($body);
        sendResponse($result);
    } else if ($verb == "DELETE") {
        $result = $controller->deleteTrainingPlan($id);
        sendResponse($result);
    } else {
        throw new Exception("Method not allowed", 405);
    }
} catch (Throwable $e) {
    sendResponse($e);
}
