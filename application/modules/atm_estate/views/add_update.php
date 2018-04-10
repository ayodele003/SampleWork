<form action="<?php echo base_url()."atm_estate/add_edit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 10px">
 <?php if(isset($data->atm_estate_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->atm_estate_id) ?$data->atm_estate_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group form-float">
<div class="form-line"><input type="text" class="form-control" id="atm_estate_bank_name" name="atm_estate_bank_name" required value="<?php echo isset($data->atm_estate_bank_name)?$data->atm_estate_bank_name:"";?>"  >
<label for="atm_estate_bank_name" class="form-label"><?php echo lang('bank_name'); ?> <span class="text-red">*</span></label>
</div></div>
<div class="form-group form-float">
<div class="form-line"><input type="number" class="form-control" id="atm_estate_quantity" name="atm_estate_quantity" required value="<?php echo isset($data->atm_estate_quantity)?$data->atm_estate_quantity:"";?>"  >
<label for="atm_estate_quantity" class="form-label"><?php echo lang('quantity'); ?> <span class="text-red">*</span></label>
</div></div>

        		<?php get_custom_fields('atm_estate', isset($data->atm_estate_id)?$data->atm_estate_id:NULL); ?>
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