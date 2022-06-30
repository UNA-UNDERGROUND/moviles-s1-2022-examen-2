<?php

class Product implements JsonSerializable
{
    private $idproduct;
    private $idsubcategory;
    private $name;
    private $description;
    private $price;
    private $stock;
    private $image;
    private $legalDocument;

    function __construct(
        $idproduct,
        $idsubcategory,
        $name,
        $description,
        $price,
        $stock,
        $image,
        $legalDocument
    ) {
        $this->idproduct = $idproduct;
        $this->idsubcategory = $idsubcategory;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->image = $image;
        // workarround for the non existent module for gym creation
        $this->legalDocument = $legalDocument;
    }

    // GETTERS
    function getIdProduct()
    {
        return $this->idproduct; // id del producto
    }
    function getIdSubcategory()
    {
        return $this->idsubcategory; // id de la subcategoria
    }
    function getName()
    {
        return $this->name; // nombre del producto
    }
    function getDescription()
    {
        return $this->description; // descripcion del producto
    }
    function getPrice()
    {
        return $this->price; // precio del producto
    }
    function getStock()
    {
        return $this->stock; // stock del producto
    }
    function getImage()
    {
        return $this->image; // imagen del producto
    }
    function getLegalDocument()
    {
        return $this->legalDocument; // documento legal del producto
    }
    // SETTERS
    function setIdProduct($idproduct)
    {
        $this->idproduct = $idproduct; // id del producto
    }
    function setIdSubcategory($idsubcategory)
    {
        $this->idsubcategory = $idsubcategory; // id de la subcategoria
    }
    function setName($name)
    {
        $this->name = $name; // nombre del producto
    }
    function setDescription($description)
    {
        $this->description = $description; // descripcion del producto
    }
    function setPrice($price)
    {
        $this->price = $price; // precio del producto
    }
    function setStock($stock)
    {
        $this->stock = $stock; // stock del producto
    }
    function setImage($image)
    {
        $this->image = $image; // imagen del producto
    }
    function setLegalDocument($legalDocument)
    {
        $this->legalDocument = $legalDocument; // documento legal del producto
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->idproduct,
            'idsubcategory' => $this->idsubcategory,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $this->image,
            // workarround for the non existent module for gym creation
            'legalDocument' => $this->legalDocument
        ];
    }
}
