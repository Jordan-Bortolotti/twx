<?php
	require_once('lib/lib.php');

	output_html5_header(
		'New User',
		array("css/common.php")
	);

	output_page_header();
	output_page_menu();
	output_createuser_page_content();
	output_page_footer();

	output_html5_footer();
?>