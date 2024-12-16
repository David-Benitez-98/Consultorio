<?php
require 'clases/conexion.php';
?>
<?php
$preconsulta = consultas::get_datos("SELECT * FROM v_pre_consulta WHERE pcon_cod = " . $_GET['cod']);
?>
<?php if (!empty($preconsulta)) { ?>            
    <?php
    foreach ($preconsulta as $precon) {      
            ?>
            <tr>
                
                <td data-title="#" class="pcon_cod"><?php echo $precon['pcon_cod']; ?></td>
                <td hidden class="pac_cod"><?php echo $precon['pac_cod']; ?></td>
                <td data-title="Paciente"><?php echo $precon['paciente']; ?></td>
                <td data-title="Presion Arterial"><?php echo $precon['presion_arterial']; ?></td>
                <td data-title="Temperatura"><?php echo $precon['temperatura']; ?></td>
                <td data-title="Frecuencia Respiratoria"><?php echo $precon['frecuencia_respiratoria']; ?></td>
                <td data-title="Frecuencia Cardiaca"><?php echo $precon['frecuencia_cardiaca']; ?></td>
                <td data-title="Saturacion"><?php echo $precon['saturacion']; ?></td>
                <td data-title="Peso"><?php echo $precon['peso']; ?></td>
                <td data-title="Talla"><?php echo $precon['talla']; ?></td> 
            </tr>
            <?php       
    }
} else {
    ?>
    <option value=""></option> 
<?php } ?>        


