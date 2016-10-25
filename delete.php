<?php session_start();
require_once("inc/checkAdminPagePermissions.php");
require_once("inc/config.inc.php");
require_once("inc/database.inc.php");
require_once("inc/settings.inc.php");
require_once("inc/functions.inc.php");

$db = new Database();
$message = '';
$action = isset($_GET['action'])?$_GET['action']:'';
$table = isset($_GET['table'])?$_GET['table']:'';
$id = isset($_GET['id'])?$_GET['id']:'';
$caTable = '';
switch($table){
    case 'category':
      $acTable = $caTable;
      break; 
  case 'product':
      $acTable = $proTable;
      break;
  case 'user':
      $acTable = $customerTable;
      break;
  
  
}

if ($action == 'delete' && !empty($acTable) && !empty($id)) {
   
     $db->delete($acTable,$id);
     $_SESSION['adm_message'] = ucfirst($table).' has been delete successfully.';
     
} else {
    $_SESSION['adm_message'] = 'You are not authenticated to delete '.$table.'.';
}
header("location:".$_SERVER['HTTP_REFERER']);
exit;
?>

