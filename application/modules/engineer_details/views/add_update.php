<form action="<?php echo base_url()."engineer_details/add_edit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->engineer_details_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->engineer_details_id) ?$data->engineer_details_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="engineer_details_engineer_first_name_" name="engineer_details_engineer_first_name_" required value="<?php echo isset($data->engineer_details_engineer_first_name_)?$data->engineer_details_engineer_first_name_:"";?>"  >
<label for="engineer_details_engineer_first_name_" class="form-label"><?php echo lang('engineer_first_name_'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="engineer_details_engineer_last_name" name="engineer_details_engineer_last_name" required value="<?php echo isset($data->engineer_details_engineer_last_name)?$data->engineer_details_engineer_last_name:"";?>"  >
<label for="engineer_details_engineer_last_name" class="form-label"><?php echo lang('engineer_last_name'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="engineer_details_engineer_email" name="engineer_details_engineer_email" required value="<?php echo isset($data->engineer_details_engineer_email)?$data->engineer_details_engineer_email:"";?>"  >
<label for="engineer_details_engineer_email" class="form-label"><?php echo lang('engineer_email'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="engineer_details_engineer_number" name="engineer_details_engineer_number" required value="<?php echo isset($data->engineer_details_engineer_number)?$data->engineer_details_engineer_number:"";?>"  >
<label for="engineer_details_engineer_number" class="form-label"><?php echo lang('engineer_number'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="engineer_details_location" name="engineer_details_location" required value="<?php echo isset($data->engineer_details_location)?$data->engineer_details_location:"";?>"  >
<label for="engineer_details_location" class="form-label"><?php echo lang('location'); ?> <span class="text-red">*</span></label>
</div></div>

        		<?php get_custom_fields('engineer_details', isset($data->engineer_details_id)?$data->engineer_details_id:NULL); ?>
        		</div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                  	 <input type="submit" value="<?php echo lang('save'); ?>" name="save" class="btn btn-primary btn-color">
                  </div>
               </form>
            <script>
  				$.AdminBSB.input.activate();
  				$(document).ready(function() {
				  $('.mka-cl').on('click', function() {
				    if($(this).parents('.input-group').first().find('input.mka-pass-field').hasClass('showing')){
				      $(this).parents('.input-group').first().find('input.mka-pass-field').removeClass('showing').attr('type', 'password');
				    } else {
				      $(this).parents('.input-group').first().find('input.mka-pass-field').addClass('showing').attr('type', 'text');
				    }
				  });
				});
			</script>