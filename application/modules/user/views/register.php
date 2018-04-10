<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <title>Sign In | Tailor POS</title>
      <!-- Favicon-->
      <link rel="icon" href="<?php echo mka_base(); ?>assets/images/favicon.ico" type="image/x-icon">

      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

      <!-- Bootstrap Core Css -->
      <link href="<?php echo mka_base(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

      <!-- Waves Effect Css -->
      <link href="<?php echo mka_base(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />

      <!-- Animation Css -->
      <link href="<?php echo mka_base(); ?>assets/plugins/animate-css/animate.css" rel="stylesheet" />

      <!-- Custom Css -->
      <link href="<?php echo mka_base(); ?>assets/css/style.css" rel="stylesheet">
  </head>
  <body class="hold-transition signup-page">
    <div class="signup-box">
      <div class="logo">
        <?php $setting = settings(); ?>
        <a href="<?php echo base_url(); ?>" style="color:#5E5E5E;"><b><?= isset($setting['website'])?$setting['website']:'Custom Project'; ?></b></a>
      </div>
      <div class="card">
        <div class="body">
          <div class="msg">Register a new membership</div>
          <form action="<?php echo base_url().'user/registration'; ?>" method="post" id="register-form">
            
			        <div class="input-group">
              			<span class="input-group-addon">
                			<i class="material-icons">extension</i>
              			</span>
              			<div class="form-line">
                			<input type="email" name="email" class="form-control" required  placeholder="Email">
              			</div>
            		</div>
					
			        <div class="input-group">
              			<span class="input-group-addon">
                			<i class="material-icons">extension</i>
              			</span>
              			<div class="form-line">
                			<input type="text" name="name" class="form-control" required  placeholder="Name">
              			</div>
            		</div>
					
            
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">lock</i>
              </span>
              <div class="form-line">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" data-validation="required">
              </div>
            </div>

            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">lock</i>
              </span>
              <div class="form-line">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password" data-validation="confirmation">
              </div>
            </div>

            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">shuffle</i>
              </span>
              <div class="form-line">
                <?php $type = json_decode(setting_all('user_type')); ?>
                <select name="user_type" id="" class="form-control">
                  <option value=""><?php echo lang('select_type') ?></option>
                  <?php 
                  foreach ($type as $key => $value) {
                    if($value != 'admin') {
                      echo '<option value="'.$value.'">'.ucfirst($value).'</option>';            
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <?php get_custom_fields('user'); ?>
            
            <div class="row">
              <div class="col-xs-12">
                  <!--  <input type="hidden" name="user_type" value="<?php //echo setting_all('user_type');?>"> -->
                  <input type="hidden" name="call_from" value="reg_page">
                  <button type="submit" name="submit" class="btn btn-block btn-lg bg-grey waves-effect"><?php echo lang('register'); ?></button>
                </div>
              </div>
          </form>
          <br>
          <a href="<?php echo base_url('user/login');?>" class="text-center"><?php echo lang('i_already_have_a_membership'); ?></a>
        </div>
      </div>
      <!-- /.form-box -->
    </div>
    <!-- Jquery Core Js -->
    <script src="<?php echo mka_base(); ?>assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo mka_base(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo mka_base(); ?>assets/plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php echo mka_base(); ?>assets/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo mka_base(); ?>assets/js/admin.js"></script>
    <script src="<?php echo mka_base(); ?>assets/js/pages/examples/sign-in.js"></script>
  </body>
<script>
$(document).ready(function(){
  <?php if($this->input->get('invited') && $this->input->get('invited') != ''){ ?>
    $burl = '<?php echo base_url() ?>';
    $.ajax({
      url: $burl+'user/chekInvitation',
      method:'post',
      data:{
        code: '<?php echo $this->input->get('invited'); ?>'
      },
      dataType: 'json'
    }).done(function(data){
      console.log(data);
      if(data.result == 'success') {
        $('[name="email"]').val(data.email);
        $('form').attr('action', $burl + 'user/register_invited/' + data.users_id);
      } else{
        window.location.href= $burl + 'user/login';
      }
    });
  <?php } ?>

  $('#register-form').validate({

    rules: {
        password: {
            required: true,
        },
        password_confirmation: {
            required: true,
            equalTo: "#password"
        }
    }
  });
});
</script>
</html>
