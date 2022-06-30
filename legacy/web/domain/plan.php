<?php
class Plan{
    private $id;
    private $name;
    private $qrCode;

    public function __construct($id, $name, $qrCode){
        $this->id = $id;
        $this->name = $name;
        $this->qrCode = $qrCode;
    }

    public function setId( $id ){ $this->id = $id; }

    public function getId(){ return $this->id; }

    public function setName( $name ){ $this->name = $name; }

    public function getName(){ return $this->name; }

    public function setQrCode( $qrCode ){ $this->qrCode = $qrCode; }

    public function getQrCode(){ return $this->qrCode; }
}
?>