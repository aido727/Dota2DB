<script language="JavaScript" type="text/javascript">
	var searched = "";
	var count = "";
	if(document.URL.indexOf("search=") > -1)
	{
		searched = document.URL.substring(document.URL.indexOf("search=")+7,document.URL.length);
		switch(searched)
		{
			case "Consumables":
				count = " - Basics - Consumables";
			break;
			
			case "Attributes":
				count = " - Basics - Attributes";
			break;
			
			case "Armaments":
				count = " - Basics - Armaments";
			break;
			
			case "Arcane":
				count = " - Basics - Arcane";
			break;
			
			case "Common":
				count = " - Upgrades - Common";
			break;
			
			case "Support":
				count = " - Upgrades - Support";
			break;
			
			case "Caster":
				count = " - Upgrades - Caster";
			break;
			
			case "Weapons":
				count = " - Upgrades - Weapons";
			break;
			
			case "Armor":
				count = " - Upgrades - Armor";
			break;
			
			case "Artifacts":
				count = " - Upgrades - Artifacts";
			break;
			
			case "Secret":
				count = " - Secret Items";
			break;
			
			case "all":
				count = " - All Items";
			break;
			
			case "Basics":
				count = " - Basic Items";
			break;
			
			case "Upgrades":
				count = " - Upgrade Items";
			break;
			
			case "Roshan":
				count = " - Roshan Drops";
			break;
			
			default:
				count = " - " + (searched.split(",").length -1) + " Selected Items";
			break;
		}
	}
	document.title = document.title + " - Items" + count;
</script>

<?php
$searchspec = $_GET['search'];
$listtosearch = "";

switch($searchspec)
{
	case "Consumables":
		$searchnames = mysqli_query($db,"SELECT name FROM consumables ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "Attributes":
		$searchnames = mysqli_query($db,"SELECT name FROM basics WHERE type = 'Attributes' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "Armaments":
		$searchnames = mysqli_query($db,"SELECT name FROM basics WHERE type = 'Armaments' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "Arcane":
		$searchnames = mysqli_query($db,"SELECT name FROM basics WHERE type = 'Arcane' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "Common":
		$searchnames = mysqli_query($db,"SELECT name FROM upgrades WHERE type = 'Common' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			if(strpos($string['name'], " (") === false) {$listtosearch .= $string[name] . ",";}
		}
	break;
	
	case "Support":
		$searchnames = mysqli_query($db,"SELECT name FROM upgrades WHERE type = 'Support' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "Caster":
		$searchnames = mysqli_query($db,"SELECT name FROM upgrades WHERE type = 'Caster' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			if(strpos($string['name'], " (") !== false)
			{
				if(strpos($string['name'], " (Lvl 1)") !== false)
				{
					$listtosearch .= $string['name'] . ",";
				}
			}
			else
			{
				$listtosearch .= $string['name'] . ",";
			}
		}
	break;
	
	case "Weapons":
		$searchnames = mysqli_query($db,"SELECT name FROM upgrades WHERE type = 'Weapons' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "Armor":
		$searchnames = mysqli_query($db,"SELECT name FROM upgrades WHERE type = 'Armor' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "Artifacts":
		$searchnames = mysqli_query($db,"SELECT name FROM upgrades WHERE type = 'Artifacts' ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			if(strpos($string['name'], " (") !== false)
			{
				if(strpos($string['name'], " (Lvl 1)") !== false)
				{
					$listtosearch .= $string['name'] . ",";
				}
			}
			else
			{
				$listtosearch .= $string['name'] . ",";
			}
		}
	break;
	
	case "Secret":
		$searchnames = mysqli_query($db,"SELECT name FROM secret ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "all":
		$searchnames = mysqli_query($db,"SELECT name FROM consumables ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
		$searchnames = mysqli_query($db,"SELECT name FROM basics ORDER BY type,position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
		$searchnames = mysqli_query($db,"SELECT name FROM upgrades ORDER BY type,position");
		while($string = mysqli_fetch_array($searchnames))
		{
			if(strpos($string['name'], " (") !== false)
			{
				if(strpos($string['name'], " (Lvl 1)") !== false)
				{
					$listtosearch .= $string['name'] . ",";
				}
			}
			else
			{
				$listtosearch .= $string['name'] . ",";
			}
		}
		$searchnames = mysqli_query($db,"SELECT name FROM secret ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "Basics":
		$searchnames = mysqli_query($db,"SELECT name FROM consumables ORDER BY position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
		$searchnames = mysqli_query($db,"SELECT name FROM basics ORDER BY type,position");
		while($string = mysqli_fetch_array($searchnames))
		{
			$listtosearch .= $string['name'] . ",";
		}
	break;
	
	case "Upgrades":
		$searchnames = mysqli_query($db,"SELECT name FROM upgrades ORDER BY type,position");
		while($string = mysqli_fetch_array($searchnames))
		{
			if(strpos($string['name'], " (") !== false)
			{
				if(strpos($string['name'], " (Lvl 1)") !== false)
				{
					$listtosearch .= $string['name'] . ",";
				}
			}
			else
			{
				$listtosearch .= $string['name'] . ",";
			}
		}
	break;
	
	case "Roshan":
		$searchnames = mysqli_query($db,"SELECT name FROM other WHERE type = 'Roshan Drop' ORDER BY position");
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
	$items = Tokenise($listtosearch);
	include "scripts/displayItem.php";
	echo "<input type='button' value='Back to Items' onClick=\"location.href='?go=items'\"/></br><hr/>";
	foreach ($items as $itemname)
	{
		$item = QueryItem($db,$itemname);
		if($item)
		{
			displayItem($db,$item,$upgradeable_items,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg,$LshopWimglrg,$LshopBimglrg,$SshopWimglrg,$SshopRimglrg);
			echo "<input type='button' value='Back to Items' onClick=\"location.href='?go=items'\"/><br/><hr/>";
		}
		else
		{
			//report on bad search term
			echo "<br/><hr/><br/><span class='notfound'>'" . $itemname . "' not found!</span><br/><br/><hr/><br/>";
		}
	}
}
else
{	//if this page is reached in error
	echo "<span class='notfound'>Search error, please report!</span>";
}
?>