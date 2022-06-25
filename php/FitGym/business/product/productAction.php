<?php

$fitgym_path = realpath(dirname(__FILE__) . '/../../');

require_once 'productBusiness.php';
require_once '../../domain/product/product.php';

$success = false;
$message = "No se ha podido realizar el registro, por favor intente de nuevo";
//header('Content-Type: application/json');
$productBusiness = new ProductBusiness();
if (isset($_POST['create'])) {
    $exist_post_data =
        isset($_POST['idSubCategory']) &&
        isset($_POST['name']) &&
        isset($_POST['description']) &&
        isset($_POST['price']) &&
        isset($_POST['stock']);
    $exists_image = isset($_FILES['image']);

    if (
        $exist_post_data &&
        // check there is a file called image
        $exists_image
    ) {
        $idSubcategoryProduct = filter_var($_POST['idSubCategory'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
        $stock = filter_var($_POST['stock'], FILTER_SANITIZE_STRING);
        $image = file_get_contents($_FILES['image']['tmp_name']);
        // workarround for the non existent module for gym creation
        $legalDocument = null;
        if (isset($_POST['legalDocument'])) {
            $legalDocument = filter_var($_POST['legalDocument'], FILTER_SANITIZE_STRING);
        }
        // get the image file extension
        $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        // generate a new GUID for the image
        $image_guid = uniqid();
        // generate a new file name
        $image_name = $image_guid . '.' . $image_extension;
        // copy the image to /resources/img/product/(img_name)
        $image_path = $fitgym_path . '/resources/img/product/' . $image_name;
        // the web path to the image
        $image_res_path = 'resources/img/product/' . $image_name;
        copy($_FILES['image']['tmp_name'], $image_path);


        $arrayProducts = $productBusiness->getAllProducts($idSubcategoryProduct);
        $exist = false;
        for ($i = 0; $i < count($arrayProducts); $i++) {
            if (strcasecmp($arrayProducts[$i]->getName(), $name) == 0) {
                $exist = true;
                $i = count($arrayProducts);
            }
        }
        if (!$exist) {
            $product = new Product(
                null,
                $idSubcategoryProduct,
                $name,
                $description,
                $price,
                $stock,
                $image_res_path,
                $legalDocument
            );
            if ($productBusiness->insertProduct(
                $idSubcategoryProduct,
                $name,
                $description,
                $price,
                $stock,
                $image_res_path,
                $legalDocument
            )) {
                $success = true;
                $message = "Producto registrado correctamente";
            }
        } else {
            $message = "Este nombre de producto ya se encuentra registrado en esta categoría";
        }
    }

    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} elseif (isset($_POST['update'])) {
    $exist_post_data =
        isset($_POST['idProduct']) &&
        isset($_POST['idSubCategory']) &&
        isset($_POST['name']) &&
        isset($_POST['description']) &&
        isset($_POST['price']) &&
        isset($_POST['stock']);
    $exists_image = isset($_FILES['image']);
    if (
        $exist_post_data
    ) {
        $idProduct = filter_var($_POST['idProduct'], FILTER_SANITIZE_STRING);
        $idSubcategoryProduct = filter_var($_POST['idSubCategory'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
        $stock = filter_var($_POST['stock'], FILTER_SANITIZE_STRING);
        if ($exists_image) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
            // get the image file extension
            $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            // generate a new GUID for the image
            $image_guid = uniqid();
            // generate a new file name
            $image_name = $image_guid . '.' . $image_extension;
            // copy the image to /resources/img/product/(img_name)

            $image_path = $fitgym_path . '/resources/img/product/' . $image_name;
            // the web path to the image
            $image_res_path = 'resources/img/product/' . $image_name;
            copy($_FILES['image']['tmp_name'], $image_path);
        } else {
            $image_res_path = null;
        }

        $product = new Product(
            $idProduct,
            $idSubcategoryProduct,
            $name,
            $description,
            $price,
            $stock,
            $image_res_path,
            $legalDocument
        );
        if ($productBusiness->updateProduct(
            $idProduct,
            $idSubcategoryProduct,
            $name,
            $description,
            $price,
            $stock,
            $image_res_path,
            $legalDocument
        )) {
            $success = true;
            $message = "Producto actualizado correctamente";
        } else {
            $message = "No se ha podido actualizar el producto, por favor intente de nuevo";
        }
        $arrayInfo = array();
        $arrayAux = array("success" => $success, "message" => $message);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);
    }
} elseif (isset($_POST['delete'])) {
    if (isset($_POST['idProduct'])) {
        $idProduct = filter_var($_POST['idProduct'], FILTER_SANITIZE_STRING);
        if ($productBusiness->deleteProduct($idProduct)) {
            $success = true;
            $message = "Producto eliminado correctamente";
        } else {
            $message = "No se ha podido eliminar el producto, por favor intente de nuevo";
        }
        $arrayInfo = array();
        $arrayAux = array("success" => $success, "message" => $message);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);
    }
} elseif (isset($_POST['getProducts'])) {
    $arrayProducts = $productBusiness->getAllProducts();
    echo json_encode($arrayProducts);
} elseif (isset($_POST['getProduct'])) {
    if (isset($_POST['idProduct'])) {
        $idProduct = filter_var($_POST['idProduct'], FILTER_SANITIZE_STRING);
        $product = $productBusiness->getProduct($idProduct);
        $arrayInfo = array();
        array_push($arrayInfo, $product);
        echo json_encode($arrayInfo);
    }
} elseif (isset($_POST['getProductsBySubcategory'])) {
    if (isset($_POST['idSubCategoryProduct'])) {
        $idSubcategoryProduct = filter_var($_POST['idSubCategoryProduct'], FILTER_SANITIZE_STRING);
        $arrayProducts = $productBusiness->getAllProductsBySubCategory($idSubcategoryProduct);
        echo json_encode($arrayProducts);
    }
}
