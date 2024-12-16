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
                            <div class="box box-danger">
                                <div class=" box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title" >Reporte de Cargo</h3>
                                    <div class="box-tools">
                                        <a href="cargo_add.php" class="btn btn-primary btn-sm" data-title="Agregar" rel="tooltip" data-placement="left">
                                            <i class="fa fa-plus"></i></a>
                                        <a href="cargo_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left">
                                            <i class="fa fa-print"></i></a>
                                    </div>
                                </div> <!-- box-header -->
                                <div class="box-body no-padding" >
                                    <div class="row" >
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                            <?php $opcion='2';
                                            if (isset($_GET['opcion'])){
                                                $opcion=$_GET['opcion'];
                                            }?>
                                            <form action="cargo_print.php" method="get" accept-charset="utf-8" class="form-horizontal">
                                                <input type="hidden" value="<?php echo $opcion;?>" name="opcion"/>
                                                <div class="box-body" >
                                                    <div class="col-md-4 col-sm-4 col-lg-4">
                                                        <div class="panel panel-danger">
                                                            <div class="panel-heading" >
                                                                <strong>Opciones</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="lis-group" >
                                                                    <a href="cargo_rpt.php?opcion=1" class="list-group-item">Por Codigo</a>
                                                                    <a href="cargo_rpt.php?opcion=2" class="list-group-item">Por Descripcion</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 col-lg-8">
                                                        <div class="panel panel-danger">
                                                            <div class="panel-heading">
                                                                <strong>Filtros</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <?php $cargos= consultas::get_datos("select * from cargo order by car_cod");
                                                                ?>
                                                                <div class="form-group">
                                                                    <label class="col-md-2 col-sm-2 col-lg-2 control-label">Desde</label>
                                                                    <div class="col-md-6">
                                                                        <select class="form-control select2" name="vdesde">
                                                                            <?php if (!empty($cargos)){
                                                                                 foreach ($cargos as $cargo){ ?>
                                                                            <option value="<?php if ($opcion==='1'){
                                                                            echo $cargo['car_cod'];}
                                                                            else{ echo $cargo['car_descri'];}
                                                                            ?>">
                                                                                <?php if ($opcion=='1'){
                                                                                echo $cargo['car_cod'];}else{
                                                                                echo $cargo['car_descri'];    
                                                                                }?>
                                                                            </option>
                                                                                 <?php }
                                                                                } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                 <div class="form-group">
                                                                    <label class="col-md-2 col-sm-2 col-lg-2 control-label">Hasta</label>
                                                                    <div class="col-md-6 col-sm-6 col-lg-6">
                                                                        <select class="form-control select2" name="vhasta">
                                                                            <?php if (!empty($cargos)){
                                                                                 foreach ($cargos as $cargo){ ?>
                                                                            <option value="<?php if ($opcion==='1'){
                                                                            echo $cargo['car_cod'];}
                                                                            else{ echo $cargo['car_descri'];}
                                                                            ?>">
                                                                                <?php if ($opcion=='1'){
                                                                                echo $cargo['car_cod'];}else{
                                                                                echo $cargo['car_descri'];    
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
                                                    <button type="submit" class="btn btn-danger pull-right">
                                                        <i class="fa fa-print"></i>Listar
                                                    </button>
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
        <?php require 'menu/footer_lte.ctp'; ?>
        </div>
<?php require 'menu/js_lte.ctp'; ?>
        <script>
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        </script>
    </body>
</html>