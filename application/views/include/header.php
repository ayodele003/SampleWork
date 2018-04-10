<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php $setting = setting_all();?>
    <title><?php echo (setting_all('website'))?setting_all('website'):'Dasboard';?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo setting_all('favicon')?mka_base().'assets/images/'.setting_all('favicon'):'assets/images/favicon.ico';?>" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo mka_base(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo mka_base(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="<?php echo mka_base(); ?>assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Dropzone Css -->
    <link href="<?php echo mka_base(); ?>assets/plugins/dropzone/dropzone.css" rel="stylesheet">

    <!-- Animation Css -->
    <link href="<?php echo mka_base(); ?>assets/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo mka_base(); ?>assets/css/style.css" rel="stylesheet">

    <!-- Bootstrap Select Css -->
    <link href="<?php echo mka_base(); ?>assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <!-- Bootstrap Material Datetime Picker Css -->
    <link rel="stylesheet" type="text/css" href="<?php echo mka_base().'assets/css/daterangepicker.css'; ?>" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo mka_base(); ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <link href="<?php echo mka_base(); ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
    

    <!-- Sweet Alert Css -->
    <link href="<?php echo mka_base(); ?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo mka_base(); ?>assets/css/jquery-ui.css">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo mka_base(); ?>assets/css/themes/all-themes.css" rel="stylesheet" />
    <link href="<?php echo mka_base(); ?>assets/css/custom.css" rel="stylesheet" />

    <script src="<?php echo mka_base(); ?>assets/js/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo mka_base(); ?>assets/js/jquery-ui.min.js"></script>
    <script src='<?php echo mka_base(); ?>assets/js/moment.min.js'></script>

<style> ?>
.lagAm .btn-group.bootstrap-select {margin-top: 8%;}
#rightsidebar .slimScrollDiv{height: 540px !important;}
#rightsidebar .slimScrollDiv ul{height: 540px !important;}
.sidebar .menu .list a{width: 83% !important;}
.sidebar .menu .list a.right0{width: 13% !important; right: 0;}
</style>
</head>
<?php 
    $this->load->helper('cookie');
    $cookie= get_cookie('theme_color');
    if((!isset($cookie)) || (isset($cookie) && empty($cookie))){ $cookie = 'theme-blue'; } 
