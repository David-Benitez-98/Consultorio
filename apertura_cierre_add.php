<!DOCTYPE html>
<html>
     <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Apertura y Cierre de Caja - Sistema Consultorio</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php
        session_start();
        require 'menu/css_lte.ctp';
        ?>
    </head>
     <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-success">
                                 <div class="box-header">
                                    <i class="ion ion-plus"></i><i class="fa fa-money"></i>
                                    <h3 class="box-title">Registrar Apertura de Caja</h3>
                                    <div class="box-tools">
                                        <a href="aperturaycierre_index.php" class="btn btn-success btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>
                                    </div>
                                </div>

                                <form action="aperturaycierre_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vaper_cod" value="0"/>                                    
                                    <div class="box-body"> 

                                    <!-- Monto Inicial -->
                                    <div class="form-group">
                                        <label class="control-label col-lg-2 col-md-2">Monto Inicial:</label>
                                        <div class="col-lg-3 col-md-3">
                                            <input type="number" name="vaper_monto" class="form-control" required placeholder="100.000"/>
                                        </div>
                                    </div>

                                        <!-- Seleccionar Caja -->
                                        
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2">Caja:</label>
                                            <div class="col-lg-5 col-md-5">
                                                <select required class="form-control" name="caj_cod" id="detalles">
                                                <option value="0">Seleccione una caja</option>
                                                <?php
                                                $cajas = consultas::get_datos("SELECT * FROM cajas");
                                                foreach ($cajas as $c) {
                                                    echo "<option value='{$c['caj_cod']}'>{$c['caj_descrip']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                        <!-- Fecha de Apertura -->
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2">Fecha de Apertura:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i:s'); ?>" readonly/>
                                            </div>
                                        </div>
                                        <!-- Monto Inicial -->
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2" for="montocierre">Monto Cierre:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" name="txtmontocierre" id="txtmontocierre" title="txtmontocierre" class="form-control" value="" disabled=""/>
                                            </div>
                                        </div>
                                        

                                    </div>

                                    <!-- Botones -->
                                    <div class="box-footer">
                                        <button type="reset" class="btn btn-default" data-title="Cancelar" rel="tooltip">
                                            <i class="fa fa-remove"></i> Cancelar</button>                                        
                                        <!-- Botón de submit -->
                                        <button type="submit" class="btn btn-primary pull-right">Confirmar Apertura</button>
                                    </form>
                                            <!--div class="col-md-2 text-right">
                                                <input id="btnGrabar" type="button" class="form-control btn-success" value="Grabar"  onclick="grabar();"/>
                                            </div-->
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            document.querySelector('form').addEventListener('submit', function(event) {
                const cajaSelect = document.querySelector('select[name="caj_cod"]');
                if (cajaSelect.value === "0") {
                    alert("Por favor seleccione una caja válida.");
                    event.preventDefault();
                }
            });
            </script>


            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->
        </div>

        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
    </body>
</html>

