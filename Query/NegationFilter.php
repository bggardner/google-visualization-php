<?php
  namespace Google\Visualization\Datasource\Query;

  class NegationFilter extends QueryFilter
  {
    protected $subFilter;

    public function __construct(QueryFilter $subFilter)
    {
      $this->subFilter = $subFilter;
    }

    public function isMatch(DataTable $table, TableRow $row)
    {
      return !$this->subFilter->isMatch($table, $row);
    }

    public function getAllColumnIds()
    {
      return $this->subFilter->getAllColumnIds();
    }

    public function getScalarFunctionColumns()
    {
      return $this->subFilter->getScalarFunctionColumns();
    }

    public function getAggregationColumns()
    {
      return $this->subFilter->getAggregationColumns();
    }

    public function getSubFilter()
    {
      return $this->subFilter;
    }

    public function toQueryString()
    {
      return "NOT (" . $this->subFilter->toQueryString() . ")";
    }
  }
?>
