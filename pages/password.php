<?php
session_start();
include_once '../dbconnect.php';

function phpAlert($msg) {  echo '<script type="text/javascript">alert("' . $msg . '")</script>';  }  

	if (isset($_SESSION['odontoUserSession_ID']))
	{
	  $query = $DBcon->query("SELECT user_type FROM access WHERE id=".$_SESSION['odontoUserSession_ID']);
	  $userRow=$query->fetch_array();
	  
		if ($userRow['user_type'] != 'root')
		  header("Location: ../index.php");
		  
	  $DBcon->close();	
	}else
	  header("Location: ../index.php");
  
	  if (isset($_POST['change_pass'])) {
		// User Data
		  $ID	= $_SESSION['odontoUserSession_IdForPasswordChange'];
			unset($_SESSION['odontoUserSession_IdForPasswordChange']);

		  $pass1 = strip_tags($_POST['password1']);
		  $pass2 = strip_tags($_POST['password2']);
	  
		  // MySQL Connection  
		   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
			
			 if ($DBcon->connect_errno) {
				 die("ERROR : -> ".$DBcon->connect_error);
			 }
			 
			 if ($pass1 != $pass2)
				phpAlert('As senhas não conferem!');
			 else
			 {
				$pass = password_hash($pass1, PASSWORD_DEFAULT);
				$query = $DBcon->query("UPDATE `access` SET `password` = '$pass' WHERE `access`.`id` = $ID");						
				  
				if ($query)
				{
				  phpAlert("Senha alterada com sucesso!");
				  header("Location: tools.php");
				}
				else
				  phpAlert('Erro inesperado, tente novamente...');
			 }

		  // Closing the DB connection
			$DBcon->close();
	  }
?>

<!DOCTYPE html>
<html >
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../css/main.css?version=1">
    <title>Odontologia Especializada</title> 
  </head>
  
  <body>
	<!-- Back Button -->	  
	<a style="float: left; margin: 5px;text-decoration: none;" id="imgbut" href="tools.php">
	  <img class="icon" src="../img/redo.png">
	  Voltar
	</a>
	
	<!-- Login Box -->	  
	<div id="login">
	  <form id="login-user" action="" method="post">
		
		<img src="../img/bigkey.png" class="logo">
		
		<input type="password" name="password1" placeholder="Nova Senha" required="required" tabindex="1" style="width: 250px; display: block; margin: 5px auto;">
		<input type="password" name="password2" placeholder="Repita a Senha" required="required" tabindex="2" style="width: 250px; display: block; margin: 5px auto;">
		
		<center>		
		  <input type="submit" name="change_pass" value="Alterar" tabindex="3" style="width: 250px; display: inline-block; margin: 5px auto; cursor: pointer;">
		</center>
		
	  </form>
	</div>
	
	<!-- Rodapé. -->
	<div id="footer" style="color: #057c5c; background: none;">
      Developed by Isaque Costa.<br>isaquecostaa@gmail.com
	</div>
  </body>
</html>