<?php
  namespace Google\Visualization\DataSource\Query;

  use Google\Visualization\DataSource\Base\InvalidQueryException;
  use Google\Visualization\DataSource\Base\MessagesEnum;

  class Query
  {
    protected $sort;
    protected $selection;
    protected $filter;
    protected $group;
    protected $pivot;
    protected $rowSkipping = 0;
    protected $rowLimit = -1;
    protected $rowOffset = 0;
    protected $options;
    protected $labels;
    protected $userFormatOptions;
    protected $localeForUserMessages;

    protected function checkForDuplicates($selectionColumns, $clauseName)
    {
      for ($i = 0; $i < count($selectionColumns); $i++)
      {
        $col = $selectionColumns[$i];
        for ($j = $i + 1; $j < count($selectionColumns); $j++)
        {
          if (($isCol = ($col instanceof AbstractColumn && $col->equals($selectionColumns[$j]))) || $col == $selectionColumns[$j])
          {
            $args = array($isCol ? $col->toString() : $col, $clauseName);
            $messageToLogAndUser = MessagesEnum::getMessageWithArgs(MessagesEnum::COLUMN_ONLY_ONCE, $this->localeForUserMessages, $args);
            //$log->error($messageToLogAndUser);
            throw new InvalidQueryException($messageToLogAndUser);
          }
        }
      }
    }

    public function setSort(QuerySort $sort = NULL)
    {
      $this->sort = $sort;
    }

    public function getSort()
    {
      return $this->sort;
    }

    public function hasSort()
    {
      return !is_null($this->sort) && !$this->sort->isEmpty();
    }

    public function setSelection(QuerySelection $selection = NULL)
    {
      $this->selection = $selection;
    }

    public function getSelection()
    {
      return $this->selection;
    }

    public function hasSelection()
    {
      return !is_null($this->selection) && !$this->selection->isEmpty();
    }

    public function setFilter(QueryFilter $filter = NULL)
    {
      $this->filter = $filter;
    }

    public function getFilter()
    {
      return $this->filter;
    }

    public function hasFilter()
    {
      return !is_null($this->filter);
    }

    public function setGroup(QueryGroup $group = NULL)
    {
      $this->group = $group;
    }

    public function getGroup()
    {
      return $this->group;
    }

    public function hasGroup()
    {
      return !is_null($this->group) && count($this->group->getColumnIds());
    }

    public function setPivot(QueryPivot $pivot = NULL)
    {
      $this->pivot = $pivot;
    }

    public function getPivot()
    {
      return $this->pivot;
    }

    public function hasPivot()
    {
      return !is_null($this->pivot) && count($this->pivot->getColumnIds());
    }

    public function getRowSkipping()
    {
      return $this->rowSkipping;
    }

    public function setRowSkipping($rowSkipping)
    {
      if ($rowSkipping < 0)
      {
        $messageToLogAndUser = MessagesEnum::INVALID_SKIPPING;
        //$log->error($messageToLogAndUser);
       throw new InvalidQueryException($messageToLogAndUser);
      }
      $this->rowSkipping = $rowSkipping;
    }

    public function copyRowSkipping(Query $originalQuery)
    {
      $this->rowSkipping = $originalQuery->getRowSkipping();
    }

    public function hasRowSkipping()
    {
      return $this->rowSkipping > 0;
    }

    public function getRowLimit()
    {
      return $this->rowLimit;
    }

    public function setRowLimit($rowLimit)
    {
      if ($rowLimit < -1)
      {
        $messageToLogAndUser = "Invalid value for row limit: " . $rowLimit;
        //$log->error($messageToLogAndUser);
        throw new InvalidQueryException($messageToLogAndUser);
      }
      $this->rowLimit = $rowLimit;
    }

    public function copyRowLimit(Query $originalQuery)
    {
      $this->rowLimit = $originalQuery->getRowLimit();
    }

    public function hasRowLimit()
    {
      return $this->rowLimit > -1;
    }

    public function getRowOffset()
    {
      return $this->rowOffset;
    }

    public function setRowOffset($rowOffset)
    {
      if ($rowOffset < 0)
      {
        $messageToLogAndUser = MessagesEnum::INVALID_OFFSET;
        //$log->error($messageToLogAndUser);
        throw new InvalidQueryException($messageToLogAndUser);
      }
      $this->rowOffset = $rowOffset;
    }

    public function copyRowOffset(Query $originalQuery)
    {
      $this->rowOffset = $originalQuery->getRowOffset();
    }

    public function hasRowOffset()
    {
      return $this->rowOffset > 0;
    }

    public function getUserFormatOptions()
    {
      return $this->userFormatOptions;
    }

    public function setUserFormatOptions(QueryFormat $userFormatOptions = NULL)
    {
      $this->userFormatOptions = $userFormatOptions;
    }

    public function hasUserFormatOptions()
    {
      return !is_null($this->userFormatOptions) && count($this->userFormatOptions->getColumns());
    }

    public function getLabels()
    {
      return $this->labels;
    }

    public function setLabels(QueryLabels $labels = NULL)
    {
      $this->labels = $labels;
    }

    public function hasLabels()
    {
      return !is_null($this->labels) && count($this->labels->getColumns());
    }

    public function getOptions()
    {
      return $this->options;
    }

    public function setOptions(QueryOptions $options = NULL)
    {
      $this->options = $options;
    }

    public function hasOptions()
    {
      return !is_null($this->options) && !$this->options->isDefault();
    }

    public function isEmpty()
    {
      return !$this->hasSort() && !$this->hasSelection() && !$this->hasFilter() && !$this->hasGroup()
        && !$this->hasPivot && !$this->hasRowSkipping() && !$this->hasRowLimit() && !$this->hasRowOffset()
        && !$this->hasUserFormatOptions() && !$this->hasLabels() && !$this->hasOptions();
    }

    public function setLocaleForUserMessages($localeForUserMessages)
    {
      $this->localeForUserMessages = $localeForUserMessages;
    }

    public function copyFrom(Query $query)
    {
      $this->setSort($query->getSort());
      $this->setSelection($query->getSelection());
      $this->setFilter ($query->getFilter());
      $this->setGroup($query->getGroup());
      $this->setPivot($query->getPivot());
      $this->copyRowSkipping($query);
      $this->copyRowLimit($query);
      $this->copyRowOffset($query);
      $this->setUserFormatOptions($query->getUserFormatOptions());
      $this->setLabels($query->getLabels());
      $this->setOptions($query->getOptions());
    }

    public function validate()
    {
      $groupColumnIds = $this->hasGroup() ? $this->group->getColumnIds() : array();
      $groupColumns = $this->hasGroup() ? $this->group->getColumns() : array();
      $pivotColumnIds = $this->hasPivot() ? $this->pivot->getColumnIds() : array();
      $selectionColumns = $this->hasSelection() ? $this->selection->getColumns() : array();
      $selectionAggregated = $this->hasSelection() ? $this->selection->getAggregationColumns() : array();
      $selectionSimple = $this->hasSelection() ? $this->selection->getSimpleColumns() : array();
      $selectedScalarFunctionColumns = $this->hasSelection() ? $this->selection->getScalarFunctionColumns() : array();
      $sortColumns = $this->hasSort() ? $this->sort->getColumns() : array();
      $sortAggregated = $this->hasSort() ? $this->sort->getAggregationColumns() : array();

      // Check for duplicates
      $this->checkForDuplicates($selectionColumns, "SELECT");
      $this->checkForDuplicates($sortColumns, "ORDER BY");
      $this->checkForDuplicates($groupColumnIds, "GROUP BY");
      $this->checkForDuplicates($pivotColumnIds, "PIVOT");

      // Cannot have aggregations in either group by, pviot, or where
      if ($this->hasGroup())
      {
        foreach ($this->group->getColumns() as $column)
        {
          if (count($column->getAllAggregationColumns()))
          {
            $messageToLogAndUser = MessagesEnum::getMessageWithArgs(MessagesEnum::CANNOT_BE_IN_GROUP_BY, $this->localeForUserMessages, $column->toQueryString());
            //$log->error($messageToLogAndUser);
            throw new InvalidQueryException($messageToLogAndUser);
          }
        }
      }
      if ($this->hasPivot())
      {
        foreach ($this->pivot->getColumns() as $column)
        {
          if (count($column->getAllAggregationColumns()))
          {
            $messageToLogAndUser = MessagesEnum::getMessageWithArgs(MessagesEnum::CANNOT_BE_IN_PIVOT, $this->localeForUserMessages, $column->toQueryString());
            //$log->error($messageToLogAndUser);
            throw new InvalidQueryException($messageToLogAndUser);
          }
        }
      }
      if ($this->hasFilter())
      {
        $filterAggregations = $this->filter->getAggregationColumns();
        if (count($filterAggregations))
        {
          $messageToLogAndUser = MessagesEnum::getMessageWithArgs(MessagesEnum::CANNOT_BE_IN_WHERE, $this->localeForUserMessages, $column->toQueryString());
          //$log->error($messageToLogAndUser);
          throw new InvalidQueryException($messageToLogAndUser);
        }
      }

      // A column cannot appear both as an aggregation column and as a regular column in the selection
      foreach ($selectionSimple as $column1)
      {
        $id = $column1->getColumnId();
        {
          foreach ($selectionAggregated as $column2)
          {
            if ($id == $column2->getAggregatedColumn()->getId())
            {
              $messageToLogAndUser = MessagesEnum::getMessageWithArgs(MessagesEnum::SELECT_WITH_AND_WITHOUT_AGG, $this->localeForUserMessages, $id);
              //$log->error($messageToLogAndUser);
              throw new InvalidQueryException($messageToLogAndUser);
            }
          }
        }
      }

      // When aggregation is used, check that all selected columns are valid (either grouped-by or a scalar function with valid column arguments)
      if (count($selectionAggregated))
      {
        foreach ($selectionColumns as $col)
        {
          $this->checkSelectedColumnWithGrouping($groupColumns, $col);
        }
      }

      // Cannot group by a column that appears in an aggregation
      if ($this->hasSelection() && $this->hasGroup())
      {
        foreach ($selectionAggregated as $column)
        {
          $id = $column->getAggregatedColumn()->getId();
          if (in_array($id, $groupColumnIds))
          {
            $messageToLogAndUser = MessagesEnum::getMessageWithArgs(MessagesEnum::COL_AGG_NOT_IN_SELECT, $this->localeForUserMessages, $id);
            //$log->error($messageToLogAndUser);
            throw new InvalidQueryException($messageToLogAndUser);
          }
        }
      }
      // TODO
    }

    public function getAllColumnIds()
    {
      $result = array();
      if ($this->hasSelection())
      {
        foreach ($this->selection->getColumns() as $col)
        {
          $result = array_merge($result, $col->getAllSimpleColumnIds());
        }
      }
      if ($this->hasSort())
      {
        foreach ($this->sort->getColumns() as $col)
        {
          $result = array_merge($result, $col->getAllSimpleColumnIds());
        }
      }
      if ($this->hasGroup())
      {
        $result = array_merge($result, $this->getGroup()->getSimpleColumnIds());
      }
      if ($this->hasPivot())
      {
        $result = array_merge($result, $this->getPivot()->getSimpleColumnIds());
      }
      if ($this->hasFilter())
      {
        $result = array_merge($result, $this->getFilter()->getAllColumnIds());
      }
      if ($this->hasLabels())
      {
        foreach ($this->labels->getColumns() as $col)
        {
          $result = array_merge($result, $col->getAllSimpleColumnIds());
        }
      }
      if ($this->hasUserFormatOptions())
      {
        foreach ($this->userFormatOptions->getColumns() as $col)
        {
          $result = array_merge($result, $col->getAllSimpleColumnIds());
        }
      }

      return $result;
    }

    public function getAllAggregations()
    {
      $result = array();
      if ($this->hasSelection())
      {
        $result = array_merge($result, $this->selection->getAggregationColumns());
      }
      if ($this->hasSort())
      {
        foreach ($this->sort->getColumns() as $col)
        {
          if ($col instanceof AggregationColumn)
          {
            array_push($result, $col);
          }
        }
      }
      if ($this->hasLabels())
      {
        foreach ($this->labels->getColumns() as $col)
        {
          if ($col instanceof AggregationColumn)
          {
            array_push($result, $col);
          }
        }
      }
      if ($this->hasUserFormatOptions())
      {
        foreach ($this->userFormatOptions->getColumns() as $col)
        {
          if ($col instanceof AggregationColumn)
          {
            array_push($result, $col);
          }
        }
      }
      return $result;
    }

    public function getAllScalarFunctionsColumns()
    {
      $mentionedScalarFunctionsColumns = array();
      if ($this->hasSelection())
      {
        $mentionedScalarFunctionsColumns = array_merge($mentionedScalarFunctionsColumns, $this->selection->getScalarFunctionColumns());
      }
      if ($this->hasFilter())
      {
        $mentionedScalarFunctionsColumns = array_merge($mentionedScalarFunctionsColumns, $this->filter->getScalarFunctionColumns());
      }
      if ($this->hasGroup())
      {
        $mentionedScalarFunctionsColumns = array_merge($mentionedScalarFunctionsColumns, $this->group->getScalarFunctionColumns());
      }
      if ($this->hasPivot())
      {
        $mentionedScalarFunctionsColumns = array_merge($mentionedScalarFunctionsColumns, $this->pivot->getScalarFunctionColumns());
      }
      if ($this->hasSort())
      {
        $mentionedScalarFunctionsColumns = array_merge($mentionedScalarFunctionsColumns, $this->sort->getScalarFunctionColumns());
      }
      if ($this->hasLabels())
      {
        $mentionedScalarFunctionsColumns = array_merge($mentionedScalarFunctionsColumns, $this->labels->getScalarFunctionColumns());
      }
      if ($this->hasUserFormatOptions())
      {
        $mentionedScalarFunctionsColumns = array_merge($mentionedScalarFunctionsColumns, $this->userFormatOptions->getScalarFunctionColumns());
      }
      return $mentionedScalarFunctionsColumns;
    }

    protected function checkSelectedColumnWithGrouping($groupColumns, AbstractColumn $col)
    {
      if ($col instanceof SimpleColumn)
      {
        if (!in_array($col, $groupColumns))
        {
          $messageToLogAndUser = MessagesEnum::getMessageWithArgs(MessagesEnum::ADD_COL_TO_GROUP_BY_OR_AGG, $this->localeForUserMessages, $col->getId());
          //$log->error($messageToLogAndUser
          throw new InvalidQueryException($messageToLogAndUser);
        }
      } else if ($col instanceof ScalarFunctionColumn)
      {
        if (!in_array($col, $groupColumns))
        {
          $innerColumns = $col->getColumns();
          foreach ($innerColumns as $innerColumn)
          {
            $this->checkSelectedColumnWithGrouping($groupColumns, $innerColumn);
          }
        }
      }
    }

    public static function columnListtoQueryString($l)
    {
      $s = array();
      foreach ($l as $col)
      {
        $s[] = $col->toQueryString();
      }
      return implode(", ", $s);
    }

    public static function stringToQueryStringLiteral($s)
    {
      if (strpos($s, "\\") !== FALSE)
      {
        if (strpos($s, "'") !== FALSE)
        {
          throw new \RuntimeException("Cannot represent string that contains both double-quotes (\") and single quotes (').");
        } else
        {
          return "'" . $s . "'";
        }
      } else
      {
        return "\"" . $s . "\"";
      }
    }

    public function toQueryString()
    {
      $clauses = array();
      if ($this->hasSelection())
      {
        $clauses[] = "SELECT " . $this->selection->toQueryString();
      }
      if ($this->hasFilter())
      {
        $clauses[] = "WHERE " . $this->filter->toQueryString();
      }
      if ($this->hasGroup())
      {
        $clauses[] = "GROUP BY " . $this->group->toQueryString();
      }
      if ($this->hasPivot())
      {
        $clauses[] = "PIVOT " . $this->pivot->toQueryString();
      }
      if ($this->hasSort())
      {
        $clauses[] = "ORDER BY " . $this->sort->toQueryString();
      }
      if ($this->hasRowSkipping())
      {
        $clauses[] = "SKIPPING " . $this->rowSkipping;
      }
      if ($this->hasRowLimit())
      {
        $clauses[] = "LIMIT " . $this->rowLimit;
      }
      if ($this->hasRowOffset())
      {
        $clauses[] = "OFFSET " . $this->rowOffset;
      }
      if ($this->hasLabels())
      {
        $clauses[] = "LABEL " . $this->labels->toQueryString();
      }
      if ($this->hasUserFormatOptions())
      {
        $clauses[] = "FORMAT " . $this->userFormatOptions->toQueryString();
      }
      if ($this->hasOptions())
      {
        $clauses[] = "OPTIONS " . $this->options->toQueryString();
      }
      return implode(" ", $clauses);
    }
  }
?>
