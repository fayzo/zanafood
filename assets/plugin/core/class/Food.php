<?php 
 if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])){
       header('Location: ../../404.html');
 }

class Food extends home {

     public function foodcart_item(){

        $mysqli= $this->database;
        $db_handle = $mysqli;
        if(!empty($_POST["actions"])) {
        switch($_POST["actions"]) {
        	case "add":
        		if(!empty($_POST["quantitys"])) {
        			$productByCode = $this->runQuery("SELECT * FROM food WHERE code='" . $_POST["code"] . "'");
        			$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["photo_Title_main"], 'code'=>$productByCode[0]["code"], 'user_id'=>$_POST["user_id"], 'quantitys'=>$_POST["quantitys"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["photo"], 'food_id'=>$productByCode[0]["food_id"], 'user_id3'=>$productByCode[0]["user_id3"], 'categories'=>$productByCode[0]["categories_food"]));
        			if(!empty($_SESSION["foodcart_item"])) {    
        				if(in_array($productByCode[0]["code"],array_keys($_SESSION["foodcart_item"]))) {
        					foreach($_SESSION["foodcart_item"] as $k => $v) {
        							if($productByCode[0]["code"] == $k) {
        								if(empty($_SESSION["foodcart_item"][$k]["quantitys"])) {
        									$_SESSION["foodcart_item"][$k]["quantitys"] = 0;
                                        }
                                        $_SESSION["foodcart_item"][$k]["quantitys"] += $_POST["quantitys"];
                                        
                                        foreach($_SESSION["foodcart_item"] as $k => $v) {
                                            $price = $_SESSION["foodcart_item"][$k]["price"]*$_SESSION["foodcart_item"][$k]["quantitys"];
                                            // var_dump($itemArray[$k]["house_id"],$itemArray[$k]["code"]);
                                            $this->updateQuery('food_watchlist',array(
                                                'food_id_list' => $_SESSION["foodcart_item"][$k]["food_id"], 
                                                'user_id3_list' => $_POST["user_id"],  
                                                'categories'=> $_SESSION["foodcart_item"][$k]["categories"], 
                                                'price'=> $price,  
                                                'status_food' => '0',
                                            ),array(
                                                'food_id_list' => $_SESSION["foodcart_item"][$k]["food_id"],
                                                'code' => $_SESSION["foodcart_item"][$k]["code"],  
                                                'user_id3_list' => $_POST["user_id"],
                                             ));  
                                        }

        							}
        					}
        				} else {
                            foreach($itemArray as $k => $v) {
                                // var_dump($itemArray[$k]["house_id"],$itemArray[$k]["code"]);
                                $this->insertQuery('food_watchlist',array(
                                    'food_id_list' => $itemArray[$k]["food_id"], 
                                    'user_id3_list' => $_POST["user_id"],  
                                    'code' => $itemArray[$k]["code"],  
                                    'categories'=> $itemArray[$k]["categories"],  

                                    'photo_Title_main_list'=> $itemArray[$k]["name"],  
                                    'photo_list'=> $itemArray[$k]["image"],  
                                    'quantitys'=> $itemArray[$k]["quantitys"],  
                                    'unit_price'=> $itemArray[$k]["price"],  

                                    'price'=> $itemArray[$k]["price"],  
                                    'status_food' => '0',
                                ));  
                            }
        					$_SESSION["foodcart_item"] = array_merge($_SESSION["foodcart_item"],$itemArray);
        				}
        			} else {
                        foreach($itemArray as $k => $v) {
                            // var_dump($itemArray[$k]["house_id"],$itemArray[$k]["code"]);
                            $this->insertQuery('food_watchlist',array(
                                'food_id_list' => $itemArray[$k]["food_id"], 
                                'user_id3_list' => $_POST["user_id"],  
                                'code' => $itemArray[$k]["code"],  
                                'categories'=> $itemArray[$k]["categories"],  
                                
                                'photo_Title_main_list'=> $itemArray[$k]["name"],  
                                'photo_list'=> $itemArray[$k]["image"],  
                                'quantitys'=> $itemArray[$k]["quantitys"],  
                                'unit_price'=> $itemArray[$k]["price"],  

                                'price'=> $itemArray[$k]["price"],  
                                'status_food' => '0',
                            ));  
                        }
        				$_SESSION["foodcart_item"] = $itemArray;
        			}
                }
             exit($this->FoodshowCart_itemSale());
                
        	break;
            case "remove":
                $productByCode = $this->runQuery("SELECT * FROM food_watchlist WHERE code='" . $_POST["code"] . "' AND user_id3_list='" . $_POST["user_id"] . "'");
                $itemArray = array($productByCode[0]["code"]=>array('food_watchlist_id'=>$productByCode[0]["food_watchlist_id"], 'code'=>$productByCode[0]["code"]));

        		if(!empty($_SESSION["foodcart_item"])) {
        			foreach($itemArray as $k => $v) {

                            $this->delete('food_watchlist',array(
                                'food_watchlist_id' =>  $itemArray[$k]["food_watchlist_id"], 
                            ));

        					if($_POST["code"] == $k)
        						unset($_SESSION["foodcart_item"][$k]);				
        					if(empty($_SESSION["foodcart_item"]))
        						unset($_SESSION["foodcart_item"]);
        			}
                }
             exit($this->FoodshowCart_itemSale());
        	break;
        	case "empty":
        		unset($_SESSION["foodcart_item"]);
        	break;	
        }
        }
    }

     public function FoodshowCart_item(){

        if(isset($_SESSION["foodcart_item"])){
                $total_quantitys = 0;
                $total_price = 0;
            ?>	
            <table class="tbl-cart table table-responsive-sm table-hover table-bordered bg-light"  cellpadding="10" cellspacing="1">
            <thead class="main-active">
            <tr>
            <th style="text-align:left;">Name</th>
            <th style="text-align:left;">Code</th>
            <th style="text-align:right;" width="5%">quantitys</th>
            <th style="text-align:right;" width="10%">Unit Price</th>
            <th style="text-align:right;" width="10%">Price</th>
            <th style="text-align:center;" width="5%">Remove</th>
            </tr>	
             </thead>
            <tbody>
            <?php		
                foreach ($_SESSION["foodcart_item"] as $item){
                    $item_price = $item["quantitys"]*$item["price"];
            		?>
            				<tr>
            				<td><img src="<?php echo BASE_URL ;?>uploads/food/<?php echo $item["image"]; ?>" height='80px' width='80px' class="cart-item-image" /><?php echo $item["name"]; ?></td>
            				<td><?php echo $item["code"]; ?></td>
            				<td style="text-align:right;"><?php echo $item["quantitys"]; ?></td>
            				<td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
            				<td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
            				<td style="text-align:center;">
                                <form method="post" id="form-foodcartitem<?php echo $item['code']; ?>remove" >
                                    <input type="hidden" style="width:30px;" name="user_id" value="<?php echo $item['user_id']; ?>" />
                                    <input type="hidden" style="width:30px;" name="actions" value="remove" />
                                    <input type="hidden" style="width:30px;" name="code" value="<?php echo $item['code']; ?>" />
                                    <a href="javascript:void(0);" onclick="xxda('remove','<?php echo 'form-foodcartitem'.$item['code'].'remove'; ?>','<?php echo $item['code']; ?>');"><img src="<?php echo BASE_URL_LINK ;?>image/product-images/icon-delete.png" alt="Remove Item" /></a> 
                                </form>
                                <!-- <a href="food.php?actions=remove&code=< ?php echo $item["code"]; ?>" class="btnRemoveactions"><img src="< ?php echo BASE_URL_LINK ;?>image/product-images/icon-delete.png" alt="Remove Item" /></a> -->
                            </td>
            				</tr>
            				<?php
            				$total_quantitys += $item["quantitys"];
            				$total_price += ($item["price"]*$item["quantitys"]);
            		}
            		?>
            
            <tr>
            <td colspan="2" align="right">Total:</td>
            <td align="right"><?php echo $total_quantitys; ?></td>
            <td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
            <td></td>
            </tr>
            </tbody>
            </table>		
              <?php
            } else {
            ?>
            <div class="no-records">Your Cart is Empty</div>
            <?php 
            } 
	}
	
    public function FoodshowCart_itemSale(){

        if(isset($_SESSION["foodcart_item"])){
                $total_quantitys = 0;
                $total_price = 0;
            // var_dump(count($_SESSION["foodcart_item"]));
            ?>	
            <table class="table table-responsive-sm table-hover table-bordered bg-light mb-0" id="foodshowcart">
             <thead class="main-active">
               <tr>
               <th style="text-align:center;">Products</th>
               <th style="text-align:center;">Price</th>
               <th style="text-align:center;">Remove</th>
			   </tr>	
			 </thead>
             <tbody>
            <?php		
                foreach ($_SESSION["foodcart_item"] as $item){
                    $item_price = $item["quantitys"]*$item["price"];
            		?>
            		<tr>
                    <td style="background: url('<?php echo BASE_URL ;?>uploads/food/<?php echo $item["image"]; ?>')no-repeat center center;background-size:contain;height:80px;width:80px;position:relative">
                    <div style="position:absolute;bottom:0px;left:0px;background-color:#0000006e;color:white;width: 100%;"><?php
                    if (strlen($item["name"]) > 12) {
                      echo $item["name"] = substr($item["name"],0,12).'..';
                    }else{
                      echo $item["name"];
                    } ?></div>
                    </td>
            				<td align="right"><?php echo "$ ". number_format($item_price); ?></td>
            				<td align="center">
                                <form method="post" id="form-foodcartitem<?php echo $item['code']; ?>remove" >
                                         <input type="hidden" style="width:30px;" name="user_id" value="<?php echo $item['user_id']; ?>" />
                                        <input type="hidden" style="width:30px;" name="actions" value="remove" />
                                        <input type="hidden" style="width:30px;" name="code" value="<?php echo $item['code']; ?>" />
                                        <a href="javascript:void(0);" onclick="xxda('remove','<?php echo 'form-foodcartitem'.$item['code'].'remove'; ?>','<?php echo $item['code']; ?>');"><img src="<?php echo BASE_URL_LINK ;?>image/product-images/icon-delete.png" alt="Remove Item" /></a> 
                                </form>
                            </td>
            				</tr>
            				<?php
            				$total_quantitys += $item["quantitys"];
            				$total_price += ($item["price"]*$item["quantitys"]);
            		}
            		?>
            
            <tr>
            <td>Total:</td>
            <td align="left" colspan="2"><strong><?php echo "$ ".number_format($total_price); ?></strong></td>
            </tr>
            <tr>
                <td align="center" colspan="3"><a href="#" class="btn btn-primary btn-block-lg">Proceed</a></li>
            </tr>		
            </tbody>
            </table>		
              <?php
            } else {
            ?>
            <div class="no-records">Your Cart is Empty</div>
            <?php 
            } 
    }

    public function FoodshowCart_itemNavbar(){

        if(isset($_SESSION["foodcart_item"])){
                $total_quantitys = 0;
                $total_price = 0;
            // var_dump(count($_SESSION["foodcart_item"]));
            ?>
            <li>
            <span id="responseSubmitfooditerm"> </span>
            <div id="responseSubmitfooditermview">
            <div class="large-2">
            
            <table class="table table-responsive-sm table-hover table-bordered bg-light mb-0" id="foodshowcart">
             <thead class="main-active">
               <tr>
               <th style="text-align:center;">Products</th>
               <th style="text-align:center;">Price</th>
               <th style="text-align:center;">Remove</th>
			   </tr>	
			 </thead>
             <tbody>
            <?php		
                foreach ($_SESSION["foodcart_item"] as $item){
                    $item_price = $item["quantitys"]*$item["price"];
            		?>
            		<tr>
                    <td style="background: url('<?php echo BASE_URL ;?>uploads/food/<?php echo $item["image"]; ?>')no-repeat center center;background-size:contain;height:80px;width:80px;position:relative">
                    <div style="position:absolute;bottom:0px;left:0px;background-color:#0000006e;color:white;width: 100%;"><?php
                    if (strlen($item["name"]) > 12) {
                      echo $item["name"] = substr($item["name"],0,12).'..';
                    }else{
                      echo $item["name"];
                    } ?></div>
                    </td>
            				<td align="right"><?php echo "$ ". number_format($item_price); ?></td>
            				<td align="center">
                                <form method="post" id="form-foodcartitem<?php echo $item['code']; ?>remove" >
                                         <input type="hidden" style="width:30px;" name="user_id" value="<?php echo $item['user_id']; ?>" />
                                        <input type="hidden" style="width:30px;" name="actions" value="remove" />
                                        <input type="hidden" style="width:30px;" name="code" value="<?php echo $item['code']; ?>" />
                                        <a href="javascript:void(0);" onclick="xxda('remove','<?php echo 'form-foodcartitem'.$item['code'].'remove'; ?>','<?php echo $item['code']; ?>');"><img src="<?php echo BASE_URL_LINK ;?>image/product-images/icon-delete.png" alt="Remove Item" /></a> 
                                </form>
                            </td>
            				</tr>
            				<?php
            				$total_quantitys += $item["quantitys"];
            				$total_price += ($item["price"]*$item["quantitys"]);
            		}
            		?>
            
            </tbody>
            </table>
            </div>
            
            <table class="table table-bordered bg-light mb-0">
            <tbody>
                <tr>
                    <td width="80px">Total:</td>
                    <td align="left" colspan="2"><strong><?php echo "$ ".number_format($total_price); ?></strong></td>
                </tr>		
                <tr>
                    <td align="center" colspan="3"><a href="#" class="btn btn-primary btn-block-lg">Proceed</a></li>
                </tr>		
            </tbody>
            </table>
            </div>

            </li>		
              <?php
            } else {
            ?>
            <div class="no-records">Your Cart is Empty</div>
            <?php 
            } 
    }


    public function property_navListHome($categories,$pages,$user_id){ ?>

            
        <div class="property-navs border rounded" style="text-align: center;background:#f7f7f7;padding:10px 0 0;margin-bottom: 25px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="main-menus">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#House_For_sale" onclick="foodCategories('food',1,<?php echo $user_id ; ?>);">food<span class="badge badge-primary"><?php echo $this->foodcountPOSTS('food');?></span></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#House_For_rent" onclick="foodCategories('drink',1,<?php echo $user_id ; ?>);">beverage<span class="badge badge-primary"><?php echo $this->foodcountPOSTS('drink');?></span></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#House_For_rent" onclick="foodCategories('fruits',1,<?php echo $user_id ; ?>);">fruits<span class="badge badge-primary"><?php echo $this->foodcountPOSTS('fruits');?></span></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#House_For_rent" onclick="foodCategories('vegetables',1,<?php echo $user_id ; ?>);">vegetable<span class="badge badge-primary"><?php echo $this->foodcountPOSTS('vegetables');?></span></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#House_For_rent" onclick="foodCategories('macedone',1,<?php echo $user_id ; ?>);">macedone<span class="badge badge-primary"><?php echo $this->foodcountPOSTS('macedone');?></span></a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="col-lg-12 mt-3">
                         <div class="price-range-wrap">
                            <div class="price-text">
                                <label for="priceRange">Price:</label>
                                <input type="hidden" class="price_range-user_id" value="<?php echo $user_id; ?>" />
                                <!-- <input type="text" id="priceRange" value="0,100000000" readonly> -->
                                <input type="text" style="color:black" id="priceRange" readonly>
                            </div>
                            <div id="price-range" class="slider"></div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    <?php }


     public function foodList($categories,$pages,$user_id)
    {
        $pages= $pages;
        $categories= $categories;
        
        if($pages === 0 || $pages < 1){
            $showpages = 0 ;
        }else{
            $showpages = ($pages*10)-10;
        }
        $mysqli= $this->database;
        $query= $mysqli->query("SELECT * FROM food WHERE categories_food ='$categories' ORDER BY discount > 50 ,rand() Desc Limit $showpages,10");
        ?>
         <div id="food-hides" > 

        <div class="tab-content">
        <div class="active tab-pane" id="<?php echo $categories; ?>">
        

        <div class="property-list" id="property-list">
        <?php if ($query->num_rows > 0) {
                                            ?>
        <div class="timeline">

        <?php while($food= $query->fetch_array()) { ?>
                     
        <div class="single-property-item ">

            <?php echo $this->buychangesColor($food['buy']); ?>
            <!-- <i class="bg-success text-light require" >Sale </i> -->
            <i class="fa fa-user"></i>

            <?php if($food['discount'] != 0){ ?>
            <?php echo $this->PercentageDiscount($food['discount']); ?>
            <?php }else { echo ''; ?>
                <!-- <span class="bg-info text-light" > 0% </span>  -->
            <?php } ?>

            <div class="row timeline-item">

                <div class="col-md-4 px-0">
                        <?php echo $this->banner($food['banner']) ; ?>
                    <div class="property-pic"> 
                        <?php   $file = $food['photo']."=".$food['other_photo'];
                                $expode = explode("=",$file);  ?>
                        
                        <a href="javascript:void(0)" id="food-readmore"  data-food="<?php echo $food['food_id']; ?>" >
                            <img class="propertyPicture"  src="<?php echo BASE_URL.'uploads/food/'.$expode[0]; ?>" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-md-8">
                <div id="response<?php echo $food['food_id']; ?>"></div>
                    <div class="property-text" >
                        <!-- <div class="s-text">For Sale</div> -->
                        <!-- < ?php echo $this->edit_delete_food($user_id,$food['user_id3'],$food['food_id']); ?> -->
                        
                        <h5 class="r-title" style="display: inline-block;">
                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                            <?php 
                            $subect = $food['categories_food'];
                            $replace = " ";
                            $searching = "_";
                            echo str_replace($searching,$replace, $subect);
                            ?>
                        </h5> |
                        
                        <!-- <span class="h6 text-success text-uppercase ml-2">< ?php echo $food['equipment']; ?></span> -->
                        <?php if (isset($_SESSION['key_food'])) { ?>
                                
                                <form method="post" id="form-foodcartitem<?php echo $food['code']; ?>add" class="float-right">
                                    <div style="display:inline-flex;" >
                                        <input type="hidden" style="width:30px;" name="user_id" value="<?php echo $user_id; ?>" />
                                        <input type="hidden" style="width:30px;" name="actions" value="add" />
                                        <input type="hidden" style="width:30px;" name="code" value="<?php echo $food['code']; ?>" />
                                        <input type="text" class="form-control form-control-sm text-center mr-2" style="width:30px;" name="quantitys" value="1" size="2" readonly/>
                                        <input type="button" onclick="xxda('add','<?php echo 'form-foodcartitem'.$food['code'].'add'; ?>','<?php echo $food['code']; ?>');" value="Add to Cart" class="btn btn-outline-success btn-sm " />
                                    </div>
                                </form>
                        <?php } ?>
                        <div style="margin-bottom: 10px;clear:-left"> From:<span class="room-price price-change"> <?php echo number_format($food['price']); ?> Frw
                            </span>
                            <?php if($food['price_discount'] != 0){ ?>
                                
                            <span class="text-danger price-change" style="text-decoration: line-through;">
                            <?php echo number_format($food['price_discount']); ?> Frw </span> <?php } ?>
                        </div>
                        <a class="text-primary float-left" href="javascript:void(0)" id="food-readmore" data-food="<?php echo $food['food_id']; ?>" ><?php echo $food['photo_Title_main']; ?></a>
                               <?php if($user_id == $food['user_id3']){ ?>
                                    <ul class="list-inline ml-2  float-right" style="list-style-type: none;">  

                                            <li  class=" list-inline-item">
                                                <ul class="showcartButt" style="list-style-type: none; margin:0px;" >
                                                    <li>
                                                        <a href="javascript:void(0)" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                                                        <ul style="list-style-type: none; margin:0px; margin:0px;width:250px;text-align:center;" >
                                                            <li style="list-style-type: none; margin:0px;"> 
                                                            <label class="deletefood"  data-food="<?php echo $food["food_id"];?>"  data-user="<?php echo $food["user_id3"];?>">Delete </label>
                                                            </li>

                                                            <li style="list-style-type: none; margin:0px;"> 
                                                            <label for="">
                                                            <div class="form-row">
                                                                <div class="col">
                                                                        Banner
                                                                        <div class="input-group">
                                                                              <select class="form-control" name="banner" id="banner<?php echo $food["food_id"];?>">
                                                                                <option value="<?php echo $food['banner']; ?>" selected><?php echo $food['banner']; ?></option>
                                                                                <option value="new">New</option>
                                                                                <option value="new_arrival">New arrival</option>
                                                                                <option value="great_deal">Great deal</option>
                                                                                <option value="empty">empty</option>
                                                                              </select>
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text" style="padding: 0px 10px;" aria-label="Username" aria-describedby="basic-addon1" >banner</span>
                                                                            </div>
                                                                        </div> <!-- input-group -->
                                                                </div>
                                                            </div>
                                                            </label>
                                                            </li>

                                                          <li style="list-style-type: none; margin:0px;"> 
                                                            <label for="">
                                                            <div class="form-row">
                                                                <div class="col">
                                                                    discount %
                                                                    <div class="input-group">
                                                                        <input  type="number" class="form-control form-control-sm" name="discount_change" id="discount_change<?php echo $food["food_id"];?>" value="<?php echo $food["discount"];?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text" style="padding: 0px 10px;" aria-label="Username" aria-describedby="basic-addon1" >%</span>
                                                                        </div>
                                                                    </div> <!-- input-group -->
                                                                </div>
                                                            </div>
                                                            </label>
                                                            </li>
                                                            
                                                            <li style="list-style-type: none;"> 
                                                            <label for="discount">
                                                            <div class="form-row">
                                                                <div class="col">
                                                                    discount price
                                                                    <div class="input-group">
                                                                        <input  type="number" class="form-control form-control-sm" name="discount_price" id="discount_price<?php echo $food["food_id"];?>" value="<?php echo $food["price_discount"];?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text" style="padding: 0px 10px;" aria-label="Username" aria-describedby="basic-addon1">$</span>
                                                                        </div>
                                                                    </div> <!-- input-group -->
                                                                </div>
                                                                <div class="col">
                                                                        Price
                                                                    <div class="col">
                                                                        </div>
                                                                    <div class="input-group">
                                                                        <input  type="number" class="form-control form-control-sm" name="price" id="price<?php echo $food["food_id"];?>" value="<?php echo $food["price"];?>">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text" style="padding: 0px 10px;"
                                                                                aria-label="Username" aria-describedby="basic-addon1" >$</span>
                                                                        </div>
                                                                    </div> <!-- input-group -->
                                                                </div>
                                                            </div>
                                                            </label>
                                                            </li>

                                                            <li style="list-style-type: none;"> 
                                                            <label for="discount" class="update-food-btn" data-food="<?php echo $food["food_id"];?>" data-user="<?php echo $food["user_id3"];?>">submit</label>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                    </ul>
                                <?php } ?>
                               <!-- <span class="float-right"><span class="text-primary" > < ?php echo number_format($food['price']); ?> Frw</span></span> -->
                            </div> 
                           
                            <div class="text-muted clear-float">
                                <span> <i class="fa fa-clock-o mt-1" aria-hidden="true"></i> Created on <?php echo $this->timeAgo($food['created_on3']); ?></span>
                            </div>
                            <p class="card-text clear-float">200 m square feet Garden,4 bedroom,2 bathroom, kitchen and cabinet, car parking dapibuseget quame... Continue reading... </p>

                </div>
                </div>
            </div>
           <?php   }

                    $query1= $mysqli->query("SELECT COUNT(*) FROM food WHERE categories_food ='$categories' ");
                    $row_Paginaion = $query1->fetch_array();
                    $total_Paginaion = array_shift($row_Paginaion);
                    $post_Perpages = $total_Paginaion/10;
                    $post_Perpage = ceil($post_Perpages); ?>    
                 <!-- END timeline item -->
            <div class="single-property-item ">
                <i class="fa fa-clock-o bg-info text-light"></i>
            </div>
    </div>
    <?php 

        if($post_Perpage > 1){ ?>
         <nav>
             <ul class="pagination justify-content-center mt-3">
                 <?php if ($pages > 1) { ?>
                     <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="foodCategories('<?php echo $categories; ?>',<?php echo $pages-1; ?>)">Previous</a></li>
                 <?php } ?>
                 <?php for ($i=1; $i <= $post_Perpage; $i++) { 
                         if ($i == $pages) { ?>
                      <li class="page-item active"><a href="javascript:void(0)"  class="page-link" onclick="foodCategories('<?php echo $categories; ?>',<?php echo $i; ?>)" ><?php echo $i; ?> </a></li>
                      <?php }else{ ?>
                     <li class="page-item"><a href="javascript:void(0)"  class="page-link" onclick="foodCategories('<?php echo $categories; ?>',<?php echo $i; ?>)" ><?php echo $i; ?> </a></li>
                 <?php } } ?>
                 <?php if ($pages+1 <= $post_Perpage) { ?>
                     <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="foodCategories('<?php echo $categories; ?>',<?php echo $pages+1; ?>)">Next</a></li>
                 <?php } ?>
             </ul>
         </nav>
        <?php } 
        
    }else{
        echo ' <div class="col-md-12 col-lg-12"><div class="alert alert-danger alert-dismissible fade show text-center">
                <button class="close" data-dismiss="alert" type="button">
                    <span>&times;</span>
                </button>
                <strong>No Record</strong>
            </div>'; 
    }

    echo '</div>
    </div>
    </div>
    </div>';
    }

    public function foodcountAgentPOSTS($categories,$id)
    {
        $db =$this->database;
        $sql= $db->query("SELECT COUNT(*) FROM food WHERE categories_food ='$categories' ");
        $row_post = $sql->fetch_array();
        $total_post= array_shift($row_post);
        $array= array(0,$total_post);
        $total_posts= array_sum($array);
        echo $total_posts;
    }

    public function edit_delete_foodEdit($variable,$id){ ?>

        <table class="table table-responsive-sm table_adminLA table-hover ">
            <thead class="main-active">
                <tr>
                    <th>N0</th>
                    <th class="text-center">
                        <i class="icon-people"></i>
                    </th>
                    <th>PRICE/Food</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>

            <?php switch ($variable) {
                case $variable :
                    # code... ?>
                    <?php 
                            $increment= 1;
                            $mysqli= $this->database;
                            $result= $mysqli->query("SELECT * FROM food WHERE categories_food= '$variable'");
                        if ($result->num_rows > 0) {
                            while($row= $result->fetch_array()){ ?>
                       <tr id="food_n<?php echo $row['food_id']; ?>">
                            <td><?php echo  $increment++ ; ?></td>
                            <td class="text-center">
                                <div class="avatar">
                                    <?php
                                    $file = $row['photo'];
                                    $expode = explode("=",$file);  ?>
                                    <img class="img-avatar" width="80px" 
                                        src="<?php echo BASE_URL.'uploads/food/'.$expode[0]; ?>" alt="">
                                </div>
                            </td>
                            <td>
                                <div><?php echo number_format($row['price']); ?> Frw 
                                    </div>
                                    <div> <?php echo $this->buychangesColor($row['buy']); ?></div>
                                    <?php if($row['price_discount'] != 0){ ?>
                                    <div class="text-danger price-change" style="text-decoration: line-through;">
                                        <?php echo number_format($row['price_discount']); ?> Frw 
                                    </div> 
                                <?php } ?>
                                <?php 
                                    $subect = $row['categories_food'];
                                    $replace = " ";
                                    $searching = "_";
                                    echo str_replace($searching,$replace, $subect);
                                ?>
                                <!-- <div class="text-danger price-change">< ?php echo $row['equipment']; ?></div> -->
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="javascript:void(0)" onclick="viewOReditHouses(<?php echo $row['food_id'];?>, 'EditHouseAdmin')"   class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    <a href="javascript:void(0)" id="food-readmore" data-food="<?php echo $row['food_id']; ?>" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="javascript:void(0)" onclick="deleteRow(<?php echo $row['food_id'];?>,'deleteRowfood')" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                <?php 
                     } }else{ 
                       # code...  ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>No record</td>
                            <td></td>
                        </tr>
                    <?php    }
                break;
            } ?>
                    </tbody>
                </table>

<?php   }

