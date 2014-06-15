<?php

function do_page_prerequisites()
{
	if(session_status() == PHP_SESSION_NONE)
	{
		session_start();
	}
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
	<img src="http://www.terminally-incoherent.com/blog/wp-content/uploads/2012/08/areyouawizard.png" alt="">
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
			<h2>Search Filter:</h2>
			<div id="searchCheckboxes">
				<input type="checkbox" id="chkCardName" checked onclick="toggleHide(this);">Card Name<br>
				<input type="checkbox" id="chkCardSet" onclick="toggleHide(this);">Card Set<br>
				<input type="checkbox" id="chkCardCondition" onclick="toggleHide(this);">Card Condition<br>
				<input type="checkbox" id="chkExchangeType" onclick="toggleHide(this);">Trade or Want<br>
				<br>
			</div>
			<div id="cardNameCheckbox"><label  for="cname">Card Name: </label> <input type="text" name="cardName"><br></div>
			<div id="cardSetCheckbox"><label  for="cset">Card Set: </label>
ZZEOF;
	echo_select_cardset('cardSet', FALSE);	//instead of <input type="text" name="cardSet">
	echo<<<ZZEOF
			<br></div>
			<div id="cardConditionCheckbox"><label  for="ccond">Card Condition: </label>
ZZEOF;
	echo_select_cardcondition('cardCondition', FALSE);
	echo<<<ZZEOF
			</div><br>
			<div id="exchangeTypeCheckbox"><label  for="lf">Looking For: </label>
			<select name="exchangeType">
              <option value=""></option>			
			  <option value="Want">People who want this card</option>
			  <option value="Trade">People trading away this card</option>			  
			</select></div><br><br>
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
			if($key == "email")
			{
				echo "<td><a href='mailto:".$value."?subject=The Wizard Exchange'>".$value."</td>";
			}
			else
			{
				echo<<<ZZEOF
			<td>$value</td>
ZZEOF;
			}
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
		<input required type="radio" name="r" value="Trade">To Trade</input>
		<br />
		<label for='r'>&nbsp;</label>
		<input required type="radio" name="r" value="Want">Looking For</input>
		<br />
		<label for='cardname'>Card Name:</label>
		<input required type='text' name='cardname' maxlength='50'/>
		<br />
		<label for='cardset'>Card Set:</label>
ZZEOF;
		echo_select_cardset('cardset', TRUE);
		echo<<<ZZEOF
		<!--<input required type='text' name='cardset' maxlength='50'/>-->
		<br />
		<label for='condition'>Condition:</label>
ZZEOF;
		echo_select_cardcondition('condition', TRUE);
		echo<<<ZZEOF
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
	<br />
		<ul>
			<li id="aboutlist"><b>Where to Begin</b>
				    <div id="wherebegin"><p>Begin by signing up with a username and password for full access to the site!This way you can both search and post wanted or sale ads on TWX. From there, look to make excanges with fellow wizards</p>
</div>
			</li>
			<li id="aboutlist"><b>How to Post</b>
			    <div id="howpost"><p>To post a wanted or selling ad, simply navigate to the Put up a card! menu option above and fill out a form.</p></div>
			</li>
			<li id="aboutlist"><b>How to Search</b>
			    <div id="howsearch"><p>To search for cards, navigate to the Search  panel and enter in the type, quality, and name of your card. Perhaps someone is selling the card you desperately want! Or maybe you've got enough Boros Reckoners that you'd like to sell one yourself. Search for that card, and maybe there's a buy order waiting for you.</p></div>
			</li>
			<li id="aboutlist" onclick="showhideXML('get_xml_block.php','legal');"><b>Legal (Click to Expand)</b>
			    <div id="legal">&nbsp;</div>
			</li> 
		</ul>
</div>

ZZEOF;
}

