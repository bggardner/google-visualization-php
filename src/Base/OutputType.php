<?php

namespace Google\Visualization\DataSource\Base;

use ReflectionClass;

class OutputType
{
    public const CSV = 'csv';
    public const HTML = 'html';
    public const JSON = 'json';
    public const JSONP = 'jsonp';
    public const PHP = 'php';
    public const TSV_EXCEL = 'tsv-excel';

    public static function defaultValue()
    {
        return self::JSON;
    }

    public static function findByCode($code)
    {
        $refl = new ReflectionClass(new self());
        if (in_array($code, $refl->getConstants())) {
            return $code;
        }
    }
}
