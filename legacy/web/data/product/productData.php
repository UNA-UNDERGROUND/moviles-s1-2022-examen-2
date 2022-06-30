<?php

$fitgympath = realpath(dirname(__FILE__) . '/../../');

require_once $fitgympath . '/vendor/una-ouroboros/DBoilerplate/MySqlConnectionProvider.php';
require_once $fitgympath . '/domain/product/product.php';

use una_ouroboros\DBoilerplate\MySqlConnectionProvider;


class ProductData extends MySqlConnectionProvider
{
    // constructor
    function __construct()
    {
        parent::__construct("FitGym", "local");
    }

    // verifica si ya existe un id de producto
    public function verifyExistIdProduct($idProduct)
    {
        // inicio de conexion
        $conn = parent::getConnection();

        $querySelect = "SELECT idproduct FROM tbproduct WHERE idproduct = " . $idProduct;
        $result = mysqli_query($conn, $querySelect);

        $flag = false;

        if (mysqli_num_rows($result) > 0) { // ingresa si nota que ya existe el id en la tabla
            $flag = true;
        }

        return $flag;
    }

    // crea un nuevo producto
    public function insertProduct(
        $idSubCategory,
        $name,
        $description,
        $price,
        $stock,
        $image,
        $legalDocument
    ) {
        // inicio de conexion
        $conn = parent::getConnection();

        $queryInsert = "INSERT INTO tbproduct" .
            " (idsubcategory,name,description,price,stock,image, legalDocument) VALUES" .
            "( '{$idSubCategory}','{$name}','{$description}',{$price},{$stock},'{$image}',{$legalDocument});";
        $result = mysqli_query($conn, $queryInsert);

        mysqli_close($conn);
        return $result;
    }

    // recupera un producto
    public function getProduct($idProduct)
    {
        // inicio de conexion
        $conn = parent::getConnection();

        $querySelect = "SELECT * FROM tbproduct WHERE idproduct = {$idProduct}";
        $result = mysqli_query($conn, $querySelect);

        $product = null;

        if (mysqli_num_rows($result) > 0) { // ingresa si nota que ya existe el id en la tabla
            $row = mysqli_fetch_row($result);
            $product = new Product(
                $row[0], // id
                $row[1], // idSubCategory
                $row[2], // name
                $row[3], // description
                $row[4], // price
                $row[5], // stock
                $row[6], // image
                $row[7]  // legalDocument
            );
        }

        mysqli_close($conn);
        return $product;
    }

    // recupera todos los productos
    public function getAllProducts()
    {
        // inicio de conexion
        $conn = parent::getConnection();

        $querySelect = "SELECT * FROM tbproduct";
        $result = mysqli_query($conn, $querySelect);

        $products = array();

        if (mysqli_num_rows($result) > 0) { // ingresa si nota que ya existe el id en la tabla
            while ($row = mysqli_fetch_row($result)) {
                $product = new Product(
                    $row[0], // id
                    $row[1], // idSubCategory
                    $row[2], // name
                    $row[3], // description
                    $row[4], // price
                    $row[5], // stock
                    $row[6], // image
                    $row[7]  // legalDocument
                );
                array_push($products, $product);
            }
        }

        mysqli_close($conn);
        return $products;
    }

    // recupera todos los productos de una subcategoria
    public function getAllProductsBySubCategory($idSubCategory)
    {
        // inicio de conexion
        $conn = parent::getConnection();

        $querySelect = "SELECT * FROM tbproduct WHERE idsubcategory= {$idSubCategory}";
        $result = mysqli_query($conn, $querySelect);

        $products = array();

        if (mysqli_num_rows($result) > 0) { // ingresa si nota que ya existe el id en la tabla
            while ($row = mysqli_fetch_row($result)) {
                $product = new Product(
                    $row[0], // id
                    $row[1], // idSubCategory
                    $row[2], // name
                    $row[3], // description
                    $row[4], // price
                    $row[5], // stock
                    $row[6], // image
                    $row[7]  // legalDocument
                );
                array_push($products, $product);
            }
        }

        mysqli_close($conn);
        return $products;
    }

    // actualiza un producto
    public function updateProduct(
        $idProduct,
        $idSubCategory,
        $name,
        $description,
        $price,
        $stock,
        $image,
        $legalDocument,
    ) {
        // inicio de conexion
        $conn = parent::getConnection();


        $queryUpdate = "UPDATE tbproduct SET " .
            "idsubcategory = '{$idSubCategory}'," .
            "name = '{$name}'," .
            "description = '{$description}'," .
            "price = {$price}," .
            "stock = {$stock},".
            "legalDocument = '{$legalDocument}'";
        if ($image != null) {
            $queryUpdate .= ",image = '{$image}'";
        }
        $queryUpdate .= " WHERE idproduct = {$idProduct}";
        $result = mysqli_query($conn, $queryUpdate);

        mysqli_close($conn);
        return $result;
    }

    // elimina un producto
    public function deleteProduct($idProduct)
    {
        // inicio de conexion
        $conn = parent::getConnection();

        $queryDelete = "DELETE FROM tbproduct WHERE idproduct = {$idProduct}";
        $result = mysqli_query($conn, $queryDelete);

        mysqli_close($conn);
        return $result;
    }
}
