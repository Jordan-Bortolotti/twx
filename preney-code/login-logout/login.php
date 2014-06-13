<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login or Logout!</title>
  </head>
  <body>
<?php
  if (array_key_exists('loggedin', $_SESSION))
  {
?>
  <p>Are you sure you want to log out? If so, then click this <a href="logout.php">link</a>!</p>
  <p>Otherwise <a href="main.php">click this</a> to go back to the main page.</p>
<?php
  } else {
?>
    <h1>Login Page</h1>
    <form action="trylogin.php" method="POST">
      <fieldset>
        <legend>Login</legend>
        Login: <input type="text" name="login" /></br >
        Password: <input type="password" name="pass" /><br />
        <input type="submit" value="Login" />
      </fieldset>
    </form>
<?php
  }
?>
  </body>
</html>
