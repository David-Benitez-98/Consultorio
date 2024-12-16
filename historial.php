<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Historial Consultorio</title>
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
                                    <h3 class="box-title">Historial Médico del Paciente</h3>
                                    <div class="box-tools">
                                        <a href="historial.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                    </div>
                                </div>
                                <!--Inicio de cabecera -->
                                <div class="row">
                                    <?php
                                    date_default_timezone_set('America/Asuncion');
                                    $fechaHoraActual = date('Y-m-d\TH:i:s', time()); // Formato ISO 8601
                                    ?>
                                    <div class="col-md-3">
                                        <input type="datetime-local" disabled="" class="form-control" name="vfecha_hora" id="vfecha_hora" value="<?php echo $fechaHoraActual; ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Paciente</label>
                                        <select name="pac_cod" id="paciente_diagnostico" class="form-control" onchange="historial_datopaciente(); return false;">
                                            <?php
                                            $diagnostico = consultas::get_datos("SELECT 'FICHA MÉDICA'::text AS tipo,
                                                f.fich_cod,                                                
                                                f.fich_fecha AS fecha,
                                                f.pac_cod, concat(per.per_nombre, ' ', per.per_apellido) AS paciente
                                                FROM fichamedica f
                                                JOIN pacientes p ON f.pac_cod = p.pac_cod
                                                JOIN persona per ON per.per_cod = p.per_cod
                                               ");
                                            ?>
                                            <option value="0">Seleccione Paciente</option>
                                            <?php foreach ($diagnostico as $diag) : ?>
                                                <option value="<?php echo $diag['pac_cod']; ?>" data-nombre="<?php echo $diag['paciente']; ?>">
                                                    <?= $diag['paciente']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="color: white;">TIPO</th>
                                                        <th style="color: white;">FECHA</th>
                                                        <th style="color: white;">DESCRIPCION</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="datos_diagnostico">
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="alert alert-info">
                                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                                No se han seleccionado Paciente...
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>   
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-success" onclick="imprimirHistorial()">Imprimir Historial</button>
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
            function historial_datopaciente() {
                var pacienteId = $("#paciente_diagnostico").val();
                var pacienteNombre = $("#paciente_diagnostico option:selected").data('nombre');
                if (pacienteId === "0") {
                    $('#datos_diagnostico').html(`<tr>
                                        <td colspan="3"><div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                No se han seleccionado Paciente...
                                            </div></td>
                                    </tr>`);
                } else {
                    $.ajax({
                        type: "GET",
                        url: "historial_datopaciente.php?cod=" + pacienteId,
                        cache: false,
                        beforeSend: function () {
                            $('#datos_diagnostico').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
                        },
                        success: function (data) {
                            $('#datos_diagnostico').html(data);
                        },
                        error: function () {
                            $('#datos_diagnostico').html('<div class="alert alert-danger">Error al cargar el historial médico.</div>');
                        }
                    });
                }
            }

            function imprimirHistorial() {
                var contenido = document.getElementById('datos_diagnostico').innerHTML;
                var pacienteNombre = $("#paciente_diagnostico option:selected").data('nombre');
                var ventana = window.open('', '_blank');
                ventana.document.write('<html><head><title>Imprimir Historial</title>');
                ventana.document.write('<style>table {width: 100%; border-collapse: collapse;} table, th, td {border: 1px solid black;} th, td {padding: 10px; text-align: left;} th {background-color: #f2f2f2;}</style>');
                ventana.document.write('</head><body>');
                ventana.document.write('<div style="text-align: center;">');
                ventana.document.write('<img src="img/logoconsultorio.png" alt="Logo Consultorio" style="width: 60px; height: auto;"><br>');
                ventana.document.write('<strong>CONSULTORIO MÉDICO "Medicina Familiar"</strong><br>');
                ventana.document.write('Dirección: Ruta n°8 - Simón Bolivar<br>');
                ventana.document.write('Teléfono: 0975388433<br>');
                ventana.document.write('Correo: medicinafamiliar2018@gmail.com<br>');
                ventana.document.write('</div><br>');
                ventana.document.write('<h2 style="text-align: center;">Historial Médico del Paciente</h2>');
                ventana.document.write('<h3 style="text-align: center;">Paciente: ' + pacienteNombre + '</h3>');
                ventana.document.write('<table>' + contenido + '</table>');
                ventana.document.write('</body></html>');
                ventana.document.close();
                ventana.print();
            }
        </script>
        <?php require 'menu/js_lte.ctp'; ?> <!-- Agrega tus scripts JavaScript si es necesario -->
    </body>
</html>
