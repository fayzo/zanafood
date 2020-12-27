<?php include "Get_usernameProfile.php"?>
<?php include "header.php"?>
    
<!-- <body> -->
<body >
<!-- <body class="chair"> -->
    <div class="content">
    <?php include "navbar.php"?>
    <!-- navbar -->


    <!-- Property Section Begin -->
    <section class="property-section spad">
        <div class="container">
            <div class="row">
                <!-- col -->
                <div class="col-md-3">
                    <div class="row forth_sec">
                        <div class="col-sm-12">
                            <div class="menu" style="background: url(assets/image/img/menu_bg.jpg)no-repeat;background-size: 100% 100%;">
                                <div class="inner_content">
                                    <span class="flaticon flaticon-burger"></span>
                                    <h2>menu</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="drinks" style="background: url(assets/image/img/drinks_bg.jpg)no-repeat;background-size: 100% 100%;">
                                <div class="inner_content">
                                    <span class="flaticon flaticon-drink"></span>
                                    <h2>drinks</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="sides" style="background: url(assets/image/img/sides_bg.jpg)no-repeat;background-size: 100% 100%;">
                                <div class="inner_content">
                                    <span class="flaticon flaticon-food"></span>
                                    <h2>sides</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- col -->

                <div class="col-md-6" id="house_hidden">
                      <?php echo $food->property_navListHome('food',1,$user_id); ?>
                      <?php echo $food->foodList('food',1,$user_id); ?>
                </div>
                <div class="col-md-3">
                    <div class="row">

                        <div class="col-md-12">
                            <span id="responseSubmitfooditerm"> </span>
                            <div id="responseSubmitfooditermview">
                                 <?php echo $food->FoodshowCart_itemSale(); ?>
                            </div>
                        </div> 
                        <!-- col -->
                    </div> 
                    <!-- row -->

                    <h3>Recent Post</h3>
                    <div class="post-box-blog">
							<div class="recent-post-box">
								<div class="recent-box-blog">
									<div class="recent-img">
										<img class="img-fluid" src="assets/image/img/post-img-01.jpg" alt="">
									</div>
									<div class="recent-info">
										<ul>
											<li><i class="zmdi zmdi-account"></i>Posted By : <span>Rubel Ahmed</span></li>
											<li>|</li>
											<li><i class="zmdi zmdi-time"></i>Time : <span>11.30 am</span></li>
										</ul>
										<h4>Duis feugiat neque sed dolor cursus, sed lacinia nisl pretium.</h4>
									</div>
								</div>
								<div class="recent-box-blog">
									<div class="recent-img">
										<img class="img-fluid" src="assets/image/img/post-img-02.jpg" alt="">
									</div>
									<div class="recent-info">
										<ul>
											<li><i class="zmdi zmdi-account"></i>Posted By : <span>Rubel Ahmed</span></li>
											<li>|</li>
											<li><i class="zmdi zmdi-time"></i>Time : <span>11.30 am</span></li>
										</ul>
										<h4>Duis feugiat neque sed dolor cursus, sed lacinia nisl pretium.</h4>
									</div>
								</div>
								<div class="recent-box-blog">
									<div class="recent-img">
										<img class="img-fluid" src="assets/image/img/post-img-03.jpg" alt="">
									</div>
									<div class="recent-info">
										<ul>
											<li><i class="zmdi zmdi-account"></i>Posted By : <span>Rubel Ahmed</span></li>
											<li>|</li>
											<li><i class="zmdi zmdi-time"></i>Time : <span>11.30 am</span></li>
										</ul>
										<h4>Duis feugiat neque sed dolor cursus, sed lacinia nisl pretium.</h4>
									</div>
								</div>
								<div class="recent-box-blog">
									<div class="recent-img">
										<img class="img-fluid" src="assets/image/img/post-img-01.jpg" alt="">
									</div>
									<div class="recent-info">
										<ul>
											<li><i class="zmdi zmdi-account"></i>Posted By : <span>Rubel Ahmed</span></li>
											<li>|</li>
											<li><i class="zmdi zmdi-time"></i>Time : <span>11.30 am</span></li>
										</ul>
										<h4>Duis feugiat neque sed dolor cursus, sed lacinia nisl pretium.</h4>
									</div>
								</div>
							</div>
						</div>

                </div> 
                <!-- col -->
            </div>
             <!-- row -->

        </div>
    </section>
    <!-- Property Section End -->

<!-- Top Properties Section Begin -->
    <div class="top-properties-section spad" style="background: #f8f9fa;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="properties-title">
                        <div class="section-title">
                            <span>Special Menu For You</span>
                            <h2>OUR MENUS</h2>
                        </div>
                        <!-- <a href="< ?php echo (isset($_SESSION['key']))? VIEW_ALL_PROPERTY:F_VIEW_ALL_PROPERTY; ?>" class="top-property-all">View All Property</a> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="top-properties-carousel owl-carousel">
               <?php echo $food->food_carousel(); ?>
            </div>
        </div>
    </div>
    <!-- Top Properties Section End -->

    
     <!-- Video Section Begin -->
     <div class="video-section set-bg" data-setbg="<?php echo BASE_URL; ?>assets/image/img/food_preparation.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-text">
                        <a href="https://www.youtube.com/watch?v=JpaoLFVg-q4" class="play-btn video-popup"><i class="fa fa-play"></i></a>
                        <h4>View in your own sight</h4>
                        <h2>HOW FOOD PREPARE IN OUR KICHTEN</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Section End -->

    

    <!-- Top Properties Section End -->
    <section class="agent-section" style="padding-bottom:4px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Our Stuff</h2>
                    </div>
                </div>
            </div>
            <?php echo $food->stuff(); ?>
        </div>

    </section>
    <!-- Property Section End -->

    <!-- Top Properties Section End -->
    <section>
        <div class="qt-box qt-background" style="background: url(assets/image/img/qt-bg.jpg) no-repeat;
        background-size: cover;
        padding: 100px 0;
        background-attachment: fixed;
        background-position: center center;
        position: relative;">

            <div class="container">
                <div class="row">
                    <div class="col-md-8 ml-auto mr-auto text-center">
                        <p class="lead ">
                            " If you're not the one cooking, stay out of the way and compliment the chef. "
                        </p>
                        <span class="lead">Michael Strahan</span>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <!-- Property Section End -->

<section class="agent-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>We Are Here To Serve You</span>
                    <h2>Customer Reviews</h2>
                </div>
            </div>
        </div>
        <?php echo $food->custtomer_reviews(); ?>
    </div>

</section>
<!-- Property Section End -->


<?php include "admin_message.php"?>
<?php include "footer.php"?>
