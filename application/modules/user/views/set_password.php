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
  <body class="hold-transition fp-page">
  <?php 
    if($email=='allredyUsed'){ ?>
      <div class="container text-center">
        <h2><?php echo lang('you_have_already_reset_your_password'); ?>..</h2>
         <p><?php echo lang('please_login'); ?> <a href="<?php echo base_url().'user/login'; ?>"><?php echo lang('here'); ?></a> </p>
      </div>
    <?php } else{  ?>
    <div class="fp-box">
      <div class="logo" style="color: #eee">
        <h2 class="text-center"><strong><?php echo lang('set_new_password'); ?></strong>
          <div class="line1 green-bg"></div>
        </h2>
      </div>
      <div class="card">
        <div class="body">
          <div class="inner_container loginpage login-box login-box-body">
            <section>
              <form class="createaccount" action="<?php echo base_url().'user/reset_password'?>" method="post">
                <input type="hidden" name="email" value="<?php echo $email; ?>" class="form-control"  />
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="material-icons">lock</i>
                  </span>
                  <div class="form-line">
                    <input type="password" id="password1" name="password_confirmation" class="form-control" placeholder="<?php echo lang('NewPassword'); ?>..." data-validation="required" />
                  </div>
                </div>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="material-icons">lock</i>
                  </span>
                  <div class="form-line">
                    <input type="password" id="password2" name="password" class="form-control" placeholder="<?php echo lang('ConfirmPassword') ?>" data-validation="confirmation" />
                  </div>
                </div>
                <div>
                  <button type="submit" name="sub" value="Set password" class="btn btn-primary green-btn submit"><?php echo lang('set_password'); ?></button>
                  <!--<a class="btn btn-default submit" >Log in</a>-->         
                </div>
              </form>
              <!-- form -->
            </section>
          <!-- content -->
          </div>
        </div>
      </div>
    </div>
      <?php } ?>
  <script type="text/javascript">
      window.onload = function () {
      document.getElementById("password1").onchange = validatePassword;
      document.getElementById("password2").onchange = validatePassword;
      }
      function validatePassword(){
        var pass2=document.getElementById("password2").value;
        var pass1=document.getElementById("password1").value;
        if(pass1!=pass2)
        {
          document.getElementById("password2").setCustomValidity("<?php echo lang('passwords_dont_match'); ?>");
        }
        else{
             document.getElementById("password2").setCustomValidity('');
        }
      }
    </script>
 <!-- /.login-box -->
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
</html>
