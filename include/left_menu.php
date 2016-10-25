<?php session_start();
  $path = $_SERVER['PHP_SELF'];
  $openmenu = basename($path,".php");
  $catMenu = array('all-category','add-category','edit-category');
  $productsMenu = array('all-products','add-product','edit-product');
  $usersMenu = array('all-users','add-user','edit-user');
  $dashboard = array('dashboard');
  
?>

  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo $_SESSION['profile_pic'];?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['adm_username'];?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview <?php echo in_array($openmenu, $dashboard)?'active':''?>">
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          
        </li>
        <li class="treeview <?php echo in_array($openmenu, $catMenu)? 'active':''?>">
          <a href="all-category.php">
            <i class="fa fa-th"></i>
            <span>Category</span>
            <i class="fa fa-angle-left pull-right"></i>
            <!--span class="label label-primary pull-right">4</span-->
          </a>
            <ul class="treeview-menu <?php echo in_array($openmenu, $catMenu)? 'menu-open':''?>" style="<?php echo in_array($openmenu, $catMenu)? 'display: block;':''?>">
            <li><a href="all-category.php"><i class="fa fa-circle-o"></i> All Category</a></li>
            <li><a href="add-category.php"><i class="fa fa-circle-o"></i> Add Category</a></li>
          </ul>
        </li>
        <li class="treeview <?php echo in_array($openmenu, $productsMenu)? 'active':''?>">
          <a href="all-products.php">
            <i class="glyphicon glyphicon-list-alt"></i>
            <span>Products</span>
            <i class="fa fa-angle-left pull-right"></i>
            <!--span class="label label-primary pull-right">4</span-->
          </a>
            <ul class="treeview-menu <?php echo in_array($openmenu, $productsMenu)? 'menu-open':''?>" style="<?php echo in_array($openmenu, $productsMenu)? 'display: block;':''?>">
            <li><a href="all-products.php"><i class="fa fa-circle-o"></i> All Products</a></li>
            <li><a href="add-product.php"><i class="fa fa-circle-o"></i> Add Product</a></li>
          </ul>
        </li>
        <li class="treeview <?php echo in_array($openmenu, $usersMenu)? 'active':''?>">
          <a href="all-users.php">
            <i class="fa fa-user"></i>
            <span>Users</span>
            <i class="fa fa-angle-left pull-right"></i>
            <!--span class="label label-primary pull-right">4</span-->
          </a>
            <ul class="treeview-menu <?php echo in_array($openmenu, $usersMenu)? 'menu-open':''?>" style="<?php echo in_array($openmenu, $productsMenu)? 'display: block;':''?>">
            <li><a href="all-users.php"><i class="fa fa-circle-o"></i> All Users</a></li>
            <li><a href="add-user.php"><i class="fa fa-circle-o"></i> Add User</a></li>
          </ul>
        </li>
         <li class="treeview">
          <a href="changepassword.php">
            <i class="fa fa-key"></i>
            <span>Change Password</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
        </li>
         <li class="treeview">
          <a href="logout.php">
            <i class="glyphicon glyphicon-off"></i>
            <span>Sign out</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
        </li>
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>