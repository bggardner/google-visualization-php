<?php

namespace Google\Visualization\DataSource\DataTable\Value;

use ReflectionClass;

class ValueType
{
    public const BOOLEAN = 'boolean';
    public const NUMBER = 'number';
    public const TEXT = 'string';
    public const DATE = 'date';
    public const TIMEOFDAY = 'timeofday';
    public const DATETIME = 'datetime';

    public static function values()
    {
        $refl = new ReflectionClass(__CLASS__);
        return $refl->getConstants();
    }
}
