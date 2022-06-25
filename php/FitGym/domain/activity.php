<?php

class Activity{
    
    private $name;
    private $series;
    private $repetitions;
    private $weight;
    private $cadence;
    private $breaks;

    public function __construct($name, $series, $repetitions, $weight, $cadence, $breaks){
        $this->name = $name;
        $this->series = $series;
        $this->repetitions = $repetitions;
        $this->weight = $weight;
        $this->cadence = $cadence;
        $this->breaks = $breaks;
    }

    public function setName( $name ){ $this->name = $name; }

    public function getName(){ return $this->name; }

    public function setSeries( $series ){ $this->series = $series; }

    public function getSeries(){ return $this->series; }

    public function setRepetitions( $repetitions ){ $this->repetitions = $repetitions; } 

    public function getRepetitions(){ return $this->repetitions; }

    public function setWeight( $weight ){ $this->weight = $weight; }

    public function getWeight(){ return $this->weight; }

    public function setCadence( $cadence ){ $this->cadence = $cadence; }

    public function getCadence(){ return $this->cadence; }

    public function setBreaks( $breaks ){ $this->breaks = $breaks; }

    public function getBreaks(){ return $this->breaks; }
}
?>