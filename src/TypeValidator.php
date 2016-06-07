<?php

namespace Collections;


use Collections\Exceptions\InvalidArgumentException;

trait TypeValidator
{
    private function determineType($type, $onlyScalar = false)
    {
        if (!$onlyScalar && $this->nonScalarTypeExists($type)) {
            return $type;
        }

        if ($scalarType = $this->determineScalar($type)) {
            return $scalarType;
        }

        throw new InvalidArgumentException("This type does not exist.");
    }

    private function nonScalarTypeExists($type)
    {
        return class_exists($type)
                || interface_exists($type)
                || in_array($type, ["array", "object", "callable"]);
    }

    private function determineScalar($type)
    {
        $synonyms = [
            "int" => "integer",
            "float" => "double",
            "bool" => "boolean"
        ];

        if (array_key_exists($type, $synonyms)) {
            $type = $synonyms[$type];
        }

        $types = [ "string", "integer", "double", "boolean" ];

        return in_array($type, $types) ? $type : null;
    }

    protected function validateItem($item, $target)
    {
        $type = gettype($item);

        $shouldBeCallable = $target === 'callable';
        $isObject = $type === "object";

        //callable must be callable
        if ($shouldBeCallable && !is_callable($item)) {
            throw new InvalidArgumentException("Item must be callable");
        }

        //target isn't callable, object must be an instance of target
        if (!$shouldBeCallable && $isObject && !is_a($item, $target)) {
            throw new InvalidArgumentException("Item is not type or subtype of " . $target);
        }

        //a non callable, non object type should match the target string
        if (!$shouldBeCallable && !$isObject && $type != $target) {
            throw new InvalidArgumentException("Item is not of type: " . $target);
        }
    }
}