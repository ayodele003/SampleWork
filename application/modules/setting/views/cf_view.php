<div class="col-md-12">
	<div class="box-header my-header">
		<div class="pull-right">
            <button type="button" class="btn-sm  btn btn-primary waves-effect modalButton" ><i class="material-icons">add</i> <?php echo lang('add_field'); ?></button>
        </div>
		<h3 class="box-title"><?php echo lang('custom_fields'); ?> </h3>
		<hr>

	</div>
	<div class="box-body">
		<table id="custom-fileds" class="cell-border table table-striped table1 table-bordered table-hover dataTable" style="width: 100%;">
			<thead>
				<tr>
					<th><?php echo lang('id'); ?></th>
					<th><?php echo lang('name'); ?></th>
					<th><?php echo lang('type'); ?></th>
					<th><?php echo lang('module'); ?></th>
					<th><?php echo lang('status'); ?></th>
					<th><?php echo lang('action'); ?></th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>
<div class="modal fade" id="custom_fields_modal"  role="dialog"><!-- Modal Crud Start-->
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header">
			  	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			  	<h3 class="modal-title"><?php echo lang('add_field'); ?></h3>
			 	<hr>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div><!--End Modal Crud -->

<script>
	$(document).ready(function() {
		$('#custom-fileds').dataTable({
			"dom": 'lfrtip',
	        "processing": true,
	        "serverSide": true,
	        "ajax": {
	        	url: 'setting/ajax_data'
	        },
		});

		$('body').on("click",".modalButton", function(e) {  
	    	var loading = '<img src="<?php echo mka_base() ?>assets/images/loading.gif" />';
	    	$("#custom_fields_modal").find(".modal-body").html(loading);
	    	$("#custom_fields_modal").find(".modal-body").attr("style","text-align: center");    
		    $.ajax({
				url : "<?php echo base_url()."setting/get_modal";?>",
				method: "post", 
				data : {
				id: $(this).attr("data-src")
				}
				}).done(function(data) {
				$("#custom_fields_modal").find(".modal-body").removeAttr("style");  
				$("#custom_fields_modal").find(".modal-body").html(data);
				$("#custom_fields_modal").modal("show");
				$(".form_check").each(function() {
		          	$p_obj = $(this);
		          	$res = 1;
	          		if($p_obj.find(".check_box").hasClass("required")) {
	            		if($p_obj.find(".check_box").is(":checked")) {
	              			$res = "0";
	            		}
	          		}
		          	if($res == 0) {
		            	$(".check_box").prop("required", false);
		          	}
		        }) 
		    })
	  	});

	  	$('body').off('click', '.yes-btn');
		$('body').on('click', '.yes-btn', function(e) {
			e.preventDefault();
			$.post($(this).attr('href'), function(data) {
				$('tbody').find('tr').each(function() {
					$ob = $(this);
					$dom_val = $ob.find('td').first().text();
					$('#cnfrm_delete').modal('hide');
					$.each(data, function(index, val) {
						if($dom_val == val) {
							$ob.fadeOut('slow');
						}
					});
				});
			}, 'json');
		});
	})
</script>
	
