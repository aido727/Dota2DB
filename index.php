<html lang="en" xml:lang="en">
	<head>
		<title>Dota 2 Items Database</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" href="images/icon.ico" />
		
		<meta name="DC.title" content="Dota 2 Items Database" />
		<meta name="DC.creator" content="Aidan Harney" />
		<meta name="DC.date.created" content="3-May-2013" />
		<meta name="DC.language" content="en" />
		
		<!--Facebook tags-->
		<meta property="og:title" content="Dota 2 Items Database" />
		<meta property="og:url" content="http://dota2itemsdb.x10.mx/" />
		<meta property="og:description" content="Quick search and filtering for Dota 2 Items (and Heroes)" />
		<meta property="og:image" content="http://dota2itemsdb.x10.mx/images/logo.png" />
		
		<?php
			ini_set("display_errors", 0);
			ini_set("log_errors", 1);
			
			include "scripts/global.php";
			include "scripts/functions.php";
			include "scripts/functions.js";
			include "scripts/db_connect.php";
		?>

	</head>
	<body>
		<?php include_once("scripts/analyticstracking.php") ?>
		<div id="wrapper">
			<div id="header">
				<?php include "display/header.php";?>
			</div>
			<div id="main">
				<?php
				if ($connection_result == 1)
				{
					//database is NOT connected
					echo $connection_message . "<br/>";
				}
				else
				{
					//database is connected
					echo "</br>"; //required to keep page out from under the header, table css adds much space at top
					$go = (!empty($_GET['go']) ? $_GET['go'] : null);
					if($go == "")
					{
						$page = "display/home.php";
						include $page;
					}
					else
					{
						$page = "display/" . $_GET['go'] . ".php";
						if (file_exists($page))
						{
							include $page;
						}
						else
						{
								include "display/404.php";
						}
					}
				}
				
				//remove double occurance on itemgroup
				if($go != "itemgroup")
				{
					echo "<hr/>";
				}
				?>
				<div id="footer">
					<?php include "display/footer.php";?>
				</div>
			</div>
		</div>
	</body>
</html> 