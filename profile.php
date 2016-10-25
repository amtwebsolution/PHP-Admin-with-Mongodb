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
    if (empty($username)) {
        $error[] = 'Please enter username.';
    } else {
        $cond = array('$and' => array(array('username' => $username), array('_id' => array('$ne' => $id))));
        $count = $db->numRows($adminTable, $cond);
        if ($count > 0) {
            $error[] = 'Username is already exists.';
        }
    }
    if (empty($email)) {
        $error[] = 'Please enter email.';
    } else {
        $cond = array('$and' => array(array('email' => $email), array('_id' => array('$ne' => $id))));
        $count = $db->numRows($adminTable, $cond);
        if ($count > 0) {
            $error[] = 'Email is already exists.';
        }
    }

    if (empty($first_name)) {
        $error[] = 'Please enter first name.';
    }

    if (empty($last_name)) {
        $error[] = 'Please enter last name.';
    }
    if (!empty($_FILES['profile_pic']['name'])) {
        $ext = pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION);
        if (!in_array($ext, $imageExtension)) {
            $error[] = 'Image not valid. Please upload jpg or png image.';
        }
    }


    if (empty($error)) {

        if (!empty($_FILES['profile_pic']['name'])) {
            $type = $_FILES["profile_pic"]["type"];
            $source = $_FILES["profile_pic"]["tmp_name"];
            $file = UPLOAD_DIR_PROFILE . $id . '_' . strtolower($_FILES["profile_pic"]["name"]);
            move_uploaded_file($source, $file);
            @unlink($profile_pic);
        } else {
            $file = $profile_pic;
        }

        $data = array('profile_pic' => $file, 'updated' => time());
        unset($_POST['username']);
        foreach ($_POST as $key => $dat) {
            $data[$key] = stripQuotes(removeBadChars($dat));
        }
        $collection = $db->update($adminTable, $id, $data);
        $_SESSION['adm_message'] = 'Profile has been updated successfully.';
        $_SESSION['type'] = 'success';
        header("Location: profile.php");
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
            My Profile

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">  
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">User</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-danger"><?php echo $message; ?></div>
                        <?php } ?>
                        <h3 class="box-title"><?php
                          messages('adm_message');
                        ?></h3>
                        <form role="form" name="frm" id="frm" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="username" value="<?php echo $username; ?>" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="email" value="<?php echo $email; ?>">
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="first_name" value="<?php echo $first_name; ?>">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="last_name" value="<?php echo $last_name; ?>">
                            </div>
                            <div class="form-group">
                                <label>Profile Pic</label>
                                <input type="file" class="form-control" name="profile_pic">
                            </div>
<?php if (isset($profile_pic) && !empty($profile_pic)) { ?><div class="form-group"><img src="<?php echo $profile_pic; ?>" width="100" height="75"></div><?php } ?>

                            <div class="box-footer">
                                <!--<button type="submit" class="btn btn-default">Cancel</button>-->
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