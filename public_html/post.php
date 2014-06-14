<?php
	require_once('lib/dblibs.php');
	require_once('lib/lib.php');

	if(!empty($_POST))
	{
		if(empty($_POST['cardname']))
		{
			$_SESSION['posterror'] = "Please include a cardname";
		}
		else if(empty($_POST['cardset']))
		{
			$_SESSION['posterror'] = "Please include the card set";
		}
		else if(empty($_POST['condition']))
		{
			$_SESSION['posterror'] = "Please include the card's condition";
		}
		else if(empty($_POST['r']))
		{
			$_SESSION['posterror'] = "Please include the exchange type";
		}
		else if(!db_upload_card($_POST['cardname'], $_POST['cardset'], $_POST['condition'], $_POST['r']))
		{
			$_SESSION['posterror'] = "Unable to create posting";
		}
		else
		{
			$_SESSION['posterror'] = "Post successful";
		}
		header('Location: post.php');
		exit;
	}
	else
	{
		output_html5_header(
			'Put up a card!',
			array("css/common.php")
		);

		output_page_menu();
		output_page_header();
		output_post_page_content();
		output_page_footer();

		output_html5_footer();
	}
?>