<?php
require_once('../lib/lib.php');
do_page_prerequisites();
header('Content-Type: text/css');
?>
#header {
  background-color: #F00;
}

#menu {
  background-color: #FF0;
}

#content {
  background-color: #F0F;
}

#footer {
  background-color: #0F0;
}

#menu :link, 
#menu :visited {
  color: #FF0;
  text-decoration: normal;
}

#menu ul li {
  background-color: #070;
  color: #F0F;
}

#menu ul {
  list-style-type: none;
}

#menu li:hover,
#menu li:focus {
  background-color: #FF0;
  color: #070;
}
#menu a:hover
{
  background-color: black;
}

#login {
  float: right;
}