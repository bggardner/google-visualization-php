<?php
  namespace Google\Visualization\DataSource\Base;

  class MessagesEnum
  {
    const INVALID_OFFSET = "INVALID_OFFSET";
    const NO_COLUMN = "NO_COLUMN";

    public static function getMessageWithArgs($type, $locale)
    {
      $args = array_slice(func_get_args(), 2);
      return LocaleUtil::getLocalizedMessageFromBundleWithArguments(__NAMESPACE__ . "\ErrorMessages", $type, $args, $locale);
    }
  }
?>
