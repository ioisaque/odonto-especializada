<?php
session_start();
require_once 'dbconnect.php';

  if (isset($_SESSION['odontoUserSession_ID'])!="")
  {
  header("Location: pages/home.php");
  exit;
  }
  
  function phpAlert($msg) {  echo '<script type="text/javascript">alert("' . $msg . '")</script>';  }

  if (isset($_POST['btn-login']))
  {
  
  $username = strip_tags($_POST['username']);
  $password = strip_tags($_POST['password']);
  
  $username = $DBcon->real_escape_string($username);
  $password = $DBcon->real_escape_string($password);
  
  $query = $DBcon->query("SELECT ID, username, password FROM access WHERE username='$username'");
  
  if ($query != false)
  {
    $row=$query->fetch_array();
    $count = $query->num_rows; // if username/password are correct returns must be 1 row
  }else
    $count = 0;
  
  
  if (password_verify($password, $row['password']) && $count==1) {
    $_SESSION['odontoUserSession_ID'] = $row['ID'];
    $_SESSION['odontoUserSession_Name'] = $row['username'];
    header("Location: pages/home.php");
  } else {
    phpAlert('Usuário ou senha inválidos!');
  }
  $DBcon->close();
  }

  if (isset($_POST['btn-register']))
  {
  
  $username = strip_tags($_POST['username']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  
  $user = $DBcon->query("SELECT `username` FROM `access` WHERE `username` = '$username'");
  
  if ($user->fetch_array())
    {
	  phpAlert('Nome de usuário já cadastrado, escolha outro!');
	  $DBcon->close();
	}
  else
    {
	  $query = $DBcon->query("INSERT INTO access (id, username, password) VALUES (NULL, '$username', '$password') ");
	  
	  if ($query != false)
	  {    
		phpAlert('Usuário cadastrado!');
	  }else
		phpAlert('Error ao cadastrar usuário, tente novamente!');
	  
	  $DBcon->close();
	  }
	}
	
  if (isset($_POST['btn-guest']))
  {
    $_SESSION['odontoUserSession_ID'] = "0";
    $_SESSION['odontoUserSession_Name'] = "Convidado";
	
      header("Location: pages/home.php");
      phpAlert('Bem Vindo!');
	
	$DBcon->close();
  }	
?>

<!DOCTYPE html>
<html >
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="./img/icon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <title>Odontologia Especializada</title> 
  </head>
  
  <body>
	<!-- Back Button -->	  
	<a style="float: left; margin: 5px;text-decoration: none;" id="imgbut" href="../../">
	  <img class="icon" src="./img/redo.png">
	  Voltar
	</a>
	<!-- Login Box -->	  
	<div id="login">
	  <form id="login-user" action="" method="post">
		
		<img src="./img/logo.png" class="logo">
		
		<input type="text" name="username" placeholder="Usuário" required="required" tabindex="1" style="width: 250px; display: block; margin: 5px auto;">
		<input type="password" name="password" placeholder="Senha" required="required" tabindex="2" style="width: 250px; display: block; margin: 5px auto;">
		
		<center>		
		  <input type="submit" name="btn-login" value="Acessar" tabindex="3" style="width: 250px; display: inline-block; margin: 5px auto; cursor: pointer;">
		</center>
		
	  </form>
	  
		<form action="" method="post">
		  <input type="submit" id="login-guest" name="btn-guest" style="padding: 5px; display: inline-block; cursor: pointer;" value="Entrar como convidado...">
		</form>
	</div>
	
	<!-- Rodapé. -->
	<div id="footer" style="color: #057c5c; background: none;">
      Developed by Isaque Costa.<br>isaquecostaa@gmail.com
	</div>
  </body>
</html>