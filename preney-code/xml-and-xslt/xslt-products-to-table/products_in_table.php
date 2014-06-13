<?php

/*
 * This file uses: myfile.xml and eg.xsl.
 * It sets the showChapter parameter to whatever is assigned to 'id'.
 */

header('Content-Type: text/xml');

$xmlFile = new DOMDocument();
$xmlFile->load('productsdb.xml');

$xslFile = new DOMDocument();
$xslFile->load('products_to_table_v2.xsl');

$proc = new XSLTProcessor();
$proc->importStylesheet($xslFile);
echo $proc->transformToXML($xmlFile);

?>
