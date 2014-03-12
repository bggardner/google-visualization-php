<?php
  namespace Google\Visualization\DataSource\Util;

  class SqlDataSourceHelper
  {
    public static function executeQuery(Query $query, SqlDatabaseDescription $databaseDescription)
    {
      $con = self::getDatabaseConnection($databaseDescription);
      $tableName = $dataBaseDescription->getTableName();

      $queryString = self::buildSqlQuery($query, $tableName);
      $columnIdsList = self::getColumnIdsList($query->getSelection());
      try
      {
        $rs = $con->query($queryString);

        $table = self::buildColumns($rs, $columnIdsList);
        $table = self::buildRows($table, $rs);
        return $table;
      } catch (mysqli_sql_exception $e)
      {
        $messageToUser = "Failed to execute SQL query. mySQL error message: " . $e->getMessage();
        throw new DataSourceException(ReasonType::INTERNAL_ERROR, $messageToUser);
      } finally
      {
        $con->close();
      }
    }

    public static function getDataBaseConnection(SqlDatabaseDescription $databaseDescription)
    {
      $url = $databaseDescription->getUrl();
      $userName = $databaseDescription->getUser();
      $password = $databaseDescription->getPassword();
      $dbName = $databaseDescription->getName();
      try
      {
        $con = new mysqli($url, $userName, $password, $dbName);
      } catch (mysqli_sql_exception $e)
      {
        throw new DataSourceException(ReasonType::INTERNAL_ERROR, "Failed to connect to database server.");
      }
    }
  }
?>
