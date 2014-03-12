<?php
  namespace Google\Visualization\DataSource\DataTable\Value;

  use DateTime;
  use Google\Visualization\DataSource\DataTable\Value\ValueType;

  class DateValue extends Value
  {
    protected $dateTime;

    public function __construct($dateStr)
    {
      $this->dateTime = new DateTime($dateStr);
    }

    public static function getNullValue()
    {
      return new static();
    }

    public function __toString()
    {
      if (is_null($this->dateTime))
      {
        return "null";
      }
      return $this->dateTime->format("Y-m-d");
    }

    public function getDateTime()
    {
      return $this->dateTime;
    }

    public function getYear()
    {
      return (int) $this->dateTime->format("Y");
    }

    public function getMonth()
    {
      return (int) $this->dateTime->format("n") - 1;
    }

    public function getDayOfMonth()
    {
      return (int) $this->dateTime->format("j");
    }

    public function getType()
    {
      return ValueType::DATE;
    }

    public function getObjectToFormat()
    {
      if ($this->isNull())
      {
        return NULL;
      }
      return $this->dateTime;
    }

    public function isNull()
    {
      return is_null($this->dateTime);
    }

    public function compareTo(Value $other)
    {
      if ($this == $other)
      {
        return 0;
      }
      $otherDate = $other;
      if ($this->isNull())
      {
        return -1;
      }
      if ($otherDate->isNull())
      {
        return 1;
      }
      if ($this->dateTime > $otherDate->dateTime)
      {
        return 1;
      } else if ($this->dateTime < $otherDate->dateTime)
      {
        return -1;
      }
      return 0;
    }

    protected function innerToQueryString()
    {
      return "DATE '" . $this->getYear() . "-" . $this->getMonth() . "-" . $this->getDayOfMonth() . "'";
    }
  }
?>
