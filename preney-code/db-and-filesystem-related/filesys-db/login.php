<?php
session_start();

if (count($_POST) > 0)
{
  if (isset($_POST['submit']))
  {
    if ($_POST['submit'] == 'Login')
    {
      if (isset($_POST['login'], $_POST['pass']))
      {
        if ($_POST['login'] == 'preney' && $_POST['pass'] == '12345')
          $_SESSION['loggedinas'] = $_POST['login'];
      }
      else
        unset($_SESSION['loggedinas']);
    }
    else if ($_POST['submit'] == 'Logout')
    {
      unset($_SESSION['loggedinas']);
    }
  }
  else
    unset($_SESSION['loggedinas']);
}

?>
<html>
<head><title></title></head>
<body>
<?php
if (!isset($_SESSION['loggedinas'])) 
{ ?>
<form action="login.php" method="post">
  <input type="text" name="login" />
  <input type="password" name="pass" />
  <input type="submit" name="submit" value="Login" />
</form>
<?php
} else {
?>
<form action="login.php" method="post">
  <input type="submit" name="submit" value="Logout" />
</form>
<?php
}
?>
</body>
</html>
