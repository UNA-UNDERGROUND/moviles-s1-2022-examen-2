<?php
require_once "plan.php";

class TrainingPlan extends Plan{
    private $days;

    public function __construct($id, $name, $qrCode, $days){
        parent::__construct($id, $name, $qrCode);
        $this->days = $days;
    }

    public function setDays( $days ){ $this->days = $days; }

    public function getDays(){ return $this->days; }
}    
?>