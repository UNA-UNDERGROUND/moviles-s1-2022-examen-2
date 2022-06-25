<?php


// baseController.php
require_once "baseController.php";
// Activity
require_once "../model/activity.php";


class ActivityController extends BaseController
{

    function __construct()
    {
        parent::__construct("activity");
    }

    public function getAll(): array
    {
        $rows = parent::select([]);
        $activities = [];
        foreach ($rows as $row) {
            $activities[] = $this->constructActivity($row);
        }
        return $activities;
    }

    public function getById(int $id): Activity
    {
        $rows = parent::select(['id' => $id]);
        if (count($rows) == 0) {
            throw new Exception("Activity not found");
        }
        return $this->constructActivity($rows[0]);
    }

    // get the activities of a training plan
    public function getByTrainingPlanId(int $id): array
    {
        $rows = parent::select(['id_training_plan' => $id]);
        $activities = [];
        foreach ($rows as $row) {
            $activities[] = $this->constructActivity($row);
        }
        return $activities;
    }

    public function insertActivity(Activity $activity)
    {
        $values = $this->toSqlArray($activity);
        $id = parent::insert($values);
        $activity->setId($id);
        return $id;
    }

    public function updateActivity(Activity $activity)
    {
        $values = $this->toSqlArray($activity);
        $id = parent::update($values, $activity->getId());
        return $id;
    }

    public function deleteActivity(Activity $activity)
    {
        return $this->deleteActivityById($activity->getId());
    }

    public function deleteActivityById(int $id)
    {
        $id = parent::delete($id);
        return $id;
    }



    private function constructActivity(array $row): Activity
    {
        // rename id_training_plan to idTrainingPlan
        $row['idTrainingPlan'] = $row['id_training_plan'];
        // remove id_training_plan
        unset($row['id_training_plan']);
        // create the activity (from array)
        return Activity::fromArray($row);
    }

    private function toSqlArray(Activity $activity): array
    {
        $arr = $activity->toArray();
        // rename idTrainingPlan to id_training_plan
        $arr['id_training_plan'] = $arr['idTrainingPlan'];
        // remove idTrainingPlan
        unset($arr['idTrainingPlan']);
        // return the array
        return $arr;
    }
}
