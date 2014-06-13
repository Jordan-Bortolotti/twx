<?php

/*
  Strategy
  ========

  The User class permits:
    - The ability to lookup, create, modify, and delete users in a persistent
      user database using the static functions of the same names.
    - The User class maintains a user database, stored as an XML file whose
      format is:
        <user>
          <userName>a_userId</userName>
          <password>a_password</password>
          <fullName>Mr. John Doe</fullName>
          <emailAddress>john.doe@acme.com</emailAddress>
          <isDisabled>false</isDisabled>
          <isRegistered>true</isRegistered>
          <isAdmin>false</isAdmin>
        </user>
    - The User.xsd schema should match the above.
    - Editing the XML file is strongly discouraged.
 
  File specifics:
    - Each user is stored in its own file.
      - Filename: <userId>.db   (in the userPath() directory)
    - Access is guarded by lock files named:
        <userId>.db.lock

  Efficiency Notes:
    - lookupAllUserNames()
      - Must find all *.db files in the user db directory.
      - O(n), where n is the number of users.
    - lookupAllAdmins(), lookupAllAuthors(), lookupAllReviewers()
      - Must load all *.db files in the user db directory.
      - Loaded users are made into User objects.
      - O(n), where n is the number of users; slower than lookupAllUserNames()
    - lookupAll*() can be made more efficient by maintaining files that 
      efficiently cache such answers. Normally, one would use a SQL database
      for this, but, if the number of users does not get large, this is a
      non-issue. Further, these functions are only called for some of the 
      operations done by the admin user.
*/

final class User
{
  private $data;

  // This next function must have a unique UNKNOWN directory name if it is
  // located in the web mount. It would be better to have this path as a global
  // variable in config.php...
  public static function userPath()
  {
    return dirname(__FILE__).'/users/yEWuiw82';
  }

  //---------------------------------------------------------------------------

  public function __construct(DOMDocument $doc = null)
  {
    $this->data = array(
      'userName' => null,
      'password' => null,
      'fullName' => null,
      'emailAddress' => null,
      'isDisabled' => false,
      'isRegistered' => false,
      'isAdmin' => false,
    );

    if ($doc != null)
      $this->load($doc);
  }

  public function __get($name)
  {
    if (array_key_exists($name, $this->data))
      return $this->data[$name];

    $trace = debug_backtrace();
    trigger_error(
      'Undefined property: '.$name.' in '. $trace[0]['file'].
      ' on line '.$trace[0]['line'],E_USER_NOTICE
    );
    return null;
  }

  public function __set($name, $value)
  {
    $isOkay = 0;

    switch ($name)
    {
      case 'userName':
      case 'password':
      users/case 'fullName':
      case 'emailAddress':
        if (is_string($value))
          $this->data[$name] = $value;
        else
          $isOkay = 1;
        break;

      case 'isDisabled':
      case 'isRegistered':
      case 'isAdmin':
        if (is_bool($value))
          $this->data[$name] = $value;
        else
          $isOkay = 1;
        break;

      default:
        $isOkay = 2;
    }

    switch ($isOkay)
    {
      case 0:
        break;

      case 1:
        $trace = debug_backtrace();
        trigger_error(
          'Incorrect type assignment for property: '.$name.' in '.
          $trace[0]['file'].' on line '.$trace[0]['line'],E_USER_NOTICE
        );
        break;

      case 2:
        $trace = debug_backtrace();
        trigger_error(
          'Undefined property: '.$name.' in '.$trace[0]['file'].
          ' on line '.$trace[0]['line'],E_USER_NOTICE
        );
        break;
    }
  }

  public static function lookupAllUserNames()
  {
    $retval = array();
    if ($dp = opendir(User::userPath()))
    {
      while (($file = readdir($dp)) !== false)
      {
        $info = pathinfo($file);
        if (strcmp($info['extension'],'db') == 0)
          $retval[] = $info['filename'];
      }
      closedir($dp);
    }

    return $retval;
  }
  
  public static function lookupAllAdmins()
  {
    $retval = array();
    $allUsers = User::lookupAllUserNames();
    foreach ($allUsers as $user)
    {
      $userDoc = User::lookup($user);
      if ($userDoc->isAdmin)
        $retval[] = $user;
    }

    return $retval;
  }

