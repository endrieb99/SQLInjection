<?php
   if(!isset($_SESSION)) { 
      session_start(); 
  }

  if(!(isset($_SESSION['cart']))){
      $_SESSION['cart'] = array(); 
  }

  $out = "";
  //buy
  if(isset($_GET['pID'])){
      $pID = $_GET['pID'];
      $quan = $_GET['quan'];

      if($quan > 0 && filter_var($quan, FILTER_VALIDATE_INT)) {
         if(isset($_SESSION['cart'][$pID])) {
            $_SESSION['cart'][$pID] += $quan;
         } else{
            $_SESSION['cart'][$pID] = $quan;
         }
      } else{
         $out = "Bad Input";
      }
  }

   $url_components = parse_url($_SERVER['REQUEST_URI']);

   if(!empty($url_components['query'])){
      require_once "protected/db/db.class.php";

      $db = new DB();
      parse_str($url_components['query'], $param);

      $product = $db->getProduct($param['id'])[0];

      $imgs = explode("|",$product->getImages());
   }

   $cartSize = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
   <head>
        <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Product Details</title>
        <link rel="stylesheet" href="css/index.css">
        <script src="js/default.js"></script> 
   </head>
   <body>
      <div class="container">
      <div><a href="/sql_injection/"> < Change section</a></div>
      <div class="navbar">
         <div class="nav">
            <ul id="menue-item">
               <li><a href="index.php">MARKETPLACE</a></li>
               <li><a href="index.php">Home</a></li>
               <li><a href="products.php" >Products</a></li>
               <?php
                  if(isset($_SESSION['loggedIn'])){
                     if($_SESSION['loggedIn'] == true) {
                        echo "<li><a href=\"user_info.php\">".$_SESSION['account_first_name']." ".$_SESSION['account_last_name']."</a></li>\n
                        <li><a id=\"btnLogOut\" href=\"#\">Logout</a></li>";
                     }
                  } else {
                     echo "<li><a href=\"login.php\">Login</a></li>";
                  }
               ?>
            </ul>
         </div>
         <a href="cart.php"><img src="images/cart.png" width="50px"height="50px"><p id="cartQuant"><?php echo $cartSize; ?></p></a>
          <img src="images/menu.png" class="menue-icon" onclick="menuetoggle();">
      </div>
      </div>
       <div class="small-container single-product">
            <?php 
               echo $out;
            ?>
            <div class="row">
               <div class="col-2">
                  <img src="<?php echo $imgs[0] ?>" width="100%" id="product-image">
                  <div class="small-img-row">
                  <?php 
                     foreach($imgs as $img) {
                        echo "
                           <div class=\"small-img-col\">
                              <img src=\"$img\" class=\"small-img\">
                           </div>";
                     }
                  ?>
                  </div>
               </div>
               <div class="col-2">
                  <h1><?php echo $product->getName()?></h1>
                  <h4>$<?php echo $product->getPrice()?></h4>
                  <form action="cart.php">
                     <input type="hidden" id="pID" name="pID" value="<?php echo $product->getID()?>">
                     <input type="number" id="quantity" name="quan" min="0" value="1">
                     <button type="submit" class="btn" id="addToCartBtn">Add To Cart</button>
                     <!-- <a href="cart.php" class="btn">Add To Cart</a> -->
                  </form>
                  <h3>Product details <i class="fa fa-indent"></i></h3>
                  <br>
                  <p class="text"><?php echo $product->getDescription()?></p>
               </div>
            </div>
       </div>
       <div class="small-container single-product">
         <div class="row row-2">
            <h2>Related Products</h2>
            <p><a href="products.php">View More</a></p>
         </div>
       </div>
        <div class="small-container">
            <div class="row">
               <div class="col-4">
                  <img src="images/beats.jpeg">
                  <h4>Beats By Dre Studio3</h4>
                  <div class="rating">
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star-o"></i>
                  </div>
                  <p>$879.00</p>
               </div>
                <div class="col-4">
                  <img src="images/ipad.jpg">
                  <h4>Apple iPad Pro</h4>
                  <div class="rating">
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star-half-o"></i>
                  </div>
                  <p>$879.00</p>
               </div>
                 <div class="col-4">
                  <img src="images/x1.jpg">
                  <h4>Lenovo X1 Carbon</h4>
                  <div class="rating">
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star-half-o"></i>
                  </div>
                  <p>$1500.00</p>
               </div>
                  <div class="col-4">
                  <img src="images/s21.jpg">
                  <h4>Samsung Galaxy S21 Ultra 5G</h4>
                  <div class="rating">
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star-half-full"></i>
                  </div>
                  <p>$1000.00</p>
                  </div>
            </div>
       </div>
        <div class="footer">
         <div class="container">
            <div class="row">
              <div class="footer-col-2">
               <h3>WORKED:</h3>
                <ul>
                  <li>ENDRI BIDA</li>
                </ul>
              </div>
               <div class="footer-col-1">
               <h3>WHERE TO FIND US?</h3>
                <ul>
                  <li>You can find us anytime in:</li>
                  <li>Konrad-Zuse-Ring 11, 14469 Potsdam</li>
                  <li>or reach us on this phone number</li>
                  <li>+49 (0)30 338 539 710</li>
                </ul>
              </div>
              </div>
            </div>
            <hr>
            <p class="copyright"> COPYRIGHT &copy; SQL INJECTION &reg; JANUARY </p>
         </div>
         <script src="js/jquery-3.5.1.min.js"></script>
        <script>
           var menueItmes=document.getElementById("menue-item");
               menueItmes.style.maxHeight="0px";
               function menuetoggle(){
                  
                  if(menueItmes.style.maxHeight=="0px"){
                      menueItmes.style.maxHeight="200px";
                  }else{
                      menueItmes.style.maxHeight="0px";
                  }
               }
               /*----------image gallery-------*/
               var bigImage=document.getElementById("product-image");
                var smallImage=document.getElementsByClassName("small-img");
                smallImage[0].onclick = function()
                {
                  bigImage.src=smallImage[0].src;
                };
                smallImage[1].onclick = function(){
                  bigImage.src=smallImage[1].src;
                };
                smallImage[2].onclick=function(){
                  bigImage.src=smallImage[2].src;
                };
                /*------------typed text dynamicaaly --------------*/
        </script>
   </body>
</html>