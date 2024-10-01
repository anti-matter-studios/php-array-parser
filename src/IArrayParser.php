<?php
/*
 * Copyright © 2024 - Cow Or King Café.
 * All rights reserved.
 */

namespace AntiMatter_Studios\ArrayParser;

use StringBackedEnum;

/** Interface common to all the {@link ArrayParser}-derived classes. */
interface IArrayParser
{
    /** Separator used to recurse into inner objects. */
    const INNER_OBJECT_SEPARATOR = "::";

    /**
     * Retrieves a list from the current source.
     *
     * @param string $key The key to retrieve.
     * @param string $separator The separator for the elements of the list.
     * @return list<mixed> The list found at the given location.
     */
    public function list(string $key, string $separator = ","): array;

    /**
     * Retrieves an optional list from the current source.
     *
     * @param string $key The key to retrieve.
     * @param string $separator The separator for the elements of the list.
     * @return list<mixed>|null The list found at the given location.
     */
    public function optionalList(string $key, string $separator = ","): array|null;

    /**
     * Retrieves an inner {@link ArrayParser} from the current source.
     *
     * @param string $key The key to retrieve.
     * @return ArrayParser An {@link ArrayParser} for the object found at the given location.
     */
    public function arrayParser(string $key): ArrayParser;

    /**
     * Retrieves an inner {@link ArrayParser} from the current source.
     *
     * @param string $key The key to retrieve.
     * @return list<ArrayParser>|null An {@link ArrayParser} for the object found at the given location.
     */
    public function optionalArrayParser(string $key): ArrayParser|null;

    /**
     * Retrieves an array parser list from the current source.
     *
     * @param string $key The key to retrieve.
     * @return list<IArrayParser> A list of {@link IArrayParser} found at the given location.
     */
    public function arrayParserList(string $key): array;

    /**
     * Retrieves an optional list from the current source.
     *
     * @param string $key The key to retrieve.
     * @return list<IArrayParser>|null A list of {@link IArrayParser} found at the given location.
     */
    public function optionalArrayParserList(string $key): array|null;

    /**
     * Retrieves an integer value from the source.
     *
     * @param string $key The key to retrieve.
     * @return int The value of the retrieved key.
     */
    public function int(string $key): int;

    /**
     * Retrieves an optional integer value from the source.
     *
     * @param string $key The key to retrieve.
     * @return int|null The value of the retrieved key.
     */
    public function optionalInt(string $key): int|null;

    /**
     * Retrieves a list of integer values from the source.
     *
     * @param string $key The key to retrieve.
     * @param string $separator The separator for the elements of the list.
     * @return list<int> The value of the retrieved key.
     */
    public function intList(string $key, string $separator = ","): array;

    /**
     * Retrieves an optional integer value from the source.
     *
     * @param string $key The key to retrieve.
     * @param string $separator The separator for the elements of the list.
     * @return list<int>|null The value of the retrieved key.
     */
    public function optionalIntList(string $key, string $separator = ","): array|null;

    /**
     * Retrieves a floating point number value from the source.
     *
     * @param string $key The key to retrieve.
     * @return float The value of the retrieved key.
     */
    public function float(string $key): float;

    /**
     * Retrieves an optional floating point number value from the source.
     *
     * @param string $key The key to retrieve.
     * @return float|null The value of the retrieved key.
     */
    public function optionalFloat(string $key): float|null;

    /**
     * Retrieves a list of floating point number values from the source.
     *
     * @param string $key The key to retrieve.
     * @param string $separator The separator for the elements of the list.
     * @return list<float> The value of the retrieved key.
     */
    public function floatList(string $key, string $separator = ","): array;

    /**
     * Retrieves an optional floating point number value from the source.
     *
     * @param string $key The key to retrieve.
     * @param string $separator The separator for the elements of the list.
     * @return list<float>|null The value of the retrieved key.
     */
    public function optionalFloatList(string $key, string $separator = ","): array|null;

