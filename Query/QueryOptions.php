<?php
  namespace Google\Visualization\DataSource\Query;

  class QueryOptions
  {
    protected $noValues;
    protected $noFormat;

    public function __construct()
    {
      $this->noValues = FALSE;
      $this->noFormat = FALSE;
    }

    public function setNoValues($noValues)
    {
      $this->noValues = $noValues;
    }

    public function setNoFormat($noFormat)
    {
      $this->noFormat = $noFormat;
    }

    public function isDefault()
    {
      return !$this->noFormat && !$this->noValues;
    }
  }
?>
