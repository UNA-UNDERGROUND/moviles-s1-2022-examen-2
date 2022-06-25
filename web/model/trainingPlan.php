<?php


class TrainingPlan implements JsonSerializable{

    private int $id;

    public TrainingPlan(){
        
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
};