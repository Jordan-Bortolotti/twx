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
  db_connect();
  global $db_connection_handle;

  $adjusted_pass = md5($pass);

  $user_array = array(':null' => null,':user' => $user, ':pass' => $adjusted_pass, ':userEmail' => $userEmail, ':totalTrades'=>'0');

  $sql = 'INSERT INTO Users VALUES (:null, :user, :pass, :userEmail, :totalTrades)';
  $st = $db_connection_handle->prepare($sql);
  $result = $st->execute($user_array);
  
  db_CloseConnection();
}

function db_verify_login($user, $pass)
{
  db_connect();
  global $db_connection_handle;

  $adjusted_pass = md5($pass);
  $user_array = array(':userName' => $user);
  $sql = 'SELECT * FROM Users WHERE userName=:userName';

  try
  {
    $st = $db_connection_handle->prepare($sql);
    $result = $st->execute($user_array);

	$us = $st->fetch();
	
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
  db_CloseConnection();
 }
  
function db_upload_card($cardName,$cardSet,$cardCondition,$exchangeType)
{
    db_connect();
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
	db_CloseConnection();
}

function db_search_cards($choices = array())
{
	db_connect();
	global $db_connection_handle;
	
	//Begining of sql statements	
	$sql = "SELECT cardName, cardSet, cardCondition, exchangeType, userName, email FROM Cards INNER JOIN Users USING(userID) WHERE ";
	$execute_array = array();
	$i = 1;
	
	//Assemble search query based on the choice array
	foreach($choices as $searchType => $searchValue)
	{
		if ($i>1)
		{
			$sql = $sql." AND ";
		}		
		$sql = $sql.$searchType."=:".$searchType;
		$execute_array[':'.$searchType] =  $searchValue;
		$i++;
	}
	//Begin Processing
	$st = $db_connection_handle->prepare($sql);
	$result = $st->execute($execute_array);
	$us = $st->fetchAll(PDO::FETCH_ASSOC);
	
	return $us;
	
	db_CloseConnection();	
}



?>