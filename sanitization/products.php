<?php 
   if(!isset($_SESSION)) { 
      session_start(); 
   }
   $cartSize = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

   include_once "protected/db/db.class.php";
   $db = new DB();

   $products = array();

   if(isset($_GET['s'])){
      $products = $db->performSearch($_GET['s']);
   }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
        <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Products Page</title>
        <link rel="stylesheet" href="css/index.css">
        <script src="js/default.js"></script> 
        <script src="js/jquery-3.5.1.min.js"></script>
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
      <div class="small-container">
         <form id="searchBar" action="products.php">
            <input type="text" id="searchTxt" name="s" placeholder="<?php
             if(isset($_GET['s'])){
               echo $_GET['s'];
             } else{
               echo "Search..";
             }
             ?>">
            <button type="submit" class="btn" id="searchBtn">Search</button>
         </form>
      </div>
       <div class="small-container">
           <div class="row row-2">
            <h2>All Products</h2>
            <select>
                <option>Deault Sorting</option>
                <option>Sort By Rating</option>
                <option>Sort By Date</option>
                <option> Low to high price</option>
                <option>High to low price</option>
            </select>
           </div>
           <div class="row">
           <?php
               if(!isset($_GET['s'])){
                  $products = $db->getAllProducts();
               }
               foreach($products as $product) {
                  $imgs = explode("|", $product['images']);
                  echo "<div class=\"col-4\">
                  <a href=\"product_details.php?id=".$product['id']."\"><img src=\"".$imgs[1]."\"></a>
                  <h4>".$product['name']."</h4>
                  <div class=\"rating\">
                     <i class=\"fa fa-star\"></i>
                     <i class=\"fa fa-star\"></i>
                     <i class=\"fa fa-star\"></i>
                     <i class=\"fa fa-star\"></i>
                     <i class=\"fa fa-star\"></i>
                  </div>
                  <p>$".$product['price']."</p>
               </div>";
               }
           ?>  
           </div>
            <div class="page-btn">
                <span>1</span>
                <span>2</span>
                <span>3</span>
                <span>4</span>
                <span>&#8594;</span>
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