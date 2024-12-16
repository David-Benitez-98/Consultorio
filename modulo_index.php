<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">   
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Sistema Consultorio</title>
        <meta content="width=divice-width, initial-scale=1, maximun-scale=1, user-scalable=no" name="viewport">

        <?php
        session_start(); /* Reanudar sesion */
        require 'menu/css_lte.ctp';
        ?>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!-- CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!-- MENU PRINCIPAL-->
            <div class="content-wrapper">

                <!-- CONTENEDOR PRINCIPAL --> 
                <div class="content" >
                    <div class="row" >
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                                <div class="alert alert-danger" role="alert" id="mensaje" >
                                    <span class="glyphicon glyphicon-exclamation-sign" ></span>
                                    <?php echo $_SESSION['mensaje'];
                                    $_SESSION['mensaje'] = ''; ?>
                                </div>
                           <?php } ?>
                            <div class="box box-success">
                                <div class=" box-header">
                                    <i class="fa fa-meh-o" aria-hidden="true"></i>
                                    <h3 class="box-title">Nicolás Cabrera T...(+_+)</h3><br><br>
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title" >MODULOS</h3>
                                    <div class="box-tools">
                                        <a class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip" data-placement="left"
                                           data-toggle="modal" data-target="#registrar" > <i class="fa fa-plus"></i></a>
                                        <a href="modulo_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left">
                                            <i class="fa fa-print"></i></a>
                                    </div>
                                </div> <!-- box-header -->
                                <div class="box-body no-padding" >
                                    <div class="row" >
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                            <form action="cargo_index.php" method="post" accept-charset="utf8" class="form-horizontal" >
                                                <div class="box-body" >
                                                    <div class="form-group" >
                                                        <div class="col-lg-12 col-md-12 col-xs-12" >
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" class="form-control"
                                                                       name="buscar" placeholder="Buscar..." autofocus=""/>
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-success btn-flat"
                                                                            data-title="Buscar" data-placement="bottom"
                                                                            rel="tooltip"><span class="fa fa-search"></span></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
                                            $valor='';
                                            if (isset($_REQUEST['buscar'])){
                                                $valor=$_REQUEST['buscar'];
                                            }
                                            $modulos = consultas::get_datos("select * from modulos "
                                                    . "where (mod_cod||trim(upper(mod_nombre)))"
                                                    . "like trim(upper('%".$valor."%')) order by mod_cod");
                                            if (!empty($modulos)) { ?>
                                                <div class="table-responsive" >
                                                    <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th class="text-center" >Accciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <?php foreach ($modulos as $modulo) { ?>
                                                                    <tr>
                                                                        <td data-title="Nombre" ><?php echo $modulo['mod_nombre']; ?></td>
                                                                        <td data-title="Acciones" class="text-center" >
                                                                            <a onclick="editar(<?php echo"'" . $modulo['mod_cod'] . "_" . $modulo['mod_nombre'] . "'"; ?>)" 
                                                                               class="btn btn-xs btn-primary" role="button" role="button" 
                                                                               data-title ="Editar" rel="tooltip" data-toggle="modal" data-target="#editar" data-placement="top" >
                                                                                <span class="glyphicon glyphicon-pencil" ></span>
                                                                            </a>
                                                                            <a onclick="borrar(<?php echo"'" . $modulo['mod_cod'] . "_" . $modulo['mod_nombre'] . "'"; ?>)"
                                                                               class="btn btn-danger btn-sm" role="button" 
                                                                               data-title ="Borrar" rel="tooltip" data-toggle="modal" data-target="#borrar" data-placement="top" >
                                                                                <span class="glyphicon glyphicon-trash" ></span>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

<?php } else { ?>
                                                <div class="alert alert-info flat" >
                                                    <span class="glyphicon glyphicon-info-sign"></span>
                                                    No se han registrado modulos...
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
        <?php require 'menu/footer_lte.ctp'; ?>
        </div>
        <!-- Inicio Modal -->
         <div class="modal" id="registrar" role="dialog" >
            <div class="modal-dialog">
             <div class="modal-content">
                    <div class="modal-header" >
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i><strong>Registar Modulos</strong></h4>
                    </div>
                    <form action="modulo_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                        <input name="accion" value="1" type="hidden"/>
                        <input name="vmod_cod" value="0" type="hidden"/>
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label col-lg-2 col-sm-2 col-md-2">Nombre</label>
                                <div class="col-lg-10 col-sm-10 col-md-10">
                                    <input type="text" class="form-control" name="vmod_nombre" required>
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
        <!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
                <!-- Inicio Modal editar -->
         <div class="modal" id="editar" role="dialog" >
            <div class="modal-dialog">
             <div class="modal-content">
                    <div class="modal-header" >
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                        <h4 class="modal-title"><i class="fa fa-edit"></i><strong>Editar Modulos</strong></h4>
                    </div>
                    <form action="modulo_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                        <input name="accion" value="2" type="hidden"/>
                        <input name="vmod_cod" value="0" type="hidden" id="cod"/>
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label col-lg-2 col-sm-2 col-md-2">Nombre</label>
                                <div class="col-lg-10 col-sm-10 col-md-10">
                                    <input type="text" class="form-control" name="vmod_nombre" required="" id="nombre">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="reset" data-dismiss="modal" class="btn btn-default">
                                <i class="fa fa-remove" ></i>Cerrar</button>
                            <button type="submit" class="btn btn-warning pull-right">
                                <i class="fa fa-edit" ></i>Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- fin Modal editar-->
         <!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
                <!-- Inicio Modal borrar -->
                <div class="modal" id="borrar" role="dialog" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" >
                                <button type="button" class="close" data-dismiss="modal">x</button>
                                <h4 class="modal-title custom_aling" id="Heading">Atención...!!!</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" id="confirmacion"></div>
                            </div>
                            <div class="modal-footer">
                                <a id="si" role="button" class="btn btn-danger" >
                                    <span class="glyphicon glyphicon-ok-sign"></span> Si
                                </a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remove"></span> No
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

        <!-- fin Modal borrar-->
<?php require 'menu/js_lte.ctp'; ?>
  
        <script>
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        </script>
        <script>
            $('.modal').on('shown.bs.modal',function(){
                $(this).find('input:text:visible:first').focus();
            });
        </script>
        <script>
        function editar(datos){
                var dat = datos.split("_");
                $("#cod").val(dat[0]);
                $("#nombre").val(dat[1]);
            }
        </script>
        <script>
        function borrar(datos){
            var dat = datos.split("_");
                $("#si").attr('href','modulo_control.php?vmod_cod='+dat[0]+'&vmod_nombre='+dat[1]+'&accion=3');
                $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
        Desea borrar el Modulo <em><strong>'+dat[1]+'</strong></em> ?');     
       }
        </script>      
    </body>
</html>