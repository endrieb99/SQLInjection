<?php 
    if(!isset($_SESSION)) { 
        session_start(); 
    }
    if(!$_SESSION['loggedIn'] == true){
        header("Location: login.php");
        exit();
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

    if(isset($_GET['del'])){
        unset($_SESSION['cart'][$_GET['del']]);
    }

    if(isset($_GET['buy'])){
        $keys = array_keys($_SESSION['cart']);
        foreach($keys as $item){
            unset($_SESSION['cart'][$item]);
        }
    }

    $cartSize = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
   <head>
        <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cart</title>
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
      </header>
       <div class="small-container cart">
           <table>
            <tr>
                <th>Products</th>
                <th>Quantity</th>
                <th>SubTotal</th>
            </tr>
            <?php
                include_once "protected/db/db.class.php";
                $db = new DB();

                $cartSubtotal = 0;
                $cartTax = 0;
                $cartTotal = 0;
                foreach(array_keys($_SESSION['cart']) as $prod){

                    $product = $db->getProduct($prod)[0];

                    $subtotal = $_SESSION['cart'][$prod]*$product->getPrice();
                    $cartSubtotal += $subtotal;

                    $imgs = explode("|",$product->getImages());

                    echo "<tr>
                        <td>
                            <div class=\"cart-info\">
                                <img src=\"".$imgs[1]."\" alt=\"".$imgs[1]."\">
                                <div>
                                    <h1>".$product->getName()."</h1>
                                    <normal>Price: $".$product->getPrice()."</normal>
                                    <a href=\"cart.php?del=".$product->getID()."\">Remove</a>
                                </div>
                            </div>
                        </td>
                        <td><input type=\"number\" value=\"".$_SESSION['cart'][$prod]."\"></td>
                        <td class=\"subtotal\">$".number_format($subtotal,2)."</td>
                    </tr>";
                }
                $cartTotal = $cartSubtotal + $cartTax;
            ?>
           </table>
           <div class="total-price">
           <table>
            <tr>
                <td>SubTotal</td>
                <td>$<?php echo number_format($cartSubtotal,2) ?></td>
            </tr>
            <tr>
                <td>Tax</td>
                <td>$<?php echo number_format($cartTax,2) ?></td>
            </tr>
            <tr>
                <td>Total</td>
                <td>$<?php echo number_format($cartTotal,2) ?></td>
            </tr>
           </table>
       </div>
       <form action="cart.php?">
            <input type="hidden" name="buy" value="true">
            <button type="submit" class="btn" id="purchaseBtn">Confirm Purchase</button>
        </form>
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
        </script>
   </body>
</html>