<?php
  namespace Google\Visualization\DataSource\Base;

  class DataSourceException extends \Exception
  {
    protected $reasonType;
    protected $messageToUser;

    public function __construct($reasonType, $messageToUser)
    {
      parent::__construct($messageToUser);
      $this->messageToUser = $messageToUser;
      $this->reasonType = $reasonType;
    }

    public function getMessageToUser()
    {
      return $this->messageToUser;
    }

    public function getReasonType()
    {
      return $this->reasonType;
    }
  }
?>
