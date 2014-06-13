<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head><title>Main Page</title></head>
  <body>
    <h1>Main Page</h1>
<?php
  if (array_key_exists('loggedin', $_SESSION))
  {
?>
    <p><a href="login.php">Logout <?php echo htmlspecialchars($_SESSION['loggedin']); ?></a></p>
<?php
  } else {
?>
    <p><a href="login.php">Login</a></p>
<?php
  }
?>
  </body
</html>
