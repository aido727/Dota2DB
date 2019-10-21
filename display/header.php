<?php
	include 'scripts/headerimgs.js';
?>
<div id="center" class="table" style="width:157px;">
	<div class="table-row">
		<div class="table-cell" style="padding-right:1px;">
			<?php
			$go = (!empty($_GET['go']) ? $_GET['go'] : null);
			if($go == "" || $go == "home")
			{
				echo "<img src='images/button_home_in.png'/>";
			}
			else
			{
				echo "<a href='?go=home' ><img src='images/button_home.png' onMouseOver='this.src = home_up' onMouseOut='this.src = home_down' onMouseDown='this.src = home_click' onMouseUp='this.src = home_up' alt='Home'/></a>";
			}
			?>
		</div>
		<div class="table-cell" style="padding-left:1px; padding-right:1px;">
			<?php
			if($go == "heroes")
			{
				echo "<img src='images/button_heroes_in.png'/>";
			}
			else
			{
				echo "<a href='?go=heroes' ><img src='images/button_heroes.png' onMouseOver='this.src = heroes_up' onMouseOut='this.src = heroes_down' onMouseDown='this.src = heroes_click' onMouseUp='this.src = heroes_up' alt='Heroes'/></a>";
			}
			?>
		</div>
		<div class="table-cell" style="padding-left:1px;">
			<?php
			if($go == "items")
			{
				echo "<img src='images/button_items_in.png'/>";
			}
			else
			{
				echo "<a href='?go=items' ><img src='images/button_items.png' onMouseOver='this.src = items_up' onMouseOut='this.src = items_down' onMouseDown='this.src = items_click' onMouseUp='this.src = items_up' alt='Items'/></a>";
			}
			?>
		</div>
	</div>
</div>
<br/>
<span class='dbdate'>
	<a href="<?php echo getCurrentBalanceLog(); ?>"><?php echo getCurrentDataDate(); ?></a>
</span>
<!--<span class='livedate'>
<?php
	//echo getCurrentLiveDate();
?>
</span>-->
<?php
	$currentpage = (!empty($_GET['go']) ? $_GET['go'] : null);
?>
