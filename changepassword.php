<?php
session_start();
require_once("inc/checkAdminPagePermissions.php");
require_once("inc/config.inc.php");
require_once("inc/database.inc.php");
require_once("inc/functions.inc.php");
require_once("inc/settings.inc.php");

$db = new Database();
$message = '';
$id = $_SESSION['adm_user_id'];
/* fetch data */
$cond = array('_id' => $id);
$editdata = $db->find($adminTable, $cond);
if (!empty($editdata)) {
    foreach ($editdata as $row) {
        extract($row);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submit'] == 'save') {
    extract($_POST);
    $error = '';
    
    if (empty($oldpassword)) {
        $error[] = 'Please enter old password.';
    }else{
       
        if (PASSWORD_ENCRYPTION_TYPE == 'AES') {
            $oldpassword = AES_ENCRYPT($oldpassword, PASSWORD_ENCRYPTION_KEY);
        } else {
            $oldpassword = MD5($oldpassword);
        }
    
       if($oldpassword != $password){
           $error[] = 'Old password is not match.';
       } 
    }

    if (empty($newpassword)) {
        $error[] = 'Please enter New password.';
    }
    if (empty($repassword)) {
        $error[] = 'Please enter last name.';
    }
    
    if($newpassword != $repassword){
        $error[] = 'New password and Retype Password are not match.';
    }


    if (empty($error)) {

        if (PASSWORD_ENCRYPTION_TYPE == 'AES') {
            $dat = AES_ENCRYPT($newpassword, PASSWORD_ENCRYPTION_KEY);
        } else {
            $dat = MD5($newpassword);
        }
        $data['password'] = $dat;
       
        $collection = $db->update($adminTable, $id, $data);
        $_SESSION['adm_message'] = 'Password has been updated successfully.';
        $_SESSION['type'] = 'success';
        header("Location: changepassword.php");
        exit;
    } else {

        $message = implode('<br/>', $error);
    }
}
include('include/header.php');
include('include/left_menu.php');
?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Change Password

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Change Password</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">  
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Password</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-danger"><?php echo $message; ?></div>
                        <?php } ?>
                        <h3 class="box-title"><?php
                          messages('adm_message');
                        ?></h3>
                        <form role="form" name="frm" id="frm" method="post" >
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" class="form-control" placeholder="Enter ..." name="oldpassword">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" placeholder="Enter ..." name="newpassword">
                            </div>
                            <div class="form-group">
                                <label>Retype Password</label>
                                <input type="password" class="form-control" placeholder="Enter ..." name="repassword">
                            </div>
                            
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right" name="submit" value="save">Save</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>   
        </div>

    </section>

</div>
<?php include('include/footer.php'); ?>