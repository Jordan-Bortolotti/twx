<?php
	require_once('lib/lib.php');

	output_xhtml_header(
		'Wizard Exchange Home',
		array("css/common.php")
	);

	output_page_menu();
	output_page_header();
	output_home_page_content();
	output_page_footer();

	output_html5_footer();
?>
