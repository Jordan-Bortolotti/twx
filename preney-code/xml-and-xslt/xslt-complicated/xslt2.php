<?php

/*
 * This file uses: myfile.xml and eg2.xsl.
 * It sets the showChapter parameter to whatever is assigned to 'id'.
 */

header('Content-Type: text/html');

$xmlFile = new DOMDocument();
$xmlFile->load('myfile.xml');

$xslFile = new DOMDocument();
$xslFile->load('eg2.xsl');

$proc = new XSLTProcessor();
$showChapterID = !isset($_GET['id']) ? 1 : $_GET['id'];
$proc->setParameter('', 'showChapter', $showChapterID);
$proc->importStylesheet($xslFile);
echo $proc->transformToXML($xmlFile);

?>
