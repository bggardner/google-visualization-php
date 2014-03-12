<?php
  namespace Google\Visualization\DataSource\DataTable\Value;

  use Google\Visualization\DataSource\Base\ValueType;

  class TimeOfDayValue extends DateTimeValue
  {
    protected $dateTime;

    public function getType()
    {
      return ValueType::TIMEOFDAY;
    }
  }
?>
