<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $pageTitle . ' | ' . $_SESSION['siteConfigs']->get('generalSiteTitle'); ?></title>

        <!-- Favicons -->
<link rel="shortcut icon" href="<?php echo base_url('assets/img/favico.png'); ?>" type="image/x-icon">
            <!--     <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>" type="image/x-icon"> -->

        <!-- Plugins CSS -->
        <link href="<?php echo base_url('assets/plugins/animate.css/animate.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/sweetalert/dist/sweetalert.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/material-design-iconic-font/dist/css/material-design-iconic-font.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet">
        <?php echo $pluginCss; ?>

        <!-- CSS -->
        <link href="<?php echo base_url('assets/components/css/app.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
        <?php echo $pageCss; ?>
        
        <script>var base_url = '<?php echo base_url(); ?>';</script>
        <script>var userId = '<?php echo $this->currentUser->getObjectId(); ?>';</script>
        <script>var username = '<?php echo $this->currentUser->get('username'); ?>';</script>
        <script>var firstName = '<?php echo $this->currentUser->get('firstName'); ?>';</script>
        <script>var userAvatar = '<?php echo fetch_user_avatar($this->currentUser); ?>';</script>
        <script>var userLevel = '<?php echo $this->currentUser->get('roleName'); ?>';</script>

        <?php $this->load->view('layout/noscript'); ?>
    </head>
    <body>
        <header id="header" class="clearfix default-primary-color">
            <ul class="h-inner">
                <li class="hi-trigger ma-trigger" data-ma-action="sidebar-open" data-ma-target="#sidebar">
                    <div class="line-wrap">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>

                <li style="margin-top: -13px;">
                    <a href="<?php echo base_url('dashboard'); ?>" class="header-logo">
                        <!-- <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Loqasi logo"> line-chart  -->
           <!--              <h3 class="c-white">LORIEN ANALYTICS LOGO</h3> -->

            <img src="<?php echo base_url('assets/img/logo75x66.png'); ?>" alt="Loqasi logo">
                    </a>
                </li>

                <li class="pull-right">
                    <ul class="hi-menu">
                        <!--<li>
                            <a href="" ><i class="him-icon zmdi zmdi-help"></i></a>
                        </li>
                        <li class="dropdown">
                            <a data-toggle="dropdown" href="">
                                <i class="him-icon zmdi zmdi-notifications"></i>
                                <i class="him-counts" style="display: none;">9</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg pull-right">
                                <div class="list-group him-notification">
                                    <div class="lg-header">
                                        Notification
                                        <ul class="actions">
                                            <li class="dropdown">
                                                <a href="" data-ma-action="clear-notification">
                                                    <i class="zmdi zmdi-check-all"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="lg-body" id="notification-content">
                                    </div>

                                    <a class="view-more" href="<?php echo base_url('notifications'); ?>">View All</a>
                                </div>
                            </div>
                        </li>-->
                        <li>
                            <a href="javascript:void(0);" data-ma-action="fullscreen"><i class="him-icon zmdi zmdi-fullscreen"></i></a>
                        </li>
                        <li>
                            <a href="Javascript:void(0);" id="logout"><i class="him-icon zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Top Search Content -->
            <div class="h-search-wrap">
                <div class="hsw-inner">
                    <i class="hsw-close zmdi zmdi-arrow-left" data-ma-action="search-close"></i>
                    <input type="text">
                </div>
            </div>
        </header>

        <section id="main">
    
            <?php $this->load->view('layout/sidebar'); ?>

            <section id="content">

                <div class="container">
                    
                    <?php echo $content; ?>

                </div>
                
            </section>

        </section>

        <footer id="footer">
            <ul class="f-menu">
                <li>&copy; Copyright <?php echo date('Y'); ?> <?php echo $_SESSION['siteConfigs']->get('generalSiteTitle'); ?></li>
            </ul>
            <ul class="f-menu">
                <li>Site designed and developed by <a href="http://xenero.com.au">Xenero | Sydney Web & App Design</a></li>
            </ul>
        </footer>

        <!-- Page Loader -->
        <!-- <div class="page-loader">
            <div class="preloader pls-blue">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>
                <p>Please wait...</p>
            </div>
        </div> -->
        
        <!-- Javascript Libraries -->
        <script src="<?php echo base_url('assets/plugins/jquery/dist/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/bootstrap/dist/js/bootstrap.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/sparklines/source/jquery.sparkline.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/sweetalert/dist/sweetalert.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/Waves/dist/waves.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/blockUI/jquery.blockUI.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/jquery-validation/js/jquery.validate.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/ion-sound/ion.sound.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/js-cookie/js.cookie.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/helper.js'); ?>"></script>
        <?php echo $pluginJs; ?>

        <!-- Component JS -->
        <script src="<?php echo base_url('assets/components/js/app.js'); ?>"></script>
        <?php echo $pageJs; ?>
        <?php $this->load->view('analytics'); ?>
    </body>
  </html>