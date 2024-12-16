<?php
	$conexion = conexion::conectar();
	$rs1 = pg_query($conexion,"SELECT * FROM v_permisos WHERE rol_cod = ".$_SESSION['rol_cod']." AND pag_cod = ".$_SESSION['pag_cod']." AND id_ac = 1 AND pe_estado = 'ACTIVO';");
	$rs2 = pg_fetch_all($rs1);
	if(empty($rs2)){
		$_SESSION['mensaje'] = "NO POSEE PERMISOS PARA LA PAGINA";
		$_SESSION['tipo_mensaje'] = "error";
		header('Location:/sistema_consultorio/menu.php');
	}else{
		$_SESSION['mensaje'] = '';
		$_SESSION['mod_cod'] = $rs2[0]['mod_cod'];
	}
?>