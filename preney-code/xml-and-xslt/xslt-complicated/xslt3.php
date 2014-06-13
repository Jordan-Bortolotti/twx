<?php

/*
 * This file uses: myfile2.xml and eg3.xsl.
 * It sets the showChapter parameter to whatever is assigned to 'id'.
 */


header('Content-Type: text/html');

$xmlFile = new DOMDocument();
$xmlFile->load('myfile2.xml');

$xslFile = new DOMDocument();
$xslFile->load('eg3.xsl');

$proc = new XSLTProcessor();
$showChapterID = !isset($_GET['id']) ? 'alpha' : $_GET['id'];
$proc->setParameter('', 'showChapter', $showChapterID);
$proc->importStylesheet($xslFile);
echo $proc->transformToXML($xmlFile);

?>
