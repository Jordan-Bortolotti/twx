<?php

require_once('config.php');

session_start();
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

function db_CloseConnection()
{
	$db_connection_handle = NULL;
}

function db_init()
{
  global $DB_FIRST_ADMIN_ONLY;

  //if ($DB_FIRST_ADMIN_ONLY !== TRUE)
  // return TRUE;

  try
  {
    db_connect();
    return TRUE;
  }
  catch (PDOException $e)
  {
    //echo 'PDO ERROR: '.$e->getMessage()."\n";
    return FALSE;
  }
}

function db_add_new_user($user, $pass, $userEmail)
{
  global $db_connection_handle;

  $adjusted_pass = md5($pass);

  $user_array = array(':null' => null,':user' => $user, ':pass' => $adjusted_pass, ':userEmail' => $userEmail, ':totalTrades'=>'0');

  $sql = 'INSERT INTO Users VALUES (:null, :user, :pass, :userEmail, :totalTrades)';
  $st = $db_connection_handle->prepare($sql);
  $result = $st->execute($user_array);
}

function db_verify_login($user, $pass)
{
  global $db_connection_handle;

  $adjusted_pass = md5($pass);
  $user_array = array(':userName' => $user);
  $sql = 'SELECT * FROM Users WHERE userName=:userName';

  try
  {
    $st = $db_connection_handle->prepare($sql);
    $result = $st->execute($user_array);

	$us = $st->fetch();
	
	echo '<p>For each done</p>';
	echo $us['password'].' - '.$adjusted_pass;
    
	if (strcmp($us['password'], $adjusted_pass) == 0){
      $_SESSION['userID'] = $us['userid'];
	  $_SESSION['user'] = $us['username'];
	  return TRUE;
	}
	else
	{
		return FALSE;
	}
  }
  catch (PDOException $e)
  {
	echo '<p>EXCEPTION</p>';
    return FALSE;
  }
 }
  
function db_upload_card($cardName,$cardSet,$cardCondition,$exchangeType)
{
	global $db_connection_handle;
	
	$sql = 'INSERT INTO Cards VALUES (:null,:cardName, :cardSet, :cardCondition, :exchangeType, :userID)';
	$userID = $_SESSION['userID'];
	$card_array = array(':null' => null,':cardName' => $cardName, ':cardSet' => $cardSet, ':cardCondition' => $cardCondition, ':exchangeType' => $exchangeType,':userID' => $userID);
	
	try
	{
		$st = $db_connection_handle->prepare($sql);
		$result = $st->execute($card_array);
		return true;
	}catch(PDOException $e)
	{
		return false;
	}
}



?>