<?php
  namespace Google\Visualization\DataSource\Base;

  use Locale;
  use MessageFormatter;
  use ResourceBundle;

  class LocaleUtil
  {
    const LOCALE_PATTERN = "/(^[^_-]*)(?:[_-]([^_-]*)(?:[_-]([^_-]*))?)?/";

    protected static $defaultLocale;

    public static function setDefaultLocale($defaultLocale)
    {
      self::$defaultLocale = $defaultLocale;
    }

    public static function getDefaultLocale()
    {
      if (!isset($defaultLocale))
      {
        self::$defaultLocale = Locale::getDefault();
      }
      return self::$defaultLocale;
    }

    public static function getLocalizedMessageFromBundle($bundleName, $key, $locale)
    {
      $bundleName = str_replace(__NAMESPACE__ . "\\", __DIR__ . DIRECTORY_SEPARATOR, $bundleName);
      $rb = ResourceBundle::create($locale, $bundleName , TRUE);
      if (!($rb instanceof ResourceBundle))
      {
        $rb = ResourceBundle::create($locale, NULL , TRUE);
        $messageToUser = "Server Error: ResourceBundle could not be created (" . intl_error_name(intl_get_error_code()) . ").";
        return $messageToUser;
      }
      return $rb->get($key);
    }

    public static function getLocalizedMessageFromBundleWithArguments($bundleName, $key, $args, $locale)
    {
      $rawMessage = self::getLocalizedMessageFromBundle($bundleName, $key, $locale);
      if (!is_null($args) && count($args))
      {
        return MessageFormatter::formatMessage($locale, $rawMessage, $args);
      }
      return $rawMessage;
    }
  }
?>
