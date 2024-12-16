<?php
require 'clases/conexion.php';
?>
<?php
$ordenestudio = consultas::get_datos("SELECT * FROM v_ordenestudiosdetalle WHERE oe_cod = " . $_GET['cod']);
?>
<?php if (!empty($ordenestudio)) { ?>            
    <?php
    foreach ($ordenestudio as $oe) {
        ?>
        <tr>
            <td hidden class="pac_cod"><?php echo $oe['pac_cod']; ?></td>
            <td data-title="#" class="oe_cod"><?php echo $oe['oe_cod']; ?></td>
            <td data-title="Paciente"><?php echo $oe['paciente']; ?></td>
            <td data-title="Fecha de Orden Estudio"><?php echo $oe['oe_fecha']; ?></td>
            <td data-title="Tipo de Orden Estudio"><?php echo $oe['tipooe_descri']; ?></td>
            <td data-title="Observación"><?php echo $oe['observacion']; ?></td>
        </tr>
        <?php
    }
} else {
    ?>
    <option value=""></option> 
<?php } ?>
        


