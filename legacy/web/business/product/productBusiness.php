<?php

require_once '../../data/product/productData.php';

class ProductBusiness
{

    private $dataProduct;

    public function __construct()
    {
        $this->dataProduct = new ProductData();
    }

    public function insertProduct(
        $idSubCategory,
        $name,
        $description,
        $price,
        $stock,
        $image,
        $legalDocument
    ) {
        return $this->dataProduct->insertProduct(
            $idSubCategory,
            $name,
            $description,
            $price,
            $stock,
            $image,
            $legalDocument
        );
    }

    public function getProduct($idProduct)
    {
        return $this->dataProduct->getProduct($idProduct);
    }

    public function getAllProducts()
    {
        return $this->dataProduct->getAllProducts();
    }

    public function getAllProductsBySubCategory($idSubCategory)
    {
        return $this->dataProduct->getAllProductsBySubCategory($idSubCategory);
    }

    public function updateProduct(
        $idProduct,
        $idSubCategory,
        $name,
        $description,
        $price,
        $stock,
        $image,
        $legalDocument
    ) {
        return $this->dataProduct->updateProduct(
            $idProduct,
            $idSubCategory,
            $name,
            $description,
            $price,
            $stock,
            $image,
            $legalDocument
        );
    }

    public function deleteProduct($idProduct)
    {
        return $this->dataProduct->deleteProduct($idProduct);
    }
}
