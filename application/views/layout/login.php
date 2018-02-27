<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo GENERAL_SITE_TITLE; ?></title>
        
        <!-- Favicons -->
        <!-- <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>" type="image/x-icon"> -->
        
        <!-- Plugins CSS -->
        <link href="<?php echo base_url('assets/plugins/animate.css/animate.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/material-design-iconic-font/dist/css/material-design-iconic-font.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/sweetalert/dist/sweetalert.css'); ?>" rel="stylesheet">

        <!-- CSS -->
        <link href="<?php echo base_url('assets/components/css/app.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
        <style>
            body {
                display: table;
                margin: 0;
            }

            .btn-login {
                margin-top: -30px !important;
            }
        </style>
        <script>var base_url = '<?php echo base_url(); ?>';</script>
        <script>var redirect_url = '<?php //echo $this->agent->referrer(); ?>';</script>
        
    </head>

    <body class="default-primary-color">
        <?php $this->load->view('layout/noscript'); ?>

        <div class="login-page">
            
            <div class="logo m-b-20">
                <!-- <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Loqasi Logo"> -->
                <h1 class="c-white">LORIEN ANALYTICS LOGO</h1>
            </div>

            <!-- Login -->
            <div class="lc-block toggled" id="l-login">
                <?php echo form_open('', 'id="login-form"'); ?>
                    <div class="lcb-form">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                                <div class="fg-line">
                                    <input type="text" class="form-control" placeholder="Username" name="identity">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                                <div class="fg-line">
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>
                            </div>
                        </div>

                        <div class="checkbox m-t-20">
                            <label>
                                <input type="checkbox" value="1" name="remember">
                                <i class="input-helper"></i>
                                Remember me
                            </label>
                        </div>

                        <button type="submit" class="btn btn-login bgm-amber btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>
                    </div>

                    <!--<div class="lcb-navigation">
                        <a href="javascript:void(0);" data-ma-action="login-switch" data-ma-block="#l-forget-password"><i>?</i> <span>Forgot Password</span></a>
                    </div>-->
                <?php echo form_close(); ?>
            </div>

            <!-- Forgot Password -->
            <div class="lc-block" id="l-forget-password">
                <?php echo form_open('', 'id="forgot-form"'); ?>
                    <div class="lcb-form">
                        <p class="text-left">Silahkan masukkan username atau email kamu.</p>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                                <div class="fg-line">
                                    <input type="text" class="form-control" placeholder="Username atau email" name="identity">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-forgot bgm-amber btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>
                    </div>

                    <div class="lcb-navigation">
                        <a href="javascript:void(0);" data-ma-action="login-switch" data-ma-block="#l-login"><i class="zmdi zmdi-long-arrow-right"></i> <span>Sign in</span></a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>

        <!-- Javascript Libraries -->
        <script src="<?php echo base_url('assets/plugins/jquery/dist/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/Waves/dist/waves.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-validation/js/jquery.validate.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/sweetalert/dist/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/ion-sound/ion.sound.min.js'); ?>"></script>

        <!-- Component JS -->
        <script src="<?php echo base_url('assets/components/js/app.js'); ?>"></script>

        <!-- Page JS -->
        <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/auth.js'); ?>"></script>
        <script>
            $(document).ready(function() {
                Login.init();
                Register.init();
                Forgot.init();
            });
        </script>
        <?php $this->load->view('analytics'); ?>
    </body>
</html>
