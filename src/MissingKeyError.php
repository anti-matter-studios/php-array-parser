<?php
/*
 * Copyright © 2024 - Cow Or King Café.
 * All rights reserved.
 */

namespace AntiMatter_Studios\ArrayParser;

use Error;

/** Error thrown by the {@link IArrayParser} objects when a key is missing from the source. */
final class MissingKeyError extends Error
{
    /** @param string $key The key that was not found. */
    public function __construct(string $key)
    {
        parent::__construct("Could not found the key \"$key\" in the source.");
    }
}
