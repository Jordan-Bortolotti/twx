<?php
	require_once('lib/lib.php');

	output_html5_header(
		'Put up a card!',
		array("css/common.php")
	);

	output_page_menu();
	output_page_header();
	output_post_page_content();
	output_page_footer();

	output_html5_footer();
?>