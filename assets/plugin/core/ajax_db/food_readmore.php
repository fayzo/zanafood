<?php 
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if (isset($_POST['food_id']) && !empty($_POST['food_id'])) {
   if (isset($_SESSION['key'])) {
        # code...
        $user_id= $_SESSION['key'];
    }else {
        # code...
        $username= $users->test_input('jojo');
        $uprofileId= $home->usersNameId($username);
        $profileData= $home->userData($uprofileId['user_id']);
        $user_id= $profileData['user_id'];
    }
    
    $food_id = $_POST['food_id'];
    $user= $food->foodReadmore($food_id);
     ?>
<style>
    	ul{
			list-style: none outside none;
		    padding-left: 0;
            margin: 0;
		}
        .demo .item{
            margin-bottom: 60px;
        }
		.content-slider li{
		    background-color: #ed3020;
		    text-align: center;
		    color: #FFF;
		}
		.content-slider h3 {
		    margin: 0;
		    padding: 70px 0;
		}
		.demo{
			width: 800px;
		}
</style>
<div class="food-popup">
    <div class="wrap6">
        <span class="colose">
        	<button class="close-imagePopup"><i class="fa fa-times" aria-hidden="true"></i></button>
        </span>
        <div class="img-popup-wrap">
        	<div class="img-popup-body">

            <div class="card">
                <div class="card-header">
                   <div class="user-block">
                        <div class="user-blockImgBorder">
                         <div class="user-blockImg">
                               <?php if (!empty($user['profile_img'])) {?>
                               <img src="<?php echo BASE_URL_LINK ;?>image/users_profile_cover/<?php echo $user['profile_img'] ;?>" alt="User Image">
                               <?php  }else{ ?>
                                 <img src="<?php echo BASE_URL_LINK.NO_PROFILE_IMAGE_URL ;?>" alt="User Image">
                               <?php } ?>
                         </div>
                         </div>
                         <span class="username">
                             <a
                                 href="<?php echo BASE_URL_PUBLIC.$user['username'] ;?>"><?php echo $user['firstname']." ".$user['lastname'] ;?></a>
                             <!-- //Jonathan Burke Jr. -->
                         </span>
                         <span class="description">Shared publicly - <?php echo $users->timeAgo($user['created_on3']) ;?></span>
                     </div> <!-- /.user-block -->
                </div> <!-- /.card-header -->

                <div class="card-body">

                   <div class="row reusercolor p-2">
                       <div class="col-md-12">
                           <h5 class="text-center black-bg h4 mb-2"><?php echo $user['photo_Title_main']." at ".number_format($user['price'])." Frw"; ?></h5>
                        </div>
                        <div class="col-md-6">

                            <div class="clearfix" style="max-width:474px;">
                                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                                <?php 
                                        $file = $user['photo']."=".$user['other_photo'];
                                        $expode = explode("=",$file);
                                        // $splice = array_expode ($expode,0,10);
                                        for ($i=0; $i < count($expode); ++$i) { 
                                            ?>
                                            <li data-thumb="<?php echo BASE_URL_PUBLIC.'uploads/food/'.$expode [$i]; ?>" > 
                                               <img src="<?php echo BASE_URL_PUBLIC.'uploads/food/'.$expode [$i]; ?>" />
                                            </li>
                                      <?php } ?>
                                </ul>
                            </div>  

                            <h4 class="mt-2"><i>
                                authors: <?php echo $user['authors']; ?>
                            </i></h4>
                            <div class="mt-2">
                                <?php echo $user['text']; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mt-2"><i>Details of food</i></h4>
                            <ul>
                                <li>200 m square feet Garden,</li>
                                <li>4 bedroom,</li>
                                <li>2 bathroom, </li>
                                <li>kitchen and cabinet,</li>
                                <li>car parking ,</li>
                                <li>dapibuseget quame</li>
                            </ul>      
                       </div><!-- /.col -->
                       <?php 
                        $file = $user['photo']."=".$user['other_photo'];
                        $expodefile = explode("=",$file); 
                        $fileActualExt= array();
                         for ($i=0; $i < count($expodefile); ++$i) { 
                             $fileActualExt[]= strtolower(substr($expodefile[$i],-3));
                         }
                         $allower_ext = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
             if (array_diff($fileActualExt,$allower_ext) == false) {
                        $file = $user['photo']."=".$user['other_photo'];
                        $expode = explode("=",$file); 
                        $count = count($expode); ?>

               <?php if ($count < 4) { ?>

                         <?php 
                               $file = $user['photo']."=".$user['other_photo'];
                               $title= $user['photo_Title_main']."=".$user["photo_Title"];
                               $photo_title=  explode("=",$title);
                               $explode = explode("=",$file);
                               $splice= array_splice($explode,0,3);

                               for ($i=0; $i < count($splice); ++$i) { 
                                   ?>
                                   <div class="col-md-6 mt-2">
                                         <div class="imagefoodViewPopup more"  data-food="<?php echo $user["food_id"] ;?>">
                                         <img src="<?php echo BASE_URL_PUBLIC."uploads/food/".$splice[$i] ;?>"
                                             alt="Photo" >
                                         </div>
                                     <div class="h5"><i><?php echo $photo_title[$i]; ?></i></div>
                                   </div>
                             <?php } ?>

                  <?php }else if ($count > 4) { ?>

                            <?php 
                               $file = $user['photo']."=".$user['other_photo'];
                               $title= $user['photo_Title_main']."=".$user["photo_Title"];
                               $photo_title=  explode("=",$title);
                               $explode = explode("=",$file);
                               $splice= array_splice($explode,0,4);

                               for ($i=0; $i < count($splice); ++$i) { 
                                   ?>
                                   <div class="col-md-6 mt-2">
                                         <div class="imagefoodViewPopup more"  data-food="<?php echo $user["food_id"] ;?>">
                                         <img src="<?php echo BASE_URL_PUBLIC."uploads/food/".$splice[$i] ;?>"
                                             alt="Photo" >
                                         </div>
                                     <div class="h5"><i><?php echo $photo_title[$i]; ?></i></div>
                                   </div>
                             <?php } ?>
                            <span class="btn btn-primary imagefoodViewPopup  float-right" data-food="<?php echo $user["food_id"] ;?>" > View More photo  <i class="fa fa-picture-o"></i> >>> </span>
                  <?php } ?>
                  
               <?php } ?>
                   </div><!-- /.row -->
                </div><!-- /.card-body -->
                <div class="card-footer text-muted">
                    Footer
                </div><!-- /.card-footer -->
            </div>


           </div><!-- img-popup-body -->
        </div><!-- user-show-popup-box -->
    </div> <!-- Wrp4 -->
</div> <!-- apply-popup" -->
<script>
    	 $(document).ready(function() {
			$("#content-slider").lightSlider({
                loop:true,
                keyPress:true
            });
            $('#image-gallery').lightSlider({
                gallery:true,
                item:1,
                thumbItem:9,
                slideMargin: 0,
                speed:1500,
                auto:true,
                loop:true,
                onSliderLoad: function() {
                    $('#image-gallery').removeClass('cS-hidden');
                }  
            });
		});
    </script>
<?php } 