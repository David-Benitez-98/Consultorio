<?php
require 'clases/conexion.php';
session_start();

$detalles = consultas::get_datos("select * from v_consultadetalle"
                . " where cod_consulta=" . $_REQUEST['vcod_consulta'] . " and sin_cod =" . $_REQUEST['vsin_cod']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> <strong>Modificar Detalle Consulta</strong></h4>
</div>
<form action="consultadetalle_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="3"/>
    <input type="hidden" name="vcod_consulta" value="<?php echo $detalles[0]['cod_consulta'] ?>"/>
    <input type="hidden" name="vsin_cod" value="<?php echo $detalles[0]['sin_cod'] ?>"/>
    <div class="modal-body">
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Sintomas:</label>
            <div class="col-lg-6 col-md-6 col-sm-7">
                <?php $sintomas = consultas::get_datos("SELECT * FROM sintomas WHERE sin_estado = 'ACTIVO' ORDER BY sin_cod"); ?>
                <select class="form-control select2" name="vsin_cod">
                    <?php if (!empty($sintomas)) { ?>            
                        <option value="0">Seleccionar Síntomas</option>       
                        <?php foreach ($sintomas as $sin) { ?>
                            <option value="<?php echo $sin['sin_cod']; ?>"><?php echo $sin['sin_descri']; ?></option>                          
                            <?php
                        }
                    }  
                        ?>
                    <?php  ?>        
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Observacion:</label>
            <div class="col-lg-6 col-sm-6 col-md-7">
                <input type="text" name="vobservacion" class="form-control"  required="" value="<?php echo $detalles[0]['observacion'] ?>"/>
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