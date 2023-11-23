<?php

namespace Google\Visualization\DataSource\Query;

class QueryOptions
{
    protected $noValues;
    protected $noFormat;

    public function __construct()
    {
        $this->noValues = false;
        $this->noFormat = false;
    }

    public function setNoValues($noValues)
    {
        $this->noValues = $noValues;
        return $this;
    }

    public function setNoFormat($noFormat)
    {
        $this->noFormat = $noFormat;
        return $this;
    }

    public function isDefault()
    {
        return !$this->noFormat && !$this->noValues;
    }
}
