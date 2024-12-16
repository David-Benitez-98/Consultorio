<?php
require 'clases/conexion.php';
session_start();

$detalles = consultas::get_datos("select * from v_recetasindicacionesdetalle"
                . " where re_cod=" . $_REQUEST['vre_cod'] . " and medi_cod =" . $_REQUEST['vmedi_cod']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> <strong>Modificar Detalle Recetas/Indicaciones</strong></h4>
</div>
<form action="recetasindicacionesdetalle_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="3"/>
    <input type="hidden" name="vre_cod" value="<?php echo $detalles[0]['re_cod'] ?>"/>
    <input type="hidden" name="vmedi_cod" value="<?php echo $detalles[0]['medi_cod'] ?>"/>
    <div class="modal-body">

        
            <div class="col-lg-6 col-md-6 col-sm-7">
                <label>Medicamentos:</label>
                <?php
                $medicamentos = consultas::get_datos("SELECT * FROM v_medicamentostipo ORDER BY medi_cod");
                ?>
                <select class="form-control select2" name="vmedi_cod">
                    <?php if (!empty($medicamentos)) { ?>            
                        <option value="0">Seleccionar Medicamentos</option>       
                        <?php foreach ($medicamentos as $med) { ?>
                            <option value="<?php echo $med['medi_cod']; ?>"><?php echo $med['medi_descri']; ?>
                                - <?php echo $med['tipomedi_descri']; ?></option>                          
                            <?php
                        }
                    }
                    ?>
                    <?php ?>        
                </select>
            </div>
 

        <div class="col-lg-6 col-md-6 col-sm-7">
            <label>Indicaciones</label>
            <input type="text" class="form-control" name="vre_indi" value="<?php echo $detalles[0]['re_indi'] ?>"/>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-7">
            <label>Observaciones</label>
            <input type="text" class="form-control" name="vre_observ" value="<?php echo $detalles[0]['re_observ'] ?>"/>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-7">
            <label>HORA:</label>
            <input type="time" class="form-control" name="vhora" value="<?php echo $detalles[0]['hora'] ?>"/>
        </div>
        <br>
        <div class="col-lg-6 col-md-6 col-sm-7">
            <label>Dosis:</label>
            <input type="text" class="form-control" name="vdosis" value="<?php echo $detalles[0]['dosis'] ?>"/>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-7">
            <label>Cantidad:</label>
            <input type="numeric" class="form-control" name="vcantidad" value="<?php echo $detalles[0]['det_cantidad'] ?>"/>
        </div>
    </div>

    <div class="modal-footer" >
        <button type="reset" data-dismiss="modal" class="btn btn-default">
            <i class="fa fa-remove"></i> Cerrar
        </button>
        <button type="submit" class="btn btn-warning">
            <i class="fa fa-floppy-o"></i> Actualizar
        </button>                                      
    </div>
</form>