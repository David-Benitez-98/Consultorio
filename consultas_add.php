<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Agregar Consultas</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Agrega tus estilos CSS personalizados aquí si es necesario -->
        <?php
        session_start();
        require 'menu/css_lte.ctp';
        ?><!-- ARCHIVOS CSS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?>
            <?php require 'menu/toolbar_lte.ctp'; ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                                <div class="alert alert-danger" role="alert" id="mensaje">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    <?php
                                    echo $_SESSION['mensaje'];
                                    $_SESSION['mensaje'] = '';
                                    ?>
                                </div>
                            <?php } ?>
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Agregar Consultas</h3>
                                </div>
                                <div class="box-tools">
                                    <a href="consultas_index.php" class="btn btn-primary btn-sm float-left" data-title="Volver" rel="tooltip" data-placement="left">
                                        <i class="fa fa-arrow-left"></i> VOLVER
                                    </a>                                            
                                </div>
                                <!--Inicio de cabecera -->
                                <div class="box-body">
                                    <form action="consulta_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                        <input type="hidden" name="pac_cod" id="pac_cod" value="">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vcod_consulta" value="0">
                                        <div class="row">
                                            <?php
                                            date_default_timezone_set('America/Asuncion');
                                            $fechaHoraActual = date('Y-m-d\TH:i:s', time()); // Formato ISO 8601
                                            ?>
                                            <div class="col-md-2">
                                                <input type="datetime-local" class="form-control" name="vfecha_hora" id="vfecha_hora" value="<?php echo $fechaHoraActual; ?>">

                                            </div>
                                            <br>
                                            <br>
                                            <div class="col-md-2">
                                                <label>Precio</label>
                                                <input type="numeric" value="100.000" class="form-control" name="vcons_precio" id="vcons_precio">
                                            </div>
                                            <br>
                                            <br>
                                            <br>
                                            <div class="col-md-3">
                                                <label for="vtipcon_cod">Tipo de Consulta:</label>
                                                <?php
                                                $tipo_consulta = consultas::get_datos("SELECT * FROM tipo_consulta ORDER BY tipcon_cod");
                                                ?>
                                                <select class="form-control" name="vtipcon_cod" required id="vtipcon_cod">
                                                    <option value="0">Seleccionar Tipo de Consulta</option>
                                                    <?php foreach ($tipo_consulta as $tipo_con) : ?>
                                                        <option value="<?php echo $tipo_con['tipcon_cod']; ?>"><?php echo $tipo_con['tipcon_descri']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Paciente</label>
                                                <select  name="vpcon_cod" id="paciente_pre_consulta" class="form-control" onchange="cargarPreConsulta(); return false;">
                                                    <?php
                                                    $pre = consultas::get_datos("SELECT
                                                        pc.pcon_cod,
                                                        p.pac_cod,
                                                        per.per_nombre,
                                                        per.per_apellido
                                                        FROM pre_consulta  pc 
                                                        JOIN citas c 
                                                        ON c.cita_cod =  pc.cita_cod
                                                        JOIN pacientes p 
                                                        ON p.pac_cod =  c.pac_cod
                                                        JOIN persona per 
                                                        ON per.per_cod =  p.per_cod
                                                        WHERE pc.pcon_estado = 'CONFIRMADO'");
                                                    ?>
                                                    <option value="0">Pre consultas del dia</option>
                                                    <?php foreach ($pre as $con) : ?>
                                                        <option value="<?php echo $con['pcon_cod']; ?>" data-pac-cod="<?php echo $con['pac_cod']; ?>">
                                                            <?= $con['per_nombre']; ?> <?= $con['per_apellido']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-condensed table-hover">
                                                        <thead>
                                                        <th>#</th>
                                                        <th>Paciente</th>
                                                        <th>Presion Arterial</th>
                                                        <th>Temperatura</th>
                                                        <th>Frecuencia Respiratoria</th>
                                                        <th>Frecuencia Cardiaca</th>
                                                        <th>Saturación</th>
                                                        <th>Peso</th>
                                                        <th>Talla</th>
                                                        </thead>
                                                        <tbody id="datos_pre_consulta">
                                                            <tr>
                                                                <td colspan="10"><div class="alert alert-info">
                                                                        <span class="glyphicon glyphicon-info-sign"></span> 
                                                                        No se han seleccionado Pre Consulta...
                                                                    </div></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Motivo</label>
                                                <input type="text" class="form-control" name="vcon_motivo" id="vcon_motivo" >
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <div class="box-footer">
                                            <a href="consulta_index.php" class="btn btn-danger">
                                                <i class="fa fa-remove"></i> CANCELAR
                                            </a>   
                                            <button type="submit" class="btn btn-primary pull-right">
                                                <i class="fa fa-floppy-o"></i> Ir a Detalles
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
    </div>
    <?php require 'menu/footer_lte.ctp'; ?>

</div>
<script>
    // Función para mostrar el mensaje inicial
    function mostrarMensajeInicial() {
        $('#mensaje-inicial').show();
    }
    function cargarPreConsulta() {
        if ($("#paciente_pre_consulta").val() === "0") {
            $('#datos_pre_consulta').html(`<tr>
                                            <td colspan="10"><div class="alert alert-info">
                                                    <span class="glyphicon glyphicon-info-sign"></span> 
                                                    No se han seleccionado Pre Consulta...
                                                </div></td>
                                        </tr>`);
        } else {
            $.ajax({
                type: "GET",
                url: "consulta_datopreconsulta.php?cod=" + $('#paciente_pre_consulta').val(),
                cache: false,
                beforeSend: function () {
                    $('#datos_pre_consulta').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
                },

                success: function (data) {
                    console.log(data);
                    $('#datos_pre_consulta').html(data);
                    // Obtener el código del paciente seleccionado
                    var pacCod = $('#paciente_pre_consulta').find(':selected').data('pac-cod');
                    // Asignar el código del paciente a un campo oculto en el formulario
                    $('#pac_cod').val(pacCod);
                }
            });
        }
    }

    function remover(tr) {
        $(tr).remove();
    }
    ;

</script>
<script>
    // Obtener el valor del campo fecha y hora
    var fechaHoraInput = document.getElementById('vfecha_hora');

    // Escuchar cambios en el campo
    fechaHoraInput.addEventListener('change', function () {
        // Obtener la fecha y hora seleccionadas
        var fechaHoraSeleccionada = fechaHoraInput.value;

        // Formatear la fecha y hora (puedes personalizar el formato según tus necesidades)
        var fechaHoraFormateada = new Date(fechaHoraSeleccionada).toLocaleString('es-ES', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });

        // Puedes imprimir la fecha y hora formateada en la consola o usarla según tus necesidades
        console.log('Fecha y Hora Formateada:', fechaHoraFormateada);
    });
</script>

<?php require 'menu/js_lte.ctp'; ?> 
<script>
    $('#mensaje').delay(4000).slideUp(200, function () {
        $(this).alert('close');
    });
</script><!-- Agrega tus scripts JavaScript si es necesario -->
</body>
</html>
