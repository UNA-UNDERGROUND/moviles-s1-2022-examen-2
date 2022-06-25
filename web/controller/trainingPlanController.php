<?php

$model_path = realpath(dirname(__FILE__) . '/../model');

// baseController.php
require_once "baseController.php";
// activity controller
require_once "activityController.php";
// ActivityController
require_once $model_path . "/activity.php";
// TrainingPlan
require_once $model_path . "/trainingPlan.php";

class TrainingPlanController extends BaseController
{

    private ActivityController $activityController;

    function __construct()
    {
        $this->activityController = new ActivityController();
        parent::__construct("training_plan");
    }

    public function getAll(): array
    {
        $rows = parent::select([]);
        $trainingPlans = [];
        foreach ($rows as $row) {
            $trainingPlans[]
                = $this->constructTrainingPlan($row, $this->activityController);
        }
        return $trainingPlans;
    }

    public function getById(int $id): TrainingPlan
    {
        $rows = parent::select(['id' => $id]);
        if (count($rows) == 0) {
            throw new Exception("TrainingPlan not found", 404);
        }
        return $this->constructTrainingPlan($rows[0], $this->activityController);
    }

    public function getByUsername(string $username): array
    {
        $rows = parent::select(['username' => $username]);
        $trainingPlans = [];
        foreach ($rows as $row) {
            $trainingPlans[]
                = $this->constructTrainingPlan($row, $this->activityController);
        }
        return $trainingPlans;
    }

    public function insertTrainingPlan(TrainingPlan $trainingPlan)
    {
        $values = $this->toSqlArray($trainingPlan);
        $id = parent::insert($values);
        $trainingPlan->setId($id);
        // insert activities
        foreach ($trainingPlan->getActivities() as $activity) {
            $activity->setIdTrainingPlan($id);
            $this->activityController->insertActivity($activity);
        }
        return $id;
    }

    public function updateTrainingPlan(TrainingPlan $trainingPlan)
    {
        $values = $this->toSqlArray($trainingPlan);
        $id = parent::update($values, $trainingPlan->getId());
        // update activities
        foreach ($trainingPlan->getActivities() as $activity) {
            $activity->setIdTrainingPlan($trainingPlan->getId());
            $this->activityController->updateActivity($activity);
        }
        return $id;
    }

    public function deleteTrainingPlan(TrainingPlan $trainingPlan)
    {
        return $this->deleteTrainingPlanById($trainingPlan->getId());
    }

    public function deleteTrainingPlanById(int $id)
    {
        // the activities of the training plan are deleted automatically
        // on cascade delete
        return parent::delete($id);
    }

    private function constructTrainingPlan(
        array $row,
        ActivityController $activityController = null
    ): TrainingPlan {
        $trainingPlan = TrainingPlan::fromArray($row);
        if ($activityController != null) {
            $activities = $activityController->getByTrainingPlanId($row['id']);
            $trainingPlan->setActivities($activities);
        }
        return $trainingPlan;
    }

    private function toSqlArray(TrainingPlan $trainingPlan): array
    {
        // convert to array not recursivelly
        return $trainingPlan->toArray(false);
    }
};
