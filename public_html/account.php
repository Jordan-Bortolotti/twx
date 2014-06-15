<?php
	require_once('lib/dblibs.php');
	require_once('lib/lib.php');
	
	output_html5_header('Profile Page', array("css/common.php"));
	output_page_menu();
	output_page_header();
	output_account_page_content();
	process_user_posts();	
	process_deletions();
	output_page_footer();
	output_html5_footer();
	
	
	function process_user_posts()
	{
		$values = db_get_user_posts($_SESSION['userID']);
		
		if(!empty($values))
		{
			output_account_table($values);
			output_delete_rows_button();
		}else
		{
			echo "<br><p class=search>You have not uploaded anything! You can do so by clicking <a href=post.php>Here.</a></p><br>";
		}
	}
	
	function process_deletions()
	{		
		if(isset($_POST['deleteValues']))
		{			
			$values = trim($_POST['deleteValues']);
			$values = explode(",",$values);
			
			foreach($values as $record)
			{				
				if(ctype_digit(trim($record)))
				{					
					db_delete_post($record);
				}
			}
			unset($_POST['deleteValues']);
			header('Location: account.php');
		}
	}
?>