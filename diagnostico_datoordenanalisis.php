<?php
require 'clases/conexion.php';
?>
<?php
$ordenanalisis = consultas::get_datos("SELECT * FROM v_ordenanalisisdetalle WHERE oa_cod = " . $_GET['oacod']);
?>
<?php if (!empty($ordenanalisis)) { ?>            
    <?php
    foreach ($ordenanalisis as $oa) {
        ?>
        <tr>
            <td data-title="#" class="oa_cod"><?php echo $oa['oa_cod']; ?></td>
            <td data-title="Paciente"><?php echo $oa['paciente']; ?></td>
            <td data-title="Fecha de Orden Estudio"><?php echo $oa['oa_fecha']; ?></td>
            <td data-title="Tipo de Orden Estudio"><?php echo $oa['tipooa_descri']; ?></td>
            <td data-title="Observación"><?php echo $oa['observacion']; ?></td>
        </tr>
        <?php
    }
} else {
    ?>
    <option value=""></option> 
<?php } ?>
        


