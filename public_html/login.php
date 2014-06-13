<?php
	/*require_once('lib/dblib.php');*/
	session_start();

	if(isset($_POST['NewUser']))
	{
		header('Location: createuser.php');
	}
	else
	{
		if(empty($_POST['username']))
		{
			$_SESSION['error'] = "UserName is empty!";
			go_to_main();
		}

		if(empty($_POST['password']))
		{
			$_SESSION['error'] = "Password is empty!";
			go_to_main();
		}

		$_SESSION['user'] = trim($_POST['username']);
		go_to_main();
	}
	

	function go_to_main()
	{
		header('Location: main.php');
		exit;
	}
?>