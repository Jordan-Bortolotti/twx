<?php
require_once('HTTPUtils.php');

function example_cleanup($filename,$readfileResult)
{
  if ($readfileResult === FALSE)
  {
    // an error occurred sending the file
    // do something (e.g., log it to the DB, email the admin, etc.)
  }
}

// Very silly example to send this file (which you'd never do in
// a real web site).
HTTPUtils::sendFile(
  'example.php', 
  'dload_example.dsadasdas', 
  'application/octet-stream', 
  'PHP Code',
  'example_cleanup'     // optional
);

?>
