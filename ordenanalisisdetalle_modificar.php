<?php
require 'clases/conexion.php';
session_start();

$detalles = consultas::get_datos("select * from v_ordenanalisisdetalle"
            . " where oa_cod=" . $_REQUEST['voa_cod'] . " and tipooa_cod =" . $_REQUEST['vtipooa_cod']);?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> <strong>Modificar Detalle Orden Analisis</strong></h4>
</div>

<form action="ordenanalisisdetalle_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="3"/>
    <input type="hidden" name="voa_cod" value="<?php echo $detalles[0]['oa_cod'] ?>"/>
    <input type="hidden" name="vtipooa_cod" value="<?php echo $detalles[0]['tipooa_cod'] ?>"/>
    <div class="modal-body">

        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Tipo de Analisis:</label>
            <div class="col-lg-6 col-md-6 col-sm-7">
                <?php
                $tipoanalisis = consultas::get_datos("SELECT * FROM v_tipo_ordenanalisis ORDER BY tipooa_cod");
                ?>
                <select class="form-control select2" name="vtipooa_cod">
                    <?php if (!empty($tipoanalisis)) { ?>            
                        <option value="0">Seleccionar Tipo Orden de Analisis</option>       
                        <?php foreach ($tipoanalisis as $tipoa) { ?>
                            <option value="<?php echo $tipoa['tipooa_cod']; ?>"><?php echo $tipoa['tipooa_descri']; ?></option>                          
                            <?php
                        }
                    }
                    ?>
                    <?php ?>        
                </select>
            </div>
            <br>
            <br>
            <br>
            <div class="form-group">
                <label class="control-label col-lg-2 col-sm-2 col-md-2">Observacion:</label>
                <div class="col-lg-6 col-sm-6 col-md-7">
                    <input type="text" name="vobservacion" class="form-control"  required="" value="<?php echo $detalles[0]['observacion'] ?>"/>
                </div>
            </div> 
        </div>
        
    </div>    
    
        <div class="modal-footer">
            <button type="reset" data-dismiss="modal" class="btn btn-default">
                <i class="fa fa-remove"></i> Cerrar
            </button>
            <button type="submit" class="btn btn-warning">
                <i class="fa fa-floppy-o"></i> Actualizar
            </button>                                      
        </div>
</form>