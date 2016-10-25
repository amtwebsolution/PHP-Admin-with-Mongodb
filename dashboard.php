<?php
session_start();
require_once("inc/checkAdminPagePermissions.php");
require_once("inc/config.inc.php");
require_once("inc/database.inc.php");
require_once("inc/settings.inc.php");
require_once("inc/functions.inc.php");

$menu_group_index = 0;
$menu_group_count = 0;
$db = new Database();

$conduction = array('_id' => array('$ne'  => '0'));
$countCategories = $db->numRows($caTable, $conduction);
$countProducts = $db->numRows($proTable, $conduction);
$countUser = $db->numRows($customerTable, $conduction);
include('include/header.php');
include('include/left_menu.php');
?>

  <div class="content-wrapper">
   
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
    
      <div class="row">
           <div class="box-header"> 
                        <h3 class="box-title"><?php messages('adm_message'); ?></h3>
           </div>
        <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $countCategories;?></h3>
              <p>Categories</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <!--a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a-->
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $countProducts;?></h3>

              <p>Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <!--a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a-->
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $countUser;?></h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <!--a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a-->
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>
              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <!--a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a-->
          </div>
        </div>
        <!-- ./col -->
      </div>
     
     

    </section>
   
  </div>
  
  

  <?php include('include/footer.php');?>
 