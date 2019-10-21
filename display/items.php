<script language="JavaScript" type="text/javascript">
	var searched = "";
	if(document.URL.indexOf("search=") > -1)
	{
		searched = " - " + document.URL.substring(document.URL.indexOf("search=")+7,document.URL.length);
		while(searched.indexOf("%20") > -1)
		{
					searched = searched.replace("%20"," ");
		}
		while(searched.indexOf("%27") > -1)
		{
					searched = searched.replace("%27","'");
		}
	}
	document.title = document.title + " - Items" + searched;
</script>

<?php
//see if an item is to be displayed
$searchspec = (!empty($_GET['search']) ? $_GET['search'] : null);
if($searchspec)
{
	$item = QueryItem($db,$searchspec);
	
	if($item)
	{
		include "scripts/displayItem.php";
		displayItem($db,$item,$upgradeable_items,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg,$LshopWimglrg,$LshopBimglrg,$SshopWimglrg,$SshopRimglrg);
		echo "<div id='resultbutton'><input type='button' value='Clear Result' onmouseup='clearResult()'/><hr/></div>";
	}
	else
	{
		//report on bad search term
		echo "<br/>'" . $searchspec . "' not found<br/>";
	}
}

//PHP to JS information
$abilities = "";
foreach ($item_abilities as $ability)
{
	$abilities = $abilities . $ability . ",";
}