function output_contact_page_content()
{
	if(empty($_SESSION['contact']))
	{
		echo<<<ZZEOF
<form id='content' method='POST' action='contact.php'>
		<label for='name'>Name:</label>
		<input name='name' type='text'/><br />
		<label for='email'>Email:</label>
		<input name='email' type='text'/><br />
		<label for='comments'>Comments:</label><br />
		<emailarea name='comments'></emailarea>
		<input name='submit' type='submit' value='Send Message'/><br />
</form>
ZZEOF;
	}
	else
	{
		echo "<div id='content'>".$_SESSION['contact']."</div>";
		unset($_SESSION['contact']);
	}
	
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
ZZEOF;
		echo "<input required type='text' name='username' maxlength='50' value='".$_SESSION['createuser']['username']."'/>";
	echo<<<ZZEOF
		<br />
		<label for='email'>Email:</label>
ZZEOF;
		echo "<input required type='text' name='email' maxlength='50' value='".$_SESSION['createuser']['email']."'/>";
		echo<<<ZZEOF
		<br />
		<label for='password1'>Password:</label>
ZZEOF;
		echo "<input required type='password' name='password1' maxlength='50' value='".$_SESSION['createuser']['password']."'/'>";
		echo<<<ZZEOF
		<br />
		<label for='password2'>Confirm:</label>
		<input required type='password' name='password2' maxlength="50"/>
		<br /><br />
		<input type='submit' name='NewUser' value='New User'/>
	</fieldset>
</form>
ZZEOF;

	unset($_SESSION['createusererror']);
	unset($_SESSION['createuser']);
}

function output_login_content()
{
	if(is_user_logged_in())
	{
		echo '<a id="login" href="logout.php">Logout '.$_SESSION['user'].'</a>';
	}
	else
	{
		echo<<<ZZEOF
<div id="login">
	<form action='login.php' method='post' accept-charset='UTF-8'>
		<fieldset>
			<legend>Login</legend>
ZZEOF;
		if(!empty($_SESSION['loginerror']))
		{
			echo "<span class='error'>".$_SESSION['loginerror']."</span><br />";
		}
		echo<<<ZZEOF
			<label for='username'>Username:</label>
ZZEOF;
		echo "<input type='text' name='username' maxlength='50' value='".$_SESSION['login']['username']."'/>";
		echo<<<ZZEOF
			<br />
			<label for='password'>Password:</label>
ZZEOF;
		echo "<input type='password' name='password' maxlength='50' value='".$_SESSION['login']['password']."'/>";
		echo<<<ZZEOF
			<br />
			<input type='submit' name='Submit' value='Submit'/>
			<input type='submit' name='NewUser' value='New User'/>
		</fieldset>
	</form>
</div>
ZZEOF;
	}
	unset($_SESSION['loginerror']);
	unset($_SESSION['login']);
}
 
/*function get_html_block($htmlfile)
{
 $doc = new DOMDocument();
 $doc->loadHTMLFile("resources/$htmlfile");
 echo $doc->saveHTML();
}

function get_xml_block($xmlfile, $xslfile)
{
 header('Content-Type: text/xml');

 $xml = new DOMDocument();
 $xml->load("resources/$xmlfile");

 $xsl = new DOMDocument();
 $xsl->load("resources/$xslfile");

 $proc = new XSLTProcessor();
 $proc->importStylesheet($xsl);
 echo $proc->transformToXML($xml);
}*/

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

