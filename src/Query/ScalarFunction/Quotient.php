<?php

namespace Google\Visualization\DataSource\Query\ScalarFunction;

use Google\Visualization\DataSource\DataTable\Value\NumberValue;
use Google\Visualization\DataSource\DataTable\Value\ValueType;

class Quotient implements ScalarFunction
{
    protected const FUNCTION_NAME = 'quotient';

    public function getFunctionName()
    {
        return self::FUNCTION_NAME;
    }

    public function evaluate($values)
    {
        if ($values[0]->isNull() || $values[1]->isNull() || $values[1]->getValue() == 0) {
            return NumberValue::getNullValue();
        }
        $sum = $values[0]->getValue() / $values[1]->getValue();
        return new NumberValue($sum);
    }

    public function getReturnType($types)
    {
        return ValueType::NUMBER;
    }

    public function validateParameters($types)
    {
        if (count($types) != 2) {
            throw new InvalidQueryException('The function ' . self::FUNCTION_NAME . ' requires two parameters');
        }
        foreach ($types as $type) {
            if ($type != ValueType::NUMBER) {
                throw new InvalidQueryException(
                    'Cannot perform the function ' . self::FUNCTION_NAME . ' on values that are not numbers'
                );
            }
        }
        return $this;
    }

    public function toQueryString($argumentsQueryStrings)
    {
        return '(' . $argumentsQueryStrings[0] . ' / ' . $argumentsQueryStrings[1] . ')';
    }
}
