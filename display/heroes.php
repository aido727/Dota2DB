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
	document.title = document.title + " - Heroes" + searched;
</script>

<?php
//see if a hero is to be displayed
$searchspec = (!empty($_GET['search']) ? $_GET['search'] : null);
if($searchspec)
{
	$hero = QueryHero($db,$searchspec);
	
	if($hero)
	{
		include "scripts/itemsimgs.js";
		include "scripts/displayHero.php";
		displayHero($db,$hero,$upgradeable_items,$stricon,$agilicon,$intlicon,$hoverimg,$goldimg,$cooldownimg,$manaimg,$LshopWimg,$LshopBimg,$SshopWimg,$SshopRimg);
		echo "<div id='resultbutton'><input type='button' value='Clear Result' onmouseup='clearResult()'/><hr/></div>";
	}
	else
	{
		//report on bad search term
		echo "<br/>'" . $searchspec . "' not found<br/>";
	}
}

//PHP to JS information
$roles = "";
foreach ($hero_roles as $role)
{
	$roles = $roles . $role . ",";
}

include "scripts/heroesimgs.js";
include "scripts/showHeroFunctions.js";
include "scripts/showHeroThumbs.php";
include "scripts/preloadTooltipImgs.php";
?>

<form id="herofilter">
	<div id="center" class="table">
		<div class="table-row">
			<div class="table-cell">
				Roles:
				<input type="radio" name="rolestype" id="exclusive" onchange="filterHero()" checked/><span class="helphotspot" onmouseover="tooltip.show('Heroes must match ALL selected roles');" onmouseout="tooltip.hide();">Exclusive</span>
				<input type="radio" name="rolestype" id="additive" onchange="filterHero()"/><span class="helphotspot" onmouseover="tooltip.show('Hero matches at least one selected role');" onmouseout="tooltip.hide();">Additive</span>
			</div>
			<div class="table-cell">
				Name Search: <input type="text" id="namesearch" onkeyup="filterHero()" size="19" maxlength="19"/>
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell">
				<?php
					$i=0;
					foreach ($hero_roles as $role)
					{	
						$i++;
						echo "<input type=\"checkbox\" id=\"" . $role . "\" onchange=\"filterHero()\">" . $role . " ";
						if($i == 5)
						{
							break;
						}
					}
				?>
			</div>
			<div class="table-cell">
				Attack method: 
				<input type="radio" name="attack" id="either" onchange="filterHero()" checked/>Either
				<input type="radio" name="attack" id="melee" onchange="filterHero()"/>Melee
				<input type="radio" name="attack" id="ranged" onchange="filterHero()"/>Ranged
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell">
				<?php
					$i=0;
					foreach ($hero_roles as $role)
					{	
						$i++;
						if($i > 5)
						{
							echo "<input type=\"checkbox\" id=\"" . $role . "\" onchange=\"filterHero()\">" . $role . " ";
						}
					}
				?>
			</div>
			<div class="table-cell">
				<input type="button" id="clearsearchfilter" value="Clear Search Filters" onmouseup="clearSearchFilter()"/>
			</div>
		</div>
		<div class="table-row">
			<div class="table-cell">
				<input type="button" id="clearrolesfilter" value="Clear Roles Filter" onmouseup="clearRolesFilter()"/>
			</div>
			<div class="table-cell">
				<input type="checkbox" id="scepter" onchange="filterScepter()"/>Highlight <a href="http://dota2itemsdb.x10.mx/?go=itemgroup&search=Aghanim%27s%20Scepter,">Aghanim's Scepter</a> users
			</div>
		</div>
	</div>
