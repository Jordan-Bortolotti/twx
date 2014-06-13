<?php
	require_once('lib/lib.php');

	output_html5_header(
		'Search',
		array("css/common.php")
	);

	output_page_header();
	output_page_menu();
	output_search_page_content();
	output_page_footer();

	output_html5_footer();
?>