include "scripts/itemsimgs.js";
include "scripts/showItemFunctions.js";
include "scripts/showItemThumbs.php";
include "scripts/preloadTooltipImgs.php";
?>
<form id="itemfilter">
	<font size="1">
	<div id="center" class="table">
		<div class="table-row">
			<div class="table-cell">
				<font size="2">
				Ability/Bonus:
				<input type="radio" name="rolestype" id="exclusive" onchange="filterItems()" checked/><span class="helphotspot" onmouseover="tooltip.show('Items must match ALL selected abilities/bonuses');" onmouseout="tooltip.hide();">Exclusive</span>
				<input type="radio" name="rolestype" id="additive" onchange="filterItems()"/><span class="helphotspot" onmouseover="tooltip.show('Item matches at least one selected ability/bonus');" onmouseout="tooltip.hide();">Additive</span>
				</font>
			</div>
			<div class="table-cell">
				<font size="2">
				Unique Attack Mods:
				</font>
			</div>
			<div class="table-cell">
				Name Search: <input type="text" id="namesearch" onkeyup="filterItems()" size="25" maxlength="25"/>
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell">
				<?php
					$i=0;
					foreach ($item_abilities as $ability)
					{	
						$i++;
						echo "<input type=\"checkbox\" id=\"" . $ability . "\" onchange=\"filterItems()\">" . $ability . " ";
						if($i == 3)
						{
							break;
						}
					}
				?>
			</div>
			<div class="table-cell">
				<font size="2">
				<input type="radio" name="all" id="allclear" onchange="clearUAMFilter()" checked/>No Filter
				<input type="radio" name="all" id="allshow" onchange="highlightAllUAM()"/>Highlight All
				<input type="radio" name="all" id="allhide" onchange="hideAllUAM()"/>Hide All
				</font>
			</div>
			<div class="table-cell">
				Requires <a href="http://www.dota2wiki.com/wiki/Recipes">Recipe</a>: 
				<input type="radio" name="recipe" id="recipeclear" onchange="filterItems()" checked/>No Filter
				<input type="radio" name="recipe" id="recipeshow" onchange="filterItems()"/>Highlight
				<input type="radio" name="recipe" id="recipehide" onchange="filterItems()"/>Hide
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell">
				<?php
					$i=0;
					foreach ($item_abilities as $ability)
					{	
						$i++;
						if($i > 3)
						{
							echo "<input type=\"checkbox\" id=\"" . $ability . "\" onchange=\"filterItems()\">" . $ability . " ";
						}
						if($i == 6)
						{
							break;
						}
					}
				?>
			</div>
			<div class="table-cell">
				<span class="helphotspot" onmouseover="tooltip.show('Does not include non Unique Attack Modifier Lifesteal items');" onmouseout="tooltip.hide();">Lifesteal:</span>
				<input type="radio" name="life" id="lifeclear" onchange="filterItems()" checked/>No Filter
				<input type="radio" name="life" id="lifeshow" onchange="filterItems()"/>Highlight
				<input type="radio" name="life" id="lifehide" onchange="filterItems()"/>Hide
			</div>
			<div class="table-cell">
				Has Aura: 
				<input type="radio" name="aura" id="auraclear" onchange="filterItems()" checked/>No Filter
				<input type="radio" name="aura" id="aurashow" onchange="filterItems()"/>Highlight
				<input type="radio" name="aura" id="aurahide" onchange="filterItems()"/>Hide
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell">
				<?php
					$i=0;
					foreach ($item_abilities as $ability)
					{	
						$i++;
						if($i > 6)
						{
							echo "<input type=\"checkbox\" id=\"" . $ability . "\" onchange=\"filterItems()\"/>" . $ability . " ";
						}
						if($i == 9)
						{
							break;
						}
					}
				?>
			</div>
			<div class="table-cell">
				<span class="helphotspot" onmouseover="tooltip.show('Allows Lifesteal to stack');" onmouseout="tooltip.hide();">Stackable:</span>
				<input type="radio" name="stack" id="stackclear" onchange="filterItems()" checked/>No Filter
				<input type="radio" name="stack" id="stackshow" onchange="filterItems()"/>Highlight
				<input type="radio" name="stack" id="stackhide" onchange="filterItems()"/>Hide
			</div>
			<div class="table-cell">
				Can be Disassembled: 
				<input type="radio" name="disassemble" id="disassembleclear" onchange="filterItems()" checked/>No Filter
				<input type="radio" name="disassemble" id="disassembleshow" onchange="filterItems()"/>Highlight
				<input type="radio" name="disassemble" id="disassemblehide" onchange="filterItems()"/>Hide
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell">
				<?php
					$i=0;
					foreach ($item_abilities as $ability)
					{	
						$i++;
						if($i > 9)
						{
							echo "<input type=\"checkbox\" id=\"" . $ability . "\" onchange=\"filterItems()\">" . $ability . " ";
						}
						if($i == 13)
						{
							break;
						}
					}
				?>
			</div>
			<div class="table-cell">
				<span class="helphotspot" onmouseover="tooltip.show('Allows another Unique Attack Mod on hits that do not activate Chain Lightning');" onmouseout="tooltip.hide();">Interupting:</span>
				<input type="radio" name="chain" id="chainclear" onchange="filterItems()" checked/>No Filter
				<input type="radio" name="chain" id="chainshow" onchange="filterItems()"/>Highlight
				<input type="radio" name="chain" id="chainhide" onchange="filterItems()"/>Hide
			</div>
			<div class="table-cell">
				<input type="button" id="clearsearchfilter" value="Clear Search Filters" onmouseup="clearSearchFilter()"/>
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell">
				<?php
					$i=0;
					foreach ($item_abilities as $ability)
					{	
						$i++;
						
						//manual display override
						$ability_display = $ability;
						if($ability_display == "Magic Resist")
						{
							$ability_display = "Spell Resistance";
						}
						
						if($i > 13)
						{
							echo "<input type=\"checkbox\" id=\"" . $ability . "\" onchange=\"filterItems()\">" . $ability_display . " ";
						}
					}
				?>
			</div>
			<div class="table-cell">
				Other:
				<input type="radio" name="uam" id="uamclear" onchange="filterItems()" checked/>No Filter
				<input type="radio" name="uam" id="uamshow" onchange="filterItems()"/>Highlight
				<input type="radio" name="uam" id="uamhide" onchange="filterItems()"/>Hide
			</div>
			<div class="table-cell">
				Gold Available: <input type="text" id="goldsearch" style="text-align: right" onkeyup="filterItems()" value="0" size="5" maxlength="5"/><input type="button" id="cleargoldfilter" value="Clear Gold" onmouseup="clearGoldFilter()"/>
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell">
				<input type="button" id="clearabilitiesfilter" value="Clear Abilities Filter" onmouseup="clearAbilitiesFilter()"/>
			</div>
			<div class="table-cell">
				<input type="button" id="clearuamfilter" value="Clear UAM Filter" onmouseup="clearUAMFilter()"/>
			</div>
			<div class="table-cell">
				<span class="helphotspot" onmouseover="tooltip.showrev('Side Lane Shop: some parts available<br/>No Filter | Highlight | Hide');" onmouseout="tooltip.hide();"><img src="<?php echo $LshopWimg?>"/></span><input type="radio" name="LSpart" id="LSpartclear" onchange="filterItems()" checked/><input type="radio" name="LSpart" id="LSpartshow" onchange="filterItems()"/><input type="radio" name="LSpart" id="LSparthide" onchange="filterItems()"/>
				<span class="helphotspot" onmouseover="tooltip.showrev('Side Lane Shop: all parts available<br/>No Filter | Highlight | Hide');" onmouseout="tooltip.hide();"><img src="<?php echo $LshopBimg?>"/></span><input type="radio" name="LSall" id="LSallclear" onchange="filterItems()" checked/><input type="radio" name="LSall" id="LSallshow" onchange="filterItems()"/><input type="radio" name="LSall" id="LSallhide" onchange="filterItems()"/>
				<span class="helphotspot" onmouseover="tooltip.showrev('Secret Shop: some parts available<br/>No Filter | Highlight | Hide');" onmouseout="tooltip.hide();"><img src="<?php echo $SshopWimg?>"/></span><input type="radio" name="SSpart" id="SSpartclear" onchange="filterItems()" checked/><input type="radio" name="SSpart" id="SSpartshow" onchange="filterItems()"/><input type="radio" name="SSpart" id="SSparthide" onchange="filterItems()"/>
				<span class="helphotspot" onmouseover="tooltip.showrev('Secret Shop: all parts available<br/>No Filter | Highlight | Hide');" onmouseout="tooltip.hide();"><img src="<?php echo $SshopRimg?>"/></span><input type="radio" name="SSall" id="SSallclear" onchange="filterItems()" checked/><input type="radio" name="SSall" id="SSallshow" onchange="filterItems()"/><input type="radio" name="SSall" id="SSallhide" onchange="filterItems()"/>
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell">
			</div>
			<div class="table-cell">
			</div>
			<div class="table-cell">
				<input type="button" id="clearshopfilter" value="Clear Shop Filters" onmouseup="clearShopFilter()"/>
			</div>
		</div>
	</div>
	</font>
