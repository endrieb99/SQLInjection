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
        <title>Login</title>
        <link rel="stylesheet" href="css/index.css">
        <script src="js/default.js"></script> 
   </head>
   <body>
      <div class="container">
          <div><a href="/sql_injection/"> < Change section</a></div>
      <div class="navbar ">
         <div class="nav">
            <ul id="menue-item">
                <li><a href="index.php">MARKETPLACE</a></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php" >Products</a></li>
                <li><a href="login.php" >Login</a></li>
            </ul>
         </div>
         <a href="cart.php"><img src="images/cart.png" width="50px"height="50px"><p id="cartQuant"><?php echo $cartSize; ?></p></a>
          <img src="images/menu.png" class="menue-icon" onclick="menuetoggle();">
      </div>
      </div>
      <div class="login">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <img src="images/sql.png" alt="images/sql.jpg" width="100%">
                </div>
                <div class="col-2">
                    <div class="form-container">
                        <div class="form-btn">
                            <span onclick="Login();">Login</span>
                            <span onclick="Register();">Register</span>
                            <hr id="indicator">
                        </div>
                        <form action="" id="login">
                            <input type="text" id="emailTxt" placeholder="E-mail">
                            <input type="password" id="passTxt" placeholder="Password">
                            <button type="submit" class="btn" id="loginBtn">Login</button>
                            <a href="">Forgot Password?</a>
                        </form>
                         <form action="" id="register">
                            <input type="text" id="firstNameTxt" placeholder="First Name"> 
                            <input type="text" id="middleNameTxt" placeholder="Middle Name">
                            <input type="text" id="lastNameTxt" placeholder="Last Name">
                            <input type="text" id="registerEmailTxt" placeholder="E-mail">
                            <input type="password" id="registerPassTxt" placeholder="Password">
                            <input type="password" id="registerPassConfTxt" placeholder="Confirm Password">
                            <button type="submit" class="btn" id="registerBtn">Register</button>                      
                        </form>
                    </div>
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
       <p class="copyright"> COPYRIGHT &copy; SQL INJECTION GROUP &reg; JANUARY </p>
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
               var logIn=document.getElementById("login"),
                    register=document.getElementById("register"),
                    indicator=document.getElementById("indicator");
                    function Register(){
                        register.style.transform="translateX(0px)";
                        logIn.style.transform="translateX(0px)";
                        indicator.style.transform="translateX(100px)";
                    }
                    function Login(){
                        register.style.transform="translateX(300px)";
                        logIn.style.transform="translateX(300px)";
                        indicator.style.transform="translateX(0px)";
                    }
        </script>
   </body>
</html>