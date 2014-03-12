Google Visualization Data Source for PHP
========================================

This is a near literal translation of [google-visualization-java](https://code.google.com/p/google-visualization-java/source/browse/trunk/src/main/java/com/google/visualization/datasource/) into PHP.


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


Limitations
-----------

- MySQL Helper does not support MILLISECOND query statement


Dependencies
------------

- PHP 5.4


Usage
-----

The usage is nearly similar to that of the java library:
- Include all the files in the path or use an autoloader such as [AutoloadByNamespace-php](https://github.com/bggardner/AutoloadByNamespace-php).
- For usage with Google Charts:
    - Create a class that extends the DataSource class
    - Instantiate the class in a file that accepts the HTTP GET request ('tq' and 'tqx' parameters) from the Google Chart
- For stand-alone usage:
    - Use DataSourceHelper::parseQuery() to generate a Query object from a string
    - Use MySqlPdoDataSourceHelper::executeQuery() to retrieve a DataTable from a MySQL database
    - Use DataSourceHelper::applyQuery() to apply a query to an existing DataTable
