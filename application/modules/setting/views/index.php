<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <?php echo lang("settings");?>                              
                        </h2>
                    </div>
                    <div class="body">
                      <div class="row">
                  <div class="col-lg-12">
                    <div class="tabbable">
                      <ul id="myTab4" class="nav nav-tabs">
                        <li class="active">
                          <a href="#tab_General" data-toggle="tab">
                            <i class="fa fa-cogs"></i>&nbsp;&nbsp; 
                            <span><?php echo lang("general");?></span>
                          </a>
                        </li>
                        <li>
                          <a href="#emailSetting" data-toggle="tab">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp;&nbsp; 
                            <span><?php echo lang("email");?></span>
                          </a>
                        </li>
                        <li id="permis">
                          <a href="#permissionSetting" data-toggle="tab">
                            <i class="fa fa-indent" aria-hidden="true"></i> 
                            <span><?php echo lang("permission");?></span>
                          </a>
                        </li>
                        <li id="templates">
                          <a href="#templates-div" data-toggle="tab">
                            <i class="fa fa-puzzle-piece" aria-hidden="true"></i> 
                            <span><?php echo lang('templates'); ?></span>
                          </a>
                        </li>
                        <li id="custom-fields">
                          <a href="#custom-fields-div" data-toggle="tab">
                            <i class="fa fa-cog" aria-hidden="true"></i> 
                            <span><?php echo lang('custom_fields'); ?></span>
                          </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane fade in" id="templates-div"></div>
                        <div class="tab-pane fade in" id="custom-fields-div">
                          <?php $this->load->view('cf_view'); ?>
                        </div>
                        <div class="tab-pane fade active in" id="tab_General">
                          <form method="post" enctype="multipart/form-data" action="<?php echo base_url().'setting/edit_setting' ?>" data-parsley-validate class="form-horizontal form-label-left demo-form2">
                            <div class="col-md-12 m-t-20">
                              <div class="form-group form-float">
                                  <div class="form-line">
                                      <input type="text" id="" class="form-control" name="website" required="" value="<?php echo isset($result['website'])?$result['website'] :'';?>">
                                      <label class="form-label"><?php echo lang("title_of_website");?> *</label>
                                  </div>
                              </div>

                              <?php //if(isset($result['UserModules']) && $result['UserModules']=='yes'){ ?>
                              <div class="form-group form-float m-t-30">
                                <?php 
                                  $permissiona = getAllDataByTable('permission'); 
                                  $i = 0;
                                  foreach($permissiona as $perkey => $value){
                                    $user_type = isset($value->user_type)?$value->user_type:''; 
                                    if($user_type != 'admin') {
                                ?>
                                <div class="row">
                                  <div class="col-md-3">
                                  <?php if($i == 0) { ?>
                                    <label for="" class="label-control"> <?php echo lang('user_type'); ?>: </label>
                                  <?php } ?>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-line">
                                      <input type="text" class="form-control inp-field" data-old-id="<?php echo $value->id; ?>" name="user_type_name[<?php echo $value->id; ?>]" value="<?php echo $user_type; ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                  <?php if($i == 0) { ?>
                                    <button class="btn btn-success ad-u-type-btn btn-sm" type="button" title="<?php echo lang('add_new'); ?>"><i class="material-icons">add_circle</i></button>
                                  <?php } else { ?>
                                    <button class="btn btn-danger rm-u-type-btn btn-sm" type="button" title="<?php echo lang('remove'); ?>"><i class="material-icons">remove_circle</i></button>
                                  <?php } ?>
                                  </div>
                                </div>
                                <?php 
                                $i++; } }
                                ?>
                              </div>
                              <div class="form-group form-float m-t-30">
                                <input type="checkbox" name="register_allowed" id="register_allowed" <?php if(isset($result['register_allowed']) && $result['register_allowed']==1){echo'checked="checked"';}?> value="1" />
                                <label for="register_allowed"><?php echo lang('allow_signup'); ?></label>
                              </div>

                              <div class="form-group form-float m-t-30">
                                <input type="checkbox" name="admin_approval" id="admin_approval" <?php if(isset($result['admin_approval']) && $result['admin_approval']==1){echo'checked="checked"';}?> value="1" />
                                <label for="admin_approval"><?php echo lang('admin_approval'); ?></label>
                              </div>
                              <div class="form-group form-float m-t-20">
                                <div class="form-line">
                                <label class="form-label "><?php echo lang('user_type');?> *</label>
                                  <select name="user_type[]" class="form-control m-t-10" multiple="multiple">
                                    <?php $permissiona =getAllDataByTable('permission');
                                      foreach($permissiona as $perkey=>$value){
                                        $user_type = isset($value->user_type)?$value->user_type:''; 
                                        if($user_type != 'admin') {
                                        $old = json_decode($result['user_type']);
                                    ?>
                                          <option value="<?php echo $user_type;?>" <?php if(in_array(strtolower($user_type), array_map('strtolower', $old))){echo'selected';}?>><?php echo ucfirst($user_type);?></option>
                                      <?php } } ?>
                                  </select>
                                </div>
                              </div>
                              <!-- <div class="form-group form-float m-t-20">
                                <div class="form-line">
                                <label class="form-label "><?php //echo lang('date_formate');?> *</label>
                                  <select name="date_formate" class="form-control m-t-10">
                                    <option value="YY-MM-DD">YY-MM-DD</option>
                                    <option value="MM-YY-DD">MM-YY-DD</option>
                                  </select>
                                </div>
                              </div> -->
                              <div class="form-group form-float m-t-20">
                                <div class="row">
                                  <div class="col-md-3">
                                    <div class="form-line">
                                        <select name="api_status" class="form-control m-t-20" id="">
                                          <option value="enable" <?= isset($result['api_status']) && $result['api_status'] == 'enable'?'selected':''; ?> ><?php echo lang('enable'); ?></option>
                                          <option value="disabled" <?= isset($result['api_status']) && $result['api_status'] == 'disabled'?'selected':''; ?>><?php echo lang('disabled'); ?></option>
                                        </select>
                                        <label class="form-label "><?php echo lang('api_status');?> *</label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="col-md-9">
                                      <div class="form-line">
                                        <input type="text" class="form-control m-t-20" name="api_key" value="<?= isset($result['api_key'])?$result['api_key']:''; ?>">
                                        <label class="form-label "><?php echo lang('api_key');?> *</label>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <button class="btn btn-primary waves-effect upd-api-key m-t-20" type="button"> <i class="material-icons">refresh</i> </button>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-line">
                                        <select name="token_expiration" class="form-control m-t-20" id="">
                                          <option value="10" <?= isset($result['token_expiration']) && $result['token_expiration'] == '10'?'selected':''; ?> >10 <?php echo lang('minutes'); ?></option>
                                          <option value="20" <?= isset($result['token_expiration']) && $result['token_expiration'] == '20'?'selected':''; ?>>20 <?php echo lang('minutes'); ?></option>
                                          <option value="30" <?= isset($result['token_expiration']) && $result['token_expiration'] == '30'?'selected':''; ?>>30 <?php echo lang('minutes'); ?></option>
                                          <option value="40" <?= isset($result['token_expiration']) && $result['token_expiration'] == '40'?'selected':''; ?>>40 <?php echo lang('minutes'); ?></option>
                                          <option value="50" <?= isset($result['token_expiration']) && $result['token_expiration'] == '50'?'selected':''; ?>>50 <?php echo lang('minutes'); ?></option>
                                          <option value="60" <?= isset($result['token_expiration']) && $result['token_expiration'] == '60'?'selected':''; ?>>60 <?php echo lang('minutes'); ?></option>
                                        </select>
                                        <label class="form-label "><?php echo lang('token_expiration');?> *</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php //}?>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group col-md-2 col-sm-2  col-xs-2 ">
                                  <span for="exampleInputFile"><?php echo lang('website_logo'); ?>: </span>
                                </div>
                                <div class="form-group pic_size col-sm-4 col-xs-4 text-center" id="logo-holder">
                                  <img class="thumb-image logo setpropileam" src="<?php echo mka_base().'assets/images/'.(isset($result['logo']) && $result['logo'] != '' ?$result['logo']:"logo.png");?>"  alt="logoSite">
                                </div>
                                <div class="col-md-3 p-d-0 mrg-left-5">
                                  <div class="fileUpload btn btn-primary waves-effect">
                                    <span><?php echo lang('change_logo'); ?></span>
                                      <input type="file" class="upload" name="logo" id="logoSite" name="logo"  value="" accept="image/*">
                                      <input type="hidden" name="fileOldlogo" value="<?php echo isset($result['logo'])?$result['logo']: "";?>">
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group col-md-2 col-sm-2  col-xs-2 dsize">
                                  <span for="exampleInputFile" class="thfont"><?php echo lang('website_favicon'); ?>: </span>
                                </div>
                                <div class=" form-group pic_size col-sm-4 col-xs-4 text-center" id="favicon-holder" >
                                  <img class="thumb-image favicon setpropileam" src="<?php echo mka_base().'assets/images/'.(isset($result['favicon']) && $result['favicon'] != ''?$result['favicon']:"favicon.ico");?>"  alt="favicon">
                                </div>
                                <div class="col-md-3 p-d-0 mrg-left-5">
                                  <div class="fileUpload btn btn-primary waves-effect">
                                    <span><?php echo lang('change_favicon'); ?></span>
                                    <input type="hidden" name="fileOldfavicon" value="<?php echo isset($result['favicon'])?$result['favicon']:"";?>">
                                    <input type="file" class="upload" name="favicon" id="favicon" value="" accept="image/*">
                                 </div>
                                </div>
                              </div>
                            </div>
                            <div class="row col-md-10" align="center">
                              <div class="form-group sub-btn-wdt">
                                <input type="submit" value="<?php echo lang('save'); ?>" class="btn btn-primary btn-lg waves-effect">
                              </div>          
                            </div>
                                <!--/.col (left) -->
                              </form> 
                            </div>
                            <div class="tab-pane fade" id="emailSetting">
                              <form method="post" enctype="multipart/form-data" action="<?php echo base_url().'setting/edit_setting' ?>" data-parsley-validate class="form-horizontal form-label-left demo-form2">
                                <div class="col-md-12">
                                  <div class=""> 

                                    <div class="form-group form-float m-t-20">
                                        <input type="radio" id="php_mailer" name="mail_setting" value="php_mailer" <?php if(isset($result['mail_setting']) && $result['mail_setting']=='php_mailer'){echo "checked";}?> >
                                        <label for="php_mailer" class="thfont"> <?php echo lang('smtp'); ?> </label>
                                        <input type="radio" id="simple_mail" name="mail_setting" value="simple_mail"  <?php if(isset($result['mail_setting']) && $result['mail_setting']=='simple_mail'){echo "checked";}?>>
                                        <label for="simple_mail" class="thfont"> <?php echo lang('server_default'); ?> </label>
                                    </div>

                                    <div id="phpmailer" style="display:<?php if(isset($result['mail_setting']) && $result['mail_setting']=='php_mailer'){echo "block";}else{ echo 'none'; }?>;" >
                                      <div class="form-group form-float m-t-20">
                                          <div class="form-line">
                                            <input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo isset($result['company_name'])?$result['company_name'] :'';?>">
                                            <label class="form-label" for=""><?php echo lang('company_name'); ?></label>
                                          </div>
                                      </div>

                                      <div class="form-group form-float m-t-20">
                                        <div class="form-line">
                                          <input type="email" class="form-control" name="SMTP_EMAIL" id="SMTP_EMAIL" value="<?php echo isset($result['SMTP_EMAIL'])?$result['SMTP_EMAIL'] :'';?>">
                                          <label class="form-label" for="SMTP_EMAIL"><?php echo lang('smtp_email'); ?>:</label>
                                        </div>
                                      </div>

                                      <div class="form-group form-float m-t-20">
                                          <div class="form-line">
                                            <input type="text" class="form-control" name="HOST" id="HOST" value="<?php echo isset($result['HOST'])?$result['HOST'] :'';?>">
                                            <label class="form-label" for="HOST"><?php echo lang('smtp_host'); ?>:</label>
                                          </div>
                                      </div>

                                      <div class="form-group form-float m-t-20">
                                        <div class="form-line">
                                          <input type="text" class="form-control" name="PORT" id="PORT" value="<?php echo isset($result['PORT'])?$result['PORT'] :'';?>">
                                          <label class="form-label" for="PORT"><?php echo lang('smtp_port') ?>:</label>
                                        </div>
                                      </div>

                                      <div class="form-group form-float m-t-20">
                                        <div class="form-line">
                                          <input type="text" class="form-control" name="SMTP_SECURE" id="SMTP_SECURE" value="<?php echo isset($result['SMTP_SECURE'])?$result['SMTP_SECURE'] :'';?>">
                                          <label class="form-label" for="SMTP_SECURE"><?php echo lang('smtp_secure'); ?>:</label>
                                        </div>
                                      </div>

                                      <div class="form-group form-float m-t-20 ">
                                          <div class="form-line">
                                            <input type="text" style="display: none;">
                                            <input type="password" class="form-control showpassword" name="SMTP_PASSWORD" id="test1" value="<?php echo isset($result['SMTP_PASSWORD'])?$result['SMTP_PASSWORD'] :'';?>">
                                            <label class="form-label" for="SMTP_PASSWORD"><?php echo lang('smtp_password'); ?>:</label>
                                          </div>
                                          <!-- <input id="test2" type="checkbox" />Show password -->
                                      </div>
                                    </div>
                                    <div id="simplemail"  style="display:<?php if(isset($result['mail_setting']) && $result['mail_setting']=='simple_mail'){echo "block";}else{ echo 'none'; }?>;">

                                      <div class="form-group form-float m-t-20">
                                        <div class="form-line">
                                          <input type="text" class="form-control" name="company_name" id="company_name" value="<?php echo isset($result['company_name'])?$result['company_name'] :'';?>">
                                          <label class="form-label" for=""><?php echo lang('company_name'); ?>:</label>
                                        </div>
                                      </div>

                                      <div class="form-group form-float m-t-20">
                                        <div class="form-line">
                                          <input type="email" class="form-control" name="EMAIL" id="EMAIL" value="<?php echo isset($result['EMAIL'])?$result['EMAIL'] :'';?>">
                                          <label class="form-label" for="EMAIL"><?php echo lang('email'); ?>:</label>
                                        </div>
                                      </div>

                                    </div>
                                    <div class="row col-md-10 m-t-20" align="center">
                                      <div class="form-group sub-btn-wdt">
                                        <input name="register_allowed" type="hidden" value="<?php if(isset($result['register_allowed'])&& $result['register_allowed']==1){echo'1';} else { echo '0'; }?>" >
                                        <input type="submit" value="Save" class="btn btn-primary waves-effect">
                                      </div>          
                                    </div>
                                  </div>
                                </div>
                              </form> 
                            </div>
                            <div class="tab-pane " id="permissionSetting">
                              <form class="form-horizontal" action="<?php echo base_url().'setting/permission' ?>" method="post">
                              <?php 
                              $permission = getAllDataByTable('permission');
                              $setPermission =array();
                              $own_create = '';$own_read = '';$own_update = '';$own_delete = '';
                              $all_create = '';$all_read = '';$all_update = '';$all_delete = '';
                              $i=0;
                              $permission = isset($permission)&&is_array($permission)&&!empty($permission)?$permission:array();
                              if(isset($permission[1])) {
                                foreach($permission as $perkey=>$value){
                                  $id = isset($value->id)?$value->id:'';
                                  $user_type = isset($value->user_type)?$value->user_type:'';
                                  $data = isset($value->data)?json_decode($value->data):'';
                                  if($user_type=='admin'){}else{
                              ?>
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                        <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $id;?>"><i class="fa fa-bars"></i> <?php echo  lang('permissions_for').': '. ucfirst($user_type);?></a></h4>
                                      </div>
                                      <?php /*if($i==0){echo"in";}*/ ?>
                                      <div id="collapse_<?php echo $id;?>" class="panel-collapse collapse">
                                        <div class="panel-body table-responsive">
                                          <table class="table table-bordered dt-responsive rolesPermissionTable">
                                            <thead>
                                              <tr class="showRolesPermission">
                                                <th scope="col"><?php echo lang('modules'); ?></th>
                                                <th scope="col"><?php echo lang('create'); ?></th>
                                                <th scope="col"><?php echo lang('read'); ?></th>
                                                <th scope="col"><?php echo lang('update'); ?></th>
                                                <th scope="col"><?php echo lang('delete'); ?></th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php 
                                              if(isset($data) && !empty($data)){
                                                foreach($data as $perkey=>$valueR){
                                                  $perkey = isset($perkey)?$perkey:'';
                                                  $valueR = isset($valueR)?$valueR:'';
                                                  if(isset($valueR)) {
                                                    $setPermissionCheck = $valueR;
                                                    $own_create = isset($setPermissionCheck->own_create)?$setPermissionCheck->own_create:'';
                                                    $own_read = isset($setPermissionCheck->own_read)?$setPermissionCheck->own_read:'';
                                                    $own_update = isset($setPermissionCheck->own_update)?$setPermissionCheck->own_update:'';
                                                    $own_delete = isset($setPermissionCheck->own_delete)?$setPermissionCheck->own_delete:'';
                                                    $all_create = isset($setPermissionCheck->all_create)?$setPermissionCheck->all_create:'';
                                                    $all_read = isset($setPermissionCheck->all_read)?$setPermissionCheck->all_read:'';
                                                    $all_update = isset($setPermissionCheck->all_update)?$setPermissionCheck->all_update:'';
                                                    $all_delete = isset($setPermissionCheck->all_delete)?$setPermissionCheck->all_delete:'';
                                                  } else {
                                                    $setPermissionCheck =array();$own_create = '';$own_read = '';$own_update = '';$own_delete = '';
                                                    $all_create = '';$all_read = '';$all_update = '';$all_delete = '';
                                                  }
                                                ?>
                                                  <tr>
                                                    <th scope="col" colspan="5" class="showRolesPermission text-center"><?php echo ucfirst(str_replace('_', ' ', $perkey));?>
                                                      <?php  
                                                            //$perkey = str_replace(' ', '_SPACE_', $perkey); 
                                                            $user_type = str_replace(' ', '_SPACE_', $user_type); 
                                                      ?>
                                                      <input type="hidden" name="data[<?php echo $user_type;?>][<?php echo $perkey;?>]" value="<?php echo $perkey;?>" />
                                                    </th>
                                                  </tr>
                                                  <tr>
                                                    <th scope="row" class="thfont"><?php echo lang('own_entries'); ?><input type="checkbox" class="pull-right sell_all"></th>
                                                    <td><input type="checkbox" class="chk_create" name="data[<?php echo $user_type;?>][<?php echo $perkey;?>][own_create]" value="1" <?php if($own_create==1){echo"checked";}?>/></td>
                                                    <td><input type="checkbox" class="chk_read" name="data[<?php echo $user_type;?>][<?php echo $perkey;?>][own_read]"  value="1" <?php if($own_read==1){echo"checked";}?>/></td>
                                                    <td><input type="checkbox" class="chk_update" name="data[<?php echo $user_type;?>][<?php echo $perkey;?>][own_update]"  value="1" <?php if($own_update==1){echo"checked";}?>/></td>
                                                    <td><input type="checkbox" class="chk_delete" name="data[<?php echo $user_type;?>][<?php echo $perkey;?>][own_delete]" value="1" <?php if($own_delete==1){echo"checked";}?>/></td>
                                                  </tr>
                                                  <tr>
                                                    <th scope="row" class="thfont"><?php echo lang('all_entries'); ?><input type="checkbox" class="pull-right sell_all"></th>
                                                    <td>-</td>
                                                    <td><input type="checkbox" class="chk_read" name="data[<?php echo $user_type;?>][<?php echo $perkey;?>][all_read]"  value="1" <?php if($all_read==1){echo"checked";}?>/></td>
                                                    <td><input type="checkbox" class="chk_update" name="data[<?php echo $user_type;?>][<?php echo $perkey;?>][all_update]"  value="1" <?php if($all_update==1){echo"checked";}?> /></td>
                                                    <td><input type="checkbox" class="chk_delete" name="data[<?php echo $user_type;?>][<?php echo $perkey;?>][all_delete]" value="1" <?php if($all_delete==1){echo"checked";}?>/></td>
                                                  </tr>
                                          <?php } 
                                              } else {
                                                $blanckModule1 = getRowByTableColomId('permission','admin','user_type','data');
                                                if(isset($blanckModule1) && $blanckModule1 != '') {
                                                  foreach(json_decode($blanckModule1) as $key1=>$value1) {  
                                          ?>
                                                    <tr>
                                                      <th scope="col" colspan="5" class="showRolesPermission text-center"><?php echo ucfirst(str_replace('_', ' ', $key1));?>
                                                        <?php  
                                                          //$key1 = str_replace(' ', '_SPACE_', $key1); 
                                                          $user_type = str_replace(' ', '_SPACE_', $user_type); 
                                                        ?>
                                                        <input type="hidden" name="data[<?php echo $user_type;?>][<?php echo $key1;?>]" value="<?php echo $key1;?>" />
                                                      </th>
                                                    </tr>
                                                    <tr>
                                                      <th scope="row" class="thfont"><?php echo lang('own_entries'); ?></th>
                                                      <td><input type="checkbox" class="chk_create" name="data[<?php echo $user_type;?>][<?php echo $key1;?>][own_create]" value="1"/></td>
                                                      <td><input type="checkbox" class="chk_read" name="data[<?php echo $user_type;?>][<?php echo $key1;?>][own_read]"  value="1"/></td>
                                                      <td><input type="checkbox" class="chk_update" name="data[<?php echo $user_type;?>][<?php echo $key1;?>][own_update]"  value="1"/></td>
                                                      <td><input type="checkbox" class="chk_delete" name="data[<?php echo $user_type;?>][<?php echo $key1;?>][own_delete]" value="1"/></td>
                                                    </tr>
                                                    <tr>
                                                      <th scope="row" class="thfont"><?php echo lang('all_entries'); ?></th>
                                                      <td>-</td>
                                                      <td><input type="checkbox" class="chk_read" name="data[<?php echo $user_type;?>][<?php echo $key1;?>][all_read]"  value="1"/></td>
                                                      <td><input type="checkbox" class="chk_update" name="data[<?php echo $user_type;?>][<?php echo $key1;?>][all_update]"  value="1"/></td>
                                                      <td><input type="checkbox" class="chk_delete" name="data[<?php echo $user_type;?>][<?php echo $key1;?>][all_delete]" value="1"/></td>
                                                    </tr>
                                              <?php
                                                  } 
                                                }
                                              }
                                              ?>
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>
                                    </div>
                            <?php 
                                    $i++;
                                  }
                                }
                            ?>
                                <hr>
                                <input type="submit" name="save" value="<?php echo lang('save_permission'); ?>" class="btn btn-wide btn-primary waves-effect margin-top-20" />
                        <?php } ?>
                              </form> 
                            </div>
                              <!-- /.panel -->
                            </div>
                          </div>
                        </div>
                </div>
                    </div>
                  </div>
              </div>
          </div>

  
      <!-- /.content-wrapper -->