public function agent_profile_viewProfile($user_id){ ?>

    <div class="col-md-3 mb-2">

        <?php 
            $mysqli= $this->database;
            $result =$mysqli->query("SELECT * FROM users WHERE register_as ='Agent' and user_id= $user_id " );
            
            while ($user= $result->fetch_array()) { ?>

                <!-- Profile Image -->
                <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                    Chef de cuisine
                    </div>
                    <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                        <h2 class="lead"><b><?php echo $user['firstname']." ".$user['lastname']; ?></b></h2>
                        <!-- <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p> -->
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"><i class="fa fa-lg fa-building"></i></span> Address: <?php echo $user['location']; ?></li>
                            <li class="small"><span class="fa-li"><i class="fa fa-lg fa-phone"></i></span> Phone : <?php echo $user['telephone']; ?></li>
                        </ul>
                        </div>
                        <div class="col-5 text-center single-agent-profile">
                            <div class="sa-pic">
                                <?php if (!empty($user['profile_img'])) { ?>
                                    <img src="<?php echo BASE_URL_LINK."image/users_profile_cover/".$user['profile_img'] ;?>" alt="" class="img-circle img-fluid" alt="User Image" >
                                <?php  }else{ ?>
                                    <img src="<?php echo BASE_URL_LINK.NO_PROFILE_IMAGE;?>" alt="User Image" class="img-circle img-fluid">
                                <?php } ?>
                                <!-- <img src="< ?php echo BASE_URL;?>assets/image/img/agent/agent-1.jpg" alt="" class="img-circle img-fluid"> -->
                                <div class="hover-social">
                                    <a href="<?php echo TWITTER.$user['twitter']; ?>" class="twitter"><i class="fa fa-twitter"></i></a>
                                    <a href="<?php echo INSTAGRAM.$user['instagram']; ?>" class="instagram"><i class="fa fa-instagram"></i></a>
                                    <a href="<?php echo FACEBOOK.$user['facebook']; ?>" class="facebook"><i class="fa fa-facebook"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="card-footer">
                    <div class="text-right">
                        <a href="javascript:void(0)" id="contacts_agent" data-user="<?php echo $user['user_id'];?>" class="btn btn-sm bg-teal">
                        <i class="fas fa-comments"></i> Message
                        </a>
                        <!-- <a href="< ?php echo BASE_URL.$user['username']; ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-user"></i> View Profile
                        </a> -->
                    </div>
                    </div>
                </div>
            <!-- card -->

    <?php  } ?>

     </div>
            <!-- col -->

<?php  }


      public function foodcountPOSTS($categories)
    {
        $db =$this->database;
        $sql= $db->query("SELECT COUNT(*) FROM food WHERE categories_food ='$categories' ");
        $row_post = $sql->fetch_array();
        $total_post= array_shift($row_post);
        $array= array(0,$total_post);
        $total_posts= array_sum($array);
        echo $total_posts;
    }


      public function foodReadmore($food_id)
    {
        $mysqli= $this->database;
        $query= $mysqli->query("SELECT * FROM users U Left JOIN food F ON F. user_id3 = u. user_id WHERE F. food_id = '$food_id' ");
        $row= $query->fetch_array();
        return $row;
    }

    function PercentageDiscount($variable)
    {

    switch ($variable) {
        case $variable <= 10 :
            # code...
            return '<span class="bg-danger text-light percertage" > '.$variable.'% </span> ';
            break;
        case $variable <= 20 :
            # code...
            return '<span class="bg-danger text-light percertage" > '.$variable.'% </span> ';
            break;
        case $variable <= 30 :
            # code...
            return '<span class="bg-info text-light percertage" > '.$variable.'% </span> ';
            break;
        case $variable <= 35:
            # code...
            return '<span class="bg-warning text-light percertage" > '.$variable.'% </span> ';
            break;
        case $variable <= 40:
            # code...
            return '<span class="bg-info text-light percertage" > '.$variable.'% </span> ';
            break;
        case $variable <= 50:
            # code...
            return '<span class="bg-success text-light percertage" > '.$variable.'% </span> ';
            break;
        case $variable <= 60:
            # code...
            return '<span class="bg-success text-light percertage" > '.$variable.'% </span> ';
            break;
        case $variable <= 75:
            # code...
            return '<span class="bg-success text-light percertage" > '.$variable.'% </span> ';
            break;
        default:
            # code...
            return '<span class="bg-success text-light percertage" > '.$variable.'% </span> ';
            break;
        }

    } 

     
    public function food_getPopupTweet($user_id,$food_id,$food_user_id)
    {
        $mysqli= $this->database;
        $result= $mysqli->query("SELECT * FROM users U Left JOIN food B ON B. user_id3 = u. user_id WHERE B. food_id = $food_id AND B. user_id3 = $food_user_id ");
        // var_dump('ERROR: Could not able to execute'. $query.mysqli_error($mysqli));
        while ($row= $result->fetch_array()) {
            # code...
            return $row;
        }
    }

    
    public function deleteFood($food_id)
    {
        $mysqli= $this->database;
        $query="DELETE H,A,W FROM food H 
                        LEFT JOIN agent_message A ON A. house_id_msg = H. food_id 
                        LEFT JOIN food_watchlist W ON W. food_id_list = H. food_id 
                        WHERE H. food_id = '{$food_id}' ";

        $query1="SELECT * FROM food WHERE food_id = $food_id ";

        $result= $mysqli->query($query1);
        $rows= $result->fetch_assoc();

        if(!empty($rows['photo'])){
            $photo=$rows['photo'].'='.$rows['other_photo'];
            $expodefile = explode("=",$photo);
            $fileActualExt= array();
            for ($i=0; $i < count($expodefile); ++$i) { 
                $fileActualExt[]= strtolower(substr($expodefile[$i],-3));
            }
            $allower_ext = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf' , 'doc' , 'ppt'); // valid extensions
            if (array_diff($fileActualExt,$allower_ext) == false) {
                $expode = explode("=",$photo);
                $uploadDir = DOCUMENT_ROOT.'/uploads/food/';
                for ($i=0; $i < count($expode); ++$i) { 
                      unlink($uploadDir.$expode[$i]);
                }
            }else if (array_diff($fileActualExt,$allower_ext)[0] == 'mp4') {
                $uploadDir = DOCUMENT_ROOT.'/uploads/food/';
                      unlink($uploadDir.$photo);
            }else if (array_diff($fileActualExt,$allower_ext)[0] == 'mp3') {
                $uploadDir = DOCUMENT_ROOT.'/uploads/food/';
                      unlink($uploadDir.$photo);
            }
        }

        $query= $mysqli->query($query);
        // var_dump("ERROR: Could not able to execute $query.".mysqli_error($mysqli));

        if($query){
                exit('<div class="alert alert-success alert-dismissible fade show text-center">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>SUCCESS DELETE</strong> </div>');
            }else{
                exit('<div class="alert alert-danger alert-dismissible fade show text-center">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>Fail to delete !!!</strong>
                </div>');
        }
    }
      
    public function deleteLikesfood($tweet_id)
    {
        $mysqli= $this->database;
        $query="DELETE B , L ,C ,R FROM events B 
                        LEFT JOIN events_like L ON L. like_on = B. events_id 
                        LEFT JOIN events_comment_like C ON C. like_on_ = B. events_id 
                        LEFT JOIN events_comment R ON R. comment_on = B. events_id 
                        WHERE B. events_id = '{$tweet_id}' and B. user_id3 = '{$user_id}' ";

        $query1="SELECT * FROM events WHERE events_id = $tweet_id and user_id3 = $user_id ";

        $result= $mysqli->query($query1);
        $rows= $result->fetch_assoc();

        if(!empty($rows['photo'])){
            $photo=$rows['photo'].'='.$rows['other_photo'];
            $expodefile = explode("=",$photo);
            $fileActualExt= array();
            for ($i=0; $i < count($expodefile); ++$i) { 
                $fileActualExt[]= strtolower(substr($expodefile[$i],-3));
            }
            $allower_ext = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf' , 'doc' , 'ppt'); // valid extensions
            if (array_diff($fileActualExt,$allower_ext) == false) {
                $expode = explode("=",$photo);
                $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/Blog_nyarwanda_CMS/uploads/events/';
                for ($i=0; $i < count($expode); ++$i) { 
                      unlink($uploadDir.$expode[$i]);
                }
            }else if (array_diff($fileActualExt,$allower_ext)[0] == 'mp4') {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/Blog_nyarwanda_CMS/uploads/events/';
                      unlink($uploadDir.$photo);
            }else if (array_diff($fileActualExt,$allower_ext)[0] == 'mp3') {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/Blog_nyarwanda_CMS/uploads/events/';
                      unlink($uploadDir.$photo);
            }
        }

        $query= $mysqli->query($query);
        // var_dump("ERROR: Could not able to execute $query.".mysqli_error($mysqli));

        if($query){
                exit('<div class="alert alert-success alert-dismissible fade show text-center">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>SUCCESS DELETE</strong> </div>');
            }else{
                exit('<div class="alert alert-danger alert-dismissible fade show text-center">
                    <button class="close" data-dismiss="alert" type="button">
                        <span>&times;</span>
                    </button>
                    <strong>Fail to delete !!!</strong>
                </div>');
        }
    }

    public function update_food($banner,$discount_change,$discount_price,$price,$food_id)
    {
        $mysqli= $this->database;
        $query= "UPDATE food SET banner= '$banner', discount = $discount_change ,price_discount = $discount_price, price = $price WHERE food_id= $food_id ";
        $mysqli->query($query);

        if($query){
                exit('<div class="alert alert-success alert-dismissible fade show text-center" style="font-size:12px;padding:2px;">
                    <button class="close" data-dismiss="alert" type="button" style="top:-6px;">
                        <span>&times;</span>
                    </button>
                    <strong>SUCCESS</strong> </div>');
            }else{
                exit('<div class="alert alert-danger alert-dismissible fade show text-center" style="font-size:12px;padding:2px;">
                    <button class="close" data-dismiss="alert" type="button"  style="top:-6px;">
                        <span>&times;</span>
                    </button>
                    <strong>Fail to Edit !!!</strong>
                </div>');
        }
    }

    public function buychangesColor($variable){

        switch ($variable) {
    
            case $variable === 'new' :
                # code...
                echo '<span class="bg-success p-1 text-light require" > new </span> ';
                break;
            case $variable === 'soon' :
                # code...
                echo '<span class="bg-danger p-1 text-light require" >soon</span> ';
                break;
    
            case $variable === 'available' :
                # code...
                echo '<span class="bg-success p-1 text-light require" >available</span> ';
                break;
    
             default:
                # code...
                echo '';
                break;
            }
        }
    
        public function banner($variable){
    
            $banner = $variable;
            switch ($banner) {
                case $banner == 'new':
                    # code...
                    echo '<img class="discount" style="margin-left: -10px;" src="'.BASE_URL_LINK.'image/img/banner/new.png" >';
                    break;
                case $banner == 'great-deal':
                    # code...
                    echo '<img class="discount" style="right:0px;" src="'.BASE_URL_LINK.'image/img/banner/great-deal.png">';
                    break;
                case $banner == 'great-deal1':
                    # code...
                    echo '<img class="discount" style="right:0px;" src="'.BASE_URL_LINK.'image/img/banner/great-deal1.png">';
                    break;
                case $banner == 'discount':
                    # code...
                    echo '<img class="discount" style="right:0px;" src="'.BASE_URL_LINK.'image/img/banner/discount.png">';
                    break;
                case $banner == 'new-arrival':
                    # code...
                    echo '<img class="discount" style="left:0px;" src="'.BASE_URL_LINK.'image/img/banner/new-arrival.png">';
                    break;
                 default:
                    # code...
                    echo '';
                    break;
            }
              
        }
    
        public function categoriesBanner($categories){ ?>
            
            <div class="single-property-item" style="margin-bottom: 0px;">
                <span class="banner" style="margin-left: -10px;"> <img src="<?php echo BASE_URL_LINK.'image/img/banner/discount.png' ;?>" width="80px"> </span>
                <!-- categories of house banner  -->
    
        <?php  switch ($categories) { 
                case $categories == 'House_For_sale':
                    # code...
                    echo '<img src="'.BASE_URL_LINK.'image/img/banner/banners1.png" width="200px">
                          <img style="margin-top:15px;margin-right:25px;" src="'.BASE_URL_LINK.'image/img/banner/weekPrice.png" width="200px">
                        ';
                    break;
                case $categories == 'House_For_rent':
                    # code...
                    echo '<img src="'.BASE_URL_LINK.'image/img/banner/photo1.png" width="200px">
                          <img style="margin-top:15px;margin-right:25px;" src="'.BASE_URL_LINK.'image/img/banner/weekPrice.png" width="200px">
                        ';
                    break;
                case $categories == 'Land_For_sale':
                    # code... 
                    echo '<img src="'.BASE_URL_LINK.'image/img/banner/photo2.png" width="200px">
                          <img style="margin-top:15px;margin-right:25px;" src="'.BASE_URL_LINK.'image/img/banner/weekPrice.png" width="200px">
                        ';
                    break;
                case $categories == 'Apartment_For_sale':
                    # code...
                    echo '<img src="'.BASE_URL_LINK.'image/img/banner/photo3.jpg" width="200px">
                          <img style="margin-top:15px;margin-right:25px;" src="'.BASE_URL_LINK.'image/img/banner/weekPrice.png" width="200px">
                        ';
                    break;
                case $categories == 'Apartment_For_rent':
                    # code...
                    echo '<img src="'.BASE_URL_LINK.'image/img/banner/photo4.jpg" width="200px">
                          <img style="margin-top:15px;margin-right:25px;" src="'.BASE_URL_LINK.'image/img/banner/weekPrice.png" width="200px">
                        ';
                    break;
                case $categories == 'Offices_stores':
                    # code...
                    echo '<img src="'.BASE_URL_LINK.'image/img/banner/photo4.jpg" width="200px">
                          <img style="margin-top:15px;margin-right:25px;" src="'.BASE_URL_LINK.'image/img/banner/weekPrice.png" width="200px">
                        ';
                    break;
                
            } ?>
            </div>
        <?php
        }
    


}

$food = new Food();
/*
===========================================
         Notice
===========================================
# You are free to run the software as you wish
# You are free to help yourself study the source code and change to do what you wish
# You are free to help your neighbor copy and distribute the software
# You are free to help community create and distribute modified version as you wish

We promote Open Source Software by educating developers (Beginners)
use PHP Version 5.6.1 > 7.3.20  
===========================================
         For more information contact
=========================================== 
Kigali - Rwanda
Tel : (250)787384312 / (250)787384312
E-mail : shemafaysal@gmail.com

*/
?>