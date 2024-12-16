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
                                    <h3 class="box-title">AGREGAR DETALLE DE DIAGNOSTICO</h3>
                                    <div class="box-tools">
                                        <a href="diagnostico_index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                   
                                    </div>
                                </div>
                                 <div class="buttons-container">
                                     <a href="tratamiento_add.php" class="btn btn-success btn-secondary"
                                           data-title="Agregar" rel="tooltip"> <i class="fa fa-plus">  </i>Tratamientos a seguir</a>
                                    </div>
                                <!--Inicio de cabecera -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                                                                     
                                        <?php
                                        $diagnostico = consultas::get_datos("select * FROM v_diagnostico WHERE diag_cod = (select max(diag_cod) from v_diagnostico)");
                                        if (!empty($diagnostico)) {
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Paciente</th>
                                                            <th>Fecha</th>
                                                            <th>Hora</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($diagnostico as $diag) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $diag['diag_cod']; ?></td>
                                                                <td data-title="Paciente"><?php echo $diag['paciente']; ?></td>
                                                                <td data-title="Fecha"><?php echo $diag['diag_fecha']; ?></td>
                                                                <td data-title="Hora"><?php echo $diag['diag_hora']; ?></td>
                                                                <td data-title="Estado"><?php echo $diag['diag_estado']; ?></td>
                                                            </tr>  
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                No se han registrado detalle de DIAGNOSTICO...
                                            </div>      
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--Fin de cabecera -->
                                <!--Inicio de Detalle -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                               
                                        <?php
                                        $detalletratamientos = consultas::get_datos("select * from v_diagnosticodetalle where diag_cod= " . $_REQUEST['vdiag_cod']);
                                        if (!empty($detalletratamientos)) {
                                            ?>
                                            <div class="box-header">
                                                <i class="fa fa-list"></i>
                                                <h3 class="box-title">Detalle Diagnostico</h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Enfermedades Diagnosticada</th>
                                                            <th>Tipo de Enfermedades</th>
                                                            <th>Descripcion</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalletratamientos as $detalles) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $detalles['diag_cod']; ?></td>
                                                                <td data-title="Doctor"><?php echo $detalles['enfe_descri']; ?></td>
                                                                <td data-title="Doctor"><?php echo $detalles['tipoenfe_descri']; ?></td>
                                                                <td data-title="Especialidad"><?php echo $detalles['diag_descri']; ?></td>
                                                                <td class="text-center">

                                                                    <a onclick="editar(<?php echo $detalles['diag_cod']; ?>)"
                                                                       class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a> 
                                                                    <a onclick="borrar('<?php echo $detalles['diag_cod']; ?>')" 
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
                                                Diagnostico aún no tiene detalle
                                            </div>      
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <form action="diagnosticodetalle_control.php" method="post">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vdiag_cod" value="<?php echo $diagnostico[0]['diag_cod'] ?>"/>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card-header text-center" style="background-color: #28a745; color: #ffffff;">
                                                    COMPLETA LOS DATOS DEL DETALLE
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="venfe_cod">Enfermedad:</label>
                                                <?php
                                                $enfermedad = consultas::get_datos("SELECT * FROM v_enfermedades ORDER BY enfe_cod");
                                                ?>
                                                <select class="form-control" name="venfe_cod" required id="venfe_cod">
                                                    <option value="0">Seleccionar Enfermedad</option>
                                                    <?php foreach ($enfermedad as $enfe) : ?>
                                                        <option value="<?php echo $enfe['enfe_cod']; ?>"><?php echo $enfe['enfermedad']; ?> - <?php echo $enfe['enfe_descri']; ?></option>
                                                    <?php endforeach; ?><?php echo $enfe['enfe_descri']; ?>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary btn-flat leftS" type="button" data-title="Agregar Enfermedades"
                                                            rel="tooltip"   data-toggle="modal" data-target="#registrar">
                                                        <i  class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                                <div id="doctores"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Observacion</label>
                                                <input type="text" class="form-control" name="vdiag_descri" id="vdiag_descri" >
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <a href="diagnostico_index.php" class="btn btn-danger">
                                                <i class="fa fa-remove"></i> Cerrar
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
            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
            <div class="modal" id="registrar" role="dialog" >
            <div class="modal-dialog">
             <div class="modal-content">
                    <div class="modal-header" >
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i><strong>Agregar Enfermedades</strong></h4>
                    </div>
                 <form action="enfermedades_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                        <input name="accion" value="1" type="hidden"/>
                        <input name="venfe_cod" value="0" type="hidden"/>
                        <div class="box-body">
                           <div class="form-group">
                                <label class="control-label col-lg-4">Nombre:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="venfe_descri" required autofocus>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-lg-4">Tipo de Enfermedad:</label>
                                <div class="col-lg-8">
                                    <?php $genero = consultas::get_datos("select * from tipo_enfermedad order by tipoenfe_cod"); ?>
                                    <select class="form-control" name="vtipoenfe_cod" required>
                                        <option value="">Seleccionar Tipo de Enfermedad</option>
                                        <?php
                                        if (!empty($genero)) {
                                            foreach ($genero as $gen) {
                                                ?>
                                                <option value="<?php echo $gen['tipoenfe_cod'] ?>"><?php echo $gen['tipoenfe_descri'] ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
<?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="reset" data-dismiss="modal" class="btn btn-default">
                                <i class="fa fa-remove" ></i>Cerrar</button>
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="fa fa-floppy-o" ></i>Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- fin Modal Agregar-->
        </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        </script>
        <script>
            function agregardetalle() {
                if ($("#venfe_cod").val() === "0") {
                    alert("Debes seleccionar una enfermedad");
                    return;
                }

                let repetido = false;
                $("#detalle_consulta tr").each(function (index, tr) {
                    if ($(tr).find("td:eq(0)").text() === $("#venfe_cod").val()) {
                        repetido = true;
                    }
                });
                if (repetido) {
                    alert("La Enfermedad ya ha sido agregado");
                    return;
                }
                let fila = "<tr>";
                fila += `<td>${$("#venfe_cod").val()}</td>`;
                fila += `<td>${$("#venfe_cod option:selected").html()}</td>`;
                fila += `<td>${$("#vdiag_descri").val()}</td>`;
                fila += `<td><button class='btn btn-danger remover-item' onclick='remover($(this).closest("tr")); return false;'>Borrar</button></td>`;
                fila += "</tr>";
                $("#detalle_consulta").append(fila);
            }
            function remover(tr) {
                $(tr).remove();
            }
        </script>
    </body>
</html>