<script>
$("#logoSite").on('change', function () {
  if (typeof (FileReader) != "undefined") {
    var image_holder = $("#logo-holder");
    image_holder.empty();
    var reader = new FileReader();
    reader.onload = function (e) {
      $("<img />", { "src": e.target.result,"class": "thumb-image logo setpropileam" }).appendTo(image_holder);
    }
    image_holder.show();
    reader.readAsDataURL($(this)[0].files[0]); } else { alert("<?php echo lang('this_browser_does_not_support_fileReader'); ?>."); }
});
$("#favicon").on('change', function () {
  if (typeof (FileReader) != "undefined") {
    var image_holder = $("#favicon-holder");
    image_holder.empty();
    var reader = new FileReader();
    reader.onload = function (e) {
      $("<img />", { "src": e.target.result, "class": "thumb-image setpropileam" }).appendTo(image_holder);
    }
    image_holder.show();
    reader.readAsDataURL($(this)[0].files[0]);} else { alert("<?php echo lang('this_browser_does_not_support_fileReader'); ?>.");  }
});
</script>
<script type="text/javascript">
$('document').ready(function(){

  $('.ad-u-type-btn').on('click', function() {
    $obj = $(this); 
    $ohtml = $obj.parents('div.row').first().clone();
    $ohtml.find('label.label-control').text('');
    $ohtml.find('button.btn').removeClass('btn-success')
    .addClass('btn-danger')
    .removeClass('ad-u-type-btn')
    .addClass('rm-u-type-btn')
    .attr('title', 'Remove')
    .find('i')
    .text('remove_circle');
    $ohtml.find('input.inp-field').val('')
    .attr('data-old-id', 'new')
    .attr('name', "new_mka[]");
    $ohtml.find('.form-line').removeClass('focused');
    $obj.parents('div.form-group').append($ohtml);
    $.AdminBSB.input.activate();
  });


  $('body').on('click', '.rm-u-type-btn', function() {
    $(this).parents('.form-group').after('<input type="hidden" name="rm_user_type[]" value="'+ $(this).parents('.row').first().find('input.inp-field').attr('data-old-id') +'">');
    $(this).parents('.row').first().remove();
  });


	$('input[type="radio"]').click(function(){
       if($(this).attr('id') == 'simple_mail') {$('#simplemail').show();$('#phpmailer').hide();}else{$('#phpmailer').show();$('#simplemail').hide();}
   });
	if('simple_mail'=='<?php echo isset($result['mail_setting'])? $result['mail_setting']:'';?>'){$('#phpmailer').hide();}else{$('#simplemail').hide();}
});
(function ($) {
    $.toggleShowPassword = function (options) {
        var settings = $.extend({ field: "#password", control: "#toggle_show_password",}, options);
        var control = $(settings.control);
        var field = $(settings.field);
        control.bind('click',function(){if(control.is(':checked')){ field.attr('type', 'text');}else{ field.attr('type', 'password');} })
    };
}(jQuery));
$.toggleShowPassword({  field: '#test1', control: '#test2'}); 
</script>
<script>   
$(document).ready(function() {
  $('#rolesAdd').prop('disabled', true);
     $('#roles').keyup(function() {
        if($(this).val() != '') {
          $('#rolesAdd').prop('disabled', false);
        }
        else{
          $('#rolesAdd').prop('disabled', true);
        }
  });
	$('#addmoreRolesShow').hide();
    $('#addmoreRoles').on('click', function(){
       $('#addmoreRolesShow').slideToggle();
    });
  $('#rolesAdd').on('click',function(event){
    var roles = $('#roles').val();
    if(roles != ''){
      var url_page = '<?php echo base_url().'setting/add_user_type'; ?>';
      event.preventDefault();
      $.ajax({
          type: "POST",
          url: url_page,
          data:{ action: 'ADDACTION',rolesName:roles},
          success: function (data) { 
        if(data=='<?php echo lang("this_user_type") ?> ('+ roles +') <?php echo lang("is_already_exist_in_this_project_please_enter_another_name"); ?>'){$("#showRolesMSG").html(data);}
        else{
          $('#addmoreRolesShow').hide();
            location.reload();
          }
        }
      });
    } else {
      $('#roles').focus();
    }
  });

  $('#templates').on('click', function() {
    $('#templates-div').html('');
    $.ajax({  
      url: '<?php echo base_url().'templates'; ?>',
      method:'post',
      data:{
        showTemplate: 'showTemplate'
      }
    }).done(function(data) {
      //console.log(data);
      $('#templates-div').html(data);
      $('#templates-div').find('table').css({
        width: '100%'
      });
    });
  });
  // Javascript to enable link to tab
  var url = document.location.toString();
  if (url.match('#')) {
      var tag = url.split('#')[1];
      if(tag == 'templates-div'){
        $('#templates').click();
      }
      $('.nav-tabs a[href="#' + tag + '"]').tab('show');
  } 

  // Change hash for page-reload
  $('.nav-tabs a').on('shown.bs.tab', function (e) {
      window.location.hash = e.target.hash;
      $(window).scrollTop(0);
  });

//window.location.hash = '#foodmka';

    $('.upd-api-key').on('click', function() {
      $o = $(this);
      $.post('<?php echo base_url(); ?>' + 'setting/get_api_key', {param1: 'value1'}, function(mka) {
        if(mka) {
          $o.parents('.row').first().find('input[name="api_key"]').val(mka).focus();
        }
      });
    });

  $('select[name="api_status"]').on('change',  function() {
    $o = $(this);
    if($o.val() == 'disabled') {
      $.post('<?php echo base_url(); ?>' + 'setting/remove_tokens', function(data, textStatus, xhr) {
        
      });
    }
  });


})
</script>
  <!-- /page content -->