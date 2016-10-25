<?php
require_once("inc/config.inc.php");
require_once("inc/database.inc.php");

//$db = new Database();
//$fulltable = _DB_PREFIX . 'settings';
//$settingscon = array('_id' => '1');
//$settingdata = $db->find($fulltable, $settingscon);
//print_r($collection);
$site_name = _SITE_NAME;
$css_style = _CSS_STYLE;
$header_text = _PANEL_NAME;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $site_name; ?>  | Dashboard</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="plugins/morris/morris.css">
        <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
        <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

        <script type="text/javascript">
            var currentUrl = '<?php echo $_SERVER['PHP_SELF']; ?>';
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini fixed">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <span class="logo-lg"><b>amtwebsolution</b>.com</span>
                </a>

                <nav class="navbar navbar-static-top">

                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo $_SESSION['profile_pic']; ?>" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $_SESSION['adm_username']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo $_SESSION['profile_pic']; ?>" class="img-circle" alt="User Image">

                                        <p>
                                            <?php echo $_SESSION['adm_username']; ?> - <?php echo $_SESSION['adm_role']; ?>

                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">

                                            </div>
                                            <div class="col-xs-4 text-center">

                                            </div>
                                            <div class="col-xs-4 text-center">

                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </nav>
            </header>





























            <html>
                <head>
                    <title><?php echo $site_name; ?> :: Admin Panel</title>
                    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
                    <link href="css/style_<?php echo $css_style; ?>.css" type="text/css" rel="stylesheet">
                </head>

                <body class="header">
                    <!-- HEADER -->
                    <table class="tborder" cellspacing="0" cellpadding="5" width="100%" align="center" border="0">
                        <tbody>
                            <tr>
                                <td class="tcat" valign="top" height="70px">                
                                    <h2><?php echo $header_text; ?></h2>
                                    for <?php echo $site_name; ?>
                                </td>

                            </tr>
                    </table>
                </body>
            </html>

