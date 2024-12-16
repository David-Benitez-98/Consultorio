<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Sistema Consultorio</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php
        session_start();
        require 'menu/css_lte.ctp';
        ?>
    </head>
    <body class="hold-transition skin-blue skin-green sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?>
            <?php require 'menu/toolbar_lte.ctp'; ?>

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

                            <div class="box box-success">
                                <div class="box-header with-border d-flex justify-content-between align-items-center">
                                    <h3 class="box-title">AGREGAR DETALLES NOTA CREDITO/DEBITO</h3>
                                    <div class="box-tools">
                                        <?php
                                        $factura = consultas::get_datos("select * from v_factura where fac_cod=" . $_REQUEST['vfac_cod']);
                                        ?>
                                        <a href="notacreditodebito_index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                                                                     
                                    <?php
//                                       
                                    $consulta = consultas::get_datos("select * FROM v_factura WHERE fac_cod =" . $_REQUEST['vfac_cod']);
                                    if (!empty($consulta)) {
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Nro factura</th>
                                                        <th>Timbrado</th>
                                                        <th>Cliente</th>
                                                        <th>Condicion</th>
                                                        <th>Total</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($consulta as $consul) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $consul['fac_cod']; ?></td>
                                                            <td data-title="Fecha"><?php echo $consul['fac_fecha']; ?></td>
                                                            <td data-title="Tipo de Consulta"><?php echo $consul['fac_nro']; ?></td>
                                                            <td data-title="Motivo"><?php echo $consul['timbrado']; ?></td>
                                                            <td data-title="Paciente"><?php echo $consul['paciente']; ?></td>
                                                            <td data-title="Paciente"><?php echo $consul['fac_condicion']; ?></td>
                                                            <td data-title="Paciente"><?php echo $consul['total']; ?></td>
                                                            <td data-title="Paciente"><?php echo $consul['fac_estado']; ?></td>

                                                        </tr>  
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-info">
                                            <span class="glyphicon glyphicon-info-sign"></span> 
                                            No se han registrado la Cabecera...
                                        </div>      
                                    <?php } ?>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <?php
                                        // Comprobamos si hay datos en $detallefactura antes de intentar obtener los detalles
                                        $detalles = consultas::get_datos("SELECT * FROM v_detalle_factura WHERE fac_cod = " . $_REQUEST['vfac_cod']);
//                                        var_dump($detalles);
                                        if (!empty($detalles)) {
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Codigo Servicio</th>
                                                    <th>Servicios</th>
                                                    <th>Cant.</th>
                                                    <th>Precio</th>
                                                    <th>Impuesto</th>
                                                    <th>Subtotal</th>
                                                    <th class="text-center">Acciones</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $det['fac_cod']; ?></td>
                                                                <td data-title="Servicios"><?php echo $det['servi_cod']; ?></td>
                                                                <td data-title="Servicios"><?php echo $det['Servicio']; ?></td>
                                                                <td data-title="Cant."><?php echo $det['Cantidad']; ?></td>
                                                                <td data-title="Precio"><?php echo number_format($det['Precio'], 0, ",", "."); ?></td>
                                                                <td data-title="Impuesto"><?php echo $det['Tipo de Impuesto']; ?></td>
                                                                <td data-title="Subtotal"><?php echo number_format($det['Total'], 0, ",", "."); ?></td>
                                                                <td class="text-center">
                                                     
                                                                    <a onclick="borrar(<?php echo $det['fac_cod']; ?>, <?php echo $det['servi_cod']; ?>, <?php echo $det['Tipo de Impuesto']; ?>)" 
                                                                       class="btn btn-danger btn-sm" data-title="Quitar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#borrar">
                                                                        <i class="fa fa-trash-o"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>

                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                La factura aun no tiene detalles cargados...
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--FIN DETALLE-->
                                <!-- INICIO DETALLE -->
                                <div class="box-header">
                                    <i class="fa fa-plus"></i><i class="fa fa-list"></i>
                                    <h3 class="box-title">Detalles</h3>
                                </div>

                                <div class="box-body">
                                    <form action="facturadetalle_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vfac_cod" value="<?php echo $consulta[0]['fac_cod']; ?>"/>
                                        <div class="row">
                                            <!-- Campo para seleccionar el servicio -->
                                            <div class="col-md-3">
                                                <label for="vservi_cod">Servicio:</label>
                                                <?php
                                                $servicios = consultas::get_datos("SELECT * FROM v_servicios WHERE servi_estado = 'ACTIVO' ORDER BY servi_cod");
                                                ?>
                                                <select class="form-control" name="vservi_cod" required id="vservi_cod" onchange="actualizarPrecio();">
                                                    <option value="0" data-precio="0">Seleccionar Servicio</option>
                                                    <?php foreach ($servicios as $servicio) : ?>
                                                        <option value="<?php echo $servicio['servi_cod']; ?>" data-precio="<?php echo $servicio['servi_precio']; ?>">
                                                            <?php echo $servicio['servi_descri']; ?> - Precio: <?php echo $servicio['servi_precio']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Cantidad -->
                                            <div class="col-md-3">
                                                <label for="vcantidad">Cantidad:</label>
                                                <input type="number" class="form-control" name="vcantidad" required value="1" min="1" id="vcantidad">
                                            </div>

                                            <!-- Precio -->
                                            <div class="col-md-3">
                                                <label for="vprecio">Precio:</label>
                                                <input type="text" class="form-control" name="vprecio" required id="vprecio" readonly>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fa fa-plus"></i> Agregar Detalle
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <?php require 'menu/footer_lte.ctp'; ?>
        </div>
        <!-- MODAL BORRAR-->
        <div class="modal" id="borrar" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                        <h4 class="modal-title custom_align">Atención!!!</h4>
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
        <!-- FIN MODAL BORRAR-->  
        <?php require 'menu/js_lte.ctp'; ?>
        <script>
            // Función para actualizar el precio basado en el servicio seleccionado
            function actualizarPrecio() {
                const servicioSelect = document.getElementById('vservi_cod');
                const precioInput = document.getElementById('vprecio');
                const selectedOption = servicioSelect.options[servicioSelect.selectedIndex];
                const precio = selectedOption.getAttribute('data-precio');
                precioInput.value = precio;
            }

            function tiposelect() {
                const tipoSelect = document.getElementById('vfac_condicion');
                const cuotasInput = document.getElementById('txtvencantcuotas');
                cuotasInput.disabled = tipoSelect.value === 'CONTADO';
            }
            function confirmar(datos) {
                var dat = datos.split('_');
                $('#sic').attr('href', 'factura_control.php?vfac_cod=' + dat[0] + '&accion=2');
                $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
            Desea confirmar la Factura N° <strong>' + dat[0] + '</strong> del cliente <strong>' + dat[1] + '</strong> de fecha <strong>' + dat[2] + '</strong>')
            }

        </script>
        <script>
            function borrar(facCod, serviCod, tipoimCod) {
                // Configura la URL correcta para el enlace de confirmación
                $('#si').attr('href', 'facturadetalle_control.php?vfac_cod=' + facCod + '&vservi_cod=' + serviCod + '&vtipoim_cod=' + tipoimCod + '&accion=3');

                // Genera el mensaje de confirmación
                $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                          Desea borrar el detalle de la factura <strong>' + facCod + '</strong> ?');
            }
        </script>

    </body>
</html>
