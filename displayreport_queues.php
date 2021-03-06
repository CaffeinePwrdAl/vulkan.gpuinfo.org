<?php
	/* 		
		*
		* Vulkan hardware capability database server implementation
		*	
		* Copyright (C) 2016-2018 by Sascha Willems (www.saschawillems.de)
		*	
		* This code is free software, you can redistribute it and/or
		* modify it under the terms of the GNU Affero General Public
		* License version 3 as published by the Free Software Foundation.
		*	
		* Please review the following information to ensure the GNU Lesser
		* General Public License version 3 requirements will be met:
		* http://www.gnu.org/licenses/agpl-3.0.de.html
		*	
		* The code is distributed WITHOUT ANY WARRANTY; without even the
		* implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
		* PURPOSE.  See the GNU AGPL 3.0 for more details.		
		*
	*/
	
	try {
		$stmnt = DB::$connection->prepare("SELECT * from devicequeues where reportid = :reportid");
		$stmnt->execute(array(":reportid" => $reportID));
		while($row = $stmnt->fetch(PDO::FETCH_NUM)) {
			echo "<table id='devicequeues-$index' class='table table-striped table-bordered table-hover responsive' style='width:100%;'>";
			echo "<thead>";
			echo "<tr><td colspan=2 class=tablehead>Queue family $index</td></tr>";
			echo "<tr>";
			echo "</thead><tbody>";
			for($i = 0; $i < count($row); $i++)
			{
				$meta = $stmnt->getColumnMeta($i);
				$fname = $meta["name"];			
				if (in_array($fname, array('id', 'reportid')))
					continue;
				$value = $row[$i];
				if ($fname == 'count') {
					$fname = 'queueCount';
				}
				if ($fname == 'flags') {
					echo "<tr><td width='25%'>$fname</td>";
					echo "<td>";
					$flags = getQueueFlags($value);
					listFlags($flags);
					echo "</td>";
				} else {
					echo "<tr><td width='25%'>$fname</td><td>$value</td></tr>\n";
				}
			}				
	
			echo "</tbody></table>";								
			$index++;			
		}
	} catch (Exception $e) {
		die('Error while fetching report features');
		DB::disconnect();
	}		
?>