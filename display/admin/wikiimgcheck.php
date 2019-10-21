<script language="JavaScript" type="text/javascript">
	document.title = document.title + " - Admin - Wiki Image Check";
</script>

<div id="genericheader">Admin - Dota 2 Wiki image check</div>

<?php
	//dire couriers
	$item_data = mysqli_query($db,"SELECT name,img_dire,wiki_url FROM consumables WHERE type = 'Courier'");
	while($item_values = mysqli_fetch_array($item_data))
	{
		$item[] = array("name" => $item_values['name'],"img" => $item_values['img_dire'],"url" => $item_values['wiki_url']);
	}
	
	//power treads
	$item_data = mysqli_query($db,"SELECT name,img,wiki_url FROM upgrades WHERE name like 'Power Treads (%'");
	while($item_values = mysqli_fetch_array($item_data))
	{
		$item[] = array("name" => $item_values['name'],"img" => $item_values['img'],"url" => $item_values['wiki_url']);
	}
	
	//upgradeable items
	$item_data = mysqli_query($db,"SELECT name,img,wiki_url FROM upgrades WHERE upgradeable = '1' AND upgrade_level > 1");
	while($item_values = mysqli_fetch_array($item_data))
	{
		$item[] = array("name" => $item_values['name'],"img" => $item_values['img'],"url" => $item_values['wiki_url']);
	}
	
	//roshan drop items
	$item_data = mysqli_query($db,"SELECT name,img,wiki_url FROM other WHERE type = 'Roshan Drop'");
	while($item_values = mysqli_fetch_array($item_data))
	{
		$item[] = array("name" => $item_values['name'],"img" => $item_values['img'],"url" => $item_values['wiki_url']);
	}
	
	//hero map icons
	$item_data = mysqli_query($db,"SELECT name,map_icon,wiki_url FROM heroes WHERE unreleased = '0'");
	while($item_values = mysqli_fetch_array($item_data))
	{
		$item[] = array("name" => $item_values['name'],"img" => $item_values['map_icon'],"url" => $item_values['wiki_url']);
	}
	
	// display
	echo "<div id='center' class='table' style='width:370px;'>";
		echo "<div class='table-row'>";
			echo "<div class='table-cell' style='width:200px;'><b>Object Name</b></div>";
			echo "<div class='table-cell' style='width:90px;'><b>Img</b></div>";
		echo "</div>";
	foreach($item as $data)
	{
		echo "<div class='table-row'>";
		echo "<div class='table-cell'><a href='" . $data['url'] . "'>" . $data['name'] . "</a></div>";
		echo "<div class='table-cell'><img src='" . $data['img'] . "' /></div>";
		echo "</div>";
	}
	echo "</div>";
?>