<?php
require_once('config.php');
require_once('dblibs.php');

// generatedata.com - auto generate data (if needed)

?>
<html>
  <head>
    <title>Administrator Page</title>
  </head>
  <body>
<?php
if ($DB_FIRST_ADMIN_ONLY !== TRUE)
{
?>
  <b>YOU MUST SET $DB_FIRST_ADMIN_ONLY = TRUE; in config.php 
  to use this page!</b>
<?php
} else {
?>
  <a href="dbinit.php">Initialize Database</a><br/>
  <a href="dbinit-exampledata.php">Populate Database With Example Data</a><br />
  <b>WHEN DONE SET $DB_FIRST_ADMIN_ONLY = FALSE; in config.php!</b>
<?php
}
?>
  </body>
</html>
