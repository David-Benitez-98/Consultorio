<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Agregar Justificativo</title>
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
                                    <h3 class="box-title">Agregar Justificativo Médico</h3>
                                </div>
                                <div class="box-tools">
                                    <a href="justificativomedico_index.php" class="btn btn-primary btn-sm float-left" data-title="Volver" rel="tooltip" data-placement="right">
                                        <i class="fa fa-arrow-left"></i> VOLVER
                                    </a>  
                                </div>

                                <div class="box-body">
                                    <form action="justificativomedico_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                        <input type="hidden" name="pac_cod" id="pac_cod" value="">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vjus_cod" value="0">
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
                                                <select  name="vdiag_cod" id="paciente_diagnostico" class="form-control" onchange="cargardiagnostico(); return false;">
                                                    <?php
                                                    $diagnostico = consultas::get_datos("SELECT 
                                                        d.diag_cod,
                                                        d.pac_cod,
                                                        per.per_nombre,
                                                        per.per_apellido,
                                                        d.diag_fecha,
                                                        d.diag_hora,
                                                        array_agg(DISTINCT dd.enfe_cod),
                                                        array_agg(DISTINCT e.enfe_descri)
                                                    FROM 
                                                        diagnostico d
                                                    JOIN 
                                                        pacientes p ON d.pac_cod = p.pac_cod
                                                    JOIN 
                                                        persona per ON per.per_cod = p.per_cod
                                                    LEFT JOIN 
                                                        detalle_diagnostico dd ON d.diag_cod = dd.diag_cod
                                                    LEFT JOIN 
                                                        enfermedades e ON dd.enfe_cod = e.enfe_cod
                                                    WHERE 
                                                        d.diag_estado = 'HECHO'
                                                    GROUP BY 
                                                        d.diag_cod, d.pac_cod, per.per_nombre, per.per_apellido, d.diag_fecha, d.diag_hora
                                                    ORDER BY 
                                                        d.diag_cod;
                                                    ");
                                                    ?>
                                                    <option value="0">Seleccione Paciente</option>
                                                    <?php foreach ($diagnostico as $diag) : ?>
                                                        <option value="<?php echo $diag['diag_cod']; ?>" data-pac-cod="<?php echo $diag['pac_cod']; ?>">
                                                            <?= $diag['per_nombre']; ?> <?= $diag['per_apellido']; ?>
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
                                                        <th>Tipo de Enfermedad</th>
                                                        <th>Enfermedad</th>
                                                        <th>Observacion</th>
                                                        </thead>
                                                        <tbody id="datos_diagnostico">
                                                            <tr>
                                                                <td colspan="6">
                                                                    <div class="alert alert-info">
                                                                        <span class="glyphicon glyphicon-info-sign"></span> 
                                                                        No se han seleccionado Diagnostico...
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>   
                                        </div>
                                        <div class="box-footer">
                                            <a href="justificativomedico_index.php" class="btn btn-default">
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
    // Función para mostrar el mensaje inicial
    function mostrarMensajeInicial() {
        $('#mensaje-inicial').show();
    }

    function cargardiagnostico() {
        if ($("#paciente_diagnostico").val() === "0") {
            $('#datos_diagnostico').html(`<tr>
                                        <td colspan="10"><div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                No se han seleccionado Paciente de Diagnostico...
                                            </div></td>
                                    </tr>`);
        } else {
            $.ajax({
                type: "GET",
                url: "tratamiento_datodiagnostico.php?cod=" + $('#paciente_diagnostico').val(),
                cache: false,
                beforeSend: function () {
                    $('#datos_diagnostico').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
                },
                success: function (data) {
                    console.log(data);
                    $('#datos_diagnostico').html(data);

                    // Obtener el código del paciente seleccionado
                    var pacCod = $('#paciente_diagnostico').find(':selected').data('pac-cod');

                    // Asignar el código del paciente a un campo oculto en el formulario
                    $('#pac_cod').val(pacCod);
                }
            });
        }
    }

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
