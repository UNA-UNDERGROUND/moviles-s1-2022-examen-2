<?php
class Day{

    private $id;
    private $name;
    private $activities;

    public function __construct($id, $name, $activities){
        $this->id = $id;
        $this->name = $name;
        $this->activities = $activities;
    }

    public function setId( $id ){ $this->id = $id; }

    public function getId(){ return $this->id; }

    public function setName( $name ){ $this->name = $name; }

    public function getName(){ return $this->name; }

    public function setActivities( $activities ){ $this->activities = $activities; }

    public function getActivities(){ return $this->activities; }
}
?>