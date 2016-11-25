<?php
	include ('common.header.php');

	include ('common.topmenu.php');
	
	include ('common.library.php');
	
	include ('db.vars.php');
			
	echo "<div class='clear'></div>";
	
	//closing div id='content'
	echo "</div>";
	
	include ('common.footer.php');
	
	//closing div id=outer
	echo "</div>";
	
	echo "<script>";
	echo 'window.location.replace("'.url().'/mssqladmin/Configuration.php'.'");';
	
	echo "</script>";
	
	echo "</body></html>";

?>
