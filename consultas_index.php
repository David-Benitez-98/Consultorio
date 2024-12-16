<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Consultas - Sistema Consultorio</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Agrega tu CSS personalizado aquí -->
        <?php
        session_start();
        require 'menu/css_lte.ctp';
        ?><!-- ARCHIVOS CSS -->
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
                                    <h3 class="box-title">Consultas</h3>
                                    <div class="box-tools">
                                        <a href="consultas_add.php" class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip">
                                            <i class="fa fa-plus"></i> Agregar Consultas
                                        </a>
                                        
                                        <a href="consultas_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form action="consultas_index.php" method="post" accept-charset="utf8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" class="form-control" name="buscar" placeholder="Buscar..." autofocus=""/>
                                                                <a href="consultas_add.php"></a>
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
                                            <!-- Mostrar la tabla de citas -->
                                            <?php
                                            $tipo_consulta = consultas::get_datos("SELECT * FROM v_consulta WHERE con_fecha::text ILIKE '%%' ORDER BY cod_consulta desc;");
                                            if (!empty($tipo_consulta)){
                                            ?>
                                            <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                <thead>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Paciente</th>
                                                <th>Motivo</th>
                                                <th>Estado</th>
                                                <th class="text-center">Acciones</th>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($tipo_consulta as $tipo_con) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $tipo_con['cod_consulta']; ?></td>
                                                            <td data-title="Fecha"><?php echo $tipo_con['con_fecha']; ?></td>
                                                            <td data-title="Paciente"><?php echo $tipo_con['paciente']; ?></td>
                                                            <td data-title="Descripción"><?php echo $tipo_con['con_motivo']; ?></td>
                                                            <td data-title="Estado"><?php echo $tipo_con['con_estado']; ?></td>
                                                            <td data-title="Acciones" class="text-center">
                                                                <?php if ($tipo_con['con_estado'] == 'PENDIENTE') { ?>
                                                                    
                                                                <a href="consultadetalle_add.php?vcod_consulta=<?php echo $tipo_con['cod_consulta']; ?>" 
                                                                       class="btn btn-success btn-sm" role="button" data-title="Detalles" 
                                                                       rel="tooltip" data-placement="top">
                                                                        <span class="glyphicon glyphicon-list"></span></a>
                                                                    <a onclick="anular(<?php echo "'".$tipo_con['cod_consulta']."_".$tipo_con['paciente']."_".$tipo_con['con_fecha']."'";?>)"
                                                                        class="btn btn-danger btn-sm" role="button" data-title="Anular" rel="tooltip" data-placement="top" 
                                                                       data-toggle="modal" data-target="#anular">
                                                                        <span class="glyphicon glyphicon-remove"></span></a>  
                                                                        
                                                                <?php } ?>
                                                                <a href="consultas_print.php?vcod_consulta=<?php echo $tipo_con['cod_consulta']; ?>" class="btn btn-primary btn-sm" role="button" data-title="Imprimir" 
                                                                   rel="tooltip" data-placement="top" target="print">
                                                                    <span class="glyphicon glyphicon-print"></span></a>                                                                          
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                         <?php } else { ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                No se han registrado Consultas...
                                            </div>      
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
                </div>
            </div>
            <?php require 'menu/footer_lte.ctp'; ?>
             <div class="modal" id="anular" role="dialog">
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
            <!-- MODAL confirmar-->
            <div class="modal" id="confirmar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                            <h4 class="modal-title custom_align">ATENCIÓN...!!!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-success" id="confirmacionc"></div>
                        </div>
                        <div class="modal-footer">
                            <a id="sic" role="buttom" class="btn btn-success">
                                <span class="glyphicon glyphicon-ok-sign"></span> SI
                            </a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> NO
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $("#mensaje").delay(4000).slideUp(200,function(){
           $(this).alert('close'); 
        });
        </script>
          <script>
    // Muestra el mensaje
    document.getElementById('mensaje').style.display = 'block';

    // Desaparece el mensaje después de 5 segundos
    setTimeout(function() {
        document.getElementById('mensaje').style.display = 'none';
    }, 4000);
</script>
         <script>
        function anular(datos){
            var dat = datos.split('_');
            $('#si').attr('href','consulta_control.php?vcod_consulta='+dat[0]+'&accion=4');
            $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
            Desea anular la Consulta N° <strong>'+dat[0]+'</strong> del Paciente <strong>'+dat[1]+'</strong> de fecha  <strong>'+dat[2]+ ' ?</strong>')
        }
         function confirmar(datos){
            var dat = datos.split('_');
            $('#sic').attr('href','consulta_control.php?vcod_consulta='+dat[0]+'&accion=3');
            $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
            Desea confirmar la Consulta N° <strong>'+dat[0]+'</strong> del Paciente <strong>'+dat[1]+'</strong> de fecha  <strong>'+dat[2]+ ' ?</strong>')
        }  
        </script> 
        <?php require 'menu/js_lte.ctp'; ?>
    </body>
</html>
