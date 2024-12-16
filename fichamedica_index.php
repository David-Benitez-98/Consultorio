<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
    <title>Sistema Consultorio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Agrega tu CSS personalizado aquí -->
    <?php
    session_start();
    require 'menu/css_lte.ctp';
    ?><!--ARCHIVOS CSS-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>
        <div class="content-wrapper">
            <section class="content">
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
                                <i class="ion ion-clipboard"></i>
                                <h3 class="box-title">Ficha Médica</h3>
                                <div class="box-tools">
                                    <a href="historial.php" class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip">
                                        <i class="fa fa-plus"></i> Historial Médico
                                    </a>
                                    <a href="fichamedica_add.php" class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip">
                                        <i class="fa fa-plus"></i> Agregar Ficha Medica
                                    </a>
                                    <a href="fichamedica_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="box-body no-padding">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <form action="fichamedica_index.php" method="post" accept-charset="utf8" class="form-horizontal">
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                                        <div class="input-group custom-search-form">
                                                            <input type="search" class="form-control" name="buscar" placeholder="Buscar..." autofocus=""/>
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
                                        <!-- Mostrar la tabla de v_agenda -->
                                        <?php
                                        $tipo_consulta = consultas::get_datos("SELECT * FROM v_fichamedica WHERE pac_cod::text ILIKE '%%' ORDER BY fich_cod;");
                                        if (!empty($tipo_consulta)) {
                                        ?>
                                            <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                <thead>
                                                    <th>#</th>
                                                    <th>Paciente</th>
                                                    <th class="text-center">Acciones</th>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($tipo_consulta as $tipo_con) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $tipo_con['fich_cod']; ?></td>
                                                            <td data-title="Paciente"><?php echo $tipo_con['paciente']; ?></td>
                                                            <td data-title="Acciones" class="text-center">
                                                                <a href="fichamedica_add.php?vfich_cod=<?php echo $tipo_con['fich_cod']; ?>" class="btn btn-success btn-sm" role="button" data-title="Detalles" rel="tooltip" data-placement="top">
                                                                    <span class="glyphicon glyphicon-list"></span>
                                                                </a> 
                                                                <a onclick="anular(<?php echo "'".$tipo_con['fich_cod']."_".$tipo_con['paciente']."'";?>)" class="btn btn-danger btn-sm" role="button" data-title="Anular" rel="tooltip" data-placement="top" data-toggle="modal" data-target="#anular">
                                                                    <span class="glyphicon glyphicon-remove"></span>
                                                                </a>  
                                                                <a href="fichamedica_print.php?vfich_cod=<?php echo $tipo_con['fich_cod']; ?>" class="btn btn-primary btn-sm" role="button" data-title="Imprimir" rel="tooltip" data-placement="top" target="print">
                                                                    <span class="glyphicon glyphicon-print"></span>
                                                                </a>                                                                          
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
    </div>
    <!-- ... (otros modales y scripts JavaScript) ... -->
    <?php require 'menu/js_lte.ctp'; ?>
</body>
</html>
