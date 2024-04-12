<?php
	include_once "../controller/controller.php";
	insertarLog('Cierra sesión.', connectDB());
	session_unset();
	header("location: ../index.php");
?>