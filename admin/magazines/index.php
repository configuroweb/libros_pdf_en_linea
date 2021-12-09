<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Lista de Libros PDF</h3>
		<div class="card-tools">
			<a href="./?page=magazines/manage_magazine" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Agregar Nuevo Libro</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="30%">
					<col width="20%">
					<col width="15%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Fecha de Creación</th>
						<th>Libros PDF</th>
						<th>Autor</th>
						<th>Estado</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
                        $mwhere = "";
                        if($_settings->userdata('type') != 1){
                            $mwhere = " where user_id = '{$_settings->userdata('id')}' ";
                        }
                        $users_qry = $conn->query("SELECT id,username FROM `users` where id in (SELECT user_id from `magazine_list` {$mwhere}) ");
                        $user_res = $users_qry->fetch_all(MYSQLI_ASSOC);
                        $user_arr = array_column($user_res,'username','id');
						$qry = $conn->query("SELECT * from `magazine_list` {$mwhere} order by `title` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td class="truncate-1"><?php echo ucwords($row['title']) ?></td>
							<td><?php echo isset($user_arr[$row['user_id']]) ? $user_arr[$row['user_id']] : "N/A" ?></td>
							<td class="text-center">
                                <?php
                                    switch($row['status']){
                                        case '1':
                                            echo "<span class='badge badge-success bg-primary badge-pill'>Publicado</span>";
                                            break;
                                        case '0':
                                            echo "<span class='badge badge-secondary badge-pill'>No Publicado</span>";
                                            break;
                                    }
                                ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Acción
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="./?page=magazines/view_magazine&id=<?= $row['id'] ?>" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> Ver</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item" href="./?page=magazines/manage_magazine&id=<?= $row['id'] ?>" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Editar</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Eliminar</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("¿Estás segur@ de eliminar estas revistas de forma permanente?","delete_magazine",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
	})
	function delete_magazine($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_magazine",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("Ocurrió un error",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("Ocurrió un error",'error');
					end_loader();
				}
			}
		})
	}
</script>