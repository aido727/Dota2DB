<script language="JavaScript" type="text/javascript">
	var searched = "";
	var count = "";
	if(document.URL.indexOf("search=") > -1)
	{
		searched = document.URL.substring(document.URL.indexOf("search=")+7,document.URL.length);
		switch(searched)
		{
			case "radiant":
				count = " - The Radiant";
			break;
			
			case "dire":
				count = " - The Dire";
			break;
			
			case "radiantStr":
				count = " - Strength Radiant Heroes";
			break;
			
			case "radiantAgil":
				count = " - Agility Radiant Heroes";
			break;
			
			case "radiantInt":
				count = " - Intelligence Radiant Heroes";
			break;
			
			case "direStr":
				count = " - Strength Dire Heroes";
			break;
			
			case "direAgil":
				count = " - Agility Dire Heroes";
			break;
			
			case "direInt":
				count = " - Intelligence Dire Heroes";
			break;
			
			case "all":
				count = " - All Heroes";
			break;
			
			default:
				count = " - " + (searched.split(",").length -1) + " Selected Heroes";
			break;
		}
	}
	document.title = document.title + " - Heroes" + count;
</script>

<?php
$searchspec = $_GET['search'];
$listtosearch = "";

switch($searchspec)
{
	case "radiant":
		$searchnames = mysqli_query($db,"SELECT name FROM heroes WHERE faction = 'Radiant' AND unreleased = '0' ORDER BY attribute,position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "dire":
		$searchnames = mysqli_query($db,"SELECT name FROM heroes WHERE faction = 'Dire' AND unreleased = '0' ORDER BY attribute,position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "radiantStr":
		$searchnames = mysqli_query($db,"SELECT name FROM heroes WHERE faction = 'Radiant' AND attribute = 'Strength' AND unreleased = '0' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "radiantAgil":
		$searchnames = mysqli_query($db,"SELECT name FROM heroes WHERE faction = 'Radiant' AND attribute = 'Agility' AND unreleased = '0' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "radiantInt":
		$searchnames = mysqli_query($db,"SELECT name FROM heroes WHERE faction = 'Radiant' AND attribute = 'Intelligence' AND unreleased = '0' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "direStr":
		$searchnames = mysqli_query($db,"SELECT name FROM heroes WHERE faction = 'Dire' AND attribute = 'Strength' AND unreleased = '0' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "direAgil":
		$searchnames = mysqli_query($db,"SELECT name FROM heroes WHERE faction = 'Dire' AND attribute = 'Agility' AND unreleased = '0' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "direInt":
		$searchnames = mysqli_query($db,"SELECT name FROM heroes WHERE faction = 'Dire' AND attribute = 'Intelligence' AND unreleased = '0' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "all":
		$searchnames = mysqli_query($db,"SELECT name FROM heroes WHERE unreleased = '0' ORDER BY attribute,faction,position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	default:
		$listtosearch = $searchspec;
	break;
}
//if selected group is searched
if(substr($listtosearch, -1) == ",")
{
	$heroes = Tokenise($listtosearch);
	include "scripts/displayHero.php";
	echo "<input type='button' value='Back to Heroes' onClick=\"location.href='?go=heroes'\"/><br/>";
	foreach ($heroes as $heroname)
	{
		$hero = QueryHero($db,$heroname);
		if($hero)
		{
			displayHero($db,$hero,$upgradeable_items,$stricon,$agilicon,$intlicon,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
			echo "<input type='button' value='Back to Heroes' onClick=\"location.href='?go=heroes'\"/><br/>";
		}
		else
		{
			//report on bad search term
			echo "<br/><hr/><br/><span class='notfound'>'" . $heroname . "' not found!</span><br/><br/><hr/><br/>";
		}
	}
}
else
{	//if this page is reached in error
	echo "<span class='notfound'>Search error, please report!</span>";
}
?>