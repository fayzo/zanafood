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
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Title</h4>
                            <p class="card-text">Text</p>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Title</h4>
                            <p class="card-text">Text</p>
                        </div>
                    </div> <!-- card -->
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
                </div> 
                <!-- col -->
            </div>
             <!-- row -->

        </div>
    </section>
    <!-- Property Section End -->

    
     <!-- Video Section Begin -->
     <div class="video-section set-bg" data-setbg="<?php echo BASE_URL; ?>assets/image/img/vision-city-rwanda.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-text">
                        <a href="https://www.youtube.com/watch?v=JpaoLFVg-q4" class="play-btn video-popup"><i class="fa fa-play"></i></a>
                        <h4>Find The Perfect</h4>
                        <h2>Real Estate Agent Near You</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Section End -->

    
<!-- Top Properties Section Begin -->
    <div class="top-properties-section spad" style="background: #f8f9fa;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="properties-title">
                        <div class="section-title">
                            <span>Property For You</span>
                            <h2>Properties</h2>
                        </div>
                        <a href="<?php echo (isset($_SESSION['key']))? VIEW_ALL_PROPERTY:F_VIEW_ALL_PROPERTY; ?>" class="top-property-all">View All Property</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="top-properties-carousel owl-carousel">
               <!-- < ?php echo $house->top_properties_carousel(); ?> -->
            </div>
        </div>
    </div>

    <!-- Top Properties Section End -->

<section class="agent-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>We Are Here To Help You</span>
                    <h2>Our Agents</h2>
                </div>
            </div>
        </div>
        <?php echo $house->agent_profile_home(); ?>
    </div>

</section>
<!-- Property Section End -->

<?php include "admin_message.php"?>
<?php include "footer.php"?>
