<?php

class ProductCategory implements JsonSerializable{
    private $idproductcategory;
    private $name;
    private $description;
    private $subcategories;

    function __construct($idproductcategory, $name, $description){
        $this->idproductcategory = $idproductcategory;
        $this->name = $name;
        $this->description = $description;
    }
    
    // GETTERS
    function getIdProductCategory(){
        return $this->idproductcategory; // id de la categoria de producto
    }
    function getName(){
        return $this->name; // nombre de la categoria de producto
    }
    function getDescription(){
        return $this->description; // descripcion de la categoria de producto
    }
    function getSubcategories(){
        return $this->subcategories;
    }
    // SETTERS
    function setIdProductCategory($idproductcategory){
        $this->idproductcategory = $idproductcategory; // id de la categoria de producto
    }
    function setName($name){
        $this->name = $name; // nombre de la categoria de producto
    }
    function setDescription($description){
        $this->description = $description; // descripcion de la categoria de producto
    }
    function setSubcategories($subcategories){
        $this->subcategories = $subcategories;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->idproductcategory,
            'name' => $this->name,
            'description' => $this->description,
            'subcategories' => $this->subcategories
        ];
    }
}

?>