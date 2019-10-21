<?php
//-----------------------------------------------------------------------------//
//	getItemTable() - Returns the table the input item is on
//-----------------------------------------------------------------------------//
function getItemTable ($db,$item_name)
{
	$table = mysqli_fetch_array(mysqli_query($db,"SELECT table_name FROM items_index WHERE item_name = \"" . $item_name . "\""));
	
	return $table['table_name'];
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	getRecipeCost() - Returns the cost of the recipe for the input item
//-----------------------------------------------------------------------------//
function getRecipeCost ($db,$item)
{
	$cost = $item['cost'];
	$table = getItemTable($db,$item['name']);
	if($table == "consumables" || $table == "upgrades")
	{
		foreach(Tokenise($item['prereqs']) as $rec_item)
		{
			$table = getItemTable($db,$rec_item);
			$item_data = mysqli_fetch_array(mysqli_query($db,"SELECT cost FROM " . $table . " WHERE name =\"" . $rec_item . "\""));
			$cost -= $item_data['cost'];
		}
	}
	else
	{
		$cost = getItemTable($db,$item_name);
	}
	
	return $cost;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	buildItemTooltip() - Returns string for advanced item tooltips content
//-----------------------------------------------------------------------------//
function buildItemTooltip($db,$item_name,$table,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg)
{	
	$tooltip = "Tooltip error, please report!";
	switch($table)
	{
		case "consumables":
			$item_data = mysqli_query($db,"SELECT sideshop,type,short_desc,cost,hp_restored,hp_restored_ward,mana_restored,active_name,charges,hp_regen,dmg,mana_cost,cooldown,duration,radius,move_spd FROM consumables WHERE name =\"" . $item_name . "\"");
			while($item_values = mysqli_fetch_array($item_data))
			{
				$item = array ( "sideshop" => $item_values['sideshop'],
								"type" => $item_values['type'],
								"cost" => $item_values['cost'],
								"hp_restored" => $item_values['hp_restored'],
								"hp_restored_ward" => $item_values['hp_restored_ward'],
								"mana_restored" => $item_values['mana_restored'],
								"short_desc" => $item_values['short_desc'],
								"active_name" => $item_values['active_name'],
								"charges" => $item_values['charges'],
								"hp_regen" => $item_values['hp_regen'],
								"dmg" => $item_values['dmg'],
								"mana_cost" => $item_values['mana_cost'],
								"cooldown" => $item_values['cooldown'],
								"duration" => $item_values['duration'],
								"radius" => $item_values['radius'],
								"move_spd" => $item_values['move_spd']
								);
			}
			$sideshop = "";
			if($item['sideshop'] == 1)
			{
				$sideshop = "&nbsp;<img src=\'" . $LshopBimg . "\'/>";
			}
			$tooltip = titletext($item_name,$item['type']) . "<br/><img src=\'" . $goldimg . "\' height=\'12px\'/><span class=\'itemcost\'>" . $item['cost'] . "</span>&nbsp;<span class=\'itemtext\'>" . $item['type'] . "<span class=\'shopicons\'>" . $sideshop . "</span>";
			switch($item['type'])
			{
				case "Consumable":
					$tooltip .= "<br/><span class=\'itemabilityname\'>" . $item['active_name'] . ": </span>";
					if($item['short_desc'] != null) {$tooltip .= "<br/>" . desctexttooltip($item['short_desc']);}
					if($item['charges'] != null) {$tooltip .= "<br/>Charges: " . $item['charges'];}
					if($item['hp_regen'] != null) {$tooltip .= "<br/>HP Regen +" . $item['hp_regen'];}
					if($item['dmg'] != null) {$tooltip .= "<br/>Damage +" . $item['dmg'];}
					if($item['duration'] != null) {$tooltip .= "<br/>Duration: " . $item['duration'];}
					if($item['radius'] != null) {$tooltip .= "<br/>Radius: " . $item['radius'];}
					if($item['hp_restored_ward'] != null)
					{
						if($item['hp_restored'] != null) {$tooltip .= "<br/>HP Restored (Tree): " . $item['hp_restored'];}
						$tooltip .= "<br/>HP Restored (Ward): " . $item['hp_restored_ward'];
					}
					else
					{
						if($item['hp_restored'] != null) {$tooltip .= "<br/>HP Restored: " . $item['hp_restored'];}
					}
					if($item['mana_restored'] != null) {$tooltip .= "<br/>Mana Restored: " . $item['mana_restored'];}
					if($item['move_spd'] != null) {$tooltip .= "<br/>Move Speed +" . $item['move_spd'];}
					if($item['cooldown'] != null || $item['mana_cost'] != null) {$tooltip .= "</br>";}
					if($item['cooldown'] != null) {$tooltip .= "<img src=\'" . $cooldownimg . "\' height=\'14px\'/> " . $item['cooldown'] . "&nbsp;&nbsp;&nbsp;";}
					if($item['mana_cost'] != null) {$tooltip .= "<img src=\'" . $manaimg . "\' height=\'14px\'/> " . $item['mana_cost'];}
				break;
				case "Courier":
					$tooltip .= "<br/>HP: " . $item['hp_restored'];
					if($item['mana_restored'] > 0) {$tooltip .= "<br/>Armor: " . $item['mana_restored'];}
					$tooltip .= "</br>Move Speed: " . $item['move_spd'];
					$tooltip .= "<br/>" . desctexttooltip($item['short_desc']);
				break;
				case "Ward":
					$tooltip .= "<br/>" . desctexttooltip($item['short_desc']) . "<br/>Uses: " . $item['charges'] . "<br/>Duration: " . durationtext($item['duration']) . "<br/>Radius: " . $item['radius'] . "<br/>HP: " . $item['hp_restored'] . "</br><img src=\'" . $cooldownimg . "\' height=\'14px\'/> " . $item['cooldown'];
				break;
			}
			$tooltip .= "</span>";
		break;
		
		case "basics":
			$item_data = mysqli_query($db,"SELECT sideshop,type,cost,str,agil,intl,armor,block_chance,block_melee_holder,block_ranged_holder,dmg,hp_regen,mana_regen,atk_spd,move_spd,magic_resist,lifesteal,active_name,active_desc_short,active_range,active_range_ward,active_cooldown,active_mana,active_duration,active_hp_total,active_mana_total,passive_name,passive_desc_short,passive_radius,passive_bonus_dmg_chance,passive_bonus_dmg,passive_bonus_dmg_melee_percent,passive_bonus_dmg_ranged_percent,passive_dmg_psec, passive_move_spd_reduct_percent_melee_wielder, passive_move_spd_reduct_percent_ranged_wielder, passive_duration,unique_atk_mod_lifesteal,unique_atk_mod_pluslifesteal FROM basics WHERE name = \"" . $item_name . "\"");
			while($item_values = mysqli_fetch_array($item_data))
			{
				$item = array ( "sideshop" => $item_values['sideshop'],
								"type" => $item_values['type'],
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
								"block_melee_holder" => $item_values['block_melee_holder'],
								"block_ranged_holder" => $item_values['block_ranged_holder'],
								"lifesteal" => $item_values['lifesteal'],
								"active_name" => $item_values['active_name'],
								"active_desc_short" => $item_values['active_desc_short'],
								"active_range" => $item_values['active_range'],
								"active_range_ward" => $item_values['active_range_ward'],
								"active_cooldown" => $item_values['active_cooldown'],
								"active_mana" => $item_values['active_mana'],
								"active_duration" => $item_values['active_duration'],
								"passive_name" => $item_values['passive_name'],
								"passive_desc_short" => $item_values['passive_desc_short'],
								"passive_radius" => $item_values['passive_radius'],
								"passive_bonus_dmg_chance" => $item_values['passive_bonus_dmg_chance'],
								"passive_bonus_dmg" => $item_values['passive_bonus_dmg'],
								"passive_bonus_dmg_melee_percent" => $item_values['passive_bonus_dmg_melee_percent'],
								"passive_bonus_dmg_ranged_percent" => $item_values['passive_bonus_dmg_ranged_percent'],
								"passive_dmg_psec" => $item_values['passive_dmg_psec'],
								"passive_move_spd_reduct_percent_melee_wielder" => $item_values['passive_move_spd_reduct_percent_melee_wielder'],
								"passive_move_spd_reduct_percent_ranged_wielder" => $item_values['passive_move_spd_reduct_percent_ranged_wielder'],
								"passive_duration" => $item_values['passive_duration']
								);
			}
			$sideshop = "";
			if($item['sideshop'] == 1)
			{
				$sideshop = "&nbsp;&nbsp;<img src=\'" . $LshopBimg . "\'/>";
			}
			$tooltip = titletext($item_name,$item['type']) . "<br/><img src=\'" . $goldimg . "\' height=\'12px\'/><span class=\'itemcost\'>" . $item['cost'] . "</span>&nbsp;<span class=\'itemtext\'>" . $item['type'] . "<span class=\'shopicons\'>" . $sideshop . "</span>";
			if($item['str'] != null) {$tooltip .= "<br/>Strength +" . $item['str'];}
			if($item['agil'] != null) {$tooltip .= "<br/>Agility +" . $item['agil'];}
			if($item['intl'] != null) {$tooltip .= "<br/>Intelligence +" . $item['intl'];}
			if($item['armor'] != null) {$tooltip .= "<br/>Armor +" . $item['armor'];}
			if($item['hp_regen'] != null) {$tooltip .= "<br/>HP Regen +" . $item['hp_regen'];}
			if($item['mana_regen'] != null) {$tooltip .= "<br/>Mana Regen +" . $item['mana_regen'] . "%";}
			if($item['dmg'] != null) {$tooltip .= "<br/>Damage +" . $item['dmg'];}
			if($item['atk_spd'] != null) {$tooltip .= "<br/>Attack Speed +" . $item['atk_spd'];}
			if($item['move_spd'] != null) {$tooltip .= "<br/>Move Speed +" . $item['move_spd'];}
			if($item['magic_resist'] != null) {$tooltip .= "<br/>Spell Resistance " . $item['magic_resist'] . "%";}
			if($item['active_name'] != null)
			{
				$tooltip .= "<br/><hr size=\'1\'/><span class=\'itemabilityname\'>" . $item['active_name'] . ":</span> (Active)";
				if($item['active_desc_short'] != null) {$tooltip .= "<br/>" . desctexttooltip($item['active_desc_short']);}
				if($item['active_duration'] != null) {$tooltip .= "<br/>Duration: " . $item['active_duration'];}
				if($item['active_range_ward'] != null)
				{
					if($item['active_range'] != null) {$tooltip .= "<br/>Range (Tree): " . $item['active_range'];}
					$tooltip .= "<br/>Range (Ward): " . $item['active_range_ward'];
				}
				else
				{
					if($item['active_range'] != null) {$tooltip .= "<br/>Range: " . $item['active_range'];}
				}
				if($item['active_hp_total'] != null) {$tooltip .= "<br/>HP Restored: " . $item['active_hp_total'] . "/charge";}
				if($item['active_mana_total']) {$tooltip .= "<br/>Mana Restored: " . $item['active_mana_total'] . "/charge";}
				if($item['active_cooldown'] != null || $item['active_mana'] != null) {$tooltip .= "</br>";}
				if($item['active_cooldown'] != null) {$tooltip .= "<img src=\'" . $cooldownimg . "\' height=\'14px\'/> " . $item['active_cooldown'] . "&nbsp;&nbsp;&nbsp;";}
				if($item['active_mana'] != null) {$tooltip .= "<img src=\'" . $manaimg . "\' height=\'14px\'/> " . $item['active_mana'];}
			}
			if($item['passive_name'])
			{
				$tooltip .= "<br/><hr size=\'1\'/><span class=\'itemabilityname\'>" . $item['passive_name'] . ":</span> (Passive)";
				if($item['mod_lifesteal'] == 1) {$tooltip .= "<br/><span class=\'itemuam\'>Unique Attack Modifier (Lifesteal)</span>";}
				if($item['mod_stack'] == 1) {$tooltip .= "<br/><span class=\'itemuam\'>Unique Attack Modifier<br/>(Stacks with Lifesteal)</span>";}
				if($item['passive_desc_short'] != null) {$tooltip .= "<br/>" . desctexttooltip($item['passive_desc_short']);}
				if($item['lifesteal'] != null) {$tooltip .= "<br/>Lifesteal: " . $item['lifesteal'] . "%";}
				if($item['block_chance'] != null) {$tooltip .= "<br/>" . $item['block_melee_holder'] . " (Melee Holder)<br/>" . $item['block_ranged_holder'] . " (Ranged Holder)</br>Block Chance: " . $item['block_chance'] . "%";}
				if($item['passive_radius'] != null) {$tooltip .= "<br/>Radius: " . $item['passive_radius'];}
				if($item['passive_bonus_dmg_chance'] != null) {$tooltip .= "<br/>Bonus Damage Chance: " . $item['passive_bonus_dmg_chance'] . "%";}
				if($item['passive_bonus_dmg'] != null) {$tooltip .= "<br/>Bonus Damage: " . $item['passive_bonus_dmg'];}
				if($item['passive_bonus_dmg_melee_percent'] != null && $item['passive_bonus_dmg_ranged_percent'] != null) {$tooltip .= "<br/>Bonus Damage:</br>" . $item['passive_bonus_dmg_melee_percent'] . "% (Melee Holder)<br/>" . $item['passive_bonus_dmg_ranged_percent'] . "% (Ranged Holder)";}
				if($item['passive_dmg_psec'] != null) {$tooltip .= "<br/>Damage: " . $item['passive_dmg_psec'] . "/second";}
				if($item['passive_move_spd_reduct_percent_melee_wielder'] != null && $item['passive_move_spd_reduct_percent_ranged_wielder'] != null) {$tooltip .= "<br/>Movement Slow:<br/>" . $item['passive_move_spd_reduct_percent_melee_wielder'] . "% (Melee Holder)<br/>" . $item['passive_move_spd_reduct_percent_ranged_wielder'] . "% (Ranged Holder)</br>";}
				if($item['passive_duration'] != null) {$tooltip .= "Duration: " . $item['passive_duration'];}
			}
			$tooltip .= "</span>";
		break;
		
		case "upgrades":
			$item_data = mysqli_query($db,"SELECT sideshop_entirely,sideshop_partly,secretshop_only,secretshop_partly,type,cost,str,agil,intl,armor,block_chance,block_melee_holder,block_ranged_holder,dmg,hp,hp_regen,mana,mana_regen,atk_spd,move_spd,move_spd_percent,magic_resist,lifesteal,lifesteal_ranged,evasion,active_name,active_desc_short,active_range,active_range_ward,active_radius,active_cooldown,active_cooldown_2,active_cooldown_reduct_puse,active_cooldown_reduct_min,active_mana,active_duration,active_duration_selfally,active_duration_melee_target,active_duration_reduct_puse,active_duration_reduct_min,active_str,active_armor,active_charges,active_hp_total,active_hp_drain,active_hp_cost,active_mana_total,active_dmg_total,active_dmg_chance,active_dmg_reduct_percent,active_reduct_duration,active_atk_spd,active_move_spd_percent,active_move_spd_percent_2,active_move_spd_reduct_percent,active_armor_reduct,active_magic_dmg_amp,active_magic_resistance_percent,active_dmg_received_amp,active_dmg_target_amp,active_name2,active_desc2_short,active_range2,active_cooldown2,passive_name,passive_desc_short,passive_radius,passive_duration,passive_duration_melee_holder,passive_duration_ranged_holder,passive_mana_burn,passive_magic_resistance_percent,passive_cooldown,passive_bonus_dmg_chance,passive_bonus_dmg,passive_dmg_psec,passive_dmg_percent,passive_crit_chance,passive_crit_dmg_multi,passive_stun_chance_melee_holder,passive_stun_chance_ranged_holder,passive_stun_time,passive_ministun_time,passive_slow_chance,passive_enemy_miss_chance,passive_armor,passive_armor_reduct,passive_charges,passive_hp_regen,passive_hp_regen_percent,passive_mana_regen,passive_atk_spd,passive_atk_spd_reduct,passive_atk_spd_reduct_percent,passive_move_spd_percent,passive_move_spd_reduct_percent,passive_chain_targets,passive_chain_bounce_range,passive_cooldown_reduct_percent,passive_hp_threshold_percent,passive_hp_regen_below_threshold,passive_armor_below_threshold,passive_name2,passive_desc2_short,passive_bonus_dmg_melee_percent2,passive_bonus_dmg_ranged_percent2,passive_hero_spell_lifesteal2,passive_creep_spell_lifesteal2,aura,unique_atk_mod,unique_atk_mod_lifesteal,unique_atk_mod_pluslifesteal,unique_atk_mod_interupt FROM upgrades WHERE name = \"" . $item_name . "\"");
			while($item_values = mysqli_fetch_array($item_data))
			{
				$item = array (	"sideshop_entirely" => $item_values['sideshop_entirely'],
								"sideshop_partly" => $item_values['sideshop_partly'],
								"secretshop_only" => $item_values['secretshop_only'],
								"secretshop_partly" => $item_values['secretshop_partly'],
								"type" => $item_values['type'],
								"cost" => $item_values['cost'],
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
								"passive_bonus_dmg" => $item_values['passive_bonus_dmg'],
								"passive_dmg_percent" => $item_values['passive_dmg_percent'],
								"passive_armor" => $item_values['passive_armor'],
								"passive_hp_regen" => $item_values['passive_hp_regen'],
								"passive_hp_regen_percent" => $item_values['passive_hp_regen_percent'],
								"passive_mana_regen" => $item_values['passive_mana_regen'],
								"passive_atk_spd" => $item_values['passive_atk_spd'],
								"passive_move_spd_percent" => $item_values['passive_move_spd_percent'],
								"passive_move_spd_reduct_percent" => $item_values['passive_move_spd_reduct_percent'],
								"block_melee_holder" => $item_values['block_melee_holder'],
								"block_ranged_holder" => $item_values['block_ranged_holder'],
								"lifesteal" => $item_values['lifesteal'],
								"lifesteal_ranged" => $item_values['lifesteal_ranged'],
								"active_name" => $item_values['active_name'],
								"active_desc_short" => $item_values['active_desc_short'],
								"active_range" => $item_values['active_range'],
								"active_range_ward" => $item_values['active_range_ward'],
								"active_radius" => $item_values['active_radius'],
								"active_cooldown" => $item_values['active_cooldown'],
								"active_cooldown_2" => $item_values['active_cooldown_2'],
								"active_cooldown_reduct_puse" => $item_values['active_cooldown_reduct_puse'],
								"active_cooldown_reduct_min" => $item_values['active_cooldown_reduct_min'],
								"active_mana" => $item_values['active_mana'],
								"active_duration" => $item_values['active_duration'],
								"active_duration_selfally" => $item_values['active_duration_selfally'],
								"active_duration_melee_target" => $item_values['active_duration_melee_target'],
								"active_duration_reduct_puse" => $item_values['active_duration_reduct_puse'],
								"active_duration_reduct_min" => $item_values['active_duration_reduct_min'],
								"active_armor" => $item_values['active_armor'],
								"active_charges" => $item_values['active_charges'],
								"active_hp_drain" => $item_values['active_hp_drain'],
								"active_hp_cost" => $item_values['active_hp_cost'],
								"active_dmg_total" => $item_values['active_dmg_total'],
								"active_dmg_chance" => $item_values['active_dmg_chance'],
								"active_atk_spd" => $item_values['active_atk_spd'],
								"active_move_spd_percent" => $item_values['active_move_spd_percent'],
								"active_move_spd_percent_2" => $item_values['active_move_spd_percent_2'],
								"active_armor_reduct" => $item_values['active_armor_reduct'],
								"active_magic_dmg_amp" => $item_values['active_magic_dmg_amp'],
								"active_magic_resistance_percent" => $item_values['active_magic_resistance_percent'],
								"active_dmg_received_amp" => $item_values['active_dmg_received_amp'],
								"active_dmg_target_amp" => $item_values['active_dmg_target_amp'],
								"active_dmg_reduct_percent" => $item_values['active_dmg_reduct_percent'],
								"active_name2" => $item_values['active_name2'],
								"active_desc2_short" => $item_values['active_desc2_short'],
								"active_range2" => $item_values['active_range2'],
								"active_cooldown2" => $item_values['active_cooldown2'],
								"passive_name" => $item_values['passive_name'],
								"passive_desc_short" => $item_values['passive_desc_short'],
								"passive_radius" => $item_values['passive_radius'],
								"passive_duration" => $item_values['passive_duration'],
								"passive_duration_melee_holder" => $item_values['passive_duration_melee_holder'],
								"passive_duration_ranged_holder" => $item_values['passive_duration_ranged_holder'],
								"passive_mana_burn" => $item_values['passive_mana_burn'],
								"passive_magic_resistance_percent" => $item_values['passive_magic_resistance_percent'],
								"passive_cooldown" => $item_values['passive_cooldown'],
								"passive_bonus_dmg_chance" => $item_values['passive_bonus_dmg_chance'],
								"passive_dmg_psec" => $item_values['passive_dmg_psec'],
								"passive_crit_chance" => $item_values['passive_crit_chance'],
								"passive_crit_dmg_multi" => $item_values['passive_crit_dmg_multi'],
								"passive_stun_chance_melee_holder" => $item_values['passive_stun_chance_melee_holder'],
								"passive_stun_chance_ranged_holder" => $item_values['passive_stun_chance_ranged_holder'],
								"passive_stun_time" => $item_values['passive_stun_time'],
								"passive_ministun_time" => $item_values['passive_ministun_time'],
								"passive_slow_chance" => $item_values['passive_slow_chance'],
								"passive_enemy_miss_chance" => $item_values['passive_enemy_miss_chance'],
								"passive_armor_reduct" => $item_values['passive_armor_reduct'],
								"passive_charges" => $item_values['passive_charges'],
								"passive_atk_spd_reduct" => $item_values['passive_atk_spd_reduct'],
								"passive_atk_spd_reduct_percent" => $item_values['passive_atk_spd_reduct_percent'],
								"passive_chain_targets" => $item_values['passive_chain_targets'],
								"passive_chain_bounce_range" => $item_values['passive_chain_bounce_range'],
								"passive_cooldown_reduct_percent" => $item_values['passive_cooldown_reduct_percent'],
								"passive_hp_threshold_percent" => $item_values['passive_hp_threshold_percent'],
								"passive_hp_regen_below_threshold" => $item_values['passive_hp_regen_below_threshold'],
								"passive_armor_below_threshold" => $item_values['passive_armor_below_threshold'],
								"passive_name2" => $item_values['passive_name2'],
								"passive_desc2_short" => $item_values['passive_desc2_short'],
								"passive_bonus_dmg_melee_percent2" => $item_values['passive_bonus_dmg_melee_percent2'],
								"passive_bonus_dmg_ranged_percent2" => $item_values['passive_bonus_dmg_ranged_percent2'],
								"passive_hero_spell_lifesteal2" => $item_values['passive_hero_spell_lifesteal2'],
								"passive_creep_spell_lifesteal2" => $item_values['passive_creep_spell_lifesteal2']
								);
			}
			$or = "";
			if($item_name == "Power Treads")
			{
				$or = " <b>or</b>";
			}
			$sideshop = "";
			if($item['sideshop_entirely'] == 1 || $item['sideshop_partly'] == 1 || $item['secretshop_only'] == 1 || $item['secretshop_partly'] == 1 )
			$sideshop = "&nbsp;";
			if($item['sideshop_partly'] == 1)
			{
				$sideshop .= "&nbsp;<img src=\'" . $LshopWimg . "\'/>";
			}
			if($item['sideshop_entirely'] == 1)
			{
				$sideshop .= "&nbsp;<img src=\'" . $LshopBimg . "\'/>";
			}
			if($item['secretshop_partly'] == 1)
			{
				$sideshop .= "&nbsp;<img src=\'" . $SshopWimg . "\'/>";
			}
			if($item['secretshop_only'] == 1)
			{
				$sideshop .= "&nbsp;<img src=\'" . $SshopRimg . "\'/>";
			}
			$tooltip = titletext($item_name,$item['type']) . "<br/><img src=\'" . $goldimg . "\' height=\'12px\'/><span class=\'itemcost\'>" . $item['cost'] . "</span>&nbsp;<span class=\'itemtext\'>" . $item['type'] . "<span class=\'shopicons\'>" . $sideshop . "</span>";
			if($item['str'] != null) {$tooltip .= "<br/>Strength +" . $item['str'] . $or;}
			if($item['agil'] != null) {$tooltip .= "<br/>Agility +" . $item['agil'] . $or;}
			if($item['intl'] != null) {$tooltip .= "<br/>Intelligence +" . $item['intl'];}
			if($item['armor'] != null) {$tooltip .= "<br/>Armor +" . $item['armor'];}
			if($item['hp'] != null) {$tooltip .= "<br/>HP +" . $item['hp'];}
			if($item['hp_regen'] != null) {$tooltip .= "<br/>HP Regen +" . $item['hp_regen'];}
			if($item['mana'] != null) {$tooltip .= "<br/>Mana +" . $item['mana'];}
			if($item['mana_regen'] != null) {$tooltip .= "<br/>Mana Regen +" . $item['mana_regen'] . "%";}
			if($item['dmg'] != null) {$tooltip .= "<br/>Damage +" . $item['dmg'];}
			if($item['atk_spd'] != null) {$tooltip .= "<br/>Attack Speed +" . $item['atk_spd'];}
			if($item['move_spd'] != null) {$tooltip .= "<br/>Move Speed +" . $item['move_spd'];}
			if($item['move_spd_percent'] != null) {$tooltip .= "<br/>Move Speed +" . $item['move_spd_percent'] . "%";}
			if($item['magic_resist'] != null) {$tooltip .= "<br/>Spell Resistance " . $item['magic_resist'] . "%";}
			if($item['evasion'] != null) {$tooltip .= "<br/>Evasion: " . $item['evasion'] . "%";}
			if($item['active_name'] != null)
			{	
				if($item_name == "Magic Wand")
				{
					$mw = "/charge";
				}
				else
				{
					$mw = "";
				}
				$tooltip .= "<br/><hr size=\'1\'/><span class=\'itemabilityname\'>" . $item['active_name'] . ":</span> (Active)";
				if($item['active_desc_short'] != null) {$tooltip .= "<br/>" . desctexttooltip($item['active_desc_short']);}
				if($item['active_charges'] != null) {$tooltip .= "<br/>Charges: " . $item['active_charges'];}
				if($item['active_duration'] != null && $item['active_duration_melee_target'] != null)
				{
					$tooltip .= "<br/>Duration:</br>" . $item['active_duration_melee_target'] . " (Melee Target)<br/>" . $item['active_duration'] . " (Ranged Target)";
				}
				else
				{
					if($item['active_duration_reduct_puse'] != null)
					{
						$tooltip .= "<br/>Duration: " . $item['active_duration'];
						$temp = $item['active_duration'];
						while($temp > $item['active_duration_reduct_min'])
						{
							$temp = ($temp - $item['active_duration_reduct_puse']);
							$tooltip .= ">" . $temp;
						}
					}
					else
					{
						if($item['active_duration'] != null) {$tooltip .= "<br/>Duration: " . $item['active_duration'];}
						if($item['active_duration_selfally'] != null) {$tooltip .= "(" . $item['active_duration_selfally'] . " on self or ally)";}
					}
				}
				if($item['active_range_ward'] != null)
				{
					if($item['active_range'] != null) {$tooltip .= "<br/>Range (Tree): " . $item['active_range'];}
					$tooltip .= "<br/>Range (Ward): " . $item['active_range_ward'];
				}
				else
				{
					if($item['active_range'] != null) {$tooltip .= "<br/>Range: " . $item['active_range'];}
				}
				if($item['active_radius'] != null) {$tooltip .= "<br/>Radius: " . $item['active_radius'];}
				if($item['active_str'] != null) {$tooltip .= "<br/>Strength +" . $item['active_str'];}
				if($item['active_hp_total'] != null) {$tooltip .= "<br/>HP Restored: " . $item['active_hp_total'] . $mw;}
				if($item['active_hp_drain'] != null) {$tooltip .= "<br/>HP Drain: " . $item['active_hp_drain'] . "/second";}
				if($item['active_hp_cost'] != null) {$tooltip .= "<br/>HP Cost: " . $item['active_hp_cost'];}
				if($item['active_mana_total'] != null) {$tooltip .= "<br/>Mana Restored: " . $item['active_mana_total'] . $mw;}
				if($item['active_armor'] != null) {$tooltip .= "<br/>Armor +" . $item['active_armor'];}
				if($item['active_armor_reduct'] != null) {$tooltip .= "<br/>Armor -" . $item['active_armor_reduct'];}
				if($item['active_dmg_total'] != null) {$tooltip .= "<br/>Damage: " . $item['active_dmg_total'];}
				if($item['active_dmg_chance'] != null) {$tooltip .= "<br/>Damage Chance: " . $item['active_dmg_chance'] . "%";}
				if($item['active_dmg_received_amp'] != null) {$tooltip .= "<br/>Damage Recieved Amplified " . $item['active_dmg_received_amp'] . "%";}
				if($item['active_dmg_target_amp'] != null) {$tooltip .= "<br/>Damage Amplified " . $item['active_dmg_target_amp'] . "%";}
				if($item['active_atk_spd'] != null) {$tooltip .= "<br/>Attack Speed +" . $item['active_atk_spd'];}
				if($item['active_move_spd_percent'] != null && $item['active_move_spd_percent_2'] != null)
				{
					$tooltip .= "</br>Melee Move Speed: +" . $item['active_move_spd_percent'] . "%";
					$tooltip .= "</br>Ranged Move Speed: +" . $item['active_move_spd_percent_2'] . "%";
				}
				else
				{
					if($item['active_move_spd_percent'] != null) {$tooltip .= "<br/>Move Speed +" . $item['active_move_spd_percent'] . "%";}
				}
				if($item['active_move_spd_reduct_percent'] != null) {$tooltip .= "<br/>Move Speed -" . $item['active_move_spd_reduct_percent'] . "%";}
				if($item['active_magic_dmg_amp'] != null) {$tooltip .= "<br/>Magic Damage Amplified " . $item['active_magic_dmg_amp'] . "%";}
				if($item['active_magic_resistance_percent'] != null) {$tooltip .= "<br/>Spell Resistance: " . $item['active_magic_resistance_percent'] . "%";}
				if($item['active_dmg_reduct_percent'] != null) {$tooltip .= "<br/>Enemy Damage -" . $item['active_dmg_reduct_percent'] . "%";}
				if($item['active_reduct_duration'] != null) {$tooltip .= "<br/>Reduction Duration: " . $item['active_reduct_duration'];}
				if($item['active_cooldown'] != null && $item['active_cooldown_2'] != null)
				{
					$tooltip .= "</br>Melee: <img src=\'" . $cooldownimg . "\' height=\'14px\'/> " . $item['active_cooldown'] . "&nbsp;&nbsp;&nbsp;";
					if($item['active_mana'] != null) {$tooltip .= "<img src=\'" . $manaimg . "\' height=\'14px\'/> " . $item['active_mana'];}
					$tooltip .= "</br>Ranged: <img src=\'" . $cooldownimg . "\' height=\'14px\'/> " . $item['active_cooldown_2'] . "&nbsp;&nbsp;&nbsp;";
					if($item['active_mana'] != null) {$tooltip .= "<img src=\'" . $manaimg . "\' height=\'14px\'/> " . $item['active_mana'];}
					
				}
				else
				{
					if($item['active_cooldown'] != null || $item['active_mana'] != null) {$tooltip .= "</br>";}
					if($item['active_cooldown_reduct_puse'] != null)
					{
						$tooltip .= "<img src=\'" . $cooldownimg . "\' height=\'14px\'/> " . $item['active_cooldown'];
						$temp = $item['active_cooldown'];
						while($temp > $item['active_cooldown_reduct_min'])
						{
							$temp = ($temp - $item['active_cooldown_reduct_puse']);
							$tooltip .= ">" . $temp;
						}
					}
					else
					{
						if($item['active_cooldown'] != null) {$tooltip .= "<img src=\'" . $cooldownimg . "\' height=\'14px\'/> " . $item['active_cooldown'] . "&nbsp;&nbsp;&nbsp;";}
					}
					if($item['active_mana'] != null) {$tooltip .= "<img src=\'" . $manaimg . "\' height=\'14px\'/> " . $item['active_mana'];}
				}
			}
			if($item['active_name2'] != null)
			{
				$tooltip .= "<br/><hr size=\'1\'/><span class=\'itemabilityname\'>" . $item['active_name2'] . ":</span> (Active)";
				if($item['active_desc2_short'] != null) {$tooltip .= "<br/>" . desctexttooltip($item['active_desc2_short']);}
				if($item['active_range2'] != null) {$tooltip .= "<br/>Range: " . $item['active_range2'];}
				if($item['active_cooldown2'] != null) {$tooltip .= "<br/><img src=\'" . $cooldownimg . "\' height=\'14px\'/> " . $item['active_cooldown2'] . "&nbsp;&nbsp;&nbsp;";}
			}
			if($item['passive_name'] != null)
			{
				$tooltip .= "<br/><hr size=\'1\'/><span class=\'itemabilityname\'>" . desctexttooltip($item['passive_name']) . ":</span>";
				if($item['aura'] == 1) {$tooltip .= " (Aura)";} else {$tooltip .= " (Passive)";}
				if($item['uam'] == 1) {$tooltip .= "<br/><span class=\'itemuam\'>Unique Attack Modifier</span>";}
				if($item['mod_lifesteal'] == 1) {$tooltip .= "<br/><span class=\'itemuam\'>Unique Attack Modifier (Lifesteal)</span>";}
				if($item['mod_stack'] == 1) {$tooltip .= "<br/><span class=\'itemuam\'>Unique Attack Modifier<br/>(Stacks with Lifesteal)</span>";}
				if($item['mod_chain'] == 1) {$tooltip .= "<br/><span class=\'itemuam\'>Unique Attack Modifier<br/>(Stacking Interupt)</span>";}
				if($item['passive_desc_short'] != null) {$tooltip .= "<br/>" . desctexttooltip($item['passive_desc_short']);}
				if($item['lifesteal_ranged'] != null)
				{
					if($item['lifesteal'] != null) {$tooltip .= "<br/>Lifesteal (Melee Ally): " . $item['lifesteal'] . "%";}
					$tooltip .= "<br/>Lifesteal (Ranged Ally): " . $item['lifesteal_ranged'] . "%";
				}
				else
				{
					if($item['lifesteal'] != null) {$tooltip .= "<br/>Lifesteal: " . $item['lifesteal'] . "%";}
				}
				if($item['block_chance'] != null) {$tooltip .= "<br/>" . $item['block_melee_holder'] . " (Melee Holder)<br/>" . $item['block_ranged_holder'] . " (Ranged Holder)</br>Block Chance: " . $item['block_chance'] . "%";}
				if($item['passive_chain_bounce_range'] != null) {$tooltip .= "<br/>Chain Targets: " . $item['passive_chain_targets'] . "<br/>Chain Range: " . $item['passive_chain_bounce_range'];}
				if($item['passive_charges'] != null) {$tooltip .= "<br/>Charges: " . $item['passive_charges'];}
				if($item['passive_duration'] != null) {$tooltip .= "<br/>Duration: " . $item['passive_duration'];}
				if($item['passive_duration_melee_holder'] != null && $item['passive_duration_ranged_holder'] != null) {$tooltip .= "<br/>Duration:<br/>" . $item['passive_duration_melee_holder'] . " (Melee Holder)<br/>" . $item['passive_duration_ranged_holder'] . " (Ranged Holder)";}
				if($item['passive_radius'] != null) {$tooltip .= "<br/>Radius: " . $item['passive_radius'];}
				if($item['passive_hp_regen'] != null) {$tooltip .= "<br/>HP Regen +" . $item['passive_hp_regen'];}
				if($item['passive_hp_regen_percent'] != null) {$tooltip .= "<br/>HP Regen +" . $item['passive_hp_regen_percent'] . "%";}
				if($item['passive_mana_regen'] != null) {$tooltip .= "<br/>Mana Regen +" . $item['passive_mana_regen'];}
				if($item['passive_mana_burn'] != null) {$tooltip .= "<br/>Mana Burn: " . $item['passive_mana_burn'];}
				if($item['passive_magic_resistance_percent'] != null) {$tooltip .= "<br/>Spell Resistance: " . $item['passive_magic_resistance_percent'] . "%";}
				if($item_name == "Assault Cuirass")
				{
					if($item['passive_armor'] != null) {$tooltip .= "<br/>Armor +" . $item['passive_armor'] . " (for Allies)";}
					if($item['passive_armor_reduct'] != null) {$tooltip .= "<br/>Armor -" . $item['passive_armor_reduct'] . " (for Enemies)";}
				}
				else
				{
					if($item['passive_armor'] != null) {$tooltip .= "<br/>Armor +" . $item['passive_armor'];}
					if($item_name == "Desolator")
					{
						if($item['passive_armor_reduct'] != null) {$tooltip .= "<br/>Target Armor -" . $item['passive_armor_reduct'];}
					}
					else
					{	
						if($item['passive_armor_reduct'] != null) {$tooltip .= "<br/>Armor -" . $item['passive_armor_reduct'];}
					}
				}
				if($item['passive_bonus_dmg_chance'] != null) {$tooltip .= "<br/>Bonus Damage Chance: " . $item['passive_bonus_dmg_chance'] . "%";}
				if($item['passive_bonus_dmg'] != null) {$tooltip .= "<br/>Bonus Damage: " . $item['passive_bonus_dmg'];}
				if($item['passive_dmg_psec'] != null) {$tooltip .= "<br/>Bonus Damage: " . $item['passive_dmg_psec'] . "/second";}
				if($item['passive_dmg_percent'] != null) {$tooltip .= "<br/>Bonus Damage: " . $item['passive_dmg_percent'] . "%";}
				if($item['passive_crit_chance'] != null) {$tooltip .= "<br/>Crit Chance: " . $item['passive_crit_chance'] . "%";}
				if($item['passive_crit_dmg_multi'] != null) {$tooltip .= "<br/>Crit Damage: ×" . $item['passive_crit_dmg_multi'];}
				if($item['passive_atk_spd'] != null) {$tooltip .= "<br/>Attack Speed +" . $item['passive_atk_spd'];}
				if($item['passive_atk_spd_reduct'] != null) {$tooltip .= "<br/>Attack Speed -" . $item['passive_atk_spd_reduct'];}
				if($item['passive_atk_spd_reduct_percent'] != null) {$tooltip .= "<br/>Attack Speed -" . $item['passive_atk_spd_reduct_percent'] . "%";}
				if($item['passive_move_spd_percent'] != null) {$tooltip .= "<br/>Move Speed +" . $item['passive_move_spd_percent'] . "%";}
				if($item['passive_move_spd_reduct_percent'] != null) {$tooltip .= "<br/>Move Speed -" . $item['passive_move_spd_reduct_percent'] . "%";}
				if($item['passive_stun_chance_melee_holder'] != null && $item['passive_stun_chance_ranged_holder'] != null)
				{
					if($item['passive_stun_chance_melee_holder'] == $item['passive_stun_chance_ranged_holder'])
					{
						$tooltip .= "<br/>Stun Chance: " . $item['passive_stun_chance_melee_holder'] . "%";
					}
					else
					{
						$tooltip .= "<br/>Stun Chance:<br/>" . $item['passive_stun_chance_melee_holder'] . "% (Melee Holder)<br/>" . $item['passive_stun_chance_ranged_holder'] . "% (Ranged Holder)";
					}
				}
				if($item['passive_stun_time'] != null) {$tooltip .= "<br/>Stun Time: " . $item['passive_stun_time'];}
				if($item['passive_ministun_time'] != null) {$tooltip .= "<br/>Mini-Stun Time: " . $item['passive_ministun_time'];}
				if($item['passive_enemy_miss_chance'] != null) {$tooltip .= "<br/>Enemy Miss Chance: " . $item['passive_enemy_miss_chance'] . "%";}
				if($item['passive_slow_chance'] != null) {$tooltip .= "<br/>Maim Chance: " . $item['passive_slow_chance'] . "%";}
				if($item['passive_cooldown_reduct_percent'] != null) {$tooltip .= "<br/>Cooldown Reduction: " . $item['passive_cooldown_reduct_percent'] . "%";}
				if($item['passive_hp_threshold_percent'] != null) {$tooltip .= "<br/>HP Threshold: " . $item['passive_hp_threshold_percent'] . "%";}
				if($item['passive_hp_regen_below_threshold'] != null) {$tooltip .= "<br/>Threshold HP Regen +" . $item['passive_hp_regen_below_threshold'];}
				if($item['passive_armor_below_threshold'] != null) {$tooltip .= "<br/>Threshold Armor +" . $item['passive_armor_below_threshold'];}
				if($item['passive_cooldown'] != null) {$tooltip .= "<br/><img src=\'" . $cooldownimg . "\' height=\'14px\'/> " . $item['passive_cooldown'];}
			}
			if($item['passive_name2'] != null){$tooltip .= "<br/><hr size=\'1\'/><span class=\'itemabilityname\'>" . $item['passive_name2'] . ":</span> (Passive)";}
			if($item['passive_desc2_short'] != null) {$tooltip .= "<br/>" . desctexttooltip($item['passive_desc2_short']);}
			if($item['passive_name2'] != null)
			{
				if($item['passive_hero_spell_lifesteal2'] != null) {$tooltip .= "<br/>Hero Spell Lifesteal: " . $item['passive_hero_spell_lifesteal2'] . "%";}
				if($item['passive_creep_spell_lifesteal2'] != null) {$tooltip .= "<br/>Creep Spell Lifesteal: " . $item['passive_creep_spell_lifesteal2'] . "%";}
				if($item['passive_bonus_dmg_melee_percent2'] != null && $item['passive_bonus_dmg_ranged_percent2'] != null) {$tooltip .= "<br/>Bonus Damage:</br>" . $item['passive_bonus_dmg_melee_percent2'] . "% (Melee Holder)<br/>" . $item['passive_bonus_dmg_ranged_percent2'] . "% (Ranged Holder)";}
			}
		break;
		
		case "secret":
			$item_data = mysqli_query($db,"SELECT sideshop_also,cost,str,agil,intl,armor,hp,hp_regen,mana,mana_regen,dmg,atk_spd,evasion FROM secret WHERE name = \"" . $item_name . "\"");
			while($item_values = mysqli_fetch_array($item_data))
			{
				$item = array ( "sideshop_also" => $item_values['sideshop_also'],
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
								"evasion" => $item_values['evasion'],
								);
			}
			$sideshop = "&nbsp;&nbsp;<img src=\'" . $SshopRimg . "\'/>";
			if($item['sideshop_also'] == 1)
			{
				$sideshop = "&nbsp;&nbsp;<img src=\'" . $LshopBimg . "\'/>&nbsp;<img src=\'" . $SshopRimg . "\'/>";
			}
			$tooltip = titletext($item_name,"Secret") . "<br/><img src=\'" . $goldimg . "\' height=\'12px\'/><span class=\'itemcost\'>" . $item['cost'] . "</span>&nbsp;<span class=\'itemtext\'>Secret<span class=\'shopicons\'>" . $sideshop . "</span>";
			if($item['str'] != null) {$tooltip .= "<br/>Strength +" . $item['str'];}
			if($item['agil'] != null) {$tooltip .= "<br/>Agility +" . $item['agil'];}
			if($item['intl'] != null) {$tooltip .= "<br/>Intelligence +" . $item['intl'];}
			if($item['armor'] != null) {$tooltip .= "<br/>Armor +" . $item['armor'];}
			if($item['hp'] != null) {$tooltip .= "<br/>HP +" . $item['hp'];}
			if($item['hp_regen'] != null) {$tooltip .= "<br/>HP Regen +" . $item['hp_regen'];}
			if($item['mana'] != null) {$tooltip .= "<br/>Mana +" . $item['mana'];}
			if($item['mana_regen'] != null) {$tooltip .= "<br/>Mana Regen +" . $item['mana_regen'] . "%";}
			if($item['dmg'] != null) {$tooltip .= "<br/>Damage +" . $item['dmg'];}
			if($item['atk_spd'] != null) {$tooltip .= "<br/>Attack Speed +" . $item['atk_spd'];}
			if($item['evasion'] != null) {$tooltip .= "<br/>Evasion: " . $item['evasion'] . "%";}
		break;
		
		case "other":
			$item_data = mysqli_query($db,"SELECT type,short_desc,active_name,active_desc_short,active_charges,active_cooldown,active_hp_restored,active_mana_restored,passive_name,passive_desc_short FROM other WHERE name = \"" . $item_name . "\"");
			while($item_values = mysqli_fetch_array($item_data))
			{
				$item = array ( "type" => $item_values['type'],
								"desc" => $item_values['short_desc'],
								"active_name" => $item_values['active_name'],
								"active_desc_short" => $item_values['active_desc_short'],
								"active_charges" => $item_values['active_charges'],
								"active_cooldown" => $item_values['active_cooldown'],
								"active_hp_restored" => $item_values['active_hp_restored'],
								"active_mana_restored" => $item_values['active_mana_restored'],
								"passive_name" => $item_values['passive_name'],
								"passive_desc_short" => $item_values['passive_desc_short']
								);
			}
			switch($item['type'])
			{
				case "Roshan Drop":
					$tooltip = titletext($item_name,$item['type']) . "<br/><span class=\'itemtext\'>" . $item['type'];
					if($item['desc'] != null) {$tooltip .= "<br/>" . desctexttooltip($item['desc']);}
					if($item['active_name'] != null)
					{
						$tooltip .= "<br/><hr size=\'1\'/><span class=\'itemabilityname\'>" . $item['active_name'] . ":</span>";
						if($item['active_desc_short'] != null) {$tooltip .= "<br/>" . desctexttooltip($item['active_desc_short']);}
						if($item['active_charges'] != null) {$tooltip .= "<br/>Charges: " . $item['active_charges'];}
						if($item['active_hp_restored'] != null) {$tooltip .= "<br/>HP Restored: " . $item['active_hp_restored'];}
						if($item['active_mana_restored'] != null) {$tooltip .= "<br/>Mana Restored: " . $item['active_mana_restored'];}
						if($item['active_cooldown'] != null) {$tooltip .= "<br/><img src=\'" . $cooldownimg . "\' height=\'14px\'/> " . $item['active_cooldown'];}
					}
					if($item['passive_name'] != null)
					{
						$tooltip .= "<br/><hr size=\'1\'/><span class=\'itemabilityname\'>" . $item['passive_name'] . ":</span>";
						if($item['passive_desc_short'] != null) {$tooltip .= "<br/>" . desctexttooltip($item['passive_desc_short']);}
					}
				break;
				case "Recipe":
					$tooltip = "Incorrect tooltip use for 'Recipe', please report!";
				break;
			}
		break;
	}
	return $tooltip;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	titletext() - converts title from DB info into text format for tooltips
//-----------------------------------------------------------------------------//
function titletext($input,$type)
{
	switch($type)
	{
		case "Common":
			$color = "#2BAB08";
		break;
		case "Support":
		case "Caster":
			$color = "#1F87F9";
		break;
		case "Weapons":
		case "Armor":
			$color = "#B819B7";
		break;
		case "Artifacts":
			$color = "#E29B01";
		break;
		default:
			$color = "white";
		break;
	}
	
	return "<span class=\'itemtitle\' style=\'color:" . $color . ";\'>" . strtoupper(str_replace(" (Lvl 1)","",str_replace("'","%39",$input))) . "</span>";
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	titletextdetail() - converts title from DB info into text format for detailed view
//-----------------------------------------------------------------------------//
function titletextdetail($input,$type)
{
	switch($type)
	{
		case "Common":
			$color = "#2BAB08";
		break;
		case "Support":
		case "Caster":
			$color = "#1F87F9";
		break;
		case "Weapons":
		case "Armor":
			$color = "#B819B7";
		break;
		case "Artifacts":
			$color = "#E29B01";
		break;
		default:
			$color = "white";
		break;
	}
	
	return "<span class='itemtitledetail' style='color:" . $color . ";'>" . strtoupper(str_replace(" (Lvl 1)","",$input)) . "</span>";
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	desctext() - converts descriptions from DB info into text format
//-----------------------------------------------------------------------------//
function desctext($input)
{
	return preg_replace('/\s\s+/', '</br>', $input);
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	desctexttooltip() - converts descriptions from DB info into text format for tooltips
//-----------------------------------------------------------------------------//
function desctexttooltip($input)
{
	return str_replace("'","%39",preg_replace('/\s\s+/', '</br>', $input));
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	durationtext() - converts duration from DB info into text format for tooltips
//-----------------------------------------------------------------------------//
function durationtext($input)
{
	if($input > 59)
	{
		$mins = floor($input/60);
		$secs = $input%60;
		$text = "";
		if($secs > 0)
		{
			if($secs < 10)
			{
				$secs = ":0" . $secs;
			}
			else
			{
				$secs = ":" . $secs;
			}
		}
		else
		{
			$secs = "";
		}
		if($mins > 1)
		{
			$text = " minutes";
		}
		else
		{
			$text = " minute";
		}
		return $mins . $secs . $text;
	}
	else
	{
		return $input;
	}
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	displaySuggestedItem() - Displays items for hero suggestions and item recipes
//-----------------------------------------------------------------------------//
function displaySuggestedItem($db,$item_name,$r,$faction,$itemimgwidth,$itemimgheight,$itemrowpadding,$upgradeable_items,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg)
{
	if($itemimgwidth == null)
	{
		$itemimgwidth = 'auto';
	}

	if (strstr($item_name,'Courier') && $faction == "Dire")
	{
		$table = getItemTable($db,$item_name);
		$item = mysqli_fetch_array(mysqli_query($db,"SELECT img_dire FROM consumables WHERE name = \"" . $item_name . "\""));
		$img = $item['img_dire'];
	}
	else
	{
		if (in_array($item_name,$upgradeable_items))
		{
			$item_name = $item_name . " (Lvl 1)";
		}
		$table = getItemTable($db,$item_name);
		$item = mysqli_fetch_array(mysqli_query($db,"SELECT img,type FROM " . $table . " WHERE name = \"" . $item_name . "\""));
		$img = $item['img'];
	}
	
	$type = "";
	if(isset($item['type'])){$type = $item['type'];}
	switch($type)
	{
		case "Common":
			$bordercolor = "#2BAB08";
		break;
		case "Support":
		case "Caster":
			$bordercolor = "#1F87F9";
		break;
		case "Weapons":
		case "Armor":
			$bordercolor = "#B819B7";
		break;
		case "Artifacts":
			$bordercolor = "#E29B01";
		break;
		default:
			$bordercolor = "#BBBBBB";
		break;
	}
	
	echo "<div class='herodetailitem' style='width:" . ($itemimgwidth+$itemrowpadding*2) . "px;'><img style='border-style:solid;border-width:1px;border-color:" . $bordercolor . ";margin:1px;' src=\"" . $img . "\" alt=\"" . $item_name . "\" width=\"" . $itemimgwidth . "\" height=\"" . $itemimgheight . "\"/>";
	$tooltip = buildItemTooltip($db,$item_name,$table,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
	if($itemimgwidth > 84)
	{
		echo "<span class=\"hotspot\" onmouseover=\"tooltip.showitem" . $r . "('" . $tooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"http://dota2itemsdb.x10.mx/?go=items&search=" . $item_name . "\" ><img class=\"herodetailitem-hoverimage\" src=\"" . $hoverimg . "\"/></a></span></div>";
	}
	else
	{
		echo "<span class=\"hotspot\" onmouseover=\"tooltip.showitem" . $r . "('" . $tooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"http://dota2itemsdb.x10.mx/?go=items&search=" . $item_name . "\" ><img class=\"herodetailitemsmall-hoverimage\" src=\"" . $hoverimg . "\"/></a></span></div>";
	}
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	displayRecipeItem() - Displays the Recipe item
//-----------------------------------------------------------------------------//
function displayRecipeItem($db,$item,$itemimgwidth,$itemimgheight,$itemrowpadding,$hoverimg,$goldimg)
{
	if($itemimgwidth == null)
	{
		$itemimgwidth = 'auto';
	}

	$table = getItemTable($db,"Recipe");
	$rec_item = mysqli_fetch_array(mysqli_query($db,"SELECT img,wiki_url,type FROM " . $table . " WHERE name = \"Recipe\""));
	
	$bordercolor = "#BBBBBB";
	
	echo "<div class='herodetailitem' style='width:" . ($itemimgwidth+$itemrowpadding*2) . "px;'><img style='border-style:solid;border-width:1px;border-color:" . $bordercolor . ";margin:1px;' src=\"" . $rec_item['img'] . "\" alt=\"Recipe\" width=\"" . $itemimgwidth . "\" height=\"" . $itemimgheight . "\"/>";
	$tooltip = titletext("Recipe",$rec_item['type']) . "<br/><img src=\'" . $goldimg . "\' height=\'12px\'/><span class=\'itemcost\'>" . getRecipeCost($db,$item) . "</span>";
	echo "<span class=\"hotspot\" onmouseover=\"tooltip.showitemrevd('" . $tooltip . "');\" onmouseout=\"tooltip.hide();\"><a href=\"" . $rec_item['wiki_url'] . "\" alt=\"Recipe\"><img class=\"herodetailitem-hoverimage\" src=\"" . $hoverimg . "\"/></a></span></div>";
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	Tokenise() - Takes a comma seperated string and returns an array of elements
//-----------------------------------------------------------------------------//
function Tokenise($string)
{
	$array = array();
	$element = strtok($string,',');
	while($element)
	{
		array_push($array,$element);
		$element = strtok(',');
	}
	
	return $array;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	getCurrentDataDate() - reads date from text file matching to current data date
//-----------------------------------------------------------------------------//
function getCurrentDataDate()
{
	//$day = file_get_contents('data/currentdataversion.txt', NULL, NULL, 0, 2);
	//$month = file_get_contents('data/currentdataversion.txt', NULL, NULL, 2, 2);
	//$year = file_get_contents('data/currentdataversion.txt', NULL, NULL, 4, 4);
	$ret_string = file_get_contents('data/currentdataversion.txt');
	
	//$ret_string = date('jS \of F Y', mktime(0, 0, 0, $month, $day, $year));
	
	return $ret_string;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	getCurrentBalanceLog() - reads URL from text file
//-----------------------------------------------------------------------------//
function getCurrentBalanceLog()
{
	$ret_string = file_get_contents('data/currentbalancechangelog.txt');
	
	return $ret_string;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	getCurrentLiveDate() - reads date from wiki matching to current live date
//-----------------------------------------------------------------------------//
/*function getCurrentLiveDate()
{
	$lastscrape = file_get_contents('data/lastscrapetimestamp.txt');
	$currenttimestamp = date('d/m/Y H:i:s', time()-14400);
		
	if($lastscrape < $currenttimestamp)
	{
		$source = file_get_contents('http://dota2.gamepedia.com/Dota_2_Wiki');
		$startindex = strpos($source,"Latest patch:
</th>
<td style=\"text-align: left;\"> <a href=\"/");
		$endindex = strpos($source,"_Patch\" title=\"");
		$string = substr($source,$startindex+53,$endindex-($startindex+53));
		
		unset($source);
			
		$array = array();
		$element = strtok($string,'_');
		while($element)
		{
			array_push($array,$element);
			$element = strtok('_');
		}
		$array[1] = str_replace(",", "", $array[1]);
		switch ($array[0])
		{
			case January:
				$array[0] = "01";
			break;
			
			case February:
				$array[0] = "02";
			break;
		
			case March:
				$array[0] = "03";
			break;
			
			case April:
				$array[0] = "04";
			break;
			
			case May:
				$array[0] = "05";
			break;
			
			case June:
				$array[0] = "06";
			break;
			
			case July:
				$array[0] = "07";
			break;
			
			case August:
				$array[0] = "08";
			break;
			
			case September:
				$array[0] = "09";
			break;
			
			case October:
				$array[0] = "10";
			break;
			
			case November:
				$array[0] = "11";
			break;
			
			case December:
				$array[0] = "12";
			break;
		}
		$ret_string = date('jS \of F Y', mktime(0, 0, 0, $array[0], $array[1], $array[2]));
		file_put_contents('data/currentliveversion.txt', $array[1], LOCK_EX);
		file_put_contents('data/currentliveversion.txt', $array[0], FILE_APPEND | LOCK_EX);
		file_put_contents('data/currentliveversion.txt', $array[2], FILE_APPEND | LOCK_EX);
		
		file_put_contents('data/lastscrapetimestamp.txt',date('d/m/Y H:i:s', time()), LOCK_EX);
	}

	$day = file_get_contents('data/currentliveversion.txt', NULL, NULL, 0, 2);
	$month = file_get_contents('data/currentliveversion.txt', NULL, NULL, 2, 2);
	$year = file_get_contents('data/currentliveversion.txt', NULL, NULL, 4, 4);
	$ret_string = date('jS \of F Y', mktime(0, 0, 0, $month, $day, $year));

return $ret_string;
}*/
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	QueryHero() - Returns array of all fields for a single Hero
//-----------------------------------------------------------------------------//
function QueryHero ($db,$hero_name)
{
	//query for hero
	$hero_data = mysqli_query($db,"SELECT * FROM heroes WHERE name =\"" . $hero_name . "\"");
	
	//dump values into array
	while($hero_values = mysqli_fetch_array($hero_data))
	{
		$hero = array(	"name" => $hero_values['name'],
						"wiki_url" => $hero_values['wiki_url'],
						"img" => $hero_values['img'],
						"map_icon" => $hero_values['map_icon'],
						"faction" => $hero_values['faction'],
						"attribute" => $hero_values['attribute'],
						"basic_attack" => $hero_values['basic_attack'],
						"scepter" => $hero_values['scepter'],
						"scepter_cast" => $hero_values['scepter_cast'],
						"unique_atk_mod" => $hero_values['unique_atk_mod'],
						"bash_item_ban" => $hero_values['bash_item_ban'],
						"blink_item_ban" => $hero_values['blink_item_ban'],
						"ability_name" => $hero_values['ability_name'],
						"ability_url" => $hero_values['ability_url'],
						"ability_img" => $hero_values['ability_img'],
						"ability_type" => $hero_values['ability_type'],
						"starter_items" => $hero_values['starter_items'],
						"early_game_items" => $hero_values['early_game_items'],
						"core_items" => $hero_values['core_items'],
						"situational_items" => $hero_values['situational_items'],
						"role1" => $hero_values['role1'],
						"role2" => $hero_values['role2'],
						"role3" => $hero_values['role3'],
						"role4" => $hero_values['role4'],
						"position" => $hero_values['position']
						);
	}
	
	return $hero;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	QueryItem() - Returns array of all fields for a single Item
//-----------------------------------------------------------------------------//
function QueryItem ($db,$item_name)
{
	//query for item
	$table = getItemTable($db,$item_name);
	$item_data = mysqli_query($db,"SELECT * FROM " . $table . " LEFT JOIN recipes ON " . $table . ".name=recipes.top_item WHERE name = \"" . $item_name . "\"");
	
	//dump values into matching array
	switch ($table)
	{
		case "consumables":
			while($item_values = mysqli_fetch_array($item_data))
			{
				$item = array(	"name" => $item_values['name'],
								"cost" => $item_values['cost'],
								"type" => $item_values['type'],
								"description" => $item_values['description'],
								"short_desc" => $item_values['short_desc'],
								"wiki_url" => $item_values['wiki_url'],
								"img" => $item_values['img'],
								"sideshop" => $item_values['sideshop'],
								"active_name" => $item_values['active_name'],
								"active_ability" => $item_values['active_ability'],
								"active_affects" => $item_values['active_affects'],
								"charges" => $item_values['charges'],
								"hp_regen" => $item_values['hp_regen'],
								"dmg" => $item_values['dmg'],
								"mana_cost" => $item_values['mana_cost'],
								"cooldown" => $item_values['cooldown'],
								"duration" => $item_values['duration'],
								"hp_restored" => $item_values['hp_restored'],
								"hp_restored_ward" => $item_values['hp_restored_ward'],
								"mana_restored" => $item_values['mana_restored'],
								"radius" => $item_values['radius'],
								"move_spd" => $item_values['move_spd'],
								"recipe" => $item_values['recipe'],
								"position" => $item_values['position'],
								"prereqs" => $item_values['prereqs'],
								"has_recipe" => $item_values['has_recipe']
								);
			}
		break;
			
		case "basics":
			while($item_values = mysqli_fetch_array($item_data))
			{
				$item = array(	"name" => $item_values['name'],
								"cost" => $item_values['cost'],
								"type" => $item_values['type'],
								"wiki_url" => $item_values['wiki_url'],
								"img" => $item_values['img'],
								"sideshop" => $item_values['sideshop'],
								"str" => $item_values['str'],
								"agil" => $item_values['agil'],
								"intl" => $item_values['intl'],
								"armor" => $item_values['armor'],
								"block_chance" => $item_values['block_chance'],
								"block_melee_holder" => $item_values['block_melee_holder'],
								"block_ranged_holder" => $item_values['block_ranged_holder'],
								"dmg" => $item_values['dmg'],
								"hp_regen" => $item_values['hp_regen'],
								"mana_regen" => $item_values['mana_regen'],
								"atk_spd" => $item_values['atk_spd'],
								"move_spd" => $item_values['move_spd'],
								"magic_resist" => $item_values['magic_resist'],
								"lifesteal" => $item_values['lifesteal'],
								"active_name" => $item_values['active_name'],
								"active_ability" => $item_values['active_ability'],
								"active_affects" => $item_values['active_affects'],
								"active_desc" => $item_values['active_desc'],
								"active_desc_short" => $item_values['active_desc_short'],
								"active_range" => $item_values['active_range'],
								"active_range_ward" => $item_values['active_range_ward'],
								"active_cooldown" => $item_values['active_cooldown'],
								"active_mana" => $item_values['active_mana'],
								"active_duration" => $item_values['active_duration'],
								"active_hp_total" => $item_values['active_hp_total'],
								"active_mana_total" => $item_values['active_mana_total'],
								"passive_name" => $item_values['passive_name'],
								"passive_affects" => $item_values['passive_affects'],
								"passive_desc" => $item_values['passive_desc'],
								"passive_desc_short" => $item_values['passive_desc_short'],
								"passive_radius" => $item_values['passive_radius'],
								"passive_bonus_dmg_chance" => $item_values['passive_bonus_dmg_chance'],
								"passive_bonus_dmg" => $item_values['passive_bonus_dmg'],
								"passive_bonus_dmg_melee_percent" => $item_values['passive_bonus_dmg_melee_percent'],
								"passive_bonus_dmg_ranged_percent" => $item_values['passive_bonus_dmg_ranged_percent'],
								"passive_dmg_psec" => $item_values['passive_dmg_psec'],
								"passive_move_spd_reduct_percent_melee_wielder" => $item_values['passive_move_spd_reduct_percent_melee_wielder'],
								"passive_move_spd_reduct_percent_ranged_wielder" => $item_values['passive_move_spd_reduct_percent_ranged_wielder'],
								"passive_duration" => $item_values['passive_duration'],
								"unique_atk_mod_lifesteal" => $item_values['unique_atk_mod_lifesteal'],
								"unique_atk_mod_pluslifesteal" => $item_values['unique_atk_mod_pluslifesteal'],
								"boots" => $item_values['boots'],
								"position" => $item_values['position']
								);
			}
			break;
			
		case "upgrades":
			while($item_values = mysqli_fetch_array($item_data))
			{
				$item = array(	"name" => $item_values['name'],
								"cost" => $item_values['cost'],
								"type" => $item_values['type'],
								"wiki_url" => $item_values['wiki_url'],
								"img" => $item_values['img'],
								"sideshop_entirely" => $item_values['sideshop_entirely'],
								"sideshop_partly" => $item_values['sideshop_partly'],
								"secretshop_only" => $item_values['secretshop_only'],
								"secretshop_partly" => $item_values['secretshop_partly'],
								"upgradeable" => $item_values['upgradeable'],
								"upgrade_level" => $item_values['upgrade_level'],
								"upgrade_max" => $item_values['upgrade_max'],
								"str" => $item_values['str'],
								"agil" => $item_values['agil'],
								"intl" => $item_values['intl'],
								"armor" => $item_values['armor'],
								"block_chance" => $item_values['block_chance'],
								"block_melee_holder" => $item_values['block_melee_holder'],
								"block_ranged_holder" => $item_values['block_ranged_holder'],
								"dmg" => $item_values['dmg'],
								"hp" => $item_values['hp'],
								"hp_regen" => $item_values['hp_regen'],
								"mana" => $item_values['mana'],
								"mana_regen" => $item_values['mana_regen'],
								"atk_spd" => $item_values['atk_spd'],
								"move_spd" => $item_values['move_spd'],
								"move_spd_percent" => $item_values['move_spd_percent'],
								"magic_resist" => $item_values['magic_resist'],
								"lifesteal" => $item_values['lifesteal'],
								"lifesteal_ranged" => $item_values['lifesteal_ranged'],
								"evasion" => $item_values['evasion'],
								"active_name" => $item_values['active_name'],
								"active_ability" => $item_values['active_ability'],
								"active_affects" => $item_values['active_affects'],
								"active_desc" => $item_values['active_desc'],
								"active_desc_short" => $item_values['active_desc_short'],
								"active_range" => $item_values['active_range'],
								"active_range_ward" => $item_values['active_range_ward'],
								"active_radius" => $item_values['active_radius'],
								"active_cooldown" => $item_values['active_cooldown'],
								"active_cooldown_2" => $item_values['active_cooldown_2'],
								"active_cooldown_reduct_puse" => $item_values['active_cooldown_reduct_puse'],
								"active_cooldown_reduct_min" => $item_values['active_cooldown_reduct_min'],
								"active_mana" => $item_values['active_mana'],
								"active_duration" => $item_values['active_duration'],
								"active_duration_selfally" => $item_values['active_duration_selfally'],
								"active_duration_melee_target" => $item_values['active_duration_melee_target'],
								"active_duration_reduct_puse" => $item_values['active_duration_reduct_puse'],
								"active_duration_reduct_min" => $item_values['active_duration_reduct_min'],
								"active_str" => $item_values['active_str'],
								"active_armor" => $item_values['active_armor'],
								"active_charges" => $item_values['active_charges'],
								"active_hp_total" => $item_values['active_hp_total'],
								"active_hp_drain" => $item_values['active_hp_drain'],
								"active_hp_cost" => $item_values['active_hp_cost'],
								"active_mana_total" => $item_values['active_mana_total'],
								"active_dmg_total" => $item_values['active_dmg_total'],
								"active_dmg_chance" => $item_values['active_dmg_chance'],
								"active_atk_spd" => $item_values['active_atk_spd'],
								"active_move_spd_percent" => $item_values['active_move_spd_percent'],
								"active_move_spd_percent_2" => $item_values['active_move_spd_percent_2'],
								"active_move_spd_reduct_percent" => $item_values['active_move_spd_reduct_percent'],
								"active_armor_reduct" => $item_values['active_armor_reduct'],
								"active_magic_dmg_amp" => $item_values['active_magic_dmg_amp'],
								"active_magic_resistance_percent" => $item_values['active_magic_resistance_percent'],
								"active_dmg_received_amp" => $item_values['active_dmg_received_amp'],
								"active_dmg_target_amp" => $item_values['active_dmg_target_amp'],
								"active_dmg_reduct_percent" => $item_values['active_dmg_reduct_percent'],
								"active_reduct_duration" => $item_values['active_reduct_duration'],
								"active_name2" => $item_values['active_name2'],
								"active_desc2" => $item_values['active_desc2'],
								"active_desc2_short" => $item_values['active_desc2_short'],
								"active_range2" => $item_values['active_range2'],
								"active_cooldown2" => $item_values['active_cooldown2'],
								"passive_name" => $item_values['passive_name'],
								"passive_ability" => $item_values['passive_ability'],
								"passive_affects" => $item_values['passive_affects'],
								"passive_desc" => $item_values['passive_desc'],
								"passive_desc_short" => $item_values['passive_desc_short'],
								"passive_radius" => $item_values['passive_radius'],
								"passive_duration" => $item_values['passive_duration'],
								"passive_duration_melee_holder" => $item_values['passive_duration_melee_holder'],
								"passive_duration_ranged_holder" => $item_values['passive_duration_ranged_holder'],
								"passive_mana_burn" => $item_values['passive_mana_burn'],
								"passive_cooldown" => $item_values['passive_cooldown'],
								"passive_bonus_dmg_chance" => $item_values['passive_bonus_dmg_chance'],
								"passive_bonus_dmg" => $item_values['passive_bonus_dmg'],
								"passive_dmg_psec" => $item_values['passive_dmg_psec'],
								"passive_dmg_percent" => $item_values['passive_dmg_percent'],
								"passive_crit_chance" => $item_values['passive_crit_chance'],
								"passive_crit_dmg_multi" => $item_values['passive_crit_dmg_multi'],
								"passive_stun_chance_melee_holder" => $item_values['passive_stun_chance_melee_holder'],
								"passive_stun_chance_ranged_holder" => $item_values['passive_stun_chance_ranged_holder'],
								"passive_stun_time" => $item_values['passive_stun_time'],
								"passive_ministun_time" => $item_values['passive_ministun_time'],
								"passive_slow_chance" => $item_values['passive_slow_chance'],
								"passive_armor" => $item_values['passive_armor'],
								"passive_armor_reduct" => $item_values['passive_armor_reduct'],
								"passive_charges" => $item_values['passive_charges'],
								"passive_hp_regen" => $item_values['passive_hp_regen'],
								"passive_hp_regen_percent" => $item_values['passive_hp_regen_percent'],
								"passive_mana_regen" => $item_values['passive_mana_regen'],
								"passive_atk_spd" => $item_values['passive_atk_spd'],
								"passive_atk_spd_reduct" => $item_values['passive_atk_spd_reduct'],
								"passive_atk_spd_reduct_percent" => $item_values['passive_atk_spd_reduct_percent'],
								"passive_move_spd_percent" => $item_values['passive_move_spd_percent'],
								"passive_move_spd_reduct_percent" => $item_values['passive_move_spd_reduct_percent'],
								"passive_magic_resistance_percent" => $item_values['passive_magic_resistance_percent'],
								"passive_enemy_miss_chance" => $item_values['passive_enemy_miss_chance'],
								"passive_chain_targets" => $item_values['passive_chain_targets'],
								"passive_chain_bounce_range" => $item_values['passive_chain_bounce_range'],
								"passive_cooldown_reduct_percent" => $item_values['passive_cooldown_reduct_percent'],
								"passive_hp_threshold_percent" => $item_values['passive_hp_threshold_percent'],
								"passive_hp_regen_below_threshold" => $item_values['passive_hp_regen_below_threshold'],
								"passive_armor_below_threshold" => $item_values['passive_armor_below_threshold'],
								"passive_name2" => $item_values['passive_name2'],
								"passive_ability2" => $item_values['passive_ability2'],
								"passive_affects2" => $item_values['passive_affects2'],
								"passive_desc2" => $item_values['passive_desc2'],
								"passive_desc2_short" => $item_values['passive_desc2_short'],
								"passive_bonus_dmg_melee_percent2" => $item_values['passive_bonus_dmg_melee_percent2'],
								"passive_bonus_dmg_ranged_percent2" => $item_values['passive_bonus_dmg_ranged_percent2'],
								"passive_hero_spell_lifesteal2" => $item_values['passive_hero_spell_lifesteal2'],
								"passive_creep_spell_lifesteal2" => $item_values['passive_creep_spell_lifesteal2'],
								"unique_atk_mod" => $item_values['unique_atk_mod'],
								"unique_atk_mod_lifesteal" => $item_values['unique_atk_mod_lifesteal'],
								"unique_atk_mod_pluslifesteal" => $item_values['unique_atk_mod_pluslifesteal'],
								"unique_atk_mod_interupt" => $item_values['unique_atk_mod_interupt'],
								"boots" => $item_values['boots'],
								"aura" => $item_values['aura'],
								"no_self_aura_stack" => $item_values['no_self_aura_stack'],
								"no_bash_stack" => $item_values['no_bash_stack'],
								"no_yasha_stack" => $item_values['no_yasha_stack'],
								"no_armor_manaregen_stack" => $item_values['no_armor_manaregen_stack'],
								"position" => $item_values['position'],
								"prereqs" => $item_values['prereqs'],
								"has_recipe" => $item_values['has_recipe']
								);
			}
		break;
		
		case "secret":
			while($item_values = mysqli_fetch_array($item_data))
			{
				$item = array(	"name" => $item_values['name'],
								"cost" => $item_values['cost'],
								"wiki_url" => $item_values['wiki_url'],
								"img" => $item_values['img'],
								"type" => $item_values['type'],
								"sideshop_also" => $item_values['sideshop_also'],
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
								"evasion" => $item_values['evasion'],
								"position" => $item_values['position']
								);
			}
		break;
		
		case "other":
			while($item_values = mysqli_fetch_array($item_data))
			{
				$item = array(	"name" => $item_values['name'],
								"wiki_url" => $item_values['wiki_url'],
								"img" => $item_values['img'],
								"type" => $item_values['type'],
								"description" => $item_values['description'],
								"active_name" => $item_values['active_name'],
								"active_ability" => $item_values['active_ability'],
								"active_affects" => $item_values['active_affects'],
								"active_desc" => $item_values['active_desc'],
								"active_desc_short" => $item_values['active_desc_short'],
								"active_charges" => $item_values['active_charges'],
								"active_cooldown" => $item_values['active_cooldown'],
								"active_hp_restored" => $item_values['active_hp_restored'],
								"active_mana_restored" => $item_values['active_mana_restored'],
								"passive_name" => $item_values['passive_name'],
								"passive_ability" => $item_values['passive_ability'],
								"passive_desc" => $item_values['passive_desc'],
								"passive_desc_short" => $item_values['passive_desc'],
								"position" => $item_values['position']
								);
			}
		break;
	}
	
	return $item;
}
//-----------------------------------------------------------------------------//
?>