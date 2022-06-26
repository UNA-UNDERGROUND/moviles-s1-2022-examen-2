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

class InvalidFieldsException extends JsonSerializableException
{
    private array $invalidFields;
    private string $objectName;
    public function __construct(
        array $invalidFields,
        string $objectName,
    ) {
        parent::__construct(
            'Invalid fields for ' . $objectName,
            422
        );
        $this->invalidFields= $invalidFields;
        $this->objectName = $objectName;
    }

    public function getInvalidFields(): array
    {
        return $this->invalidFields;
    }

    public function getObjectName(): string
    {
        return $this->objectName;
    }

    public function toArray(): array
    {
        return [
            'invalidFields' => $this->getInvalidFields(),
            'objectName' => $this->getObjectName(),
        ];
    }
}

// check whether a string is empty or only have non visible characters
function isBlank(string $str): bool
{
    // check if the string is empty
    if (strlen($str) == 0) {
        return true;
    }
    // check if the string is only whitespace
    if (ctype_space($str)) {
        return true;
    }
    return false;
}
