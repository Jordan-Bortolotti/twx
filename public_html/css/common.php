<?php
require_once('../lib/lib.php');
do_page_prerequisites();
header('Content-Type: text/css');
?>
body {
  font: "Trebuchet MS", Verdana, sans-serif;
  background-color: #5C87B2;
  color: #696969;
}

#main {
  padding: 20px;
  background-color: #ffffff;
  border-radius: 0 4px 4px 4px;
}

h1 {
  font: Georgia, serif;
  border-bottom: 3px solid #cc9900;
  color: #996600;
}

/*#header {
  background-color: #F00;
}*/

/*#menu {
  background-color: #FF0;
}*/

/*#content {
  background-color: #F0F;
}*/

/*#footer {
  background-color: #0F0;
}*/

ul#menu
{
padding: 0px;
position: relative;
margin: 0;
}

ul#menu li
{
display: inline;
}

ul#menu li a
{
background-color: #ffffff;
padding: 10px 20px;
text-decoration: none;
line-height: 2.8em;
color: #034af3;
border-radius: 4px 4px 0 0;
}

ul#menu li a:hover
{
background-color: #e8eef4;
}

#login {
  float: right;
}

.error {
  color: #F00;
}

div#content label{
    display: inline-block;
    float: left;
    clear: left;
    width: 110px;
    text-align: left;
	color: #000000;
}

div#content  input {
  display: inline-block;
  float: left;
}