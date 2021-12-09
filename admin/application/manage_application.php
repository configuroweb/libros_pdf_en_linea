<style>
    img.cimg{
		height: 15vh;
		width: 15vh;
		object-fit: scale-down;
		object-position: center;
	}
</style>
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
}
?>
<div class="card rounded-0 card-outline card-primary shadow">
    <div class="card-header rounded-0">
        <h5 class="card-title">
            <?php echo !isset($_GET['id']) ? "Create New Registration" : "Update Registration Details".(isset($registration_code)? " - <span class='text-info'>{$registration_code}</span>" : "") ?>
        </h5>
    </div>
    <div class="card-body rounded-0">
        <form action="" id="mregistration-form">
            <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
            <div class="col-12">
                <fieldset>
                    <legend class="text-dark">Groom's Information</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="groom_firstname" class="control-label text-info">Firstname</label>
                                <input type="text" name="groom_firstname" id="groom_firstname" class="form-control border-0 border-bottom rounded-0" required value="<?= isset($groom_firstname) ? $groom_firstname : '' ?>" autofucos>
                            </div>
                            <div class="form-group">
                                <label for="groom_middlename" class="control-label text-info">Middlename</label>
                                <input type="text" name="groom_middlename" id="groom_middlename" class="form-control border-0 border-bottom rounded-0" value="<?= isset($groom_middlename) ? $groom_middlename : '' ?>" palceholder="optional">
                            </div>
                            <div class="form-group">
                                <label for="groom_lastname" class="control-label text-info">Lastname</label>
                                <input type="text" name="groom_lastname" id="groom_lastname" class="form-control border-0 border-bottom rounded-0" value="<?= isset($groom_lastname) ? $groom_lastname : '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="groom_dob" class="control-label text-info">Date of Birth</label>
                                <input type="date" name="groom_dob" id="groom_dob" class="form-control border-0 border-bottom rounded-0" value="<?= isset($groom_dob) ? $groom_dob : '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="groom_religion" class="control-label text-info">Religion</label>
                                <input type="text" name="groom_religion" id="groom_religion" class="form-control border-0 border-bottom rounded-0" value="<?= isset($groom_religion) ? $groom_religion : '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="groom_permanent_address" class="control-label text-info">Permanent Address</label>
                                <textarea rows="2" name="groom_permanent_address" id="groom_permanent_address" class="form-control border-0 border-bottom rounded-0" style="resize:none" required><?= isset($groom_permanent_address) ? $groom_permanent_address : '' ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="groom_present_address" class="control-label text-info">Present Address</label>
                                <textarea rows="2" name="groom_present_address" id="groom_present_address" class="form-control border-0 border-bottom rounded-0" style="resize:none" required><?= isset($groom_present_address) ? $groom_present_address : '' ?></textarea>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <img src="<?php echo validate_image(isset($groom_image) ? $groom_image : "") ?>" alt="" class="img-fluid img-thumbnail border bg-black groom cimg">
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img[groom]" onchange="displayImg(this,$(this),$('.cimg.groom'))">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </fieldset>
                <fieldset>
                    <legend class="text-dark">Bride's Information</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bride_firstname" class="control-label text-info">Firstname</label>
                                <input type="text" name="bride_firstname" id="bride_firstname" class="form-control border-0 border-bottom rounded-0" required value="<?= isset($bride_firstname) ? $bride_firstname : '' ?>" autofucos>
                            </div>
                            <div class="form-group">
                                <label for="bride_middlename" class="control-label text-info">Middlename</label>
                                <input type="text" name="bride_middlename" id="bride_middlename" class="form-control border-0 border-bottom rounded-0" value="<?= isset($bride_middlename) ? $bride_middlename : '' ?>" palceholder="optional">
                            </div>
                            <div class="form-group">
                                <label for="bride_lastname" class="control-label text-info">Lastname</label>
                                <input type="text" name="bride_lastname" id="bride_lastname" class="form-control border-0 border-bottom rounded-0" value="<?= isset($bride_lastname) ? $bride_lastname : '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="bride_dob" class="control-label text-info">Date of Birth</label>
                                <input type="date" name="bride_dob" id="bride_dob" class="form-control border-0 border-bottom rounded-0" value="<?= isset($bride_dob) ? $bride_dob : '' ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="bride_religion" class="control-label text-info">Religion</label>
                                <input type="text" name="bride_religion" id="bride_religion" class="form-control border-0 border-bottom rounded-0" value="<?= isset($bride_religion) ? $bride_religion : '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bride_permanent_address" class="control-label text-info">Permanent Address</label>
                                <textarea rows="2" name="bride_permanent_address" id="bride_permanent_address" class="form-control border-0 border-bottom rounded-0" style="resize:none" required><?= isset($bride_permanent_address) ? $bride_permanent_address : '' ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="bride_present_address" class="control-label text-info">Present Address</label>
                                <textarea rows="2" name="bride_present_address" id="bride_present_address" class="form-control border-0 border-bottom rounded-0" style="resize:none" required><?= isset($bride_present_address) ? $bride_present_address : '' ?></textarea>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <img src="<?php echo validate_image(isset($bride_image) ? $bride_image : "") ?>" alt="" class="img-fluid img-thumbnail border bg-black bride cimg">
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img[bride]" onchange="displayImg(this,$(this),$('.cimg.bride'))">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </fieldset>
                <fieldset>
                    <legend class="text-dark">Witnesses</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="witness1_name">Name</label>
                                <input type="text" name="witness1_name" id="witness1_name" class="form-control border-0 border-bottom rounded-0" value="<?= isset($witness1_name) ? $witness1_name : '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="witness1_address">Address</label>
                                <input type="text" name="witness1_address" id="witness1_address" class="form-control border-0 border-bottom rounded-0" value="<?= isset($witness1_address) ? $witness1_address : '' ?>" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="witness2_name">Name</label>
                                <input type="text" name="witness2_name" id="witness2_name" class="form-control border-0 border-bottom rounded-0" value="<?= isset($witness2_name) ? $witness2_name : '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="witness2_address">Address</label>
                                <input type="text" name="witness2_address" id="witness2_address" class="form-control border-0 border-bottom rounded-0" value="<?= isset($witness2_address) ? $witness2_address : '' ?>" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="witness3_name">Name</label>
                                <input type="text" name="witness3_name" id="witness3_name" class="form-control border-0 border-bottom rounded-0" value="<?= isset($witness3_name) ? $witness3_name : '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="witness3_address">Address</label>
                                <input type="text" name="witness3_address" id="witness3_address" class="form-control border-0 border-bottom rounded-0" value="<?= isset($witness3_address) ? $witness3_address : '' ?>" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                </fieldset>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-info" for="schedule">Marriage Date</label>
                            <input type="date" name="schedule" id="schedule" class="form-control border-0 border-bottom rounded-0" value="<?= isset($schedule) ? $schedule : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status" class="control-label text-info">Status</label>
                            <select name="status" id="status" class="custom-select form-control-border border-width-2">
                            <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Verified</option>
                            <option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>Rejected</option>
                            <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-info" for="remarks">Remarks</label>
                            <textarea rows="3" name="remarks" id="remarks" class="form-control border-0 border-bottom rounded-0" style="resize:none"><?= isset($remarks) ? $remarks : '' ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer text-center rounded-0">
        <button class="btn btn-primary rounded-0" type="submit" form="mregistration-form">Save</button>
        <a href="./" class="btn btn-light border-secondary rounded-0">Cancel</a>
    </div>
</div>
<script>
    function displayImg(input,_this,image) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	image.attr('src', e.target.result);
                _this.siblings('label').text(input.files[0].name)
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
            image.attr('src', "<?php echo validate_image('') ?>");
            _this.siblings('label').text('Choose file')
        }
	}
    $(function(){
        $('#mregistration-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_marriage_information",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.replace("./?page=application/view_application&id="+resp.id);
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
                    $('html,body').animate({scroolTop:0},'fast')
				}
			})
		})
    })
</script>