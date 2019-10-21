<script language="JavaScript" type="text/javascript">
//-----------------------------------------------------------------------------//
//	filterHero() - sets which hero thumbs are faded out
//-----------------------------------------------------------------------------//
function filterHero()
{	
	//reset any previous filter
	var all_heroes = document.getElementsByClassName('hero_select-thumb');
	for(var i=0;i < all_heroes.length;i++)
	{
		all_heroes[i].className = all_heroes[i].className.replace( /(?:^|\s)greyedout(?!\S)/g , '' )
	}
	
	//attack type filter
	var attack = "";
	if(innerHTML=document.forms.herofilter.elements['either'].checked == false)
	{
		if(innerHTML=document.forms.herofilter.elements['melee'].checked)
		{
			attack = "Ranged"; //Melee wanted, hide Ranged
		}
		else
		{
			if(innerHTML=document.forms.herofilter.elements['ranged'].checked)
			{
				attack = "Melee"; //Ranged wanted, hide Melee
			}
		}
		
		//attack filter only applied when required
		var heroes = document.getElementsByClassName(attack);
		for(var i=0;i < heroes.length;i++)
		{
			heroes[i].className += " greyedout";
		}
	}

	
	//roles search filter
	var roles = delimitArray("<?php echo $roles; ?>",",");
	var roleschecked = new Array();
	var heroeskeeping = new Array();
	var heroeskeeping1 = new Array();
	var heroeskeeping2 = new Array();
	for(var i=0;i < roles.length-1;i++)
	{
		if(innerHTML=document.forms.herofilter.elements[roles[i]].checked)
		{
			roleschecked.push(roles[i]);
		}
	}
		
	//this passes only when the roles filter is required
	if(roleschecked.length > 0)
	{
		if(innerHTML=document.forms.herofilter.elements['additive'].checked)
		{
			for(var i=0;i < roleschecked.length;i++)
			{
				while(roleschecked[i].indexOf(" ") > -1)
				{
					roleschecked[i] = roleschecked[i].replace(" ","-");
				}
				//get all heroes with that role
				var heroeswithrole = document.getElementsByClassName(roleschecked[i]);
				//combine with array of other heroes with other roles
				for(var i2=0;i2 < heroeswithrole.length;i2++)
				{
					//no duplicates
					if(heroeskeeping.indexOf(heroeswithrole[i2]) < 0)
					{
						heroeskeeping.push(heroeswithrole[i2]);
					}
				}
			}
		}
		else
		{		
			if(innerHTML=document.forms.herofilter.elements['exclusive'].checked)
			{
				for(var i=0;i < roleschecked.length;i++)
				{
					while(roleschecked[i].indexOf(" ") > -1)
					{
						roleschecked[i] = roleschecked[i].replace(" ","-");
					}
					//get all heroes with that role
					var heroeswithrole = document.getElementsByClassName(roleschecked[i]);
					//combine with array of other heroes with other roles
					for(var i2=0;i2 < heroeswithrole.length;i2++)
					{
						//if first/only role then load array with initial/only heroes to keep
						if(i==0)
						{
							if(heroeskeeping.indexOf(heroeswithrole[i2]) < 0)
							{
								heroeskeeping.push(heroeswithrole[i2]);
							}
						}
						else
						{
							//load addition set of heroes into seperate array
							if(heroeskeeping2.indexOf(heroeswithrole[i2]) < 0)
							{
								heroeskeeping2.push(heroeswithrole[i2]);
							}
						}
					}
					//then remove heroes from initial array that do not appear in the additional hero set
					if(i!=0)
					{
						for(var i3=0;i3 < heroeskeeping2.length;i3++)
						{
							if(heroeskeeping.indexOf(heroeskeeping2[i3]) > -1)
							{
								heroeskeeping1.push(heroeskeeping2[i3]);
							}
						}
						heroeskeeping = heroeskeeping1;
					}
					
					//reset temp arrays
					var heroeskeeping1 = new Array();
					var heroeskeeping2 = new Array();
				}
			}
		}
		
		//apply roles filter
		for(var i=0;i < all_heroes.length;i++)
		{
			if(heroeskeeping.indexOf(all_heroes[i]) < 0)
			{
				all_heroes[i].className += " greyedout";
			}
		}
	}
	
	//name search filter
	var name = innerHTML=document.forms.herofilter.elements['namesearch'].value;
	var namecheck = "name-" + name.toLowerCase().trim();
	while(namecheck.indexOf(" ") > -1)
	{
		namecheck = namecheck.replace(" ","%20");
	}
	while(namecheck.indexOf("'") > -1)
	{
		namecheck = namecheck.replace("'","");
	}
	for(var i=0;i < all_heroes.length;i++)
	{
		if(all_heroes[i].className.toLowerCase().indexOf(namecheck) < 0)
		{
			all_heroes[i].className += " greyedout";
		}
	}
	
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	filterScepter() - Aghanim's Scepter filter element script
//-----------------------------------------------------------------------------//
function filterScepter()
{
	var scepter = innerHTML=document.forms.herofilter.elements['scepter'].checked;
	var heroes = document.getElementsByClassName('hero_scepter');
	var heroes_cast = document.getElementsByClassName('hero_scepter_cast');
	
	if(scepter)
	{
		for(var i=0;i < heroes.length;i++)
		{
			heroes[i].className += " hero_scepter_highlight";
		}
		for(var i=0;i < heroes_cast.length;i++)
		{
			heroes_cast[i].className += " hero_scepter_cast_highlight";
		}
	}
	else
	{
		for(var i=0;i < heroes.length;i++)
		{
			heroes[i].className = heroes[i].className.replace( /(?:^|\s)hero_scepter_highlight(?!\S)/g , '' )
		}
		for(var i=0;i < heroes_cast.length;i++)
		{
			heroes_cast[i].className = heroes_cast[i].className.replace( /(?:^|\s)hero_scepter_cast_highlight(?!\S)/g , '' )
		}
	}
	
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	clearRolesFilter() - resets roles filter elements on Hero selection screen
//-----------------------------------------------------------------------------//
function clearRolesFilter()
{
	var roles = delimitArray("<?php echo $roles; ?>",",");
	for(var i=0;i < roles.length-1;i++)
	{
		innerHTML=document.forms.herofilter.elements[roles[i]].checked = false;
	}
	innerHTML=document.forms.herofilter.elements['exclusive'].checked = true;
	
	filterHero();
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	clearSearchFilter() - resets search filter elements on Hero selection screen
//-----------------------------------------------------------------------------//
function clearSearchFilter()
{
	//innerHTML=document.forms.herofilter.elements['scepter'].checked = false;
	innerHTML=document.forms.herofilter.elements['namesearch'].value = "";
	innerHTML=document.forms.herofilter.elements['either'].checked = true;

	filterHero()
	
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	selectedSearch() - builds a string of all selected Heroes
//-----------------------------------------------------------------------------//
function selectedSearch()
{
	var all_heroes = document.getElementsByClassName('hero_select-thumb');
	var hidden_heroes = document.getElementsByClassName('greyedout');
	var select_heroes = "http://dota2itemsdb.x10.mx/?go=herogroup&search=";
	//because fuck knows why I can't just use (hidden_heroes.indexOf(all_heroes[i]) < 0)...
	var hidden_heroes2 = new Array();
	for(var i=0;i < hidden_heroes.length;i++)
	{
		hidden_heroes2.push(hidden_heroes[i]);
	}
	
	for(var i = 0;i < all_heroes.length;i++)
	{
		if(hidden_heroes2.indexOf(all_heroes[i]) < 0)
		{
			select_heroes = select_heroes + all_heroes[i].alt + ",";
		}
	}

	document.location = select_heroes;
	
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	clearResult() - clears any result
//-----------------------------------------------------------------------------//
function clearResult()
{
	document.getElementById("result").style.display="none";
	document.getElementById("resultbutton").style.display="none";

	return;
}
//-----------------------------------------------------------------------------//
</script>