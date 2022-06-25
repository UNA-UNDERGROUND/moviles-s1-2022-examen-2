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

    public static function fromJson(array $json): TrainingPlan
    {
        $id = $json['id'];
        $username = $json['username'];
        $name = $json['name'];
        $activities = [];
        foreach ($json['activities'] as $activity) {
            $activities[] = Activity::fromJson($activity);
        }
        return new TrainingPlan($id, $username, $name, $activities);
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'activities' => $this->activities,
        ];
    }
};
