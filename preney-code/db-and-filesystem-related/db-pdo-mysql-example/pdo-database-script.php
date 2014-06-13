<?php

require_once('config.php');

// Log to browser...
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', NULL);
//error_reporting(E_ALL); 

header('Content-Type: text/plain');

$db = NULL;
try
{
  $db = new PDO("mysql:host=localhost;dbname=$DBNAME", $DBUSER, $DBPASS);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
  $db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);

  $sql = "DROP TABLE IF EXISTS users";
  $result = $db->exec($sql);
  echo "CREATE TABLE: $result dropped.\n";
  


  // Let's create a user database...
  $sql = <<<ZZEOF
CREATE TABLE users (
  login VARCHAR(80) PRIMARY KEY,
  pass VARCHAR(40) NOT NULL
)
ZZEOF;

  $result = $db->exec($sql);
  echo "CREATE TABLE: $result created.\n";
}
catch (PDOException $e)
{
  echo 'PDO ERROR: '.$e->getMessage()."\n";
}

try
{
  // Let's add some users...
  $users = array(
    array(':user' => 'john', ':pass' => sha1('abc123')),
    array(':user' => 'sally', ':pass' => sha1('qwerty42')),
  );
  $sql = 'INSERT INTO users VALUES (:user, :pass)';
  $st = $db->prepare($sql);
  foreach ($users as $u)
  {
    $result = $st->execute($u);
    echo "INSERT INTO: $result rows inserted.\n";
  }

  // etc.
}
catch (PDOException $e)
{
  echo 'PDO ERROR: '.$e->getMessage()."\n";
}

try
{
  // Let's get some users...
  $sql = 'SELECT * FROM users WHERE login=:user';
  $st = $db->prepare($sql);
  $st->execute(array(':user' => 'sally'));
  //$us = $st->fetchAll();
  foreach ($us as $u)
  {
    print_r($u);
  }
}
catch (PDOException $e)
{
  echo 'PDO ERROR: '.$e->getMessage()."\n";
}


try
{
  // Let's get some users...
  $sql = 'UPDATE users SET pass=:pass WHERE login=:user';
  $st = $db->prepare($sql);
  $st->execute(
    array(':user' => 'sally', ':pass' => sha1('qwerty'))
  );
  echo "Yay! sally's password changed!\n";
}
catch (PDOException $e)
{
  echo 'PDO ERROR: '.$e->getMessage()."\n";
}

try
{
  // Let's get some users...
  $sql = 'DELETE FROM users WHERE login=:user';
  $st = $db->prepare($sql);
  $st->execute(
    array(':user' => 'sally')
  );
  echo "sally has been deleted\n";
}
catch (PDOException $e)
{
  echo 'PDO ERROR: '.$e->getMessage()."\n";
}


?>
