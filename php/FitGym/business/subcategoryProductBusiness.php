<?php

require_once '../data/subcategoryProductData.php';

class SubcategoryProductBusiness{

    private $dataSubCategoryProduct;

    public function __construct(){
        $this->dataSubCategoryProduct = new SubcategoryProductData();
    }


    public function insertSubCategoryProduct($subcategoryProduct, $idProductCategory){
        return $this->dataSubCategoryProduct->insertSubCategoryProduct($subcategoryProduct, $idProductCategory);
    }

    public function getSubCategoryProduct($idSubcategoryProduct){
        return $this->dataSubCategoryProduct->getSubCategoryProduct($idSubcategoryProduct);
    }

    public function getAllSubCategoriesProduct($idProductCategory){
        return $this->dataSubCategoryProduct->getAllSubCategoriesProduct($idProductCategory);
    }
    public function getAllSubCategories(){
        return $this->dataSubCategoryProduct->getAllSubCategories();
    }

    public function updateSubCategoryProduct($subcategoryProduct){
        return $this->dataSubCategoryProduct->updateSubCategoryProduct($subcategoryProduct);
    }

    public function  deleteSubCategoryProduct($idSubcategoryProduct){
        return $this->dataSubCategoryProduct-> deleteSubCategoryProduct($idSubcategoryProduct);
    }
}
