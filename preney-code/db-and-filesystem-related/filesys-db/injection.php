<?php

?>
<html>
<head><title></title></head>
<body>
<?php
  if (isset($_POST['submit']))
  {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    foreach ($_POST as $k => $v)
    {
      echo '<p>'.htmlspecialchars($v).'</p>';
    }
    echo '<hr />';
  }
?>
  <form action="injection.php" method="post">
    <input type="tf" name="tf" />
    <textarea name="ta" rows="3" cols="20"></textarea>
    <input type="submit" name="submit" value="Send" />
  </form>
</body>
</html>  
