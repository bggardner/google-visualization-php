<?php

namespace Google\Visualization\DataSource;

use Google\Visualization\DataSource\Query\Query;

class QueryPair
{
    protected $dataSourceQuery;
    protected $completionQuery;

    public function __construct(Query $dataSourceQuery = null, Query $completionQuery = null)
    {
        $this->dataSourceQuery = $dataSourceQuery;
        $this->completionQuery = $completionQuery;
    }

    public function getDataSourceQuery()
    {
        return $this->dataSourceQuery;
    }

    public function getCompletionQuery()
    {
        return $this->completionQuery;
    }
}
