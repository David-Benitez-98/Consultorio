<?php 
require 'clases/conexion.php';
session_start();

$detalle = consultas::get_datos("select * from v_agenda_detalle"
        . " where agen_cod=".$_REQUEST['vagen_cod']." and doc_cod =".$_REQUEST['vdoc_cod']
        ." and esp_cod =".$_REQUEST['vesp_cod'] 
        ."and dia_cod =".$_REQUEST['vdia_cod']
          ." and tur_cod =".$_REQUEST['vtur_cod']
          ." and sal_cod =".$_REQUEST['vsal_cod'] );
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> <strong>Editar Detalle de Agenda</strong></h4>
</div>
<form action="agendadetalle_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="2"/>
    <input type="hidden" name="vagen_cod" value="<?php echo $detalle[0]['agen_cod'] ?>"/>
    <input type="hidden" name="vdoc_cod" value="<?php echo $detalle[0]['doc_cod'] ?>"/>
    <input type="hidden" name="vesp_cod" value="<?php echo $detalle[0]['esp_cod'] ?>"/>
    <input type="hidden" name="vdia_cod" value="<?php echo $detalle[0]['dia_cod'] ?>"/>
    <input type="hidden" name="vtur_cod" value="<?php echo $detalle[0]['tur_cod'] ?>"/>
    <input type="hidden" name="vsal_cod" value="<?php echo $detalle[0]['sal_cod'] ?>"/>
    <div class="modal-body">
        
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Doctor:</label>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="<?php echo $detalle[0]['doctor']?>"/>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Especialidad:</label>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="<?php echo $detalle[0]['esp_descri']?>"/>
            </div>
        </div> 
        
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Dias:</label>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="<?php echo $detalle[0]['dia_descri']?>"/>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Turno:</label>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="<?php echo $detalle[0]['tur_descri']?>"/>
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