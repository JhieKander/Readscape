<div class="container my-3" id="trending-corousel">
    <h5>What’s Trending</h5>
    <div class="row mx-auto my-auto justify-content-center">
        <!-- First Slider -->
        <div id="recipeCarousel1" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php
                $trending = $book->productlistTrending();
                if (!is_array($trending) && !is_object($trending)) {
                    echo "No data available";
                } elseif (empty($trending)) {
                ?>
                    <div class="carousel-item active">
                        <span colspan="6">No data available</span>
                    </div>
                <?php
                } else {
                    $first = true; // Flag to mark the first item as active
                    foreach ($trending as $lisproduct1) {
                ?>
                        <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                            <div class="col-md-3 me-3">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="assets/images/products/<?= $lisproduct1['image'] ?>" class="img-fluid">
                                        <div class="container">
                                            <p class="text-center"><?= $lisproduct1['book_name'] ?></p>
                                            <span>₱ <?= $lisproduct1['price'] ?></span>
                                            <br>
                                            <div class="text-center">
                                                <button class="btn">ADD TO CART</button>
                                            </div>
                                            <hr class="text-light">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                        $first = false; // Update the flag after the first iteration
                    }
                }
                ?>
            </div>
            <a style="margin-left:-10%;" class="carousel-control-prev bg-transparent w-auto" href="#recipeCarousel1" role="button" data-bs-slide="prev">
                <span style="border-radius: 50px;" class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next bg-transparent w-auto" href="#recipeCarousel1" role="button" data-bs-slide="next">
                <span style="margin-right:-130%; border-radius: 50px" class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
            </a>
        </div>

        <!-- Second Slider -->
        <div id="recipeCarousel2" class="carousel slide mt-5" data-bs-ride="carousel">
             <h5>New Releases</h5>
               <div class="carousel-inner" role="listbox">
                <?php
                $release = $book->productlistrelase();
                if (!is_array($release) && !is_object($release)) {
                    echo "No data available";
                } elseif (empty($release)) {
                ?>
                    <div class="carousel-item active">
                        <span colspan="6">No data available</span>
                    </div>
                <?php
                } else {
                    $first = true; // Flag to mark the first item as active
                    foreach ($release as $lisproduct2) {
                ?>
                        <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                            <div class="col-md-3 me-3">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="assets/images/products/<?= $lisproduct2['image'] ?>" class="img-fluid">
                                        <div class="container">
                                            <p class="text-center"><?= $lisproduct2['book_name'] ?></p>
                                            <span>₱ <?= $lisproduct2['price'] ?></span>
                                            <br>
                                            <div class="text-center">
                                                <button class="btn">PRE-ORDER</button>
                                            </div>
                                            <hr class="text-light">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                        $first = false; // Update the flag after the first iteration
                    }
                }
                ?>
            </div>
            <a style="margin-left:-10%;" class="carousel-control-prev bg-transparent w-auto" href="#recipeCarousel2" role="button" data-bs-slide="prev">
                <span style="border-radius: 50px;" class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next bg-transparent w-auto" href="#recipeCarousel2" role="button" data-bs-slide="next">
                <span style="margin-right:-130%; border-radius: 50px" class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
            </a>
        </div>

         <!-- Third Slider -->
        <div id="recipeCarousel3" class="carousel slide mt-5" data-bs-ride="carousel">
               <h5>New Arrivals</h5>
               <div class="carousel-inner" role="listbox">
                <?php
                $arrival = $book->productArival();
                if (!is_array($arrival) && !is_object($arrival)) {
                    echo "No data available";
                } elseif (empty($arrival)) {
                ?>
                    <div class="carousel-item active">
                        <span colspan="6">No data available</span>
                    </div>
                <?php
                } else {
                    $first = true; // Flag to mark the first item as active
                    foreach ($arrival as $lisproduct3) {
                ?>

                        <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                            <div class="col-md-3 me-3">
                                <div class="card">
                                    <div class="card-img">
                                        <img src="assets/images/products/<?= $lisproduct3['image'] ?>" class="img-fluid">
                                        <div class="container">
                                            <p class="text-center"><?= $lisproduct3['book_name'] ?></p>
                                            <span>₱ <?= $lisproduct3['price'] ?></span>
                                            <br>
                                            <div class="text-center">
                                                <button class="btn">ADD TO CART</button>
                                            </div>
                                            <hr class="text-light">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                        $first = false; // Update the flag after the first iteration
                    }
                }
                ?>
            </div>
            <a style="margin-left:-10%;" class="carousel-control-prev bg-transparent w-auto" href="#recipeCarousel3" role="button" data-bs-slide="prev">
                <span style="border-radius: 50px;" class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next bg-transparent w-auto" href="#recipeCarousel3" role="button" data-bs-slide="next">
                <span style="margin-right:-130%; border-radius: 50px" class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
            </a>
        </div>

    </div>
</div>

