<?php

final class FileLock
{
  private $path;
  private $fp;
  private $inUse;

  public function __construct($path)
  {
    $this->path = $path;
    $this->fp = fopen($path, "w");
    $this->inUse = false;
  }

  public function __destruct()
  {
    $this->releaseLock();
    fclose($this->fp);
    unlink($this->path);
  }

  public function requestReadLock()
  {
    if ($this->inUse === false)
      $this->inUse = flock($this->fp, LOCK_SH);
    return $this->inUse;
  }

  public function requestWriteLock()
  {
    if ($this->inUse === false)
      $this->inUse = flock($this->fp, LOCK_EX);
    return $this->inUse;
  }

  public function releaseLock()
  {
    if ($this->inUse === true)
    {
      $retval = flock($this->fp, LOCK_UN);
      $this->inUse = false;
      return $retval;
    }
    else
      return false;
  }
}

?>
