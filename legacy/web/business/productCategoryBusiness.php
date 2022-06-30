<?php

require_once '../data/productCategoryData.php';

class ProductCategoryBusiness
{

    private $dataProductCategory;

    public function __construct()
    {
        $this->dataProductCategory = new ProductCategoryData();
    }

    public function verifyExistIdProductCategory($idProductCategory)
    {
        return $this->dataProductCategory->verifyExistIdProductCategory($idProductCategory);
    }

    public function insertProductCategory($name, $description)
    {
        return $this->dataProductCategory->insertProductCategory($name, $description);
    }

    public function getProductCategory($idProductCategory)
    {
        return $this->dataProductCategory->getProductCategory($idProductCategory);
    }

    public function getAllProductCategories()
    {
        return $this->dataProductCategory->getAllProductCategories();
    }

    public function updateProductCategory($idProductCategory, $name, $description)
    {
        return $this->dataProductCategory->updateProductCategory($idProductCategory, $name, $description);
    }

    public function deleteProductCategory($idProductCategory)
    {
        return $this->dataProductCategory->deleteProductCategory($idProductCategory);
    }
}
