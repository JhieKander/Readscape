<!DOCTYPE html>
<html>
  <?php require_once("../assets/parts/admin-head.php"); ?>
<body>
<?php require_once("../assets/inc/admin-nav.php"); ?>
<hr>
<?php require_once("../function/admin-session.php"); ?>

<?php require_once("../assets/inc/admin-sidebar.php"); ?>

<div class="container col py-3">
        <div class="container-fluid content" id="dashboard">
            <h5>Dashboard</h5>
                         <div class="row">
                         	<div class="col-md-4 d-box me-4">
                         		<div class="d-flex">
	                         		<img src="../assets/images/icon/peso.png" class="img-fluid me-2 mt-3">
	                         		<div class="sales">
	                         	   	  <p class="fw-bold values">Total Sales<br> <span>00, 0000, 000.00</span></p>
	                         		</div> 
                          	   </div>	
                         	</div>

                         	<div class="col-md-3 d-box me-4">
                         		<div class="d-flex">
	                         		<img src="../assets/images/icon/cart.png" class="img-fluid me-2 mt-3">
	                         		<div class="sales">
	                         	   	  <p class="fw-bold values">Total orders<br> <span>0000</span></p>
	                         		</div> 
                          	   </div>	
                         	</div>

                         	<div class="col-md-3 d-box me-4">
                         		<div class="d-flex">
	                         		<img src="../assets/images/icon/cart.png" class="img-fluid me-2 mt-3">
	                         		<div class="sales">
	                         	   	  <p class="fw-bold values">Item Uploaded<br> <span>0000</span></p>
	                         		</div> 
                          	   </div>	
                         	</div>

                         
                       </div>
                        <br><br>
                         <div class="row">
                       	  <div class="col-md-4 me-3 websitevist">
                       	  	 <?php
 
								$dataPoints = array( 
									array("label"=>"Visit", "symbol" => "O","y"=>46.6),
									array("label"=>"", "symbol" => "O","y"=>10000),

								 
								)
								 
								?>
								<script>
								window.onload = function() {
							var chart = new CanvasJS.Chart("chartContainer", {
							    theme: "light2",
							    backgroundColor: "rgba(215, 185, 169, 0.5)", // Change this to the color you want
							    animationEnabled: true,
							    title: {
							        text: "Website Total Visit",
							         fontSize: 15 

							    },
							     
							    data: [{
							        type: "doughnut",
							        indexLabel: "{symbol} - {y}",
							        yValueFormatString: "#,##0.0\"%\"",
							        showInLegend: false,
							        legendText: "{label} : {y}",
							        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
							    }]
							});
							chart.render();
								 
								}
								</script>

								<div id="chartContainer" style="height: 370px; width: 100%;	"></div>
								<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                       	  </div>

                       	  <div class="col-md-7 d-box">
                       	  	<label>Latest Orders</label>
                       	  	<table class="table border-dark">
                       	  		 <tbody>
                       	  		 	<tr>
                       	  		 		<td>Order Number</td>
                       	  		 		<td>Customer Name</td>
                       	  		 		<td>Total Order</td>
                       	  		 		<td>Status</td>
                       	  		 	</tr>

                       	  		 	<tr>
                       	  		 		<td>Order Number</td>
                       	  		 		<td>Customer Name</td>
                       	  		 		<td>Total Order</td>
                       	  		 		<td>Status</td>
                       	  		 	</tr>

                       	  		 	<tr>
                       	  		 		<td>Order Number</td>
                       	  		 		<td>Customer Name</td>
                       	  		 		<td>Total Order</td>
                       	  		 		<td>Status</td>
                       	  		 	</tr>


                       	  		 </tbody>
                       	  	</table>
                       	  </div>
                      </div>   
                       <hr>           
                 </div>
             </div>
             <!-- end of contaier col py -->
        </div>
    </div>
</div>




 <?php require_once("../assets/inc/admin-footer.php"); ?>
 <?php require_once("../assets/parts/admin-bottom.php"); ?>
