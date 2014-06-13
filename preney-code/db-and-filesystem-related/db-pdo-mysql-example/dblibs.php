<?php

require_once('config.php');

$db_connection_handle = NULL;

function db_connect()
{
  global $DBUSER, $DBPASS, $DBNAME, $db_connection_handle;

  $db_connection_handle = 
    new PDO("mysql:host=localhost;dbname=$DBNAME", $DBUSER, $DBPASS);
  $db_connection_handle->
    setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db_connection_handle->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
  $db_connection_handle->
    setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
}

function db_create_user_table($drop = TRUE)
{
  global $db_connection_handle;

  if ($drop)
  {
    $sql = "DROP TABLE IF EXISTS users";
    $result = $db_connection_handle->exec($sql);
  }

  $sql = <<<ZZEOF
CREATE TABLE users (
  login VARCHAR(80) PRIMARY KEY,
  pass VARCHAR(40) NOT NULL
)
ZZEOF;
  $result = $db_connection_handle->exec($sql);

  return $result;
}

function db_init()
{
  global $DB_FIRST_ADMIN_ONLY;

  if ($DB_FIRST_ADMIN_ONLY !== TRUE)
    return TRUE;

  try
  {
    db_connect();
    db_create_user_table();
    return TRUE;
  }
  catch (PDOException $e)
  {
    //echo 'PDO ERROR: '.$e->getMessage()."\n";
    return FALSE;
  }
}

function db_add_new_user($user, $pass, $do_hash = TRUE)
{
  global $db_connection_handle;

  $adjusted_pass = $do_hash == TRUE ? sha1($pass) : $pass;

  $user_array = array(':user' => $user, ':pass' => $adjusted_pass);

  $sql = 'INSERT INTO users VALUES (:user, :pass)';
  $st = $db_connection_handle->prepare($sql);
  $result = $st->execute($user_array);
}

function db_check_user($user, $pass, $do_hash = TRUE)
{
  global $db_connection_handle;

  $adjusted_pass = $do_hash == TRUE ? sha1($pass) : $pass;
  $user_array = array(':user' => $user);
  $sql = 'SELECT pass FROM users WHERE user=:user';

  try
  {
    $st = $db_connection_handle->prepare($sql);
    $result = $st->execute($user_array);

    if (strcmp($result['pass'], $adjusted_pass) == 0)
      return TRUE;
  }
  catch (PDOException $e)
  {
    return FALSE;
  }
}



?>
