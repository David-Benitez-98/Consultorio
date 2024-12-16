<?php
require 'clases/conexion.php';
?>

<?php
$doctores = consultas::get_datos("SELECT
  de.doc_cod,
  p.per_nombre,
  p.per_apellido
FROM
  agenda_detalle de
JOIN
  doctor d ON d.doc_cod = de.doc_cod
JOIN
  persona p ON p.per_cod = d.per_cod
JOIN
  especialidad tu ON de.esp_cod = tu.esp_cod
WHERE
  tu.esp_cod =" . $_GET['vesp_cod'] . " "
                . "GROUP BY de.doc_cod,  p.per_nombre,  p.per_apellido");
?>
<?php if (!empty($doctores)) { ?>            
    <option value="">FAVOR SELECCIONE EL DOCTOR</option>        
    <?php
    foreach ($doctores as $doctor) {
        ?>
        <option value="<?php echo $doctor['doc_cod'] ?>"> <?= $doctor['per_nombre'] ?> <?= $doctor['per_apellido'] ?></option>            
        <?php
    }
} else {
    ?>
    <option value="">ESTA ESPECIALIDAD NO TIENE DOCTOR DISPONIBLE</option> 
<?php } ?>        

