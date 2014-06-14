<?php
	require_once('lib/dblibs.php');
	
	if(isset($_POST['NewUser']))
	{
		header('Location: createuser.php');
		exit;
	}
	else if(empty($_POST['username']))
	{
		$_SESSION['loginerror'] = "UserName is empty!";
	}
	else if(empty($_POST['password']))
	{
		$_SESSION['loginerror'] = "Password is empty!";
	}
	else if(!db_verify_login($_POST['username'], $_POST['password']))
	{
		$_SESSION['loginerror'] = "Invalid login";
	}
	
	header('Location: main.php');
	exit;
?>