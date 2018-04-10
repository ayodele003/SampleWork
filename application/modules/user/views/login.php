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
	    <style>
	    	.logo b {
			    color: #555;
			}
	    </style>
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
	        <div class="logo">
	        	<?php $setting = settings(); ?>
	            <a href="<?php echo base_url(); ?>"><b><?= isset($setting['website'])?$setting['website']:'Custom Project'; ?></b></a>
	        </div>
	        <div class="card">
	            <div class="body">
	                <form action="<?php echo base_url().'user/auth_user'; ?>" method="post" id="login-form">
	                    <div class="msg"><?php echo lang('sign_in_to_start_your_session'); ?></div>
	                    <div class="input-group">
	                        <span class="input-group-addon">
	                            <i class="material-icons">person</i>
	                        </span>
	                        <div class="form-line">
	                        	<input type="text" name="email" class="form-control" id="" placeholder="<?php echo lang('email'); ?>" required autofocus>
	                        </div>
	                    </div>
	                    <div class="input-group">
	                        <span class="input-group-addon">
	                            <i class="material-icons">lock</i>
	                        </span>
	                        <div class="form-line">
	                            <input type="password" name="password" class="form-control" id="pwd" placeholder="<?php echo lang('password'); ?>" required>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-xs-8 p-t-5">
	                            <!-- <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
	                            <label for="rememberme">Remember Me</label> -->
	                        </div>
	                        <div class="col-xs-4">
	                            <button class="btn btn-block bg-grey waves-effect" type="submit"><?php echo lang('SIGN_IN'); ?></button>
	                        </div>
	                    </div>
	                    <div class="row m-t-15 m-b--20">
	                    	<?php if(setting_all('register_allowed')==1){ ?>
		                        <div class="col-xs-6">
		                            <a href="<?php echo base_url().'user/registration'; ?>"><?php echo lang('register_now') ?>!</a>
		                        </div>
	                        <?php } ?>
	                        <div class="col-xs-6 align-right">
	                            <a href="<?php echo base_url().'user/forgetpassword' ?>"><?php echo lang('forgot_password') ?>?</a>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
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
	    <script src="<?php echo mka_base(); ?>assets/js/custom.js"></script>
	    <script src="<?php echo mka_base() ?>assets/plugins/bootstrap-notify/bootstrap-notify.js"></script>
	</body>

	<script>
        $(document).ready(function() {
            /**
             * $type may be success, danger, warning, info 
             */
            <?php 
            if(isset($this->session->get_userdata()['alert_msg'])) {
            ?>
                $msg = '<?php echo $this->session->get_userdata()['alert_msg']['msg']; ?>';
                $type = '<?php echo $this->session->get_userdata()['alert_msg']['type']; ?>';
                showNotification($msg, $type);
            <?php 
            $this->session->unset_userdata('alert_msg');
            } 
            ?>

            $('#login-form').validate();
        });

    </script>

</html>

