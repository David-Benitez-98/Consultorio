<?php
require 'clases/conexion.php';
?>
<?php
$preconsulta = consultas::get_datos("SELECT * FROM v_citas WHERE cita_cod = " . $_GET['cod']);
?>
<?php if (!empty($preconsulta)) { ?>            
    <?php
    foreach ($preconsulta as $precon) {      
            ?>
            <tr>
                <td data-title="#" class="cita_cod"><?php echo $precon['cita_cod']; ?></td>
                <td hidden class="pac_cod"><?php echo $precon['pac_cod']; ?></td>
                <td data-title="Paciente"><?php echo $precon['paciente']; ?></td>
                <td data-title="Presion Arterial"><?php echo $precon['cita_fecha']; ?></td>
                <td data-title="Temperatura"><?php echo $precon['razon_cita']; ?></td>
                <td data-title="Frecuencia Respiratoria"><?php echo $precon['doctor']; ?></td>
                <td data-title="Frecuencia Cardiaca"><?php echo $precon['esp_descri']; ?></td>
            </tr>
            <?php       
    }
} else {
    ?>
    <option value=""></option> 
<?php } ?>        


