<?php if(CheckPermission("ATM Estate", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="atm_estate")?"active":"not-active"?>">
						<a href="<?php echo base_url("atm_estate"); ?>" data-crud_id="25065" class="EditCrud"><i class="glyphicon glyphicon-eye-open"></i> <span><?php echo lang('atm_estate'); ?></span></a>
					</li><?php }?>
<?php if(CheckPermission("Engineer Details", "all_read,own_read")){ ?>
					<li class="<?=($this->router->class==="engineer_details")?"active":"not-active"?>">
						<a href="<?php echo base_url("engineer_details"); ?>" data-crud_id="25229" class="EditCrud"><i class="glyphicon glyphicon-user"></i> <span><?php echo lang('engineer_details'); ?></span></a>
					</li><?php }?>
