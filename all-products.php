<?php session_start();
require_once("inc/checkAdminPagePermissions.php");
require_once("inc/config.inc.php");
require_once("inc/database.inc.php");
require_once("inc/settings.inc.php");
require_once("inc/functions.inc.php");
require_once("inc/ps_pagination.php");
$db = new Database();
$message = '';
/* * ***fetch state******** */
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$append = '';
if(!empty($limit)){
  $append .= 'limit='.$limit;
}
$search = isset($_GET['search']) ? $_GET['search'] : '';
include('include/header.php');
include('include/left_menu.php');
?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Manage Category

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Category</li>
        </ol>
    </section>
    <?php /* if(!empty($message)){?>
      <div class="alert alert-danger"><?php echo $message;?></div>
      <?php } */ ?>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Data Table With Full Features</h3>
                    </div>
                    <div class="box-header"> 
                        <h3 class="box-title"><?php 
                             messages('adm_message');
                        ?></h3>
                    </div>
                        
                    <div class="box-body">
                        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="dataTables_length" id="example1_length">
                                        <label>Show 
                                            <select id="example1_length" name="example1_length" aria-controls="example1" class="form-control input-sm">
                                                <option value="10" <?php if ($limit == 10) { ?> selected="selected" <?php } ?>>10</option>
                                                <option value="25" <?php if ($limit == 25) { ?> selected="selected" <?php } ?>>25</option>
                                                <option value="50" <?php if ($limit == 50) { ?> selected="selected" <?php } ?>>50</option>
                                                <option value="100" <?php if ($limit == 100) { ?> selected="selected" <?php } ?>>100</option>
                                            </select> 
                                            entries</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div id="example1_filter" class="dataTables_filter">
                                       <label>
                                            Search:
                                            <form name="form1" action="<?php echo $_SERVER['PHP_SELF'];?>"  enctype="multipart/form-data" onsubmit="return validation_category();">
                                                <input type="text" class="form-control input-sm" placeholder="Search" name="search" id="search" value="<?php echo $search;?>">
                                              <input type="submit" name="go" value="Go">
                                            </form>  
                                            
                                        </label>
                                    </div>
                                </div>
                            </div>  

                            <div class="row">
                                <div class="col-sm-12">  
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>NAME</th>
                                                <th>PARENT</th>
                                                <th>CREATED</th>
                                                <th>UPDATED</th>
                                                <th>STATUS</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!isset($_GET['page']) || empty($_GET['page'])) {
                                                $i = 1;
                                            } else {
                                                $i = ((int) $_GET['page'] - 1) * $limit + 1;
                                            }

                                            //$conduction = array('parent_id' => array('$ne' => '0'));
                                            $conduction = array('_id' => array('$ne'  => '0'));
                                            if(!empty($search)){
                                                $conduction = array_merge($conduction, array('name'=>array('$regex'=>$search, '$options' =>'i')));
                                                $append .= '&search='.$search;
                                            }
                                            
                                            
                                            $sql = array(
                                                'mainCollection' => $proTable,
                                                'joinCollection' => $caTable,
                                                'localField' => 'cat_id',
                                                'foreignField' => '_id',
                                                'as' => 'data_join',
                                                'match' => $conduction,
                                                'sort' => array('name' => 1)
                                            );


                                            $pager = new PS_Pagination($db, $sql, $limit, 5, $append);
                                            $rs = $pager->paginate();
                                           if($rs['result']){
                                            foreach ($rs['result'] as $key => $data) {
                                              
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $data['name']; ?></td>
                                                    <td><?php echo isset($data['data_join'][0]['name'])?$data['data_join'][0]['name']:''; ?></td>
                                                    <td><?php echo date('d/m/Y h:i:s', $data['created']); ?></td>
                                                    <td><?php echo isset($data['updated'])?date('d/m/Y h:i:s', $data['updated']):''; ?></td>
                                                    <td><?php echo $data['status']==1?'Active':'Deactive'; ?></td>
                                                    <td><a href="edit-product.php?id=<?php echo $data['_id']; ?>">
                                                            <i class="fa fa-pencil"></i>Edit
                                                        </a> &nbsp;&nbsp;
                                                        <a href="delete.php?action=delete&table=product&id=<?php echo $data['_id']; ?>">
                                                            <i class="fa fa-remove"></i>Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                           }else{
                                               echo '<tr><td colspan="5">Data Not Found.</td></tr>';
                                           }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                        <?php echo $pager->renderFullNav(); ?>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </section>

</div>
<?php include('include/footer.php'); ?>
 