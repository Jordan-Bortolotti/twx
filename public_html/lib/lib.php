<?php

function do_page_prerequisites()
{
	session_start();
}

function output_html5_header($title, $css = array(), $js = array())
{
  	do_page_prerequisites();
 	header('Content-Type: text/html');

  	$title = htmlspecialchars($title);

  	$link = '';
  	foreach ($css as $cssFile)
    	$link .= '<link rel="stylesheet" type="text/css" href="'.$cssFile.'" />';
  
  	$script = '';
  	foreach ($js as $jsFile)
    	$script .= '<script type="application/javascript" src="'.$jsFile.'"></script>';

  	echo <<<ZZEOF
<!DOCTYPE html>
<html>
<head>
	  <title>$title</title>
	  $link
	  $script
</head>
<body>
ZZEOF;
}

function output_html5_footer()
{
	echo<<<ZZEOF
</body>
</html>
ZZEOF;
}

function output_page_header()
{
	echo<<<ZZEOF
<div id="main"><h1>Wizard Exchange</h1>
ZZEOF;
}

function output_page_menu()
{
	echo<<<ZZEOF
<ul id="menu">
	<li><a href="main.php">Home</a></li>
	<li><a href="search.php">Search</a></li>
	<li><a href="post.php">Put up a card!</a></li>
	<li><a href="about.php">About</a></li>
	<li><a href="contact.php">Contact us</a></li>
</ul>
ZZEOF;
	output_login_content();
}

function output_home_page_content()
{
	echo<<<ZZEOF
<div id="content">Welcome to Wizard Echange!</div>
ZZEOF;
}

function output_search_page_content()
{
	echo<<<ZZEOF
<div id="content">Search page content!</div>
ZZEOF;
}

function output_post_page_content()
{
	if(is_user_logged_in())
	{
		echo<<<ZZEOF
<form action='post.php' id="content" method='post' accept-charset='UTF-8'>
	<fieldset>
		<legend>New Post</legend>
		<label for='cardname'>Card Name:</label>
		<input type='text' name='cardname' maxlength="50"/>
		<br />
		<label for='cardset'>Card Set:</label>
		<input type='text' name='cardset' maxlength="50"/>
		<br />
		<label for='condition'>Condition:</label>
		<select name="condition">
			<option value=""></option>
			<option value="nm">Near Mint</option>
			<option value="sp">Lightly Played</option>
			<option value="mp">Moderately Played</option>
			<option value="hp">Heavily Played</option>
			<option value="d">Damaged</option>
		</select>
		<br />
		<input type="radio" name="r" value="has">To Trade</input>
		<input type="radio" name="r" value="wants">Looking For</input>
		<br />
		<label for="file">Filename:</label>
		<input type="file" name="file" id="file">
		<br />
		<input type='submit' name='Submit' value='Submit'/>
	</fieldset>
</form>
ZZEOF;
	}
	else
	{
		echo<<<ZZEOF
<div id="content">Please login to post</div>
ZZEOF;
	}
}

function output_createuser_page_content()
{
	echo<<<ZZEOF
<form action='createuser.php' id="content" method='post' accept-charset='UTF-8'>
	<fieldset>
		<legend>New User</legend>
		<label for='username'>Username:</label>
		<input type='text' name='username' maxlength="50"/>
		<br />
		<label for='email'>Email:</label>
		<input type='text' name='email' maxlength="50"/>
		<br />
		<label for='password1'>Password:</label>
		<input type='password' name='password1' maxlength="50"/>
		<br />
		<label for='password2'>Re-enter:</label>
		<input type='password' name='password2' maxlength="50"/>
		<br />
		<input type='submit' name='NewUser' value='New User'/>
	</fieldset>
</form>
ZZEOF;
}

function output_login_content()
{
	if(is_user_logged_in())
	{
		echo<<<ZZEOF
<a id="login" href="logout.php">Logout</a>
ZZEOF;
	}
	else
	{
		echo<<<ZZEOF
<form id="login" action='login.php' method='post' accept-charset='UTF-8'>
	<fieldset>
		<legend>Login</legend>
		<label for='username'>Username:</label>
		<input type='text' name='username' maxlength="50"/>
		<br />
		<label for='password'>Password:</label>
		<input type='password' name='password' maxlength="50"/>
		<br />
		<input type='submit' name='Submit' value='Submit'/>
		<input type='submit' name='NewUser' value='New User'/>
	</fieldset>
</form>
ZZEOF;
	}
}

function output_page_footer()
{
	echo<<<ZZEOF
<div id="footer">&copy; 2014 TaGaJo. All rights reserved.</div>
</div>
ZZEOF;
}

function is_user_logged_in()
{
	return isset($_SESSION['user']);
}

function user_logged_in()
{
	if(is_user_logged_in())
		return $_SESSION['user'];
	else
		return FALSE;
}

function send_user_to_url($url)
{
	header('Location: '.$url);
	exit;
}
?>