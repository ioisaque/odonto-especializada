<?phpsession_start();include_once '../dbconnect.php';	if (isset($_SESSION['odontoUserSession_ID']))	{	  $query = $DBcon->query("SELECT user_type FROM access WHERE id=".$_SESSION['odontoUserSession_ID']);	  $userRow=$query->fetch_array();	  		if ($userRow['user_type'] != 'root' and $userRow['user_type'] != 'admin')		  header("Location: ../index.php");		  	  $DBcon->close();		}else	  header("Location: ../index.php");?><!doctype html><html>  <head>    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	<link rel="shortcut icon" href="../img/icon.png" type="image/x-icon">	<link rel="stylesheet" type="text/css" href="../css/main.css?version=1">	<title>Odontologia Especializada</title>   </head>  <body>    <div id="wrapper"> <!-- Divisão, corpo da página inteira. -->		<div id="header" class="no-print"> <!-- Cabeçalho. -->   	  <?php $nb = file_get_contents('./default/navbar.html'); echo $nb; ?>	</div> <!-- Fim Cabeçalho. -->        <div id="content"> <!-- Corpo da página. -->		  <!-- Document Gen -->	  <form style='width: 350px; height: auto; position: absolute; top: 50%; left: 30%;  transform: translate(-50%,-50%); z-index: -1;' method='post' action='./docs/generate.php'>		<div id="subtitle">		  Gerar Atestado            <button id='imgbut' type="submit" name='atestado'>			  <img class="icon" src="../img/gear.png">			</button>		</div>	  	    <div id="container">				<p>			<label for="patient">Paciente</label><br>            <input type="text" name="patient" required="required" placeholder="Nome" style="width: 100%; height:25px;">		</p>		<p>			<label for="date">Data</label>			<label for="time" style='margin-left: 190px;'>Dias</label><br>						<input type="date" name="date" required="required" value="<?php $Today = date("Y-m-d");echo $Today;?>" style="width: 145px; height:25px;">			<input type="number" name="time" required="required" value='1' min='1' max='3' style="float: right; width: 100px; height:25px;">		</p>		<p>			<label for="CID">CID</label><br>					  <?php						// MySQL Connection  			  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);									if ($DBcon->connect_errno) {				  die("ERROR : -> ".$DBcon->connect_error);				}							echo '<select name="CID" required="required" style="width:100%; height:25px;">';								  					$query = $DBcon->query("SELECT * FROM `cids`");												  					  while($array = $query->fetch_array())					  {						  echo "<option value='$array[1]'>$array[1]</option>";					  }						$query->free();													echo '</select>';		  ?>					</p>				<p>		<label for="doc">Dentista</label><br>		  <?php						// MySQL Connection  			  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);									if ($DBcon->connect_errno) {				  die("ERROR : -> ".$DBcon->connect_error);				}							echo '<select name="doc" required="required" style="width:100%; height:25px;">';								  					$query = $DBcon->query("SELECT * FROM `doctors`");												  					  while($array = $query->fetch_array())					  {							  echo "<option value='$array[1]'>$array[1]</option>";					  }						$query->free();													echo '</select>';		  ?>		</p>		</div>	  </form>	  	  <form style='width: 350px; height: auto; position: absolute; top: 50%; left: 70%;  transform: translate(-50%,-50%); z-index: -1;' method='post' action='./docs/generate.php'>		<div id="subtitle">		  Gerar Declaração            <button id='imgbut' type="submit" name='declaracao'>			  <img class="icon" src="../img/gear.png">			</button>		</div>	  	    <div id="container">				<p>			<label for="patient">Paciente</label><br>            <input type="text" name="patient" required="required" placeholder="Nome" style="width: 100%; height:25px;">		</p>		<center>						Dia <input type="date" name="date" required="required" value="<?php $Today = date("Y-m-d");echo $Today;?>" style="width: 145px; height:25px;"><br><br>						De			<input type="time" name="time_i" required="required" style="width:auto; height:25px;">			às			<input type="time" name="time_f" required="required" style="width:auto; height:25px;">		</center>				<p>		<label for="doc">Assinatura</label><br>		  <?php						// MySQL Connection  			  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);									if ($DBcon->connect_errno) {				  die("ERROR : -> ".$DBcon->connect_error);				}							echo '<select name="ass" required="required" style="width:100%; height:25px;">				  <option value="Secretária" selected>Secretária</option>';								  					$query = $DBcon->query("SELECT * FROM `doctors`");												  					  while($array = $query->fetch_array())					  {							  echo "<option value='$array[1]'>$array[1]</option>";					  }						$query->free();													echo '</select>';					  ?>		</p>		</div>	  </form>	  	      </div>  <!-- Fim Corpo da página. -->    	<div id="footer" class="no-print"><!-- Rodapé. -->	  Developed by Isaque Costa.<br>isaquecostaa@gmail.com	</div><!-- Fim Rodapé. -->	  </div> <!-- Fim Divisão corpo da página. --></body></html>