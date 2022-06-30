<?php
require_once 'subcategoryProductBusiness.php';
require_once '../domain/productCategory.php';

if (isset($_POST['create'])) {
    if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['idCategory'])) {

        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $idCategory = filter_var($_POST['idCategory'], FILTER_SANITIZE_STRING);
        $subcategoryProductBusiness = new SubcategoryProductBusiness();
        $arraySubcategories = $subcategoryProductBusiness->getAllSubCategoriesProduct($idCategory);
        $success = $exist = false;
        $message = "No se ha podido realizar el registro, por favor intente de nuevo";
        for ($i = 0; $i < count($arraySubcategories); $i++) {
            if (strcasecmp($arraySubcategories[$i]->getName(), $name) == 0) {
                $exist = true;
                $i = count($arraySubcategories);
            }
        }
        if (!$exist) {
            $subcategoryProduct = new ProductCategory(0, $name, $description);
            if ($subcategoryProductBusiness->insertSubCategoryProduct($subcategoryProduct, $idCategory)) {
                $success = true;
                $message = "SubCategoria de producto registrada correctamente";
            }
        } else {
            $message = "Este nombre de subcategoría ya se encuentra registrado en esta categoría";
        }
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} elseif (isset($_POST['update'])) {
    if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['idCategory']) && isset($_POST['idSubcategoryProduct'])) {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $idCategory = filter_var($_POST['idCategory'], FILTER_SANITIZE_STRING);
        $idSubCategory = filter_var($_POST['idSubcategoryProduct'], FILTER_SANITIZE_STRING);
        $subcategoryProductBusiness = new SubcategoryProductBusiness();
        $arraySubcategories = $subcategoryProductBusiness->getAllSubCategoriesProduct($idCategory);
        $success = $exist = false;
        $message = "No se ha podido realizar la actualización, por favor intente de nuevo";
        for ($i = 0; $i < count($arraySubcategories); $i++) {
            if (strcasecmp($arraySubcategories[$i]->getName(), $name) == 0 && $arraySubcategories[$i]->getIdProductCategory() != $idSubCategory) {
                $exist = true;
                $i = count($arraySubcategories);
            }
        }
        if (!$exist) {
            $subcategoryProduct = new ProductCategory($idSubCategory, $name, $description);
            if ($subcategoryProductBusiness->updateSubCategoryProduct($subcategoryProduct)) {
                $success = true;
                $message = "SubCategoria de producto actualizada correctamente";
            }
        } else {
            $message = "Este nombre de subcategoría ya se encuentra registrado en esta categoría";
        }
    }
    header('Content-Type: application/json');
    $arrayInfo = array();
    $arrayAux = array("success" => $success, "message" => $message);
    array_push($arrayInfo, $arrayAux);
    echo json_encode($arrayInfo);
} elseif (isset($_POST['delete'])) {
    if (isset($_POST['idSubcategoryProduct']) && isset($_POST['idCategory'])) {
        $id = filter_var($_POST['idSubcategoryProduct'], FILTER_SANITIZE_STRING);
        $idCategory = filter_var($_POST['idCategory'], FILTER_SANITIZE_STRING);
        $subcategoryProductBusiness = new SubcategoryProductBusiness();
        $arraySubcategories = $subcategoryProductBusiness->getAllSubCategoriesProduct($idCategory);
        $success = false;
        $message = "No se ha podido eliminar la Subcategoría, por favor intente de nuevo";
        for ($i = 0; $i < count($arraySubcategories); $i++) {
            if ($arraySubcategories[$i]->getIdProductCategory() == $id) {
                $exist = true;
                $i = count($arraySubcategories);
            }
        }
        if ($exist) {
            if ($subcategoryProductBusiness->deleteSubCategoryProduct($id)) {
                $success = true;
                $message = "Subcategoría eliminada correctamente";
            }
        } else {
            $message = "La Subcategoría que desea eliminar no existe";
        }
        header('Content-Type: application/json');
        $arrayInfo = array();
        $arrayAux = array("success" => $success, "message" => $message);
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);
    }
} elseif (isset($_POST['getSubcategories'])) {
    if (isset($_POST['idCategory'])) {
        $idProductCategory = $_POST["idCategory"];
        $subcategoryProductBusiness = new SubcategoryProductBusiness();
        $arraySubcategories = $subcategoryProductBusiness->getAllSubCategoriesProduct($idProductCategory);
        header('Content-Type: application/json');
        $arrayInfo = array();
        for ($i = 0; $i < count($arraySubcategories); $i++) {
            $arrayAux = array(
                "id" => $arraySubcategories[$i]->getIdProductCategory(), "name" => $arraySubcategories[$i]->getName(),
                "description" => $arraySubcategories[$i]->getDescription()
            );
            array_push($arrayInfo, $arrayAux);
        }
        echo json_encode($arrayInfo);
    } else {
        //no se ha seleccionado una categoria
    }
} elseif (isset($_POST['getSubCategory'])) {
    if (isset($_POST['idSubCategoryProduct'])) {
        $idSubcategoryProduct = $_POST['idSubCategoryProduct'];
        $subcategoryProductBusiness = new SubcategoryProductBusiness();
        $subcategoryProduct = $subcategoryProductBusiness->getSubCategoryProduct($idSubcategoryProduct);
        header('Content-Type: application/json');
        $arrayInfo = array();
        $arrayAux = array(
            "id" => $subcategoryProduct->getIdProductCategory(), "name" => $subcategoryProduct->getName(),
            "description" => $subcategoryProduct->getDescription()
        );
        array_push($arrayInfo, $arrayAux);
        echo json_encode($arrayInfo);
    } else {
        echo json_encode(array("success" => false, "message" => "No se ha seleccionado una subcategoría"));
        //no se ha seleccionado una categoria
    }
} elseif (isset($_POST['getAllSubCategories'])) {
    $subcategoryProductBusiness = new SubcategoryProductBusiness();
    $arraySubcategories = $subcategoryProductBusiness->getAllSubCategories();
    header('Content-Type: application/json');
    $arrayInfo = array();
    $message = "";
    for ($i = 0; $i < count($arraySubcategories); $i++) {
        $arrayAux = array(
            "id" => $arraySubcategories[$i]->getIdProductCategory(), "name" => $arraySubcategories[$i]->getName(),
            "description" => $arraySubcategories[$i]->getDescription()
        );
        array_push($arrayInfo, $arrayAux);
    }
    $arrayRes = array("success" => true, "message" => $message, "data" => $arrayInfo);
    echo json_encode($arrayRes);
}
