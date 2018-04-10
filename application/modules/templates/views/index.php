<!-- <div class="modal fade" id="nameModal_Templates"  role="dialog">Modal Crud Start
  <div class="col-md-offset-4 col-md-4">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <h3 class="box-title">Templates</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div> -->
<div class="modal fade" id="nameModal_Templates"  role="dialog"><!-- Modal Crud Start-->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h3><?php echo lang('templates'); ?></h3>
      </div>
      <div class="modal-body" style="padding: 25px 0px 0px 0px;"></div>
    </div>
  </div>
</div><!--End Modal Crud -->
<!-- start: PAGE CONTENT -->
<div class="col-md-12 m-t-20">
  <div class="box-body">						
    <table id="example_Templates" class="cell-border example_Templates table table-striped table1 table-bordered table-hover dataTable" style="width: -1px;">
      <thead>
        <tr>
          <th><?php echo lang('template_name'); ?></th>
          <th><?php echo lang('Action'); ?></th>
        </tr>
      </thead>
      <tbody>
      </tbody> 
    </table>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.row -->
<!-- Modal -->
<div id="previewModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('template_preview'); ?></h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) { 
	var url = "<?php echo base_url();?>";
    $("#example_Templates").DataTable({ 
        "processing": true,
        "serverSide": true,
		"language": {"search": "_INPUT_", "searchPlaceholder": "<?php echo lang('search'); ?>"}, 
		"iDisplayLength": 10,
		"aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"<?php echo lang('all'); ?>"]],
        "ajax": url+"templates/ajax_data"
    });


} );

function setId(id) {
	var url =  "<?php echo site_url();?>";
	$("#cnfrm_delete").find("a.yes-btn").attr("href",url+"/templates/delete_data/"+id);
}
</script>
