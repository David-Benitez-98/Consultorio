<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Agregar Pre Consulta</title>

        <!-- Estilos CSS -->
        <?php
        session_start();
        require 'menu/css_lte.ctp';
        ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            body {
                background-color: #f8f9fa;
            }
            .card {
                border-radius: 10px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            }
            .form-label {
                font-weight: bold;
            }
            .form-control {
                border: 1px solid #ced4da;
                border-radius: 5px;
                box-shadow: none;
            }
            .form-control:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }
            .btn {
                border-radius: 5px;
            }
        </style>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <!-- Contenido de la página -->
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
                            <!-- Card principal -->
                            <div class="card">
                                <div class="card-header text-center bg-primary text-white">
                                    <h3>Agregar Pre Consulta</h3>
                                </div>
                                <div class="card-body">
                                    <form action="preconsulta_control.php" method="post" class="form-horizontal">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vpcon_cod" value="0">
                                        <div class="row">
                                            <!-- Columna izquierda -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <?php $fecha = consultas::get_datos("SELECT current_date as fecha"); ?>
                                                    <label for="fecha" class="form-label">Fecha:</label>
                                                    <input type="date" name="vpcon_fecha" class="form-control" id="fecha" value="<?php echo $fecha[0]['fecha']; ?>" readonly>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="hora" class="form-label">Hora:</label>
                                                    <input type="time" name="vpcon_hora" class="form-control" id="hora" value="07:00">
                                                </div>

                                                <!-- Paciente -->
                                                <div class="mb-6">       
                                                    <label>Paciente</label>
                                                    <select name="vcita_cod" id="paciente_pre_consulta" class="form-control">
                                                        <?php
                                                        $pre = consultas::get_datos("SELECT c.cita_cod,
                                                                        p.pac_cod,
                                                                        per.per_nombre,
                                                                        per.per_apellido
                                                                FROM citas c 
                                                                JOIN pacientes p ON p.pac_cod = c.pac_cod
                                                                JOIN persona per ON per.per_cod = p.per_cod
                                                                WHERE c.cita_estado = 'CONFIRMADO'");
                                                        ?>
                                                        <option value="0">Citas del día</option>
                                                        <?php foreach ($pre as $con) : ?>
                                                            <option value="<?php echo $con['cita_cod']; ?>">
                                                                <?= $con['per_nombre']; ?> <?= $con['per_apellido']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Columna derecha -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="presion" class="form-label">Presión Arterial (mmHg):</label>
                                                    <input type="number" class="form-control" name="vpresion_arterial" id="presion" placeholder="Presión Arterial">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="temperatura" class="form-label">Temperatura (Cº):</label>
                                                    <input type="number" class="form-control" name="vtemperatura" id="temperatura" placeholder="Temperatura">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Campos adicionales -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="frecuencia_respiratoria" class="form-label">Frecuencia Respiratoria (x Minuto):</label>
                                                    <input type="number" class="form-control" name="vfrecuencia_respiratoria" id="frecuencia_respiratoria" placeholder="Frecuencia Respiratoria">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="frecuencia_cardiaca" class="form-label">Frecuencia Cardiaca (x Minuto):</label>
                                                    <input type="number" class="form-control" name="vfrecuencia_cardiaca" id="frecuencia_cardiaca" placeholder="Frecuencia Cardiaca">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="saturacion" class="form-label">Saturación O2:</label>
                                                    <input type="number" class="form-control" name="vsaturacion" id="saturacion" placeholder="Saturación">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="peso" class="form-label">Peso (Kg):</label>
                                                    <input type="number" class="form-control" name="vpeso" id="peso" placeholder="Peso">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="talla" class="form-label">Talla (cm):</label>
                                            <input type="number" class="form-control" name="vtalla" id="talla" placeholder="Talla">
                                        </div>

                                        <!-- Botones -->
                                        <div class="box-footer text-center">
                                            <a href="preconsulta_index.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
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
            function citas() {
                console.log($('#pacientes').val());
                $.ajax({
                    type: "GET",
                    url: "preconsulta_paccitas.php?vpac_cod=" + $('#pacientes').val(),
                    cache: false,
                    beforeSend: function () {
                        $('#vcita_cod').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
                    },
                    success: function (data) {
                        console.log(data);
                        $('#vcita_cod').html(data);
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function () {
                // Manejar el evento de cambio del select
                $('.seleccionar-paciente').change(function () {
                    // Obtener el valor seleccionado
                    var selectedPaciente = $(this).val();

                    // Realizar una llamada AJAX para obtener la información del paciente
                    // Aquí debes implementar la lógica para obtener la información del paciente según el valor seleccionado

                    // Actualizar los campos CI y Fecha de Nacimiento con la información obtenida
                    $('#vpac_ci').val('per_ci');
                    $('#vpac_fecnac').val('vpac_fecnac');
                });
            });
        </script>

        <?php require 'menu/js_lte.ctp'; ?>
        <script>
            $('#mensaje').delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        </script>
    </body>
</html>
