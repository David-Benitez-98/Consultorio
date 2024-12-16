<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Agregar Detalle Ficha</title>
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
                                <div class="box-header with-border">
                                    <h3 class="box-title">DETALLE DE FICHA MEDICA <?= $_GET['vcod_ficha'] ?></h3>
                                    <div class="box-tools">

                                        <div>
                                            <a href="fichamedica_add.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                                <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                        </div>                         
                                    </div>

                                    <?php if (!empty($_SESSION['mensaje'])) { ?>
                                        <div class="alert alert-danger" role="alert" id="mensaje">
                                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                                            <?php
                                            echo $_SESSION['mensaje'];
                                            $_SESSION['mensaje'] = '';
                                            ?>
                                        </div>
                                    <?php } ?>
                                    <div class="box-body">
                                        <!-- Mensaje inicial oculto -->
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">                                                                                     
                                                <?php
                                                $detalletratamiento = consultas::get_datos("select * FROM v_fichamedica WHERE fich_cod = " . $_REQUEST['vcod_ficha']);
                                                if (!empty($detalletratamiento)) {
                                                    ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-condensed table-hover">
                                                            <thead>
                                                            <label>Datos Cabecera Ficha Médica</label>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Paciente</th>
                                                                <th>CI</th>
                                                                <th>Fecha de Nacimiento</th>
                                                                <th>Genero</th>

                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($detalletratamiento as $diag) { ?>
                                                                    <tr>
                                                                        <td data-title="#"><?php echo $diag['fich_cod']; ?></td>
                                                                        <td data-title="Paciente"><?php echo $diag['paciente']; ?></td>
                                                                        <td data-title="Paciente"><?php echo $diag['per_ci']; ?></td>
                                                                        <td data-title="Paciente"><?php echo $diag['per_fecnac']; ?></td>
                                                                        <td data-title="Paciente"><?php echo $diag['gen_descri']; ?></td>
                                                                    </tr>  
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary form-control" data-toggle="modal" data-target="#documentos-modal" 
                                                    class="btn btn-danger btn-sm" role="button" data-title="Documentos Varios" rel="tooltip" data-placement="top">
                                                Agregar Documentos
                                            </button>
                                        </div><br><br>
                                        <!--Inicio de detalle agregar-->
                                        <div class="row">
                                            <div class="col-md-6">                               
                                                <?php
                                                $detallealergias = consultas::get_datos("select * from v_detallealergias where fich_cod= " . $_GET['vcod_ficha']);
                                                if (!empty($detallealergias)) {
                                                    ?>
                                                    <div class="box-header">
                                                        <i class="fa fa-list"></i>
                                                        <h3 class="box-title">Detalles de Alergias</h3>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-condensed table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Alergias</th>
                                                                    <th>Sintomas</th>
                                                                    <th>Causas</th>
                                                                    <th class="text-center" >Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($detallealergias as $detalle) { ?>
                                                                    <tr>
                                                                        <td data-title="Doctor"><?php echo $detalle['ale_cod']; ?></td>
                                                                        <td data-title="Especialidad"><?php echo $detalle['ale_descri']; ?></td>
                                                                        <td data-title="Turno."><?php echo $detalle['ale_sintomas']; ?></td>
                                                                        <td data-title="Dia"><?php echo $detalle['ale_causa']; ?></td>
                                                                        <td class="text-center">
                                                                            <a onclick="editar(<?php echo $detalle['ale_cod'] . "_" . $detalle['ale_descri']; ?>)"
                                                                               class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a> 
                                                                            <a onclick="borrarAlergia('<?php echo $detalle['ale_cod'] . "_" . $detalle['ale_descri']; ?>')" 
                                                                               data-toggle="modal" data-target="#borrar" class="btn btn-danger btn-sm" role="button" data-title="Quitar" rel="tooltip" data-placement="top">
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
                                                        La ficha aún no tiene detalle de Alergias
                                                    </div>      
                                                <?php } ?>
                                            </div>
                                            <!--Inicio de detalle agregar-->
                                            <div class="col-md-6">                               
                                                <?php
                                                $detallepatologias = consultas::get_datos("select * from v_detallepatologias where fich_cod= " . $_GET['vcod_ficha']);
                                                if (!empty($detallepatologias)) {
                                                    ?>
                                                    <div class="box-header">
                                                        <i class="fa fa-list"></i>
                                                        <h3 class="box-title">Detalles de Patologías</h3>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-condensed table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Patologias</th>
                                                                    <th class="text-center" >Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($detallepatologias as $detalles) { ?>
                                                                    <tr>
                                                                        <td data-title="Doctor"><?php echo $detalles['fich_cod']; ?></td>
                                                                        <td data-title="Doctor"><?php echo $detalles['pat_cod']; ?></td>
                                                                        <td data-title="Especialidad"><?php echo $detalles['pat_descri']; ?></td>
                                                                        <td class="text-center">
                                                                            <a onclick="editar(<?php echo $detalles['pat_cod'] . "_" . $detalles['pat_descri']; ?>)"
                                                                               class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a> 
                                                                            <a onclick="borrarPatologia(<?php echo $detalles['fich_cod'] . "_" . $detalles['pat_cod']; ?>)" 
                                                                               data-toggle="modal" data-target="#borrarr" class="btn btn-danger btn-sm" role="button" data-title="Quitar" rel="tooltip" data-placement="top">
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
                                                        La ficha aún no tiene detalle de Patologias
                                                    </div>      
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!--Fin de detalle agregar-->

                                        <!--Fin de detalle -->
                                        <div class="row"> 
                                            <div class="col-md-6">
                                                <div class="box-body">
                                                    <form action="fichaalergiasdetalle_control.php" method="post">
                                                        <input type="hidden" name="accion" value="1">
                                                        <input type="text" name="cod_ficha" value="<?= $_GET['vcod_ficha'] ?>" hidden>
                                                        <input type="hidden" name="vale_cod"value="<?php echo $detallealergias[0]['ale_cod'] ?>"/>

                                                        <div class="col-md-12">
                                                            <div class="card-header text-center" style="background-color: #28a745; color: #ffffff;">
                                                                COMPLETA LOS DATOS DEL DETALLE
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-12">
                                                            <label for="vale_cod">Alergias:</label>
                                                            <?php
                                                            $especialidad = consultas::get_datos("SELECT * FROM alergias ORDER BY ale_cod");
                                                            ?>
                                                            <select class="form-control" name="vale_cod" required id="especialidad" return false;">
                                                                <option value="">Seleccionar Alergias</option>
                                                                <?php foreach ($especialidad as $espe) : ?>
                                                                    <option value="<?php echo $espe['ale_cod']; ?>"><?php echo $espe['ale_descri']; ?> - <?php echo $espe['ale_sintomas']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <div id="doctores"></div>
                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-success pull-right" onclick="location.reload();">
                                                                    <span class="glyphicon glyphicon-floppy-saved"></span> Agregar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="box-body">
                                                    <form action="fichapatologiasdetalle_control.php" method="post">
                                                        <input type="hidden" name="accion" value="1">
                                                        <input type="text" name="cod_ficha" value="<?= $_GET['vcod_ficha'] ?>" hidden>
                                                        <input type="hidden" name="vpat_cod"value="<?php echo $detallepatologias[0]['pat_cod'] ?>"/>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card-header text-center" style="background-color: #28a745; color: #ffffff;">
                                                                    COMPLETA LOS DATOS DEL DETALLE
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="col-md-12">
                                                                <label for="vpat_cod">Patologias:</label>
                                                                <?php
                                                                $especialidad = consultas::get_datos("SELECT * FROM patologias ORDER BY pat_cod");
                                                                ?>
                                                                <select class="form-control" name="vpat_cod" required id="especialidad" return false;">
                                                                    <option value="">Seleccionar Patologias</option>
                                                                    <?php foreach ($especialidad as $espe) : ?>
                                                                        <option value="<?php echo $espe['pat_cod']; ?>"><?php echo $espe['pat_descri']; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <div id="doctores"></div>
                                                                <div class="box-footer">
                                                                    <button type="submit" class="btn btn-success pull-right">
                                                                        <span class="glyphicon glyphicon-floppy-saved"></span> Agregar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Agregar mas al formulario-->
                                         <!--Inicio de detalle agregar-->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <?php
                                        $detallerecetas = consultas::get_datos("select * from vista_detalle_fichamedica where fich_cod= " . $_GET['vcod_ficha']);
                                        if (!empty($detallerecetas)) {
                                            ?>
                                            <div class="box">
                                                <div class="box-header with-border">
                                                    <i class="fa fa-list"></i>
                                                    <h3 class="box-title">DETALLES</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-condensed table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>ANTECEDENTES ENFERMEDADES</th>
                                                                    <th>CIRUGIAS ANTERIOS</th>
                                                                    <th>OBSERVACIONES</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($detallerecetas as $detalles) { ?>
                                                                    <tr>
                                                                        <td data-title="#"><?php echo $detalles['fich_cod']; ?></td>
                                                                        <td data-title="Medicamentos"><?php echo $detalles['fich_antecedentes_enfermedades']; ?></td>
                                                                        <td data-title="Indicaciones"><?php echo $detalles['fich_cirugias_anteriores']; ?></td>
                                                                        <td data-title="Hora"><?php echo $detalles['fich_observacion']; ?></td>
                                                                        <td class="text-center">
                                                                            
                                                                        </td>
                                                                    </tr> 
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                Lo agregado aún no tiene detalle
                                            </div>      
                                        <?php } ?>
                                    </div>
                                </div>

                                <!--Fin de detalle -->
                                <div class="box-body">
                                    <form action="fichamedicadetalle_control.php" method="post">
                                        <input type="hidden" name="accion" value="1">
                                       <input type="text" name="cod_ficha" value="<?= $_GET['vcod_ficha'] ?>" hidden>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>ANTECEDENTES ENFERMEDADES</label>
                                                <input type="text" class="form-control" name="vfich_antecedentes_enfermedades" id="vdetalle_obser" >
                                            </div>
                                            <div class="col-md-4">
                                                <label>CIRUGIAS ANTERIOS</label>
                                                <input type="text" class="form-control" name="vfich_cirugias_anteriores" id="vdetalle_obser" >
                                            </div>
                                            <div class="col-md-8">
                                                <label>OBSERVACION</label>
                                                <input type="text" class="form-control" name="vfich_observacion" id="vdetalle_obser" >
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            
                                            <button type="submit" class="btn btn-primary pull-right">
                                                <i class="fas fa-save"></i> Registrar <!-- Utilizo el ícono 'save' de Font Awesome para registrar -->
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
            <div class="modal" id="borrar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                            <h4 class="modal-title custom_align">ATENCIÓN...!!!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" id="confirmacion"></div>
                        </div>
                        <div class="modal-footer">
                            <a id="si" role="buttom" class="btn btn-danger">
                                <span class="glyphicon glyphicon-ok-sign"></span> SI
                            </a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> NO
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="borrarr" role="dialog">
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
            <!--Modal Detalle de Ficha -->
            <div class="modal" id="documentos-modal" role="dialog" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" >
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i><strong>Registrar Documentos Varios</strong></h4>
                        </div>
                        <form action="documentosvarios_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                            <input name="accion" value="1" type="hidden" />
                            <input name="vdocva_cod" value="0" type="hidden" />
                            <input type="text" name="cod_ficha" value="<?= $_GET['vcod_ficha'] ?>" hidden>
                            <div class="box-body">
                                <?php
                                date_default_timezone_set('America/Asuncion');
                                $fechaHoraActual = date('Y-m-d\TH:i:s', time()); // Formato ISO 8601
                                ?>
                                <div class="col-md-6">
                                    <label for="vfecha_hora">Fecha y Hora:</label>
                                    <input type="datetime-local" class="form-control" name="vfecha_hora" id="vfecha_hora" value="<?php echo $fechaHoraActual; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="vtipodo_cod">Tipo de Documento:</label>
                                    <?php
                                    $tipodocumentos = consultas::get_datos("SELECT * FROM tipo_documento ORDER BY tipodo_cod");
                                    ?>
                                    <select class="form-control" name="vtipodo_cod" required id="vtipodo_cod">
                                        <option value="0">Seleccionar Tipo de Documento</option>
                                        <?php foreach ($tipodocumentos as $tipodo) : ?>
                                            <option value="<?php echo $tipodo['tipodo_cod']; ?>"><?php echo $tipodo['tipodo_descri']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="vdocva_observacion">Observación:</label>
                                    <input type="text" value="SIN OBSERVACION" class="form-control" name="vdocva_observacion" id="vdocva_observacion">
                                </div>
                            </div>
                            <!-- Agrega este bloque después del formulario -->
                            <?php
                            $detallepatologias = consultas::get_datos("select * from v_documentos_varios where fich_cod= " . $_GET['vcod_ficha']);
                            if (!empty($detallepatologias)) {
                                ?>
                                <div class="box-header">
                                    <i class="fa fa-list"></i>
                                    <h3 class="box-title">Detalles de Documentos</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-condensed table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Tipo de Documento</th>
                                                <th>Observación</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($detallepatologias as $detalles) { ?>
                                                <tr>
                                                    <td data-title="Doctor"><?php echo $detalles['fich_cod']; ?></td>
                                                    <td data-title="Doctor"><?php echo $detalles['docva_fecha']; ?></td>
                                                    <td data-title="Doctor"><?php echo $detalles['tipo_documento']; ?></td>
                                                    <td data-title="Especialidad"><?php echo $detalles['docva_observacion']; ?></td>
                                                    <td class="text-center">
                                                    </td>
                                                </tr> 
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-info">
                                    <span class="glyphicon glyphicon-info-sign"></span> 
                                    La ficha aún no tiene detalle de Documentos
                                </div>      
                            <?php } ?>
                            <div class="box-footer">
                                <button type="reset" data-dismiss="modal" class="btn btn-default">
                                    <i class="fa fa-remove"></i> Cerrar
                                </button>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-floppy-o"></i> Registrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
            <script>
    // Espera a que el documento esté completamente cargado
    $(document).ready(function() {
        // Maneja el evento de envío del formulario
        $("#formulario").submit(function(event) {
            event.preventDefault();

            // Realiza la petición AJAX para actualizar la tabla de detalles
            $.ajax({
                type: "POST",
                url: "documentos-modal", // Ajusta la URL según tu estructura
                data: $(this).serialize(), // Envía los datos del formulario
                success: function(response) {
                    // Actualiza la tabla de detalles en el modal
                    $("#documentos-modal").html(response);

                    // Puedes cerrar el modal aquí si es necesario
                    // $("#documentos-modal").modal("hide");
                }
            });
        });
    });
</script>

        <script>
            // Función para mostrar el mensaje inicial
            function mostrarMensajeInicial() {
                $('#mensaje-inicial').show();
            }

            $(document).ready(function () {
            mostrarMensajeInicial(); // Muestra el mensaje inicial al abrir la página



                    function editar(oe_cod, tipooe_cod){
                    $.ajax({
                    type    : "GET",
                            url     : "ordenestudiodetalle_modificar.php?voe_cod=" + oe_cod + "&vtipooe_cod=" + tipooe_cod,
                            cache   : false,
                            beforeSend:function(){
                            $("#detalles").html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
                            },
                            success:function(data){
                            $("#detalles").html(data)
                            }
                    })
                    };
        </script>
        <script>
                    // Muestra el mensaje
                    document.getElementById('mensaje').style.display = 'block';
                    // Desaparece el mensaje después de 5 segundos
                    setTimeout(function() {
                    document.getElementById('mensaje').style.display = 'none';
                    }, 5000);
        </script>
        <script>

                    function borrarAlergia(vale_cod) {
                    $('#si').attr('href', 'fichaalergiasdetalle_control.php?vale_cod=' + vale_cod + '&accion=2');
                            $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
            ¿Deseas borrar el detalle de Alergias de la Ficha N° <strong>' + vale_cod + '</strong>?');
                    }

            function borrarPatologia(vpat_cod) {
            $('#sic').attr('href', 'fichapatologiasdetalle_control.php?vpat_cod=' + vpat_cod + '&accion=2');
                    $("#confirmacionc").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
            ¿Deseas borrar el detalle de Patología de la Ficha N° <strong>' + vpat_cod + '</strong>?');
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
     

        <?php require 'menu/js_lte.ctp'; ?> <!-- Agrega tus scripts JavaScript si es necesario -->
    </body>
</html>
