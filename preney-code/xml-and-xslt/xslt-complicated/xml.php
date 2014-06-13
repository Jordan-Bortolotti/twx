<?php

header('Content-Type: text/xml');

$xmlFile = new DOMDocument();
$xmlFile->load('myfile.xml');
echo $xmlFile->saveXML();

?>
