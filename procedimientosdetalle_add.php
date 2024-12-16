<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
    <title>Sistema Consultorio</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php
    session_start(); /* Reanudar sesion */
    require 'menu/css_lte.ctp';
    ?><!--ARCHIVOS CSS-->
    <style>
        .modal-header {
            border-top: 3px solid #007bff;
            /* Cambia #007bff por el color azul que prefieras */
        }
    </style>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
        <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php if (!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php
                                echo $_SESSION['mensaje'];
                                $_SESSION['mensaje'] = '';
                                ?>
                            </div>
                        <?php } ?>
                        <div class="box box-primary">
                            <div class="box-header">
                                <i class="fa fa-list"></i><i class="fa fa-plus"></i>
                                <h3 class="box-title">AGREGAR DETALLE DE PROCEDIMIENTO</h3>
                                <div class="box-tools">
                                    <a href="procedimientos_index.php" class="btn btn-primary btn-sm"
                                        data-title="Volver" rel="tooltip" data-placement="left">
                                        <i class="fa fa-arrow-left"></i> VOLVER</a>
                                </div>
                            </div>
                            <!--Inicio de cabecera -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?php
                                    $procedimientos = consultas::get_datos("select * FROM v_procedimiento WHERE proce_cod = (select max(proce_cod) from v_procedimiento)");
                                    if (!empty($procedimientos)) {
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Paciente</th>
                                                        <th>Tipo de Procedimiento</th>
                                                        <th>Descripción</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($procedimientos as $proce) { ?>
                                                        <tr>
                                                            <td data-title="#">
                                                                <?php echo $proce['proce_cod']; ?>
                                                            </td>
                                                            <td data-title="Paciente">
                                                                <?php echo $proce['paciente']; ?>
                                                            </td>
                                                            <td data-title="Fecha">
                                                                <?php echo $proce['tipoproce_descri']; ?>
                                                            </td>
                                                            <td data-title="Hora">
                                                                <?php echo $proce['proce_descri']; ?>
                                                            </td>
                                                            <td data-title="Estado">
                                                                <?php echo $proce['proce_estado']; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-info">
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                            Este Paciente no tiene Procedimiento...
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!--Fin de cabecera -->



                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?php
                                    $detalleproce = consultas::get_datos("select * FROM v_procedimiento WHERE proce_cod = (select max(proce_cod) from v_procedimiento)");
                                    if (!empty($detalleproce)) {
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed table-hover">

                                                <tbody>
                                                    <?php foreach ($detalleproce as $detalle) { ?>
                                                        <tr>
                                                            <td hidden="" class="proce_cod">
                                                                <?php echo $detalle['proce_cod']; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!--Inicio de detalle agregar-->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?php
                                    $detalleprocedimiento = consultas::get_datos("select * from v_detalleprocedimiento where proce_cod= " . $detalleproce[0]['proce_cod']);
                                    if (!empty($detalleprocedimiento)) {
                                        ?>
                                        <div class="box-header">
                                            <i class="fa fa-list"></i>
                                            <h3 class="box-title">DETALLES</h3>
                                            <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                                                data-target="#myModal">
                                                Ver Stock
                                            </button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Insumos</th>
                                                        <th>Tipo de Insumos</th>
                                                        <th>Cantidad</th>
                                                        <th>OBSERVACION</th>
                                                        <th class="text-center">Accciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($detalleprocedimiento as $detalles) { ?>
                                                        <tr>
                                                            <td data-title="#">
                                                                <?php echo $detalles['proce_cod']; ?>
                                                            </td>
                                                            <td data-title="Doctor">
                                                                <?php echo $detalles['insumo']; ?>
                                                            </td>
                                                            <td data-title="Doctor">
                                                                <?php echo $detalles['tipoins_descri']; ?>
                                                            </td>
                                                            <td data-title="Especialidad">
                                                                <?php echo $detalles['cantidad_utilizada']; ?>
                                                            </td>
                                                            <td data-title="Sala">
                                                                <?php echo $detalles['observacion']; ?>
                                                            </td>
                                                            <td class="text-center">


                                                                <a onclick="editar(<?php echo $detalles['proce_cod'] . "_" . $detalles['insumo']; ?>)"
                                                                    class="btn btn-warning btn-sm" data-title="Editar"
                                                                    rel="tooltip" data-placement="left" data-toggle="modal"
                                                                    data-target="#editar">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a onclick="borrar('<?php echo $detalles['proce_cod'] . "_" . $detalles['insumo']; ?>)"
                                                                    data-toggle="modal" data-target="#borrar"
                                                                    class="btn btn-danger btn-sm" role="button"
                                                                    data-title="Quitar" rel="tooltip" data-placement="top">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-info">
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                            El Procedimiento aún no tiene detalle
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!--Fin de detalle -->
                            <div class="box-body">
                                <form action="procedimientosdetalle_control.php" method="post">
                                    <input type="hidden" name="accion" value="1">
                                    <input type="hidden" name="vproce_cod"
                                        value="<?php echo $detalleproce[0]['proce_cod'] ?>" />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-header text-center"
                                                style="background-color: #28a745; color: #ffffff;">
                                                COMPLETA LOS DATOS DEL DETALLE
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="vins_cod">Insumos:</label>
                                            <?php
                                            $insumos = consultas::get_datos("SELECT * FROM v_insumo ORDER BY ins_cod");
                                            ?>
                                            <select class="form-control" name="vins_cod" required id="vins_cod">
                                                <option value="0">Seleccionar Insumos</option>
                                                <?php foreach ($insumos as $insumo): ?>
                                                    <option value="<?php echo $insumo['ins_cod']; ?>">
                                                        <?php echo $insumo['ins_nombre']; ?> -
                                                        <?php echo $insumo['ins_descri']; ?>
                                                    <?php endforeach; ?>
                                            </select>
                                            <div id="doctores"></div>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Cantidad Utilizada</label>
                                            <input type="numeric" class="form-control" name="vcantidad_utilizada"
                                                id="vcantidad_utilizada">
                                        </div>

                                        <div class="col-md-3">
                                            <label>Observacion</label>
                                            <input type="text" value="SIN OBSERVACION" class="form-control"
                                                name="vobservacion" id="vobservacion">
                                        </div>
                                        <br>
                                    </div>
                                    <div class="box-footer">
                                        <a href="procedimientosdetalle_add.php" class="btn btn-default">
                                            <i class="fa fa-remove"></i> CERRAR
                                        </a>
                                        <button type="submit" class="btn btn-primary pull-right">
                                            <span class="glyphicon glyphicon-floppy-saved"></span> Registrar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
        <!-- Modal -->
        <style>
            .borde-azul thead tr th {
                border-top: 3px solid #007bff;
            }

            .borde-verde thead tr th {
                border-top: 3px solid #28a745;
            }

            .borde-rojo thead tr th {
                border-top: 3px solid #dc3545;
            }

            .borde-amarillo thead tr th {
                border-top: 3px solid #ffc107;
            }

            .borde-morado thead tr th {
                border-top: 3px solid #6f42c1;
            }
        </style>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Stock</h4>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido de la tabla con bordes de arriba -->
                        <?php
                        $stock = consultas::get_datos("SELECT * FROM v_stock ORDER BY stock_cod");
                        if (!empty($stock)) {
                            ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed table-hover borde-azul">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Insumo</th>
                                            <th>Tipo de Insumo</th>
                                            <th>Marca</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($stock as $st) { ?>
                                            <tr>
                                                <td data-title="#">
                                                    <?php echo $st['stock_cod']; ?>
                                                </td>
                                                <td data-title="Insumo">
                                                    <?php echo $st['insumo']; ?>
                                                </td>
                                                <td data-title="Tipo de Insumo">
                                                    <?php echo $st['tipoinsumo']; ?>
                                                </td>
                                                <td data-title="Marca">
                                                    <?php echo $st['marca']; ?>
                                                </td>
                                                <td data-title="Cantidad">
                                                    <?php echo $st['cantidadinsumo']; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                Este Paciente no tiene Procedimiento...
                            </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- INICIO MODAL confirmar-->
        <div class="modal" id="confirmar" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                        <h4 class="modal-title custom_align">ATENCIÓN...!!!</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" id="confirmacion"></div>
                    </div>
                    <div class="modal-footer">
                        <a id="si" role="buttom" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok-sign"></span> SI
                        </a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> NO
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin MODAL confirmar-->
        <div class="modal" id="borrar" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                        <h4 class="modal-title custom_align">ATENCIÓN...!!!</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" id="confirmacionc"></div>
                    </div>
                    <div class="modal-footer">
                        <a id="sic" role="buttom" class="btn btn-danger">
                            <span class="glyphicon glyphicon-ok-sign"></span> SI
                        </a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> NO
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN MODAL BORRAR-->
    </div>
    <script>
        function borrar(datos, fechaInicio, fechaFin) {
            var dat = datos.split('_');
            var fechaInicioFormatted = encodeURIComponent(fechaInicio);
            var fechaFinFormatted = encodeURIComponent(fechaFin);
            var queryString = 'tratamientodetalle_control.php?vtra_cod=' + dat[0] +
                '&vtipotra_cod=' + dat[1] + '&accion=3' +
                '&vtra_fechainicio=' + fechaInicioFormatted +
                '&vtra_fechafin=' + fechaFinFormatted;
            $('#sic').attr('href', queryString);
            $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
    Desea confirmar el tratamiento </strong>');
        }



        function agregardetalle() {
            if ($("#vtipotra_cod").val() === "0") {
                alert("Debes seleccionar un Tipo de Tratamiento");
                return;
            }

            let repetido = false;
            $("#detalle_consulta tr").each(function (index, tr) {
                if ($(tr).find("td:eq(0)").text() === $("#venfe_cod").val()) {
                    repetido = true;
                }
            });
            if (repetido) {
                alert("El Tipo de Tratamiento ya ha sido agregado");
                return;
            }
            let fila = "<tr>";
            fila += `<td>${$("#vtipotra_cod").val()}</td>`;
            fila += `<td>${$("#vtipotra_cod option:selected").html()}</td>`;
            fila += `<td>${$("#vdetalle_obser").val()}</td>`;
            fila += `<td>${$("#vprecio").val()}</td>`;
            fila += `<td><button class='btn btn-danger remover-item' onclick='remover($(this).closest("tr")); return false;'>Borrar</button></td>`;
            fila += "</tr>";
            $("#detalle_consulta").append(fila);
        }
        function remover(tr) {
            $(tr).remove();
        }
        function confirmar(datos) {
            var dat = datos.split('_');

            // Intenta obtener los valores de fecha por ID si están disponibles
            var fechaInicio = document.getElementById("vtra_fechainicio") ? document.getElementById("vtra_fechainicio").value : '';
            var fechaFin = document.getElementById("vtra_fechafin") ? document.getElementById("vtra_fechafin").value : '';

            // Si no se pudo obtener por ID, intenta por nombre
            if (!fechaInicio || !fechaFin) {
                fechaInicio = document.getElementsByName("vtra_fechainicio")[0] ? document.getElementsByName("vtra_fechainicio")[0].value : '';
                fechaFin = document.getElementsByName("vtra_fechafin")[0] ? document.getElementsByName("vtra_fechafin")[0].value : '';
            }

            $('#si').attr('href', 'tratamientodetalle_control.php?vtra_cod=' + dat[0] + '&vtipotra_cod=' + dat[1] + '&accion=2&vtra_fechainicio=' + fechaInicio + '&vtra_fechafin=' + fechaFin);
            $("#confirmacion").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
    Desea confirmar el tratamiento </strong>');
        }


    </script>
    <?php require 'menu/js_lte.ctp'; ?>
    <script>
        // Muestra el mensaje
        document.getElementById('mensaje').style.display = 'block';

        // Desaparece el mensaje después de 5 segundos
        setTimeout(function () {
            document.getElementById('mensaje').style.display = 'none';
        }, 5000);
    </script>
    <script>
        $("#mensaje").delay(4000).slideUp(200, function () {
            $(this).alert('close');
        });
    </script>
</body>

</html>