<?php

namespace Collections;


use Collections\Exceptions\InvalidArgumentException;

trait TypeValidator
{
    private function determineType($type, $keyType = false)
    {
        if (!$keyType && $this->nonScalarTypeExists($type)) {
            return $type;
        }

        if ($scalarType = $this->determineScalar($type)) {

            if ($keyType && (in_array($scalarType, ["double", "boolean"]))) {
                throw new InvalidArgumentException("This type is not supported as a key.");
            }

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

    /**
     * Validates an array of items
     *
     * @param array $items an array of items to be validated
     * @param type
     */
    protected function validateItems(array $items, $type)
    {
        foreach ($items as $item) {
            $this->validateItem($item, $type);
        }
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