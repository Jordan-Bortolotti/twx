<?php
	require_once('lib/dblibs.php');
	
	if(isset($_POST['NewUser']))
	{
		$_SESSION['createuser'] = $_POST;
		header('Location: createuser.php');
		exit;
	}
	else if(!db_verify_login($_POST['username'], $_POST['password']))
	{
		$_SESSION['loginerror'] = "Invalid login";
	}
	
	header('Location: main.php');
	exit;
?>