<?php
  namespace Google\Visualization\DataSource\Query;

  use Google\Visualization\DataSource\DataTable\DataTable;
  use Google\Visualization\DataSource\DataTable\TableRow;

  class CompoundFilter extends QueryFilter
  {
   const LOGICAL_OPERATOR_AND = "and";
   const LOGICAL_OPERATOR_OR = "or";

    protected $operator;
    protected $subFilters;

    public function __construct($operator, $subFilters)
    {
      $this->operator = $operator;
      $this->subFilters = $subFilters;
    }

    public function isMatch(DataTable $table, TableRow $row)
    {
static $a = 0;
      if (!count($this->subFilters))
      {
        throw new RuntimeException("Compound filter with empty subFilters list");
      }
      foreach ($this->subFilters as $subFilter)
      {
        $result = $subFilter->isMatch($table, $row);
        if ((($this->operator == self::LOGICAL_OPERATOR_AND) && !$result) || (($this->operator == self::LOGICAL_OPERATOR_OR) && $result))
        {
          return $result;
        }
      }
      return $this->operator == self::LOGICAL_OPERATOR_AND;
    }

    public function getAllColumnIds()
    {
      $result = array();
      foreach ($this->subFilters as $subFilter)
      {
        $result = array_merge($result, $subFilter->getAllColumnIds());
      }
      return $result;
    }

    public function getScalarFunctionColumns()
    {
      $result = array();
      foreach ($this->subFilters as $subFilter)
      {
        $result = array_merge($result, $subFilter->getScalarFunctionColumns());
      }
      return $result;
    }

    public function getAggregationColumns()
    {
      $result = array();
      foreach ($this->subFilters as $subFilter)
      {
        $result = array_merge($result, $subFilter->getAggregationColumns());
      }
      return $result;
    }

    public function getOperator()
    {
      return $this->operator;
    }

    public function getSubFilters()
    {
      return $this->subFilters;
    }

    public function toQueryString()
    {
      $subFilterStrings = array();
      foreach ($this->subFilters as $subFilter)
      {
        $subFilterStrings[] = "(" . $subFilter->toQueryString() . ")";
      }
      return implode(" " . $this->operator . " ", $subFilterStrings);
    }
  }
?>
