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
  padding: 20px;
  background-color: #ffffff;
  border-radius: 0 4px 4px 4px;
}

#login label {
  display: inline-block;
  float: left;
  clear: left;
  width: 90px;
  text-align: left;
}

#login input {
  display: inline-block;
  float: left;
}

.error {
  color: #F00;
}

#content label{
    display: inline-block;
    float: left;
    clear: left;
    width: 110px;
    text-align: left;
	color: #000000;
}

#content  input, select {
  display: inline-block;
  float: left;
}

div#seachContent table, th, td {
	color: #000000;
    border: 1px solid black;
}

div#searchCheckboxes {
	color: #000000;
}

p.search {
	color: #000000;
	font-size:150%;
}

#cardSetCheckbox {
    display: none;
}

#cardConditionCheckbox {
    display: none;
}

#exchangeTypeCheckbox {
	display: none;
}