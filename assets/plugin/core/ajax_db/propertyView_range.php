<?php
include('../init.php');
$users->preventUsersAccess($_SERVER['REQUEST_METHOD'],realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

if(isset($_POST['price_range'])){
    $user_id= $_POST['user_id'];
    $pages = $_POST['pages'];
    // var_dump($_POST['price_range']);
    // $vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
    // $vowels = array("[", "]", "$");
    // $priceRange= str_replace($vowels,"", $_POST['price_range']);
    // var_dump(explode('-',$priceRange));
    if($pages === 0 || $pages < 1){
        $showpages = 0 ;
    }else{
        $showpages = ($pages*9)-9;
    }
    
    //Include database configuration file
    $priceRange= $_POST['price_range'];
    //set conditions for filter by price range
    $whereSQL = $orderSQL = '';
    if(!empty($priceRange)){
        $vowels = array("[", "]",",","Frw");
        // $vowels = array("[", "]","Frw");
        $priceRangeArr_= str_replace($vowels,"", $priceRange);
        $priceRangeArr= explode('-',$priceRangeArr_);
        $whereSQL = "WHERE price BETWEEN '".$priceRangeArr[0]."' AND '".$priceRangeArr[1]."'";
        $orderSQL = " ORDER BY price ASC ,rand() Desc Limit $showpages,9";
    }else{
        $orderSQL = " ORDER BY created DESC ,rand() Desc Limit $showpages,9";
    }
    
    //get product rows
    $query = $db->query("SELECT * FROM house H
            Left JOIN provinces P ON H. province = P. provincecode
            Left JOIN districts M ON H. districts = M. districtcode
            Left JOIN sectors T ON H. sector = T. sectorcode
            Left JOIN cells C ON H. cell = C. codecell
            Left JOIN vilages V ON H. village = V. CodeVillage $whereSQL $orderSQL"); 
            
    
    if($query->num_rows > 0){
        $priceRangeArr_= number_format($priceRangeArr[0]);
        $priceRangeArrs= number_format($priceRangeArr[1]);
        echo "<h4 style='padding: 0px 10px;text-align:center;'>FROM <span style='color:black;'> $priceRangeArr_ Frw </span> TO <span style='color:black;'> $priceRangeArrs Frw</span> </h4> "; 
        ?>
        <div class="row"> 
      
        <?php 
        while ($houses = $query->fetch_array()) { ?>

       <div class="col-md-4 col-lg-4">
       <div class="single_property bg-light">
           <div class="property_thumb">
               <?php if ($houses['buy'] == "sale") { ?>
                   <div class="property_tag">
                           For Sale
                   </div>
                   <?php }else if ($houses['buy'] == "rent") { ?>
                       <div class="property_tag bg-success">
                               For Rent
                       </div>
                   <?php }else {  ?>
                       <div class="property_tag red">
                                Sold
                       </div>
               <?php } ?>
               <?php 
               // echo $this->banner($houses['banner']) ;
                       $file = $houses['photo']."=".$houses['other_photo'];
                                       $expode = explode("=",$file);  ?>
               <img src="<?php echo BASE_URL.'uploads/house/'.$expode[0]; ?>" alt="">
           </div>
           <div class="property_content">
               <div class="main_pro">
                       <?php echo $house->edit_delete_house($user_id,$houses['user_id3'],$houses['house_id']); ?>
                       <h3><a href="javascript:void(0)" id="house-readmore" data-house="<?php echo $houses['house_id']; ?>">
                               <?php 
                                   $subect = $houses['categories_house'];
                                   $replace = " ";
                                   $searching = "_";
                                   echo str_replace($searching,$replace, $subect);
                                   ?>
                       </a>
                       <span class="h6 text-success text-uppercase ml-2"><?php echo $houses['equipment']; ?></span>
                       </h3>
                       <div class="mark_pro">
                           <!-- <img src="<?php echo BASE_URL; ?>assets/icon/svg_icon/location.svg" alt=""> -->
                           <span>
                           <a class="properties-location" href="javascript:void(0)" id="house-readmore" data-house="<?php echo $houses['house_id']; ?>" ><i class="icon_pin"></i>
                           <?php echo $houses['namedistrict']; ?> / 
                           <?php echo $houses['namesector']; ?>
                           </a></span>
                       </div>
                       <span class="amount">
                           From:<span class="room-price price-change"> <?php echo number_format($houses['price']); ?> Frw
                           <?php  echo (substr($houses['categories_house'],-4) == 'sale')? '':'/month';?>
                           </span>
                           <?php if($houses['price_discount'] != 0){ ?>
                               
                           <div class="text-danger price-change" style="text-decoration: line-through;">
                           <?php echo number_format($houses['price_discount']); ?> Frw </div><?php } ?>
                       </span>
                       <?php if (isset($_SESSION['key'])) { ?>
                       <div class="text-muted clear-right" style="padding-bottom: 10px;">
                            <form method="post" id="form-housecartitem<?php echo $houses['code']; ?>add" class="float-right">
                                <div style="display:inline-flex;" >
                                    <input type="hidden" style="width:30px;" name="user_id" value="<?php echo $user_id; ?>" />
                                    <input type="hidden" style="width:30px;" name="actions" value="add" />
                                    <input type="hidden" style="width:30px;" name="code" value="<?php echo $houses['code']; ?>" />
                                    <input type="hidden" class="form-control form-control-sm text-center mr-2" style="width:30px;" name="quantitys" value="1" size="2" readonly/>
                                    <input type="button" onclick="xxda('add','<?php echo 'form-housecartitem'.$houses['code'].'add'; ?>','<?php echo $houses['code']; ?>');" value="Add to WatchList" class="btn btn-outline-success btn-sm " />
                                </div>
                            </form>
                        </div>
                        <?php } ?>

               </div>
               Publish <?php echo $house->timeAgo($houses['created_on3']); ?>
           </div>
           <div class="footer_pro">
               <ul>
                   <li>
                       <div class="single_info_doc">
                           <img src="<?php echo BASE_URL; ?>assets/icon/svg_icon/bed.svg" alt="">
                           <span><?php echo $houses['bedroom']; ?> Bed</span>
                       </div>
                   </li>
                   <li>
                       <div class="single_info_doc">
                           <img src="<?php echo BASE_URL; ?>assets/icon/svg_icon/bath.svg" alt="">
                           <span><?php echo $houses['bathroom']; ?>  Bath</span>
                       </div>
                   </li>
                   <li>
                       <div class="single_info_doc">
                       <i class="fa fa-car"></i>
                           <!-- <img src="< ?php echo BASE_URL; ?>assets/icon/svg_icon/car.png" alt=""> -->
                           <span><?php echo $houses['car_in_garage']; ?>  car</span>
                       </div>
                   </li>
               </ul>
           </div>
       </div>
       <!-- single_property -->
       </div>
   <!-- col -->

   <?php }

    echo '</div>';
                     
        $query1= $db->query("SELECT COUNT(*) FROM house $whereSQL ");
        $row_Paginaion = $query1->fetch_array();
        $total_Paginaion = array_shift($row_Paginaion);
        $post_Perpages = $total_Paginaion/9;
        $post_Perpage = ceil($post_Perpages); ?> 


        <?php if($post_Perpage > 1){ ?>
         <nav>
             <ul class="pagination justify-content-center mt-3">
                 <?php if ($pages > 1) { ?>
                     <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="houseRangeLayout('<?php echo $priceRange; ?>',<?php echo $pages-1; ?>,<?php echo $user_id; ?>)">Previous</a></li>
                 <?php } ?>
                 <?php for ($i=1; $i <= $post_Perpage; $i++) { 
                         if ($i == $pages) { ?>
                      <li class="page-item active"><a href="javascript:void(0)"  class="page-link" onclick="houseRangeLayout('<?php echo $priceRange; ?>',<?php echo $i; ?>,<?php echo $user_id; ?>)" ><?php echo $i; ?> </a></li>
                      <?php }else{ ?>
                     <li class="page-item"><a href="javascript:void(0)"  class="page-link" onclick="houseRangeLayout('<?php echo $priceRange; ?>',<?php echo $i; ?>,<?php echo $user_id; ?>)" ><?php echo $i; ?> </a></li>
                 <?php } } ?>
                 <?php if ($pages+1 <= $post_Perpage) { ?>
                     <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="houseRangeLayout('<?php echo $priceRange; ?>',<?php echo $pages+1; ?>,<?php echo $user_id; ?>)">Next</a></li>
                 <?php } ?>
             </ul>
         </nav>
        <?php } 

    }else{
        $priceRangeArr_= number_format($priceRangeArr[0]);
        $priceRangeArrs= number_format($priceRangeArr[1]);
        echo "<h4 style='padding: 0px 10px;text-align:center;'>FROM <span style='color:black;'> $priceRangeArr_ Frw </span> TO <span style='color:black;'> $priceRangeArrs Frw</span> </h4> "; 
        echo 'House(s) not found';
        // echo 'Product(s) not found';
    }

}


?>