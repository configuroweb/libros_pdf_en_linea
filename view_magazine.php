<?php
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `magazine_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
    $user_qry = $conn->query("SELECT username,id,avatar FROM `users` where id = '{$user_id}' ");
    if($user_qry->num_rows > 0){
        $user_arr  = $user_qry->fetch_array();
    }
}
?>
<style>
    #magazine-cover-view{
        object-fit:scale-down;
        object-position:center center;
        height:30vh;
        width:20vw;
    }
    #author-avatar{
        height:35px;
        width:35px;
        object-fit: cover;
        object-position:center center;
        border-radius:50% 50%
    }
    #PDF-holder{
        height:80vh;
    }
    .comment-avatar{
        object-fit:cover;
        object-position:center center;
        width:3em;
        height:3em;
        border-radius:50% 50%
    }
    .comment-item .col-auto.flex-grow-1{
        max-width:calc(100% - 4em);
    }
</style>
<div class="py-3">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h5 class="card-title">Información del Libro</h5>
            <div class="card-tools">
                <button class="btn-primary" type="button" onclick="location.replace(document.referrer)"><i class="fa fa-angle-left"></i> Volver</button>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row justify-content-center align-items-end">
                    <div class="col-md-4 text-center">
                        <img src="<?= validate_image(isset($banner_path) ? $banner_path : "") ?>" alt="" id="magazine-cover-view" class="img-thumbnail bg-dark">
                    </div>
                    <div class="col-md-8">
                        <h2 class='text-purple'><b><?= isset($title) ? $title : "" ?></b></h2>
                        <hr>
                        <div class="row justify-content-between align-items-top">
                            <div class="col-auto">
                                <div class="d-flex align-items-center">
                                    <span>
                                        <img src="<?= validate_image(isset($user_arr['avatar']) ? $user_arr['avatar'] : "") ?>" alt="Author Image" id="author-avatar" class="img-thumbail border">
                                    </span>
                                    <span class="mx-2 text-muted"><?= isset($user_arr['username']) ? $user_arr['username'] : "N/A" ?></span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <span class="text-muted">
                                    <i class="fa fa-calendar-day"></i> <?= date("M d, Y h:i A",strtotime($date_created)) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-md-12">
                        <div class="text-muted">Descripción</div>
                        <div><?= isset($description) ? html_entity_decode($description) : "" ?></div>
                    </div>
                </div>
                <div class="row">
                    <h4 class="text-purple"><b>Archivo PDF</b></h4>
                    <hr>
                    <div class="w-100" id="PDF-holder">
                        <iframe src="<?= isset($pdf_path) ? base_url.$pdf_path : '' ?>" frameborder="1" class="w-100 h-100 bg-dark"></iframe>
                    </div>
                </div>
                <hr class="border-primary">
                <h3 class="text-muted">Commentarios:</h3>
                <?php 
                    $cwhere = " and status = 1";
                    if($_settings->userdata('id') > 0 && $_settings->userdata('type') == 1){
                        $cwhere = "";
                    }
                    $uqry = $conn->query("SELECT * FROM `users` where id in (Select user_id from comment_list where magazine_id = '{$id}' {$cwhere})");
                    $uarr = [];
                    if($uqry->num_rows > 0){
                        $res = $uqry->fetch_all(MYSQLI_ASSOC);
                        $uarr = array_column($res,'banner_path','id');
                    }
                    $comments = $conn->query("SELECT * from comment_list where magazine_id = '{$id}' {$cwhere} order by unix_timestamp(date_created) asc");
                    while($row = $comments->fetch_assoc()):
                ?>
                    <div class="callout border-primary comment-item">
                            <div class="row">
                                <div class="col-auto">
                                    <img src="<?= validate_image(!is_null($row['user_id']) && isset($uarr[$row['user_id']]) ? $uarr[$row['user_id']] : "" ) ?>" alt="Comment Avatar" class="comment-avatar img-thumbnail">
                                </div>
                                <div class="col-auto flex-grow-1">
                                    <b><?= ucwords($row['name']) ?></b><br>
                                    <small><span class="text-muted"><?= date("Y-m-d H:i",strtotime($row['date_created'])) ?></span></small>
                                </div>
                            </div>
                            <hr class="">
                            <p class="pl-5"><?php echo $row['comment'] ?></p>
                            <div class="my-1 text-right">
                            <?php
                                if(isset($row['status'])):
                                    switch($row['status']){
                                        case '1':
                                            echo "<span class='badge badge-success bg-primary badge-pill'>Verificado</span>";
                                            break;
                                        case '0':
                                            echo "<span class='badge badge-secondary badge-pill'>No verificado</span>";
                                            break;
                                    }
                                endif;
                            ?>
                            </div>
                    </div>
                <?php endwhile; ?>
                <?php if($comments->num_rows <= 0): ?>
                <div class="text-center">Sin comentarios que mostrar</div>
                <?php endif; ?>
                <div class="bg-gradient-light shadow px-2 py-3">
                    <h3 class="text-purple">Publica un comentario</h3>
                    <form action="" id="comment-form">
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="magazine_id" value="<?= $id ?>">
                        <input type="hidden" name="user_id" value="<?= $_settings->userdata('id') > 0 ? $_settings->userdata('id') : null ?>">
                        <?php if($_settings->userdata('id') <= 0): ?>
                        <div class="form-group">
                            <label for="name" class="control-label">Nombre</label>
                            <input type="text" class="form-control col-md-6 " name="name" required>
                        </div>
                        <?php else: ?>
                        <input type="hidden" name="name" value="<?= $_settings->userdata('username') ?>">
                        <input type="hidden" name="status" value="1">
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="comment" class="control-label">Comentario</label>
                            <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary">Publicar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#comment-form').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            $('.pop-msg').remove()
            var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=save_comment",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("Ocurrió un error",'error');
					end_loader();
				},
                success:function(resp){
                    if(resp.status == 'success'){
                        if($('#user_id').val() > 0)
                        location.reload();
                        else{
                            alert("Tu comentario ha sido ingresado exitósamente y podrás verlo después de la validación respectiva del Administrador")
                            location.reload();
                        }
                    }else if(!!resp.msg){
                        el.addClass("alert-danger")
                        el.text(resp.msg)
                        _this.prepend(el)
                    }else{
                        el.addClass("alert-danger")
                        el.text("A ocurrido un error")
                        _this.prepend(el)
                    }
                    el.show('slow')
                    end_loader();
                    $('html, body').animate({scrollTop:0},'fast')
                }
            })
        })
    })
</script>