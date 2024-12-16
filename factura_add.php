

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
                                    unset($_SESSION['mensaje']); // Limpiar mensaje después de mostrar
                                    ?>
                                </div>
                            <?php } ?>
                            <div class="box box-success">
                                <div class="box-header with-border d-flex justify-content-between align-items-center">
                                    <h3 class="box-title">Agregar Factura</h3>
                                    <div class="box-tools">
                                        <a href="factura_index.php" class="btn btn-primary btn-xs" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER
                                        </a>
                                    </div>
                                </div>

                                <!-- Inicio de cabecera -->
                                <div class="box-body">
                                    <form id="form-factura" action="factura_control.php" method="post" class="form-horizontal">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vfac_cod" value="0">
                                        <!-- Factura, Timbrado, Fecha -->
                                        <div class="form-group row">
                                           <label for="fac_nro" class="control-label col-lg-2">Nro de Factura:</label>
                                        <div class="col-lg-2">
                                            <input type="text" id="fac_nro" name="fac_nro" readonly>
                                        </div>
                                            <!-- Timbrado -->
                                            <label class="control-label col-lg-2">Timbrado:</label>
                                            <div class="col-lg-2">
                                                <input type="text" class="form-control-static" 
                                                       value="<?php
                                                       $timbrado = consultas::get_datos("SELECT * FROM timbrado WHERE tim_cod = (SELECT MAX(tim_cod) FROM timbrado)");
                                                       echo isset($timbrado[0]['tim_numero']) ? $timbrado[0]['tim_numero'] : 'No disponible';
                                                       ?>" disabled>
                                                <input type="hidden" name="tim_cod" value="<?php echo isset($timbrado[0]['tim_cod']) ? $timbrado[0]['tim_cod'] : ''; ?>">
                                            </div>
                                            <label class="control-label col-lg-2">Fecha:</label>
                                            <div class="col-lg-2">
                                                <?php $fecha = consultas::get_datos("SELECT current_date as fecha"); ?>
                                                <input type="date" name="vfac_fecha" class="form-control" id="fecha" value="<?php echo $fecha[0]['fecha']; ?>" readonly>
                                            </div>
                                        </div>

                                        <!-- Pacientes y Apertura -->
                                        <div class="form-group row">
                                            <label for="vpac_cod" class="control-label col-lg-2">Pacientes:</label>
                                            <div class="col-lg-4">
                                                <select class="form-control" id="vpac_cod" name="vpac_cod" required>
                                                    <option value="">Seleccionar Pacientes</option>
                                                    <?php
                                                    $pacientes = consultas::get_datos("SELECT * FROM v_paciente ORDER BY pac_cod");
                                                    foreach ($pacientes as $pac) {
                                                        echo "<option value='{$pac['pac_cod']}'>{$pac['paciente']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <label class="control-label col-lg-2">Caja:</label>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="aper_cod" required>
                                                    <option value="">Seleccionar Caja </option>
                                                    <?php
                                                    $aperturas = consultas::get_datos("SELECT * FROM apertura_cierre ORDER BY aper_cod");
                                                    foreach ($aperturas as $apertura) {
                                                        echo "<option value='{$apertura['aper_cod']}'>{$apertura['fecha_apertura']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Tipo de Factura y Cuotas -->
                                        <div class="form-group row">
                                            <label for="vfac_condicion" class="control-label col-lg-2">Tipo Factura:</label>
                                            <div class="col-lg-2">
                                                <select class="form-control" id="vfac_condicion" name="fac_condicion" onchange="tiposelect();">
                                                    <option value="CONTADO">CONTADO</option>
                                                    <option value="CREDITO">CREDITO</option>
                                                </select>
                                            </div>
                                            <label class="control-label col-lg-2">Intervalo Cuotas:</label>
                                            <div class="col-lg-2">
                                                <input type="number" class="form-control" name="fac_intervalo" id="vfac_intervalo" value="0">
                                            </div>
                                            <label class="control-label col-lg-2">Cantidad de Cuotas:</label>
                                            <div class="col-lg-2">
                                                <input min="1" type="number" class="form-control" name="fac_cantcuotas" id="txtvencantcuotas" value="1" required disabled>
                                            </div>
                                        </div>

                                        <!-- Botones de acción -->
                                        <div class="form-group-lg">
                                            <div class="col-lg-2 text-left">
                                                <a href="aperturaycierre_index.php" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-remove"></i> Cancelar
                                                </a>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-save"></i> Ir Detalles
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Fin de cabecera -->
                            </div>
                        </div>
                </section>
            </div>
            <?php require 'menu/footer_lte.ctp'; ?>
        </div>
       
        <script>
            function tiposelect() {
                const tipoFactura = document.getElementById('vfac_condicion').value;
                const cantidadCuotasInput = document.getElementById('txtvencantcuotas');
                const intervaloCuotasInput = document.getElementById('vfac_intervalo');

                if (tipoFactura === 'CREDITO') {
                    cantidadCuotasInput.disabled = false;
                } else {
                    cantidadCuotasInput.disabled = true;
                    cantidadCuotasInput.value = 1; // Reiniciar a 1 si se selecciona CONTADO
                }
            }
        </script>
        <script>
            document.getElementById('facturaForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Evitar el envío del formulario

                const formData = new FormData(this);
                const data = Object.fromEntries(formData);

                // Enviar los datos al servidor (ejemplo usando fetch)
                fetch('ruta_a_tu_script_php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('resultado').innerText = data.mensaje;
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                            document.getElementById('resultado').innerText = 'Error al crear la factura.';
                        });
            });
        </script>
        <?php require 'menu/js_lte.ctp'; ?>
    </body>
</html>
