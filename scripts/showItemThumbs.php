<?php

//COST must ALWAYS be the LAST element of the img class due to filter functionality//

//-----------------------------------------------------------------------------//
//	displayItemGroupConsumables() - Displays item images linked for individual item display for table 'consumables'
//-----------------------------------------------------------------------------//
function displayItemGroupConsumables($db,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopBimg)
{
	$item_data = mysqli_query($db,"SELECT name,img,sideshop,type,cost,hp_regen,dmg,hp_restored,mana_restored FROM consumables ORDER BY position");
	while($item_values = mysqli_fetch_array($item_data))
	{
		$items[] = array ( 	"name" => $item_values['name'],
							"img" => $item_values['img'],
							"sideshop" => $item_values['sideshop'],
							"type" => $item_values['type'],
							"cost" => $item_values['cost'],
							"hp_regen" => $item_values['hp_regen'],
							"dmg" => $item_values['dmg'],
							"hp_restored" => $item_values['hp_restored'],
							"mana_restored" => $item_values['mana_restored'],
							);
	}
	
	$ret_string = "<div class='table'>";
	foreach($items as $item)
	{
		//reset per item
		$hp_regen = "";
		$dmg = "";
		$hp_restored = "";
		$mana_restored = "";
		$shopfilter = "";
		
		$url = "?go=items&search=" . $item['name'];
		$filtername = str_replace(" ","%20",$item['name']);
		$filtername = str_replace("'","",$filtername);
		
		//filter
		if($item['hp_regen'] > 0 && $item['type'] == "Consumable") {$hp_regen = " hp_regen";}
		if($item['dmg'] > 0) {$dmg = " damage";}
		if($item['hp_restored'] > 0 && $item['type'] == "Consumable") {$hp_restored = " hp_restore";}
		if($item['mana_restored'] > 0 && $item['type'] == "Consumable") {$mana_restored = " mana_restore";}
		if($item['sideshop'] == 1) {$shopfilter = " LSall";}
		
		//tooltip
		$LshopWimg = "";
		$SshopWimg = "";
		$SshopRimg = "";
		$tooltip = buildItemTooltip($db,$item['name'],"consumables",$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
		
		//display
		$ret_string .= "<div class=\"table-row\"><div class=\"table-cell\"><div class=\"itemthumb floatleft\"><img class=\"item_select-thumb name-" . $filtername . $hp_regen . $dmg . $hp_restored . $mana_restored . $shopfilter . " cost-" . $item['cost'] . "\" src=\"" . $item['img'] . "\" alt=\"" . $item['name'] . "\" >";
		$ret_string .= "<span class=\"hotspot\" onmouseover=\"tooltip.showitem('" . $tooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"" . $url . "\" alt=\"" . $item['name'] . "\"><img class=\"item-hoverimage\" src=\"" . $hoverimg . "\" /></a></span></div></div></div>";
	}
	$ret_string .= "</div>";
	
	return $ret_string;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	displayItemGroupBasics() - Displays item images linked for individual item display for table 'basics'
//-----------------------------------------------------------------------------//
function displayItemGroupBasics($db,$type,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopBimg)
{
	$item_data = mysqli_query($db,"SELECT name,img,sideshop,cost,str,agil,intl,armor,block_chance,dmg,hp_regen,mana_regen,atk_spd,move_spd,magic_resist,active_hp_total,active_mana_total,passive_dmg_psec,passive_move_spd_reduct_percent_melee_wielder,passive_move_spd_reduct_percent_ranged_wielder,unique_atk_mod_lifesteal,unique_atk_mod_pluslifesteal FROM basics WHERE type = '" . $type . "'ORDER BY position");
	while($item_values = mysqli_fetch_array($item_data))
	{
		$items[] = array ( 	"name" => $item_values['name'],
							"img" => $item_values['img'],
							"sideshop" => $item_values['sideshop'],
							"cost" => $item_values['cost'],
							"mod_lifesteal" => $item_values['unique_atk_mod_lifesteal'],
							"mod_stack" => $item_values['unique_atk_mod_pluslifesteal'],
							"str" => $item_values['str'],
							"agil" => $item_values['agil'],
							"intl" => $item_values['intl'],
							"armor" => $item_values['armor'],
							"block_chance" => $item_values['block_chance'],
							"dmg" => $item_values['dmg'],
							"hp_regen" => $item_values['hp_regen'],
							"mana_regen" => $item_values['mana_regen'],
							"atk_spd" => $item_values['atk_spd'],
							"move_spd" => $item_values['move_spd'],
							"magic_resist" => $item_values['magic_resist'],
							"active_hp_total" => $item_values['active_hp_total'],
							"active_mana_total" => $item_values['active_mana_total'],
							"passive_dmg_psec" => $item_values['passive_dmg_psec'],
							"passive_move_spd_reduct_percent_melee_wielder" => $item_values['passive_move_spd_reduct_percent_melee_wielder'],
							"passive_move_spd_reduct_percent_ranged_wielder" => $item_values['passive_move_spd_reduct_percent_ranged_wielder']
							);
	}
	
	$ret_string = "<div class='table'>";
	foreach($items as $item)
	{
		//reset per item
		$uam = "";
		$mod_lifesteal = "";
		$mod_stack = "";
		$str = "";
		$agil = "";
		$intl = "";
		$armor = "";
		$block_chance = "";
		$dmg = "";
		$hp_regen = "";
		$mana_regen = "";
		$atk_spd = "";
		$move_spd = "";
		$magic_resist = "";
		$active_hp_total = "";
		$active_mana_total = "";
		$slow = "";
		$shopfilter = "";
			
		$url = "?go=items&search=" . $item['name'];
		$filtername = str_replace(" ","%20",$item['name']);
		
		//filter
		if($item['mod_lifesteal'] == 1) {$mod_lifesteal = " mod_lifesteal";}
		if($item['mod_stack'] == 1) {$mod_stack = " mod_stack";}
		if($item['str'] > 0) {$str = " strength";}
		if($item['agil'] > 0) {$agil = " agility";}
		if($item['intl'] > 0) {$intl = " intelligence";}
		if($item['armor'] > 0) {$armor = " armor";}
		if($item['block_chance'] > 0) {$block_chance = " damage_block";}
		if($item['dmg'] > 0) {$dmg = " damage";}
		if($item['hp_regen'] > 0) {$hp_regen = " hp_regen";}
		if($item['mana_regen'] > 0) {$mana_regen = " mana_regen";}
		if($item['atk_spd'] > 0) {$atk_spd = " attack_speed";}
		if($item['move_spd'] > 0) {$move_spd = " movement_speed";}
		if($item['magic_resist'] > 0) {$magic_resist = " magic_resist";}
		if($item['active_hp_total'] > 0) {$active_hp_total = " hp_restore";}
		if($item['active_mana_total'] > 0) {$active_mana_total = " mana_restore";}
		if($item['passive_move_spd_reduct_percent_melee_wielder'] > 0 || $item['passive_move_spd_reduct_percent_ranged_wielder'] > 0) {$slow = " slow-maim";}
		if($item['sideshop'] == 1) {$shopfilter = " LSall";}
		
		//tooltip
		$LshopWimg = "";
		$SshopWimg = "";
		$SshopRimg = "";
		$tooltip = buildItemTooltip($db,$item['name'],"basics",$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
		
		//display
		$ret_string .= "<div class=\"table-row\"><div class=\"table-cell\"><div class=\"itemthumb floatleft\"><img class=\"item_select-thumb name-" . $filtername . $mod_lifesteal . $mod_stack . $str . $agil . $intl . $armor . $block_chance . $dmg . $hp_regen . $mana_regen . $atk_spd . $move_spd . $magic_resist . $active_hp_total . $active_mana_total . $slow . $shopfilter . " cost-" . $item['cost'] . "\" src=\"" . $item['img'] . "\" alt=\"" . $item['name'] . "\" >";
		$ret_string .= "<span class=\"hotspot\" onmouseover=\"tooltip.showitem('" . $tooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"" . $url . "\" alt=\"" . $item['name'] . "\"><img class=\"item-hoverimage\" src=\"" . $hoverimg . "\" /></a></span></div></div></div>";
	}
	$ret_string .= "</div>";
	
	return $ret_string;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	displayItemGroupUpgrades() - Displays item images linked for individual item display for table 'upgrades'
//-----------------------------------------------------------------------------//
function displayItemGroupUpgrades($db,$type,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg)
{
	$item_data = mysqli_query($db,"SELECT upgrades.name,upgrades.img,upgrades.sideshop_entirely,upgrades.sideshop_partly,upgrades.secretshop_only,upgrades.secretshop_partly,upgrades.cost,upgrades.upgradeable,upgrades.upgrade_level,upgrades.str,upgrades.agil,upgrades.intl,upgrades.armor,upgrades.block_chance,upgrades.dmg,upgrades.hp,upgrades.hp_regen,upgrades.mana,upgrades.mana_regen,upgrades.atk_spd,upgrades.move_spd,upgrades.move_spd_percent,upgrades.magic_resist,upgrades.evasion,upgrades.active_str,upgrades.active_hp_total,upgrades.active_mana_total,upgrades.active_move_spd_reduct_percent,active_magic_resistance_percent,upgrades.passive_bonus_dmg,upgrades.passive_dmg_percent,upgrades.passive_armor,upgrades.passive_hp_regen,upgrades.passive_hp_regen_percent,upgrades.passive_mana_regen,upgrades.passive_atk_spd,upgrades.passive_move_spd_percent,upgrades.passive_move_spd_reduct_percent,upgrades.aura,upgrades.unique_atk_mod,upgrades.unique_atk_mod_lifesteal,upgrades.unique_atk_mod_pluslifesteal,upgrades.unique_atk_mod_interupt,upgrades.disassemblable,recipes.has_recipe FROM upgrades LEFT JOIN recipes ON upgrades.name=recipes.top_item WHERE type = '" . $type . "'ORDER BY position");
	while($item_values = mysqli_fetch_array($item_data))
	{
		$items[] = array ( 	"name" => $item_values['name'],
							"img" => $item_values['img'],
							"sideshop_entirely" => $item_values['sideshop_entirely'],
							"sideshop_partly" => $item_values['sideshop_partly'],
							"secretshop_only" => $item_values['secretshop_only'],
							"secretshop_partly" => $item_values['secretshop_partly'],
							"cost" => $item_values['cost'],
							"upgradeable" => $item_values['upgradeable'],
							"upgrade_level" => $item_values['upgrade_level'],
							"has_recipe" => $item_values['has_recipe'],
							"aura" => $item_values['aura'],
							"uam" => $item_values['unique_atk_mod'],
							"mod_lifesteal" => $item_values['unique_atk_mod_lifesteal'],
							"mod_stack" => $item_values['unique_atk_mod_pluslifesteal'],
							"mod_chain" => $item_values['unique_atk_mod_interupt'],
							"str" => $item_values['str'],
							"agil" => $item_values['agil'],
							"intl" => $item_values['intl'],
							"armor" => $item_values['armor'],
							"block_chance" => $item_values['block_chance'],
							"dmg" => $item_values['dmg'],
							"hp" => $item_values['hp'],
							"hp_regen" => $item_values['hp_regen'],
							"mana" => $item_values['mana'],
							"mana_regen" => $item_values['mana_regen'],
							"atk_spd" => $item_values['atk_spd'],
							"move_spd" => $item_values['move_spd'],
							"move_spd_percent" => $item_values['move_spd_percent'],
							"magic_resist" => $item_values['magic_resist'],
							"evasion" => $item_values['evasion'],
							"active_str" => $item_values['active_str'],
							"active_hp_total" => $item_values['active_hp_total'],
							"active_mana_total" => $item_values['active_mana_total'],
							"active_move_spd_reduct_percent" => $item_values['active_move_spd_reduct_percent'],
							"active_magic_resistance_percent" => $item_values['active_magic_resistance_percent'],
							"passive_bonus_dmg" => $item_values['passive_bonus_dmg'],
							"passive_dmg_percent" => $item_values['passive_dmg_percent'],
							"passive_armor" => $item_values['passive_armor'],
							"passive_hp_regen" => $item_values['passive_hp_regen'],
							"passive_hp_regen_percent" => $item_values['passive_hp_regen_percent'],
							"passive_mana_regen" => $item_values['passive_mana_regen'],
							"passive_atk_spd" => $item_values['passive_atk_spd'],
							"passive_move_spd_percent" => $item_values['passive_move_spd_percent'],
							"passive_move_spd_reduct_percent" => $item_values['passive_move_spd_reduct_percent'],
							"disassemble" => $item_values['disassemblable'],
							);
	}
	
	$ret_string = "<div class='table'>";
	//reversed tooltip calc
	$r = "";
	if($type == "Caster" || $type == "Weapons" || $type == "Armor" || $type == "Artifacts")
	{
		$r = "rev";
	}
	
	foreach($items as $item)
	{
		if(($item['upgradeable'] == 0 || ($item['upgradeable'] == 1 && $item['upgrade_level'] == 1)) && strpos($item['name'],"Power Treads (") === false)
		{
			//reset per item
			$has_recipe = "";
			$aura = "";
			$uam = "";
			$mod_lifesteal = "";
			$mod_stack = "";
			$mod_chain = "";
			$str = "";
			$agil = "";
			$intl = "";
			$armor = "";
			$block_chance = "";
			$dmg = "";
			$hp = "";
			$hp_regen = "";
			$mana = "";
			$mana_regen = "";
			$atk_spd = "";
			$move_spd = "";
			$magic_resist = "";
			$evasion = "";
			$active_hp_total = "";
			$active_mana_total = "";
			$slow = "";
			$shopfilter = "";
			$disassemble = "";
			
			$url = "?go=items&search=" . $item['name'];
			$filtername = str_replace(" ","%20",$item['name']);
			
			//filter
			if($item['has_recipe'] == 1) {$has_recipe = " has_recipe";}
			if($item['aura'] == 1) {$aura = " aura";}
			if($item['uam'] == 1) {$uam = " UAM";}
			if($item['mod_lifesteal'] == 1) {$mod_lifesteal = " mod_lifesteal";}
			if($item['mod_stack'] == 1) {$mod_stack = " mod_stack";}
			if($item['mod_chain'] == 1) {$mod_chain = " mod_chain";}
			if($item['str'] > 0 || $item['active_str'] > 0) {$str = " strength";}
			if($item['agil'] > 0) {$agil = " agility";}
			if($item['intl'] > 0) {$intl = " intelligence";}
			if($item['armor'] > 0 || $item['passive_armor'] > 0) {$armor = " armor";}
			if($item['block_chance'] > 0) {$block_chance = " damage_block";}
			if($item['dmg'] > 0 || $item['passive_bonus_dmg'] > 0 || $item['passive_dmg_percent'] > 0) {$dmg = " damage";}
			if($item['hp'] > 0) {$hp = " hp";}
			if($item['hp_regen'] > 0 || $item['passive_hp_regen'] > 0 || $item['passive_hp_regen_percent'] > 0) {$hp_regen = " hp_regen";}
			if($item['mana'] > 0) {$mana = " mana";}
			if($item['mana_regen'] > 0 || $item['passive_mana_regen'] > 0) {$mana_regen = " mana_regen";}
			if($item['atk_spd'] > 0 || $item['passive_atk_spd'] > 0) {$atk_spd = " attack_speed";}
			if($item['move_spd'] > 0 || $item['move_spd_percent'] > 0 || $item['passive_move_spd_percent'] > 0) {$move_spd = " movement_speed";}
			if($item['magic_resist'] > 0 || $item['active_magic_resistance_percent'] > 0) {$magic_resist = " magic_resist";}
			if($item['evasion'] > 0) {$evasion = " evasion";}
			if($item['active_hp_total'] > 0) {$active_hp_total = " hp_restore";}
			if($item['active_mana_total'] > 0) {$active_mana_total = " mana_restore";}
			if($item['active_move_spd_reduct_percent'] > 0 || $item['passive_move_spd_reduct_percent'] > 0) {$slow = " slow-maim";}
			if($item['sideshop_entirely'] == 1) {$shopfilter .= " LSall";}
			if($item['sideshop_partly'] == 1) {$shopfilter .= " LSpart";}
			if($item['secretshop_only'] == 1) {$shopfilter .= " SSall";}
			if($item['secretshop_partly'] == 1) {$shopfilter .= " SSpart";}
			if($item['disassemble'] == 1) {$disassemble = " disassemble";}
			
			//tooltip
			$tooltip = buildItemTooltip($db,$item['name'],"upgrades",$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
			
			//display
			$ret_string .= "<div class=\"table-row\"><div class=\"table-cell\"><div class=\"itemthumb floatleft\"><img class=\"item_select-thumb name-" . $filtername . $has_recipe . $aura . $uam . $mod_lifesteal . $mod_stack . $mod_chain . $str . $agil . $intl . $armor . $block_chance . $dmg . $hp . $hp_regen . $mana . $mana_regen . $atk_spd . $move_spd . $magic_resist . $evasion . $active_hp_total. $active_mana_total. $slow . $shopfilter . $disassemble . " cost-" . $item['cost'] . "\" src=\"" . $item['img'] . "\" alt=\"" . $item['name'] . "\" >";
			$ret_string .= "<span class=\"hotspot\" onmouseover=\"tooltip.showitem" . $r . "('" . $tooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"" . $url . "\" alt=\"" . $item['name'] . "\"><img class=\"item-hoverimage\" src=\"" . $hoverimg . "\" /></a></span></div></div></div>";
		}
	}
	$ret_string .= "</div>";
	
	return $ret_string;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	displayItemGroupSecret() - Displays item images linked for individual item display for table 'secret'
//-----------------------------------------------------------------------------//
function displayItemGroupSecret($db,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopBimg,$SshopRimg)
{
	$item_data = mysqli_query($db,"SELECT name,img,sideshop_also,cost,str,agil,intl,armor,hp,hp_regen,mana,mana_regen,dmg,atk_spd,evasion FROM secret ORDER BY position");
	while($item_values = mysqli_fetch_array($item_data))
	{
		$items[] = array ( 	"name" => $item_values['name'],
							"img" => $item_values['img'],
							"sideshop_also" => $item_values['sideshop_also'],
							"cost" => $item_values['cost'],
							"str" => $item_values['str'],
							"agil" => $item_values['agil'],
							"intl" => $item_values['intl'],
							"armor" => $item_values['armor'],
							"hp" => $item_values['hp'],
							"hp_regen" => $item_values['hp_regen'],
							"mana" => $item_values['mana'],
							"mana_regen" => $item_values['mana_regen'],
							"dmg" => $item_values['dmg'],
							"atk_spd" => $item_values['atk_spd'],
							"evasion" => $item_values['evasion']
							);
	}
	
	$ret_string = "<div class='table'>";
	foreach($items as $item)
	{
		//reset per item
		$str = "";
		$agil = "";
		$intl = "";
		$armor = "";
		$hp = "";
		$hp_regen = "";
		$mana = "";
		$mana_regen = "";
		$dmg = "";
		$atk_spd = "";
		$evasion = "";
		$shopfilter = "";
		
		$url = "?go=items&search=" . $item['name'];
		$filtername = str_replace(" ","%20",$item['name']);
		
		//filter
		if($item['str'] > 0) {$str = " strength";}
		if($item['agil'] > 0) {$agil = " agility";}
		if($item['intl'] > 0) {$intl = " intelligence";}
		if($item['armor'] > 0) {$armor = " armor";}
		if($item['hp'] > 0) {$hp = " hp";}
		if($item['hp_regen'] > 0) {$hp_regen = " hp_regen";}
		if($item['mana'] > 0) {$mana = " mana";}
		if($item['mana_regen'] > 0) {$mana_regen = " mana_regen";}
		if($item['dmg'] > 0) {$dmg = " damage";}
		if($item['atk_spd'] > 0) {$atk_spd = " attack_speed";}
		if($item['evasion'] > 0) {$evasion = " evasion";}
		if($item['sideshop_also'] == 1) {$shopfilter = " LSall";}
		
		//tooltip
		$LshopWimg = "";
		$SshopWimg = "";
		$tooltip = buildItemTooltip($db,$item['name'],"secret",$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
		
		//display
		$ret_string .= "<div class=\"table-row\"><div class=\"table-cell\"><div class=\"itemthumb floatleft\"><img class=\"item_select-thumb name-" . $filtername . $str . $agil . $intl . $armor. $hp . $hp_regen . $mana . $mana_regen . $dmg . $atk_spd . $evasion. $shopfilter . " SSall cost-" . $item['cost'] . "\" src=\"" . $item['img'] . "\" alt=\"" . $item['name'] . "\" >";
		$ret_string .= "<span class=\"hotspot\" onmouseover=\"tooltip.showitemrev('" . $tooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"" . $url . "\" alt=\"" . $item['name'] . "\"><img class=\"item-hoverimage\" src=\"" . $hoverimg . "\" /></a></span></div></div></div>";
	}
	$ret_string .= "</div>";
	
	return $ret_string;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	displayItemGroupRoshan() - Displays item images linked for individual item display for table 'other', type 'Roshan Drop'
//-----------------------------------------------------------------------------//
function displayItemGroupRoshan($db,$hoverimg,$goldimg,$cooldownimg,$manaimg)
{
	$item_data = mysqli_query($db,"SELECT name,img,type,active_hp_restored,active_mana_restored FROM other WHERE type = 'Roshan Drop' ORDER BY position");
	while($item_values = mysqli_fetch_array($item_data))
	{
		$items[] = array ( 	"name" => $item_values['name'],
							"img" => $item_values['img'],
							"type" => $item_values['type'],
							"hp_restored" => $item_values['active_hp_restored'],
							"mana_restored" => $item_values['active_mana_restored'],
							);
	}
	
	$ret_string = "<div class='table'><div class='table-row'>";
	foreach($items as $item)
	{
		//reset per item
		$hp_restored = "";
		$mana_restored = "";
		
		$url = "?go=items&search=" . $item['name'];
		$filtername = str_replace(" ","%20",$item['name']);
		$filtername = str_replace("'","",$filtername);
		
		//filter
		if($item['hp_restored'] > 0) {$hp_restored = " hp_restore";}
		if($item['mana_restored'] > 0) {$mana_restored = " mana_restore";}
		
		//tooltip
		$LshopWimg = "";
		$LshopBimg = "";
		$SshopWimg = "";
		$SshopRimg = "";
		$tooltip = buildItemTooltip($db,$item['name'],"other",$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
		
		//display
		$ret_string .= "<div class=\"table-cell\"><div class=\"itemthumb floatleft\"><img class=\"item_select-thumb name-" . $filtername . $hp_restored . $mana_restored . "\" src=\"" . $item['img'] . "\" alt=\"" . $item['name'] . "\" >";
		$ret_string .= "<span class=\"hotspot\" onmouseover=\"tooltip.showitem('" . $tooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"" . $url . "\" alt=\"" . $item['name'] . "\"><img class=\"item-hoverimage\" src=\"" . $hoverimg . "\" /></a></span></div></div>";
	}
	$ret_string .= "</div></div>";
	
	return $ret_string;
}
//-----------------------------------------------------------------------------//
?>