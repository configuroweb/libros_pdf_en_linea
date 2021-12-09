<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

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
		<h3 class="card-title">List of Registrations</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Code</th>
						<th>Partner's Name</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT *  from `registration_list` order by `status` asc, unix_timestamp(date_created) desc ");
						while($row = $qry->fetch_assoc()):
							$meta = $conn->query("SELECT * FROM `registration_details` where registration_id ='{$row['id']}' and (`meta_field` in ('bride_firstname','bride_middlename','bride_lastname','groom_firstname','groom_middlename','groom_lastname'))");
							$couple = array_column($meta->fetch_all(MYSQLI_ASSOC),'meta_value','meta_field');
							$bride = "{$couple['bride_firstname']} {$couple['bride_middlename']} {$couple['bride_lastname']}";
							$groom = "{$couple['groom_firstname']} {$couple['groom_middlename']} {$couple['groom_lastname']}";
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-right"><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['registration_code'] ?></td>
							<td class="lh-1">
								<small><span class="text-muted">Groom: </span><?= ucwords($groom) ?></small><br>
								<small><span class="text-muted">Bride: </span><?= ucwords($bride) ?></small>
							</td>
							<td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success rounded-pill">Verified</span>
								<?php elseif($row['status'] == 2): ?>
                                    <span class="badge badge-danger rounded-pill">Rejected</span>
                                <?php else: ?>
                                    <span class="badge badge-primary rounded-pill">Pending</span>
                                <?php endif; ?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="<?php echo base_url."admin?page=application/view_application&id=".$row['id'] ?>" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
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
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable();
	})
	
</script>