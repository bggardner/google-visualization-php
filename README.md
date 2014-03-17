Google Visualization Data Source for PHP
========================================

This is a near literal translation of [google-visualization-java](https://code.google.com/p/google-visualization-java/source/browse/trunk/src/main/java/com/google/visualization/datasource/) into PHP.  However, the QueryParser class was written from scratch.  Thorough testing has not been performed, so bug reports are encouraged.  Enjoy!


Features
--------

- A PHP implementation of the [Google Chart Tools Datasource Protocol](https://developers.google.com/chart/interactive/docs/dev/implementing_data_source)
- Parses a [Google Visualization Query](https://developers.google.com/chart/interactive/docs/querylanguage)
- Executes the query on an existing DataTable or retrieves one using Helper classes:
    - PDO Helper abstract class with extensions:
        - MySQL (performs automatic type casting)
- Additional query language functions:
    - ABS (absolute value)
    - CONCAT (concatenate strings)
    - CONCAT_WS (concatenate strings with separator)
    - ROUND (round to a digit of precision)


Dependencies
------------

- PHP 5.4+ (maybe 5.3)


Usage
-----

The usage is nearly similar to that of the [java library](https://developers.google.com/chart/interactive/docs/dev/dsl_about) (see that further usage help).
- Include all the files in the path or use an autoloader such as [AutoloadByNamespace-php](https://github.com/bggardner/AutoloadByNamespace-php).
- For usage with Google Charts:
    - Create a class that extends the DataSource class
    - Instantiate the class in a file that accepts the HTTP GET request from the Google Chart
    - Example that queries the MySQL table "mytable":

            <?php
              // Required to autoload the Google\Visualization\DataSource classes
              require_once "/includes/classes/AutoloadByNamespace.php";
              spl_autoload_register("AutoloadByNamespace::autoload");
              AutoloadByNamespace::register("Google", "/includes/classes/Google");

              // The custom class that defines the PDO connection and the MySQL table
              class MyDataSource extends Google\Visualization\DataSource\DataSource
              {
                public function getCapabilities() { return Google\Visualization\DataSource\Capabilities::SQL; }

                public function generateDataTable(Google\Visualization\DataSource\Query\Query $query)
                {
                  $pdo = new PDO('mysql:host=xxx;port=xxx;dbname=xxx', 'username', 'password');
                  return Google\Visualization\DataSource\Util\Pdo\MysqlPdoDataSourceHelper::executeQuery($query, $pdo, "mytable");
                }

                public function isRestrictedAccessMode() { return FALSE; }
              }

              // Instantiating the class parses the 'tq' and 'tqx' HTTP request parameters and outputs the resulting data
              new MyDataSource();
            ?>

- Useful stand-alone functions:
    - Use DataSourceHelper::parseQuery() to generate a Query object from a string
    - Use MySqlPdoDataSourceHelper::executeQuery() to retrieve a DataTable from a MySQL database
    - Use DataSourceHelper::applyQuery() to apply a query to an existing DataTable
