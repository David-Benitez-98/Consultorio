<?php
session_start();
if(isset($_SESSION['usu_cod'])){
	session_destroy();
}
header('Location:/sistema_consultorio/');
?>