  public static function lookup($userName)
  {
    if ($userName == null)
      return null;

    $path = User::userPath().'/'.$userName.'.db';
    if (file_exists($path))
    {
      $lock = new FileLock($path.'.lock');
      $lock->requestReadLock();
      $userObj = @DOMDocument::load($path);
      $lock->releaseLock();
      if ($userObj != null || $userObj != false)
        return new User($userObj);
    }
    
    return null;
  }

  public static function create($userName, $pass, $fullName, $emailAddress, 
    $isReg, $isDisabled=false, $isAdmin=false)
  {
    if ($userName == null)
      throw new SiteException('Invalid login/user id.', 'INVALID_USERID');

    $path = User::userPath().'/'.$userName.'.db';
    if (file_exists($path))
      throw new SiteException('Login already exists.', 'USERID_ALREADY_EXISTS');

    $userObj = new User;
    $userObj->userName = $userName;
    $userObj->password = $pass;
    $userObj->fullName = $fullName;
    $userObj->emailAddress = $emailAddress;
    $userObj->isAdmin = $isAdmin;
    $userObj->isRegistered = $isReg;
    $userObj->isDisabled = $isDisabled;

    if ($userObj->makePathsIfValid() === false)
      throw new SiteException('Unable to create user account.', 'BAD_PATHS');

    $lock = new FileLock($path.'.lock');
    $lock->requestWriteLock();

    $fp = fopen($path, 'w');
    if (fwrite($fp, $userObj->save()->saveXML()) === false)
    {
      fclose($fp);
      unlink($path);
      $lock->releaseLock();
      throw new SiteException('Unable to create user account.', 'WRITE_ERROR');
    }
    fclose($fp);

    $lock->releaseLock();

    return $userObj;
  }

  public static function modify(User $user)
  {
    if ($user == null)
      throw new SiteException('Invalid user.', 'INVALID_USERID');

    $path = User::userPath().'/'.$user->userName.'.db';
    if (!file_exists($path))
      throw new SiteException('User lookup error.', 'LOOKUP_ERROR');

    $user->makePathsIfValid();

    $lock = new FileLock($path.'.lock');
    $lock->requestWriteLock();

    $fp = fopen($path, 'w');
    if (fwrite($fp, $user->save()->saveXML()) === false)
    {
      fclose($fp);
      $lock->releaseLock();
      throw new SiteException('I/O error.', 'IO_ERROR');
    }
    fclose($fp);

    $lock->releaseLock();

    return true;
  }

  public static function delete($userName)
  {
    if ($userName == null)
      throw new SiteException('Invalid user.', 'INVALID_USERID');

    $path = User::userPath().'/'.$userName.'.db';

    $lock = new FileLock($path.'.lock');
    $lock->requestWriteLock();

    // Delete the author and reviewer directories if any...
    system('rm -rf "'.User::userPath().'/'.$userName.'.inf"');

    // Delete the user account...
    $retval = file_exists($path) && unlink($path);

    $lock->releaseLock();

    return $retval;
  }

  public function isValid()
  {
    return $this->userName !== null;
  }

  public function makePathsIfValid()
  {
    $SITE_MKDIR_MODE = 0777;
    if ($this->isValid())
    {
      if (!is_dir(User::userPath()))
        mkdir(User::userPath(), $SITE_MKDIR_MODE, true);
      $retval = is_dir(User::userPath());
      return $retval;
    }
    else
      return false;
  }

  public function load(DOMDocument $doc)
  {
    $path = new DOMXPath($doc);

    if ($doc->schemaValidate(dirname(__FILE__).'/User.xsd') == false)
      return false;

    foreach ($this->data as $k => $old)
    {
      $result = $path->query('/user/'.$k);
      foreach ($result as $n)
      {
        $v = $n->nodeValue;

        switch ($k)
        {
          case 'isDisabled':
          case 'isRegistered':
          case 'isAdmin':
            if (strcasecmp('true',$v) == 0)
              $v = true;
            elseif (strcasecmp('false',$v) == 0)
              $v = false;
            else
              $v = false;
            break;
        }

        $this->data[$k] = $v;
      }
    }
    
    return true;
  }

  public function save()
  {
    $retval = new DOMDocument();
    $root = $retval->createElement('user');
    foreach ($this->data as $k => $v)
    {
      if ($v === null)
        $elem = new DOMElement($k);
      if (is_bool($v))
        $elem = new DOMElement($k, $v ? 'true' : 'false');
      else
        $elem = new DOMElement($k, $v);
      $root->appendChild($elem);
    }
    $retval->appendChild($root);
    return $retval;
  }
}

?>
