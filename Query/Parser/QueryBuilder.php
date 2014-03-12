<?php
  namespace Google\Visualization\DataSource\Query\Parser;

  use Google\Visualization\DataSource\Query\Query;

  class QueryBuilder
  {
    public static function parseQuery($tqValue)
    {
      if (empty($tqValue))
      {
        $query = new Query();
      } else
      {
        try
        {
          $query = QueryParser::parseString($tqValue);
        } catch (ParseException $ex)
        {
          $messageToUserAndLog = $ex->getMessage();
          throw new InvalidQueryException(MessagesEnum::PARSE_ERROR . ": ". $messageToUserAndLog);
        }
        $query->validate();
      }
      return $query;
    }
  }
?>
