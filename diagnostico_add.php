<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Agregar Diagnostico</title>
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
                                    <h3 class="box-title">Agregar Diagnostico</h3>
                                </div>
                                <div class="box-tools">
                                    <a href="diagnostico_index.php" class="btn btn-primary btn-sm float-left" data-title="Volver" rel="tooltip" data-placement="left">
                                        <i class="fa fa-arrow-left"></i> VOLVER
                                    </a>  
                                </div>
                                <div class="box-body">
                                    <form action="diagnostico_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                        <input type="hidden" name="pac_cod" id="pac_cod" value="">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vdiag_cod" value="0">
                                        <!--Inicio de cabecera -->
                                        <div class="row">
                                            <?php
                                            date_default_timezone_set('America/Asuncion');
                                            $fechaHoraActual = date('Y-m-d\TH:i:s', time()); // Formato ISO 8601
                                            ?>
                                            <div class="col-md-3">
                                                <input type="datetime-local" class="form-control" disabled="" name="vfecha_hora" id="vfecha_hora" value="<?php echo $fechaHoraActual; ?>">
                                            </div>
                                            <br>
                                            <br>
                                            <div class="col-md-4">
                                                <label>ORDEN DE ESTUDIO</label>
                                                <select  name="voe_cod" id="paciente_ordenestudio" class="form-control" onchange="cargarestudios(); return false;">
                                                    <?php
                                                    $ordenestudio = consultas::get_datos("SELECT oe.oe_cod, 
                                                        oe.pac_cod,
                                                         per.per_nombre,
                                                         per.per_apellido
                                                        FROM 
                                                            orden_estudio oe
                                                        JOIN 
                                                            detalle_ordenestudio det ON oe.oe_cod = det.oe_cod
                                                        JOIN 
                                                            pacientes p ON oe.pac_cod = p.pac_cod
                                                        JOIN 
                                                            persona per ON per.per_cod = p.per_cod
                                                       where 
                                                            oe.oe_estado = 'CONFIRMADO'");
                                                    ?>
                                                    <option value="0">Orden de estudios</option>
                                                    <?php foreach ($ordenestudio as $oe) : ?>
                                                        <option value="<?php echo $oe['oe_cod']; ?>" data-pac-cod="<?php echo $oe['pac_cod']; ?>">
                                                            <?= $oe['per_nombre']; ?> <?= $oe['per_apellido']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>ORDEN DE ANALISIS</label>
                                                <select name="voa_cod" id="paciente_ordenanalisis" class="form-control" onchange="cargaranalisis(); return false;">
                                                    <?php
                                                    $ordenanalisis = consultas::get_datos("SELECT oa.oa_cod, 
                                                           oa.pac_cod, 
                                                           per.per_nombre, 
                                                           per.per_apellido
                                                    FROM orden_analisis oa
                                                    LEFT JOIN detalle_ordenanalisis det ON oa.oa_cod = det.oa_cod
                                                    LEFT JOIN pacientes p ON oa.pac_cod = p.pac_cod
                                                    LEFT JOIN persona per ON per.per_cod = p.per_cod
                                                    WHERE oa.oa_estado = 'CONFIRMADO'");
                                                    ?>
                                                    <option value="">Orden de Analisis</option>
                                                    <?php foreach ($ordenanalisis as $oa) : ?>
                                                        <option value="<?php echo $oa['oa_cod']; ?>" data-pac-cod="<?php echo $oa['pac_cod']; ?>">
                                                            <?= $oa['per_nombre']; ?> <?= $oa['per_apellido']; ?>
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
                                                        <th>#</th>
                                                        <th>Paciente</th>
                                                        <th>Fecha</th>
                                                        <th>Tipo de Orden Estudio</th>
                                                        <th>Observacion</th>
                                                        </thead>
                                                        <tbody id="datos_consulta">
                                                            <tr>
                                                                <td colspan="5">
                                                                    <div class="alert alert-info">
                                                                        <span class="glyphicon glyphicon-info-sign"></span> 
                                                                        No se han seleccionado Orden de estudio...
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-condensed table-hover">
                                                            <thead>
                                                            <th>#</th>
                                                            <th>Paciente</th>
                                                            <th>Fecha</th>
                                                            <th>Tipo de Orden Analisis</th>
                                                            <th>Observacion</th>
                                                            </thead>
                                                            <tbody id="datos_consultas">
                                                                <tr>
                                                                    <td colspan="5">
                                                                        <div class="alert alert-info">
                                                                            <span class="glyphicon glyphicon-info-sign"></span> 
                                                                            No se han seleccionado Orden de Analisis...
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <a href="diagnostico_index.php" class="btn btn-danger">
                                                    <i class="fa fa-remove"></i> CANCELAR
                                                </a>   
                                                <button type="submit" class="btn btn-primary pull-right">
                                                    <i class="fa fa-floppy-o"></i> Ir a Detalles
                                                </button>
                                            </div>
                                    </form>
                                </div>
                                <!--Fin de cabecera -->
                            </div>
                        </div>
                    </div>
            </div>
        </section>
    </div>
    <?php require 'menu/footer_lte.ctp'; ?>
    <!--INICIA MODAL REGISTRAR-->

    <!--FIN MODAL REGISTRAR-->
</div>
<script>
    function cargarestudios() {
        if ($("#paciente_ordenestudio").val() === "0") {
            $('#datos_consulta').html(`<tr>
                                        <td colspan="10"><div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                No se han seleccionado Paciente de Orden de Estudio...
                                            </div></td>
                                    </tr>`);
        } else {
            $.ajax({
                type: "GET",
                url: "diagnostico_datoordenestudio.php?cod=" + $('#paciente_ordenestudio').val(),
                cache: false,
                beforeSend: function () {
                    $('#datos_consulta').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
                },
                success: function (data) {
                    console.log(data);
                    $('#datos_consulta').html(data);

                    // Obtener el código del paciente seleccionado
                    var pacCod = $('#paciente_ordenestudio').find(':selected').data('pac-cod');

                    // Asignar el código del paciente a un campo oculto en el formulario
                    $('#pac_cod').val(pacCod);
                }
            });
        }
    }
    function cargaranalisis() {
        var selectedVal = $("#paciente_ordenanalisis").val();
        console.log("Selected Order Analysis ID: " + selectedVal);

        if (selectedVal === "") {
            $('#datos_consultas').html(`<tr>
            <td colspan="10"><div class="alert alert-info">
                <span class="glyphicon glyphicon-info-sign"></span> 
                No se han seleccionado Paciente de Orden de Analisis...
            </div></td>
        </tr>`);
        } else {
            $.ajax({
                type: "GET",
                url: "diagnostico_datoordenanalisis.php?oacod=" + selectedVal,
                cache: false,
                beforeSend: function () {
                    $('#datos_consultas').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
                },
                success: function (data) {
                    console.log("Response Data: ", data);
                    $('#datos_consultas').html(data);

                    // Obtener el código del paciente seleccionado
                    var pacCod = $('#paciente_ordenanalisis').find(':selected').data('pac-cod');
                    console.log("Patient Code: " + pacCod);

                    // Asignar el código del paciente a un campo oculto en el formulario
                    $('#pac_cod').val(pacCod);
                },
                error: function (xhr, status, error) {
                    console.log("Error: " + error);
                    console.log("Status: " + status);
                }
            });
        }
    }

</script>
<script>
    function agregardetalle() {
        if ($("#tipoconsulta").val() === "0") {

            alert("Debes seleccionar un tipo de consulta");
            return;
        }
        if ($("#vcons_descri").val().length === 0) {
            alert("Debes ingresar una descripcion");
            return;
        }
        if ($("#vprecio").val().length === 0) {
            alert("Debes ingresar un precio");
            return;
        }
        if (parseInt($("#vprecio").val()) <= 0) {
            alert("El precio no puede ser menor o igual a cero");
            return;
        }
        let repetido = false;

        $("#detalle_consulta tr").each(function (evt) {
            if ($(this).find("td:eq(0)").text() === $("#tipoconsulta").val()) {
                repetido = true;
            }
        });

        if (repetido) {
            alert("El tipo de consulta ya ha sido agregado");
            return;
        }
        let fila = "";
        fila += `<tr>`;
        fila += `<td>${$("#tipoconsulta").val()}</td>`;
        fila += `<td>${$("#tipoconsulta option:selected").html()}</td>`;
        fila += `<td>${$("#vdescripcion").val()}</td>`;
        fila += `<td>${$("#vprecio").val()}</td>`;
        fila += `<td><button class='btn btn-danger'>Remover</button></td>`;
        fila += `</tr>`;

        $("#detalle_consulta").append(fila);

    }
</script>
<?php require 'menu/js_lte.ctp'; ?> 
<script>
    $('#mensaje').delay(4000).slideUp(200, function () {
        $(this).alert('close');
    });
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
</body>
</html>
