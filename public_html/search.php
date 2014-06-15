<?php
	require_once('lib/lib.php');
	require_once('lib/dblibs.php');

	output_html5_header(
		'Search',
		array("css/common.php"),
		array("lib/libjs.js")
	);

	output_page_menu();
	output_page_header();
	output_search_page_content();
	process_search();
	output_page_footer();

	output_html5_footer();
	
	function process_search()
	{
		if (!empty($_GET))
		{
			$choice_array = array();
			
			if(!empty($_GET['cardName']))
			{
				$choice_array["cardName"] = trim($_GET['cardName']);
			}
			if(!empty($_GET['cardSet']))
			{
				$choice_array["cardSet"] = trim($_GET['cardSet']);
			}
			if(!empty($_GET['cardCondition']))
			{
				$choice_array["cardCondition"] = trim($_GET['cardCondition']);
			}
			if(!empty($_GET['exchangeType']))
			{
				$choice_array["exchangeType"] = trim($_GET['exchangeType']);
			}
			
			if(count($choice_array)>0)
			{
				$arrValues = db_search_cards($choice_array);
				
				if (!empty($arrValues))
				{
					echo "<br><p class=search> Search Results </p><br>";
					output_search_table($arrValues);				
				}else
				{
					echo "<br><p class=search> Search returned no results.</p><br>";
				}
			}
		}
	}
	
?>