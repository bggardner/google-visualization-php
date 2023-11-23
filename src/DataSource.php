<?php

namespace Google\Visualization\DataSource;

abstract class DataSource implements DataTableGenerator
{
    public function __construct()
    {
        DataSourceHelper::executeDataSource($this, $this->isRestrictedAccessMode());
    }

    protected function isRestrictedAccessMode()
    {
        return true;
    }

    public function getCapabilities()
    {
        return Capabilities::NONE;
    }
}
