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
?>
<!doctype html>
<html>
  <head>
	<link rel="shortcut icon" href="./img/icon.png" type="image/x-icon">
	<title>Odontologia Especializada - File</title> 
  </head>
  
  <script language="javascript">	
	function printDiv(divName)
	{
		 var printContents = document.getElementById(divName).innerHTML;
		 var originalContents = document.body.innerHTML;

		 document.body.innerHTML = printContents;

		 window.print();

		 document.body.innerHTML = originalContents;
	}
  </script>
  
  <style>
	@charset "UTF-8";
	/* CSS Document */
	@page {
	  size: A4;
	}	
	@media print
	{
		#pager,
		form,
		.no-print
		{
			display: none !important;
			height: 0;
		}


		.no-print, .no-print *{
			display: none !important;
			height: 0;
		}
	}
	* {-webkit-box-sizing:border-box; -moz-box-sizing:border-box; -ms-box-sizing:border-box; -o-box-sizing:border-box; box-sizing:border-box; }

	/* =================================================== */
	html,
	body {
		margin: 0 !important;
		padding: 0 !important;
		
		width: 100% !important;
		height: 100% !important;
		position: relative;
		font-family: Tahoma;	
		
		background:#c8e4dd;
	}
	#wrapper {
		width: 1024px;
		min-height: 100%;
		
		padding:25px;
		padding-top: 50px;
		padding-bottom: 50px;
		margin-left:auto;
		margin-right:auto;
		
		position: relative;
		background-color: rgba(255, 255, 255, 0.7);
		/* Font settigns */
		color:#000000;
		font-size:13px;
		line-height:1.230;
		text-align:justify;	
		text-decoration:none;		
	}
	#header {
		top: 0;
		left: 0;
		width: 100%;
		height: 50px;	
		margin-left: auto;
		margin-right: auto;
		
		position: absolute;
		background: #80baac;
	}
	#page {
	  width: 900px;
	  min-height: 1286px;
	  
	  margin: 0 auto;
	  margin-top: 50px; /* Height of the header element */
	  margin-bottom: 50px; /* Height of the footer element */
	  
	  background: url("./img/timbradoColor.jpg") no-repeat center;
	  background-size: 900px 1286px;	  
	}
	#content {
	  width: 900px;
	  height: 1286px;
	  
	  margin: 0 auto;
	  padding: 50px;
	  padding-top: 280px;
	  padding-bottom: 150px;
	  
	  font-family: Arial;
	}
	#footer {
		left: 0;
		bottom: 0;
		width: 100%;
		height: 50px;
		padding: 10px;
		
		position: absolute;
		background: #80baac;
		
		/* Font settigns */
		color: white;
		font-size: 11px;
		font-weight: bold;
		text-align: center;	
	}	
	#navbar {
		width: 100%;
		height: 100%;
		text-align: center;
	}
	.icon {
		max-width: 40px;
		max-height: 30px;
	}	
	.navtab {
		min-width: 140px;
		height: 50px;
		padding: 10px;
		cursor: pointer;
		display: inline-block;

		/* Font settigns */
		color: white;	
		font-weight: bold;
		text-decoration: none;
	}
	.navtab:hover {
		background: #2b6859;
	}	
	#type {
		float: left;
		width: 400px;
		height: 50px;
		margin-top: 85px;
		margin-left: 80px;		
		
		/* Font settigns */
		color: white;
		font-size: 35px;
		font-weight: bold;
		text-align: left;		
	}
  </style>

