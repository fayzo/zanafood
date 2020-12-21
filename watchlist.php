<?php include "header_if_login.php"?>
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
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Your Watch-List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo HOME; ?>">Home</a></li>
                </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->

        <div class="container">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-9">
                    <span id="responseSubmitfooditerm"> </span>
                    <div id="responseSubmitfooditermview">
                      <?php echo $food->FoodshowCart_item(); ?>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3">
                    <div class="row">

                        <!-- col -->
                        <div class="col-md-12 mb-3">
                            <!-- < ?php echo $watch_list->agent_profile_viewProfile();?> -->
                        </div> 
                        <!-- col -->
                    </div> 
                    <!-- row -->
                </div> 
                <!-- col -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
      
    </section>
    <!-- Property Section End -->

    
<?php include "footer.php"?>
