<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">   
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/taller_system/favicon.ico">
        <title>SYSTEM DE TALLER</title>
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
                <!-- CONTENEDOR PRINCIPAL-->
                <div class="content" >
                    <!--FILAS-->
                    <div class="row" >
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <i class="ion ion-edit" ></i>
                                    <h3 class="box-title" >Editar Cliente</h3>
                                    <div class="box-tools">
                                        <a href="cliente_index.php" class="btn btn-warning btn-sm" data-title="Volver" rel="tooltip" >
                                            <i class="fa fa-arrow-left"></i></a>
                                    </div>
                                </div><!-- box header-->
                                <form action="cliente_control.php" method="post" accept-charset="utf-8" class="form-horizontal" >
                                    <?php $resultado= consultas::get_datos("select * from clientes where cli_cod =".$_GET['vcli_cod']);?>
                                    <input type="hidden" name="accion" value="2"/>
                                    <input type="hidden" name="vcli_cod" value="<?php echo $resultado[0]['cli_cod'];?>"/>
                                    <div class="box-body" >
                                        <div class="form-group" >
                                            <label class=" control-label col-lg-2 col-md-2 col-sm-2" >C.I.N°</label>
                                            <div class="col-lg-8 col-md-8 col-sm-8" >
                                                <input type="text" class="form-control" name="vcli_ci" required autofocus 
                                                       value="<?php echo $resultado[0]['cli_ci'];?> "/>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" >
                                            <label class=" control-label col-lg-2 col-md-2 col-sm-2" >NOMBRE:</label>
                                            <div class="col-lg-8 col-md-8 col-sm-8" >
                                                <input type="text" class="form-control" name="vcli_nombre" required autofocus 
                                                       value="<?php echo $resultado[0]['cli_nombre'];?> "/>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" >
                                            <label class=" control-label col-lg-2 col-md-2 col-sm-2" >APELLIDO:</label>
                                            <div class="col-lg-8 col-md-8 col-sm-8" >
                                                <input type="text" class="form-control" name="vcli_apellido" required autofocus 
                                                       value="<?php echo $resultado[0]['cli_apellido'];?> "/>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" >
                                            <label class=" control-label col-lg-2 col-md-2 col-sm-2" >TELEFONO:</label>
                                            <div class="col-lg-8 col-md-8 col-sm-8" >
                                                <input type="text" class="form-control" name="vcli_telefono" required autofocus 
                                                       value="<?php echo $resultado[0]['cli_telefono'];?> "/>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" >
                                            <label class=" control-label col-lg-2 col-md-2 col-sm-2" >DIRECCIÓN:</label>
                                            <div class="col-lg-8 col-md-8 col-sm-8" >
                                                <input type="text" class="form-control" name="vcli_direcc" required autofocus 
                                                       value="<?php echo $resultado[0]['cli_direcc'];?> "/>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="box-footer" >
                                         <a href="cliente_index.php" class="btn btn-default">
                                            <i class="fa fa-remove"></i> CANCELAR
                                        </a> 
                                        <button type="sutmit" class="btn btn-warning pull-right" data-title="Actualizar los datos del Cliente" rel="tooltip">
                                            <i class="fa fa-edit">Actualizar</i></button>
                                    </div>
                                </form>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
            <div>
            <?php require 'menu/footer_lte.ctp'; ?>
        </div>
        <?php require 'menu/js_lte.ctp'; ?>
    </body>
</html>


