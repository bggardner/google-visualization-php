<?php
  namespace Google\Visualization\DataSource\Base;

  use Locale;

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
      $bundle = new $bundleName();
      return $bundle->getString($key, $locale);
    }

    public static function getLocalizedMessageFromBundleWithArguments($bundleName, $key, $args, $locale)
    {
      $rawMessage = self::getLocalizedMessageFromBundle($bundleName, $key, $locale);
      for ($i = 0; $i < count($args); $i++)
      {
        $rawMessage = preg_replace("/\{" . $i . "\}/", $args[$i], $rawMessage); // TODO: Avoid replacing escaped braces
      }
      return $rawMessage;
    }
  }
?>
