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
        $error[] = 'Please enter product name.';
    } 
    if (empty($sku)) {
        $error[] = 'Please enter product sku.';
    }else {
        $cond = array('sku' => $sku);
        $count = $db->numRows($proTable, $cond);
        if ($count > 0) {
            $error[] = 'Product sku already exists.';
        }
    }
    
    if (empty($description)) {
        $error[] = 'Please enter product short description.';
    } 
    
    if (empty($more_info)) {
        $error[] = 'Please enter product description.';
    } 
    
    if (empty($price)) {
        $error[] = 'Please enter product price.';
    }else{
        if(!is_numeric($price)){
            $error[] = 'Please enter valid price.';
        }
        
    }
    
    if (empty($qty)) {
        $error[] = 'Please enter qty.';
    }else{
        if(!is_numeric($qty)){
            $error[] = 'Please enter Qty.';
        }
        
    }
    
    if (!empty($_FILES['main_image']['name'])) {
         
      $ext = pathinfo($_FILES["main_image"]["name"], PATHINFO_EXTENSION);
      if(!in_array($ext, $imageExtension)){
          $error[] = 'Image not valid. Please upload jpg or png image.';
      }
      
    }
    if (empty($error)) {
        $id = $db->getNextSequence('product_id'); //create new id
        $banner = '';

        if (!empty($_FILES['main_image']['name'])) {
            $type = $_FILES["main_image"]["type"];
            $source = $_FILES["main_image"]["tmp_name"];
            $file = UPLOAD_DIR_PRODUCT . $id . '_' . strtolower($_FILES["main_image"]["name"]);
            move_uploaded_file($source, $file);
        }


        $data = array('_id' => $id, 'main_image' => $file, 'created' => time(), 'cat_id'=> (INT)$cat_id);
        unset($_POST['cat_id']);
        foreach ($_POST as $key => $dat) {
            $data[$key] = stripQuotes(removeBadChars($dat));
        }
        $collection = $db->insert($proTable, $data);
        $_SESSION['adm_message'] = 'Product has been added successfully.';
        $_SESSION['type'] = 'success';
        header("Location: all-products.php");
        exit;
    } else {

        $message = implode('<br/>', $error);
    }
}
/* * ***fetch Categories data******** */
$conductions = array('status' => '1');
$ptabledata = $db->find($caTable, $conductions, 'name', 1);
/* * ****************************************************** */
include('include/header.php');
include('include/left_menu.php');
?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Add Product

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Product</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">  
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-warning"><?php echo $message; ?></div>
                        <?php } ?>

                        <form role="form" name="frm" id="frm" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Select Category</label>
                                <select class="form-control" name="cat_id">
                                   <?php foreach ($ptabledata as $row) { ?>  
                                        <option value="<?php echo $row['_id']; ?>"><?php echo $row['name']; ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="name">
                            </div>
                            <div class="form-group">
                                <label>SKU</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="sku">
                            </div>
                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea class="form-control" placeholder="Enter ..." name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" placeholder="Enter ..." name="more_info"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="price">
                            </div>
                            
                            <div class="form-group">
                                <label>Discount in % Only</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="discount">
                            </div>
                            
                            <div class="form-group">
                                <label>Qty</label>
                                <input type="text" class="form-control" placeholder="Enter ..." name="qty">
                            </div>
                            
                             <div class="form-group">
                                <label>STOCK</label>
                                <select class="form-control" name="in_stock">
                                    <option value="1">IN STOCK</option>
                                    <option value="0">OUT STOCK</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Featured Product</label>
                                <select class="form-control" name="featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>

                                </select>
                            </div>
                             <div class="form-group">
                                <label>Product image</label>
                                <input type="file" class="form-control" name="main_image">
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
 