<form action="<?php echo base_url()."fault_calls/add_edit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->fault_calls_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->fault_calls_id) ?$data->fault_calls_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="fault_calls_engineer_name" name="fault_calls_engineer_name" required value="<?php echo isset($data->fault_calls_engineer_name)?$data->fault_calls_engineer_name:"";?>"  >
<label for="fault_calls_engineer_name" class="form-label"><?php echo lang('engineer_name'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="fault_calls_bank_name" name="fault_calls_bank_name" required value="<?php echo isset($data->fault_calls_bank_name)?$data->fault_calls_bank_name:"";?>"  >
<label for="fault_calls_bank_name" class="form-label"><?php echo lang('bank_name'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="fault_calls_terminal_id" name="fault_calls_terminal_id" required value="<?php echo isset($data->fault_calls_terminal_id)?$data->fault_calls_terminal_id:"";?>"  >
<label for="fault_calls_terminal_id" class="form-label"><?php echo lang('terminal_id'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="fault_calls_terminal_name" name="fault_calls_terminal_name" required value="<?php echo isset($data->fault_calls_terminal_name)?$data->fault_calls_terminal_name:"";?>"  >
<label for="fault_calls_terminal_name" class="form-label"><?php echo lang('terminal_name'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="fault_calls_terminal_location" name="fault_calls_terminal_location" required value="<?php echo isset($data->fault_calls_terminal_location)?$data->fault_calls_terminal_location:"";?>"  >
<label for="fault_calls_terminal_location" class="form-label"><?php echo lang('terminal_location'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="fault_calls_fault_description" name="fault_calls_fault_description" required value="<?php echo isset($data->fault_calls_fault_description)?$data->fault_calls_fault_description:"";?>"  >
<label for="fault_calls_fault_description" class="form-label"><?php echo lang('fault_description'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="fault_calls_error_code" name="fault_calls_error_code" required value="<?php echo isset($data->fault_calls_error_code)?$data->fault_calls_error_code:"";?>"  >
<label for="fault_calls_error_code" class="form-label"><?php echo lang('error_code'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="date" class="form-control" id="fault_calls_date_logged" name="fault_calls_date_logged"  value="<?php echo isset($data->fault_calls_date_logged)?date("Y-m-d",strtotime($data->fault_calls_date_logged)):date("Y-m-d",strtotime("now"));?>"  >
<label for="fault_calls_date_logged" class="form-label"><?php echo lang('date_logged'); ?> </label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="fault_calls_time_loggged" name="fault_calls_time_loggged"  value="<?php echo isset($data->fault_calls_time_loggged)?$data->fault_calls_time_loggged:"";?>"  >
<label for="fault_calls_time_loggged" class="form-label"><?php echo lang('time_loggged'); ?> </label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><select name="fault_calls_status" class="form-control" id="fault_calls_status"  required><option value=""></option>
                        			<option value="Open" <?php if(isset($data->fault_calls_status) && ($data->fault_calls_status == "Open")){ echo "selected";}?>><?php echo lang('open'); ?></option>
<option value="Closed" <?php if(isset($data->fault_calls_status) && ($data->fault_calls_status == "Closed")){ echo "selected";}?>><?php echo lang('closed'); ?></option>
</select>
<label for="fault_calls_status" class="form-label"><?php echo lang('status'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="date" class="form-control" id="fault_calls_date_resolved" name="fault_calls_date_resolved"  value="<?php echo isset($data->fault_calls_date_resolved)?date("Y-m-d",strtotime($data->fault_calls_date_resolved)):date("Y-m-d",strtotime("now"));?>"  >
<label for="fault_calls_date_resolved" class="form-label"><?php echo lang('date_resolved'); ?> </label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="fault_calls_time_resolved" name="fault_calls_time_resolved"  value="<?php echo isset($data->fault_calls_time_resolved)?$data->fault_calls_time_resolved:"";?>"  >
<label for="fault_calls_time_resolved" class="form-label"><?php echo lang('time_resolved'); ?> </label>
</div></div>

        		<?php get_custom_fields('fault_calls', isset($data->fault_calls_id)?$data->fault_calls_id:NULL); ?>
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