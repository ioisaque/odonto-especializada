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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

	<script src="default/LiveSearch.js" language="javascript"></script>
	<script src="default/jquery.mask.js" language="javascript"></script>	
	
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
	
	function GetToothInfo(ID, T)
	{	  
		$.ajax({
		  type: "POST",
		  data: {id: ID, tooth: T},
		  datatype: "html",
		  url: "default/GetToothInfo.php",
		  success: function (data)
				   {
					 if (data == "")
					   document.getElementById("tooth_info").value = "Nenhum registro..."
					 else
					   document.getElementById("tooth_info").value = data
				   }
		});
	}

	function UpdateToothInfo(ID)
	{
	  I = $("#tooth_info").val();
	  T = $("#odontograma input[name='Tooth']:checked").val();
		
		$.ajax({
		  type: "POST",
		  data: {id: ID, tooth: T, info: I},
		  datatype: "html",
		  url: "default/UpdateToothInfo.php",
		  success: function (data) { alert(data); }
		});
	}	
  </script>   
  
<body>  
  <div id="wrapper"> <!-- Divisão, corpo da página inteira. -->

	<div id="header" class="no-print"> <!-- Cabeçalho. -->
	  <?php $nb = file_get_contents('./default/navbar.html'); echo $nb; ?>
	</div> <!-- Fim Cabeçalho. -->
	
    <div id="content"> <!-- Corpo da página. -->
  	
   	  <form action="" method="post">
        <!--onblur="$('#displayR').hide()"--><input id="sName" type="text" onfocus="$('#displayR').show()" name="name" placeholder="Nome do Paciente" required="required" autocomplete="off" style="width:265px; height:30px;">
		<button type="submit" name="get_patient" style="position: absolute;"><img class="icon" src="../img/go.png"></button>
	  </form>
		
		<div id="displayR"></div>
	  
		<?php
		function phpAlert($msg) {  echo '<script type="text/javascript">alert("' . $msg . '")</script>';  }
		
			  if (isset($_POST['get_patient']))
			  {
				$Name =	htmlspecialchars($_POST["name"]);
				
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
					
					if ($query = $DBcon->query("SELECT * FROM `patients` WHERE name LIKE '%$Name%'"))					
					  if ($row = $query->fetch_row())
					  {
						$ID = sprintf("%04d", $row[0]);
						setcookie("id", $ID, time()+120);
						
						$Name = $row[1];
						setcookie("name", $Name, time()+120);
						
						$Sex = $row[2];				$Address = $row[3];
						$Number = $row[4];			$District = $row[5];
						$CEP = $row[6];				$City = $row[7];
						$State = $row[8];			$Email = $row[9];
						$Phone = $row[10];			$Naturality = $row[11];
						$Nationality = $row[12];	$Nasc = $row[13];
						$RG = $row[14];				$CPF = $row[15];
						$Status = $row[16];			$Work = $row[17];
						$Sponsor = $row[18];
						
						$query->free();
		?>				
								<form method="post" action="">
								
									<div id="subtitle">
									  Paciente: <?php echo $ID; ?>
									  <input type="text" name="id" value="<?php echo $ID; ?>" style="display: none;">
									  
										<button id="imgbut" type="submit" name="get_anamnese">
										  <img class="icon" src="../img/heart.png">
										  Anamnese
										</button>
										<button id="imgbut" type="submit" name="get_tooth">
										  <img class="icon" src="../img/tooth.png">
										  Odontograma
										</button>										
									</div>
								  
									<div id="container">
									<p>
										<label for="name">Nome Completo</label>
										<label for="sex" style="margin-left: 310px;">Sexo</label><br>
										<input type="text" name="name" value="<?php echo $Name; ?>" style="width:400px; height:25px;">
										
										<select name="sex" style="width:100px; height:25px;">
		<?php							
									if ($Sex == 'Masculino')
										echo '<option value="Masculino" selected>Masculino</option> 
											  <option value="Feminino">Feminino</option>';
									else
										echo '<option value="Masculino">Masculino</option> 
											  <option value="Feminino" selected>Feminino</option>';
		?>
										</select>
									</p>
									
									<p>
										<label for='address'>Endereço</label>
										<label for='number' style='margin-left: 298px;'>Número</label><br>
										
										<input type='text' name='address' value='<?php echo $Address; ?>' placeholder='Rua/Av' style='width:350px; height:25px;'>
										<input type='text' name='number' value='<?php echo $Number; ?>' placeholder='Nº 00 / APT 000' style='width:150px; height:25px;'>
									</p>
									
									<p>
										<label for='district'>Bairro</label>
										<label for='cep' style='margin-left: 316px;'>CEP</label><br>
										
										<input type='text' name='district' value='<?php echo $District; ?>' placeholder='Bairro' style='width:350px; height:25px;'>
										<input type='text' name='cep' value='<?php echo $CEP; ?>' placeholder='55555-333' onKeyUp="$(this).mask('00000-000');" style='width:150px; height:25px;'>
									</p>		
									
									<p>
										<label for='city'>Cidade</label>
										<label for='state' style='margin-left: 313px;'>UF</label><br>
										
										<input type='text' name='city' value='<?php echo $City; ?>' placeholder='Cidade/Comarca' style='width:350px; height:25px;'>
										<input type='text' name='state' value='<?php echo $State; ?>' placeholder='Estado' style='width:150px; height:25px;'>
									</p>
									
									<p>
										<label for='email'>E-mail</label>
										<label for='phone' style='margin-left: 313px;'>Telefone/Celular</label><br>
										
										<input type='text' name='email' value='<?php echo $Email; ?>' placeholder='mail@exemplo.com.br' style='width:350px; height:25px;'>
										<input type='text' name='phone' value='<?php echo $Phone; ?>' placeholder='(00) 9 9999 9999' onKeyUp="$(this).mask('(00) 0 0000-0000');" style='width:150px; height:25px;'>
									</p>
									
									<p>
										<label for='naturality'>Naturalidade</label>
										<label for='nationality' style='margin-left: 178px;'>Nacionalidade</label><br>
										
										<input type='text' name='naturality' value='<?php echo $Naturality; ?>' placeholder='Cidade' style='width:250px; height:25px;'>
										<input type='text' name='nationality' value='<?php echo $Nationality; ?>' placeholder='País' style='width:250px; height:25px;'>
									</p>

									<p>
										<label for='rg'>RG</label>
										<label for='cpf' style='margin-left: 233px;'>CPF</label><br>
										
										<input type='text' name='rg' value='<?php echo $RG; ?>' placeholder='00.000.000' onKeyUp="$(this).mask('AA 00.000.000');" style='width:250px; height:25px;'>
										<input type='text' name='cpf' value='<?php echo $CPF; ?>' placeholder='000.000.000-00' onKeyUp="$(this).mask('000.000.000-00', {reverse: true});" style='width:250px; height:25px;'>
									</p>
									
									<p>										
										<label for='status'>Estado Civil</label>
										<label for='nasc' style='margin-left: 186px;'>Data de Nasc.</label><br>
										
										
										<select name="status" style="width:250px; height:25px;">
		<?php							
									if ($Status == 'Casado(a)')
										echo '<option value="Solteiro(a)">Solteiro(a)</option> 
											  <option value="Casado(a)" selected>Casado(a)</option>
											  <option value="Divorciado(a)">Divorciado(a)</option>
											  <option value="Viúvo(a)">Viúvo(a)</option>';
									else if ($Status == 'Divorciado(a)')
										echo '<option value="Solteiro(a)">Solteiro(a)</option> 
											  <option value="Casado(a)">Casado(a)</option>
											  <option value="Divorciado(a)" selected>Divorciado(a)</option>
											  <option value="Viúvo(a)">Viúvo(a)</option>';
									else if ($Status == 'Viúvo(a)')
										echo '<option value="Solteiro(a)">Solteiro(a)</option> 
											  <option value="Casado(a)">Casado(a)</option>
											  <option value="Divorciado(a)">Divorciado(a)</option>
											  <option value="Viúvo(a)" selected>Viúvo(a)</option>';											  
									else if ($Status == 'Solteiro(a)')
										echo '<option value="Solteiro(a)" selected>Solteiro(a)</option> 
											  <option value="Casado(a)">Casado(a)</option>
											  <option value="Divorciado(a)">Divorciado(a)</option>
											  <option value="Viúvo(a)">Viúvo(a)</option>';									  
									else
										echo '<option value="Não especificado" selected>Não especificado</option> 
											  <option value="Solteiro(a)">Solteiro(a)</option>
											  <option value="Casado(a)">Casado(a)</option>
											  <option value="Divorciado(a)">Divorciado(a)</option>
											  <option value="Viúvo(a)">Viúvo(a)</option>';											  
		?>
										</select>
										
										<input type='date' name='nasc' value='<?php echo $Nasc; ?>' placeholder='Data de Nasc.' style='width:250px; height:25px;'>
									</p>

									<p>
										<label for='work'>Profissão</label><br>			
										<input type='text' name='work' value='<?php echo $Work; ?>' placeholder='Ocupação' style='width:250px; height:25px;'>
									</p>									
									
									<p>
										<label for='sponsor'>Nome do Responsável Completo</label><br>
										<input type='text' name='sponsor' value='<?php echo $Sponsor; ?>' style='width:500px; height:25px;'>
									</p>
									</div>
									
									<div id='navbar' style='margin-top: 20px;'>
										<button type='submit' name='up_patient' class='navtab'>
										  <img class='icon' src='../img/save.png'>
										  Atualizar
										</button>
										<button type='submit' name='del_patient' class='navtab' onclick='return AreYouSure(this);'>
										  <img class='icon' src='../img/trash.png'>
										  Deletar
										</button>
									</div>
								</form>
		<?php				
					  }else
						echo '<span class="server_response">Paciente não encontrado!</span>';
					  
				  // Closing the DB connection
				  $DBcon->close();
			  }

		  if (isset($_POST['up_patient'])) {
		    // User Data
			  $ID = htmlspecialchars($_POST["id"]);					$Name = htmlspecialchars($_POST["name"]);
			  $Sex = htmlspecialchars($_POST["sex"]);					$Address = htmlspecialchars($_POST["address"]);
			  $Number = htmlspecialchars($_POST["number"]);			$District = htmlspecialchars($_POST["district"]);
			  $CEP = htmlspecialchars($_POST["cep"]);					$City = htmlspecialchars($_POST["city"]);
			  $State = htmlspecialchars($_POST["state"]);				$Email = htmlspecialchars($_POST["email"]);
			  $Phone = htmlspecialchars($_POST["phone"]);				$Naturality = htmlspecialchars($_POST["naturality"]);
			  $Nationality = htmlspecialchars($_POST["nationality"]);	$Nasc = htmlspecialchars($_POST["nasc"]);
			  $RG = htmlspecialchars($_POST["rg"]);					$CPF = htmlspecialchars($_POST["cpf"]);
			  $Status = htmlspecialchars($_POST["status"]);			$Work = htmlspecialchars($_POST["work"]);
			  $Sponsor = htmlspecialchars($_POST["sponsor"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }

				 $query = $DBcon->query("UPDATE `patients` SET `name` = '$Name', `sex` = '$Sex', `address` = '$Address', `number` = '$Number',
						  `district` = '$District', `cep` = '$CEP', `city` = '$City', `state` = '$State', `email` = '$Email',
						  `phone` = '$Phone', `naturality` = '$Naturality', `nationality` = '$Nationality', `nasc` = '$Nasc', `RG` = '$RG',
						  `CPF` = '$CPF', `status` = '$Status', `work` = '$Work', `sponsor` = '$Sponsor'
						  WHERE `patients`.`ID` = $ID;");
			  
				if ($query)				
					echo '<span class="server_response">Dados do paciente '. $Name .' atualizados!</span>';
				  else
					echo $DBcon->error();
				  
				// Closing the DB connection
				$DBcon->close();
		  }
			  
		  if (isset($_POST['del_patient'])) {
			// User Data
			  $ID	=	htmlspecialchars($_POST["id"]);
			  $Name	=	htmlspecialchars($_POST["name"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
			  
				$query = $DBcon->query("DELETE FROM `patients` WHERE `ID` = $ID;");

				if ($query)				
					echo '<span class="server_response">Paciente ['. $ID .'] - '. $Name .' deletado!</span>';
				  else
					echo $DBcon->error();
				
				$query = $DBcon->query("DELETE FROM `anamnese` WHERE `ID` = $ID;");

				if ($query)				
					echo '<span class="server_response">Anamnese do paciente ['. $ID .'] - '. $Name .' deletada!</span>';
				  else
					echo $DBcon->error();

				$query = $DBcon->query("DELETE FROM `odontogramas` WHERE `ID` = $ID;");

				if ($query)				
					echo '<span class="server_response">Odontograma do paciente ['. $ID .'] - '. $Name .' deletado!</span>';
				  else
					echo $DBcon->error();

				// Closing the DB connection
				$DBcon->close();		  
		  }
			  
			  if (isset($_POST['get_anamnese']))
			  {
				$ID 	=	htmlspecialchars($_POST["id"]);
				$Name 	=	htmlspecialchars($_POST["name"]);
				
				  // MySQL Connection  
				   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
					
					 if ($DBcon->connect_errno) {
						 die("ERROR : -> ".$DBcon->connect_error);
					 }

					if ($query = $DBcon->query("SELECT * FROM `anamnese` WHERE `id` = '$ID'"))
					  if ($row = $query->fetch_row())
					  {
						$D1 = $row[2];					$D2 = $row[3];
						$D3 = $row[4];					$D4 = $row[5];
						$D5 = $row[6];					$D6 = $row[7];
						$D7 = $row[8];					$D8 = $row[9];
						$D9 = $row[10];					$D10 = $row[11];
						$tratamento = $row[12];			$remedio = $row[13];
						$gravidez = $row[14];			$medico = $row[15];
						$alergia = $row[16];			$cirurgia = $row[17];
						$cicatriz = $row[18];			$anestesia = $row[19];
						$hemorragia = $row[20];			$habitos = $row[21];
						$familia = $row[22];			$obs = $row[23];
		?>		  
					 <form method='post' action=''>
					  
						<div id='subtitle'>
						  Paciente: <?php echo $ID; ?>
						  <input type='text' name='id' value='<?php echo $ID; ?>' style='display: none;'>
						  
							<button id='imgbut' type='submit' name='get_patient'>
							  <img class='icon' src='../img/redo.png'>
							  Voltar
							</button>
							<button id='imgbut' type='submit' name='get_tooth'>
							  <img class='icon' src='../img/tooth.png'>
							  Odontograma
							</button>
						</div>
						
						<div id='container'>
						<p>
							<label for='name'>Nome Completo</label><br>
							<input type='text' name='name' value='<?php echo $Name; ?>' style='width:450px; height: 25px;'>
						</p>
						
						<p>
							<label>Sofre de alguma das seguintes doenças?</label>
							<br><br>
							
							<input type='hidden' value='false' name='D1'>
							<input type='hidden' value='false' name='D2'>
							<input type='hidden' value='false' name='D3'>
							<input type='hidden' value='false' name='D4'>
							<input type='hidden' value='false' name='D5'>
							<input type='hidden' value='false' name='D6'>
							<input type='hidden' value='false' name='D7'>
							<input type='hidden' value='false' name='D8'>
							<input type='hidden' value='false' name='D9'>
							<input type='hidden' value='false' name='D10'>
		<?php					
						if ($D1 != 'false')
						{
						echo '<input type="checkbox" name="D1" value="Febre Reumática" checked>~ Febre Reumática<br>';
						}else{
						echo '<input type="checkbox" name="D1" value="Febre Reumática">~ Febre Reumática<br>';					
						}
						
						if ($D2 != 'false')
						{
						echo '<input type="checkbox" name="D2" value="Problemas cardíacos" checked>~ Problemas cardíacos<br>';
						}else{
						echo '<input type="checkbox" name="D2" value="Problemas cardíacos">~ Problemas cardíacos<br>';					
						}

						if ($D3 != 'false')
						{
						echo '<input type="checkbox" name="D3" value="Problemas renais" checked>~ Problemas renais<br>';
						}else{
						echo '<input type="checkbox" name="D3" value="Problemas renais">~ Problemas renais<br>';					
						}

						if ($D4 != 'false')
						{
						echo '<input type="checkbox" name="D4" value="Problemas gástricos" checked>~ Problemas gástricos<br>';
						}else{
						echo '<input type="checkbox" name="D4" value="Problemas gástricos">~ Problemas gástricos<br>';					
						}
						
						if ($D5 != 'false')
						{
						echo '<input type="checkbox" name="D5" value="Problemas respiratórios" checked>~ Problemas respiratórios<br>';
						}else{
						echo '<input type="checkbox" name="D5" value="Problemas respiratórios">~ Problemas respiratórios<br>';					
						}

						if ($D6 != 'false')
						{
						echo '<input type="checkbox" name="D6" value="Problemas alérgicos"" checked>~ Problemas alérgicos<br>';
						}else{
						echo '<input type="checkbox" name="D6" value="Problemas alérgicos>~ Problemas alérgicos<br>';					
						}

						if ($D7 != 'false')
						{
						echo '<input type="checkbox" name="D7" value="Problemas articulares ou reumatismo" checked>~ Problemas articulares ou reumatismo<br>';
						}else{
						echo '<input type="checkbox" name="D7" value="Problemas articulares ou reumatismo">~ Problemas articulares ou reumatismo<br>';					
						}

						if ($D8 != 'false')
						{
						echo '<input type="checkbox" name="D8" value="Diabetes" checked>~ Diabetes<br>';
						}else{
						echo '<input type="checkbox" name="D8" value="Diabetes">~ Diabetes<br>';					
						}
							
						if ($D9 != 'false')
						{
						echo '<input type="checkbox" name="D9" value="Hipertensão arterial" checked>~ Hipertensão arterial<br>';
						}else{
						echo '<input type="checkbox" name="D9" value="Hipertensão arterial">~ Hipertensão arterial<br>';					
						}
						
						if ($D10 != 'false')
						{
						echo '<input type="checkbox" checked>~ Outra: <input type="text" name="D10" value="'. $D10 . '" style="width: 480px; height: 25px;">';
						}else{
						echo '<input type="checkbox">~ Outra: <input type="text" name="D10" style="width: 480px; height: 25px;">';					
						}
		?>
						</p>
						
						<p>
							<label for='tratamento'>Está em tratamento médico atualmente?</label><br>
							<input type='text' name='tratamento' value='<?php echo $tratamento; ?>' style='width: 215px; height: 25px;'>
						</p>		
						
						<p>
							<label for='remedio'>Está fazendo uso de alguma medicação?</label><br>
							<input type='text' name='remedio' value='<?php echo $remedio; ?>' style='width: 335px; height: 25px;'>
						</p>
		<?php				
						if ($gravidez == 'sim')
						{
						echo '<p>
							    <label for="gravidez">Gravidez?</label>
							    <input type="radio" name="gravidez" value="sim" checked> Sim
							    <input type="radio" name="gravidez" value="nao"> Não
							  </p>';
						}else{							
						echo '<p>
							    <label for="gravidez">Gravidez?</label>
							    <input type="radio" name="gravidez" value="sim"> Sim
							    <input type="radio" name="gravidez" value="nao" checked> Não
							  </p>';
						}
		?>						
						<p>	
							<label for='medico'>Nome/telefone do Médico assistente:</label><br>	
							<input type='text' name='medico' value='<?php echo $medico; ?>' style='width: 335px; height: 25px;'>
						</p>
						
						<p>
							<label for='alergia'>Tem alergia?</label><br>
							<input type='text' name='alergia' value='<?php echo $alergia; ?>' style='width: 335px; height: 25px;'>
						</p>

						<p>
							<label for='cirurgia'>Já foi operado?</label><br>
							<input type='text' name='cirurgia' value='<?php echo $cirurgia; ?>' style='width: 335px; height: 25px;'>
						</p>
						
						<p>
							<label for='anestesia'>Tem problemas com anestesia?</label><br>
							<input type='text' name='anestesia' value='<?php echo $anestesia; ?>' style='width: 335px; height: 25px;'>
						</p>
		<?php				
						if ($cicatriz == 'sim')
						{
						echo '<p>
							    <label for="cicatriz">Tem problemas com cicatrização?</label>
							    <input type="radio" name="cicatriz" value="sim" checked> Sim
							    <input type="radio" name="cicatriz" value="nao"> Não
							  </p>';
						}else{							
						echo '<p>
							    <label for="cicatriz">Tem problemas com cicatrização?</label>
							    <input type="radio" name="cicatriz" value="sim"> Sim
							    <input type="radio" name="cicatriz" value="nao" checked> Não
							  </p>';
						}
						
						if ($hemorragia == 'sim')
						{
						echo '<p>
							    <label for="hemorragia">Tem problemas de hemorragia?</label>
							    <input type="radio" name="hemorragia" value="sim" checked> Sim
							    <input type="radio" name="hemorragia" value="nao"> Não
							  </p>';
						}else{							
						echo '<p>
							    <label for="hemorragia">Tem problemas de hemorragia?</label>
							    <input type="radio" name="hemorragia" value="sim"> Sim
							    <input type="radio" name="hemorragia" value="nao" checked> Não
							  </p>';
						}
						
		?>						
						<p>
							<label for='habitos'>Hábitos: </label><br>
							<textarea name='habitos'style='width: 550px; height:70px; resize: none;'><?php echo $habitos; ?></textarea>
						</p>
						
						<p>
							<label for='familia'>Antecedentes Familiares: </label><br>
							<textarea name='familia' style='width: 550px; height:70px; resize: none;'><?php echo $familia; ?></textarea>
						</p>
						
						<p>
							<label for='obs'>Observações Importantes: </label><br>
							<textarea name='obs' style='width: 550px; height:70px; resize: none;'><?php echo $obs; ?></textarea>
						</p>
						</div>
						
						<div id='navbar' style='margin-top: 40px;'>		
							<button type='submit' name='up_anamnese' class='navtab'>
							  <img class='icon' src='../img/save.png'>
							  Salvar
							</button>
							<button type='submit' name='del_anamnese' class='navtab' onclick='return AreYouSure(this);'>
							  <img class='icon' src='../img/trash.png'>
							  Deletar
							</button>
						</div>
					</form>				  
		<?php		  
					  }
					  else
					  {
		?>
							<form method='post' action=''>
							  
								<div id='subtitle'>
								  Paciente: <?php echo $ID; ?>
								  <input type='text' name='id' value='<?php echo $ID; ?>' style='display: none;'>
								  
									<button id='imgbut' type='submit' name='get_patient'>
									  <img class='icon' src='../img/redo.png'>
									  Voltar
									</button>
									<button id='imgbut' type='submit' name='get_tooth'>
									  <img class='icon' src='../img/tooth.png'>
									  Odontograma
									</button>
								</div>
								
								<div id='container'>
								<p>
									<label for='id'>Paciente</label>
									<label for='name' style='margin-left:53px;'>Nome Completo</label><br>
									<input type='text' name='id' value='<?php echo $ID; ?>' style='width:100px; height: 25px;'>
									<input type='text' name='name' value='<?php echo $Name; ?>' style='width:450px; height: 25px;'>
								</p>
								
								<p>
									<label>Sofre de alguma das seguintes doenças?</label>
									<br><br>
									
									<input type='hidden' value='false' name='D1'>
									<input type='hidden' value='false' name='D2'>
									<input type='hidden' value='false' name='D3'>
									<input type='hidden' value='false' name='D4'>
									<input type='hidden' value='false' name='D5'>
									<input type='hidden' value='false' name='D6'>
									<input type='hidden' value='false' name='D7'>
									<input type='hidden' value='false' name='D8'>
									<input type='hidden' value='false' name='D9'>
									<input type='hidden' value='false' name='D10'>
									
									<input type='checkbox' name='D1' value='Febre Reumática'>~ Febre Reumática<br>			
									
									<input type='checkbox' name='D2' value='Problemas cardíacos'>~ Problemas cardíacos<br>
									
									<input type='checkbox' name='D3' value='Problemas renais'>~ Problemas renais<br>
									
									<input type='checkbox' name='D4' value='Problemas gástricos'>~ Problemas gástricos<br>			
									
									<input type='checkbox' name='D5' value='Problemas respiratórios'>~ Problemas respiratórios<br>			
									
									<input type='checkbox' name='D6' value='Problemas alérgicos'>~ Problemas alérgicos<br>			
									
									<input type='checkbox' name='D7' value='Problemas articulares ou reumatismo'>~ Problemas articulares ou reumatismo<br>			
									
									<input type='checkbox' name='D8' value='Diabetes'>~ Diabetes<br>			
									
									<input type='checkbox' name='D9' value='Hipertensão arterial'>~ Hipertensão arterial<br>		
									
									<input type='checkbox'>~ Outra: <input type='text' name='D10' placeholder='Expecifique.' style='width: 480px; height: 25px;'>
								</p>
								
								<p>
									<label for='tratamento'>Está em tratamento médico atualmente?</label><br>
									<input type='text' name='tratamento' placeholder='Não.' style='width: 215px; height: 25px;'>
								</p>		
								
								<p>
									<label for='remedio'>Está fazendo uso de alguma medicação?</label><br>
									<input type='text' name='remedio' placeholder='Não.' style='width: 335px; height: 25px;'>
								</p>
								
								<p>
									<label for='gravidez'>Gravidez?</label>
									<input type='radio' name='gravidez' value='sim'> Sim
									<input type='radio' name='gravidez' value='nao' checked> Não
								</p>
								
								<p>	
									<label for='medico'>Nome/telefone do Médico assistente:</label><br>	
									<input type='text' name='medico' style='width: 335px; height: 25px;'>
								</p>
								
								<p>
									<label for='alergia'>Tem alergia?</label><br>
									<input type='text' name='alergia' placeholder='Não.' style='width: 335px; height: 25px;'>
								</p>

								<p>
									<label for='cirurgia'>Já foi operado?</label><br>
									<input type='text' name='cirurgia' placeholder='Não.' style='width: 335px; height: 25px;'>
								</p>
								
								<p>
									<label for='anestesia'>Tem problemas com anestesia?</label><br>
									<input type='text' name='anestesia' placeholder='Não.' style='width: 335px; height: 25px;'>
								</p>
								
								<p>
									<label for='cicatriz'>Tem problemas com cicatrização?</label>
									<input type='radio' name='cicatriz' value='sim'> Sim
									<input type='radio' name='cicatriz' value='nao' checked> Não
								</p>

								<p>
									<label for='hemorragia'>Tem problemas de hemorragia?</label>
									<input type='radio' name='hemorragia' value='sim'> Sim
									<input type='radio' name='hemorragia' value='nao' checked> Não
								</p>
								
								<p>
									<label for='habitos'>Hábitos: </label><br>
									<textarea name='habitos' style='width: 550px; height:70px; resize: none;'></textarea>
								</p>
								
								<p>
									<label for='familia'>Antecedentes Familiares: </label><br>
									<textarea name='familia' style='width: 550px; height:70px; resize: none;'></textarea>
								</p>
								
								<p>
									<label for='obs'>Observações Importantes: </label><br>
									<textarea name='obs' style='width: 550px; height:70px; resize: none;'></textarea>
								</p>
								</div>
								
								<div id='navbar' style='margin-top: 40px;'>		
									<button type='submit' name='reg_anamnese' class='navtab'>
									  <img class='icon' src='../img/save.png'>
									  Salvar
									</button>
									<button type='reset' name='reset' class='navtab'>
									  <img class='icon' src='../img/trash.png'>
									  Limpar
									</button>
								</div>
							</form>
		<?php
			  }
				// Closing the DB connection
				$DBcon->close();		  
		  }
			  
		  if (isset($_POST['reg_anamnese'])) {
		  // User Data
			$ID 	=	htmlspecialchars($_POST["id"]);
			$Name 	=	htmlspecialchars($_POST["name"]);	  
		  
			$D1 = htmlspecialchars($_POST["D1"]);			$D2 = htmlspecialchars($_POST["D2"]);
			$D3 = htmlspecialchars($_POST["D3"]);			$D4 = htmlspecialchars($_POST["D4"]);
			$D5 = htmlspecialchars($_POST["D5"]);			$D6 = htmlspecialchars($_POST["D6"]);
			$D7 = htmlspecialchars($_POST["D7"]);			$D8 = htmlspecialchars($_POST["D8"]);
			$D9 = htmlspecialchars($_POST["D9"]);			$D10 = htmlspecialchars($_POST["D10"]);

			if ($D10 == null)
			  $D10 = 'false';			
			
			$tratamento = htmlspecialchars($_POST["tratamento"]);		$remedio = htmlspecialchars($_POST["remedio"]);
			$gravidez = htmlspecialchars($_POST["gravidez"]);			$medico = htmlspecialchars($_POST["medico"]);
			$alergia = htmlspecialchars($_POST["alergia"]);				$cirurgia = htmlspecialchars($_POST["cirurgia"]);
			$cicatriz = htmlspecialchars($_POST["cicatriz"]);			$anestesia = htmlspecialchars($_POST["anestesia"]);
			$hemorragia = htmlspecialchars($_POST["hemorragia"]);		$habitos = htmlspecialchars($_POST["habitos"]);
			$familia = htmlspecialchars($_POST["familia"]);				$obs = htmlspecialchars($_POST["obs"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
				  
				  $query = $DBcon->query("INSERT INTO `anamnese` (`ID`, `patient`, `D1`, `D2`, `D3`, `D4`, `D5`, `D6`, `D7`, `D8`, `D9`, `D10`, `tratamento`, `remedio`, `gravidez`, `medico`, `alergia`, `cirurgia`, `cicatriz`, `anestesia`, `hemorragia`, `habitos`, `familia`, `obs`)
				  VALUES ('$ID', '$Name', '$D1', '$D2', '$D3', '$D4', '$D5', '$D6', '$D7', '$D8', '$D9', '$D10', '$tratamento', '$remedio', '$gravidez', '$medico', '$alergia', '$cirurgia', '$cicatriz', '$anestesia', '$hemorragia', '$habitos', '$familia', '$obs')");	  
			  
				if ($query)
					echo '<span class="server_response">Anamnese do paciente ['. $ID .'] - '. $Name .' cadastrada!</span>';
				  else
					echo $DBcon->error();
				  

				// Closing the DB connection
				$DBcon->close();	  
		  }
		
		  if (isset($_POST['up_anamnese'])) {
		  // User Data
			$ID 	=	htmlspecialchars($_POST["id"]);
			$Name 	=	htmlspecialchars($_POST["name"]);	  
		  
			$D1 = htmlspecialchars($_POST["D1"]);			$D2 = htmlspecialchars($_POST["D2"]);
			$D3 = htmlspecialchars($_POST["D3"]);			$D4 = htmlspecialchars($_POST["D4"]);
			$D5 = htmlspecialchars($_POST["D5"]);			$D6 = htmlspecialchars($_POST["D6"]);
			$D7 = htmlspecialchars($_POST["D7"]);			$D8 = htmlspecialchars($_POST["D8"]);
			$D9 = htmlspecialchars($_POST["D9"]);			$D10 = htmlspecialchars($_POST["D10"]);
			
			if ($D10 == null)
			  $D10 = 'false';
			
			$tratamento = htmlspecialchars($_POST["tratamento"]);		$remedio = htmlspecialchars($_POST["remedio"]);
			$gravidez = htmlspecialchars($_POST["gravidez"]);			$medico = htmlspecialchars($_POST["medico"]);
			$alergia = htmlspecialchars($_POST["alergia"]);				$cirurgia = htmlspecialchars($_POST["cirurgia"]);
			$cicatriz = htmlspecialchars($_POST["cicatriz"]);			$anestesia = htmlspecialchars($_POST["anestesia"]);
			$hemorragia = htmlspecialchars($_POST["hemorragia"]);		$habitos = htmlspecialchars($_POST["habitos"]);
			$familia = htmlspecialchars($_POST["familia"]);				$obs = htmlspecialchars($_POST["obs"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }

				 $query = $DBcon->query("UPDATE `anamnese` SET `D1` = '$D1', `D2` = '$D2', `D3` = '$D3', `D4` = '$D4', `D5` = '$D5',
						  `D6` = '$D6', `D7` = '$D7', `D8` = '$D8', `D9` = '$D9', `D10` = '$D10',
						  `tratamento` = '$tratamento', `remedio` = '$remedio', `gravidez` = '$gravidez',
						  `medico` = '$medico', `alergia` = '$alergia', `cirurgia` = '$cirurgia',
						  `cicatriz` = '$cicatriz', `anestesia` = '$anestesia', `hemorragia` = '$hemorragia',
						  `habitos` = '$habitos', `familia` = '$familia', `obs` = '$obs' WHERE `anamnese`.`ID` = $ID;");			  
			  
				if ($query)				
					echo '<span class="server_response">Anamnese do paciente ['. $ID .'] - '. $Name .' atualizada!</span>';
				  else
					echo $DBcon->error();
				  

				// Closing the DB connection
				$DBcon->close();
		  }

		  if (isset($_POST['del_anamnese'])) {
		  // User Data
		  $ID	=	htmlspecialchars($_POST["id"]);
		  $Name	=	htmlspecialchars($_POST["name"]);
		  
			  // MySQL Connection  
			   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
				
				 if ($DBcon->connect_errno) {
					 die("ERROR : -> ".$DBcon->connect_error);
				 }
			
				$query = $DBcon->query("DELETE FROM `anamnese` WHERE `ID` = $ID;");

				if ($query)		
					echo '<span class="server_response">Anamnese do paciente ['. $ID .'] - '. $Name .' deletada!</span>';
				  else
					echo $DBcon->error();			  
			  
				// Closing the DB connection
				$DBcon->close();
		  } 
		  
			  if (isset($_POST['get_tooth']))
			  {
				// MySQL Connection  
				$DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
					
				if ($DBcon->connect_errno) {
				  die("ERROR : -> ".$DBcon->connect_error);
				}
				
				$ID 	=	htmlspecialchars($_POST["id"]);
				$Name 	=	htmlspecialchars($_POST["name"]);
				
				$LookForEntry = $DBcon->query("SELECT * FROM `odontograms` WHERE `id` = $ID");
				
				if (!$LookForEntry->fetch_row())			  
				  $DBcon->query("INSERT INTO `odontograms` (`id`, `T11`, `T12`, `T13`, `T14`, `T15`, `T16`, `T17`, `T18`, `T21`, `T22`, `T23`, `T24`, `T25`, `T26`, `T27`, `T28`, `T31`, `T32`, `T33`, `T34`, `T35`, `T36`, `T37`, `T38`, `T41`, `T42`, `T43`, `T44`, `T45`, `T46`, `T47`, `T48`) VALUES ('$ID', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')");
					
				// Closing the DB connection
				$DBcon->close();
		?>
			<form id="odontograma" action='' method='post'>		
				<div id='subtitle'>
				  Paciente: <?php echo $ID; ?>
				  <input type='text' name='id' value='<?php echo $ID; ?>' style='display: none;'>
				  
					<button id='imgbut' type='submit' name='get_patient'>
					  <img class='icon' src='../img/redo.png'>
					  Voltar
					</button>								 
					<button id='imgbut' type='button' onclick="UpdateToothInfo(<?php echo $ID; ?>)">
					  <img class='icon' src='../img/save.png'>
					  Salvar
					</button>
				</div>
				
				  <div id='container'>
					<p>
						<label for='name'>Nome Completo</label><br>
						<input type='text' name='name' value='<?php echo $Name; ?>' style='width:450px; height: 25px;'>
					</p>
					
					<div class="odontograma">
					  <div class="Top_teeth">
						<input type="radio" name="Tooth" value="T18" id="T18" onclick="GetToothInfo(<?php echo $ID; ?>, 'T18')"><label for="T18" class="T18" style="margin-left: 74px; width:35px;"></label>
						<input type="radio" name="Tooth" value="T17" id="T17" onclick="GetToothInfo(<?php echo $ID; ?>, 'T17')"><label for="T17" class="T17" style="margin-left: 3px; width: 40px;"></label>
						<input type="radio" name="Tooth" value="T16" id="T16" onclick="GetToothInfo(<?php echo $ID; ?>, 'T16')"><label for="T16" class="T16" style="margin-left: 7px; width:50px;"></label>
						<input type="radio" name="Tooth" value="T15" id="T15" onclick="GetToothInfo(<?php echo $ID; ?>, 'T15')"><label for="T15" class="T15" style="margin-left: 4px; width:30px;"></label>
						<input type="radio" name="Tooth" value="T14" id="T14" onclick="GetToothInfo(<?php echo $ID; ?>, 'T14')"><label for="T14" class="T14" style="margin-left: 14px; width:29px;"></label>
						<input type="radio" name="Tooth" value="T13" id="T13" onclick="GetToothInfo(<?php echo $ID; ?>, 'T13')"><label for="T13" class="T13" style="margin-left: 10px; width:32px;"></label>
						<input type="radio" name="Tooth" value="T12" id="T12" onclick="GetToothInfo(<?php echo $ID; ?>, 'T12')"><label for="T12" class="T12" style="margin-left: 15px; width:31px;"></label>
						<input type="radio" name="Tooth" value="T11" id="T11" onclick="GetToothInfo(<?php echo $ID; ?>, 'T11')"><label for="T11" class="T11" style="margin-left: 9px; width:41px;"></label>
						
						
						<input type="radio" name="Tooth" value="T21" id="T21" onclick="GetToothInfo(<?php echo $ID; ?>, 'T21')"><label for="T21" class="T21" style="margin-left: 6px;width: 38px;"></label>
						<input type="radio" name="Tooth" value="T22" id="T22" onclick="GetToothInfo(<?php echo $ID; ?>, 'T22')"><label for="T22" class="T22" style="margin-left: 13px;width: 32px;"></label>
						<input type="radio" name="Tooth" value="T23" id="T23" onclick="GetToothInfo(<?php echo $ID; ?>, 'T23')"><label for="T23" class="T23" style="margin-left: 7px;width: 35px;"></label>
						<input type="radio" name="Tooth" value="T24" id="T24" onclick="GetToothInfo(<?php echo $ID; ?>, 'T24')"><label for="T24" class="T24" style="margin-left: 13px;width: 31px;"></label>
						<input type="radio" name="Tooth" value="T25" id="T25" onclick="GetToothInfo(<?php echo $ID; ?>, 'T25')"><label for="T25" class="T25" style="margin-left: 3px;w;width: 40px;"></label>
						<input type="radio" name="Tooth" value="T26" id="T26" onclick="GetToothInfo(<?php echo $ID; ?>, 'T26')"><label for="T26" class="T26" style="margin-left: 8px;width: 44px;"></label>
						<input type="radio" name="Tooth" value="T27" id="T27" onclick="GetToothInfo(<?php echo $ID; ?>, 'T27')"><label for="T27" class="T27" style="margin-left: 6px;width: 40px;"></label>
						<input type="radio" name="Tooth" value="T28" id="T28" onclick="GetToothInfo(<?php echo $ID; ?>, 'T28')"><label for="T28" class="T28" style="margin-left: 3px;width:35px;"></label>										
					  </div>
					  
					  <div class="Lower_teeth">
						<input type="radio" name="Tooth" value="T48" id="T48" onclick="GetToothInfo(<?php echo $ID; ?>, 'T48')"><label for="T48" class="T48" style="margin-left: 75px;width: 39px;"></label>
						<input type="radio" name="Tooth" value="T47" id="T47" onclick="GetToothInfo(<?php echo $ID; ?>, 'T47')"><label for="T47" class="T47" style="margin-left: 10px;width: 39px;"></label>
						<input type="radio" name="Tooth" value="T46" id="T46" onclick="GetToothInfo(<?php echo $ID; ?>, 'T46')"><label for="T46" class="T46" style="margin-left: 12px;width:50px;"></label>
						<input type="radio" name="Tooth" value="T45" id="T45" onclick="GetToothInfo(<?php echo $ID; ?>, 'T45')"><label for="T45" class="T45" style="margin-left: 16px;width:30px;"></label>
						<input type="radio" name="Tooth" value="T44" id="T44" onclick="GetToothInfo(<?php echo $ID; ?>, 'T44')"><label for="T44" class="T44" style="margin-left: 10px;width:29px;"></label>
						<input type="radio" name="Tooth" value="T43" id="T43" onclick="GetToothInfo(<?php echo $ID; ?>, 'T43')"><label for="T43" class="T43" style="margin-left: 7px;width:32px;"></label>
						<input type="radio" name="Tooth" value="T42" id="T42" onclick="GetToothInfo(<?php echo $ID; ?>, 'T42')"><label for="T42" class="T42" style="margin-left: 8px;width: 27px;"></label>
						<input type="radio" name="Tooth" value="T41" id="T41" onclick="GetToothInfo(<?php echo $ID; ?>, 'T41')"><label for="T41" class="T41" style="margin-left: 14px;width: 23px;"></label>
						
						
						<input type="radio" name="Tooth" value="T31" id="T31" onclick="GetToothInfo(<?php echo $ID; ?>, 'T31')"><label for="T31" class="T31" style="margin-left: 6px;width: 29px;"></label>
						<input type="radio" name="Tooth" value="T32" id="T32" onclick="GetToothInfo(<?php echo $ID; ?>, 'T32')"><label for="T32" class="T32" style="margin-left: 8px;width: 28px;"></label>
						<input type="radio" name="Tooth" value="T33" id="T33" onclick="GetToothInfo(<?php echo $ID; ?>, 'T33')"><label for="T33" class="T33" style="margin-left: 13px;width: 30px;"></label>
						<input type="radio" name="Tooth" value="T34" id="T34" onclick="GetToothInfo(<?php echo $ID; ?>, 'T34')"><label for="T34" class="T34" style="margin-left: 15px;width: 31px;"></label>
						<input type="radio" name="Tooth" value="T35" id="T35" onclick="GetToothInfo(<?php echo $ID; ?>, 'T35')"><label for="T35" class="T35" style="margin-left: 13px;w;width: 28px;"></label>
						<input type="radio" name="Tooth" value="T36" id="T36" onclick="GetToothInfo(<?php echo $ID; ?>, 'T36')"><label for="T36" class="T36" style="margin-left: 12px;width: 44px;"></label>
						<input type="radio" name="Tooth" value="T37" id="T37" onclick="GetToothInfo(<?php echo $ID; ?>, 'T37')"><label for="T37" class="T37" style="margin-left: 15px;width: 40px;"></label>
						<input type="radio" name="Tooth" value="T38" id="T38" onclick="GetToothInfo(<?php echo $ID; ?>, 'T38')"><label for="T38" class="T38" style="margin-left: 9px;width: 40px;"></label>										
					  </div>
					  
					  <img src="../img/odontograma.png">
					</div>
					
					  <textarea id="tooth_info" value="Nenhum dente selecionado." class="tooth_description">Nenhum dente selecionado.</textarea>
					
				  </div>								  
			</form>
		<?php						  
			  }
		?>
	  
    </div>  <!-- Fim Corpo da página. -->
    
	<div id="footer"><!-- Rodapé. -->
	  Developed by Isaque Costa.<br>isaquecostaa@gmail.com
	</div><!-- Fim Rodapé. -->
	
  </div> <!-- Fim Divisão corpo da página. -->
</body>
</html>