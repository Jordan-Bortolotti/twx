<?php
session_start();

if (!isset($_SESSION['loggedinas']))
  header('Location: login.php');

//==== Start of shop cart notes ====
// You can store your shopping cart in a $_SESSION variable, the file system, or a database.
// There are pros and cons to each. The easiest is the $_SESSION variable.
if (!isset($_SESSION['shopcart']))
  $_SESSION['shopcart'] = array();

// Now, when the adds or removes anything, you'd want to search this variable.
// If adding, then you'd be appending data (or incrementing a number if it is already 
// there), e.g., appending would like something like:
$_SESSION['shopcart'][] = array('prodid' => 5, 'numitems' => 4);
$_SESSION['shopcart'][] = array('prodid' => 7, 'numitems' => 1);

// This would happen in some action="" PHP script if invoked by a form, or, a PHP script 
// invoked via AJAX.
//
// To display the cart, simply foreach through it and connect the prodids with the ones in
// the database.
//==== End of shop cart notes. ===

//==== This is an example of a hard-coded database using a global variable. ====
$db = array();
$db[] = array('prodid' => '5', 'name' => 'Amarantine', 'price' => 3.23);
$db[] = array('prodid' => '7', 'name' => 'U2: Greatest Hits', 'price' => 17.00);
//==== End of hard-coded database. ====

?>
<html>
<head><title></title></head>
<body>
<?php echo 'You are logged in as: '.$_SESSION['loggedinas'].'.'; ?>
<pre>
<?php print_r($_SESSION); ?>
</pre>
</body>
</html>
