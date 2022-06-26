<?php

require_once('common.php');

class Activity implements JsonSerializable
{
    private int $id;
    private int $idTrainingPlan;
    private string $day;
    private string $name;
    private int $repetitions;
    private int $breaks;
    private int $series;
    private int $cadence;
    private int $weight;

    public function __construct(
        int $id,
        int $idTrainingPlan,
        string $day,
        string $name,
        int $repetitions,
        int $breaks,
        int $series,
        int $cadence,
        int $weight
    ) {
        $this->id = $id;
        $this->idTrainingPlan = $idTrainingPlan;
        $this->day = $day;
        $this->name = $name;
        $this->repetitions = $repetitions;
        $this->breaks = $breaks;
        $this->series = $series;
        $this->cadence = $cadence;
        $this->weight = $weight;
        $this->validate();
    }

    // validate the object fields
    private function validate()
    {
        $invalidFields = [];
        // both id and idTrainingPlan are optional
        // check if day is a valid day
        // valid values are ['S', 'M', 'T', 'W', 'R', 'F', 'U']
        // which correspond to:
        // Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday
        if (!in_array($this->day, ['S', 'M', 'T', 'W', 'R', 'F', 'U'])) {
            $invalidFields[] = [
                'field' => 'day',
                'message' => 'Invalid day type',
                'value' => $this->day,
                'expected' => ['S', 'M', 'T', 'W', 'R', 'F', 'U'],
            ];
        }
        // check if name is not blank(empty or only whitespace)
        if (isBlank($this->name)) {
            $invalidFields[] = [
                'field' => 'name',
                'message' => 'Name cannot be blank',
                'value' => $this->name,
                'example values' => ['Push-up', 'Pull-up', 'Squat'],
            ];
        }
        // check if repetitions is greater than 0
        if ($this->repetitions <= 0) {
            $invalidFields[] = [
                'field' => 'repetitions',
                'message' => 'Repetitions must be greater than 0',
                'value' => $this->repetitions
            ];
        }
        // check if breaks is non negative
        if ($this->breaks < 0) {
            $invalidFields[] = [
                'field' => 'breaks',
                'message' => 'Breaks must be non negative',
                'value' => $this->breaks
            ];
        }
        // check if series is non negative
        if ($this->series < 0) {
            $invalidFields[] = [
                'field' => 'series',
                'message' => 'Series must be non negative',
                'value' => $this->series
            ];
        }
        // check if cadence is non negative
        if ($this->cadence < 0) {
            $invalidFields[] = [
                'field' => 'cadence',
                'message' => 'Cadence must be non negative',
                'value' => $this->cadence
            ];
        }
        // check if weight is non negative
        if ($this->weight < 0) {
            $invalidFields[] = [
                'field' => 'weight',
                'message' => 'Weight must be non negative',
                'value' => $this->weight
            ];
        }
        if (count($invalidFields) > 0) {
            throw new InvalidFieldsException($invalidFields, 'Activity');
        }
    }

    // getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdTrainingPlan(): int
    {
        return $this->idTrainingPlan;
    }

    public function getDay(): string
    {
        return $this->day;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRepetitions(): string
    {
        return $this->repetitions;
    }

    public function getBreaks(): string
    {
        return $this->breaks;
    }

    public function getSeries(): string
    {
        return $this->series;
    }

    public function getCadence(): string
    {
        return $this->cadence;
    }

    public function getWeight(): string
    {
        return $this->weight;
    }

    // setters

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setIdTrainingPlan(int $idTrainingPlan): void
    {
        $this->idTrainingPlan = $idTrainingPlan;
    }

    public function setDay(string $day): void
    {
        $this->day = $day;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setRepetitions(string $repetitions): void
    {
        $this->repetitions = $repetitions;
    }

    public function setBreaks(string $breaks): void
    {
        $this->breaks = $breaks;
    }

    public function setSeries(string $series): void
    {
        $this->series = $series;
    }

    public function setCadence(string $cadence): void
    {
        $this->cadence = $cadence;
    }

    public function setWeight(string $weight): void
    {
        $this->weight = $weight;
    }



    public function jsonSerialize(): mixed
    {
        $rows = $this->toArray();
        // remove idTrainingPlan
        unset($rows['idTrainingPlan']);
        return $rows;
    }

    public function toArray(): array
    {
        $arr = [
            'day' => $this->day,
            'name' => $this->name,
            'repetitions' => $this->repetitions,
            'breaks' => $this->breaks,
            'series' => $this->series,
            'cadence' => $this->cadence,
            'weight' => $this->weight,
        ];
        if ($this->id != -1) {
            $arr['id'] = $this->id;
        }
        if ($this->idTrainingPlan != -1) {
            $arr['idTrainingPlan'] = $this->idTrainingPlan;
        }
        return $arr;
    }

    public static function fromArray(array $arr): Activity
    {
        // check if one of the required fields is missing
        $missing_params = array();
        if (!isset($arr['id'])) {
            $arr['id'] = -1;
        }
        if (!isset($arr['idTrainingPlan'])) {
            $arr['idTrainingPlan'] = -1;
        }
        if (!isset($arr['day'])) {
            $missing_params[] = 'day';
        }
        if (!isset($arr['name'])) {
            $missing_params[] = 'name';
        }
        if (!isset($arr['repetitions'])) {
            $missing_params[] = 'repetitions';
        }
        if (!isset($arr['breaks'])) {
            $missing_params[] = 'breaks';
        }
        if (!isset($arr['series'])) {
            $missing_params[] = 'series';
        }
        if (!isset($arr['cadence'])) {
            $missing_params[] = 'cadence';
        }
        if (!isset($arr['weight'])) {
            $missing_params[] = 'weight';
        }
        if (count($missing_params) > 0) {
            // get the type of this class (static method)
            $class = get_called_class();
            // throw exception
            throw new MissingParameterException($arr, $missing_params, $class);
        }

        // the following fields must be integers
        // [repetitions, breaks, series, cadence, weight]
        $int_params = array('repetitions', 'breaks', 'series', 'cadence', 'weight');
        $invalidFields = array();
        foreach ($int_params as $param) {
            if (!is_int($arr[$param])) {
                $invalidFields[] = [
                    'field' => $param,
                    'message' => "$param must be an integer",
                    'value' => $arr[$param]
                ];
            }
        }
        if (count($invalidFields) > 0) {
            throw new InvalidFieldsException($invalidFields, 'Activity');
        }


        return new Activity(
            $arr["id"],
            $arr["idTrainingPlan"],
            $arr["day"],
            $arr["name"],
            $arr["repetitions"],
            $arr["breaks"],
            $arr["series"],
            $arr["cadence"],
            $arr["weight"]
        );
    }
};
