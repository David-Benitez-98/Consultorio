<?php
include '../../conexion.php';
$conexion = conexion::conectar();
$per_cod = $_POST['per_cod'];
$persona = pg_fetch_all(pg_query($conexion,"SELECT * FROM v_persona WHERE per_cod = $per_cod;"));
$ciudades = pg_fetch_all(pg_query($conexion,"SELECT * FROM v_ciudades WHERE id_ciu != ".$personas[0]['id_ciu']." AND estado = 'ACTIVO' ORDER BY ciu_descrip;"));
$generos = pg_fetch_all(pg_query($conexion,"SELECT * FROM generos WHERE id_gen != ".$personas[0]['id_gen']." AND estado = 'ACTIVO' ORDER BY gen_descrip;"));
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <label class="text-warning"><i class="fa fa-edit"></i> Modificar</label>
        </div>
        <div class="modal-body">
            <input type="hidden" id="id_per_editar" value="<?= $persona[0]['per_cod']; ?>">
            <div class="form-group">
                <label class="text-warning">C.I.</label>
                <input type="text" class="form-control" id="per_ci_editar" value="<?= $personas[0]['per_ci']; ?>">
            </div>
            <div class="form-group">
                <label class="text-warning">R.U.C.</label>
                <input type="text" class="form-control" id="per_ruc_editar" value="<?= $personas[0]['per_ruc']; ?>">
            </div>
            <div class="form-group">
                <label class="text-warning">Nombre(s)</label>
                <input type="text" class="form-control" id="per_nombre_editar" value="<?= $personas[0]['per_nombre']; ?>">
            </div>
            <div class="form-group">
                <label class="text-warning">Apellido(s)</label>
                <input type="text" class="form-control" id="per_apellido_editar" value="<?= $personas[0]['per_apellido']; ?>">
            </div>
            <div class="form-group">
                <label class="text-warning">Fecha de Nacimiento</label>
                <input type="date" class="form-control" value="<?= $personas[0]['per_fenaci']; ?>" id="per_fenaci_editar">
            </div>
            <div class="form-group">
                <label class="text-warning">Celular</label>
                <input type="text" class="form-control" id="per_celular_editar" value="<?= $personas[0]['per_celular']; ?>">
            </div>
            <div class="form-group">
                <label class="text-warning">Correo</label>
                <input type="text" class="form-control" id="per_email_editar" value="<?= $personas[0]['per_email']; ?>">
            </div>
            <div class="form-group">
                <label class="text-warning">Dirección</label>
                <input type="text" class="form-control" id="per_direccion_editar" value="<?= $personas[0]['per_direccion']; ?>">
            </div>
            <div class="form-group">
                <label class="text-warning">Ciudades</label>
                <select class="form-control select2" id="id_ciu_editar">
                    <option value="<?= $personas[0]['id_ciu']; ?>"><?= $personas[0]['ciu_descrip']." - ".$personas[0]['pais_descrip']; ?></option>
                    <?php foreach($ciudades as $c){ ?>
                        <option value="<?= $c['id_ciu']; ?>"><?= $c['ciu_descrip']." - ".$c['pais_descrip']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="text-warning">Género</label>
                <select class="form-control select2" id="id_gen_editar">
                    <option value="<?= $personas[0]['id_gen']; ?>"><?= $personas[0]['gen_descrip']; ?></option>
                    <?php foreach($generos as $g){ ?>
                        <option value="<?= $g['id_gen']; ?>"><?= $g['gen_descrip']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="text-warning">Estado Civil</label>
                <select class="form-control select2" id="id_ec_editar">
                    <option value="<?= $personas[0]['id_ec']; ?>"><?= $personas[0]['ec_descrip']; ?></option>
                    <?php foreach($estados_civiles as $e){ ?>
                        <option value="<?= $e['id_ec']; ?>"><?= $e['ec_descrip']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-cerrar-panel-editar"><i class="fa fa-ban"></i> Cancelar</button>
            <button type="button" class="btn btn-warning text-white" onclick="editar_grabar();"><i class="fa fa-save"></i> Modificar</button>
        </div>
    </div>
</div>