function echo_select_cardset($name, $required)
{
	if($required)
		echo "<select required name='".$name."'>";
	else
		echo "<select name='".$name."'>";
	echo<<<ZZEOF
	<option value=""></option>
	<option value="Alara Reborn">Alara Reborn</option>
	<option value="Alliances">Alliances</option>
	<option value="Antiquities">Antiquities</option>
	<option value="Apocalypse">Apocalypse</option>
	<option value="Arabian Nights">Arabian Nights</option>
	<option value="Archenemy">Archenemy</option>
	<option value="Avacyn Restored">Avacyn Restored</option>
	<option value="Battle Royale Box Set">Battle Royale Box Set</option>
	<option value="Beatdown Box Set">Beatdown Box Set</option>
	<option value="Betrayers of Kamigawa">Betrayers of Kamigawa</option>
	<option value="Born of the Gods">Born of the Gods</option>
	<option value="Champions of Kamigawa">Champions of Kamigawa</option>
	<option value="Chronicles">Chronicles</option>
	<option value="Classic Sixth Edition">Classic Sixth Edition</option>
	<option value="Coldsnap">Coldsnap</option>
	<option value="Commander 2013 Edition">Commander 2013 Edition</option>
	<option value="Commander's Arsenal">Commander's Arsenal</option>
	<option value="Conflux">Conflux</option>
	<option value="Dark Ascension">Dark Ascension</option>
	<option value="Darksteel">Darksteel</option>
	<option value="Dissension">Dissension</option>
	<option value="Dragon's Maze">Dragon's Maze</option>
	<option value="Duel Decks: Ajani vs. Nicol Bolas">Duel Decks: Ajani vs. Nicol Bolas</option>
	<option value="Duel Decks: Divine vs. Demonic">Duel Decks: Divine vs. Demonic</option>
	<option value="Duel Decks: Elspeth vs. Tezzeret">Duel Decks: Elspeth vs. Tezzeret</option>
	<option value="Duel Decks: Elves vs. Goblins">Duel Decks: Elves vs. Goblins</option>
	<option value="Duel Decks: Garruk vs. Liliana">Duel Decks: Garruk vs. Liliana</option>
	<option value="Duel Decks: Heroes vs. Monsters">Duel Decks: Heroes vs. Monsters</option>
	<option value="Duel Decks: Izzet vs. Golgari">Duel Decks: Izzet vs. Golgari</option>
	<option value="Duel Decks: Jace vs. Chandra">Duel Decks: Jace vs. Chandra</option>
	<option value="Duel Decks: Jace vs. Vraska">Duel Decks: Jace vs. Vraska</option>
	<option value="Duel Decks: Knights vs. Dragons">Duel Decks: Knights vs. Dragons</option>
	<option value="Duel Decks: Phyrexia vs. the Coalition">Duel Decks: Phyrexia vs. the Coalition</option>
	<option value="Duel Decks: Sorin vs. Tibalt">Duel Decks: Sorin vs. Tibalt</option>
	<option value="Duel Decks: Venser vs. Koth">Duel Decks: Venser vs. Koth</option>
	<option value="Eighth Edition">Eighth Edition</option>
	<option value="Eventide">Eventide</option>
	<option value="Exodus">Exodus</option>
	<option value="Fallen Empires">Fallen Empires</option>
	<option value="Fifth Dawn">Fifth Dawn</option>
	<option value="Fifth Edition">Fifth Edition</option>
	<option value="Fourth Edition">Fourth Edition</option>
	<option value="From the Vault: Dragons">From the Vault: Dragons</option>
	<option value="From the Vault: Exiled">From the Vault: Exiled</option>
	<option value="From the Vault: Legends">From the Vault: Legends</option>
	<option value="From the Vault: Realms">From the Vault: Realms</option>
	<option value="From the Vault: Relics">From the Vault: Relics</option>
	<option value="From the Vault: Twenty">From the Vault: Twenty</option>
	<option value="Future Sight">Future Sight</option>
	<option value="Gatecrash">Gatecrash</option>
	<option value="Guildpact">Guildpact</option>
	<option value="Homelands">Homelands</option>
	<option value="Ice Age">Ice Age</option>
	<option value="Innistrad">Innistrad</option>
	<option value="Invasion">Invasion</option>
	<option value="Journey into Nyx">Journey into Nyx</option>
	<option value="Judgment">Judgment</option>
	<option value="Legends">Legends</option>
	<option value="Legions">Legions</option>
	<option value="Limited Edition Alpha">Limited Edition Alpha</option>
	<option value="Limited Edition Beta">Limited Edition Beta</option>
	<option value="Lorwyn">Lorwyn</option>
	<option value="Magic 2010">Magic 2010</option>
	<option value="Magic 2011">Magic 2011</option>
	<option value="Magic 2012">Magic 2012</option>
	<option value="Magic 2013">Magic 2013</option>
	<option value="Magic 2014 Core Set">Magic 2014 Core Set</option>
	<option value="Magic: The Gathering-Commander">Magic: The Gathering-Commander</option>
	<option value="Magic: The Gathering—Conspiracy">Magic: The Gathering—Conspiracy</option>
	<option value="Masters Edition">Masters Edition</option>
	<option value="Masters Edition II">Masters Edition II</option>
	<option value="Masters Edition III">Masters Edition III</option>
	<option value="Masters Edition IV">Masters Edition IV</option>
	<option value="Mercadian Masques">Mercadian Masques</option>
	<option value="Mirage">Mirage</option>
	<option value="Mirrodin">Mirrodin</option>
	<option value="Mirrodin Besieged">Mirrodin Besieged</option>
	<option value="Modern Event Deck 2014">Modern Event Deck 2014</option>
	<option value="Modern Masters">Modern Masters</option>
	<option value="Morningtide">Morningtide</option>
	<option value="Nemesis">Nemesis</option>
	<option value="New Phyrexia">New Phyrexia</option>
	<option value="Ninth Edition">Ninth Edition</option>
	<option value="Odyssey">Odyssey</option>
	<option value="Onslaught">Onslaught</option>
	<option value="Planar Chaos">Planar Chaos</option>
	<option value="Planechase">Planechase</option>
	<option value="Planechase 2012 Edition">Planechase 2012 Edition</option>
	<option value="Planeshift">Planeshift</option>
	<option value="Portal">Portal</option>
	<option value="Portal Second Age">Portal Second Age</option>
	<option value="Portal Three Kingdoms">Portal Three Kingdoms</option>
	<option value="Premium Deck Series: Fire and Lightning">Premium Deck Series: Fire and Lightning</option>
	<option value="Premium Deck Series: Graveborn">Premium Deck Series: Graveborn</option>
	<option value="Premium Deck Series: Slivers">Premium Deck Series: Slivers</option>
	<option value="Promo set for Gatherer">Promo set for Gatherer</option>
	<option value="Prophecy">Prophecy</option>
	<option value="Ravnica: City of Guilds">Ravnica: City of Guilds</option>
	<option value="Return to Ravnica">Return to Ravnica</option>
	<option value="Revised Edition">Revised Edition</option>
	<option value="Rise of the Eldrazi">Rise of the Eldrazi</option>
	<option value="Saviors of Kamigawa">Saviors of Kamigawa</option>
	<option value="Scars of Mirrodin">Scars of Mirrodin</option>
	<option value="Scourge">Scourge</option>
	<option value="Seventh Edition">Seventh Edition</option>
	<option value="Shadowmoor">Shadowmoor</option>
	<option value="Shards of Alara">Shards of Alara</option>
	<option value="Starter 1999">Starter 1999</option>
	<option value="Starter 2000">Starter 2000</option>
	<option value="Stronghold">Stronghold</option>
	<option value="Tempest">Tempest</option>
	<option value="Tenth Edition">Tenth Edition</option>
	<option value="The Dark">The Dark</option>
	<option value="Theros">Theros</option>
	<option value="Time Spiral">Time Spiral</option>
	<option value="Time Spiral &quot;Timeshifted&quot;">Time Spiral &quot;Timeshifted&quot;</option>
	<option value="Torment">Torment</option>
	<option value="Unglued">Unglued</option>
	<option value="Unhinged">Unhinged</option>
	<option value="Unlimited Edition">Unlimited Edition</option>
	<option value="Urza's Destiny">Urza's Destiny</option>
	<option value="Urza's Legacy">Urza's Legacy</option>
	<option value="Urza's Saga">Urza's Saga</option>
	<option value="Vanguard">Vanguard</option>
	<option value="Vintage Masters">Vintage Masters</option>
	<option value="Visions">Visions</option>
	<option value="Weatherlight">Weatherlight</option>
	<option value="Worldwake">Worldwake</option>
	<option value="Zendikar">Zendikar</option>
</select>
ZZEOF;
}

function echo_select_cardcondition($name, $required)
{
	if($required)
		echo '<select required name="'.$name.'">';
	else
		echo '<select name="'.$name.'">';
	echo<<<ZZEOF
  	<option value=""></option>			
  	<option value="Near Mint">Near Mint</option>
  	<option value="Lightly Played">Lightly Played</option>
  	<option value="Moderately Played">Moderately Played	</option>
  	<option value="Heavily Played">Heavily Played</option>
  	<option value="Damaged">Damaged</option>
</select>
ZZEOF;
}
?>
