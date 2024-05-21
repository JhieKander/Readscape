<?php
require_once("../function/book-class.php");
$admininfo = $book->get_admindata();

if(isset($admininfo)){
   if($admininfo['access'] != "admin"){
      header("Location: ../admin-log.php");
   }

}else{
    header("Location: ../admin-log.php");
}
?>
