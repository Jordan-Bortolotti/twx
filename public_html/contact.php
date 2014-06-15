<?php
	require_once('lib/lib.php');

	if(!empty($_POST))
	{
		do_page_prerequisites();
		$_SESSION['contact'] = "Your email has been sent, thanks!";

		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['mce_0'];

		$subject = "The Wizard Exchange Contact Us";
		$to = 'hemstoc@uwindsor.ca';

		$headers = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/html; charset=iso-8859-1";
		$headers[] = "From: $name <$email>";
		$headers[] = "Subject: $subject";
		//$headers[] = "X-Mailer: PHP/".phpversion();

		mail($to, $subject, $message, implode("\r\n", $headers));

		send_user_to_url('contact.php');
	}
	else
	{
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
	}

?>
