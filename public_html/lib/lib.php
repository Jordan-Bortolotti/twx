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
<div id="content">Welcome to Wizard Echange!<br />
	<img src="https://avatars0.githubusercontent.com/u/3413101?s=400" alt="">
</div>
ZZEOF;
}

function output_search_page_content()
{
	echo<<<ZZEOF
<div id="content">
	<form action='search.php' id="search" method="get">
		<fieldset>
			<legend>Search</legend>
			<label  for="cname">Card Name: </label> <input type="text" name="cardName"><br>
			<label  for="cset">Card Set: </label><input type="text" name="cardSet"><br>
			<label  for="ccond">Card Condition: </label>
			<select name="cardCondition">
              <option value=""></option>			
			  <option value="Near Mint">Near Mint</option>
			  <option value="Lightly Played">Lightly Played</option>
			  <option value="Moderately Played">Moderately Played	</option>
			  <option value="Heavily Played">Heavily Played</option>
			  <option value="Damaged">Damaged</option>
			</select><br>
			<label  for="lf">Looking For: </label>
			<select name="exchangeType">
              <option value=""></option>			
			  <option value="Want">People who want this card</option>
			  <option value="Trade">People trading away this card</option>			  
			</select><br><br>
			<input type="submit" value="Search"><br><br>
		</fieldset>
	</form>
</div>
ZZEOF;
}

function output_search_table($tableValues)
{
echo<<<ZZEOF
<div id="searchContent">
	<table class="searchTable">
		<thead>
			<th>Card Name</th>
			<th>Card Set</th>
			<th>Card Condition</th>
			<th>Exchange Type</th>
			<th>Seller Name</th>
			<th>Seller Email</th>
		</thead>
		</tbody>
ZZEOF;
	foreach($tableValues as $row)
	{
		print "<tr>";
		foreach($row as $key => $value)
		{
			echo<<<ZZEOF
			<td>$value</td>				
ZZEOF;
		}
		print "</tr>";
	}
echo<<<ZZEOF
	</tbody>
	</table>	
</div>
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
ZZEOF;
	if(!empty($_SESSION['posterror']))
	{
		echo "<span class='error'>".$_SESSION['posterror']."</span><br />";
	}
		echo<<<ZZEOF
		<label for='r'>Purpose:</label>
		<input type="radio" name="r" value="Trade">To Trade</input>
		<br />
		<label for='r'>&nbsp;</label>
		<input type="radio" name="r" value="Want">Looking For</input>
		<br />
		<label for='cardname'>Card Name:</label>
		<input type='text' name='cardname' maxlength="50"/>
		<br />
		<label for='cardset'>Card Set:</label>
		<input type='text' name='cardset' maxlength="50"/>
		<br />
		<label for='condition'>Condition:</label>
		<select name="condition">
			<option value=""></option>
			<option value="Near Mint">Near Mint</option>
			<option value="Lightly Played">Lightly Played</option>
			<option value="Moderately Played">Moderately Played</option>
			<option value="Heavily Played">Heavily Played</option>
			<option value="Damaged">Damaged</option>
		</select>
		<!--<br />
		<label for="file">Filename:</label>
		<input type="file" name="file" id="file">-->
		<br /><br />
		<input type='submit' name='Submit' value='Submit'/>
	</fieldset>
</form>
ZZEOF;

	unset($_SESSION['posterror']);
	}
	else
	{
		echo<<<ZZEOF
<div id="content">Please login to post</div>
ZZEOF;
	}
}

function output_about_page_content()
{
	echo<<<ZZEOF
<div id="content">
	<p>The Wizard Exchange is a web community who's purpose is to connect Magic the Gathering players for trading, buying, and selling.</p>
	</ br>
		<ul>
			<li><b>Where to Begin</b>
			<li><b>How to Post</b>
			<li><b>How to Search</b>
			<li><b>Legal</b> 
		</ul>
	</p>	
</div>

ZZEOF;
}

function output_contact_page_content()
{
	echo<<<ZZEOF
<div id="content">
	<p>Send us an email and our support team will help resolve any issues you have regarding TWX.</p>
	<emailarea>Email Content here.</emailarea>
</div>	
ZZEOF;
}
	
function output_createuser_page_content()
{
	echo<<<ZZEOF
<form action='createuser.php' id="content" method='post' accept-charset='UTF-8'>
	<fieldset>
		<legend>New User</legend>
ZZEOF;
	if(!empty($_SESSION['createusererror']))
	{
		echo "<span class='error'>".$_SESSION['createusererror']."</span><br />";
	}
	echo<<<ZZEOF
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
		<br /><br />
		<input type='submit' name='NewUser' value='New User'/>
	</fieldset>
</form>
ZZEOF;

	unset($_SESSION['createusererror']);
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
ZZEOF;
		if(!empty($_SESSION['loginerror']))
		{
			echo "<span class='error'>".$_SESSION['loginerror']."</span><br />";
		}
		echo<<<ZZEOF
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
	unset($_SESSION['loginerror']);
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
