<?php
  namespace Google\Visualization\DataSource\Query\ScalarFunction;

  class CurrentDateTime implements ScalarFunction
  {
    const FUNCTION_NAME = "now";

    public function getFunctionName()
    {
      return self::FUNCTION_NAME;
    }

    public function evaluate($values)
    {
      return new DateTimeValue(new DateTime());
    }

    public function getReturnType($types)
    {
      return ValueType::DATETIME;
    }

    public function validateParameters($types)
    {
      if (count($types) != 0)
      {
        throw new InvalidQueryException("The " . self::FUNCTION_NAME . " function should not get any parameters");
      }
    }

    public function toQueryString($argumentsQueryStrings)
    {
      return self::FUNCTION_NAME . "()";
    }
  }
?>
