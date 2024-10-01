<?php
/*
 * Copyright © 2024 - Cow Or King Café.
 * All rights reserved.
 */

namespace AntiMatter_Studios\ArrayParser;

use BackedEnum;

/** Basic implementation of the {@link IArrayParser} interface. */
readonly class ArrayParser implements IArrayParser
{
    /** The source array being manipulated by this object. */
    protected array $source;

    /** @param array $source The source array manipulated by this instance. */
    public function __construct(array $source)
    {
        $this->source = $source;
    }

    /** @inheritDoc */
    public function list(string $key, string $separator = ","): array
    {
        return self::required($key, self::asList($key, $this->find($key), $separator));
    }

    /** @inheritDoc */
    public function optionalList(string $key, string $separator = ","): array|null
    {
        return self::asList($key, $this->find($key), $separator);
    }

    /** @inheritDoc */
    public function arrayParser(string $key): ArrayParser
    {
        return self::required($key, self::asArrayParser($key, $this->find($key)));
    }

    /** @inheritDoc */
    public function optionalArrayParser(string $key): ArrayParser|null
    {
        return self::asArrayParser($key, $this->find($key));
    }

    /** @inheritDoc */
    public function arrayParserList(string $key): array
    {
        return self::required(
            $key,
            $this->map(
                $key,
                fn(mixed $element, mixed $innerKey) => self::asArrayParser("$key::$innerKey", $element),
            ),
        );
    }

    /** @inheritDoc */
    public function optionalArrayParserList(string $key): array|null
    {
        return $this->map(
            $key,
            fn(mixed $element, mixed $innerKey) => self::asArrayParser("$key::$innerKey", $element),
        );
    }

    /** @inheritDoc */
    public function int(string $key): int
    {
        return self::required($key, self::asInt($key, $this->find($key)));
    }

    /** @inheritDoc */
    public function optionalInt(string $key): int|null
    {
        return self::asInt($key, $this->find($key));
    }

    /** @inheritDoc */
    public function intList(string $key, string $separator = ","): array
    {
        return self::required(
            $key,
            $this->map(
                $key,
                fn(mixed $element, mixed $innerKey) => self::asInt("$key::$innerKey", $element),
                $separator,
            ),
        );
    }

    /** @inheritDoc */
    public function optionalIntList(string $key, string $separator = ","): array|null
    {
        return $this->map(
            $key,
            fn(mixed $element, mixed $innerKey) => self::asInt("$key::$innerKey", $element),
            $separator,
        );
    }

    /** @inheritDoc */
    public function float(string $key): float
    {
        return self::required($key, self::asFloat($key, $this->find($key)));
    }

    /** @inheritDoc */
    public function optionalFloat(string $key): float|null
    {
        return self::asFloat($key, $this->find($key));
    }

    /** @inheritDoc */
    public function floatList(string $key, string $separator = ","): array
    {
        return self::required(
            $key,
            $this->map(
                $key,
                fn(mixed $element, mixed $innerKey) => self::asFloat("$key::$innerKey", $element),
                $separator,
            ),
        );
    }

    /** @inheritDoc */
    public function optionalFloatList(string $key, string $separator = ","): array|null
    {
        return $this->map(
            $key,
            fn(mixed $element, mixed $innerKey) => self::asFloat("$key::$innerKey", $element),
            $separator,
        );
    }

    /** @inheritDoc */
    public function bool(string $key): bool
    {
        return self::required($key, self::asBool($key, $this->find($key)));
    }

    /** @inheritDoc */
    public function optionalBool(string $key): bool|null
    {
        return self::asBool($key, $this->find($key));
    }

    /** @inheritDoc */
    public function boolList(string $key, string $separator = ","): array
    {
        return self::required(
            $key,
            $this->map(
                $key,
                fn(mixed $element, mixed $innerKey) => self::asBool("$key::$innerKey", $element),
                $separator,
            ),
        );
    }

    /** @inheritDoc */
    public function optionalBoolList(string $key, string $separator = ","): array|null
    {
        return $this->map(
            $key,
            fn(mixed $element, mixed $innerKey) => self::asBool("$key::$innerKey", $element),
            $separator,
        );
    }

    /** @inheritDoc */
    public function enum(string $key, string $enum): mixed
    {
        return self::required($key, self::asEnum($key, $this->find($key), $enum));
    }

    /** @inheritDoc */
    public function optionalEnum(string $key, string $enum, bool $list = false): mixed
    {
        return self::asEnum($key, $this->find($key), $enum);
    }

    /** @inheritDoc */
    public function enumList(string $key, string $enum, string $separator = ","): array
    {
        return self::required(
            $key,
            $this->map(
                $key,
                fn(mixed $element, mixed $innerKey) => self::asEnum("$key::$innerKey", $element, $enum),
                $separator,
            ),
        );
    }

    /** @inheritDoc */
    public function optionalEnumList(string $key, string $enum, string $separator = ","): array|null
    {
        return $this->map(
            $key,
            fn(mixed $element, mixed $innerKey) => self::asEnum("$key::$innerKey", $element, $enum),
            $separator,
        );
    }

    /** @inheritDoc */
    public function string(string $key): string
    {
        return self::required($key, self::asString($this->find($key)));
    }

    /** @inheritDoc */
    public function optionalString(string $key): string|null
    {
        return self::asString($this->find($key));
    }

    /** @inheritDoc */
    public function stringList(string $key, string $separator = ","): array
    {
        return self::required(
            $key,
            $this->map(
                $key,
                fn(mixed $element) => self::asString($element),
                $separator,
            ),
        );
    }

    /** @inheritDoc */
    public function optionalStringList(string $key, string $separator = ","): array|null
    {
        return $this->map(
            $key,
            fn(mixed $element) => self::asString($element),
            $separator,
        );
    }

    /** @inheritDoc */
    public function keyExists(string $key): bool
    {
        // Resolve the key container.
        $container = $this->resolveKeyPath($key);

        return $container !== null && $container["is-key-available"];
    }

    /** @inheritDoc */
    public function isNull(string $key): bool
    {
        // Resolve the key container.
        $container = $this->resolveKeyPath($key);

        // Check if the value is null.
        return
            $container !== null &&
            $container["is-key-available"] &&
            $container["value"] === null;
    }

    /**
     * Helper used to ensure that a given value is set.
     *
     * @template T
     * @param string $key The source key for the item.
     * @param T|null $value The value to require.
     * @return T
     */
    protected static function required(string $key, mixed $value): mixed
    {
        // Check if the value is null.
        return match ($value) {
            null => throw new MissingKeyError($key),
            default => $value
        };
    }

    /**
     * Casts a given value to a list.
     *
     * @param string $key The source key for the item.
     * @param mixed $value The value to cast.
     * @param string $separator If the value is a string, split it by this character.
     * @return list<mixed>|null The value, cast to a list.
     */
    protected static function asList(string $key, mixed $value, string $separator = ","): array|null
    {
        // Check the type of the value.
        return match (gettype($value)) {
            "array", "NULL" => $value,
            "string" => array_map("trim", explode($separator, $value)),
            default => throw new InvalidItemTypeError($key, "array", gettype($value))
        };
    }

    /**
     * Casts a given value to an ArrayParser.
     *
     * @param string $key The source key for the item.
     * @param mixed $value The value to cast.
     * @return self|null The value, cast to a {@link self} instance.
     */
    protected static function asArrayParser(string $key, mixed $value): self|null
    {
        // Check the type of the value.
        return match (gettype($value)) {
            "array" => new self($value),
            "NULL" => null,
            default => throw new InvalidItemTypeError($key, "array", gettype($value))
        };
    }

    /**
     * Casts a given value to an integer.
     *
     * @param string $key The source key for the item.
     * @param mixed $value The value to cast.
     * @return int|null The value, cast to an integer.
     */
    protected static function asInt(string $key, mixed $value): int|null
    {
        // Check the type of the value.
        return match (gettype($value)) {
            "integer" => $value,
            "double" => floor($value),
            "string" => intval($value),
            "NULL" => null,
            default => throw new InvalidItemTypeError($key, "int", gettype($value))
        };
    }

    /**
     * Casts a given value to a floating point number.
     *
     * @param string $key The source key for the item.
     * @param mixed $value The value to cast.
     * @return float|null The value, cast to a floating point number.
     */
    protected static function asFloat(string $key, mixed $value): float|null
    {
        // Check the type of the value.
        return match (gettype($value)) {
            "integer", "double" => $value,
            "string" => floatval($value),
            "NULL" => null,
            default => throw new InvalidItemTypeError($key, "float", gettype($value))
        };
    }

    /**
     * Casts a given value to a boolean.
     *
     * @param string $key The source key for the item.
     * @param mixed $value The value to cast.
     * @return bool|null The value, cast to a boolean.
     */
    protected static function asBool(string $key, mixed $value): bool|null
    {
        // Check the type of the value.
        return match (gettype($value)) {
            "boolean" => $value,
            "string" => match (strtolower(trim($value))) {
                "true", "yes", "on", "1" => true,
                default => false,
            },
            "NULL" => null,
            default => throw new InvalidItemTypeError($key, "boolean", gettype($value))
        };
    }

    /**
     * Casts a given value to an enumeration value.
     *
     * @template T of BackedEnum
     * @param string $key The source key for the item.
     * @param mixed $value The value to cast.
     * @param class-string<T> $enum The enum to cast to.
     * @return T|null The value, cast to the enum.
     */
    protected static function asEnum(string $key, mixed $value, string $enum): mixed
    {
        // Check the type of the value.
        return match (gettype($value)) {
            "NULL" => null,
            "string", "integer" => $enum::from($value),
            default => throw new InvalidItemTypeError($key, "boolean", gettype($value))
        };
    }

    /**
     * Casts a given value to a string.
     *
     * @param mixed $value The value to cast.
     * @return string|null The value, cast to a string.
     */
    protected static function asString(mixed $value): string|null
    {
        // Check the type of the value.
        return match (gettype($value)) {
            "NULL" => null,
            default => trim((string)$value)
        };
    }

    /**
     * Function used to find a key in the source array.
     *
     * @param string $key The key to search for in the {@link $source}.
     * @returns mixed The resulting element found in the array, or null if nothing was found.
     */
    protected function find(string $key): mixed
    {
        // Resolve the container.
        $container = $this->resolveKeyPath($key);
        return $container ? $container["value"] : null;
    }

    /**
     * Helper function used to retrieve a value as a list and apply a mapper function to all of its items.
     *
     * @template T
     * @param string $key
     * @param callable(mixed $value, mixed $key): T $mapper
     * @param string $separator
     * @return array|null
     */
    protected function map(string $key, callable $mapper, string $separator = ","): array|null
    {
        // Get the value as a list.
        $list = $this->optionalList($key, $separator);
        if ($list === null) {
            return null;
        }

        // Apply the mapper function.
        return array_map($mapper, $list, array_keys($list));
    }

    /**
     * Helper function used to resolve a key path in the current object's source.
     *
     *
     * @param string $key The key to resolve.
     * @return array{ is-key-available: false, value: null }|array{ is-key-available: true, value: mixed }|null
     * The information that was resolved,
     * or null if nothing was found.
     */
    protected function resolveKeyPath(string $key): array | null
    {
        // Get the starting array.
        $into = $this->source;

        // Split the key path in segments.
        $segments = explode(IArrayParser::INNER_OBJECT_SEPARATOR, $key);
        $key = array_pop($segments);

        // Search for the inner element.
        foreach ($segments as $segment) {
            // Check if the item exists.
            if (!array_key_exists($segment, $into) || gettype($into[$segment]) !== "array") {
                return null;
            }

            $into = $into[$segment];
        }

        // Return the parent and the target key.
        if (!array_key_exists($key, $into)) {
            return ["is-key-available" => false, "value" => null];
        }
        return ["is-key-available" => true, "value" => $into[$key]];
    }
}
