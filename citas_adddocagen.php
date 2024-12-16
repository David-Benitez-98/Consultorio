<?php
require 'clases/conexion.php';

$doctores = consultas::get_datos("
    SELECT
        d.dia_descri,
        d.dia_cod,
        t.tur_descri, 
        ad.hora_inicio, 
        ad.hora_fin,
        ad.agen_cod,
        ad.cupos - (
            SELECT COUNT(c.cita_cod) FROM citas c WHERE c.agen_cod = ad.agen_cod  AND c.dia_cod = d.dia_cod  AND c.cita_fecha = '" . $_GET['fecha'] . "') AS cantidad
    FROM agenda_detalle ad 
    JOIN dias d ON d.dia_cod = ad.dia_cod
    JOIN turnos t ON t.tur_cod = ad.tur_cod
    JOIN agenda a ON a.agen_cod = ad.agen_cod
    WHERE ad.doc_cod = " . $_GET['vdoc_cod'] . " 
    AND a.agen_estado = 'ACTIVO'
");

if (!empty($doctores)) { ?>            
    <option value="">FAVOR SELECCIONE EL DIA</option>        
    <?php
    foreach ($doctores as $doctor) {
        if (intval($doctor['cantidad']) > 0) {
            ?>
            <option value="<?php echo $doctor['agen_cod'] ?>">
                <?= $doctor['dia_descri'] ?> | <?= $doctor['tur_descri'] ?> <?= $doctor['hora_inicio'] ?> | <?= $doctor['hora_fin'] ?>  | DISPONIBLE <?= $doctor['cantidad'] ?>
            </option>            
            <?php
        }
    }
} else {
    ?>
    <option value="">ESTA ESPECIALIDAD NO TIENE DOCTOR DISPONIBLE</option> 
<?php } ?>
