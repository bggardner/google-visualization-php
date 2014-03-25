<?php
  namespace Google\Visualization\DataSource\DataTable\Value;

  class TimeOfDayValue extends DateTimeValue
  {
    public function getType()
    {
      return ValueType::TIMEOFDAY;
    }
  }
?>
