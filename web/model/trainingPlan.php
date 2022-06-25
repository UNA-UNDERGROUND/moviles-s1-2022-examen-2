<?php
// Activity class
require_once('activity.php');

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
        $id = $arr['id'];
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
        if ($recursive) {
            $activities = [];
            foreach ($this->activities as $activity) {
                $activities[] = $activity->toArray();
            }
            return [
                'id' => $this->id,
                'username' => $this->username,
                'name' => $this->name,
                'activities' => $activities,
            ];
        } else {
            return [
                'id' => $this->id,
                'username' => $this->username,
                'name' => $this->name,
            ];
        }
    }


    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
};
