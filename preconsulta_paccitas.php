<?php
require 'clases/conexion.php';
?>
<?php
$paciente = "pac_cod = " . $_REQUEST['vpac_cod'];
$citas = consultas::get_datos("SELECT c.cita_cod, c.cita_hora, c.cita_fecha, c.pac_cod 
                              FROM citas c
                              JOIN pacientes p ON c.pac_cod = p.pac_cod
                              WHERE c.cita_estado = 'CONFIRMADO' and c.pac_cod = " . $_GET['vpac_cod']);
?>
<?php if (!empty($citas)){ ?>            
    <option value="">Citas Disponibles</option>        
    <?php foreach ($citas as $cit) { ?>
        <option value="<?php echo $cit['cita_cod'] ?>">
            <?= $cit['cita_fecha'] ?> || <?= $cit['cita_hora'] ?>
        </option>            
    <?php } ?>
<?php } else { ?>
    <option value="">Este Paciente no tiene citas disponibles</option> 
<?php } ?>
