<?php
// Activity class
require_once('activity.php');
require_once('common.php');

class TrainingPlan implements JsonSerializable
{
    private int $id;
    private string $username;
    private string $name;
    // array of activities
    private array $activities;

    public function __construct(int $id, string $username, string $name, array $activities)
    {
        $this->id = $id;
        $this->username = $username;
        $this->name = $name;
        $this->activities = $activities;
        $this->validate();
    }

    private function validate()
    {
        $invalidFields = [];
        if (isBlank($this->username)) {
            $invalidFields[] = [
                'field' => 'username',
                'message' => 'Username is required',
                'value' => $this->username,
                'examples' => ['username1', 'username2'],
            ];
        }
        if (isBlank($this->name)) {
            $invalidFields[] = [
                'field' => 'name',
                'message' => 'Name is required',
                'value' => $this->name,
                'examples' => ['Training plan 1', 'Training plan 2'],
            ];
        }
        if (count($invalidFields) > 0) {
            throw new InvalidFieldsException($invalidFields, 'TrainingPlan');
        }
    }

    // getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getActivities(): array
    {
        return $this->activities;
    }

    // setters

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setActivities(array $activities): void
    {
        $this->activities = $activities;
    }

    public static function fromArray(array $arr): TrainingPlan
    {
        // check for required fields
        $missing_params = array();

        if (!isset($arr['username'])) {
            $missing_params[] = 'username';
        }
        if (!isset($arr['name'])) {
            $missing_params[] = 'name';
        }
        // throw exception if required fields are missing
        if (count($missing_params) > 0) {
            // if activity exists remove it from the array
            if (isset($arr['activities'])) {
                unset($arr['activities']);
            }
            // get the type of this class (static method)
            $class = get_called_class();
            // throw exception
            throw new MissingParameterException($arr, $missing_params, $class);
        }
        $id = isset($arr['id']) ? $arr['id'] : null;
        // convert id to int (if null -1)
        $id = $id == null ? -1 : intval($id);
        $username = $arr['username'];
        $name = $arr['name'];
        $activities = [];
        // activities is an optional field
        if (array_key_exists('activities', $arr)) {
            foreach ($arr['activities'] as $activity) {
                $activities[] = Activity::fromArray($activity);
            }
        }

        return new TrainingPlan($id, $username, $name, $activities);
    }

    public function toArray(bool $recursive = true): array
    {
        $params = array(
            'username' => $this->username,
            'name' => $this->name,
        );
        if ($this->id != -1) {
            $params['id'] = $this->id;
        }
        if ($recursive) {
            $activities = [];
            foreach ($this->activities as $activity) {
                $activities[] = $activity->toArray();
            }
            $params['activities'] = $activities;
        }
        return $params;
    }


    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
};
