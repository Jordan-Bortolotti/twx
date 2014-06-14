<?php
	require_once('lib/lib.php');

	output_html5_header(
		'Contact Us',
		array("css/common.php"),
		array("resources/tinymce/tinymce.min.js")
	);
	echo<<<ZZEOF
	<script>
		<!--tinymce script-->
		tinymce.init({selector:'emailarea'});
	</script>
ZZEOF;

	output_page_menu();
	output_page_header();
	output_contact_page_content();
	output_page_footer();

	output_html5_footer();
?>
