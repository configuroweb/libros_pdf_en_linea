<h1>Bienvenid@ <?php echo $_settings->info('name') ?></h1>
<hr class="border-info">
<div class="row">
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book-open"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Libros</span>
            <span class="info-box-number text-right">
                <?php 
                    $mwhere = "";
                    $mwhere2 = "";
                    if($_settings->userdata('type') != 1){
                        $mwhere = " where user_id = '{$_settings->userdata('id')}'";
                        $mwhere2 = " and user_id = '{$_settings->userdata('id')}'";
                    }
                    echo $conn->query("SELECT * FROM `magazine_list` {$mwhere}")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-book-open"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Publicados</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `magazine_list` where `status` = 1 {$mwhere2}")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-book-open"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">No Publicados</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `magazine_list` where `status` = 2 {$mwhere2}")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <?php if($_settings->userdata('type') == 1): ?>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Usuarios Verificados</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `users` where `status` = 1")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-light shadow">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Usuarios no Verificados</span>
            <span class="info-box-number text-right">
                <?php 
                    echo $conn->query("SELECT * FROM `users` where `status` = 0")->num_rows;
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <?php endif; ?>
</div>