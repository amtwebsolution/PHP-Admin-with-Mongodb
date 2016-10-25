<?php
session_start();
require_once("inc/checkAdminPagePermissions.php");
require_once("inc/config.inc.php");
require_once("inc/database.inc.php");
require_once("inc/functions.inc.php");
require_once("inc/settings.inc.php");

$db = new Database();
$message = '';
$id = isset($_GET['id']) && !empty($_GET['id']) ? (int) $_GET['id'] : '';
/* fetch data */
$cond = array('_id' => $id);
$editdata = $db->find($customerTable, $cond);
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
        $count = $db->numRows($customerTable, $cond);
        if ($count > 0) {
            $error[] = 'Username is already exists.';
        }
    }
    if (empty($email)) {
        $error[] = 'Please enter email.';
    } else {
        $cond = array('$and' => array(array('email' => $email), array('_id' => array('$ne' => $id))));
        $count = $db->numRows($customerTable, $cond);
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
    if (empty($phone)) {
        $error[] = 'Please enter phone.';
    }
    if (empty($address)) {
        $error[] = 'Please enter Address.';
    }
    if (empty($city)) {
        $error[] = 'Please enter city.';
    }
    if (empty($state)) {
        $error[] = 'Please enter state.';
    }
    if (empty($state)) {
        $error[] = 'Please enter pin.';
    }
    if (empty($country)) {
        $error[] = 'Please enter country.';
    }

    if (empty($error)) {

        $data = array('updated' => time());
        unset($_POST['username']);
        foreach ($_POST as $key => $dat) {
            if($key == 'password'){
                if (!empty($dat)) $data[$key] = md5($dat);
            }else{
              $data[$key] = stripQuotes(removeBadChars($dat));  
            }
            
            
        }
        $collection = $db->update($customerTable, $id, $data);
        $_SESSION['adm_message'] = 'User has been updated successfully.';
        $_SESSION['type'] = 'success';
        header("Location: all-users.php");
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
            Edit User 

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User</li>
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

                        <form role="form" name="frm" id="frm" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="username" value="<?php echo $username;?>" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="email" value="<?php echo $email;?>">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="password">
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="first_name" value="<?php echo $first_name;?>">
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="last_name" value="<?php echo $last_name;?>">
                            </div>
                            <!--div class="form-group">
                                <label>DOB</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="dob">
                            </div-->
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option <?php echo $gender == 'male'?'selected="selected"':'';?> value="male">Male</option>
                                    <option <?php echo $gender == 'female'?'selected="selected"':'';?> value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="phone" value="<?php echo $phone;?>">
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" placeholder="Enter ..." name="address"><?php echo $address;?></textarea>
                            </div>

                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="city" value="<?php echo $city;?>">
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="state" value="<?php echo $state;?>">
                            </div>
                            <div class="form-group">
                                <label>Pin</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="pin" value="<?php echo $pin;?>"> 
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="country" value="<?php echo $country;?>">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" <?php echo $status == '1'?'selected="selected"':'';?>>Active</option>
                                    <option value="0" <?php echo $status == '0'?'selected="selected"':'';?>>Deactive</option>
                                </select>
                            </div>
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