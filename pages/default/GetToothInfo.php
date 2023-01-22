<?php
session_start();
include_once '../../dbconnect.php';

	if (isset($_SESSION['odontoUserSession_ID']))
	{
	  $query = $DBcon->query("SELECT user_type FROM access WHERE id=".$_SESSION['odontoUserSession_ID']);
	  $userRow=$query->fetch_array();
	  
		if ($userRow['user_type'] != 'root' and $userRow['user_type'] != 'admin')
		  header("Location: ../index.php");
		  
	  $DBcon->close();	
	}else
	  header("Location: ../index.php");

 // MySQL Connection  
	$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
	  if ($DBcon->connect_errno) {
		die("ERROR : -> ".$DBcon->connect_error);
	  }

		$ID    = htmlspecialchars($_POST["id"]);
		$tooth = htmlspecialchars($_POST["tooth"]);		
		
		if ($query = $DBcon->query("SELECT $tooth FROM `odontograms` WHERE odontograms.id = '$ID'"))
		  if ($array = $query->fetch_array())
		  {						
			echo $array[$tooth];
			
			$query->free();
			$DBcon->close();			
		  }
?>