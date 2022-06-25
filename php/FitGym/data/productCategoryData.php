<?php

require_once '../domain/productCategory.php';

$path_dboilerplate = realpath(dirname(__FILE__).'/../vendor/una-ouroboros/DBoilerplate').'/';
require_once $path_dboilerplate. 'MySqlConnectionProvider.php';

use una_ouroboros\DBoilerplate\MySqlConnectionProvider;

class ProductCategoryData extends MySqlConnectionProvider
{
    // constructor
    function __construct()
    {
        parent::__construct("FitGym", "local");
    }

    // verifica si ya existe un id de categoria de producto
    public function verifyExistIdProductCategory($idProductCategory)
    {
        // inicio de conexion
        $conn = parent::getConnection();

        $querySelect = "SELECT idproductcategory FROM tbproductcategory WHERE idproductcategory = " . $idProductCategory;
        $result = mysqli_query($conn, $querySelect);

        $flag = false;

        if (mysqli_num_rows($result) > 0) { // ingresa si nota que ya existe el id en la tabla
            $flag = true;
        }

        return $flag;
    }

    // crea una nueva categoria de producto
    public function insertProductCategory($name, $description)
    {
        // inicio de conexion
        $conn = parent::getConnection();

        $queryInsert = "INSERT INTO tbproductcategory (nameproductcategory,descriptionproductcategory) VALUES ('" . $name . "','" . $description . "');";
        $result = mysqli_query($conn, $queryInsert);

        mysqli_close($conn);
        return $result;
    }
    // recupera una categoria de producto
    public function getProductCategory($idProductCategory)
    {
        // inicio de conexion
        $conn = parent::getConnection();

        $querySelect = "SELECT * FROM tbproductcategory WHERE idproductcategory = " . $idProductCategory;
        $result = mysqli_query($conn, $querySelect);

        $productCategory = null;

        if (mysqli_num_rows($result) > 0) { // ingresa si nota que ya existe el id en la tabla
            $row = mysqli_fetch_row($result);
            $productCategory = new ProductCategory($row[0], $row[1], $row[2]);
        }

        mysqli_close($conn);
        return $productCategory;
    }
    // recupera todas las categorias de producto
    public function getAllProductCategories()
    {
        // inicio de conexion
        $conn = parent::getConnection();

        $querySelect = "SELECT * FROM tbproductcategory";
        $result = mysqli_query($conn, $querySelect);

        $productCategories = array();

        if (mysqli_num_rows($result) > 0) { // ingresa si nota que ya existe el id en la tabla
            while ($row = mysqli_fetch_row($result)) {
                $productCategories[] = new ProductCategory($row[0], $row[1], $row[2]);
            }
        }

        mysqli_close($conn);
        return $productCategories;
    }
    // recupera todas las categorias de producto segun el el id del gimnasio
    // TODO: por el momento llama a getAllProductCategories
    public function getAllProductCategoriesByIdGym($idGym)
    {
        return $this->getAllProductCategories();
    }

    // actualiza una categoria de producto
    public function updateProductCategory($idProductCategory, $name, $description)
    {
        // inicio de conexion
        $conn = parent::getConnection();
        $queryUpdate = "UPDATE tbproductcategory SET nameproductcategory = '" . $name . "', descriptionproductcategory = '" . $description . "' WHERE idproductcategory = " . $idProductCategory;
        $result = mysqli_query($conn, $queryUpdate);

        mysqli_close($conn);
        return $result;
    }

    // elimina una categoria de producto
    public function deleteProductCategory($idProductCategory)
    {
        // inicio de conexion
        $conn = parent::getConnection();

        $queryDelete = "DELETE FROM tbproductcategory WHERE idproductcategory = " . $idProductCategory;
        $result = mysqli_query($conn, $queryDelete);

        mysqli_close($conn);
        return $result;
    }
}
