<?php 
   class mybookShop
   {
     private $server = "mysql:host=localhost;dbname=db_book_shop";
     private $user = "root";
     private $pass = "";
     private $options = array(PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => 
     PDO::FETCH_ASSOC);
    protected $con;
    //end of connection

        public function openConnection()
        {
          try{
           $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
           return $this->con;
            }catch(PDOException $e)
            {
              echo "There is some problem in the connection:". $e->getMessage();
          }
          
      }

 public function closeConnection(){
          $this->con = null;
      }



/////////////////////////////////////////start admin function///////////////////////////////////////////////////

public function set_admindata($array){
             
      if(!isset($_SESSION)){
      session_start();   
        }
        $_SESSION['admindata'] = array(
                  "admin_id" => $array['admin_id'],
                  "firstname" => $array['firstname'],
                  "middle_name" => $array['middle_name'],
                  "lastname" => $array['lastname'] ,
                  "email" => $array['email'],  
                  "date_register" => $array['date_register'], 
                  "access" => $array['access']


          );
              return $_SESSION['admindata'];
      }


public function adminlogout()
    {
      session_start();
      unset($_SESSION['admin_id']);
      session_unset();
      session_destroy();
      echo "Logging out .... Please Wait .....";
        
    }
public function get_admindata()
      {
               if(!isset($_SESSION)){
                 session_start();   
               }
               if(isset($_SESSION['admindata'])){
                 return $_SESSION['admindata'];  
               }else{
                 return null;
               }
        }

 public function check_user_exist($email){
        
          $connection = $this->openConnection();
            $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ?");
            $stmt -> execute([$userLog]);
            $total = $stmt ->rowCount();
            return $total;
      }


  public function adminlogin(){
    
    if(isset($_POST['admin-log']) ){ 
        
        $passlog = md5($_POST['passlog']);
        $email = $_POST['email']; 

        $connection = $this->openConnection();
        $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ? AND password = ? AND status='active'");
        $stmt -> execute([$email, $passlog]);
        $user = $stmt->fetch(); 
        $total = $stmt->rowCount(); 

        if($total > 0){
        echo "Welcome".$user['email']; 
         $this->set_admindata($user);
         header("Location: admin");
        }else{
          echo "<script language='javascript'>alert('You Are Not Yet Registered'); </script>";
        }           
    }

}

public function addCategory(){
     
     if(isset($_POST['add_cat'])){
       
        $category   = $_POST['category'];
        $encoder   = $_POST['encoder'];
        $connection = $this->openConnection();
        $stmt       = $connection->prepare("INSERT INTO tbl_category(`category_name`, `encoded_by`)
         VALUES(?,?)");
        $stmt -> execute([$category, $encoder]);
         echo "<script language='javascript'>alert('Successfully Add');
         window.location.href='category.php';</script>";                          
        
      }
    }
      
 
public function getCategory(){
      
      $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT * FROM  tbl_category  where status = 'view' limit 20");
      $stmt->execute();
      $category = $stmt->fetchall();
      $total = $stmt->rowCount();
      $nodata = "No Data Result";
      if($total > 0 ){

          return $category;
      }else{
          return FALSE;
      }
   }   


public function product(){
       
        if(isset($_POST['productadd'])){
          
          $productcode = $_POST['productcode'];
          $productname = $_POST['productname'];
          $productcategory = $_POST['category'];
          $typebook = $_POST['typebook'];
          $price = $_POST['price'];
          $description = $_POST['description'];
          $encodeby = $_POST['encodeby'];

          // Handle image upload
          $targetDir = "../assets/images/products/"; // Directory where images will be stored
          $targetFile = $targetDir . basename($_FILES["displayimage"]["name"]);
          $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
          $imageFileName = basename($_FILES["displayimage"]["name"]); // Extracting just the filename

          move_uploaded_file($_FILES["displayimage"]["tmp_name"], $targetFile);

          $connection = $this->openConnection();
          $stmt = $connection->prepare("INSERT INTO tbl_product(`bookcode`, `book_name`,`categories`,`type_book`,`product_discription`,`price`,`image`,`added_by`)
               VALUES(?,?,?,?,?,?,?,?)");
          $stmt->execute([$productcode, $productname, $productcategory, $typebook, $description, $price, $imageFileName, $encodeby]);
          echo "<script language='javascript'>alert('Successfully Add');
               window.location.href='add_product.php';</script>";
      }

}

public function addtionalImageProduct(){
        
          if(isset($_POST['productadd'])){
             
              $productcode = $_POST['productcode'];
        
              if(isset($_FILES['images'])){
                  $images = $_FILES['images'];
                  foreach($images['tmp_name'] as $key => $tmp_name){
                      $image_name = $images['name'][$key];
                      $image_tmp = $images['tmp_name'][$key];
                      
                      if(move_uploaded_file($image_tmp, "../assets/images/products/".$image_name)){
                          // Insert image details into database
                          $connection = $this->openConnection();
                          $stmt = $connection->prepare("INSERT INTO tbl_addimage(`bookcode`, `images`) VALUES (?, ?)");
                          $stmt->execute([$productcode, $image_name]);
                      } else {
                          echo "Failed to upload image: ".$image_name."<br>";
                      }
                  }
              } else {
                  echo "No images uploaded!";
              }
          }
}

 public function productlist(){
 
     $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT * FROM  tbl_product  where status = 'view'");
      $stmt->execute();
      $product = $stmt->fetchall();
      $total = $stmt->rowCount();
      $nodata = "No Data Result";
      if($total > 0 ){

          return $product;
      }else{
          return FALSE;
      }
 }


public function randomcode($length = 5){
       $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890";
        $shuffled = substr(str_shuffle($str), 0, $length);
       return $shuffled;
    }
            

        


  


//////////////////////////////////////////end of admin function///////////////////////////////////////
  


///////////////////////////Start user function/////////////////////////////////////////////////////

public function productlistTrending(){
   
     $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT * FROM  tbl_product  where type_book = 'trending' and status = 'view'");
      $stmt->execute();
      $trending = $stmt->fetchall();
      $total = $stmt->rowCount();
      $nodata = "No Data Result";
      if($total > 0 ){

          return $trending;
      }else{
          return FALSE;
      }
 }

 public function productlistrelase(){
    
     $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT * FROM  tbl_product  where type_book = 'NR' and status = 'view'");
      $stmt->execute();
      $release = $stmt->fetchall();
      $total = $stmt->rowCount();
      $nodata = "No Data Result";
      if($total > 0 ){

          return $release;
      }else{
          return FALSE;
      }
 }


  public function productArival(){
    
     $connection = $this->openConnection();
      $stmt = $connection->prepare("SELECT * FROM  tbl_product  where type_book = 'NA' and status = 'view'");
      $stmt->execute();
      $arrival = $stmt->fetchall();
      $total = $stmt->rowCount();
      $nodata = "No Data Result";
      if($total > 0 ){

          return $arrival;
      }else{
          return FALSE;
      }
 }


/////////////////////////////////////end of user function///////////////////////////////////////////////////









}

$book = new mybookShop();

 ?>