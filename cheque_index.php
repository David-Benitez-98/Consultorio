<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Sistema Consultorio</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php
        session_start(); // Iniciar sesión
        require 'menu/css_lte.ctp'; // Incluir archivo CSS
        ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?> <!-- Incluir encabezado -->
            <?php require 'menu/toolbar_lte.ctp'; ?> <!-- Incluir barra de herramientas/menú -->

            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
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
                                <div class="box-header">
                                    <i class="fa fa-meh-o" aria-hidden="true"></i>
                                    <i class="ion ion-person"></i>
                                    <h3 class="box-title">Mantener Referencial Cheques</h3>
                                    <div class="box-tools">
                                        <!-- Botón para abrir el modal de agregar persona -->
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregarCheque">
                                            Agregar
                                        </button>
                                        <a href="personas_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form action="enfermedades_index.php" method="post" accept-charset="utf8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" class="form-control" name="buscar" placeholder="Buscar..." autofocus="">
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-success btn-flat" data-title="Buscar" data-placement="bottom" rel="tooltip">
                                                                        <span class="fa fa-search"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
                                            $valor = '';
                                            if (isset($_REQUEST['buscar'])) {
                                                $valor = $_REQUEST['buscar'];
                                            }
                                            $cheque = consultas::get_datos("select * from v_cheques where (che_cod||trim(upper(titular_cheque))) like trim(upper('%" . $valor . "%')) order by che_cod");
                                            if (!empty($cheque)) {
                                                ?>
                                                <table class="table table-condensed table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            <th>Cheque</th>
                                                            <th>Banco</th>
                                                            <th>Estado</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($cheque as $per) { ?>
                                                            <tr>
                                                                <td data-title="N° Cedula"><?php echo $per['che_cod']; ?></td>
                                                                <td data-title="Telefono"><?php echo $per['che_descri']; ?></td>
                                                                <td data-title="Direccion"><?php echo $per['ban_descri']; ?></td>
                                                                <td data-title="Direccion"><?php echo $per['estado_cheque']; ?></td>
                                                                <td data-title="Acciones" class="text-center">
                                                                    <?php if ($per['estado_cheque'] == 'ACTIVO') { ?>
                                                                        
                                                                    <?php } else { ?>
                                                                       
                                                                    <?php } ?> 
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado Cheques...
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $cheque = pg_fetch_all(pg_query("SELECT * FROM v_cheques WHERE estado_cheque = 'ACTIVO' ORDER BY che_cod;"));
        ?>
        <!--INICIA MODAL REGISTRAR-->
        <div class="modal fade" id="modalAgregarCheque" tabindex="-1" role="dialog" aria-labelledby="modalAgregarPersonaLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalAgregarPersonaLabel">Agregar Cheque</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario para agregar persona -->
                        <form action="cheque_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                            <input type="hidden" name="accion" value="1" />
                            <input type="hidden" name="p_che_cod" value="0" />

                            <div class="form-group">
                                <label class="control-label col-lg-4">Titular:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="p_titular_cheque" required autofocus>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-lg-4">Banco:</label>
                                <div class="col-lg-8">
                                    <?php $genero = consultas::get_datos("select * from banco order by ban_cod"); ?>
                                    <select class="form-control" name="p_ban_cod" required>
                                        <option value="">Seleccionar Banco</option>
                                        <?php
                                        if (!empty($genero)) {
                                            foreach ($genero as $gen) {
                                                ?>
                                                <option value="<?php echo $gen['ban_cod'] ?>"><?php echo $gen['ban_descri'] ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
<?php } ?>
                                    </select>
                                </div>
                            </div>
                           
                            <!-- Agrega más campos según tus necesidades -->
                            <div class="modal-footer">
                                <button type="reset" data-dismiss="modal" class="btn btn-default">
                                    <i class="fa fa-remove"></i> Cerrar</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-floppy-o"></i> Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--FIN MODAL REGISTRAR-->
        <!--INICIA MODAL Editar-->
        <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="modaleditarPersonaLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modaleditarPersonaLabel">Actualizar datos de Persona</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario para Editar persona -->
                        <form action="personas_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                            <input type="hidden" name="accion" value="2" />
                            <input type="hidden" name="vper_cod" value="0" />

                            <div class="form-group">
                                <label class="control-label col-lg-4">Nombre:</label>
                                <div class="col-lg-8">
                                    <input id="descri" type="text" class="form-control" name="per_nombre" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4">Apellido:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="per_apellido" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4">C.I. N°:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="vper_ci" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4">Genero:</label>
                                <div class="col-lg-8">
                                        <?php $genero = consultas::get_datos("select * from genero order by gen_cod"); ?>
                                    <select class="form-control" name="vgen_cod" required>
                                        <option value="">Seleccionar genero</option>
<?php
if (!empty($genero)) {
    foreach ($genero as $gen) {
        ?>
                                                <option value="<?php echo $gen['gen_cod'] ?>"><?php echo $gen['gen_descri'] ?></option>
    <?php
    }
} else {
    ?>
<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4">Fecha Nacimiento:</label>
                                <div class="col-lg-8">
                                    <input type="date" class="form-control" name="vper_fecnac" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4">Teléfono:</label>
                                <div class="col-lg-8">
                                    <input type="tel" class="form-control" name="vper_telefono" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4">Email:</label>
                                <div class="col-lg-8">
                                    <input type="email" class="form-control" name="vper_email" required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-4">Nacionalidad:</label>
                                <div class="col-lg-8">
                                        <?php $nacionalidad = consultas::get_datos("select * from nacionalidad order by nac_cod"); ?>
                                    <select class="form-control" name="vnac_cod" required>
                                        <option value="">Seleccionar Nacionalidad</option>
<?php
if (!empty($nacionalidad)) {
    foreach ($nacionalidad as $nac) {
        ?>
                                                <option value="<?php echo $nac['nac_cod'] ?>"><?php echo $nac['nac_descri'] ?></option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-4">Departamento:</label>
                                <div class="col-lg-8">
<?php $departamentos = consultas::get_datos("select * from departamento order by depar_cod"); ?>
                                    <select class="form-control" name="vdepar_cod" required>
                                        <option value="">Seleccionar Departamento</option>
<?php
if (!empty($departamentos)) {
    foreach ($departamentos as $depar) {
        ?>
                                                <option value="<?php echo $depar['depar_cod'] ?>"><?php echo $depar['depar_descri'] ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-4">Ciudad:</label>
                                <div class="col-lg-8">
<?php $ciudad = consultas::get_datos("select * from ciudad order by ciu_cod"); ?>
                                    <select class="form-control" name="vciu_cod" required>
                                        <option value="">Seleccionar Ciudad</option>
<?php
if (!empty($ciudad)) {
    foreach ($ciudad as $ciu) {
        ?>
                                                <option value="<?php echo $ciu['ciu_cod'] ?>"><?php echo $ciu['ciu_descri'] ?></option>
    <?php
    }
} else {
    ?>
<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-4">Dirección:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="vper_direc" required autofocus>
                                </div>
                            </div>
                            <!-- Agrega más campos según tus necesidades -->
                            <div class="modal-footer">
                                <button type="reset" data-dismiss="modal" class="btn btn-default">
                                    <i class="fa fa-remove"></i> Cerrar</button>
                                <button type="submit" class="btn btn-warning pull-right">
                                    <i class="fa fa-floppy-o"></i> Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--FIN MODAL Editar-->
<?php require 'menu/footer_lte.ctp'; ?> <!-- Incluir pie de página -->

<?php require 'menu/js_lte.ctp'; ?> <!-- Incluir JavaScript -->
        <script>
            $(document).ready(function () {
                $("#mensaje").delay(4000).slideUp(200, function () {
                    $(this).alert('close');
                });

                $('.modal').on('shown.bs.modal', function () {
                    $(this).find('input:text:visible:first').focus();
                });

                function editar(datos) {
                    var dat = datos.split("_");
                    $('#cod').val(dat[0]);
                    $('#descri').val(dat[1]);
                }

                function deshabilitar(datos) {
                    var dat = datos.split("_");
                    $('#si').attr('href', 'personas_control.php?vper_cod=' + dat[0] + '&vper_ci=' + dat[1] + '&accion=3');
                    $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                            Desea inhabilitar datos de la Persona <i><strong>' + dat[1] + '</strong></i>');
                }
                function activar(datos) {
                    var dat = datos.split("_");
                    var vper_cod = dat[0];
                    var vper_ci = dat[1];
                    var vper_estado = dat[2];
                    // Configurar la URL para enviar los datos al script personas_control.php
                    var url = 'personas_control.php?accion=4&vper_cod=' + vper_cod + '&vper_ci=' + vper_ci + '&vper_estado=' + vper_estado;
                    // Actualizar el enlace 'si_activar' con la URL correcta
                    $('#si_activar').attr('href', url);

                    // Configurar el mensaje de confirmación
                    var mensaje = 'Desea activar datos de la Persona <strong>' + vper_ci + '</strong>?';
                    $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> ' + mensaje);
                }
            });
        </script>

    </body>
</html>
