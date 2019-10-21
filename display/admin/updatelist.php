<?php
	$continue = true;
	$DBday = file_get_contents('data/currentdataversion.txt', NULL, NULL, 0, 2);
	$DBmonth = file_get_contents('data/currentdataversion.txt', NULL, NULL, 2, 2);
	$DByear = file_get_contents('data/currentdataversion.txt', NULL, NULL, 4, 4);
	$day = file_get_contents('data/currentliveversion.txt', NULL, NULL, 0, 2);
	$month1 = file_get_contents('data/currentliveversion.txt', NULL, NULL, 2, 2);
	$year = file_get_contents('data/currentliveversion.txt', NULL, NULL, 4, 4);
	
	//while(intval($DBday) >= intval($day) || $DBmonth >= $month1 || $DByear >= $year)
	while(($year . $month1 . $day) > ($DByear . $DBmonth . $DBday))
	{
		switch ($month1)
		{
			case 1:
				$month = "January";
			break;
			
			case 2:
				$month = "February";
			break;
		
			case 3:
				$month = "March";
			break;
			
			case 4:
				$month = "April";
			break;
			
			case 5:
				$month = "May";
			break;
			
			case 6:
				$month = "June";
			break;
			
			case 7:
				$month = "July";
			break;
			
			case 8:
				$month = "August";
			break;
			
			case 9:
				$month = "September";
			break;
			
			case 10:
				$month = "October";
			break;
			
			case 11:
				$month = "November";
			break;
			
			case 12:
				$month = "December";
			break;
		}
		
		$url = "http://www.dota2wiki.com/wiki/" . $month . "_" . $day . ",_" . $year . "_Patch";
		echo "<br/><a href=\"" . $url . "\" title=\"" . $month . " " . $day . ", " . $year . " Patch Notes\">" . $month . " " . $day . ", " . $year . "</a>";
		
		$source = file_get_contents($url);
		$startindex = strpos($source,"&#160;<a href=\"/wiki/");
		$endindex = strpos(substr($source,$startindex),"_Patch\" title=\"");
		$string = substr(substr($source,$startindex),21,$endindex-21);
		unset($source);
		
		$day = substr($string,-8,2);
		$month = substr($string,0,strpos($string,"_"));
		$year = substr($string,-4,4);
		
		switch ($month)
		{
			case January:
				$month1 = "01";
			break;
			
			case February:
				$month1 = "02";
			break;
		
			case March:
				$month1 = "03";
			break;
			
			case April:
				$month1 = "04";
			break;
			
			case May:
				$month1 = "05";
			break;
			
			case June:
				$month1 = "06";
			break;
			
			case July:
				$month1 = "07";
			break;
			
			case August:
				$month1 = "08";
			break;
			
			case September:
				$month1 = "09";
			break;
			
			case October:
				$month1 = "10";
			break;
			
			case November:
				$month1 = "11";
			break;
			
			case December:
				$month1 = "12";
			break;
		}
		
		// if string fails, set live date to DB date to break loop
		if($string == null)
		{
			$day = $DBday;
			$month1 = $DBmonth;
			$year = $DByear;
			echo "<br/>Wiki is currently refusing access...";
		}
	}
?>