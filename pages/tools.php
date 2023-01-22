<?php
session_start();
include_once '../dbconnect.php';

	if (isset($_SESSION['odontoUserSession_ID']))
	{
	  $query = $DBcon->query("SELECT user_type FROM access WHERE id=".$_SESSION['odontoUserSession_ID']);
	  $userRow=$query->fetch_array();
	  
		if ($userRow['user_type'] != 'root' and $userRow['user_type'] != 'admin')
		  header("Location: ../index.php");
		  
	  $DBcon->close();	
	}else
	  header("Location: ../index.php");
?>
<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../css/main.css?version=1">
	<title>Odontologia Especializada</title> 
  </head>
  
  <script language="javascript">
	function AreYouSure(form)
	{
	  return confirm('Tem certeza de que deseja deletar?');
	}
  </script>
  
<body>
  <div id="wrapper"> <!-- Divisão, corpo da página inteira. -->

	<div id="header" class="no-print"> <!-- Cabeçalho. -->
   	  <?php $nb = file_get_contents('./default/navbar.html'); echo $nb; ?>
	</div> <!-- Fim Cabeçalho. -->
		
    <div id="content"> <!-- Corpo da página. -->
	
		<?php
		
		function phpAlert($msg) {  echo '<script type="text/javascript">alert("' . $msg . '")</script>';  }
		  
		  if (isset($_POST['redo_id_user'])) {
			// MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }			  
				 
				  $DBcon->query("ALTER TABLE `access` DROP `id`");
				  $DBcon->query("ALTER TABLE `access` AUTO_INCREMENT = 0");
				  $DBcon->query("ALTER TABLE `access` ADD `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");				  
					
					phpAlert("Reordenado com Sucesso!");

			// Closing the DB connection
			$DBcon->close();
		  }
		  
		  if (isset($_POST['add_user'])) {
			// User Data
			  $type = strip_tags($_POST['type']);
			  $user = strip_tags($_POST['user']);
			  $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $line = $DBcon->query("INSERT INTO `access` (`id`, `user_type`, `username`, `password`) VALUES (NULL, '$type', '$user', '$pass');");		  
			  
				if ($line)				
					echo '<span class="server_response">'. $user .' cadastrado!</span>';
				  else
					echo '<span class="server_response">Erro ao cadastrar...</span>';
				  

			  // Closing the DB connection
				$DBcon->close();
		  }
		  
		  if (isset($_POST['edit_user'])) {
			// User Data
			  $ID	= htmlspecialchars($_POST["id"]);
			  $type = strip_tags($_POST['type']);
			  $user = strip_tags($_POST['user']);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				 
				  $line = $DBcon->query("UPDATE `access` SET `user_type` = '$type', `username` = '$user' WHERE `access`.`id` = $ID");						
					  
				if ($line)				
					echo '<span class="server_response">'. $user .' atualizado!</span>';
				  else
					echo '<span class="server_response">Erro ao atualizar...</span>';
				  

			  // Closing the DB connection
				$DBcon->close();
		  }	  
		  
		  if (isset($_POST['edit_pass'])) {
			$_SESSION['odontoUserSession_IdForPasswordChange'] = htmlspecialchars($_POST["id"]);
			header("Location: password.php");
		  }
		  
		  if (isset($_POST['del_user'])) {
		    // User Data
			  $ID = htmlspecialchars($_POST["id"]);
			  $user = strip_tags($_POST['user']);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $line = $DBcon->query("DELETE FROM `access` WHERE `access`.`id` = $ID");
			  
				if ($line)
				  echo '<span class="server_response">'. $user .' deletado!</span>';
				else
				  echo '<span class="server_response">Erro ao deletar...</span>';

			  // Closing the DB connection
				$DBcon->close();
		  }		  
		  		
		  if (isset($_POST['redo_id_doc'])) {
			// MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }			  
				 
				  $DBcon->query("ALTER TABLE `doctors` DROP `id`");
				  $DBcon->query("ALTER TABLE `doctors` AUTO_INCREMENT = 1");
				  $DBcon->query("ALTER TABLE `doctors` ADD `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");				  
					
					echo '<span class="server_response">Reordenado com Sucesso!</span>';

			// Closing the DB connection
			$DBcon->close();
		  }
		  
		  if (isset($_POST['add_doc'])) {
			// Doc Data
			  $Name = htmlspecialchars($_POST["dentist"]);
			  $Specialty = htmlspecialchars($_POST["specialty"]);
			  $CRO = htmlspecialchars($_POST["cro"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $line = $DBcon->query("INSERT INTO `doctors` (`id`, `name`, `specialty`, `cro`) VALUES (NULL, '$Name', '$Specialty', '$CRO');");		  
			  
				if ($line)				
					echo '<span class="server_response">'. $Name .' cadastrado!</span>';
				  else
					echo '<span class="server_response">Erro ao cadastrar...</span>';
				  

			  // Closing the DB connection
				$DBcon->close();
		  }
		  
		  if (isset($_POST['edit_doc'])) {
			// User Data
			  $ID = htmlspecialchars($_POST["id"]);
			  $Name = htmlspecialchars($_POST["dentist"]);
			  $Specialty = htmlspecialchars($_POST["specialty"]);
			  $CRO = htmlspecialchars($_POST["cro"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $line = $DBcon->query("UPDATE `doctors` SET `name` = '$Name', `specialty` = '$Specialty', `cro` = '$CRO' WHERE `doctors`.`id` = $ID");
			  
				if ($line)				
					echo '<span class="server_response">'. $Name .' atualizado!</span>';
				  else
					echo '<span class="server_response">Erro ao atualizar...</span>';
				  

			  // Closing the DB connection
				$DBcon->close();
		  }	  
		  
		  if (isset($_POST['del_doc'])) {
		    // User Data
			  $ID = htmlspecialchars($_POST["id"]);
			  $Name = htmlspecialchars($_POST["dentist"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $line = $DBcon->query("DELETE FROM `doctors` WHERE `doctors`.`id` = $ID");
			  
				if ($line)
				  echo '<span class="server_response">'. $Name .' deletado!</span>';
				else
				  echo '<span class="server_response">Erro ao deletar...</span>';

			  // Closing the DB connection
				$DBcon->close();
		  }		  
		  
		  if (isset($_POST['redo_id_types'])) {
			// MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }			  
				 
				  $DBcon->query("ALTER TABLE `types` DROP `id`");
				  $DBcon->query("ALTER TABLE `types` AUTO_INCREMENT = 1");
				  $DBcon->query("ALTER TABLE `types` ADD `id` int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
					
					echo '<span class="server_response">Reordenado com Sucesso!</span>';

			// Closing the DB connection
			$DBcon->close();
		  }

		  if (isset($_POST['add_type'])) {
			// Type Data
			  $Name = htmlspecialchars($_POST["name"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $line = $DBcon->query("INSERT INTO `types` (`id`, `name`) VALUES (NULL, '$Name');");		  
			  
				if ($line)				
					echo '<span class="server_response">'. $Name .' cadastrado!</span>';
				  else
					echo '<span class="server_response">Erro ao cadastrar...</span>';
				
			  // Closing the DB connection
				$DBcon->close();
		  }

		  if (isset($_POST['edit_type'])) {
			// Type Data
			  $ID = htmlspecialchars($_POST["id"]);
			  $Name = htmlspecialchars($_POST["name"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				   $line = $DBcon->query("UPDATE `types` SET `name` = '$Name' WHERE `types`.`id` = $ID");
			  
				if ($line)				
					echo '<span class="server_response">'. $Name .' atualizado!</span>';
				  else
					echo '<span class="server_response">Erro ao atualizar...</span>';
				
			  // Closing the DB connection
				$DBcon->close();
		  }	
		  
		  if (isset($_POST['del_type'])) {
		    // User Data
			  $ID = htmlspecialchars($_POST["id"]);
			  $Name = htmlspecialchars($_POST["name"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $line = $DBcon->query("DELETE FROM `types` WHERE `types`.`id` = $ID");		  
			  
				if ($line)
				  echo '<span class="server_response">'. $Name .' deletado!</span>';
				else
				  echo '<span class="server_response">Erro ao deletar...</span>';
				  
			  // Closing the DB connection
				$DBcon->close();
		  }
		  
		  if (isset($_POST['add_cid'])) {
			// Type Data
			  $Name = htmlspecialchars($_POST["name"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $line = $DBcon->query("INSERT INTO `cids` (`id`, `name`) VALUES (NULL, '$Name');");		  
			  
				if ($line)				
					echo '<span class="server_response">'. $Name .' cadastrado!</span>';
				  else
					echo '<span class="server_response">Erro ao cadastrar...</span>';
				
			  // Closing the DB connection
				$DBcon->close();
		  }

		  if (isset($_POST['edit_cid'])) {
			// Type Data
			  $ID = htmlspecialchars($_POST["id"]);
			  $Name = htmlspecialchars($_POST["name"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				   $line = $DBcon->query("UPDATE `cids` SET `name` = '$Name' WHERE `cids`.`id` = $ID");
			  
				if ($line)				
					echo '<span class="server_response">'. $Name .' atualizado!</span>';
				  else
					echo '<span class="server_response">Erro ao atualizar...</span>';
				
			  // Closing the DB connection
				$DBcon->close();
		  }	
		  
		  if (isset($_POST['del_cid'])) {
		    // User Data
			  $ID = htmlspecialchars($_POST["id"]);
			  $Name = htmlspecialchars($_POST["name"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $line = $DBcon->query("DELETE FROM `cids` WHERE `cids`.`id` = $ID");		  
			  
				if ($line)
				  echo '<span class="server_response">'. $Name .' deletado!</span>';
				else
				  echo '<span class="server_response">Erro ao deletar...</span>';
				  
			  // Closing the DB connection
				$DBcon->close();
		  }

		  if (isset($_POST['cleanUp_agenda'])) {
		  // User Data
			$Di = htmlspecialchars($_POST["date_i"]);		$Df = htmlspecialchars($_POST["date_f"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $DBcon->query("DELETE FROM `agenda` WHERE `date` BETWEEN '$Di' AND '$Df'");
				  $result = $DBcon->query("SELECT * FROM `agenda` WHERE `date` BETWEEN '$Di' AND '$Df'");
			  
				if ($row = $result->fetch_row())				
					echo '<span class="server_response">Erro ao limpar agenda...</span>';	
				  else
					echo '<span class="server_response">Agenda limpa!</span>';

			  // Closing the DB connection
				$DBcon->close();
		  }	

		  if (isset($_POST['cleanUp_finances'])) {
		  // User Data
			$Di = htmlspecialchars($_POST["date_i"]);		$Df = htmlspecialchars($_POST["date_f"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $DBcon->query("DELETE FROM `finances` WHERE `date` BETWEEN '$Di' AND '$Df'");					
				  $result = $DBcon->query("SELECT * FROM `finances` WHERE `date` BETWEEN '$Di' AND '$Df'");
			  
				if ($row = $result->fetch_row())
					echo '<span class="server_response">Erro ao limpar financeiro...</span>';
				  else
					echo '<span class="server_response">Financeiro limpo!</span>';
				  
			  // Closing the DB connection
				$DBcon->close();
		  }			  
		
		// MySQL Connection  
		$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
		  if ($DBcon->connect_errno) {
			die("ERROR : -> ".$DBcon->connect_error);
		  }
				 
		  $query = $DBcon->query("SELECT user_type FROM access WHERE id=".$_SESSION['odontoUserSession_ID']);
		  $userRow=$query->fetch_array();  
		  $DBcon->close();
		  
			if ($userRow['user_type'] == 'root')
			{
		?>
		
	  <div style="margin-left: 187.25px; margin-bottom: 25px;"> <!-- Administradores -->
		<form class='toollabel' style="width: 600px;" method='post' action=''>
			<img class='icon' src='../img/briefcase.png'>
			Gerenciar Administradores

		  <button id='imgbut' type='submit' name='redo_id_user'>
			<img class='icon' src='../img/redo.png'>
			Reordenar IDs
		  </button>			  
		</form>
	  
	    <div id='container' style="width: 600px;">
		  <?php
			// MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $query = $DBcon->query("SELECT * FROM `access`");
					
					    echo '<div class="line">
								<span class="cell" style="width:100px; text-align: center;">ID</span>
								<span class="cell" style="width:70px; margin-left: 5px;">TIPO</span>
								<span class="cell" style="width:170px;">NOME</span>
							  </div>';
					
					while($array = $query->fetch_array())
					{
						$ID = sprintf("%04d", $array[0]);
		  ?>
					    <form class="line_doc" method="post" action="">
						  <input type="text" name="id" class="cell" style="width:100px; text-align: center;" value="<?php echo $ID; ?>">
						  <input type="text" name="type" class="cell" placeholder="Tipo" required="required" style="width:70px;" value="<?php echo $array[1] ?>">
						  <input type="text" name="user" class="cell" placeholder="Usuário" required="required" style="width:170px;" value="<?php echo $array[2] ?>">
							<span class="cell" style="margin-left: 30px; width:184.5px;">
							  <button style="background: none; display: inline-block;" type="submit" name="edit_pass">
								<img style="width: 30px;" src="../img/key.png">
							  </button>							
							  <button style="background: none; display: inline-block;" type="submit" name="edit_user">
								<img style="width: 30px;" src="../img/save.png">
							  </button>
							  <button style="background: none; display: inline-block;" type="submit" name="del_user" onclick="return AreYouSure(this);">
								<img style="width: 30px;" src="../img/trash.png">
							  </button>
						    </span>
						</form>
		  <?php
					}
					$query->free();
					
				// Closing the DB connection
				$DBcon->close(); 
		  ?>
		  
			<form class="line_doc" method="post" action="">
			  <span class="cell" style="width:100px; text-align: center;"> ???? </span>
			  
			    <input type="text" name="type" class="cell" placeholder="Tipo" style="width:70px;">
			  
			    <input type="text" name="user" class="cell" placeholder="Usuário" required="required" style="width:170px;">
			    <input type="password" name="pass" class="cell" placeholder="Senha" required="required" style="width:120px;">
				
				<span class="cell">
				  <button style="background: none; display: inline-block;" type="submit" name="add_user">
					<img style="width: 30px;" src="../img/add_doc.png">
				  </button>
				</span>				
			</form>			
		</div>		
	  </div>
		  <?php
			} //Closing ROOT CHECK.
		  ?>	  
		<form class='toollabel' method='post' action=''> <!-- Dentistas -->
			<img class='icon' src='../img/doctor.png'>
			Gerenciar Dentistas

		  <button id='imgbut' type='submit' name='redo_id_doc'>
			<img class='icon' src='../img/redo.png'>
			Reordenar IDs
		  </button>			  
		</form>
	  
	    <div id='container'>
		  <?php
			// MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $query = $DBcon->query("SELECT * FROM `doctors`");
					
					    echo '<div class="line">
								<span class="cell" style="width:100px; text-align: center;">ID</span>
								<span class="cell" style="width:285px; margin-left: 5px;">NOME</span>
								<span class="cell" style="width:270px; text-align: center;">ESPECIALIDADE</span>
								<span class="cell" style="width:100px; text-align: center;">CRO</span>
							  </div>';
					
					while($array = $query->fetch_array())
					{
						$ID = sprintf("%04d", $array[0]);
		  ?>
					    <form class="line_doc" method="post" action="">
						  <input type="text" name="id" class="cell" style="width:100px; text-align: center;" value="<?php echo $ID; ?>">
						  <input type="text" name="dentist" class="cell" placeholder="Nome" required="required" style="width:290px;" value="<?php echo $array[1] ?>">
						  <input type="text" name="specialty" class="cell" placeholder="Especialidade" required="required" style="width:270px; text-align: center;" value="<?php echo $array[2] ?>">
						  <input type="number" name="cro" class="cell" maxlength="5" placeholder="CRO" required="required" style="width:100px; text-align: center;" value="<?php echo $array[3] ?>">
							<span class="cell" style="width:123px;">
							  <button style="background: none; display: inline-block;" type="submit" name="edit_doc">
								<img style="width: 30px;" src="../img/save.png">
							  </button>
							  <button style="background: none; display: inline-block;" type="submit" name="del_doc" onclick="return AreYouSure(this);">
								<img style="width: 30px;" src="../img/trash.png">
							  </button>
						    </span>
						</form>
		  <?php
					}
					$query->free();
					
				// Closing the DB connection
				$DBcon->close();
		  ?>
		  
			<form class="line_doc" method="post" action="">
			  <span class="cell" style="width:100px; text-align: center;"> ???? </span>
			  
			    <input type="text" name="dentist" class="cell" placeholder="Nome" required="required" style="width:290px; height:25px;">
			  
			    <input type="text" name="specialty" class="cell" placeholder="Especialidade" required="required" style="width:270px; height:25px;">
			  
			    <input type="number" name="cro" class="cell" maxlength="5" placeholder="CRO" required="required" style="width:100px; height:25px;">
				
				<span class="cell" style="width:123px;">
				  <button style="background: none; display: inline-block;" type="submit" name="add_doc">
					<img style="width: 30px;" src="../img/add_doc.png">
				  </button>
				</span>				
			</form>			
		</div>
		
		<div id="tool"> <!-- Procedimentos -->
		  <form class="toollabel" method="post" action="">
			  <img class="icon" src="../img/tooth.png">
			  Gerenciar Procedimentos

			<button id="imgbut" type="submit" name="redo_id_types">
			  <img class="icon" src="../img/redo.png">
			  Reordenar IDs
			</button>			  
		  </form>
	  
	    <div id="container">
		  <?php
			// MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $query = $DBcon->query("SELECT * FROM `types`");
					
					    echo '<div class="line">
								<span class="cell" style="width:100px; text-align: center;">ID</span>
								<span class="cell" style="width:345px; margin-left: 5px;">NOME</span>
							  </div>';
					
					while($array = $query->fetch_array())
					{
						$ID = sprintf("%04d", $array[0]);
		  ?>	
					    <form class="line_doc" method="post" action="">
						 <input type="text" name="id" class="cell" style="width:100px; text-align: center;" value="<?php echo $ID; ?>">
						 <input type="text" name="name" class="cell" style="width:235px;" value="<?php echo $array[1] ?>">
						  <span class="cell" style="width:110px;">
							<button style="background: none; display: inline-block;" type="submit" name="edit_type">
							  <img style="width: 30px;" src="../img/save.png">
							</button>
							<button style="background: none; display: inline-block;" type="submit" name="del_type" onclick="return AreYouSure(this);">
							  <img style="width: 30px;" src="../img/trash.png">
							</button>
						  </span>
						</form>
		  <?php
					}
			
			$query->free();
			
		  // Closing the DB connection
		  $DBcon->close();
		  ?>
		  
			<form class='line_doc' method='post' action=''>
			  <span class='cell' style='width:100px; text-align: center;'> ???? </span>
			  
			    <input type='text' name='name' class='cell' placeholder="Nome" required="required" style='width:235px; height:25px;'>
				
				<span class='cell' style='width:110px;'>
				  <button style='background: none; display: inline-block;' type='submit' name='add_type'>
					<img style='width: 30px;' src='../img/add_tooth.png'>
				  </button>
				</span>				
			</form>
			
		</div>
	  </div>
	  
		<div id="tool"> <!-- CIDs -->
		  <form class="toollabel" method="post" action="">
			  <img class="icon" src="../img/book.png">
			  Gerenciar CIDs

			<button id="imgbut" type="submit" name="redo_id_types">
			  <img class="icon" src="../img/redo.png">
			  Reordenar IDs
			</button>			  
		  </form>
	  
	    <div id="container">
		  <?php
			// MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $query = $DBcon->query("SELECT * FROM `cids`");
					
					    echo '<div class="line">
								<span class="cell" style="width:100px; text-align: center;">ID</span>
								<span class="cell" style="width:345px; margin-left: 5px;">Nº do CID</span>
							  </div>';
					
					while($array = $query->fetch_array())
					{
						$ID = sprintf("%04d", $array[0]);
		  ?>	
					    <form class="line_doc" method="post" action="">
						 <input type="text" name="id" class="cell" style="width:100px; text-align: center;" value="<?php echo $ID; ?>">
						 <input type="text" name="name" class="cell" style="width:235px;" value="<?php echo $array[1] ?>">
						  <span class="cell" style="width:110px;">
							<button style="background: none; display: inline-block;" type="submit" name="edit_cid">
							  <img style="width: 30px;" src="../img/save.png">
							</button>
							<button style="background: none; display: inline-block;" type="submit" name="del_cid" onclick="return AreYouSure(this);">
							  <img style="width: 30px;" src="../img/trash.png">
							</button>
						  </span>
						</form>
		  <?php
					}
			
			$query->free();
			
		  // Closing the DB connection
		  $DBcon->close();
		  ?>
		  
			<form class='line_doc' method='post' action=''>
			  <span class='cell' style='width:100px; text-align: center;'> ???? </span>
			  
			    <input type='text' name='name' class='cell' placeholder="Nome" required="required" style='width:235px; height:25px;'>
				
				<span class='cell' style='width:110px;'>
				  <button style='background: none; display: inline-block;' type='submit' name='add_cid'>
					<img style='width: 30px;' src='../img/add_book.png'>
				  </button>
				</span>				
			</form>
			
		</div>
	  </div>	  
		
		<div id='tool'> <!-- Banco de Dados -->
		  <form method='post' action=''>

			<div class='toollabel'>
				<img class='icon' src='../img/broom.png'>
				Limpeza de Banco de Dados
			</div>
		  
			<div id='container' class=''>

			  <span style="color:#057c5c; font-family:Tahoma; font-size:13px; font-weight:bold;">
			    De <input type="date" name="date_i" value="<?php $M = date("Y-m-d", strtotime('-1 month')); echo $M;?>" required="required" style="height:25px;">
			    à	 <input type="date" name="date_f" value="<?php $Today = date("Y-m-d");echo $Today;?>" required="required" style="height:25px;">
			  </span>
			  
			  <div style='margin-top: 30px;'>
				<button id='imgbut' style='color: grey;' type='submit' name='cleanUp_finances' onclick="return AreYouSure(this);">
				  <img class='icon' src='../img/trashdb.png'>
				  Limpar Financeiro
				</button>			  
				<button id='imgbut' style='color: grey;' type='submit' name='cleanUp_agenda' onclick="return AreYouSure(this);">
				  <img class='icon' src='../img/trashdb.png'>
				  Limpar Agenda
				</button>
			  </div>
				
			</div>
			
		  </form>	  
		</div>
		
    </div>  <!-- Fim Corpo da página. -->
    
	<div id="footer"><!-- Rodapé. -->
	  Developed by Isaque Costa.<br>isaquecostaa@gmail.com
	</div><!-- Fim Rodapé. -->
	
  </div> <!-- Fim Divisão corpo da página. -->
</body>
</html>
