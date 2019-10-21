<?php
//-----------------------------------------------------------------------------//
//	displayItem() - Displays a single item, fully formatted
//-----------------------------------------------------------------------------//
//-----------------------------------------------------------------------------//
function displayItem ($db,$item,$upgradeable_items,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg,$LshopWimglrg,$LshopBimglrg,$SshopWimglrg,$SshopRimglrg)
{
	$itemimgwidth ="170";
	$recipeitemimgwidth = "85";
	$recipeitemimgheight = "64";
	$itemrowpadding = "2";
	$upgradeitemimgwidth = "42";
	$upgradeitemimgheight = "32";
	
	$midcolwidth = "293";
	$rightcolwidth = "476";
	
	$itemtooltip = titletext($item['name'],$item['type']);
	
	//display content
	$stats = "";
	$text = "<br/>";
	$LshopWtext = "<span class=\"helphotspot\" onmouseover=\"tooltip.show('Side Lane Shop: some parts available');\" onmouseout=\"tooltip.hide();\"><img src='" . $LshopWimglrg . "'/></span>";
	$LshopBtext = "<span class=\"helphotspot\" onmouseover=\"tooltip.show('Side Lane Shop: all parts available');\" onmouseout=\"tooltip.hide();\"><img src='" . $LshopBimglrg . "'/></span>";
	$SshopWtext = "<span class=\"helphotspot\" onmouseover=\"tooltip.show('Secret Shop: some parts available');\" onmouseout=\"tooltip.hide();\"><img src='" . $SshopWimglrg . "'/></span>";
	$SshopRtext = "<span class=\"helphotspot\" onmouseover=\"tooltip.show('Secret Shop: all parts available');\" onmouseout=\"tooltip.hide();\"><img src='" . $SshopRimglrg . "'/></span>";
	
	switch($item['type'])
	{
		case "Common":
			$bordercolor = "green";
		break;
		case "Support":
		case "Caster":
			$bordercolor = "#0040FF";
		break;
		case "Weapons":
		case "Armor":
			$bordercolor = "purple";
		break;
		case "Artifacts":
			$bordercolor = "#FF8000";
		break;
		default:
			$bordercolor = "#E6E6E6";
		break;
	}
	
	$table = getItemTable($db,$item['name']);
					
	switch($table)
	{
		case "consumables":
			$sideshop = "";
			if($item['sideshop'] == 1)
			{
				$sideshop = "&nbsp;" . $LshopBtext;
			}
			switch($item['type'])
			{
				case "Consumable":
					$text .= "<span class='itemabilitynamedetail'>" . $item['active_name'] . ": </span>";
					if($item['description'] != null) {$text .= "<br/><span class='textsmall'>" . desctext($item['description']) . "</span></br>";}
					if($item['charges'] != null) {$text .= "<br/>Charges: " . $item['charges'];}
					if($item['hp_regen'] != null) {$stats .= "<br/>HP Regen +" . $item['hp_regen'];}
					if($item['dmg'] != null) {$stats .= "<br/>Damage +" . $item['dmg'];}
					if($item['duration'] != null) {$text .= "<br/>Duration: " . $item['duration'];}
					if($item['radius'] != null) {$text .= "<br/>Radius: " . $item['radius'];}
					if($item['hp_restored_ward'] != null)
					{
						if($item['hp_restored'] != null) {$text .= "<br/>HP Restored (Tree): " . $item['hp_restored'];}
						$text .= "<br/>HP Restored (Ward): " . $item['hp_restored_ward'];
					}
					else
					{
						if($item['hp_restored'] != null) {$text .= "<br/>HP Restored: " . $item['hp_restored'];}
					}
					if($item['mana_restored'] != null) {$text .= "<br/>Mana Restored: " . $item['mana_restored'];}
					if($item['move_spd'] != null) {$text .= "<br/>Move Speed +" . $item['move_spd'];}
					if($item['cooldown'] != null || $item['mana_cost'] != null) {$text .= "</br>";}
					if($item['cooldown'] != null) {	$text .= "<img src='" . $cooldownimg . "' height='14px'/> " . $item['cooldown'] . "&nbsp;&nbsp;&nbsp;";}
					if($item['mana_cost'] != null) {$text .= "<img src='" . $manaimg . "' height='14px'/> " . $item['mana_cost'];}
				break;
				case "Courier":
					$stats .= "<br/>HP: " . $item['hp_restored'];
					if($item['mana_restored'] > 0) {$stats .= "<br/>Armor: " . $item['mana_restored'];}
					$stats .= "</br>Move Speed: " . $item['move_spd'];
					$text .= desctext($item['description']);
				break;
				case "Ward":
					$text .= desctext($item['description']) . "<br/>Uses: " . $item['charges'] . "<br/>Duration: " . durationtext($item['duration']) . "<br/>Radius: " . $item['radius'] . "<br/>HP: " . $item['hp_restored'] . "</br><img src='" . $cooldownimg . "' height='14px'/> " . $item['cooldown'];
				break;
			}
		break;
		
		case "basics":
			$sideshop = "";
			if($item['sideshop'] == 1)
			{
				$sideshop = "&nbsp;" . $LshopBtext;
			}
			if($item['str'] != null) {$stats .= "<br/>Strength +" . $item['str'];}
			if($item['agil'] != null) {$stats .= "<br/>Agility +" . $item['agil'];}
			if($item['intl'] != null) {$stats .= "<br/>Intelligence +" . $item['intl'];}
			if($item['armor'] != null) {$stats .= "<br/>Armor +" . $item['armor'];}
			if($item['hp_regen'] != null) {$stats .= "<br/>HP Regen +" . $item['hp_regen'];}
			if($item['mana_regen'] != null) {$stats .= "<br/>Mana Regen +" . $item['mana_regen'] . "%";}
			if($item['dmg'] != null) {$stats .= "<br/>Damage +" . $item['dmg'];}
			if($item['atk_spd'] != null) {$stats .= "<br/>Attack Speed +" . $item['atk_spd'];}
			if($item['move_spd'] != null) {$stats .= "<br/>Move Speed +" . $item['move_spd'];}
			if($item['magic_resist'] != null) {$stats .= "<br/>Spell Resistance " . $item['magic_resist'] . "%";}
			if($item['active_name'] != null)
			{
				$text .= "<span class='itemabilitynamedetail'>" . $item['active_name'] . ":</span> (Active)";
				if($item['active_desc'] != null) {$text .= "<br/><span class='textsmall'>" . desctext($item['active_desc']) . "</span></br>";}
				if($item['active_duration'] != null) {$text .= "<br/>Duration: " . $item['active_duration'];}
				if($item['active_range_ward'] != null)
				{
					if($item['active_range'] != null) {$text .= "<br/>Range (Tree): " . $item['active_range'];}
					$text .= "<br/>Range (Ward): " . $item['active_range_ward'];
				}
				else
				{
					if($item['active_range'] != null) {$text .= "<br/>Range: " . $item['active_range'];}
				}
				if($item['active_hp_total'] != null) {$text .= "<br/>HP Restored: " . $item['active_hp_total'] . "/charge";}
				if($item['active_mana_total']) {$text .= "<br/>Mana Restored: " . $item['active_mana_total'] . "/charge";}
				if($item['active_cooldown'] != null || $item['active_mana'] != null) {$text .= "</br>";}
				if($item['active_cooldown'] != null) {$text .= "<img src='" . $cooldownimg . "' height='14px'/> " . $item['active_cooldown'] . "&nbsp;&nbsp;&nbsp;";}
				if($item['active_mana'] != null) {$text .= "<img src='" . $manaimg . "' height='14px'/> " . $item['active_mana'];}
			}
			if($item['passive_name'])
			{
				if($item['active_name'] != null) {$text .= "<hr/>";}
				$text .= "<span class='itemabilitynamedetail'>" . $item['passive_name'] . ":</span> (Passive)";
				if($item['unique_atk_mod_lifesteal'] == 1) {$text .= "<br/><span class='itemuamdetail'>Unique Attack Modifier (Lifesteal)</span>";}
				if($item['unique_atk_mod_pluslifesteal'] == 1) {$text .= "<br/><span class='itemuamdetail'>Unique Attack Modifier<br/>(Stacks with Lifesteal)</span>";}
				if($item['passive_desc'] != null) {$text .= "<br/><span class='textsmall'>" . desctext($item['passive_desc']) . "</span></br>";}
				if($item['lifesteal'] != null) {$text .= "<br/>Lifesteal: " . $item['lifesteal'] . "%";}
				if($item['block_chance'] != null) {$text .= "<br/>" . $item['block_melee_holder'] . " (Melee Holder)<br/>" . $item['block_ranged_holder'] . " (Ranged Holder)</br>Block Chance: " . $item['block_chance'] . "%";}
				if($item['passive_radius'] != null) {$text .= "<br/>Radius: " . $item['passive_radius'];}
				if($item['passive_bonus_dmg_chance'] != null) {$text .= "<br/>Bonus Damage Chance: " . $item['passive_bonus_dmg_chance'] . "%";}
				if($item['passive_bonus_dmg'] != null) {$text .= "<br/>Bonus Damage: " . $item['passive_bonus_dmg'];}
				if($item['passive_bonus_dmg_melee_percent'] != null && $item['passive_bonus_dmg_ranged_percent'] != null) {$text .= "<br/>Bonus Damage:</br>" . $item['passive_bonus_dmg_melee_percent'] . "% (Melee Holder)<br/>" . $item['passive_bonus_dmg_ranged_percent'] . "% (Ranged Holder)";}
				if($item['passive_dmg_psec'] != null) {$text .= "<br/>Damage: " . $item['passive_dmg_psec'] . "/second";}
				if($item['passive_move_spd_reduct_percent_melee_wielder'] != null && $item['passive_move_spd_reduct_percent_ranged_wielder'] != null) {$text .= "<br/>Movement Slow:<br/>" . $item['passive_move_spd_reduct_percent_melee_wielder'] . "% (Melee Holder)<br/>" . $item['passive_move_spd_reduct_percent_ranged_wielder'] . "% (Ranged Holder)</br>";}
				if($item['passive_duration'] != null) {$text .= "Duration: " . $item['passive_duration'];}
			}
		break;
		
		case "upgrades":
			$or = "";
			if($item['name'] == "Power Treads")
			{
				$or = " <b>or</b>";
			}
			$sideshop = "";
			if($item['sideshop_entirely'] == 1 || $item['sideshop_partly'] == 1 || $item['secretshop_only'] == 1 || $item['secretshop_partly'] == 1 )
			$sideshop = "&nbsp;";
			if($item['sideshop_partly'] == 1)
			{
				$sideshop .= "&nbsp;" . $LshopWtext;
			}
			if($item['sideshop_entirely'] == 1)
			{
				$sideshop .= "&nbsp;" . $LshopBtext;
			}
			if($item['secretshop_partly'] == 1)
			{
				$sideshop .= "&nbsp;" . $SshopWtext;
			}
			if($item['secretshop_only'] == 1)
			{
				$sideshop .= "&nbsp;" . $SshopRtext;
			}
			if($item['str'] != null) {$stats .= "<br/>Strength +" . $item['str'] . $or;}
			if($item['agil'] != null) {$stats .= "<br/>Agility +" . $item['agil'] . $or;}
			if($item['intl'] != null) {$stats .= "<br/>Intelligence +" . $item['intl'];}
			if($item['armor'] != null) {$stats .= "<br/>Armor +" . $item['armor'];}
			if($item['hp'] != null) {$stats .= "<br/>HP +" . $item['hp'];}
			if($item['hp_regen'] != null) {$stats .= "<br/>HP Regen +" . $item['hp_regen'];}
			if($item['mana'] != null) {$stats .= "<br/>Mana +" . $item['mana'];}
			if($item['mana_regen'] != null) {$stats .= "<br/>Mana Regen +" . $item['mana_regen'] . "%";}
			if($item['dmg'] != null) {$stats .= "<br/>Damage +" . $item['dmg'];}
			if($item['atk_spd'] != null) {$stats .= "<br/>Attack Speed +" . $item['atk_spd'];}
			if($item['move_spd'] != null) {$stats .= "<br/>Move Speed +" . $item['move_spd'];}
			if($item['move_spd_percent'] != null) {$stats .= "<br/>Move Speed +" . $item['move_spd_percent'] . "%";}
			if($item['magic_resist'] != null) {$stats .= "<br/>Spell Resistance " . $item['magic_resist'] . "%";}
			if($item['evasion'] != null) {$stats .= "<br/>Evasion: " . $item['evasion'] . "%";}
			if($item['active_name'] != null)
			{	
				if($item['name'] == "Magic Wand")
				{
					$mw = "/charge";
				}
				else
				{
					$mw = "";
				}
				$text .= "<span class='itemabilitynamedetail'>" . $item['active_name'] . ":</span> (Active)";
				if($item['active_desc'] != null) {$text .= "<br/><span class='textsmall'>" . desctext($item['active_desc']) . "</span></br>";}
				if($item['active_charges'] != null) {$text .= "<br/>Charges: " . $item['active_charges'];}
				if($item['active_duration'] != null && $item['active_duration_melee_target'] != null)
				{
					$text .= "<br/>Duration:</br>" . $item['active_duration_melee_target'] . " (Melee Target)<br/>" . $item['active_duration'] . " (Ranged Target)";
				}
				else
				{
					if($item['active_duration_reduct_puse'] != null)
					{
						$text .= "<br/>Duration: " . $item['active_duration'];
						$temp = $item['active_duration'];
						while($temp > $item['active_duration_reduct_min'])
						{
							$temp = ($temp - $item['active_duration_reduct_puse']);
							$text .= ">" . $temp;
						}
					}
					else
					{
						if($item['active_duration'] != null) {$text .= "<br/>Duration: " . $item['active_duration'];}
						if($item['active_duration_selfally'] != null) {$text .= " (" . $item['active_duration_selfally'] . " on self or ally)";}
					}
				}
				if($item['active_range_ward'] != null)
				{
					if($item['active_range'] != null) {$text .= "<br/>Range (Tree): " . $item['active_range'];}
					$text .= "<br/>Range (Ward): " . $item['active_range_ward'];
				}
				else
				{
					if($item['active_range'] != null) {$text .= "<br/>Range: " . $item['active_range'];}
				}
				if($item['active_radius'] != null) {$text .= "<br/>Radius: " . $item['active_radius'];}
				if($item['active_str'] != null) {$text .= "<br/>Strength +" . $item['active_str'];}
				if($item['active_hp_total'] != null) {$text .= "<br/>HP Restored: " . $item['active_hp_total'] . $mw;}
				if($item['active_hp_drain'] != null) {$text .= "<br/>HP Drain: " . $item['active_hp_drain'] . "/second";}
				if($item['active_hp_cost'] != null) {$text .= "<br/>HP Cost: " . $item['active_hp_cost'];}
				if($item['active_mana_total'] != null) {$text .= "<br/>Mana Restored: " . $item['active_mana_total'] . $mw;}
				if($item['active_armor'] != null) {$text .= "<br/>Armor +" . $item['active_armor'];}
				if($item['active_armor_reduct'] != null) {$text .= "<br/>Armor -" . $item['active_armor_reduct'];}
				if($item['active_dmg_total'] != null) {$text .= "<br/>Damage: " . $item['active_dmg_total'];}
				if($item['active_dmg_chance'] != null) {$text .= "<br/>Damage Chance: " . $item['active_dmg_chance'] . "%";}
				if($item['active_dmg_received_amp'] != null) {$text .= "<br/>Damage Recieved Amplified " . $item['active_dmg_received_amp'] . "%";}
				if($item['active_dmg_target_amp'] != null) {$text .= "<br/>Damage Amplified " . $item['active_dmg_target_amp'] . "%";}
				if($item['active_atk_spd'] != null) {$text .= "<br/>Attack Speed +" . $item['active_atk_spd'];}
				if($item['active_move_spd_percent'] != null && $item['active_move_spd_percent_2'] != null)
				{
					$text .= "</br>Melee Move Speed: +" . $item['active_move_spd_percent'] . "%";
					$text .= "</br>Ranged Move Speed: +" . $item['active_move_spd_percent_2'] . "%";
				}
				else
				{
					if($item['active_move_spd_percent'] != null) {$text .= "<br/>Move Speed +" . $item['active_move_spd_percent'] . "%";}
				}
				if($item['active_move_spd_reduct_percent'] != null) {$text .= "<br/>Move Speed -" . $item['active_move_spd_reduct_percent'] . "%";}
				if($item['active_magic_dmg_amp'] != null) {$text .= "<br/>Magic Damage Amplified " . $item['active_magic_dmg_amp'] . "%";}
				if($item['active_magic_resistance_percent'] != null) {$text .= "<br/>Spell Resistance: " . $item['active_magic_resistance_percent'] . "%";}
				if($item['active_dmg_reduct_percent'] != null) {$text .= "<br/>Enemy Damage -" . $item['active_dmg_reduct_percent'] . "%";}
				if($item['active_reduct_duration'] != null) {$text .= "<br/>Reduction Duration: " . $item['active_reduct_duration'];}
				if($item['active_cooldown'] != null && $item['active_cooldown_2'] != null)
				{
					$text .= "</br>Melee: <img src='" . $cooldownimg . "' height='14px'/> " . $item['active_cooldown'] . "&nbsp;&nbsp;&nbsp;";
					if($item['active_mana'] != null) {$text .= "<img src='" . $manaimg . "' height='14px'/> " . $item['active_mana'];}
					$text .= "</br>Ranged: <img src='" . $cooldownimg . "' height='14px'/> " . $item['active_cooldown_2'] . "&nbsp;&nbsp;&nbsp;";
					if($item['active_mana'] != null) {$text .= "<img src='" . $manaimg . "' height='14px'/> " . $item['active_mana'];}
					
				}
				else
				{
					if($item['active_cooldown'] != null || $item['active_mana'] != null) {$text .= "</br>";}
					if($item['active_cooldown_reduct_puse'] != null)
					{
						$text .= "<img src='" . $cooldownimg . "' height='14px'/> " . $item['active_cooldown'];
						$temp = $item['active_cooldown'];
						while($temp > $item['active_cooldown_reduct_min'])
						{
							$temp = ($temp - $item['active_cooldown_reduct_puse']);
							$text .= ">" . $temp;
						}
					}
					else
					{
						if($item['active_cooldown'] != null) {$text .= "<img src='" . $cooldownimg . "' height='14px'/> " . $item['active_cooldown'] . "&nbsp;&nbsp;&nbsp;";}
					}
					if($item['active_mana'] != null) {$text .= "<img src='" . $manaimg . "' height='14px'/> " . $item['active_mana'];}
				}
			}
			if($item['active_name2'] != null)
			{
				if($item['active_name2'] != null) {$text .= "<hr/>";}
				$text .= "<span class='itemabilitynamedetail'>" . $item['active_name2'] . ":</span> (Active)";
				if($item['active_desc2'] != null) {$text .= "<br/><span class='textsmall'>" . desctext($item['active_desc2']) . "</span></br>";}
				if($item['active_range2'] != null) {$text .= "<br/>Range: " . $item['active_range2'];}
				if($item['active_cooldown2'] != null) {$text .= "<img src='" . $cooldownimg . "' height='14px'/> " . $item['active_cooldown2'] . "&nbsp;&nbsp;&nbsp;";}
			}
			if($item['passive_name'] != null)
			{
				if($item['active_name'] != null || $item['active_name2'] != null) {$text .= "<hr/>";}
				$text .= "<span class='itemabilitynamedetail'>" . $item['passive_name'] . ":</span>";
				if($item['aura'] == 1) {$text .= " (Aura)";} else {$text .= " (Passive)";}
				if($item['unique_atk_mod'] == 1) {$text .= "<br/><span class='itemuamdetail'>Unique Attack Modifier</span>";}
				if($item['unique_atk_mod_lifesteal'] == 1) {$text .= "<br/><span class='itemuamdetail'>Unique Attack Modifier (Lifesteal)</span>";}
				if($item['unique_atk_mod_pluslifesteal'] == 1) {$text .= "<br/><span class='itemuamdetail'>Unique Attack Modifier<br/>(Stacks with Lifesteal)</span>";}
				if($item['unique_atk_mod_interupt'] == 1) {$text .= "<br/><span class='itemuamdetail'>Unique Attack Modifier<br/>(Stacking Interupt)</span>";}
				if($item['passive_desc'] != null) {$text .= "<br/><span class='textsmall'>" . desctext($item['passive_desc']) . "</span></br>";}
				if($item['lifesteal_ranged'] != null)
				{
					if($item['lifesteal'] != null) {$text .= "<br/>Lifesteal (Melee Ally): " . $item['lifesteal'] . "%";}
					$text .= "<br/>Lifesteal (Ranged Ally): " . $item['lifesteal_ranged'] . "%";
				}
				else
				{
					if($item['lifesteal'] != null) {$text .= "<br/>Lifesteal: " . $item['lifesteal'] . "%";}
				}
				if($item['block_chance'] != null) {$text .= "<br/>" . $item['block_melee_holder'] . " (Melee Holder)<br/>" . $item['block_ranged_holder'] . " (Ranged Holder)</br>Block Chance: " . $item['block_chance'] . "%";}
				if($item['passive_chain_bounce_range'] != null) {$text .= "<br/>Chain Targets: " . $item['passive_chain_targets'] . "<br/>Chain Range: " . $item['passive_chain_bounce_range'];}
				if($item['passive_charges'] != null) {$text .= "<br/>Charges: " . $item['passive_charges'];}
				if($item['passive_duration'] != null) {$text .= "<br/>Duration: " . $item['passive_duration'];}
				if($item['passive_duration_melee_holder'] != null && $item['passive_duration_ranged_holder'] != null) {$text .= "<br/>Duration:<br/>" . $item['passive_duration_melee_holder'] . " (Melee Holder)<br/>" . $item['passive_duration_ranged_holder'] . " (Ranged Holder)";}
				if($item['passive_radius'] != null) {$text .= "<br/>Radius: " . $item['passive_radius'];}
				if($item['passive_hp_regen'] != null) {$text .= "<br/>HP Regen +" . $item['passive_hp_regen'];}
				if($item['passive_hp_regen_percent'] != null) {$text .= "<br/>HP Regen +" . $item['passive_hp_regen_percent'] . "%";}
				if($item['passive_mana_regen'] != null) {$text .= "<br/>Mana Regen +" . $item['passive_mana_regen'];}
				if($item['passive_mana_burn'] != null) {$text .= "<br/>Mana Burn: " . $item['passive_mana_burn'];}
				if($item['passive_magic_resistance_percent'] != null) {$text .= "<br/>Spell Resistance: " . $item['passive_magic_resistance_percent'] . "%";}
				if($item['name'] == "Assault Cuirass")
				{
					if($item['passive_armor'] != null) {$text .= "<br/>Armor +" . $item['passive_armor'] . " (for Allies)";}
					if($item['passive_armor_reduct'] != null) {$text .= "<br/>Armor -" . $item['passive_armor_reduct'] . " (for Enemies)";}
				}
				else
				{
					if($item['passive_armor'] != null) {$text .= "<br/>Armor +" . $item['passive_armor'];}
					if($item['name'] == "Desolator")
					{
						if($item['passive_armor_reduct'] != null) {$text .= "<br/>Target Armor -" . $item['passive_armor_reduct'];}
					}
					else
					{	
						if($item['passive_armor_reduct'] != null) {$text .= "<br/>Armor -" . $item['passive_armor_reduct'];}
					}
				}
				if($item['passive_bonus_dmg_chance'] != null) {$text .= "<br/>Bonus Damage Chance: " . $item['passive_bonus_dmg_chance'] . "%";}
				if($item['passive_bonus_dmg'] != null) {$text .= "<br/>Bonus Damage: " . $item['passive_bonus_dmg'];}
				if($item['passive_dmg_psec'] != null) {$text .= "<br/>Bonus Damage: " . $item['passive_dmg_psec'] . "/second";}
				if($item['passive_dmg_percent'] != null) {$text .= "<br/>Bonus Damage: " . $item['passive_dmg_percent'] . "%";}
				if($item['passive_crit_chance'] != null) {$text .= "<br/>Crit Chance: " . $item['passive_crit_chance'] . "%";}
				if($item['passive_crit_dmg_multi'] != null) {$text .= "<br/>Crit Damage: ×" . $item['passive_crit_dmg_multi'];}
				if($item['passive_atk_spd'] != null) {$text .= "<br/>Attack Speed +" . $item['passive_atk_spd'];}
				if($item['passive_atk_spd_reduct'] != null) {$text .= "<br/>Attack Speed -" . $item['passive_atk_spd_reduct'];}
				if($item['passive_atk_spd_reduct_percent'] != null) {$text .= "<br/>Attack Speed -" . $item['passive_atk_spd_reduct_percent'] . "%";}
				if($item['passive_move_spd_percent'] != null) {$text .= "<br/>Move Speed +" . $item['passive_move_spd_percent'] . "%";}
				if($item['passive_move_spd_reduct_percent'] != null) {$text .= "<br/>Move Speed -" . $item['passive_move_spd_reduct_percent'] . "%";}
				if($item['passive_stun_chance_melee_holder'] != null && $item['passive_stun_chance_ranged_holder'] != null)
				{
					if($item['passive_stun_chance_melee_holder'] == $item['passive_stun_chance_ranged_holder'])
					{
						$text .= "<br/>Stun Chance: " . $item['passive_stun_chance_melee_holder'] . "%";
					}
					else
					{
						$text .= "<br/>Stun Chance:<br/>" . $item['passive_stun_chance_melee_holder'] . "% (Melee Holder)<br/>" . $item['passive_stun_chance_ranged_holder'] . "% (Ranged Holder)";
					}
				}
				if($item['passive_stun_time'] != null) {$text .= "<br/>Stun Time: " . $item['passive_stun_time'];}
				if($item['passive_ministun_time'] != null) {$text .= "<br/>Mini-Stun Time: " . $item['passive_ministun_time'];}
				if($item['passive_enemy_miss_chance'] != null) {$text .= "<br/>Enemy Miss Chance: " . $item['passive_enemy_miss_chance'] . "%";}
				if($item['passive_slow_chance'] != null) {$text .= "<br/>Maim Chance: " . $item['passive_slow_chance'] . "%";}
				if($item['passive_cooldown_reduct_percent'] != null) {$text .= "<br/>Cooldown Reduction: " . $item['passive_cooldown_reduct_percent'] . "%";}
				if($item['passive_hp_threshold_percent'] != null) {$text .= "<br/>HP Threshold: " . $item['passive_hp_threshold_percent'] . "%";}
				if($item['passive_hp_regen_below_threshold'] != null) {$text .= "<br/>Threshold HP Regen +" . $item['passive_hp_regen_below_threshold'];}
				if($item['passive_armor_below_threshold'] != null) {$text .= "<br/>Threshold Armor +" . $item['passive_armor_below_threshold'];}
				if($item['passive_cooldown'] != null) {$text .= "<br/><img src='" . $cooldownimg . "' height='14px'/> " . $item['passive_cooldown'];}
			}
			if($item['passive_name2'] != null)
			{
				if($item['active_name'] != null || $item['active_name2'] != null || $item['passive_name'] != null) {$text .= "<hr/>";}
				$text .= "<span class='itemabilitynamedetail'>" . $item['passive_name2'] . ":</span> (Passive)";
			}
			if($item['passive_desc2'] != null) {$text .= "<br/><span class='textsmall'>" . desctext($item['passive_desc2'] . "</span>");}
			if($item['passive_name2'] != null)
			{
				$text .= "<br/>";
				if($item['passive_hero_spell_lifesteal2'] != null) {$text .= "<br/>Hero Spell Lifesteal: " . $item['passive_hero_spell_lifesteal2'] . "%";}
				if($item['passive_creep_spell_lifesteal2'] != null) {$text .= "<br/>Creep Spell Lifesteal: " . $item['passive_creep_spell_lifesteal2'] . "%";}
				if($item['passive_bonus_dmg_melee_percent2'] != null && $item['passive_bonus_dmg_ranged_percent2'] != null) {$text .= "<br/>Bonus Damage:</br>" . $item['passive_bonus_dmg_melee_percent2'] . "% (Melee Holder)<br/>" . $item['passive_bonus_dmg_ranged_percent2'] . "% (Ranged Holder)";}
			}
		break;
		
		case "secret":
			$sideshop = "&nbsp;" . $SshopRtext;
			if($item['sideshop_also'] == 1)
			{
				$sideshop = "&nbsp;" . $LshopBtext . "&nbsp;" . $SshopRtext;
			}
			if($item['str'] != null) {$stats .= "<br/>Strength +" . $item['str'];}
			if($item['agil'] != null) {$stats .= "<br/>Agility +" . $item['agil'];}
			if($item['intl'] != null) {$stats .= "<br/>Intelligence +" . $item['intl'];}
			if($item['armor'] != null) {$stats .= "<br/>Armor +" . $item['armor'];}
			if($item['hp'] != null) {$stats .= "<br/>HP +" . $item['hp'];}
			if($item['hp_regen'] != null) {$stats .= "<br/>HP Regen +" . $item['hp_regen'];}
			if($item['mana'] != null) {$stats .= "<br/>Mana +" . $item['mana'];}
			if($item['mana_regen'] != null) {$stats .= "<br/>Mana Regen +" . $item['mana_regen'] . "%";}
			if($item['dmg'] != null) {$stats .= "<br/>Damage +" . $item['dmg'];}
			if($item['atk_spd'] != null) {$stats .= "<br/>Attack Speed +" . $item['atk_spd'];}
			if($item['evasion'] != null) {$stats .= "<br/>Evasion: " . $item['evasion'] . "%";}
		break;
		
		case "other":
			switch($item['type'])
			{
				case "Roshan Drop":
					if($item['description'] != null) {$text .= "<br/>" . desctext($item['description']);}
					if($item['active_name'] != null)
					{
						$text .= "<br/><hr size='1'/><span class='itemabilitynamedetail'>" . $item['active_name'] . ":</span>";
						if($item['active_desc_short'] != null) {$text .= "<br/><span class='textsmall'>" . desctext($item['active_desc_short']) . "</span><br/>";}
						if($item['active_charges'] != null) {$text .= "<br/>Charges: " . $item['active_charges'];}
						if($item['active_hp_restored'] != null) {$text .= "<br/>HP Restored: " . $item['active_hp_restored'];}
						if($item['active_mana_restored'] != null) {$text .= "<br/>Mana Restored: " . $item['active_mana_restored'];}
						if($item['active_cooldown'] != null) {$text .= "<br/><img src='" . $cooldownimg . "' height='14px'/> " . $item['active_cooldown'] . "&nbsp;&nbsp;&nbsp;";}
					}
					if($item['passive_name'] != null)
					{
						$text .= "<br/><hr size='1'/><span class='itemabilitynamedetail'>" . $item['passive_name'] . ":</span>";
						if($item['passive_desc_short'] != null) {$text .= "<br/><span class='textsmall'>" . desctext($item['passive_desc_short']) . "</span><br/>";}
					}
				break;
				case "Recipe":
					$text = "Incorrect display use for 'Recipe', please report!";
				break;
			}
		break;
	}
	
	$stats = "<span class='statstext'>" . $stats . "</span>";

	//display
	echo "<br/> <!-- required to keep page out from under the header, table css adds much space at top of other pages -->";
	echo "<div id='result'>";
		echo "<div id='center' class='table textleft'>";
			echo "<div class='table-row'>";
				echo "<div class='table-cell' style=\"vertical-align:middle; height:" . ($recipeitemimgheight+($itemrowpadding)+2) . "px;\">";
					echo str_replace("\'","'",titletextdetail($item['name'],$item['type']) . "<br/>");
					if($item['cost'] != null) {echo "<img src='" . $goldimg . "' height='16px'/><span class='itemcostdetail'>" . $item['cost'] . "</span>&nbsp;";}
					echo "<span class='itemtextdetail'>" . $item['type'] . "<br/>" . $sideshop;
				echo "</div>";
				echo "<div class='table-cell floatright'>";
					$prereqs = 0;
					if(isset($item['prereqs']))
					{
						$prereqs = 1; //dirty fix, doesn't actually use DB value BUT only upgrades has the column and they will always be "1" at this time
						//$prereqs = $item['prereqs'];
					}
					if($prereqs == 1)
					{
						echo "<b>Recipe: </b>";
						$recipe_items = Tokenise($item['prereqs']);
						foreach ($recipe_items as $recipe_item)
						{
							displaySuggestedItem($db,$recipe_item,"revd","Radiant",$recipeitemimgwidth,$recipeitemimgheight,$itemrowpadding,$upgradeable_items,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
						}
						if($item['has_recipe'] == 1)
						{
							displayRecipeItem($db,$item,$recipeitemimgwidth,$recipeitemimgheight,$itemrowpadding,$hoverimg,$goldimg);
						}
					}
				echo "</div>";
			echo "</div>";
		echo "</div>";
		
		echo "<div id='center' class='table textleft'>";
			echo "<div id='" . $item['name'] . "' class='table-row'>";
				echo "<div class='table-cell' style='width:" . ($itemimgwidth+15) . "px; vertical-align: top; padding-right:9px;'>";
					echo "<div class='itemdetailthumb' style='width:" . $itemimgwidth . "px;'><img style='border-style:ridge;border-width:4px;border-color:" . $bordercolor . ";' src=\"" . $item['img'] . "\" alt=\"" . $item['name'] . "\" width=\"" . $itemimgwidth . "\">";
					echo "<span class=\"hotspot\" onmouseover=\"tooltip.show('" . $itemtooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"" . $item['wiki_url'] . "\" alt=\"" . $item['name'] . "\"><img class=\"itemdetailthumb-hoverimage\" src=\"" . $hoverimg . "\"/></a></span></div>";
				echo "</div>";
				echo "<div class='table-cell' style='width:" . $midcolwidth . "px; vertical-align: top; padding:" . $itemrowpadding . "px;'>";
					echo $stats;
					$upgradeable = 0;
					if(isset($item['upgradeable'])){$upgradeable = $item['upgradeable'];}
					if($upgradeable == 1)
					{
						echo "<br/><br/>Upgradable:";
						$temp_name = str_replace(" (Lvl " . $item['upgrade_level'] . ")","",$item['name']);
						for($i = 1;$i<=$item['upgrade_max'];$i++)
						{
							if($i != $item['upgrade_level'])
							{
								displaySuggestedItem($db,($temp_name . " (Lvl " . $i . ")"),"d","Radiant",$upgradeitemimgwidth,$upgradeitemimgheight,$itemrowpadding,$upgradeable_items,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
							}
						}
					}
				echo "</div>";
				echo "<div class='table-cell' style='width:" . $rightcolwidth . "px; vertical-align: top; padding:" . $itemrowpadding . "px;'>";
					echo $text;
				echo "</div>";
			echo "</div>";
		echo "</div>";
	echo "<br/>";
	echo "</div>";
}
//-----------------------------------------------------------------------------//
?>