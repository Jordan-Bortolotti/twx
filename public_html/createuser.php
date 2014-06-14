<?php
	require_once('lib/lib.php');

	if(!empty($_POST))
	{
		output_html5_header(
			'New User',
			array("css/common.php")
		);

		output_page_menu();
		output_page_header();
		
		foreach($_POST as $key => $value)
		{
			echo<<<ZZEOF
<p>$key = $value</p>
ZZEOF;
		}

		output_page_footer();

		output_html5_footer();
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