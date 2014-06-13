<?php

class UserDB
{
  CONST IDX_USERNAME = 0;
  CONST IDX_PASSWORD = 1;

  private $userdb;
  private $changed;
  private $lock;

  function __construct()
  {
    $this->changed = FALSE;

    $this->lock = new FileLock('user.db');

    $this->lock->requestReadLock();
    $f = file_get_contents('user.db');
    $this->lock->releaseLock();

    $recs = explode("\n", $f);

    foreach ($recs as $r)
      $this->userdb[] = explode(':', $r);
  }

  function __destruct()
  {
    $this->save();
  }

  function getHashedPassword($user)
  {
    foreach ($this->userdb as $r)
    {
      if ($r[IDX_USERNAME] == $user)
        return $r[IDX_PASSWORD];
    }
    return FALSE;
  }

  function addUser($user, $pass)
  {
    // check if already added, if not then...
    $this->userdb[] = array($user, md5($pass));
    $this->changed = TRUE;
    return TRUE;
  }

  function save()
  {
    if ($this->changed == FALSE)
      return;

    $this->lock->RequestWriteLock();
    $fp = fopen('user.db', 'w');
    foreach ($this->userdb as $r)
    {
      fwrite($fp, implode(':',$r)."\n");
    }
    fclose($fp);
    $this->lock->ReleaseLock();

    $this->changed = FALSE;
  }
}

?>
