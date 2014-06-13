<?php

header('Content-Type: text/plain');

$dom = new DOMDocument();
$dom->load('address-book.xml');
$xsl = new DOMDocument();
$xsl->load('stylesheet.xsl');

$xslt = new XSLTProcessor();
$xslt->importStylesheet($xsl);

function setParm(&$xslt, $name, $array)
{
  if (isset($array[$name]))
    $xslt->setParameter(NULL, $name, $array[$name]);
}

setParm($xslt, 'city', $_GET);
setParm($xslt, 'state', $_GET);

echo $xslt->transformToXML($dom);

?>
