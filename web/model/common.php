<?php

abstract class JsonSerializableException extends Exception implements JsonSerializable
{
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function jsonSerialize()
    {
        $arr = $this->toArray();
        // add the message to the array
        $arr['message'] = $this->getMessage();
        // check if there is a inner exception
        if ($this->getPrevious()) {
            $arr['innerException'] = $this->getPrevious()->getMessage();
        }
        return $arr;
    }

    abstract public function toArray(): array;
}


class MissingParameterException extends JsonSerializableException
{
    private array $originalParameters;
    private array $missingParameters;
    private string $objectName;
    public function __construct(
        array $originalParameters,
        array $missingParameters,
        string $objectName,
    ) {
        parent::__construct(
            'Missing parameters for ' . $objectName,
            422
        );
        $this->originalParameters = $originalParameters;
        $this->missingParameters = $missingParameters;
        $this->objectName = $objectName;
    }

    public function getOriginalParameters(): array
    {
        return $this->originalParameters;
    }

    public function getMissingParameters(): array
    {
        return $this->missingParameters;
    }

    public function getObjectName(): string
    {
        return $this->objectName;
    }

    public function toArray(): array
    {
        return [
            'originalParameters' => $this->getOriginalParameters(),
            'missingParameters' => $this->getMissingParameters(),
            'objectName' => $this->getObjectName(),
        ];
    }
}
