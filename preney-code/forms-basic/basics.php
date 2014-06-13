<?php

header('Content-Type: text/plain');

print_r($_SERVER);


$a = array();

$b = array(
  'house' => 42,
  'car' => 'chevy',  
);

print_r($b);

if (strcmp($b['car'], 'chevy') == 0)
{
  echo 'The car is a chevy!'."\n";
}
else
{
  echo "Not a chevy!\n";
}


?>
