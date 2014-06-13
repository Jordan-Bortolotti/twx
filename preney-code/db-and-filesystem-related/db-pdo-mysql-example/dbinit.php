<?php
require_once('config.php');
require_once('dblibs.php');

$result = TRUE;
try
{
  db_connect();
  $result = db_init();
}
catch (PDOException $e)
{
  $result = FALSE;
}

if ($result === TRUE)
  header('Location: success.php');
else
  header('Location: error.php');

exit();

?>
