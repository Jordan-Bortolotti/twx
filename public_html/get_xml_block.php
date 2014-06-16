<?php

header('Content-Type: text/xml');

$xml = new DOMDocument();
$xml->load('resources/legal.xml');

$xsl = new DOMDocument();
$xsl->load('resources/style.xsl');

$proc = new XSLTProcessor();
$proc->importStylesheet($xsl);
echo $proc->transformToXML($xml);

?>
