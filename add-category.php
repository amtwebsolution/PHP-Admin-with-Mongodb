
<?php
session_start();
require_once("inc/checkAdminPagePermissions.php");
require_once("inc/config.inc.php");
require_once("inc/database.inc.php");
require_once("inc/settings.inc.php");
require_once("inc/functions.inc.php");

$db = new Database();
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submit'] == 'save') {
    extract($_POST);
    $error = '';
    if (empty($name)) {
        $error[] = 'Please enter category.';
    } else {
        $catCond = array('$and' => array(array('name' => $name), array('pcat_id' => '0')));
        $count = $db->numRows($caTable, $catCond);
        if ($count > 0) {
            $error[] = 'Category already exists.';
        }
    }
    if (!empty($_FILES['image']['name'])) {
         
      $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
      if(!in_array($ext, $imageExtension)){
          $error[] = 'Banner not valid. Please upload jpg or png banner.';
      }
      
    }
    if (empty($error)) {
        $id = $db->getNextSequence('cat_id'); //create new id
        $banner = '';

        if (!empty($_FILES['image']['name'])) {
            $type = $_FILES["image"]["type"];
            $source = $_FILES["image"]["tmp_name"];
            $file = UPLOAD_DIR_CATEGORY . time() . '_' . strtolower($_FILES["image"]["name"]);
            move_uploaded_file($source, $file);
        }


        $data = array('_id' => $id, 'id' => $id, 'image' => $file, 'pcat_id'=> (INT)$pcat_id,'created' => time());
        unset($_POST['pcat_id']);
        foreach ($_POST as $key => $dat) {
            $data[$key] = stripQuotes(removeBadChars($dat));
        }
        $collection = $db->insert($caTable, $data);
        $_SESSION['adm_message'] = 'Category has been added successfully.';
        $_SESSION['type'] = 'success';
        header("Location: all-category.php");
        exit;
    } else {

        $message = implode('<br/>', $error);
    }
}
/* * ***fetch Category******** */
$conductions = array('$and' => array(array('status' => '1'), array('pcat_id' => '0')));
$ptabledata = $db->find($caTable, $conductions, 'name', 1);
/* * ****************************************************** */
include('include/header.php');
include('include/left_menu.php');
?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Add Category

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">category</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">  
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Category</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-danger"><?php echo $message; ?></div>
                        <?php } ?>

                        <form role="form" name="frm" id="frm" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Parent Category</label>
                                <select class="form-control" name="pcat_id">
                                    <option value="0">No Parent</option>  
                                    <?php foreach ($ptabledata as $row) { ?>  
                                        <option value="<?php echo $row['_id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php } ?> 

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="name">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" placeholder="Enter ..." name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Category Banner</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Featured Category</label>
                                <select class="form-control" name="fetured_category">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>Meta Title</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="meta_title">
                            </div>
                            <div class="form-group">
                                <label>Meta Key</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="meta_key">
                            </div>
                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea class="form-control" placeholder="Enter ..." name="meta_description"></textarea>
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
 