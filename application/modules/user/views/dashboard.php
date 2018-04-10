<!-- Content Wrapper. Contains page content -->
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
      		<h2><?php echo lang('dashboard'); ?></h2>
    	</div>
	  		<div class="row clearfix">
		    		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			          	<div class="info-box bg-pink hover-expand-effect EditDeshbord" data-deshbid_id=8128  data-deshbid_type=info_box style="background-color: #f10b0b !important;">
			            	<div class="icon">
				                <span class="glyphicon glyphicon-earphone"></span>
				            </div>
			            	<div class="content">
			            		<div class="text">OPENED CALLS</div>
			            		<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo isset($OPENED_CALLS_data[0]->mka)?number_format($OPENED_CALLS_data[0]->mka):'0'; ?></div>
			            	</div>
			            <!-- /.info-box-content -->
			          	</div>
			          <!-- /.info-box -->
			        </div>
		    		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			          	<div class="info-box bg-pink hover-expand-effect EditDeshbord" data-deshbid_id=9340  data-deshbid_type=info_box style="background-color: #00ffd9 !important;">
			            	<div class="icon">
				                <span class="glyphicon glyphicon-earphone"></span>
				            </div>
			            	<div class="content">
			            		<div class="text">CLOSED CALLS</div>
			            		<div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?php echo isset($CLOSED_CALLS_data[0]->mka)?number_format($CLOSED_CALLS_data[0]->mka):'0'; ?></div>
			            	</div>
			            <!-- /.info-box-content -->
			          	</div>
			          <!-- /.info-box -->
			        </div></div><div class="row  clearfix"><div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
  <div class="card mka-das-table EditDeshbord" data-deshbid_type="list_box" data-deshbid_id="9341">
      <div class="header">
          <h2>ATM ESTATE</h2>
      </div>
      <!-- /.box-header -->
      <div class="body" style="display: block;">
          <div class="table-responsive">
            <table class="table table-hover dashboard-task-infos">
                <thead>
                  <tr>
                    <th>Bank Name</th>
						<th>Quantity</th>
						
                  </tr>
                </thead>
                <tbody>
                  <?php
	              	if(is_array($atm_estate_list) && !empty($atm_estate_list)) {
	              		foreach ($atm_estate_list as $key => $value) {
	              	?>
		              <tr><td><?php echo $value->atm_estate_bank_name; ?></td>
							<td><?php echo $value->atm_estate_quantity; ?></td>
							</tr>
		            <?php } } else { ?>
		            	<tr>
							<td colspan="<?php echo count($atm_estate_list); ?>"> <span>No Result Found.</span> </td>
						</tr>
					<?php } ?>
		            
                </tbody>
            </table>
          </div>
        <!-- /.table-responsive -->
      </div>
      <!-- /.box-body -->
     <!--  <div class="box-footer clearfix" style="display: block;">
       <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
       <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
     </div> -->
      <!-- /.box-footer -->
  </div>
</div></div></div>
</section>
		