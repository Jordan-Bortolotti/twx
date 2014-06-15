<?php
	require_once('lib/dblibs.php');
	require_once('lib/lib.php');

	if(user_logged_in() != 'admin')
	{
		send_user_to_url('main.php');
	}

	output_html5_header(
		'Admin Page',
		array("css/common.php")
	);
	output_page_menu();
	output_page_header();
	process_posts();
	process_deletions();
	output_page_footer();
	output_html5_footer();

	function process_posts()
	{
		$values = db_get_all_posts();

		if(!empty($values))
		{
			output_admin_table($values);
			output_delete_rows_button();
		}
		else
		{
			echo "<br><p class=search>There are no posts</p><br>";
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