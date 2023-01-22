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

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
  <script src="default/jquery.mask.js" language="javascript"></script> 
  
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
		  if (isset($_POST['register'])) {
		  // User Data
										$Name = htmlspecialchars($_POST["name"]);
			$Sex = htmlspecialchars($_POST["sex"]);					$Address = htmlspecialchars($_POST["address"]);
			$Number = htmlspecialchars($_POST["number"]);			$District = htmlspecialchars($_POST["district"]);
			$CEP = htmlspecialchars($_POST["cep"]);					$City = htmlspecialchars($_POST["city"]);
			$State = htmlspecialchars($_POST["state"]);				$Email = htmlspecialchars($_POST["email"]);
			$Phone = htmlspecialchars($_POST["phone"]);				$Naturality = htmlspecialchars($_POST["naturality"]);
			$Nationality = htmlspecialchars($_POST["nationality"]);	$Nasc = htmlspecialchars($_POST["nasc"]);
			$RG = htmlspecialchars($_POST["rg"]);	 				$CPF = htmlspecialchars($_POST["cpf"]);
			$Status = htmlspecialchars($_POST["status"]); 			$Work = htmlspecialchars($_POST["work"]);	
			$Sponsor = htmlspecialchars($_POST["sponsor"]);
		  
          // MySQL Connection  
		   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
			
			 if ($DBcon->connect_errno) {
				 die("ERROR : -> ".$DBcon->connect_error);
			 }
				  
				  $query = $DBcon->query("INSERT INTO `patients` (`ID`, `name`, `sex`, `address`, `number`, `district`, `cep`, `city`, `state`, `email`, `phone`, `naturality`, `nationality`, `nasc`,`RG`, `CPF`, `status`, `work`, `sponsor`)
				  VALUES (NULL, '$Name', '$Sex', '$Address', '$Number', '$District', '$CEP', '$City', '$State', '$Email', '$Phone', '$Naturality', '$Nationality', '$Nasc','$RG', '$CPF', '$Status', '$Work', '$Sponsor');");
			  
				if ($query)
					echo '<span class="server_response">Paciente '. $Name .' cadastrado!</span>';
				  else
					echo $DBcon->error();				  

		  // Closing the DB connection
			$DBcon->close();
		  }
		  
		?>
  	
	  <form method="post" action="">
	  
		<div id="subtitle">Cadastro de Pacientes</div>
	  
	    <div id="container">
		<p>
            <label for="name">Nome Completo</label>
            <label for="sex" style="margin-left: 310px;">Sexo</label><br>
			
            <input type="text" name="name" required="required" style="width:400px; height:25px;">
			
			<select name='sex' style='width:100px; height:25px;'>
				<option value="Masculino">Masculino</option>
				<option value="Feminino">Feminino</option>
			</select>			
		</p>
		
		<p>
            <label for="address">Endereço</label>
			<label for="number" style="margin-left: 298px;">Número</label><br>
			
            <input type="text" name="address" placeholder="Rua/Av" style="width:350px; height:25px;">
            <input type="text" name="number" placeholder="Nº 00 / APT 000" style="width:150px; height:25px;">
		</p>
		
		<p>
            <label for="district">Bairro</label>
			<label for="cep" style="margin-left: 316px;">CEP</label><br>
			
            <input type="text" name="district" placeholder="Bairro" style="width:350px; height:25px;">
            <input type="text" name="cep" placeholder="XXXXX-XXX" onKeyUp="$(this).mask('00000-000');" style="width:150px; height:25px;">
		</p>		
		
		<p>
            <label for="city">Cidade</label>
			<label for="state" style="margin-left: 313px;">UF</label><br>
			
            <input type="text" name="city" placeholder="Cidade/Comarca" style="width:350px; height:25px;">
            <input type="text" name="state" placeholder="Estado" style="width:150px; height:25px;">
		</p>
		
  		<p>
            <label for="email">E-mail</label>
			<label for="phone" style="margin-left: 313px;">Telefone/Celular</label><br>
			
            <input type="text" name="email" placeholder="mail@exemplo.com.br" style="width:350px; height:25px;">
            <input type="text" name="phone" placeholder="(XX) X XXXX XXXX" onKeyUp="$(this).mask('(00) 0 0000-0000');" style="width:150px; height:25px;">
		</p>
		
  		<p>
            <label for="naturality">Naturalidade</label>
			<label for="nationality" style="margin-left: 178px;">Nacionalidade</label><br>
			
            <input type="text" name="naturality" placeholder="Cidade" style="width:250px; height:25px;">
            <input type="text" name="nationality" placeholder="País" style="width:250px; height:25px;">
		</p>
		
  		<p>
            <label for="rg">RG</label>
			<label for="cpf" style="margin-left: 233px;">CPF</label><br>
			
            <input type="text" name="rg" placeholder="00.000.000" onKeyUp="$(this).mask('AA 00.000.000');" style="width:250px; height:25px;">
            <input type="text" name="cpf" placeholder="000.000.000-00" onKeyUp="$(this).mask('000.000.000-00', {reverse: true});" style="width:250px; height:25px;">
		</p>
		
  		<p>
            <label for="status">Estado Civil</label>
			<label for="nasc" style="margin-left: 186px;">Data de Nasc.</label><br>
			
			<select name="status" style="width:250px; height:25px;">
				<option value="Não especificado" selected>Não especificado</option> 
				<option value="Solteiro(a)">Solteiro(a)</option>
				<option value="Casado(a)">Casado(a)</option>
				<option value="Divorciado(a)">Divorciado(a)</option>
				<option value="Viúvo(a)">Viúvo(a)</option>
			</select>							  
            <input type="date" name="nasc" required="required" style="width:250px; height:25px;">
		</p>
		
  		<p>
            <label for="work">Profissão</label><br>			
            <input type="text" name="work" placeholder="Ocupação" style="width:250px; height:25px;">
		</p>
		
		<p>
            <label for="sponsor">Nome do Responsável Completo</label><br>
            <input type="text" name="sponsor" style="width:500px; height:25px;">
		</p>
		</div>
		
		<div id="navbar" style="margin-top: 40px;">		
            <button type="submit" name="register" class="navtab">
			  <img class="icon" src="../img/save.png">
			  Cadastrar
			</button>
            <button type="reset" name="reset" class="navtab">
			  <img class="icon" src="../img/trash.png">
			  Limpar
			</button>
		</div>
	</form>
	  
    </div>  <!-- Fim Corpo da página. -->
    
	<div id="footer" class="no-print"><!-- Rodapé. -->
	  Developed by Isaque Costa.<br>isaquecostaa@gmail.com
	</div><!-- Fim Rodapé. -->
	
  </div> <!-- Fim Divisão corpo da página. -->
</body>
</html>