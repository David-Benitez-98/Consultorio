<?php
require 'clases/conexion.php';
session_start();

$detalles = consultas::get_datos("select * from v_ordenestudiosdetalle"
            . " where oe_cod=" . $_REQUEST['voe_cod'] . " and tipooe_cod =" . $_REQUEST['vtipooe_cod']);?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> <strong>Modificar Detalle Orden Estudio</strong></h4>
</div>

<form action="ordenestudiosdetalle_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="3"/>
    <input type="hidden" name="voe_cod" value="<?php echo $detalles[0]['oe_cod'] ?>"/>
    <input type="hidden" name="vtipooe_cod" value="<?php echo $detalles[0]['tipooe_cod'] ?>"/>
    <div class="modal-body">

        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Tipo de Estudios:</label>
            <div class="col-lg-6 col-md-6 col-sm-7">
                <?php
                $tipoestudio = consultas::get_datos("SELECT * FROM v_tipo_ordenestudio ORDER BY tipooe_cod");
                ?>
                <select class="form-control select2" name="vtipooe_cod">
                    <?php if (!empty($tipoestudio)) { ?>            
                        <option value="0">Seleccionar Tipo Orden de Estudio</option>       
                        <?php foreach ($tipoestudio as $tipoe) { ?>
                            <option value="<?php echo $tipoe['tipooe_cod']; ?>"><?php echo $tipoe['tipooe_descri']; ?></option>                          
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