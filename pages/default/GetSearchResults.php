<?php
session_start();
include_once '../../dbconnect.php';

 // MySQL Connection  
	$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
	  if ($DBcon->connect_errno) {
		die("ERROR : -> ".$DBcon->connect_error);
	  }

		$Name = htmlspecialchars($_POST["search"]);	
		
		if ($query = $DBcon->query("SELECT name FROM patients WHERE name LIKE '%$Name%' LIMIT 5"))
		
		  while ($array = $query->fetch_array())
		  {						
			 ?>

		<!-- Creating unordered list items.
			ByCalling javascript function named as "fill" found in "script.js" file.
			By passing fetched result as parameter. -->

			<div onclick='fill("<?php echo $array['name']; ?>")'>
					<!-- Assigning searched result in "Search box" in "search.php" file. -->
					<?php echo $array['name']; ?>
			</div>

			<!-- Below php code is just for closing parenthesis. Don't be confused. -->
			<?php		
		  }
	
	$DBcon->close();		  
?>