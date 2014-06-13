<?php
session_start();

/*
header('Content-Type: text/plain');
print_r($_POST);
exit(0);
 */

if (
  count($_POST) == 2 &&
  array_key_exists('login', $_POST) &&
  array_key_exists('pass', $_POST)
)
{
  $login = trim($_POST['login']);
  $pass = trim($_POST['pass']);
  // look up in db and then check (hard-coded here)...
  if ($login == 'preney' && $pass == 'abc123')
  {
    $_SESSION['loggedin'] = $login;
    header('Location: main.php');
    exit(0);
  }
  else
  {
    unset($_SESSION['loggedin']);
    header('Location: incorrectlogin.php');
    exit(0); 
  }
}
else
{
  unset($_SESSION['loggedin']);
  header('Location: login.php');
  exit(0);
}

?>
