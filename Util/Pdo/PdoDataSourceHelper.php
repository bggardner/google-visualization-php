<?php
  namespace Google\Visualization\DataSource\Util\Pdo;

  use PDO;
  use PDOException;
  use PDOStatement;
  use Google\Visualization\DataSource\Base\DataSourceException;
  use Google\Visualization\DataSource\Base\ReasonType;
  use Google\Visualization\DataSource\DataTable\ColumnDescription;
  use Google\Visualization\DataSource\DataTable\DataTable;
  use Google\Visualization\DataSource\DataTable\TableCell;
  use Google\Visualization\DataSource\DataTable\TableRow;
  use Google\Visualization\DataSource\DataTable\Value\BooleanValue;
  use Google\Visualization\DataSource\DataTable\Value\DateTimeValue;
  use Google\Visualization\DataSource\DataTable\Value\DateValue;
  use Google\Visualization\DataSource\DataTable\Value\NumberValue;
  use Google\Visualization\DataSource\DataTable\Value\TimeOfDayValue;
  use Google\Visualization\DataSource\DataTable\Value\TextValue;
  use Google\Visualization\DataSource\DataTable\Value\ValueType;
  use Google\Visualization\DataSource\Query\Query;
  use Google\Visualization\DataSource\Query\QuerySelection;
  use Google\Visualization\DataSource\Util\DataManipulatorInterface;

  abstract class PdoDataSourceHelper implements PdoDataSourceHelperInterface
  {
    public static function executeQuery(Query $query, PDO $db, $tableName, DataManipulatorInterface $manipulator = NULL)
    {
      if (!static::validateDriver($driver = $db->getAttribute(PDO::ATTR_DRIVER_NAME)))
      {
        $messageToUser = "PDO driver (" . $driver . ") must match PDODataSourceHelper (" . get_called_class() . ")";
        throw new DataSourceException(ReasonType::INTERNAL_ERROR, $messageToUser);
      }
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $queryString = static::buildSqlQuery($query, $tableName);
      $columnIdsList = NULL;
      if ($query->hasSelection())
      {
        $columnIdsList = self::getColumnIdsList($query->getSelection());
      }

      try
      {
        $stmt = $db->query($queryString);
        return self::buildTable($stmt, $columnIdsList, $manipulator);
      } catch (PDOException $e)
      {
        $messageToUser = "Failed to execute SQL query. SQL error message: " . $e->getMessage();
        throw new DataSourceException(ReasonType::INTERNAL_ERROR, $messageToUser);
      }
    }

    public static function buildTable(PDOStatement $stmt, $columnIdsList = NULL, DataManipulatorInterface $manipulator = NULL)
    {
      $table = self::buildColumns($stmt, $columnIdsList, $manipulator);
      $table = self::buildRows($table, $stmt, $manipulator);
      return $table;
    }

    protected static function getColumnIdsList(QuerySelection $selection)
    {
      $columnIds = array();
      foreach ($selection->getColumns() as $col)
      {
        $columnIds[] = $col->getId();
      }
      return $columnIds;
    }

    protected static function buildColumns(PDOStatement $stmt, $columnIdsList, DataManipulatorInterface $manipulator = NULL)
    {
      $result = new DataTable();
      for ($i = 0; $i < $stmt->columnCount(); $i++)
      {
        $metaData = $stmt->getColumnMeta($i);
        $id = is_null($columnIdsList) ? $metaData["name"] : $columnIdsList[$i];
        if (method_exists(get_called_class(), "metaDataToValueType")) // TODO: replace with try/catch
        {
          $valueType = static::metaDataToValueType($metaData);
        } else {
          $valueType = self::pdoTypeToValueType($metaData["pdo_type"]);
        }
	if ($manipulator) {
          $valueType = $manipulator->getColumnType($i, $valueType) ?: $valueType;
	}
        $columnDescription = new ColumnDescription($id, $valueType, $metaData["name"]);
        $result->addColumn($columnDescription);
      }
      return $result;
    }

    protected static function pdoTypeToValueType($pdoType)
    {
      switch ($pdoType)
      {
        case PDO::PARAM_BOOL:
          $valueType = ValueType::BOOLEAN;
          break;
        case PDO::PARAM_INT:
          $valueType = ValueType::NUMBER;
          break;
        case PDO::PARAM_STR:
        default:
          $valueType = ValueType::TEXT;
      }
      return $valueType;
    }

    protected static function buildRows(DataTable $dataTable, PDOStatement $stmt, DataManipulatorInterface $manipulator = NULL)
    {
      $columnDescriptionList = $dataTable->getColumnDescriptions();
      $numOfCols = $dataTable->getNumberOfColumns();

      $columnsTypeArray = array();
      foreach ($columnDescriptionList as $col)
      {
        $columnsTypeArray[] = $col->getType();
      }

      while ($row = $stmt->fetch(PDO::FETCH_NUM))
      {
        $tableRow = new TableRow();
        for ($c = 0; $c < $numOfCols; $c++)
        {
          $tableRow->addCell(self::buildTableCell($row, $columnsTypeArray[$c], $c, $manipulator));
        }
        try
        {
          $dataTable->addRow($tableRow);
        } catch (TypeMismatchException $e) {}
      }
      return $dataTable;
    }

    protected static function buildTableCell($row, $valueType, $column, DataManipulatorInterface $manipulator = NULL)
    {
      switch ($valueType)
      {
        case ValueType::BOOLEAN:
          $value = new BooleanValue($row[$column]);
          break;
        case ValueType::NUMBER:
          $value = new NumberValue($row[$column]);
          break;
        case ValueType::DATE:
          $value = new DateValue($row[$column]);
          break;
        case ValueType::DATETIME:
          $value = new DateTimeValue($row[$column]);
          break;
        case ValueType::TIMEOFDAY:
          $value = new TimeOfDayValue($row[$column]);
          break;
        default:
          $value = new TextValue($row[$column]);
      }
      if ($manipulator) {
        $value = $manipulator->getCellValue($column, $value, $row) ?: $value;
      }
      return new TableCell($value);
    }
  }
?>
