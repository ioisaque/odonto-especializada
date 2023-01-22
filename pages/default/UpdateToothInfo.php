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

		$ID    = (int) htmlspecialchars($_POST["id"]);
		$tooth = htmlspecialchars($_POST["tooth"]);
		$info  = htmlspecialchars($_POST["info"]);
		
		//print_r($_POST);
		//die();
		
		$UPDATE = $DBcon->query("UPDATE `odontograms` SET `$tooth` = '$info' WHERE `odontograms`.`id` = $ID");
		$CHECK = $DBcon->query("SELECT $tooth FROM odontograms WHERE odontograms.id = $ID");
		
		if ($UPDATE)	  
		  if ($CHECK)
		    if ($array = $CHECK->fetch_array())
			  if ($array[$tooth] == $info)
			    echo "Informações atualizadas!";
			  else
			    echo "Error ao atualizar...";

	   $DBcon->close();						
?>