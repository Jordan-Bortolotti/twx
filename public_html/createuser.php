<?php
	require_once('lib/dblibs.php');
	require_once('lib/lib.php');

	if(!empty($_POST))
	{
		if(empty($_POST['username']))
		{
			$_SESSION['createusererror'] = "UserName is empty!";
		}
		else if(empty($_POST['email']))
		{
			$_SESSION['createusererror'] = "Email is empty!";
		}
		else if(empty($_POST['password1']))
		{
			$_SESSION['createusererror'] = "Password is empty!";
		}
		else if($_POST['password1'] != $_POST['password2'])
		{
			$_SESSION['createusererror'] = "Passwords don't match!";
		}
		else
		{
			db_add_new_user($_POST['username'], $_POST['password1'], $_POST['email']);
			if(!db_verify_login($_POST['username'], $_POST['password1']))
			{
				$_SESSION['createusererror'] = "Unable to create user";
			}
			else
			{
				header('Location: main.php');
				exit;
			}
		}
		header('Location: createuser.php');
		exit;
	}
	else
	{
		output_html5_header(
			'New User',
			array("css/common.php")
		);

		output_page_menu();
		output_page_header();
		output_createuser_page_content();
		output_page_footer();

		output_html5_footer();
	}
?>