<?php

   $DBhost = "odonto35.mysql.dbaas.com.br";
   $DBuser = "odonto35";
   $DBpass = "V92hWhyE";
   $DBname = "odonto35";
   
   $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DBcon->connect_errno) {
         die("ERROR : -> ".$DBcon->connect_error);
     }
