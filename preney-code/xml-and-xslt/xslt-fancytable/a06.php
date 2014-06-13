<?php
  if ($_SERVER['REQUEST_METHOD'] != 'GET')
    die;

  $sortByDB = array(
    'fn' => array('tag' => 'fname',        'type' => 'text'   ),
    'ln' => array('tag' => 'lname',        'type' => 'text'   ),
    'sa' => array('tag' => 'street',       'type' => 'text'   ),
    'c'  => array('tag' => 'city',         'type' => 'text'   ),
    'p'  => array('tag' => 'province',     'type' => 'text'   ),
    'pc' => array('tag' => 'postalcode',   'type' => 'text'   ),
    'ph' => array('tag' => 'phone',        'type' => 'text'   ),
    'e'  => array('tag' => 'email',        'type' => 'text'   ),
    's'  => array('tag' => 'annualsalary', 'type' => 'number' ),
  );

  // Process the sort by request...
  $sortBy = null;
  if (array_key_exists('s', $_GET))
  {
    $sortBy = $_GET['s'];
    if ($sortBy == 'i')
      $sortBy = null;
    elseif (array_key_exists($sortBy, $sortByDB))
      $sortBy = $sortByDB[$sortBy];
    else
      $sortBy = null;
  }


  // Process the XML document...
	$xml = new DOMDocument;
	$xml->load('a06-data.xml');

	$xsl = new DOMDocument;
	$xsl->load('a06-table.xsl');

	$proc = new XSLTProcessor();
	$proc->importStylesheet($xsl);		

  // Set the sorting parameters if $sortBy is not null...
  if ($sortBy != null)
  {
    $proc->setParameter(null, 'sortby', $sortBy['tag']);
    $proc->setParameter(null, 'type', $sortBy['type']);
    $proc->setParameter(null, 'order', 'ascending');
  }

  echo $proc->transformToXML($xml);
?>
