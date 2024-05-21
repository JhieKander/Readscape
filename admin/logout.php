<?php
  require_once("../function/book-class.php"); 
$book->adminlogout();
header('Refresh: 3;url=../admin-log.php?log out successfull');