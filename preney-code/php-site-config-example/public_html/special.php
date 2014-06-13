<?php
require_once('config.php');

header('Content-Type: text/plain');
readfile($PRIVATE_DIR.'/confidential.txt');

?>
