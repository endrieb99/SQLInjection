<?php 
    if(!isset($_SESSION)) { 
        session_start(); 
    }

    $cartSize = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

    include_once "protected/db/db.class.php";
    $db = new DB();
    $payments = $db->getAllPaymentOptionsForUser($_SESSION['account_id']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>User Profile</title>
        <link rel="stylesheet" href="css/index.css">
        <script src="js/default.js"></script> 
        <script src="js/jquery-3.5.1.min.js"></script>
   </head>
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
    <div class="row row-2">
        <div class="small-container">
            <h2 class="title">USER DETAILS</h2>
            <form id="updateUserForm">
                <div class="inputBox" hidden>
                    <label>First Name</label>
                    <input type="text" id="uuidTxt" name="uuid" value="<?php echo $_SESSION['account_id'] ?>">
                </div>
                <div class="inputBox">
                    <label>First Name</label>
                    <input type="text" id="firstNameTxt" name="first_name" placeholder="<?php echo $_SESSION['account_first_name'] ?>">
                </div>
                <div class="inputBox">
                <label>Middle Name</label>
                    <input type="text" id="middleNameTxt" name="middle_name" placeholder="<?php echo $_SESSION['account_middle_name'] ?>">
                </div>
                <div class="inputBox">
                <label>Last Name</label>
                    <input type="text" id="lastNameTxt" name="last_name" placeholder="<?php echo $_SESSION['account_last_name'] ?>">
                </div>
                <div class="inputBox">
                <label>Email</label>
                    <input type="email" id="updateEmailTxt" name="email" placeholder="<?php echo $_SESSION['account_email'] ?>">
                </div>
                <div class="inputBox">
                    <label>Password</label>
                    <div>
                        <input type="password" id="updatePassTxt" name="password" disabled placeholder="Update Password">
                        <input id="isPasswordUpdated" type="checkbox"/>
                        <label id="passUpdateLabel">Update password.</label>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn" id="updateBtn">Update Information</button>
                </div>
            </form>
        </div>
        <div class="small-container">
            <h2 class="title">PAYMENT METHODS</h2>
            <?php
                foreach($payments as $payment) {
                    echo "<form>
                                <div class=\"inputBox\">
                                    <label>Card Number</label>
                                    <input type=\"text\" placeholder=\"".$payment->getCardNumber()."\">
                                </div>
                                <div class=\"row row-2\">
                                    <div class=\"inputBox\">
                                        <label>expiration date</label>
                                        <input type=\"text\" placeholder=\"".$payment->getExpirationDate()."\">
                                    </div>
                                    <div class=\"inputBox\">
                                        <label>CVV</label>
                                        <input type=\"text\" placeholder=\"".$payment->getCVV()."\">
                                    </div>
                                </div>
                            </form>";
                }
            ?>
            <div>
            <h2 class="title">ADD A PAYMENT METHOD</h2>
            <form id="addPaymentForm">
                <div class="inputBox">
                    <label>Card Number</label>
                    <input type="text" id="cardNumberTxt" placeholder="ex. 1234 5678 9101 2345">
                </div>
                    <div class="inputBox">
                        <label>expiration date</label>
                        <select name="month" id="monthSelect">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <select name="year" id="yearSelect">
                            <?php
                                for($i=2022;$i<=2032;$i++) {
                                   echo "<option value=\"$i\">$i</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label>CVV</label>
                        <input type="text" id="cvvTxt" placeholder="ex. 123">
                    </div>
                    <div>
                    <button type="submit" class="btn" id="addPaymentBtn">Add Payment Method</button>
                </div>
            </form>
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
</html>
