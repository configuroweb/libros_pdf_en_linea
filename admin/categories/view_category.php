<?php
require_once('../../config.php');
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `category_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none !important;
    }
</style>
<div class="container-fluid">
    <dl>
        <dt class="text-muted">Nombre</dt>
        <dd class='pl-4 text-purple fs-4 fw-bold'><?= isset($name) ? $name : '' ?></dd>
        <dt class="text-muted">Descripción</dt>
        <dd class='pl-4 text-dark'>
            <p class=""><small><?= isset($description) ? $description : '' ?></small></p>
        </dd>
        <dt class="text-muted">Estado</dt>
        <dd class='pl-4 text-purple'>
            <?php
            if(isset($status)):
                switch($status){
                    case '1':
                        echo "<span class='badge badge-success bg-primary badge-pill'>Activo</span>";
                        break;
                    case '0':
                        echo "<span class='badge badge-secondary badge-pill'>Inactivo</span>";
                        break;
                }
            endif;
            ?>
        </dd>
    </dl>
    <div class="col-12 text-right">
        <button class="btn btn-flat btn-sm btn-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
    </div>
</div>