<?php

namespace Bonemeijer\PhpUnitExtensions\Assertion;

class UpdateAssertionsEnv
{
    public static function isActive(): bool
    {
        return (int) getenv('UA') === 1
            || (int) getenv('UPDATE_ASSERTIONS') === 1;
    }
}
