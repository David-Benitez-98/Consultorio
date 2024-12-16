<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
        <title>LP3</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php 
        session_start();/*Reanudar sesion*/
        require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp';?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php if(!empty($_SESSION['mensaje'])){ ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje'] = '' ;?>
                            </div>
                            <?php } ?>
                            <div class="box box-danger">
                                <div class="box-header">
                                    <i class="fa fa-list"></i> 
                                    <h3 class="box-title">REPORTE DE MODULO</h3>
                                    <div class="box-tools">
                                        <a href="modulo_add.php" class="btn btn-danger btn-sm" data-title="Agregar" rel="tooltip" data-placement="left">
                                            <i class="fa fa-plus"></i></a>
                                            <a href="modulo_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
                                            <i class="fa fa-print"></i></a>                                            
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                             <?php $opcion='2';
                                             if (isset($_GET['opcion'])) {
                                                    $opcion=$_GET['opcion'];
                                            }  ?>
                                            <form action="modulo_print.php" method="get" accept-charset="utf-8" class="form-horizontal">
                                                <input type="hidden" value="<?php echo $opcion;?>" name="opcion"/>
                                                <div class="box-body">
                                                    <div class="col-md-4 col-sm-4 col-lg-4">
                                                        <div class="panel panel-danger">
                                                            <div class="panel-heading">
                                                                <strong>OPCIONES</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="list-group">
                                                                    <a href="modulo_rpt.php?opcion=1" class="list-group-item">Por Codigo</a>
                                                                    <a href="modulo_rpt.php?opcion=2" class="list-group-item">Por Nombre</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 col-lg-8">
                                                        <div class="panel panel-danger">
                                                            <div class="panel-heading">
                                                                <strong>FILTROS</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <?php
                                                                $modulos = consultas::get_datos("select * from modulos order by mod_cod");
                                                                ?>
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">Desde:</label>
                                                                    <div class="col-md-6">
                                                                        <select class="form-control select2" name="vdesde">
                                                                            <?php if (!empty($modulos)) {
                                                                            foreach ($modulos as $modulo) { ?>
                                                                            <option value="<?php if ($opcion==='1') {
                                                                                 echo $modulo['mod_cod'];}
                                                                                 else {$modulo['mod_nombre'];}
                                                                                ?>">
                                                                                <?php if ($opcion=='1') {
                                                                                        echo $modulo['mod_cod'];} else {
                                                                                        echo $modulo['mod_nombre'];
                                                                                        }?>
                                                                            </option>
                                                                             <?php }
                                                                                } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">Hasta:</label>
                                                                    <div class="col-md-6">
                                                                        <select class="form-control select2" name="vhasta">
                                                                            <?php if (!empty($modulos)) {
                                                                             foreach ($modulos as $modulo) { ?>
                                                                            <option value="<?php if ($opcion==='1') {
                                                                                 echo $modulo['mod_cod'];}
                                                                                 else {echo $modulo['mod_nombre'];}
                                                                                ?>">
                                                                                <?php if ($opcion=='1') {
                                                                                        echo $modulo['mod_cod'];} else {
                                                                                        echo $modulo['mod_nombre'];
                                                                                        }?>
                                                                            </option>
                                                                             <?php }
                                                                                } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-danger pull-right" >
                                                        <i class="fa fa-print" target="print"></i> Listar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
                
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function() {
               $(this).alert('close'); 
            });
           /* $('.modal').on('shown.bs.modal', function() {
                $(this).find('input:text:visible:first').focus();
            });*/
        </script>
       
    </body>
</html>