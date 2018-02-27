<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->config->item('app_name'); ?></title>

        <!-- Plugins CSS -->
        <link href="<?php echo base_url('assets/plugins/animate.css/animate.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/material-design-iconic-font/dist/css/material-design-iconic-font.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/sweetalert/dist/sweetalert.css'); ?>" rel="stylesheet">

        <!-- CSS -->
        <link href="<?php echo base_url('assets/components/css/app.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
        <style>
            body {
                background-color: #2196F3;
            }
        </style>
        <script>var base_url = '<?php echo base_url(); ?>';</script>
    </head>

    <body>

        <div class="login-page">
            
            <div class="logo">
                <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Loqasi Logo">
            </div>

            <!-- Login -->
            <div class="lc-block toggled" id="l-login">
                <?php if($activation): ?>
                <div class="lcb-form">
                    <p>Sekarang kamu sudah bisa login :)</p>
                    <a href="<?php echo base_url('login'); ?>" class="btn bgm-amber btn-icon waves-effect waves-circle waves-float"><i class="zmdi zmdi-check"></i></a>
                </div>
                <?php else: ?>
                <div class="lcb-form">
                    <p>Maaf, Kode aktivasi sudah expired :(</p>
                    <a href="<?php echo base_url('login'); ?>" class="btn bgm-amber btn-icon waves-effect waves-circle waves-float"><i class="zmdi zmdi-check"></i></a>
                </div>
                <?php endif; ?>
            </div>
            
        </div>

        <!-- Javascript Libraries -->
        <script src="<?php echo base_url('assets/plugins/jquery/dist/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/Waves/dist/waves.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-validation/js/jquery.validate.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/sweetalert/dist/sweetalert.min.js'); ?>"></script>

        <!-- Component JS -->
        <script src="<?php echo base_url('assets/components/js/app.js'); ?>"></script>

        <!-- Page JS -->
        <script src="<?php echo base_url('assets/js/loqasi.js'); ?>"></script>
    
    </body>
</html>
