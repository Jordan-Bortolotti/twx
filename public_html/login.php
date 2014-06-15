<?php
	require_once('lib/dblibs.php');
	
	if(isset($_POST['NewUser']))
	{
		$_SESSION['createuser'] = $_POST;
		header('Location: createuser.php');
		exit;
	}
	else
	{
		$_SESSION['login'] = $_POST;
		if(empty($_POST['username']))
		{
			$_SESSION['loginerror'] = "Username can't be empty";
		}
		else if(empty($_POST['password']))
		{
			$_SESSION['loginerror'] = "Password can't be empty";
		}
		else if(!db_verify_login($_POST['username'], $_POST['password']))
		{
			$_SESSION['loginerror'] = "Invalid login";
		}
	}
	
	header('Location: account.php');
	exit;
?>