<body>  
  <div id="wrapper"> <!-- Divisão, corpo da página inteira. -->
	
	<div id="header" class='no-print'> <!-- Cabeçalho. -->
	  <div id="navbar">
	    <a class="navtab" href="../home.php">	
		  <img class="icon" src="./img/home.png">
			Home
		</a>	  
	    <a class="navtab" href="javascript:printDiv('page');">	
		  <img class="icon" src="./img/printer.png">
			Imprimir
		</a>
	  </div>
	</div> <!-- Fim Cabeçalho. -->

    <div id="page">
	
	<?php
	  if (isset($_POST['atestado']))
	  {		
		  $Patient 	= htmlspecialchars($_POST["patient"]);		  
		  $Date 	= htmlspecialchars($_POST["date"]);
			$Date = date("d/m/Y", strtotime($Date));
			
		  $Time 	= htmlspecialchars($_POST["time"]) . ' dia(s)';
		  $CID 		= htmlspecialchars($_POST["CID"]);
		  $Doc		= htmlspecialchars($_POST["doc"]);
		
		  array ($MesesBR = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']);
		  
		  //File
		  $txt = file_get_contents('ATESTADO.txt');
		  $txt = nl2br($txt);
		  
		  // Patient
		  $txt = str_replace("_paciente_"	,	$Patient				,$txt);
		  $txt = str_replace("_tempo_"		,	$Time					,$txt);
		  $txt = str_replace("_K0.1_"		,	$CID					,$txt);
		  
		  
		  // Data 	  
		  $txt = str_replace("_data_"		,	$Date					,$txt);
		  
		  $Date = explode("/", $Date);
		  
		  $txt = str_replace("_dia_" 		,	$Date[0]				,$txt);
		  $txt = str_replace("_mes_" 		,	$MesesBR[$Date[1]-1]	,$txt);
		  $txt = str_replace("_ano_" 		,	$Date[2]				,$txt);
		  
		  
		  // Doctor
		  $txt = str_replace("_dentista_"		,	$Doc				,$txt);
		  
			// MySQL Connection  
			  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
					
				if ($DBcon->connect_errno) {
				  die("ERROR : -> ".$DBcon->connect_error);
				}
								  
				  $query = $DBcon->query("SELECT * FROM `doctors` WHERE `name` = '$Doc'");
				  $row = $query->fetch_row();
				
					$Specialty = $row[2];
					$CRO	   = $row[3];
					
					$query->free();
					
			    // Closing the DB connection
			    $DBcon->close();					
		  
		  
		  $txt = str_replace("_especialidade_"	,	$Specialty		,$txt);
		  $txt = str_replace("_cro_"			,	'CRO ' . $CRO	,$txt);



		  echo "			
			   <div id='type'> ATESTADO </div>
				  <div id='content'>		  
					  $txt
				  </div>			
			";		
	  }
	  
	  if (isset($_POST['declaracao']))
	  {		
		  $Patient 	= htmlspecialchars($_POST["patient"]);		  
		  $Date 	= htmlspecialchars($_POST["date"]);
			$Date = date("d/m/Y", strtotime($Date));
			
		  $Time_I 	= htmlspecialchars($_POST["time_i"]);
		  $Time_F 	= htmlspecialchars($_POST["time_f"]);
		  $Ass		= htmlspecialchars($_POST["ass"]);
		
		  array ($MesesBR = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']);
		  
		  //File
		  $txt = file_get_contents('DECLARACAO.txt');
		  $txt = nl2br($txt);
		  
		  // Patient
		  $txt = str_replace("_paciente_"	,	$Patient				,$txt);
		  $txt = str_replace("_hr_i_"		,	$Time_I					,$txt);
		  $txt = str_replace("_hr_f_"		,	$Time_F					,$txt);
		  
		  
		  // Data 	  
		  $txt = str_replace("_data_"		,	$Date					,$txt);
		  
		  $Date = explode("/", $Date);
		  
		  $txt = str_replace("_dia_" 		,	$Date[0]				,$txt);
		  $txt = str_replace("_mes_" 		,	$MesesBR[$Date[1]-1]	,$txt);
		  $txt = str_replace("_ano_" 		,	$Date[2]				,$txt);
		  
		  
		  // Resp
		  $txt = str_replace("_responsavel_",	$Ass					,$txt);
		  
		  echo "			
			   <div id='type'> DECLARAÇÃO </div>
				  <div id='content'>		  
					  $txt
				  </div>			
			";		
	  }	  
	?>	
    </div>
    
	<div id="footer" class='no-print'> <!-- Rodapé. -->
	  Developed by Isaque Costa.<br>isaquecostaa@gmail.com
	</div> <!-- Fim Rodapé. -->
	
  </div> <!-- Fim Divisão corpo da página. -->
</body>
</html>