</form>
<br/>
<a href="?go=itemgroup&search=all"><img src="images/button_allitems.png" onMouseOver="this.src = allitems_up" onMouseOut="this.src = allitems_down" onMouseDown="this.src = allitems_click" onMouseUp="this.src = allitems_up"/></a>
&nbsp;
<img src="images/button_selectitems.png" class="pointer" onclick="selectedSearch()" onMouseOver="this.src = selectitems_up" onMouseOut="this.src = selectitems_down" onMouseDown="this.src = selectitems_click" onMouseUp="this.src = selectitems_up"/>
<br/>
<br/>
<div id="center" class="table">
	<div class="table-row">
		<div id="item-header" class="table-cell" onclick="location.href='?go=itemgroup&search=Basics';" style="cursor: pointer;">
			B&nbsp;A&nbsp;S&nbsp;I&nbsp;C&nbsp;S
		</div>
		<div id="item-header" class="table-cell" onclick="location.href='?go=itemgroup&search=Upgrades';" style="cursor: pointer;">
			U&nbsp;P&nbsp;G&nbsp;R&nbsp;A&nbsp;D&nbsp;E&nbsp;S
		</div>
		<div id="item-header" class="table-cell" onclick="location.href='?go=itemgroup&search=Secret';" style="cursor: pointer;">
			S&nbsp;E&nbsp;C&nbsp;R&nbsp;E&nbsp;T
		</div>
	</div>
	<div class="table-row">
		<div class="table-cell border-right">
			<span class="hotspot" onmouseover="tooltip.show('Consumables');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-white">
					<a href="?go=itemgroup&search=Consumables"><img src="images/Consumables_item_icon.png"/></a>
				</div>
			</span>
			<span class="hotspot" onmouseover="tooltip.show('Attributes');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-white">
					<a href="?go=itemgroup&search=Attributes"><img src="images/Attributes_item_icon.png"/></a>
				</div>
			</span>
			<span class="hotspot" onmouseover="tooltip.show('Armaments');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-white">
					<a href="?go=itemgroup&search=Armaments"><img src="images/Armaments_item_icon.png"/></a>
				</div>
			</span>
			<span class="hotspot" onmouseover="tooltip.show('Arcane');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-white">
					<a href="?go=itemgroup&search=Arcane"><img src="images/Arcane_item_icon.png"/></a>
				</div>
			</span>
		</div>
		<div class="table-cell border-both">
			<span class="hotspot" onmouseover="tooltip.show('Common');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-green">
					<a href="?go=itemgroup&search=Common"><img src="images/Common_item_icon.png"/></a>
				</div>
			</span>
			<span class="hotspot" onmouseover="tooltip.show('Support');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-blue">
					<a href="?go=itemgroup&search=Support"><img src="images/Support_item_icon.png"/></a>
				</div>
			</span>
			<span class="hotspot" onmouseover="tooltip.show('Caster');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-blue">
					<a href="?go=itemgroup&search=Caster"><img src="images/Caster_item_icon.png"/></a>
				</div>
			</span>
			<span class="hotspot" onmouseover="tooltip.show('Weapons');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-purple">
					<a href="?go=itemgroup&search=Weapons"><img src="images/Weapons_item_icon.png"/></a>
				</div>
			</span>
			<span class="hotspot" onmouseover="tooltip.show('Armor');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-purple">
					<a href="?go=itemgroup&search=Armor"><img src="images/Armor_item_icon.png"/></a>
				</div>
			</span>
			<span class="hotspot" onmouseover="tooltip.show('Artifacts');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-orange">
					<a href="?go=itemgroup&search=Artifacts"><img src="images/Artifacts_item_icon.png"/></a>
				</div>
			</span>
		</div>
		<div class="table-cell border-left">
			<span class="hotspot" onmouseover="tooltip.showrev('Secret');" onmouseout="tooltip.hide();">
				<div id="itemmargin-head" class="itemmargin-head-grey">
					<a href="?go=itemgroup&search=Secret"><img src="images/itemcat_secret.png"/></a>
				</div>
			</span>
		</div>
	</div>
	<div class="table-row">
		<div class="table-cell border-right">
			<div id="itemmargin-thumb">
				<div id="consumables" class="floatleft">
					<?php echo displayItemGroupConsumables($db,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopBimg); ?>
				</div>
			</div>
			<div id="itemmargin-thumb">
				<div id="attributes" class="floatleft">
					<?php echo displayItemGroupBasics($db,"Attributes",$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopBimg); ?>
				</div>
			</div>
			<div id="itemmargin-thumb">
				<div id="armaments" class="floatleft">
					<?php echo displayItemGroupBasics($db,"Armaments",$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopBimg); ?>
				</div>
			</div>
			<div id="itemmargin-thumb">
				<div id="arcane" class="floatleft">
					<?php echo displayItemGroupBasics($db,"Arcane",$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopBimg); ?>
				</div>
			</div>
		</div>
		<div class="table-cell border-both">
			<div id="itemmargin-thumb">
				<div id="common" class="floatleft">
					<?php echo displayItemGroupUpgrades($db,"Common",$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg); ?>
				</div>
			</div>
			<div id="itemmargin-thumb">
				<div id="support" class="floatleft">
					<?php echo displayItemGroupUpgrades($db,"Support",$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg); ?>
				</div>
			</div>
			<div id="itemmargin-thumb">
				<div id="caster" class="floatleft">
					<?php echo displayItemGroupUpgrades($db,"Caster",$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg); ?>
				</div>
			</div>
			<div id="itemmargin-thumb">
				<div id="weapons" class="floatleft">
					<?php echo displayItemGroupUpgrades($db,"Weapons",$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg); ?>
				</div>
			</div>
			<div id="itemmargin-thumb">
				<div id="armor" class="floatleft">
					<?php echo displayItemGroupUpgrades($db,"Armor",$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg); ?>
				</div>
			</div>
			<div id="itemmargin-thumb">
				<div id="artifacts" class="floatleft">
					<?php echo displayItemGroupUpgrades($db,"Artifacts",$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg); ?>
				</div>
			</div>
		</div>
		<div class="table-cell border-left">
			<div id="itemmargin-thumb">
				<div id="secret" class="floatleft">
					<?php echo displayItemGroupSecret($db,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopBimg,$SshopRimg); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<br/>
<div id="center" class="table">
	<div class="table-row">
		<div id="item-header" class="table-cell" onclick="location.href='?go=itemgroup&search=Roshan';" style="cursor: pointer;">
			R&nbsp;O&nbsp;S&nbsp;H&nbsp;A&nbsp;N&nbsp;&nbsp;&nbsp;D&nbsp;R&nbsp;O&nbsp;P&nbsp;S
		</div>
	</div>
	<div class="table-row">
		<div class="table-cell">
			<div id="itemmargin-thumb-roshan">
				<div id="roshan" class="floatleft">
					<?php echo displayItemGroupRoshan($db,$hoverimg,$goldimg,$cooldownimg,$manaimg); ?>
				</div>
			</div>
		</div>
	</div>
</div>