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
    <div class="fp-box">
      <div class="logo">
        <a href="<?php echo mka_base(); ?>"><b>User Login and Management</b></a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="body">
          <p class="login-box-msg">Please enter your or email address. You will receive a link to create a new password via email.</p>
          <?php if($this->session->flashdata('forgotpassword')):?>
            <div class="callout callout-success">
              <h5 style='color:red;' class="fa fa-close">  <?php echo $this->session->flashdata('forgotpassword'); ?></h5>
            </div>
          <?php endif ?>
          <form action="<?php echo base_url().'user/forgetpassword'?>" method="post">
            
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">email</i>
              </span>
              <div class="form-line">
                <input type="email" name="email" class="form-control" placeholder="Email" data-validation="email" />
              </div>
            </div>

            <div class="row">
              <!-- /.col -->
              <div class="col-xs-12">
                <button type="submit" class="btn btn-block btn-lg bg-grey waves-effect">Get New Password</button>
              </div>
              <div class="text-center">
                <span class="glyph-icon-back glyphicon glyphicon-circle-arrow-left" style="cursor:pointer" onclick="window.history.back()" title="Back"></span>
              </div>
              <!-- /.col -->
            </div>
          </form>
          <div class="social-auth-links text-center">
          </div>
          <!-- /.social-auth-links -->
        </div>
      </div>
      <!-- /.login-box-body -->
    </div>
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