    /**
     * Retrieves a boolean value from the source.
     *
     * @param string $key The key to retrieve.
     * @return bool The value of the retrieved key.
     */
    public function bool(string $key): bool;

    /**
     * Retrieves an optional boolean value from the source.
     *
     * @param string $key The key to retrieve.
     * @return bool|null The value of the retrieved key.
     */
    public function optionalBool(string $key): bool|null;

    /**
     * Retrieves a list of boolean values from the source.
     *
     * @param string $key The key to retrieve.
     * @param string $separator The separator for the elements of the list.
     * @return list<bool> The value of the retrieved key.
     */
    public function boolList(string $key, string $separator = ","): array;

    /**
     * Retrieves a list of boolean values from the source.
     *
     * @param string $key The key to retrieve.
     * @param string $separator The separator for the elements of the list.
     * @return list<bool>|null The value of the retrieved key.
     */
    public function optionalBoolList(string $key, string $separator = ","): array|null;

    /**
     * Retrieves an enum value from the source.
     *
     * @template T of StringBackedEnum
     * @param string $key The key that was retrieved.
     * @param class-string<T> $enum The enumeration to cast the value to.
     * @return StringBackedEnum The cast value of the source.
     */
    public function enum(string $key, string $enum): mixed;

    /**
     * Retrieves an optional enum value from the source.
     *
     * @template T of StringBackedEnum
     * @param string $key The key that was retrieved.
     * @param class-string<T> $enum The enumeration to cast the value to.
     * @param bool $list If set, returns a list of enumerated values.
     * @return StringBackedEnum cast value of the source.
     */
    public function optionalEnum(string $key, string $enum, bool $list = false): mixed;

    /**
     * Retrieves a list of enum values from the source.
     *
     * @template T of StringBackedEnum
     * @param string $key The key that was retrieved.
     * @param class-string<T> $enum The enumeration to cast the value to.
     * @param string $separator The separator for the elements of the list.
     * @return StringBackedEnum The list of values of the source.
     */
    public function enumList(string $key, string $enum, string $separator = ","): array;

    /**
     * Retrieves an optional list of enum values from the source.
     *
     * @template T of StringBackedEnum
     * @param string $key The key that was retrieved.
     * @param class-string<T> $enum The enumeration to cast the value to.
     * @param string $separator The separator for the elements of the list.
     * @return StringBackedEnum|null The list of values of the source, if it was found.
     */
    public function optionalEnumList(string $key, string $enum, string $separator = ","): array|null;

    /**
     * Retrieves a string from the source.
     *
     * @param string $key The key to retrieve.
     * @return string The value of the retrieved key.
     */
    public function string(string $key): string;

    /**
     * Retrieves an optional string from the source.
     *
     * @param string $key The key to retrieve.
     * @return string|null The value of the retrieved key.
     */
    public function optionalString(string $key): string|null;

    /**
     * Retrieves a list of strings from the source.
     *
     * @param string $key The key to retrieve.
     * @param string $separator The separator for the elements of the list.
     * @return list<string> The value of the retrieved key.
     */
    public function stringList(string $key, string $separator = ","): array;

    /**
     * Retrieves an optional list of strings from the source.
     *
     * @param string $key The key to retrieve.
     * @param string $separator The separator for the elements of the list.
     * @return list<string>|null The value of the retrieved key.
     */
    public function optionalStringList(string $key, string $separator = ","): array|null;

    /**
     * Checks if the given key exists in the source array.
     *
     * @param string $key The key to check for.
     * @return bool <em>true</em> if the key exists.
     */
    public function keyExists(string $key): bool;

    /**
     * Checks if the given key exists in the source array and is NULL.
     *
     * @param string $key The key to check for.
     * @return bool <em>true</em> if the key exists and is NULL.
     */
    public function isNull(string $key): bool;
}
