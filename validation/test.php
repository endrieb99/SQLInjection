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

                // // print_r($login->checkForUser("anthonyjp03@hotmail.com"));

                // print_r($login->attemptLogin("anthonyjp03@mail.com","54321"));

                //print_r($login->checkForUser("anthonyjp03@mail.com"));

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
                // $data = array(
                //     "first_name"=>"'Anthony'",
                //     "middle_name"=>"'Jose'",
                //     "last_name"=>"'Perez'",
                //     "email"=>"'anthonyjp03@gmail.com'",
                //     "password"=>"1234",
                //     "user_role"=>2,
                // );
                // print_r($db->insertUser($data));
            ?>
        </pre>
        <hr>
        <pre>
            <?php
                // $db = new DB("");
                // $data = array(
                //     "id"=>5,
                //     "first_name"=>"'Anthony'",
                //     "middle_name"=>"'Jose'",
                //     "last_name"=>"'Perez'",
                //     "email"=>"'anthonyjp03@mail.com'",
                //     "password"=>"54321",
                //     "user_role"=>1,
                // );
                // print_r($db->updateUser($data));
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