<?php
//-----------------------------------------------------------------------------//
//	displayHero() - Displays a single hero, fully formatted
//-----------------------------------------------------------------------------//
function displayHero ($db,$hero,$upgradeable_items,$stricon,$agilicon,$intlicon,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg)
{
	$heroimgwidth ="256";
	$heroabilityimgwidth ="64";
	$itemimgwidth = "85";
	$itemimgheight = "64";
	$itemgroupnamewidth = "109";
	$itemgroupiconwidth = "534";
	$leftcolwidth = "305";
	$itemrowpadding = "2";
	
	$herotooltip = "<span class=\'tthero\'><img src=\'" . $hero['map_icon'] . "\' height=\'20px\'/> " . str_replace("'","%39",$hero['name']) . "</span>";
	$abiltooltip = "<span class=\'tthero\'>" . str_replace("'","%39",$hero['ability_name']) . "</span> (" . $hero['ability_type'] . ")";
	
	echo "<br/> <!-- required to keep page out from under the header, table css adds much space at top of other pages -->";
	echo "<div id='result'>";
	echo "<div id='center' class='table'>";
		echo "<div id='hero-header' class='table-caption'>";
			switch($hero['faction'])
			{
				case "Radiant":
					echo "<div id='radiant-header'";
				break;
				case "Dire":
					echo "<div id='dire-header'";
				break;					
			}
			echo " onclick=\"location.href='" . $hero['wiki_url'] . "';\" style='cursor: pointer;'/>";
			$length = strlen($hero['name']);
			$name1 = strtoupper($hero['name']);
			$name = "";
			for($i = 0;$i<$length;$i++)
			{
				$name .= substr($name1, $i, 1);
				if($i<$length-1)
				{
					$name .= '&nbsp;';
				}
			}
			echo $name . "</div><br/>";
			switch($hero['attribute'])
			{
				case "Strength":
					$attrib = "<img src='" . $stricon . "' width='25px'/>&nbsp;";
				break;
				case "Agility":
					$attrib = "<img src='" . $agilicon . "' width='25px'/>&nbsp;";
				break;
				case "Intelligence":
					$attrib = "<img src='" . $intlicon . "' width='25px'/>&nbsp;";
				break;
			}
			echo $attrib . "<b>" . $hero['basic_attack'] . "</b> - " . $hero['role1'];
			if($hero['role2'] != "") {echo " - " . $hero['role2'];}
			if($hero['role3'] != "") {echo " - " . $hero['role3'];}
			if($hero['role4'] != "") {echo " - " . $hero['role4'];}
		echo "</div>";
		echo "<div class='table-row'>";
			echo "<div class='table-cell' style='width:" . $leftcolwidth . "px;'>";
				echo "<div class='herodetailthumb' style='width:" . $heroimgwidth . "px;'><img style='border-style:ridge;border-width:4px;border-color:#999999;vertical-align:-875%;' src=\"" . $hero['img'] . "\" alt=\"" . $hero['name'] . "\" width=\"" . $heroimgwidth . "\">";
				echo "<span class=\"hotspot\" onmouseover=\"tooltip.show('" . $herotooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"" . $hero['wiki_url'] . "\" ><img class=\"herodetailthumb-hoverimage\" src=\"" . $hoverimg . "\"/></a></span></div>";
				if($hero['scepter'])
				{
					echo "<br/><br/>" . $hero['name'] . " benefits from <a href=\"http://dota2itemsdb.x10.mx/?go=itemgroup&search=Aghanim%27s%20Scepter,\">Aghanim's Scepter</a>";
				}
				if($hero['scepter_cast'])
				{
					echo "<br/><br/>" . $hero['name'] . " can cast <a href=\"http://dota2itemsdb.x10.mx/?go=itemgroup&search=Aghanim%27s%20Scepter,\">Aghanim's Scepter</a> on an ally or themself, granting the hero all stats and respective upgrades as a permanent buff.<br/>The item is consumed in the process.";
				}
				if($hero['bash_item_ban'])
				{
					echo "<br/><br/><span class=\"helphotspot\" onmouseover=\"tooltip.show('Includes:<br/>Abyssal Blade<br/>Skull Basher');\" onmouseout=\"tooltip.hide();\">Bash Items</span> <span class='banned'>will NOT trigger</span> active Bash abilities when used by " . $hero['name'] . "!";
				}
				if($hero['blink_item_ban'])
				{
					echo "<br/><br/><span class=\"helphotspot\" onmouseover=\"tooltip.show('Includes:<br/>Blink Dagger');\" onmouseout=\"tooltip.hide();\">Blink Items</span> are <span class='banned'>BANNED</span> on " . $hero['name'] . "!";
				}
				if($hero['unique_atk_mod'])
				{
					echo "<br/><br/>" . $hero['name'] . " has a Unique Attack Modifier:<br/><br/>";
					echo "<div class='herodetailabil' style='width:" . $heroabilityimgwidth . "px;'><img style='border-style:ridge;border-width:2px;border-color:#999999;' src=\"" . $hero['ability_img'] . "\" alt=\"" . $hero['ability_name'] . "\" width=\"" . $heroabilityimgwidth . "\">";
					echo "<span class=\"hotspot\" onmouseover=\"tooltip.show('" . $abiltooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"" . $hero['ability_url'] . "\" ><img class=\"herodetailabil-hoverimage\" src=\"" . $hoverimg . "\"/></a></span></div>";
				}
			echo "</div>";
			echo "<div class='table-cell'>";
				echo "<div class='table' style=''>";
					echo "<div class='table-row'>";
						echo "<div class='table-cell-right' style='width:" . $itemgroupnamewidth . "px;padding-top:" . $itemrowpadding . "px;padding-bottom:" . $itemrowpadding . "px;padding-right:" . $itemrowpadding . "px;'>";
							echo "Starter Items<br/>";
						echo "</div>";
						echo "<div class='table-cell-left' style='width:" . $itemgroupiconwidth . "px;padding-top:" . $itemrowpadding . "px;padding-bottom:" . $itemrowpadding . "px;padding-left:" . $itemrowpadding . "px;'>";
							foreach (Tokenise($hero['starter_items']) as $item_name)
							{
								displaySuggestedItem($db,$item_name,"rev",$hero['faction'],$itemimgwidth,$itemimgheight,$itemrowpadding,$upgradeable_items,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
							}
						echo "</div>";
					echo "</div>";
					echo "<div class='table-row'>";
						echo "<div class='table-cell-right style='width:" . $itemgroupnamewidth . "px;padding-top:" . $itemrowpadding . "px;padding-bottom:" . $itemrowpadding . "px;padding-right:" . $itemrowpadding . "px;'>";
							echo "Early Game Items<br/>";
						echo "</div>";
						echo "<div class='table-cell-left' style='width:" . $itemgroupiconwidth . "px;padding-top:" . $itemrowpadding . "px;padding-bottom:" . $itemrowpadding . "px;padding-left:" . $itemrowpadding . "px;'>";
							foreach (Tokenise($hero['early_game_items']) as $item_name)
							{
								displaySuggestedItem($db,$item_name,"rev",$hero['faction'],$itemimgwidth,$itemimgheight,$itemrowpadding,$upgradeable_items,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
							}
						echo "</div>";
					echo "</div>";
					echo "<div class='table-row'>";
						echo "<div class='table-cell-right style='width:" . $itemgroupnamewidth . "px;padding-top:" . $itemrowpadding . "px;padding-bottom:" . $itemrowpadding . "px;padding-right:" . $itemrowpadding . "px;'>";
							echo "Core Items<br/>";
						echo "</div>";
						echo "<div class='table-cell-left' style='width:" . $itemgroupiconwidth . "px;padding-top:" . $itemrowpadding . "px;padding-bottom:" . $itemrowpadding . "px;padding-left:" . $itemrowpadding . "px;'>";
							foreach (Tokenise($hero['core_items']) as $item_name)
							{
								displaySuggestedItem($db,$item_name,"rev",$hero['faction'],$itemimgwidth,$itemimgheight,$itemrowpadding,$upgradeable_items,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
							}
						echo "</div>";
					echo "</div>";
					echo "<div class='table-row'>";
						echo "<div class='table-cell-right style='width:" . $itemgroupnamewidth . "px;padding-top:" . $itemrowpadding . "px;padding-bottom:" . $itemrowpadding . "px;padding-right:" . $itemrowpadding . "px;'>";
							echo "Situational Items<br/>";
						echo "</div>";
						echo "<div class='table-cell-left' style='width:" . $itemgroupiconwidth . "px;padding-top:" . $itemrowpadding . "px;padding-bottom:" . $itemrowpadding . "px;padding-left:" . $itemrowpadding . "px;'>";
							foreach (Tokenise($hero['situational_items']) as $item_name)
							{
								displaySuggestedItem($db,$item_name,"rev",$hero['faction'],$itemimgwidth,$itemimgheight,$itemrowpadding,$upgradeable_items,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
							}
						echo "</div>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
	echo "<br/>";
	echo "</div>";
}
//-----------------------------------------------------------------------------//
?>