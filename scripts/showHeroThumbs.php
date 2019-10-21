<?php
function displayHeroGroup ($db,$faction,$attribute,$hoverimg)
{
	$heroes_data = mysqli_query($db,"SELECT name,wiki_url,img,map_icon,role1,role2,role3,role4,scepter,scepter_cast,basic_attack FROM heroes WHERE faction = '" . $faction . "' AND attribute = '" . $attribute . "' AND unreleased = '0' ORDER BY position");
	while($hero_values = mysqli_fetch_array($heroes_data))
	{
		$heroes[] = array(	"name" => $hero_values['name'],
							"img" => $hero_values['img'],
							"map_icon" => $hero_values['map_icon'],
							"role1" => $hero_values['role1'],
							"role2" => $hero_values['role2'],
							"role3" => $hero_values['role3'],
							"role4" => $hero_values['role4'],
							"scepter" => $hero_values['scepter'],
							"scepter_cast" => $hero_values['scepter_cast'],
							"basic_attack" => $hero_values['basic_attack']);
	}
	
	$ret_string = "<div class='hero-group table'>";
	$i2 = 0;
	
	$ret_string .= "<div class='table-row'>";
	
	foreach($heroes as $hero)
	{
		$scepterfilter = "";
		$sceptercastfilter = "";
		
		$hero['img'] = str_replace("full.png","hphover.png",$hero['img']);
		$url = "?go=heroes&search=" . $hero['name'];
		//remove spaces from name to pass to filter later
		$filtername = str_replace(" ","%20",$hero['name']);
		$filtername = str_replace("'","",$filtername);
		$hero['role1'] = str_replace(" ","-",$hero['role1']);
		$hero['role2'] = str_replace(" ","-",$hero['role2']);
		$hero['role3'] = str_replace(" ","-",$hero['role3']);
		$hero['role4'] = str_replace(" ","-",$hero['role4']);
		if($hero['scepter'] == 1) {$scepterfilter = " hero_scepter";}
		if($hero['scepter_cast'] == 1) {$sceptercastfilter = " hero_scepter_cast";}
		
		$i2++;
		
		//reversed tooltip calc
		$r = "";
		if($attribute == "Intelligence" && $i2 > 2)
		{
			$r = "rev";
		}
	
		//preload images
		echo "<div id='preload'><img src='" . $hero['map_icon'] . "' width='1' height='1' /></div>";
		
		$tooltip = "<span class=\'tthero\'><img src=\'" . $hero['map_icon'] . "\' height=\'20px\'/> " . str_replace("'","%39",$hero['name']) . "</span>";
		
		$ret_string .= "<div class=\"table-cell\"><div class=\"herothumb\"><img class=\"hero_select-thumb name-" . $filtername . $scepterfilter . $sceptercastfilter . " " . $hero['basic_attack'] . " " . $hero['role1'] . " " . $hero['role2'] . " " . $hero['role3'] . " " . $hero['role4'] . "\" src=\"" . $hero['img'] . "\" alt=\"" . $hero['name'] . "\" />";
		$ret_string .= "<span class=\"hotspot\" onmouseover=\"tooltip.show" . $r . "('" . $tooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"" . $url . "\" alt=\"" . $hero['name'] . "\"><img class=\"hero-hoverimage\" src=\"" . $hoverimg . "\"/></a></span></div></div>";
		if($i2 == 4)
		{
			$ret_string .= "</div><div class='table-row'>";
			$i2 = 0;
		}
		$r = "";
	}
	
	$ret_string .= "</div></div>";
	
	return $ret_string;
}
?>