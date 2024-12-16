<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Registrar Cobros</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Estilos CSS personalizados -->

        <?php
        session_start();
        require 'menu/css_lte.ctp';
        ?>
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
                                <div class="box-header with-border">
                                    <h3 class="box-title">Registrar Cobros <?= $_GET['vcobro_cod'] ?></h3>
                                    <div class="box-tools">
                                        <button class="btn btn-print btn-sm" onclick="window.print()">Imprimir Factura</button>
                                        <a href="cobroscabecera.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>  
                                            <a href="factura_imprimir.php?vcobro_cod=23" target="_blank">
                                            <button>Imprimir Factura</button>
                                        </a>

                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                                                                     
                                    <?php
                                    $consulta = consultas::get_datos("select * FROM v_cobros WHERE cobro_cod =" . $_REQUEST['vcobro_cod']);
                                    if (!empty($consulta)) {
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Cliente</th>
                                                        <th>Caja</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($consulta as $consul) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $consul['cobro_cod']; ?></td>
                                                            <td data-title="Fecha"><?php echo $consul['cobro_fecha']; ?></td>
                                                            <td data-title="Fecha"><?php echo $consul['pac_cod']; ?> - <?php echo $consul['paciente']; ?></td>
                                                            <td data-title="Tipo de Consulta"><?php echo $consul['caj_descrip']; ?></td>
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
                                        $detalles = consultas::get_datos("SELECT * FROM v_cobrodetalle WHERE cobro_cod = " . $_REQUEST['vcobro_cod']);
                                        if (!empty($detalles)) {
                                            ?>
                                            <div class="table-responsive">
                                                <table id="tablaCobros" class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>#Cuota</th>
                                                            <th>Factura</th>
                                                            <th>Vencimiento</th>
                                                            <th>Monto</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $det['cta_nro_cuota']; ?></td>
                                                                <td data-title="Factura"><?php echo $det['fac_cod']; ?></td>
                                                                <td data-title="Vencimiento"><?php echo $det['cta_fecha_vencimiento']; ?></td>
                                                                <td data-title="Monto" class="monto"><?php echo number_format($det['cantidad_cobro'], 3, ',', '.'); ?></td>
                                                                <td class="text-center">
                                                                    <a onclick="borrar(<?php echo $det['cta_nro_cuota']; ?>, <?php echo $det['fac_cod']; ?>, <?php echo $det['cobro_cod']; ?>)" 
                                                                       class="btn btn-danger btn-sm" data-title="Quitar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#borrar">
                                                                        <i class="fa fa-trash-o"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" style="text-align: right; background-color: #f8d7da;">TOTAL GENERAL</td>
                                                            <td id="totalMonto" style="background-color: #f8d7da;">0,000</td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                Sin detalles cargados...
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <!--FIN DETALLE-->
                                <!-- INICIO DETALLE -->
                                <div class="box-header d-flex align-items-center justify-content-between" style="background-color: #f5f5f5; border-bottom: 2px solid #007bff; padding: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 4px 4px 0 0;">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-plus" style="color: #007bff; font-size: 1.2em; margin-right: 5px;"></i>
                                        <i class="fa fa-list" style="color: #007bff; font-size: 1.2em; margin-right: 10px;"></i>
                                        <h3 class="box-title" style="margin: 0; font-weight: bold; color: #333;">Detalles</h3>
                                    </div>

                                </div>

                                <button onclick="estirarMonto(); return false;" class="btn btn-primary form-control" data-toggle="modal" data-target="#documentos-modal" 
                                        role="button" data-title="Agregar"class='fa fa-money' rel="tooltip" data-placement="top">
                                    Formas de Cobro
                                </button>

                                <script>
                                    function estirarMonto() {
                                        $("#saldo_cobrar").val($("#totalMonto").text());
                                        $("#montoPorCobrar").val($("#totalMonto").text());
                                    }
                                </script>
                                <br>
                                <div class="box-body" style="background-color: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                                    <form action="cobrosdetalle_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vcobro_cod" value="<?php echo $consulta[0]['cobro_cod']; ?>" />
                                        <input type="hidden" name="fac_cod" id="fac_cod">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="vcta_nro_cuota" class="control-label" style="font-weight: bold; color: #333;">Cuentas a Cobrar:</label>
                                                <?php
                                                // Obtener el código de cobro (cobro_cod) desde la solicitud
                                                $cobro_cod = isset($_REQUEST['vcobro_cod']) ? intval($_REQUEST['vcobro_cod']) : 0;
                                                // Inicializar pac_cod y servicios
                                                $pac_cod = 0;
                                                $servicios = [];
                                                if ($cobro_cod > 0) {
                                                    // Consulta para obtener el código de paciente relacionado al cobro
                                                    $resultado = consultas::get_datos("SELECT pac_cod FROM cobros WHERE cobro_cod = $cobro_cod");
                                                    if (!empty($resultado)) {
                                                        $pac_cod = intval($resultado[0]['pac_cod']);
                                                    }
                                                }
                                                if ($pac_cod > 0) {
                                                    // Consulta para obtener las cuentas pendientes del paciente
                                                    $servicios = consultas::get_datos("
                                                    SELECT DISTINCT 
                                                    ca.cta_nro_cuota, 
                                                    ca.fac_cod,
                                                    ca.cta_estado, 
                                                    ca.cta_saldo, 
                                                    ca.cta_monto_pagar, 
                                                    f.pac_cod,
                                                    (p.per_nombre || ' ' || p.per_apellido) AS paciente
                                                FROM cuenta_a_cobrar AS ca
                                                JOIN factura f ON ca.fac_cod = f.fac_cod
                                                JOIN pacientes pa ON f.pac_cod = pa.pac_cod  
                                                JOIN persona p ON pa.per_cod = p.per_cod  
                                                WHERE pa.pac_cod = $pac_cod 
                                                  AND ca.cta_estado = 'PENDIENTE';
                                                ");
                                                }
                                                ?>
                                                <select class="form-control chosen-select" name="vcta_nro_cuota" id="vcta_nro_cuota" onchange="actualizarDatos();" required style="width: 100%;">
                                                    <option value="0" data-precio="0" data-fac_cod="0">Seleccionar Paciente con Cuentas Pendientes</option>
                                                    <?php if (!empty($servicios)) : ?>
                                                        <?php foreach ($servicios as $servicio) : ?>
                                                            <option value="<?php echo htmlspecialchars($servicio['cta_nro_cuota']); ?>" 
                                                                    data-precio="<?php echo htmlspecialchars($servicio['cta_monto_pagar']); ?>" 
                                                                    data-fac_cod="<?php echo htmlspecialchars($servicio['fac_cod']); ?>">
                                                                <?php echo htmlspecialchars($servicio['cta_nro_cuota']); ?> - Cliente: <?php echo htmlspecialchars($servicio['paciente']); ?> - Monto: <?php echo htmlspecialchars($servicio['cta_monto_pagar']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <option value="0">No hay cuentas a cobrar pendientes.</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>

                                            <!-- Precio Total -->
                                            <div class="col-md-3 mb-3">
                                                <label for="vcantidad_cobro" style="font-weight: bold; color: #333;">Monto a Cobrar:</label>
                                                <input type="text" class="form-control" name="vcantidad_cobro" required id="vcantidad_cobro" readonly style="background-color: #e9ecef;">
                                            </div>
                                        </div>

                                        <!-- Botón de Agregar Detalle -->
                                        <div class="row mt-3">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-success btn-lg" style="padding: 10px 20px; font-weight: bold;">
                                                    <i class="fa fa-plus"></i> Agregar Detalle
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                </section>
                            </div>
                            <?php require 'menu/footer_lte.ctp'; ?>
                        </div>

                        <!-- Modal para agregar cobros Tarjeta y Cheque -->
                        <!-- Modal para Cobro con Tarjeta -->
                        <div class="modal fade" id="documentos-modal" tabindex="-1" role="dialog" aria-labelledby="documentosModalLabel">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                        <h4 class="modal-title" id="documentosModalLabel"><i class="fa fa-money"></i><strong>Agregar Forma de Cobro</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="cobros_formadetalle_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                            <select name="accion" required>
                                                <option value="1">ACCION EFECTIVO</option>
                                                <option value="2">Acción TARJETA</option>
                                                <option value="3">Acción CHEQUE</option>
                                            </select>
                                            <input name="vform_cod" value="0" type="hidden" />
                                            <input type="text" name="vcobro_cod" value="<?= $_GET['vcobro_cod'] ?>" hidden />
                                            <div class="box-body">
                                                <!-- Campo para mostrar el monto por cobrar -->
                                                <div class="form-group">
                                                    <label class="text-success">Monto por Cobrar</label>
                                                    <input type="text" class="form-control" id="montoPorCobrar" disabled>
                                                    <input type="hidden" id="hiddenMontoPorCobrar">
                                                </div>
                                                <div class="form-group">
                                                    <label class="text-success">Saldo</label>
                                                    <input type="text" class="form-control" id="saldo_cobrar" disabled>
                                                    <input type="hidden" id="hiddenMontoPorCobrar">
                                                </div>
                                                <!-- Forma de Cobro Dropdown -->
                                                <div class="form-group">
                                                    <label for="formaCobro">Forma de Cobro</label>
                                                    <select class="form-control" id="formaCobro" name="formaCobro">
                                                        <option value="0">SELECCIONA UNA FORMA DE PAGO</option>
                                                        <option value="EFECTIVO">EFECTIVO</option>
                                                        <option value="TARJETA">TARJETA</option>
                                                        <option value="CHEQUE">CHEQUE</option>
                                                    </select>
                                                </div>
                                                <!-- Campos adicionales dinámicos -->
                                                <div id="dynamicFields">
                                                    <!--PAGOS EN EFECTIVO-->
                                                    <div class="form-group bloque-efectivo" hidden >
                                                        <label for="cardNumber">Monto</label>
                                                        <input type="number" class="form-control" id="cardNumber" name="vmonto" value="0" placeholder="">
                                                    </div>
                                                    <!--PAGOS EN TARJETA-->
                                                    <div class="box-body bloque-tarjeta" hidden>
                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="vban_cod" class="control-label">Banco:</label>
                                                                <?php
                                                                $banco = consultas::get_datos("SELECT * FROM banco ORDER BY ban_cod");
                                                                ?>
                                                                <select class="form-control" name="vban_cod" id="vban_cod">
                                                                    <option value="">Seleccionar Banco</option>
                                                                    <?php foreach ($banco as $ban) : ?>
                                                                        <option value="<?php echo $ban['ban_cod']; ?>">
                                                                            <?php echo $ban['ban_descri']; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="vtar_cod" class="control-label">Tarjeta:</label>
                                                                <?php
                                                                $tipodocumentos = consultas::get_datos("SELECT * FROM vista_tarjetas ORDER BY tar_cod");
                                                                ?>
                                                                <select class="form-control" name="vtar_cod"  id="vtar_cod">
                                                                    <option value="0">Seleccionar Tarjeta</option>
                                                                    <?php foreach ($tipodocumentos as $tipodo) : ?>
                                                                        <option value="<?php echo $tipodo['tar_cod']; ?>">
                                                                            <?php echo $tipodo['tipotar_descri']; ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Campos para Número de Tarjeta y Código de Autorización en la misma fila -->
                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label for="vnro_tarjeta" class="control-label">Nro. Tarjeta:</label>
                                                                <input type="number" class="form-control" name="vnro_tarjeta" id="vnro_tarjeta"  placeholder="Ingrese el número de la tarjeta">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="vcod_aut" class="control-label">Código de Autorización:</label>
                                                                <input type="number" class="form-control" name="vcod_aut" id="vcod_aut"  placeholder="Ingrese el código de autorización">
                                                            </div>
                                                        </div>

                                                        <!-- Campos para Monto y Fecha de Expiración en la misma fila -->
                                                        <div class="form-group">
                                                            <div center class="col-md-6">
                                                                <label for="vmontotarjeta" class="control-label">Monto:</label>
                                                                <input type="number" class="form-control" name="vmontotarjeta" id="tarjetaMonto" value="0"  placeholder="Ingrese el monto">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--OPERACION CON CHEQUE-->
                                                    <div class="bloque-cheque" hidden>
                                                        
                                                        <!-- Campo para seleccionar el Banco -->
                                                        <div class="col-md-6">
                                                            <label for="vban_cod">Banco:</label>
                                                            <?php
                                                            $tipodocumentos = consultas::get_datos("SELECT * FROM banco ORDER BY ban_cod");
                                                            ?>
                                                            <select class="form-control" name="vban_cod"  id="ban_cod">
                                                                <option value="0">Seleccionar Banco</option>
                                                                <?php foreach ($tipodocumentos as $tipodo) : ?>
                                                                    <option value="<?php echo $tipodo['ban_cod']; ?>"><?php echo $tipodo['ban_descri']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="vtipoche_cod">Tipo de Cheque:</label>
                                                            <?php
                                                            $tipodocumentos = consultas::get_datos("SELECT * FROM tipo_cheque ORDER BY tipoche_cod");
                                                            ?>
                                                            <select class="form-control" name="vtipoche_cod"  id="vtipoche_cod">
                                                                <option value="0">Seleccionar Tipo Cheque</option>
                                                                <?php foreach ($tipodocumentos as $tipodo) : ?>
                                                                    <option value="<?php echo $tipodo['tipoche_cod']; ?>"><?php echo $tipodo['tipoche_descri']; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <!-- Campo para el Número de Cheque -->
                                                        <div class="col-md-6">
                                                            <label for="chequeNumero">Número de Cheque:</label>
                                                            <input type="text" class="form-control" name="vnro_cheque" id="chequeNumero"  placeholder="Ingrese el número de cheque">
                                                        </div>
                                                        <!-- Campo para la Fecha de Emisión del Cheque -->
                                                        <div class="col-md-6">
                                                            <label for="fechaEmision">Fecha de Emisión:</label>
                                                            <input type="date" class="form-control" name="vfecha_emision" id="fechaEmision" >
                                                        </div>

                                                        <!-- Campo para el Titular del Cheque -->
                                                        <div class="col-md-6">
                                                            <label for="titularCheque">Titular:</label>
                                                            <input type="text" class="form-control" name="vtitular" id="titularCheque"  placeholder="Ingrese el nombre del titular">
                                                        </div>
                                                        <!-- Campo para el Monto -->
                                                        <div class="col-md-6">
                                                            <label for="vmontocheque">Monto:</label>
                                                            <input type="number" class="form-control" name="vmontocheque" id="chequeMonto" value="0"  placeholder="Ingrese el monto">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="box-footer">
                                                <button type="reset" data-dismiss="modal" class="btn btn-default">
                                                    <i class="fa fa-remove"></i> Cerrar
                                                </button>
                                                <button type="submit" class="btn btn-primary pull-right" id="registrarCobro">
                                                    <i class="fa fa-floppy-o"></i> Registrar
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
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
                        <script>
                            // Event listener for payment type selection
                            document.getElementById('formaCobro').addEventListener('change', function () {
                                const selectedPayment = this.value;

                                document.querySelectorAll('.bloque-efectivo, .bloque-tarjeta, .bloque-cheque').forEach(block => {
                                    block.setAttribute('hidden', true);
                                });

                                if (selectedPayment === 'EFECTIVO') {
                                    document.querySelector('.bloque-efectivo').removeAttribute('hidden');
                                    document.querySelector('input[name="accion"]').value = 1;
                                } else if (selectedPayment === 'TARJETA') {
                                    document.querySelector('.bloque-tarjeta').removeAttribute('hidden');
                                    document.querySelector('input[name="accion"]').value = 2;
                                } else if (selectedPayment === 'CHEQUE') {
                                    document.querySelector('.bloque-cheque').removeAttribute('hidden');
                                    document.querySelector('input[name="accion"]').value = 3;
                                }
                            });

                            document.querySelector('form').addEventListener('submit', function (e) {
                                const formaCobro = document.getElementById('formaCobro').value;

                                if (!['EFECTIVO', 'TARJETA', 'CHEQUE'].includes(formaCobro)) {
                                    e.preventDefault();
                                    alert('Forma de cobro no válida. Por favor, selecciona una forma de cobro.');
                                }
                            });
                        </script>


                        <script>
                            // Función para calcular el total de la columna Monto
                            function calcularTotal() {
                                // Obtener todos los elementos de la columna Monto
                                let montos = document.querySelectorAll(".monto");
                                let total = 0;
                                // Sumar cada valor de la columna Monto
                                montos.forEach(monto => {
                                    total += parseInt(monto.textContent.replace('.', '').replace(',', '.')) || 0;
                                });
                                // Mostrar el total en el campo de Total General
                                document.getElementById("totalMonto").textContent = total.toLocaleString("es-ES", {
                                    minimumFractionDigits: 3,
                                    maximumFractionDigits: 3
                                });
                            }
// Llama a calcularTotal cuando se cargue la página
                            window.onload = calcularTotal;

                            $(document).ready(function () {
                                $("#agregarCobro").click(function () {
                                    var formaCobro = $("#forma_cobro").val();
                                    var montoCobro = $("#monto_cobro").val();
                                    if (montoCobro <= 0) {
                                        alert("El monto debe ser mayor que cero.");
                                        return;
                                    }

                                    // Agregar a la tabla de cobros
                                    $("#tablaCobros tbody").append(`
                                                            <tr>
                                <td>${formaCobro}</td>
                                    <td>${montoCobro}</td>
                                        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarCobro(this)">Eliminar</button></td>
                                        </tr>
                                            `);
                                    $("#monto_cobro").val('');
                                });
                                $(document).on('click', '#guardarCobros', function () {
                                    // Aquí puedes guardar los cobros al servidor, según sea necesario
                                    alert("Cobros guardados con éxito.");
                                });
                            });
                            function eliminarCobro(btn) {
                                // Eliminar la fila de la tabla de cobros
                                var row = btn.parentNode.parentNode;
                                row.parentNode.removeChild(row);
                            }
                        </script>
                        <script>
                            function actualizarDatos() {
                                // Obtener el monto a cobrar seleccionado
                                var select = document.getElementById("vcta_nro_cuota");
                                var selectedOption = select.options[select.selectedIndex];
                                // Obtener el valor del monto de la opción seleccionada
                                var montoPorCobrar = selectedOption.getAttribute("data-precio");
                                var facCod = selectedOption.getAttribute("data-fac_cod");
                                // Actualizar el campo de "Monto a Cobrar"
                                document.getElementById("vcantidad_cobro").value = montoPorCobrar;
                                // Actualizar el campo de "Monto por Cobrar" en el otro div
                                document.getElementById("montoPorCobrar").value = montoPorCobrar;
                                document.getElementById("hiddenMontoPorCobrar").value = montoPorCobrar;
                                // También puedes actualizar otros valores como facCod si es necesario
                                document.getElementById("fac_cod").value = facCod;
                            }


                            function borrar(ctaNroCuota, facCod, cobroCod) {
                                // Configura la URL correcta para el enlace de confirmación
                                $('#si').attr('href', 'cobrosdetalle_control.php?vcta_nro_cuota=' + ctaNroCuota +
                                        '&vfac_cod=' + facCod + '&vcobro_cod=' + cobroCod + '&accion=2');
                                // Genera el mensaje de confirmación
                                $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
¿Desea borrar el detalle del cobro para la cuota <strong>' + ctaNroCuota + '</strong> de la factura <strong>' + facCod + '</strong>?');
                            }


                            //--------------------------------------------------------------------
                            //--------------------------------------------------------------------
                            //--------------------------------------------------------------------
                            //--------------------------------------------------------------------
                            $(document).on("keyup", "#cardNumber, #tarjetaMonto, #chequeMonto", function (evt) {

                                let monto_pagar = parseFloat($("#montoPorCobrar").val().replace(/\./g, '').replace(',', '.'));
                                let efectivo = parseFloat($("#cardNumber").val().replace(/\./g, '').replace(',', '.'));
                                let tarjeta = parseFloat($("#tarjetaMonto").val().replace(/\./g, '').replace(',', '.'));
                                let cheque = parseFloat($("#chequeMonto").val().replace(/\./g, '').replace(',', '.'));

                                let saldo = monto_pagar - efectivo - tarjeta - cheque;

                                if (saldo < 0) {
                                    ///mostrar error
                                } else {
                                    $("#saldo_cobrar").val(saldo);
                                }

                            });
                            function validarcampos() {
                                if ($("#tarjetaMonto").val() == "" || $("#tarjetaMonto").val() == 0) {
                                    alert("llenar campos");
                                    return false;
                                }
                            }
                            $("#agregarCobro").click(function () {

                            });
                        </script>

                        </body>
                        <?php require 'menu/js_lte.ctp'; ?>
                        </html>
