<?php

namespace Google\Visualization\DataSource\Query\ScalarFunction;

class ToDate implements ScalarFunction
{
    protected const FUNCTION_NAME = 'toDate';

    public function getFunctionName()
    {
        return self::FUNCTION_NAME;
    }

    public function evaluate($values)
    {
        $value = $values[0];
        if (is_null($value)) {
            return DateValue::getNullValue();
        }

        switch ($value->getType()) {
            case ValueType::DATE:
            case ValueType::DATETIME:
                $dateValue = new DateValue($value);
                break;
            case ValueType::NUMBER:
                $dateValue = new DateValue(DateTime::createFromFormat($value->getValue() / 1000));
                break;
            default:
                throw new RuntimeException('Value type was not found: ' . $value->getType());
        }
        return $dateValue;
    }

    public function getReturnType($types)
    {
        return ValueType::DATE;
    }

    public function validateParameters($types)
    {
        if (count($types) != 1) {
            throw new InvalidQueryException('Number of parameters for the date function is wrong: ' . count($types));
        } elseif ($types[0] != ValueType::DATETIME && $types[0] != ValueType::DATE && $types[0] != ValueType::NUMBER) {
            throw new InvalidQueryException(
                'Cannot perform the function "' . self::FUNCTION_NAME
                . '" on values that are not date, dateTime, or number values'
            );
        }
        return $this;
    }

    public function toQueryString($argumentsQueryStrings)
    {
        return self::FUNCTION_NAME . '(' . $argumentsQueryStrings[0] . ')';
    }
}