?>
<body class="<?php echo $cookie; ?>" data-base-url="<?php echo base_url(); ?>">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p><?php echo lang('please_wait'); ?>...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons"><?php echo lang("search");?></i>
        </div>
        <input type="text" placeholder="<?php echo lang("StartTyping");?>">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <?php $logo = (setting_all('logo'))?setting_all('logo'):'logo.png'; ?>
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><span class="logo-lg"><img src="<?php echo mka_base().'assets/images/'.$logo; ?>" id="logo"></span></a>
                <!-- <?php //$logo_text = (setting_all('website'))?setting_all('website'):'Website Logo'; ?>
                <a class="navbar-brand" href="<?php //base_url(); ?>"><?php //echo $logo_text; ?></a> -->
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <!-- <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li> -->
                    <li class="lagAm">
                    <select style="margin: 20px 0 0 0;" onchange="javascript:window.location.href='<?php echo base_url(); ?>setting/switchLang/'+this.value;">
                        <option value="english" <?php if(setting_all('language') == 'english') echo 'selected="selected"'; ?>>English</option>
                    </select>
                    </li>
                    <!-- #END# Call Search -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo mka_base(); ?>assets/images/<?php echo isset($this->session->get_userdata()['user_details'][0]->profile_pic)?$this->session->get_userdata()['user_details'][0]->profile_pic:'user.png' ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo isset($this->session->get_userdata()['user_details'][0]->name)?$this->session->get_userdata()['user_details'][0]->name:'John Doe' ?></div>
                    <div class="email"><?php echo isset($this->session->get_userdata()['user_details'][0]->email)?$this->session->get_userdata()['user_details'][0]->email:'john.doe@example.com' ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo base_url('user/profile');?>"><i class="material-icons">person</i><?php echo lang("Profile");?></a></li>                            
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?php echo base_url('user/logout');?>"><i class="material-icons">input</i><?php echo lang("Signout");?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->

            <div class="menu">
                <ul class="list">
                    
			<li class="<?=($this->router->method==="dashboard")?"active":"not-active"?>">
				<a href="<?php echo base_url('user/dashboard');?>"> <i class="material-icons">dashboard</i> <span><?php echo lang("dashboard");?></span></a>
			</li>
		

                    <li class="<?=($this->router->method==="profile")?"active":"not-active"?>"> 
                        <a href="<?php echo base_url('user/profile');?>"> 
                        <i class="material-icons">person</i>   
                        <span><?php echo lang("my_account");?></span></a>
                    </li>

                    <?php echo custom_menus(); ?>

                    <?php $this->load->view("include/menu");?> 
                    
                    <?php if(CheckPermission("user", "own_read") || CheckPermission("user", "all_read")){ ?>
                    <li class="<?=($this->router->method==="userTable")?"active":"not-active"?>"> 
                        <a href="<?php echo base_url();?>user/userTable" class="EditCrud" data-crud_id="23010"> 
                        <i class="material-icons">supervisor_account</i>
                        <span><?php echo lang('users') ?></span></a>
                    </li>    
                    <?php }  if(isset($this->session->userdata('user_details')[0]->user_type) && $this->session->userdata('user_details')[0]->user_type == 'admin'){ ?>    
                    <li class="<?=($this->router->class==="setting")?"active":"not-active"?>">
                        <a href="<?php echo base_url("setting"); ?>"><i class="material-icons">settings_applications</i> <span><?php echo lang('settings'); ?></span></a>
                    </li>

                    <li class="<?=($this->router->class==="extension")?"active":"not-active"?>">
                        <a href="<?php echo base_url("extension"); ?>"><i class="material-icons">extension</i> <span><?php echo lang('extension'); ?></span></a>
                    </li>
         
                   
                  <?php } ?>

                  <!-- Invoice Menue -->

                  <li class="<?=($this->router->class==="about")?"active":"not-active"?>">
                        <a href="<?php echo base_url("about"); ?>"><i class="material-icons">info</i> <span><?php echo lang('about_us'); ?></span></a>
                    </li>

                    
                </ul>
            </div>
            <!-- #Menu -->            
        </aside>
        <!-- #END# Left Sidebar -->
        
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="blue" class="<?php if(isset($cookie) && $cookie == 'theme-blue'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="red" class="<?php if(isset($cookie) && $cookie == 'theme-red'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink" class="<?php if(isset($cookie) && $cookie == 'theme-pink'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple" class="<?php if(isset($cookie) && $cookie == 'theme-purple'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple" class="<?php if(isset($cookie) && $cookie == 'theme-deep-purple'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo" class="<?php if(isset($cookie) && $cookie == 'theme-indigo'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="light-blue" class="<?php if(isset($cookie) && $cookie == 'theme-light-blue'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan" class="<?php if(isset($cookie) && $cookie == 'theme-cyan'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal" class="<?php if(isset($cookie) && $cookie == 'theme-teal'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green" class="<?php if(isset($cookie) && $cookie == 'theme-green'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green" class="<?php if(isset($cookie) && $cookie == 'theme-light-green'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime" class="<?php if(isset($cookie) && $cookie == 'theme-lime'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow" class="<?php if(isset($cookie) && $cookie == 'theme-yellow'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber" class="<?php if(isset($cookie) && $cookie == 'theme-amber'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange" class="<?php if(isset($cookie) && $cookie == 'theme-orange'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange" class="<?php if(isset($cookie) && $cookie == 'theme-deep-orange'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown" class="<?php if(isset($cookie) && $cookie == 'theme-brown'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey" class="<?php if(isset($cookie) && $cookie == 'theme-grey'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey" class="<?php if(isset($cookie) && $cookie == 'theme-blue-grey'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black" class="<?php if(isset($cookie) && $cookie == 'theme-black'){ echo 'active'; }else{ echo ''; } ?>">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <script type="text/javascript">
        /*$('body').on('click', function(){
            parent.editCrud();
            parent.editDeshboard();
        });*/
    </script>