<?php
require 'clases/conexion.php';
?>
<?php
$diagnostico = consultas::get_datos("SELECT * FROM v_diagnosticodetalle WHERE diag_cod = " . $_GET['cod']);
?>
<?php if (!empty($diagnostico)) { ?>            
    <?php
    foreach ($diagnostico as $diag) {
            ?>
        <tr>
            <td hidden class="pac_cod"><?php echo $diag['pac_cod']; ?></td>
            <td data-title="#" class="diag_cod"><?php echo $diag['diag_cod']; ?></td>
            <td data-title="Paciente"><?php echo $diag['paciente']; ?></td>
            <td data-title="Fecha"><?php echo $diag['diag_fecha']; ?></td>
            <td data-title="Tipo de Enfermedad"><?php echo $diag['tipoenfe_descri']; ?></td>
            <td data-title="Enfermedad"><?php echo $diag['enfe_descri']; ?></td>
            <td data-title="Observacion"><?php echo $diag['diag_descri']; ?></td>
        </tr>
            <?php      
    }
} else {
    ?>
    <option value=""></option> 
<?php } ?>     


