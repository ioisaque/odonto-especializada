<?php
session_start();

if (!isset($_SESSION['odontoUserSession_ID'])) {
	header("Location: index.php");
} else if (isset($_SESSION['odontoUserSession_ID'])!="") {
	header("Location: pages/home.php");
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['odontoUserSession_ID']);
	unset($_SESSION['odontoUserSession_Name']);
	header("Location: index.php");
}
