<?php

require_once('common.php');

class Activity implements JsonSerializable
{
    private int $id;
    private int $idTrainingPlan;
    private string $day;
    private string $name;
    private string $repetitions;
    private string $breaks;
    private string $series;
    private string $cadence;
    private string $weight;

    public function __construct(
        int $id,
        int $idTrainingPlan,
        string $day,
        string $name,
        string $repetitions,
        string $breaks,
        string $series,
        string $cadence,
        string $weight
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
        if ($this->idTrainingPlan != 1) {
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
