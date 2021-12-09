<style>
  .user-img{
        position: absolute;
        height: 27px;
        width: 27px;
        object-fit: cover;
        left: -7%;
        top: -12%;
  }
  .btn-rounded{
        border-radius: 50px;
  }
</style>
<!-- Navbar -->
      <?php if($_settings->userdata('id') > 0): ?>
      <style>
        #login-nav{
          position:fixed !important;
          top: 0 !important;
          z-index: 1037;
        }
        #top-Nav{
          top: 30px;
        }
        .text-sm .layout-navbar-fixed .wrapper .main-header ~ .content-wrapper, .layout-navbar-fixed .wrapper .main-header.text-sm ~ .content-wrapper {
          margin-top: calc(4.93725rem + 1px);
      }
      </style>
      <nav class="bg-dark w-100 px-2 py-1 position-fixed top-0" id="login-nav">
        <div class="text-right">
          <a href="./admin" class="mx-2">Panel Administrativo</a>
          <span class="mx-2">Hola, hola <?= $_settings->userdata('username') ?></span>
          <span class="mx-1"><a href="<?= base_url.'classes/Login.php?f=logout' ?>"><i class="fa fa-power-off"></i></a></span>
        </div>
      </nav>
      <?php endif; ?>
      <nav class="main-header navbar navbar-expand navbar-light border border-light border-top-0  border-left-0 border-right-0 navbar-light text-sm bg-primary text-light" id='top-Nav'>
        
        <div class="container">
          <a href="./" class="navbar-brand">
            <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Site Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light text-light"><?php echo $_settings->info('short_name') ?></span>
          </a>

          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a href="./" class="nav-link <?= isset($page) && $page =='home' ? "active" : "" ?>">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle  <?= isset($page) && $page =='categories' ? "active" : "" ?>">Categorías</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                  <?php 
                  $category = $conn->query("SELECT * FROM `category_list` where `status` = 1 order by `name` asc");
                  $count = $category->num_rows;
                  $i = 1;
                  while($row = $category->fetch_assoc()):
                    
                  ?>
                  <li><a href=".?page=categories&c=<?= $row['id'] ?>" class="dropdown-item"><?= ucwords($row['name']) ?></a></li>
                  <?php
                    if($i < $count): 
                  ?>
                  <li class="dropdown-divider"></li>
                  <?php endif;$i++; ?>
                  <?php endwhile; ?>
                  <!-- End Level two -->
                </ul>
              </li>
              <!-- <li class="nav-item">
                <a href="#" class="nav-link">Contact</a>
              </li> -->
            </ul>

            
          </div>
          <!-- Right navbar links -->
          <div class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- SEARCH FORM -->
            <form class="form-inline ml-0 ml-md-3" id="search-form">
                <div class="input-group input-group-sm">
                  <input class="form-control form-control-navbar" type="search" placeholder="Búsqueda" name="q" value="<?= isset($_GET['q']) ? urldecode($_GET['q']) : "" ?>" aria-label="Search">
                  <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
            </form>
          <?php if($_settings->userdata('id') <= 0): ?>
            <a href="./admin" class="nav-link">Acceder</a>
            <?php endif; ?>
        </div>
        </div>
      </nav>
      <!-- /.navbar -->
      <script>
        $(function(){
          $('#search-form').submit(function(e){
            e.preventDefault()
            if($('[name="q"]').val().length == 0)
            location.href = './';
            else
            location.href = './?'+$(this).serialize();
          })
        })
      </script>