<?php

class SiteException extends Exception
{
  protected $ID;

  public function __construct($message, $ID, $code = 0) 
  { 
    parent::__construct($message, $code);
    $this->ID = $ID;
  }

  public function __toString() 
  {
    return __CLASS__ . ": [{$this->ID},{$this->code}]: {$this->message}\n";
  }

  public final function getID()
  {
    return $this->ID;
  }
}

?>
