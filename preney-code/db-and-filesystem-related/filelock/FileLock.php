<?php
defined('SEXEC') or die('Restricted access');
/*
 * Written by Paul Preney.
 * This code allows one to lock files on the file system. Please read the
 * PHP documentation concerning restrictions on use as currently written.
*/

class FileLock
{
  private $filePath;
  private $fp;

  function __construct($filePath)
  {
    $this->filePath = $filePath.'.lock';
    $this->fp = fopen($this->filePath, 'w+');

    if ($this->fp === FALSE)
      throw new InvalidArgumentException(
        'Unable to open '.$filePath.' for writing.'
      );
  }

  function __destruct()
  {
    fclose($this->fp);
    if (file_exists($this->filePath))
      unlink($this->filePath);
  }

  function getFilePath()
  {
    return $this->filePath;
  }

  function requestReadLock()
  {
    if (!flock($this->fp, LOCK_SH))
      throw new RuntimeException('Unable to get read lock.');
  }

  function requestWriteLock()
  {
    if (!flock($this->fp, LOCK_EX))
      throw new RuntimeException('Unable to get write lock.');
  }

  function releaseLock()
  {
    if (!flock($this->fp, LOCK_UN))
      throw new RuntimeException('Unable to free lock.');
  }
}

?>
