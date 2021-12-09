<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM registration_list where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_array() as $k=>$v){
            $$k= $v;
        }

        $qry_meta = $conn->query("SELECT * FROM registration_details where registration_id = '{$id}'");
        while($row = $qry_meta->fetch_assoc()){
            ${$row['meta_field']} = $row['meta_value'];
        }
    }else{
        echo "<script>alert('Unkown Registration ID');location.replace('./');</script>";
        exit;
    }
    $bride = "{$bride_firstname} {$bride_middlename} {$bride_lastname}";
    $groom = "{$groom_firstname} {$groom_middlename} {$groom_lastname}";
    if($action_user_id > 0){
        $action_by_qry = $conn->query("SELECT CONCAT(firstname,' ',COALESCE(middlename,''), ' ',lastname) as fullname FROM `users` where id= '{$action_user_id}'");
        if($action_by_qry->num_rows > 0){
            $res = $action_by_qry->fetch_array();
            $action_by = $res['fullname'];
        }
    }
}
?>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header rounded-0">
        <h5 class="card-title">Registration Code: <?= isset($registration_code) ? $registration_code : "" ?></h5>
    </div>
    <div class="card-body rounded-0">
        <div class="container-fluid" id="print_out">
            <style>
                @media print{
                    .bg-lightblue {
                        background-color: #3c8dbc !important;
                    }
                }
                body {
                -webkit-print-color-adjust: exact !important;
                }
            </style>
            <h3 class="text-center">Marriage Certificate</h3>
            <hr>
            <div>
                <dl>
                    <dt class="text-info">Registration Code: </dt>
                    <dd class="pl-4"><?= ($registration_code) ?></dd>
                    <dt class="text-info">Marriage Date</dt>
                    <dd class="pl-4"><?= date("M d, Y", strtotime($schedule)) ?></dd>
                </dl>
            </div>
            <fieldset>
                <legend class="text-info">Husband's Information</legend>
                    <div class="row">
                        <div class="col-4 text-center">
                            <img src="<?= validate_image(isset($groom_image) ? $groom_image : '') ?>" alt="Groom's Image" class="img-fluid imgs border border-2 border-dark">
                        </div>
                        <div class="col-8">
                            <dl>
                                <dt class="text-muted">Name</dt>
                                <dd class="pl-4"><?= ucwords($groom) ?></dd>
                                <dt class="text-muted">Date of Birth</dt>
                                <dd class="pl-4"><?= date("M d, Y", strtotime($groom_dob)) ?></dd>
                                <dt class="text-muted">Religion</dt>
                                <dd class="pl-4"><?= $groom_religion ?></dd>
                                <dt class="text-muted">Present Address</dt>
                                <dd class="pl-4"><?= $groom_present_address ?></dd>
                                <dt class="text-muted">Permanent Address</dt>
                                <dd class="pl-4"><?= $groom_permanent_address ?></dd>
                            </dl>
                        </div>
                    </div>
                    <hr>
            </fieldset>
            <fieldset>
                <legend class="text-info">Wife's Information</legend>
                    <div class="row">
                        <div class="col-4 text-center">
                            <img src="<?= validate_image(isset($bride_image) ? $bride_image : '') ?>" alt="Bride's Image" class="img-fluid imgs border border-2 border-dark">
                        </div>
                        <div class="col-8">
                            <dl>
                                <dt class="text-muted">Name</dt>
                                <dd class="pl-4"><?= ucwords($bride) ?></dd>
                                <dt class="text-muted">Date of Birth</dt>
                                <dd class="pl-4"><?= date("M d, Y", strtotime($bride_dob)) ?></dd>
                                <dt class="text-muted">Religion</dt>
                                <dd class="pl-4"><?= $bride_religion ?></dd>
                                <dt class="text-muted">Present Address</dt>
                                <dd class="pl-4"><?= $bride_present_address ?></dd>
                                <dt class="text-muted">Permanent Address</dt>
                                <dd class="pl-4"><?= $bride_permanent_address ?></dd>
                            </dl>
                        </div>
                    </div>
                    <hr>
            </fieldset>
            <fieldset>
                <legend class="text-info">Witnesses</legend>
                <table class="table table-bordered">
                    <colgroup>
                        <col width="10%">
                        <col width="45%">
                        <col width="45%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="text-center py-1 px-2">#</th>
                            <th class="text-center py-1 px-2">Name</th>
                            <th class="text-center py-1 px-2">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center py-1 px-2">1</td>
                            <td class=" py-1 px-2"><?= ucwords($witness1_name) ?></td>
                            <td class=" py-1 px-2"><?= ucwords($witness1_address) ?></td>
                        </tr>
                        <tr>
                            <td class="text-center py-1 px-2">2</td>
                            <td class=" py-1 px-2"><?= ucwords($witness2_name) ?></td>
                            <td class=" py-1 px-2"><?= ucwords($witness2_address) ?></td>
                        </tr>
                        <tr>
                            <td class="text-center py-1 px-2">3</td>
                            <td class=" py-1 px-2"><?= ucwords($witness3_name) ?></td>
                            <td class=" py-1 px-2"><?= ucwords($witness3_address) ?></td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
            <div>
                <dl>
                    <dt class="text-info">Status: </dt>
                    <dd class="pl-4">
                        <?php if($status == 1): ?>
                            <span class="badge badge-success rounded-pill">Verified</span>
                        <?php elseif($status == 2): ?>
                            <span class="badge badge-danger rounded-pill">Rejected</span>
                        <?php else: ?>
                            <span class="badge badge-primary rounded-pill">Pending</span>
                        <?php endif; ?>
                    </dd>
                    <dt class="text-info">
                        <?php if($status == 1): ?>
                            Verificado por:
                        <?php elseif($status == 2): ?>
                            Rechazado por:
                        <?php endif; ?>
                    </dt>
                    <dd class="pl-4"><?= ucwords(isset($action_by)? $action_by : '') ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="card-footer text-center rounded-0">
            <button class="btn btn-flat btn-sn btn-success" type="button" id="print"><i class="fa fa-print"></i> Print</button>
            <a class="btn btn-flat btn-sn btn-primary" href="<?= base_url."admin/?page=application/manage_application&id={$id}" ?>" id="print"><i class="fa fa-edit"></i> Edit</a>
            <button class="btn btn-flat btn-sn btn-danger" type="button" id="delete"><i class="fa fa-trash"></i> Delete</button>
            <a class="btn btn-flat btn-sn btn-dark" href="<?php echo base_url ?>">Volver a la lista</a>
    </div>
</div>
<script>
    
    $(function(){
        $('#delete').click(function(){
            _conf("Are you sure to delete this data?","delete_data");
        })
        $('#print').click(function(){
            start_loader()
            var _el = $('<div>')
            var _head = $('head').clone()
                _head.find('title').text("Mirrage Certificate - Print View")
            var p = $('#print_out').clone()
            p.find('tr.text-light').removeClass("text-light")
            p.find('tr.bg-lightblue').removeClass("bg-lightblue")
            _el.append(_head)
            _el.append(p.html())
            var nw = window.open("","","width=1200,height=900,left=250,location=no,titlebar=yes")
                     nw.document.write(_el.html())
                     nw.document.close()
                     setTimeout(() => {
                         nw.print()
                         setTimeout(() => {
                            nw.close()
                            end_loader()
                         }, 200);
                     }, 500);
        })
    })
    function delete_data($id="<?php echo isset($id) ? $id : '' ?>"){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_marriage_information",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace('./?page=application');
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>