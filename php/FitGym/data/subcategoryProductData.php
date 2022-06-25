<?php

include_once '../domain/productCategory.php';

require_once realpath(dirname(__FILE__)) . '../../vendor/una-ouroboros/DBoilerplate/MySqlConnectionProvider.php';

use una_ouroboros\DBoilerplate\MySqlConnectionProvider;

class SubcategoryProductData extends MySqlConnectionProvider
{
    // constructor
    function __construct()
    {
        parent::__construct("FitGym", "local");
    }


    public function insertSubCategoryProduct($subcategoryProduct, $idProductCategory)
    {
        $conn = parent::getConnection();
        $queryInsert = "INSERT INTO tbsubcategoryproduct (idcategoryproduct,namesubcategoryproduct,descriptionsubcategoryproduct) VALUES ('" . $idProductCategory . "','"
            . $subcategoryProduct->getName() . "','" . $subcategoryProduct->getDescription() . "');";
        $result = mysqli_query($conn, $queryInsert);

        mysqli_close($conn);
        return $result;
    }

    public function getSubCategoryProduct($idSubcategoryProduct)
    {
        $conn = parent::getConnection();

        $querySelect = "SELECT * FROM tbsubcategoryproduct WHERE idsubcategoryproduct = " . $idSubcategoryProduct;
        $result = mysqli_query($conn, $querySelect);

        $productCategory = null;

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_row($result);
            $productCategory = new ProductCategory($row[0], $row[2], $row[3]);
        }

        mysqli_close($conn);
        return $productCategory;
    }

    public function getAllSubCategoriesProduct($idProductCategory)
    {
        $conn = parent::getConnection();

        $querySelect = "SELECT * FROM tbsubcategoryproduct WHERE idcategoryproduct='" . $idProductCategory . "';";
        $result = mysqli_query($conn, $querySelect);

        $subcategoriesProduct = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $subcategoriesProduct[] = new ProductCategory($row[0], $row[2], $row[3]);
            }
        }

        mysqli_close($conn);
        return $subcategoriesProduct;
    }

    // recupera todas las subcategorias de un producto
    public function getAllSubCategoriesProductByProduct($idProductCategory)
    {
        $conn = parent::getConnection();
        

        $querySelect = "SELECT * FROM tbsubcategoryproduct" .
            "WHERE idcategoryproduct='{ $idProductCategory }';";
        $result = mysqli_query($conn, $querySelect);

        $subcategoriesProduct = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $subcategoriesProduct[] = new ProductCategory($row[0], $row[2], $row[3]);
            }
        }

        mysqli_close($conn);
        return $subcategoriesProduct;
    }

    public function getAllSubCategories(){
        $conn = parent::getConnection();
        

        $querySelect = "SELECT * FROM tbsubcategoryproduct;";
        $result = mysqli_query($conn, $querySelect);

        $subcategoriesProduct = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_row($result)) {
                $subcategoriesProduct[] = new ProductCategory($row[0], $row[2], $row[3]);
            }
        }

        mysqli_close($conn);
        return $subcategoriesProduct;
    }

    public function updateSubCategoryProduct($subcategoryProduct)
    {
        $conn = parent::getConnection();
        

        $queryUpdate = "UPDATE tbsubcategoryproduct SET namesubcategoryproduct = '" . $subcategoryProduct->getName() . "', descriptionsubcategoryproduct = '" . $subcategoryProduct->getDescription() . "' WHERE idsubcategoryproduct = " . $subcategoryProduct->getIdProductCategory();
        $result = mysqli_query($conn, $queryUpdate);

        mysqli_close($conn);
        return $result;
    }

    public function deleteSubCategoryProduct($idSubcategoryProduct)
    {
        $conn = parent::getConnection();
        

        $queryDelete = "DELETE FROM tbsubcategoryproduct WHERE idsubcategoryproduct = " . $idSubcategoryProduct;
        $result = mysqli_query($conn, $queryDelete);

        mysqli_close($conn);
        return $result;
    }
}
