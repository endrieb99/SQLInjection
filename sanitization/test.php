<html>
    <head>
        <title>SQL Injection</title>
    </head>
    <body>
        <h1>SQL Injection Project</h1>
        <br/>
        <h2>No Security</h2>
        <br/>
        <br/>
        <a href="../">Back to Main</a>
        <br/>
        <br/>
         <pre>
            <?php
            require_once("protected/db/db.class.php");

            //$db = new DB();
                require_once("protected/bussiness/login/login_checker.class.php");

                //$login = new LoginChecker();

                
            ?>
        </pre>
        <hr>
        <pre>
            <?php
                $db = new DB("");

                $email = "' or ''='";

                print_r($db->getUserByEmail($email));
            ?>
        </pre>
        <hr>
        <pre>
            <?php
                // $db = new DB("");

            ?>
        </pre>
        <hr>
        <pre>
            <?php
                // $db = new DB("");
;
            ?>
        </pre>
        <hr>
        <pre>
            <?php
                // $db = new DB("");

                // print_r($db->deleteUser(2));
            ?>
        </pre>
        <pre>
            <?php
                // $db = new DB("");

                // print_r($db->getUserRole(1));
            ?>
        </pre>
    </body>
</html>