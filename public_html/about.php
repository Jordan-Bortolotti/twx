<?php
	require_once('lib/lib.php');

	output_html5_header(
		'About Us',
		array("css/common.php")
	);

	output_page_menu();
	output_page_header();
	output_about_page_content();
	output_page_footer();

	output_html5_footer();
?>
