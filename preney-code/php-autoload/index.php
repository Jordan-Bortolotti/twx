<?php
require_once('config.php');
header('Content-Type: text/plain');

$obj = new Simple();

echo $obj->getValue()."\n";

?>
