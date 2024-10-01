<?php
/*
 * Copyright © 2024 - Cow Or King Café.
 * All rights reserved.
 */

namespace AntiMatter_Studios\ArrayParser;

use Error;

/** Error thrown by the {@link IArrayParser} when a key is not of the expected type. */
final class InvalidItemTypeError extends Error
{
    /**
     * @param string $key The key that was of the invalid type.
     * @param string $expectedType The expected type of the key.
     * @param string $actualType The actual type of the key.
     */
    public function __construct(string $key, string $expectedType, string $actualType)
    {
        parent::__construct("Expected $key to be of $expectedType type. But found a $actualType instead.");
    }
}
