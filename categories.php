<style>
    .magazine-cover{
        width:10em;
    }
    .magazine-item .col-auto{
        max-width: calc(100% - 12em) !important;
    }
    .magazine-item:hover{
        transform:translate(0, -4px);
        background:#a5a5a521;
    }
</style>
<?php 
if(isset($_GET['c'])){
    $qry = $conn->query("SELECT * FROM category_list where id = '{$_GET['c']}' and `status` = 1");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }else{
        echo "<script>alert('Unknown category ID.');location.href='./';</script>";
    }
}else{
    echo "<script>alert('Unknown category ID.');location.href='./';</script>";
}
?>
<h1><?= ucwords($name) ?></h1>
<div class="card card-outline card-primary shadow">
    <div class="card-body">
        <div class="container-fluid">
            <div class="list-group">
            <?php 
                $users_qry = $conn->query("SELECT id,username FROM `users` where id in (SELECT user_id from `magazine_list` where `status` = 1 and category_id = '{$id}') ");
                $user_res = $users_qry->fetch_all(MYSQLI_ASSOC);
                $user_arr = array_column($user_res,'username','id');
                $magazines = $conn->query("SELECT * FROM `magazine_list` where `status` = 1 and category_id = '{$id}' order by unix_timestamp(date_created) desc");
                while($row = $magazines->fetch_assoc()):
                    $row['description'] = strip_tags(html_entity_decode($row['description']));
            ?>
            <a href="./?page=view_magazine&id=<?= $row['id'] ?>" class="list-group-item text-decoration-none text-dark magazine-item">
                <div class="w-100 d-flex flex-nowrap mx-0">
                    <div class="col-auto">
                        <img src="<?= validate_image($row['banner_path']) ?>" alt="" class="float-left m-1 magazine-cover">
                    </div>
                    <div class="col-auto flex-grow-1">
                        <div class="col-12">
                            <h3 class="text-purple"><?= $row['title'] ?></h3>
                            <hr class="border-primary mb-0">
                            <div class="w-100 d-flex justify-content-between align-items-top">
                                <span class="text-muted">Generada por: <?= isset($user_arr[$row['user_id']]) ? $user_arr[$row['user_id']] : 'N/A' ?></span>
                                <span class="text-muted"><i class="fa fa-calendar-day"></i> <?= date('Y-m-d H:i',strtotime($row['date_created'])) ?></span>
                            </div>
                            <p>
                                <?= substr($row['description'],0,500) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
            <?php endwhile; ?>
            <?php if($magazines->num_rows < 1): ?>
                <center><span class="text-muted">Sin libros listados aún</span></center>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
