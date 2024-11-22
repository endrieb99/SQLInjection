<?php
   if(!isset($_SESSION)) { 
      session_start(); 
   }  
   $cartSize = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
   <head>
        <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>MARKETPLACE</title>
        <link rel="stylesheet" href="css/index.css">
        <script src="js/default.js"></script> 
   </head>
   <body>
         <header>
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
         <div class="row">
         <div class="col-2">
            <h1>CHECK OUT <br> SALES UNTIL SUNDAY</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <br>Morbi in posuere tortor. Nunc tellus diam</p>
            <a href="products.php" class="btn">Explore Now &#8594;</a>
         </div>
         <div class="col-2">
            <img src="images/sales.gif">
         </div>
         </div>
      </div>1
      </header>
       </header>
       <div class="small-container">
            <h2 class="title">ELECTRONIC PRODUCTS</h2>
            <div class="row">
               <div class="col-4">
                 <a href="products.php"><img src="images/mac.jpg"></a>
                   <h4>MacBook Pro</h4>
                  <div class="rating">
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                  </div>
                  <p>$3999.00</p>
               </div>
                <div class="col-4">
                  <a href="products.php"><img src="images/x1.jpg"></a>
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
                  <a href="products.php"><img src="images/s21.jpg"></a>
                  <h4>Samsung S21 ULTRA 5G</h4>
                  <div class="rating">
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>
                     <i class="fa fa-star-half-o"></i>
                  </div>
                  <p>$1000.00</p>
               </div>
            </div>
       </div>
         <div class="offer">
           <div class="small-container">
              <div class="row">
                  <div class="col-2">
                      <img src="images/PS5.jpg"class="offer-img">
                  </div>
                  <div class="col-2">
                     <p>Exclusive Discount</p>
                     <h1> PLAYSTATION 5</h1>
                     <small>THE FUTURE OF GAMING. YOU GET FOR FREE FIFA 21</small>
                     <a href="products.php" class="btn">Buy Now</a>
                  </div>
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
            <p class="copyright"> COPYRIGHT &copy; SQL INJECTION  &reg; JANUARY </p>
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
        </script>
   </body>

</html>