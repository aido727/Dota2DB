<?php
	include 'scripts/footerimgs.js';
?>
<div id='footer-link'><a href='http://blog.dota2.com/' ><img src='images/button_officialweb.png' onMouseOver='this.src = officialweb_up' onMouseOut='this.src = officialweb_down' onMouseDown='this.src = officialweb_click' onMouseUp='this.src = officialweb_up' alt='Dota 2 Official Blog'/></a></div>
<div id='footer-link'><a href='http://store.steampowered.com/app/570/'><img src='images/button_steamstore.png' onMouseOver='this.src = steamstore_up' onMouseOut='this.src = steamstore_down' onMouseDown='this.src = steamstore_click' onMouseUp='this.src = steamstore_up' alt='Dota 2 on Steam'/></a></div>
<div id='footer-link'><a href='http://www.dota2.com/store/'><img src='images/button_ingamestore.png' onMouseOver='this.src = ingamestore_up' onMouseOut='this.src = ingamestore_down' onMouseDown='this.src = ingamestore_click' onMouseUp='this.src = ingamestore_up' alt='The Dota Store'/></a></div>
<div id='footer-link'><a href='http://steamcommunity.com/sharedfiles/browse/?appid=570'><img src='images/button_workshop.png' onMouseOver='this.src = workshop_up' onMouseOut='this.src = workshop_down' onMouseDown='this.src = workshop_click' onMouseUp='this.src = workshop_up' alt='Dota 2 in Steam Workshop'/></a></div>
<div id='footer-link'><a href='http://www.playdota.com/forums/'><img src='images/button_forums.png' onMouseOver='this.src = forums_up' onMouseOut='this.src = forums_down' onMouseDown='this.src = forums_click' onMouseUp='this.src = forums_up' alt='Dota Forums'/></a></div>
<div id='footer-link'><a href='http://dota2.gamepedia.com/Dota_2_Wiki'><img src='images/button_wiki.png' onMouseOver='this.src = wiki_up' onMouseOut='this.src = wiki_down' onMouseDown='this.src = wiki_click' onMouseUp='this.src = wiki_up' alt='Dota 2 Wiki'/></a></div>
<div id='footer-link'>
<?php
$go = (!empty($_GET['go']) ? $_GET['go'] : null);
if($go == 'contact')
{
	echo "<img src='images/button_contact_in.png'/>";
}
else
{
	echo "<a href='?go=contact'><img src='images/button_contact.png' onMouseOver='this.src = contact_up' onMouseOut='this.src = contact_down' onMouseDown='this.src = contact_click' onMouseUp='this.src = contact_up' alt='Contact'/></a>";
}
?>
</div>
<div id='footer-link'>
<?php
if($go == 'changelogs')
{
	echo "<img src='images/button_changelogs_in.png'/>";
}
else
{
	echo "<a href='?go=changelogs'><img src='images/button_changelogs.png' onMouseOver='this.src = changelogs_up' onMouseOut='this.src = changelogs_down' onMouseDown='this.src = changelogs_click' onMouseUp='this.src = changelogs_up' alt='Changelogs'/></a>";
}
?>
</div>
<br/><span class='affiliation'>This site has no affiliation with <a href='http://www.valvesoftware.com/'>Valve Corporation</a></span>