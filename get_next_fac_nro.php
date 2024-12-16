<?php
// Conexión a la base de datos
require 'conexion.php';

// Obtener el código del timbrado desde la solicitud
$timCod = isset($_GET['tim_cod']) ? $_GET['tim_cod'] : 1;

// Consultar el siguiente número de factura
$query = "SELECT MAX(fac_nro) AS max_fac_nro FROM factura WHERE tim_cod = :timCod";
$stmt = $pdo->prepare($query);
$stmt->execute(['timCod' => $timCod]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Calcular el siguiente número
$nextFacNro = isset($result['max_fac_nro']) ? $result['max_fac_nro'] + 1 : 1;

// Retornar el siguiente número de factura en formato JSON
echo json_encode(['fac_nro' => $nextFacNro]);
?>