</form>
<br/>
<a href="?go=herogroup&search=all"><img src="images/button_allheroes.png" onMouseOver="this.src = allheroes_up" onMouseOut="this.src = allheroes_down" onMouseDown="this.src = allheroes_click" onMouseUp="this.src = allheroes_up"/></a>
&nbsp;
<img src="images/button_selectheroes.png" class="pointer" onclick="selectedSearch()" onMouseOver="this.src = selectheroes_up" onMouseOut="this.src = selectheroes_down" onMouseDown="this.src = selectheroes_click" onMouseUp="this.src = selectheroes_up"/>
<br/>
<br/>
<div id="center" class="table">
	<div id="radiant-header" class="table-caption" onclick="location.href='?go=herogroup&search=radiant';" style="cursor: pointer;">
		<img src="http://hydra-images.cursecdn.com/dota2.gamepedia.com/2/2a/Radiant_icon.png" width="30px"/>&nbsp;R&nbsp;A&nbsp;D&nbsp;I&nbsp;A&nbsp;N&nbsp;T
	</div>
	<div class="table-row">
		<div id="str-header" class="table-cell" onclick="location.href='?go=herogroup&search=radiantStr';" style="cursor: pointer;">
			<img src="<?php echo $stricon ?>" width="22px"/>&nbsp;S&nbsp;T&nbsp;R&nbsp;E&nbsp;N&nbsp;G&nbsp;T&nbsp;H
		</div>
		<div id="agil-header" class="table-cell" onclick="location.href='?go=herogroup&search=radiantAgil';" style="cursor: pointer;">
			<img src="<?php echo $agilicon ?>" width="22px"/>&nbsp;A&nbsp;G&nbsp;I&nbsp;L&nbsp;I&nbsp;T&nbsp;Y
		</div>
		<div id="int-header" class="table-cell" onclick="location.href='?go=herogroup&search=radiantInt';" style="cursor: pointer;">
			<img src="<?php echo $intlicon ?>" width="22px"/>&nbsp;I&nbsp;N&nbsp;T&nbsp;E&nbsp;L&nbsp;L&nbsp;I&nbsp;G&nbsp;E&nbsp;N&nbsp;C&nbsp;E
		</div>
	</div>
	<div class="table-row">
		<div class="table-cell" id="HeroRadStr">
			<?php echo displayHeroGroup($db,"Radiant","Strength",$hoverimg); ?>
		</div>
		<div class="table-cell" id="HeroRadAgil">
			<?php echo displayHeroGroup($db,"Radiant","Agility",$hoverimg); ?>
		</div>
		<div class="table-cell" id="HeroRadInt">
			<?php echo displayHeroGroup($db,"Radiant","Intelligence",$hoverimg); ?>
		</div>
	</div>
</div>
<br/>
<div id="center" class="table">
	<div id="dire-header" class="table-caption" onclick="location.href='?go=herogroup&search=dire';" style="cursor: pointer;">
		<img src="http://hydra-images.cursecdn.com/dota2.gamepedia.com/0/0e/Dire_icon.png" width="30px"/>&nbsp;D&nbsp;I&nbsp;R&nbsp;E
	</div>
	<div class="table-row">
		<div id="str-header" class="table-cell" onclick="location.href='?go=herogroup&search=direStr';" style="cursor: pointer;">
			<img src="<?php echo $stricon ?>" width="22px"/>&nbsp;S&nbsp;T&nbsp;R&nbsp;E&nbsp;N&nbsp;G&nbsp;T&nbsp;H
		</div>
		<div id="agil-header" class="table-cell" onclick="location.href='?go=herogroup&search=direAgil';" style="cursor: pointer;">
			<img src="<?php echo $agilicon ?>" width="22px"/>&nbsp;A&nbsp;G&nbsp;I&nbsp;L&nbsp;I&nbsp;T&nbsp;Y
		</div>
		<div id="int-header" class="table-cell" onclick="location.href='?go=herogroup&search=direInt';" style="cursor: pointer;">
			<img src="<?php echo $intlicon ?>" width="22px"/>&nbsp;I&nbsp;N&nbsp;T&nbsp;E&nbsp;L&nbsp;L&nbsp;I&nbsp;G&nbsp;E&nbsp;N&nbsp;C&nbsp;E
		</div>
	</div>
	<div class="table-row">
		<div class="table-cell" id="HeroDireStr">
			<?php echo displayHeroGroup($db,"Dire","Strength",$hoverimg); ?>
		</div>
		<div class="table-cell" id="HeroDireAgil">
			<?php echo displayHeroGroup($db,"Dire","Agility",$hoverimg); ?>
		</div>
		<div class="table-cell" id="HeroDireInt">
			<?php echo displayHeroGroup($db,"Dire","Intelligence",$hoverimg); ?>
		</div>
	</div>
</div>