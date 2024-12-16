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
                                    <h3 class="box-title">AGREGAR DETALLE DE TRATAMIENTO</h3>
                                    <div class="box-tools">
                                        <a href="tratamiento_index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                    </div>
                                </div>
                                <!--Inicio de cabecera -->
                                
                                <!--Fin de cabecera -->
                               <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                                                                     
                                        <?php
                                        $detalletratamiento = consultas::get_datos("select * FROM v_tratamientos WHERE tra_cod = (select max(tra_cod) from v_tratamientos)");
                                        if (!empty($detalletratamiento)) {
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                    <label>Datos Cabecera Tratamiento</label>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Paciente</th>
                                                            <th>Fecha</th>
                                                            <th>#Diagnostico</th>
                                                            <th>Enfermedad</th>
                                                            <th>Tipo de Enfermedad</th>
                                                            <th>Descripcion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalletratamiento as $diag) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $diag['tra_cod']; ?></td>
                                                                <td data-title="Paciente"><?php echo $diag['paciente']; ?></td>
                                                                <td data-title="Fecha"><?php echo $diag['tra_fecha']; ?></td>
                                                                <td data-title="Estado"><?php echo $diag['diag_cod']; ?></td>
                                                                <td data-title="Estado"><?php echo $diag['enfe_descri']; ?></td>
                                                                <td data-title="Estado"><?php echo $diag['tipoenfe_descri']; ?></td>
                                                                <td data-title="Estado"><?php echo $diag['diag_descri']; ?></td>
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
                                        $detalletratamientos = consultas::get_datos("select * from v_detalletratamiento where tra_cod= ".$_REQUEST['vtra_cod']); 
                                        if (!empty($detalletratamientos)) {
                                            ?>
                                            <div class="box-header">
                                                <i class="fa fa-list"></i>
                                                <h3 class="box-title">DETALLES</h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>TIPO TRATAMIENTO</th>
                                                            <th>PRECIO</th>
                                                            <th>FECHA INICIO</th>
                                                            <th>FECHA FIN</th>
                                                            <th>OBSERVACION</th>
                                                            <th>ESTADO</th>
                                                            <th class="text-center" >Accciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalletratamientos as $detalles) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $detalles['tra_cod']; ?></td>
                                                                <td data-title="Doctor"><?php echo $detalles['tipotra_descri']; ?></td>
                                                                <td data-title="Especialidad"><?php echo $detalles['precio']; ?></td>
                                                                <td data-title="Turno."><?php echo $detalles['tra_fechainicio']; ?></td>
                                                                <td data-title="Dia"><?php echo $detalles['tra_fechafin']; ?></td>
                                                                <td data-title="Sala"><?php echo $detalles['detalle_observ']; ?></td>
                                                                <td data-title="Sala"><?php echo $detalles['detalle_estado']; ?></td>
                                                                <td class="text-center">
                                                                    <?php /*if ($detalles['detalle_estado'] == 'PENDIENTE') { */?>
                                                                    <a onclick="confirmar('<?php echo $detalles['tra_cod'] . "_" . $detalles['tipotra_cod']; ?>')" 
                                                                       class="btn btn-success btn-sm" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar">
                                                                        <i class="fa fa-check"></i></a>
                                                                    <a onclick="editar(<?php echo $detalles['tra_cod'] . "_" . $detalles['tipotra_descri']; ?>)"
                                                                       class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a> 
                                                                    <a onclick="borrar('<?php echo $detalles['tra_cod'] . "_" . $detalles['tipotra_cod']; ?>', '<?php echo $detalles['tra_fechainicio']; ?>', '<?php echo $detalles['tra_fechafin']; ?>')" 
                                                                       data-toggle="modal" data-target="#borrar" class="btn btn-danger btn-sm" role="button" data-title="Quitar" rel="tooltip" data-placement="top">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                    <?php/* }*/ ?>
                                                                </td>
                                                            </tr> 
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                El tratamiento aún no tiene detalle
                                            </div>      
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--Fin de detalle -->
                                <div class="box-body">
                                    <form action="tratamientodetalle_control.php" method="post">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vtra_cod"value="<?php echo $detalletratamiento[0]['tra_cod'] ?>"/>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card-header text-center" style="background-color: #28a745; color: #ffffff;">
                                                    COMPLETA LOS DATOS DEL DETALLE
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="vtipotra_cod">Tipo de Tratamiento:</label>
                                                <?php
                                                $tipotratamiento = consultas::get_datos("SELECT * FROM v_tipo_tratamiento ORDER BY tipotra_cod");
                                                ?>
                                                <select class="form-control" name="vtipotra_cod" required id="vtipotra_cod">
                                                    <option value="0">Seleccionar Tipo de Tratamiento</option>
                                                    <?php foreach ($tipotratamiento as $tipotra) : ?>
                                                        <option value="<?php echo $tipotra['tipotra_cod']; ?>"><?php echo $tipotra['tipotra_descri']; ?> <?php endforeach; ?>
                                                </select>
                                                <div id="doctores"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Observacion</label>
                                                <input type="text" class="form-control" name="vdetalle_obser" id="vdetalle_obser" >
                                            </div>

                                            <div class="col-md-3">
                                                <label>Precio</label>
                                                <input type="text" value="50.000" class="form-control" name="vprecio" id="vprecio" >
                                            </div>
                                            <br>
                                            <div class="col-md-3">
                                                <label class="control-label">FECHA INICIO:</label>
                                                <input type="date" name="vtra_fechainicio" class="form-control" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label">FECHA INICIO:</label>
                                                <input type="date" name="vtra_fechafin" class="form-control" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <a href="tratamiento_index.php" class="btn btn-default">
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
            $('#mensaje').delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        </script><!-- Agrega tus scripts JavaScript si es necesario -->
    </body>
</html>

