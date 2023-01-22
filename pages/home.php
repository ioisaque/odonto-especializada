<?php
session_start();	
include_once '../dbconnect.php';

	if (isset($_SESSION['odontoUserSession_ID']))
	{
	  $query = $DBcon->query("SELECT user_type FROM access WHERE id=".$_SESSION['odontoUserSession_ID']);
	  
	  if ( $userRow=$query->fetch_array() )
	  {
		if ($userRow['user_type'] != 'root' and $userRow['user_type'] != 'admin')
		  header("Location: ../index.php");
	  }else
		  header("Location: ../logout.php?logout");
	  
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
<body>  
  <div id="wrapper"> <!-- Divisão, corpo da página inteira. -->
  
  <div id="header" class="no-print"> <!-- Cabeçalho. -->
       <?php $nb = file_get_contents('./default/navbar.html'); echo $nb; ?>
  </div> <!-- Fim Cabeçalho. -->
    
    <div id="content"> <!-- Corpo da página. -->
  
    <!-- System Stats -->
    <div style='width: 950px; position: absolute; top: 50%; left: 50%;  transform: translate(-50%,-50%); z-index: -1;'>
    
    <div id="subtitle">    Estatísticas do Sistema  </div>
    
      <div id="container">
      <?php
      array ($MesesBR = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']);        
        
       $Date = date('d/m/Y');
       $Date = explode("/", $Date);
      
         $Date = $Date[0] . ' de ' . $MesesBR[$Date[1]-1] . ' de ' . $Date[2];      
      
        echo "<pre>Bem Vindo, " . $_SESSION['odontoUserSession_Name'] . "!                    " . $Date . "</pre>";
      
        // MySQL Connection  
		   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
			
			 if ($DBcon->connect_errno) {
				 die("ERROR : -> ".$DBcon->connect_error);
			 }
		  
		  $appt = $DBcon->query("SELECT * FROM agenda");
			if ($appt != false)
			  $N_appt=$appt->num_rows;
			else
			  $N_appt= "Tabela não encontrada!";
		  
		  $docs = $DBcon->query("SELECT * FROM doctors");
			if ($docs != false)
			  $N_docs=$docs->num_rows;
			else
			  $N_docs= "Tabela não encontrada!";

		  $types = $DBcon->query("SELECT * FROM types");
			if ($types != false)
			  $N_types=$types->num_rows;
			else
			  $N_types= "Tabela não encontrada!";

		  $patients = $DBcon->query("SELECT * FROM patients");
			if ($patients != false)
			  $N_patients=$patients->num_rows;
			else
			  $N_patients= "Tabela não encontrada!";

		  $anamnese = $DBcon->query("SELECT * FROM anamnese");
			if ($anamnese != false)
			  $N_anamnese=$anamnese->num_rows;
			else
			  $N_anamnese= "Tabela não encontrada!";

		  $odontograms = $DBcon->query("SELECT * FROM odontograms");
		    if ($odontograms != false)
			  $N_odontograms=$odontograms->num_rows;
			else
			  $N_odontograms= "Tabela não encontrada!";
		  
          // Closing the DB connection
          $DBcon->close();
        
      echo '<br><br>
          <pre>Pacientes: ' . $N_patients . '<br>Anamneses: ' . $N_anamnese . '<br>Odontogramas: ' . $N_odontograms . '</pre>        

          <pre>Horário agendados: ' . $N_appt . '<br>Dentistas cadastrados: ' . $N_docs . '<br>Procedimentos cadastrados: ' . $N_types . '</pre>';          
      ?>
      
    <a id='imgbut' style='color: #525252; text-decoration: none; ' href="tools.php">
      Ferramentas  do Sistema
      <img class="icon" src="../img/gears.png">
    </a>      
    </div>
    </div>
    </div>  <!-- Fim Corpo da página. -->
    
  <div id="footer" class="no-print"><!-- Rodapé. -->
    Developed by Isaque Costa.<br>isaquecostaa@gmail.com
  </div><!-- Fim Rodapé. -->
  
  </div> <!-- Fim Divisão corpo da página. -->
</body>
</html>