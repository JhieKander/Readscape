<div class="container">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0" id="admin-sidebar">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link align-middle px-0">
                            <img src="../assets/images/icon/dashboard.png" alt="" class="img-fluid" width="20">
                             <span class="ms-1 d-none d-sm-inline text-dark">Dashboard</span>
                        </a>
                    </li>

                    <li class="mt-3">
                        <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <img src="../assets/images/icon/basket.png" alt="" class="img-fluid" width="20"> <span class="ms-1 d-none d-sm-inline text-dark">Products</span>
                        <img src="../assets/images/icon/down-arrow.png" alt="" class="img-fluid" width="20" style="margin-left:9px;"> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">  
                               <li class="w-100">
                                <a href="product_list.php" class="nav-link px-0"> <span class="d-none d-sm-inline text-end" style="color:#5B4635;">Product List</span> </a>
                            </li>

                            <li class="w-100">
                                <a href="category.php" class="nav-link px-0"> <span class="d-none d-sm-inline text-end" style="color:#5B4635;">Categories</span> </a>
                            </li>

                            <li class="w-100">
                                <a href="add_product.php" class="nav-link px-0"> <span class="d-none d-sm-inline text-end" style="color:#5B4635;">Add Products</span> </a>
                            </li>


                            
                        </ul>
                    </li>

                    <li class="mt-3">
                        <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                        <img src="../assets/images/icon/cart.png" alt="" class="img-fluid" width="20"> <span class="ms-1 d-none d-sm-inline text-dark">Orders</span> 
                        <img src="../assets/images/icon/down-arrow.png" alt="" class="img-fluid" width="20" style="margin-left:20px;"> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline text-dark">Product</span> 1</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline text-dark">Product</span> 2</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline text-dark">Product</span> 3</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline text-dark">Product</span> 4</a>
                            </li>
                        </ul>
                    </li>


                    <li class="mt-3">
                        <a href="#" class="nav-link px-0 align-middle">
                        <img src="../assets/images/icon/statistics.png" alt="" class="img-fluid" width="20">
                            <span class="ms-1 d-none d-sm-inline text-dark">Statistics</span> </a>
                    </li>

                    <li class="mt-3">
                        <a href="#" class="nav-link px-0 align-middle">
                        <img src="../assets/images/icon/review.png" alt="" class="img-fluid" width="20">
                            <span class="ms-1 d-none d-sm-inline text-dark">Reviews</span> </a>
                    </li>

                    <li class="mt-3">
                        <a href="#" class="nav-link px-0 align-middle">
                        <img src="../assets/images/icon/edit.png" alt="" class="img-fluid" width="20">
                            <span class="ms-1 d-none d-sm-inline text-dark">Edit Website</span> </a>
                    </li>


                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-user-circle text-dark" aria-hidden="true"></i>

                        <span class="d-none d-sm-inline mx-1 text-dark fw-bold">
                        <?=$admininfo['lastname']?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        