<?php
  namespace Google\Visualization\DataSource\Base;

  class MessagesEnum
  {
    const NO_COLUMN = "NO_COLUMN";
    const PARSE_ERROR = "PARSE_ERROR";
    const CANNOT_BE_IN_GROUP_BY = "CANNOT_BE_IN_GROUP_BY";
    const CANNOT_BE_IN_PIVOT = "CANNOT_BE_IN_PIVOT";
    const CANNOT_BE_IN_WHERE = "CANNOT_BE_IN_WHERE";
    const SELECT_WITH_AND_WITHOUT_AGG = "SELECT_WITH_AND_WITHOUT_AGG";
    const COL_AGG_NOT_IN_SELECT = "COL_AGG_NOT_IN_SELECT";
    const ADD_COL_TO_GROUP_BY_OR_AGG = "ADD_COL_TO_GROUP_BY_OR_AGG";
    const INVALID_OFFSET = "INVALID_OFFSET";
    const COLUMN_ONLY_ONCE = "COLUMN_ONLY_ONCE";

    public static function getMessageWithArgs($type, $locale, $args)
    {
      if (is_string($args)) { $args = array($args); }
      return LocaleUtil::getLocalizedMessageFromBundleWithArguments(__NAMESPACE__ . "\ErrorMessages", $type, $args, $locale);
    }
  }
?>
