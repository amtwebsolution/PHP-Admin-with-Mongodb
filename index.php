<?php
session_start();
foreach ($_GET as $get_key => $get_value) {
    if (is_string($get_value) && ((preg_match("/\//", $get_value)) || (preg_match("/\[\\\]/", $get_value)) || (preg_match("/:/", $get_value)) || (preg_match("/%00/", $get_value)))) {
        if (isset($_GET[$get_key]))
            unset($_GET[$get_key]);
        die("A hacking attempt has been detected. For security reasons, we're blocking any code execution.");
    }
}
require_once("inc/config.inc.php");
require_once("inc/settings.inc.php");
require_once("inc/functions.inc.php");
$log = (isset($_REQUEST['log'])) ? "out" : "";
$msg = (isset($_REQUEST['msg'])) ? $_REQUEST['msg'] : "";
$adm_logged = (isset($_SESSION['adm_logged'])) ? $_SESSION['adm_logged'] : false;
if ($adm_logged == true) {
    header("Location: dashboard.php");
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo _SITE_NAME;?> | Log in</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="index.php"><b><?php echo _SITE_ADDRESS;?></b></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>
                  <div class="box-header"> 
                       <?php messages('adm_message'); ?>
                   </div>
                <form action="check_login.php" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="User Name" name="rt_admin_username">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="rt_admin_password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <!--  <div class="checkbox icheck">
                                <label>
                                  <input type="checkbox"> Remember Me</label>
                              </div>-->
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" >Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- <div class="social-auth-links text-center">
                   <p>- OR -</p>
                   <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                     Facebook</a>
                   <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                     Google+</a>
                 </div> -->
                <!-- /.social-auth-links -->

                <!-- <a href="#">I forgot my password</a><br>
                 <a href="register.html" class="text-center">Register a new membership</a>  -->

            </div>

        </div>

        <script src="plugins/jQuery/jQuery-2.2.0.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
