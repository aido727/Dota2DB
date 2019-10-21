<script language="JavaScript" type="text/javascript">
//-----------------------------------------------------------------------------//
//	filterItems() - sets which item thumbs are faded out
//-----------------------------------------------------------------------------//
function filterItems()
{	
	//reset any previous filter
	var all_items = document.getElementsByClassName('item_select-thumb');
	for(var i=0;i < all_items.length;i++)
	{
		all_items[i].className = all_items[i].className.replace( /(?:^|\s)greyedout(?!\S)/g , '' );
		all_items[i].className = all_items[i].className.replace( /(?:^|\s)cost_highlight(?!\S)/g , '' );
	}

	//abilities search filter
	var abilities = delimitArray("<?php echo $abilities; ?>",",");
	var abilitieschecked = new Array();
	var itemskeeping = new Array();
	var itemskeeping1 = new Array();
	var itemskeeping2 = new Array();
	for(var i=0;i < abilities.length-1;i++)
	{
		if(innerHTML=document.forms.itemfilter.elements[abilities[i]].checked)
		{
			abilitieschecked.push(abilities[i]);
		}
	}
		
	//this passes only when the abilities filter is required
	if(abilitieschecked.length > 0)
	{
		if(innerHTML=document.forms.itemfilter.elements['additive'].checked)
		{
			for(var i=0;i < abilitieschecked.length;i++)
			{	
				while(abilitieschecked[i].indexOf(" ") > -1)
				{
					abilitieschecked[i] = abilitieschecked[i].replace(" ","_");
				}
				while(abilitieschecked[i].indexOf("/") > -1)
				{
					abilitieschecked[i] = abilitieschecked[i].replace("/","-");
				}
				abilitieschecked[i] = abilitieschecked[i].toLowerCase();
				//get all heroes with that role
				var itemswithability = document.getElementsByClassName(abilitieschecked[i]);
				//combine with array of other heroes with other abilities
				for(var i2=0;i2 < itemswithability.length;i2++)
				{
					//no duplicates
					if(itemskeeping.indexOf(itemswithability[i2]) < 0)
					{
						itemskeeping.push(itemswithability[i2]);
					}
				}
			}
		}
		else
		{		
			if(innerHTML=document.forms.itemfilter.elements['exclusive'].checked)
			{
				for(var i=0;i < abilitieschecked.length;i++)
				{
					while(abilitieschecked[i].indexOf(" ") > -1)
					{
						abilitieschecked[i] = abilitieschecked[i].replace(" ","_");
					}
					while(abilitieschecked[i].indexOf("/") > -1)
					{
						abilitieschecked[i] = abilitieschecked[i].replace("/","-");
					}
					abilitieschecked[i] = abilitieschecked[i].toLowerCase();
					//get all heroes with that role
					var itemswithability = document.getElementsByClassName(abilitieschecked[i]);
					//combine with array of other heroes with other abilities
					for(var i2=0;i2 < itemswithability.length;i2++)
					{
						//if first/only role then load array with initial/only heroes to keep
						if(i==0)
						{
							if(itemskeeping.indexOf(itemswithability[i2]) < 0)
							{
								itemskeeping.push(itemswithability[i2]);
							}
						}
						else
						{
							//load addition set of heroes into seperate array
							if(itemskeeping2.indexOf(itemswithability[i2]) < 0)
							{
								itemskeeping2.push(itemswithability[i2]);
							}
						}
					}
					//then remove heroes from initial array that do not appear in the additional hero set
					if(i!=0)
					{
						for(var i3=0;i3 < itemskeeping2.length;i3++)
						{
							if(itemskeeping.indexOf(itemskeeping2[i3]) > -1)
							{
								itemskeeping1.push(itemskeeping2[i3]);
							}
						}
						itemskeeping = itemskeeping1;
					}
					
					//reset temp arrays
					var itemskeeping1 = new Array();
					var itemskeeping2 = new Array();
				}
			}
		}
		
		//apply abilities filter
		for(var i=0;i < all_items.length;i++)
		{
			if(itemskeeping.indexOf(all_items[i]) < 0)
			{
				all_items[i].className += " greyedout";
			}
		}
	}
	
	//unique attack modifer filter
	//clear checks
	if(innerHTML=document.forms.itemfilter.elements['lifeclear'].checked == false)
	{
		var itemsLFS = document.getElementsByClassName('mod_lifesteal');
	}
	if(innerHTML=document.forms.itemfilter.elements['stackclear'].checked == false)
	{
		var itemsSTK = document.getElementsByClassName('mod_stack');
	}
	if(innerHTML=document.forms.itemfilter.elements['chainclear'].checked == false)
	{
		var itemsCHN = document.getElementsByClassName('mod_chain');
	}	
	if(innerHTML=document.forms.itemfilter.elements['uamclear'].checked == false)
	{
		var itemsUAM = document.getElementsByClassName('UAM');
	}
		
	//show checks
	var items2 = new Array();
	if(innerHTML=document.forms.itemfilter.elements['lifeshow'].checked)
	{

		for(var i=0;i < itemsLFS.length;i++)
		{
			items2.push(itemsLFS[i]);
		}
	}
	if(innerHTML=document.forms.itemfilter.elements['stackshow'].checked)
	{
		for(var i=0;i < itemsSTK.length;i++)
		{
			items2.push(itemsSTK[i]);
		}
	}
	if(innerHTML=document.forms.itemfilter.elements['chainshow'].checked)
	{
		for(var i=0;i < itemsCHN.length;i++)
		{
			items2.push(itemsCHN[i]);
		}
	}
	if(innerHTML=document.forms.itemfilter.elements['uamshow'].checked)
	{
		for(var i=0;i < itemsUAM.length;i++)
		{
			items2.push(itemsUAM[i]);
		}
	}
	
	//apply show filter		
	//because fuck knows why I can't just use (items.indexOf(all_items[i]) < 0)...
	if(items2.length > 0)
	{	
		for(var i=0;i < all_items.length;i++)
		{
			if(items2.indexOf(all_items[i]) < 0)
			{
				all_items[i].className += " greyedout";
			}
		}	
	}
	
	//hide checks
	if(innerHTML=document.forms.itemfilter.elements['lifehide'].checked)
	{
		for(var i=0;i < itemsLFS.length;i++)
		{
			itemsLFS[i].className += " greyedout";
		}
	}
	if(innerHTML=document.forms.itemfilter.elements['stackhide'].checked)
	{
		for(var i=0;i < itemsSTK.length;i++)
		{
			itemsSTK[i].className += " greyedout";
		}
	}
	if(innerHTML=document.forms.itemfilter.elements['chainhide'].checked)
	{
		for(var i=0;i < itemsCHN.length;i++)
		{
			itemsCHN[i].className += " greyedout";
		}
	}
	if(innerHTML=document.forms.itemfilter.elements['uamhide'].checked)
	{
		for(var i=0;i < itemsUAM.length;i++)
		{
			itemsUAM[i].className += " greyedout";
		}
	}
	
	//name search filter
	var name = innerHTML=document.forms.itemfilter.elements['namesearch'].value;
	var namecheck = "name-" + name.toLowerCase().trim();
	while(namecheck.indexOf(" ") > -1)
	{
		namecheck = namecheck.replace(" ","%20");
	}
	while(namecheck.indexOf("'") > -1)
	{
		namecheck = namecheck.replace("'","");
	}
	for(var i=0;i < all_items.length;i++)
	{
		if(all_items[i].className.toLowerCase().indexOf(namecheck) < 0)
		{
			all_items[i].className += " greyedout";
		}
	}
	
	//has_recipe filter
	if(innerHTML=document.forms.itemfilter.elements['recipeclear'].checked == false)
	{
		var items = document.getElementsByClassName('has_recipe');
		
		if(innerHTML=document.forms.itemfilter.elements['recipeshow'].checked)
		{
			//because fuck knows why I can't just use (items.indexOf(all_items[i]) < 0)...
			var items2 = new Array();
			for(var i=0;i < items.length;i++)
			{
				items2.push(items[i]);
			}
						
			for(var i=0;i < all_items.length;i++)
			{
				if(items2.indexOf(all_items[i]) < 0)
				{
					all_items[i].className += " greyedout";
				}
			}	
		}
		else
		{
			if(innerHTML=document.forms.itemfilter.elements['recipehide'].checked)
			{
				for(var i=0;i < items.length;i++)
				{
					items[i].className += " greyedout";
				}
			}
		}
	}
	
	//aura filter
	if(innerHTML=document.forms.itemfilter.elements['auraclear'].checked == false)
	{
		var items = document.getElementsByClassName('aura');
		
		if(innerHTML=document.forms.itemfilter.elements['aurashow'].checked)
		{
			//because fuck knows why I can't just use (items.indexOf(all_items[i]) < 0)...
			var items2 = new Array();
			for(var i=0;i < items.length;i++)
			{
				items2.push(items[i]);
			}
						
			for(var i=0;i < all_items.length;i++)
			{
				if(items2.indexOf(all_items[i]) < 0)
				{
					all_items[i].className += " greyedout";
				}
			}	
		}
		else
		{
			if(innerHTML=document.forms.itemfilter.elements['aurahide'].checked)
			{
				for(var i=0;i < items.length;i++)
				{
					items[i].className += " greyedout";
				}
			}
		}
	}
	
	//disassemble filter
	if(innerHTML=document.forms.itemfilter.elements['disassembleclear'].checked == false)
	{
		var items = document.getElementsByClassName('disassemble');
		
		if(innerHTML=document.forms.itemfilter.elements['disassembleshow'].checked)
		{
			//because fuck knows why I can't just use (items.indexOf(all_items[i]) < 0)...
			var items2 = new Array();
			for(var i=0;i < items.length;i++)
			{
				items2.push(items[i]);
			}
						
			for(var i=0;i < all_items.length;i++)
			{
				if(items2.indexOf(all_items[i]) < 0)
				{
					all_items[i].className += " greyedout";
				}
			}	
		}
		else
		{
			if(innerHTML=document.forms.itemfilter.elements['disassemblehide'].checked)
			{
				for(var i=0;i < items.length;i++)
				{
					items[i].className += " greyedout";
				}
			}
		}
	}
	
	//shop filter - LSpart
	if(innerHTML=document.forms.itemfilter.elements['LSpartclear'].checked == false)
	{
		var items = document.getElementsByClassName('LSpart');
		if(innerHTML=document.forms.itemfilter.elements['LSpartshow'].checked)
		{
			//because fuck knows why I can't just use (items.indexOf(all_items[i]) < 0)...
			var items2 = new Array();
			for(var i=0;i < items.length;i++)
			{
				items2.push(items[i]);
			}
						
			for(var i=0;i < all_items.length;i++)
			{
				if(items2.indexOf(all_items[i]) < 0)
				{
					all_items[i].className += " greyedout";
				}
			}	
		}
		else
		{
			if(innerHTML=document.forms.itemfilter.elements['LSparthide'].checked)
			{
				for(var i=0;i < items.length;i++)
				{
					items[i].className += " greyedout";
				}
			}
		}
	}
	
	//shop filter - LSall
	if(innerHTML=document.forms.itemfilter.elements['LSallclear'].checked == false)
	{
		var items = document.getElementsByClassName('LSall');
		if(innerHTML=document.forms.itemfilter.elements['LSallshow'].checked)
		{
			//because fuck knows why I can't just use (items.indexOf(all_items[i]) < 0)...
			var items2 = new Array();
			for(var i=0;i < items.length;i++)
			{
				items2.push(items[i]);
			}
						
			for(var i=0;i < all_items.length;i++)
			{
				if(items2.indexOf(all_items[i]) < 0)
				{
					all_items[i].className += " greyedout";
				}
			}	
		}
		else
		{
			if(innerHTML=document.forms.itemfilter.elements['LSallhide'].checked)
			{
				for(var i=0;i < items.length;i++)
				{
					items[i].className += " greyedout";
				}
			}
		}
	}
	
	//shop filter - SSpart
	if(innerHTML=document.forms.itemfilter.elements['SSpartclear'].checked == false)
	{
		var items = document.getElementsByClassName('SSpart');
		if(innerHTML=document.forms.itemfilter.elements['SSpartshow'].checked)
		{
			//because fuck knows why I can't just use (items.indexOf(all_items[i]) < 0)...
			var items2 = new Array();
			for(var i=0;i < items.length;i++)
			{
				items2.push(items[i]);
			}
						
			for(var i=0;i < all_items.length;i++)
			{
				if(items2.indexOf(all_items[i]) < 0)
				{
					all_items[i].className += " greyedout";
				}
			}	
		}
		else
		{
			if(innerHTML=document.forms.itemfilter.elements['SSparthide'].checked)
			{
				for(var i=0;i < items.length;i++)
				{
					items[i].className += " greyedout";
				}
			}
		}
	}
	
	//shop filter - SSall
	if(innerHTML=document.forms.itemfilter.elements['SSallclear'].checked == false)
	{
		var items = document.getElementsByClassName('SSall');
		if(innerHTML=document.forms.itemfilter.elements['SSallshow'].checked)
		{
			//because fuck knows why I can't just use (items.indexOf(all_items[i]) < 0)...
			var items2 = new Array();
			for(var i=0;i < items.length;i++)
			{
				items2.push(items[i]);
			}
						
			for(var i=0;i < all_items.length;i++)
			{
				if(items2.indexOf(all_items[i]) < 0)
				{
					all_items[i].className += " greyedout";
				}
			}	
		}
		else
		{
			if(innerHTML=document.forms.itemfilter.elements['SSallhide'].checked)
			{
				for(var i=0;i < items.length;i++)
				{
					items[i].className += " greyedout";
				}
			}
		}
	}
	
	//cost search filter
	var cost = innerHTML=document.forms.itemfilter.elements['goldsearch'].value;
	if(cost)
	{
		cost.trim();
		for(var i=0;i < all_items.length;i++)
		{
			var starti = all_items[i].className.indexOf('cost-');
			var price = all_items[i].className.substring(starti);
			price = price.replace("cost-","");
			if(parseInt(cost, 10)>=parseInt(price, 10))
			{
				all_items[i].className += " cost_highlight";
			}
		}
	}
	
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	selectedSearch() - builds a string of all selected Items
//-----------------------------------------------------------------------------//
function selectedSearch()
{
	var all_items = document.getElementsByClassName('item_select-thumb');
	var hidden_items = document.getElementsByClassName('greyedout');
	var select_items = "http://dota2itemsdb.x10.mx/?go=itemgroup&search=";
	//because fuck knows why I can't just use (hidden_items.indexOf(all_items[i]) < 0)...
	var hidden_items2 = new Array();
	for(var i=0;i < hidden_items.length;i++)
	{
		hidden_items2.push(hidden_items[i]);
	}
	
	for(var i = 0;i < all_items.length;i++)
	{
		if(hidden_items2.indexOf(all_items[i]) < 0)
		{
			select_items = select_items + all_items[i].alt + ",";
		}
	}

	document.location = select_items;
	
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	highlightAllUAM() - sets all UAM filter elements to highlight
//-----------------------------------------------------------------------------//
function highlightAllUAM()
{
	innerHTML=document.forms.itemfilter.elements['lifeshow'].checked = true;
	innerHTML=document.forms.itemfilter.elements['stackshow'].checked = true;
	innerHTML=document.forms.itemfilter.elements['chainshow'].checked = true;
	innerHTML=document.forms.itemfilter.elements['uamshow'].checked = true;
	
	filterItems();
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	hideAllUAM() - sets all UAM filter elements to highlight
//-----------------------------------------------------------------------------//
function hideAllUAM()
{
	innerHTML=document.forms.itemfilter.elements['lifehide'].checked = true;
	innerHTML=document.forms.itemfilter.elements['stackhide'].checked = true;
	innerHTML=document.forms.itemfilter.elements['chainhide'].checked = true;
	innerHTML=document.forms.itemfilter.elements['uamhide'].checked = true;
	
	filterItems();
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	clearAbilitiesFilter() - resets abilities filter elements on Item selection screen
//-----------------------------------------------------------------------------//
function clearAbilitiesFilter()
{
	var abilities = delimitArray("<?php echo $abilities; ?>",",");
	for(var i=0;i < abilities.length-1;i++)
	{
		innerHTML=document.forms.itemfilter.elements[abilities[i]].checked = false;
	}
	innerHTML=document.forms.itemfilter.elements['exclusive'].checked = true;
	
	filterItems();
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	clearUAMFilter() - resets UAM filter elements on Item selection screen
//-----------------------------------------------------------------------------//
function clearUAMFilter()
{
	innerHTML=document.forms.itemfilter.elements['allclear'].checked = true;
	innerHTML=document.forms.itemfilter.elements['lifeclear'].checked = true;
	innerHTML=document.forms.itemfilter.elements['stackclear'].checked = true;
	innerHTML=document.forms.itemfilter.elements['chainclear'].checked = true;
	innerHTML=document.forms.itemfilter.elements['uamclear'].checked = true;

	filterItems();
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	clearSearchFilter() - resets search filter elements on Item selection screen
//-----------------------------------------------------------------------------//
function clearSearchFilter()
{
	innerHTML=document.forms.itemfilter.elements['namesearch'].value = "";
	//innerHTML=document.forms.itemfilter.elements['goldsearch'].value = "";
	innerHTML=document.forms.itemfilter.elements['recipeclear'].checked = true;
	innerHTML=document.forms.itemfilter.elements['auraclear'].checked = true;
	innerHTML=document.forms.itemfilter.elements['disassembleclear'].checked = true;

	filterItems();
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	clearGoldFilter() - resets gold filter on Item selection screen
//-----------------------------------------------------------------------------//
function clearGoldFilter()
{
	innerHTML=document.forms.itemfilter.elements['goldsearch'].value = "0";

	filterItems();
	return;
}
//-----------------------------------------------------------------------------//

//-----------------------------------------------------------------------------//
//	clearShopFilter() - resets shop filter on Item selection screen
//-----------------------------------------------------------------------------//
function clearShopFilter()
{
	innerHTML=document.forms.itemfilter.elements['LSpartclear'].checked = true;
	innerHTML=document.forms.itemfilter.elements['LSallclear'].checked = true;
	innerHTML=document.forms.itemfilter.elements['SSpartclear'].checked = true;
	innerHTML=document.forms.itemfilter.elements['SSallclear'].checked = true;

	filterItems();
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