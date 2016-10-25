<?php
session_start();
require_once("inc/config.inc.php");
require_once("inc/database.inc.php");
require_once("inc/functions.inc.php");
$log = (isset($_REQUEST['log'])) ? "?log=out" : "?log=none";
$db = new Database();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['rt_admin_username']) ? $_POST['rt_admin_username'] : "";
    $password = isset($_POST['rt_admin_password']) ? $_POST['rt_admin_password'] : "";

    $name = stripQuotes(removeBadChars($name));
    $password = stripQuotes(removeBadChars($password));

    if (USE_PASSWORD_ENCRYPTION) {
        if (PASSWORD_ENCRYPTION_TYPE == 'AES') {
            $password = AES_ENCRYPT($password, PASSWORD_ENCRYPTION_KEY);
        } else {
            $password = MD5($password);
        }
    } else {
        $password = '\'' . $password . '\'';
    }
    $cond = array( '$and' => array( array('username' =>$name), array('password'=>$password) ) );
    $collection = $db->find($adminTable, $cond);
  if(!empty($collection)){  
    foreach($collection as $row){
      if(!empty($row)){  
        $_SESSION['adm_logged'] = true;
        $_SESSION['adm_user_id'] = $row['_id'];
        $_SESSION['adm_username'] = $row['first_name'];
        $_SESSION['adm_role'] = $row['role'];
        $_SESSION['adm_status'] = $row['status'];
        $_SESSION['profile_pic'] = $row['profile_pic'];
        $_SESSION['adm_message'] = 'You have loged in successfully.';
        $_SESSION['type'] = 'success';
        header("Location: dashboard.php");
      } else{
           $_SESSION['adm_logged'] = false;
           $_SESSION['adm_user_id'] = "";
           $_SESSION['adm_username'] = "";
           $_SESSION['adm_role'] = "";
           $_SESSION['adm_status'] = "";
           $_SESSION['profile_pic'] = '';
           $_SESSION['adm_message'] = 'Please enter correct username and password.';
           $_SESSION['type'] = 'warning';
           header("Location: index.php");
      }
    }
     $_SESSION['adm_message'] = 'Please enter correct username and password.';
     $_SESSION['type'] = 'warning';
     header("Location: index.php");
  }
   
}
//header("Location: index.php" . $log . "&msg=1");
exit;
?>