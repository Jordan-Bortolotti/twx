<?php

$doc = new DOMDocument();
$xsl = new XSLTProcessor();

$doc->load('transform.xsl');
$xsl->importStyleSheet($doc);

$doc->load('simple.xml');
echo $xsl->transformToXML($doc);

?>
