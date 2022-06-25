<?php

require_once 'productCategoryBusiness.php';
require_once '../domain/productCategory.php';


if (isset($_POST['create'])) {
    if (isset($_POST['name']) && isset($_POST['description'])) {

        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $productCategoryBusiness = new ProductCategoryBusiness();
        $success = false;
        $message = "No se ha podido realizar el registro, por favor intente de nuevo";
        // no deberia ser necesario validar si existe el idProductCategory
        // ya que es un campo autoincrementable
        if ($productCategoryBusiness->insertProductCategory($name, $description)) {
            $success = true;
            $message = "Categoria de producto registrada correctamente";
        }
        else {
            $message = "No se ha podido realizar el registro, por favor intente de nuevo";
        }
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} elseif (isset($_POST['update'])) {
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description'])) {

        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $productCategoryBusiness = new ProductCategoryBusiness();
        $success = false;
        $message = "No se ha podido realizar la actualización de la categoría, por favor intente de nuevo";
        // verficamos que exista el id, si no existe, no se puede actualizar
        if ($productCategoryBusiness->verifyExistIdProductCategory($id)) {
            if ($productCategoryBusiness->updateProductCategory($id, $name, $description)) {
                $success = true;
                $message = "Categoría actualizada correctamente";
            }
        } else {
            $message = "La categoría no existe";
        }
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} elseif (isset($_POST['delete'])) {
    if (isset($_POST['id'])) {

        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $productCategoryBusiness = new ProductCategoryBusiness();
        $success = false;
        $message = "No se ha podido borrar la categoría, por favor intente de nuevo";
        // verificamos que exista el id, si no existe, no se puede borrar
        if ($productCategoryBusiness->verifyExistIdProductCategory($id)) {
            if ($productCategoryBusiness->deleteProductCategory($id)) {
                $success = true;
                $message = "Categoría borrada correctamente";
            }
        } else {
            $message = "La categoría no existe";
        }
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} elseif (isset($_POST['getProductCategory'])) {
    if (isset($_POST['id'])) {

        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $productCategoryBusiness = new ProductCategoryBusiness();
        $productCategory = $productCategoryBusiness->getProductCategory($id);
        $success = false;
        $message = "No se ha podido realizar el registro, por favor intente de nuevo";
        if ($productCategory != null) {
            $success = true;
            $message = "Categoría obtenida correctamente";
        }
        else{
            $message = "La categoría no existe";
        }
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message, "productCategory" => $productCategory);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} elseif (isset($_POST['getAllProductCategories'])) {
    $productCategoryBusiness = new ProductCategoryBusiness();
    $productCategories = $productCategoryBusiness->getAllProductCategories();
    $success = false;
    $message = "No se ha podido recuperar la lista de categorías, por favor intente de nuevo";
    // verificamos si es un array
    if (is_array($productCategories)) {
        $success = true;
        $message = "Categorías obtenidas correctamente";
    }
    else{
        $message = "No existen categorías";
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message, "productCategories" => $productCategories);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
}
