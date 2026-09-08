<?php

namespace Jeffersongoncalves\Snov\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jeffersongoncalves\Snov\Snov
 */
class Snov extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-snov';
    }
}
