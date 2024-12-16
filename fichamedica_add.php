<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Agregar Ficha</title>
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
                            <div class="box box-success">
                                <div class="box-header">
                                    <i class="fa fa-list"></i><i class="fa fa-plus"></i> 
                                    <h3 class="box-title">AGREGAR FICHA MÉDICA</h3>
                                    <div class="box-tools">
                                        <a href="fichamedica_index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                    </div>
                                </div>
                                <div class="box-body">
                                    <!-- Mensaje inicial oculto -->
                                    <form action="fichamedica_control.php" method="post">
                                        <input type="text" name="accion" value="1" hidden>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Columna izquierda -->
                                                <div class="form-group">
                                                    <label for="vpac_cod">Pacientes:</label>
                                                    <?php
                                                    $pacientes = consultas::get_datos("SELECT * FROM v_paciente ORDER BY pac_cod");
                                                    ?>
                                                    <select class="form-control" name="vpac_cod" required>
                                                        <option value="">Seleccionar Pacientes</option>
                                                        <?php foreach ($pacientes as $pac) : ?>
                                                            <option value="<?php echo $pac['pac_cod']; ?>"><?php echo $pac['paciente']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                

                                            </div>
                                            <div class="col-md-6">
                                                <!-- Columna derecha -->

                                            </div>
                                        </div>

                                        <div class="form-group" style="text-align: center;"> <!-- Centra el contenido horizontalmente -->
                                            <button type="submit" class="btn btn-primary" style="float: left;">IR A DETALLES</button> <!-- Alinea a la izquierda con 'float' -->
                                            <a href="fichamedica_index.php" class="btn btn-danger" style="float: right;">Cancelar</a> <!-- Alinea a la derecha con 'float' -->
                                        </div>
                                    </form>
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

            $(document).ready(function () {
                mostrarMensajeInicial(); // Muestra el mensaje inicial al abrir la página

                $('#agen_fecha, #hora_inicio, #hora_fin').on('change', function () {
                    // Obtiene los valores de fecha, hora de inicio y hora de fin
                    var fecha = $('#agen_fecha').val();
                    var hora_inicio = $('#hora_inicio').val();
                    var hora_fin = $('#hora_fin').val();

                    // Realiza una solicitud al servidor para verificar la disponibilidad de la agenda
                    $.ajax({
                        type: 'POST',
                        url: 'verificar_agenda.php', // Debes crear este archivo en tu servidor
                        data: {fecha: fecha, hora_inicio: hora_inicio, hora_fin: hora_fin},
                        success: function (data) {
                            if (data === 'agenda_disponible') {
                                // Llena el combo de turnos con la información de la agenda
                                var comboTurnos = '<label for="codigo_turno">Seleccione el turno:</label>' +
                                        '<select name="codigo_turno" id="codigo_turno" class="form-control" required>' +
                                        '<option value="turno1">Mañana</option>' +
                                        '<option value="turno2">Tarde</option>' +
                                        '</select>';
                                $('#agenda-disponible').html(comboTurnos);
                            } else {
                                // No hay una agenda disponible, muestra un mensaje
                                $('#agenda-disponible').html('');
                                mostrarMensajeInicial(); // Muestra el mensaje inicial nuevamente
                            }
                        }
                    });
                });
            });
        </script>
        <?php require 'menu/js_lte.ctp'; ?> <!-- Agrega tus scripts JavaScript si es necesario -->
    </body>
</html>
