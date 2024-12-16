<?php
require 'clases/conexion.php';
?>
<?php
$consulta = consultas::get_datos("SELECT * FROM v_consultadetalle WHERE cod_consulta = " . $_GET['cod']);
?>
<?php if (!empty($consulta)) { ?>            
    <?php
    foreach ($consulta as $con) {
        ?>
        <tr>
            <td hidden class="pac_cod"><?php echo $con['pac_cod']; ?></td>
            <td data-title="#" class="cod_consulta"><?php echo $con['cod_consulta']; ?></td>
            <td data-title="Fecha"><?php echo $con['con_fecha']; ?></td>
            <td data-title="Paciente"><?php echo $con['paciente']; ?></td>
            <td data-title="TipoConsulta"><?php echo $con['tipcon_descri']; ?></td>
            <td data-title="Motivo"><?php echo $con['con_motivo']; ?></td>
            <td data-title="Sintomas"><?php echo $con['sin_descri']; ?></td>            
        </tr>
        <?php
    }
} else {
    ?>
    <option value=""></option> 
<?php } ?>        


