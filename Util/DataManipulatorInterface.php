<?php
  namespace Google\Visualization\DataSource\Util;

  use Google\Visualization\DataSource\DataTable\Value\Value;

  /**
   * Interface specification for allowing manipulation of data-types and values loaded from a datasource.
   *
   * Example:
   * <code>
   * class MyManipulator implements DataManipulatorInterface
   * {
   *   public function getColumnType($column, $valueType) {
   *     switch ($column) {
   *     case 1:
   *       // Set column 2 to be text
   *       return ValueType::TEXT;
   *     default:
   *       return NULL;
   *     }
   *   }
   *   public function getCellValue($column, $value) {
   *     switch ($column) {
   *     case 1:
   *       return new TextValue('<a href="/showObject?id=' . $value->getValue() . '">Link to object</a>');
   *     default:
   *       return NULL;
   *     }
   *   }
   * }
   * </code>
   */

  interface DataManipulatorInterface
  {
    /**
     * Allow manipulation of column-types.
     * Return NULL to maintain the original type.
     *
     * @param int Column index
     * @param string DB-derived value-type
     *
     * @return string|NULL
     */
    public function getColumnType($column, $valueType);

    /**
     * Allow manipulation of cell values.
     * Return NULL to maintain the original value.
     *
     * @param int $column Column index
     * @param Value $value DB-derived value
     *
     * @return Value|NULL
     */
    public function getCellValue($column, Value $value);
  }
?>
