<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }

    if(isset($_POST['action']) ){
    $action = $_POST['action'];
    $db = new DB();

    switch ($action) {
        case 'performLogin':
            $user = isset($_POST['email']) ? $_POST['email'] : null;
            $pass = isset($_POST['pass']) ? $_POST['pass'] : null;
            $users = $db->performLogin($user, $pass);

                if(!empty($users[0])) {
                    $user = $users[0];
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['account_id'] = $user['id'];
                    $_SESSION['account_first_name'] = $user['first_name'];
                    $_SESSION['account_middle_name'] = $user['middle_name'];
                    $_SESSION['account_last_name'] = $user['last_name'];
                    $_SESSION['account_email'] = $user['email'];
                    $_SESSION['account_type'] = $user['user_role'];

                    echo true;
                } else { echo false; }
            break;

        case 'createUser':
            $f_name = isset($_POST['fName']) ? $_POST['fName'] : null;
            $m_name = isset($_POST['mName']) ? $_POST['mName'] : null;
            $l_name = isset($_POST['lName']) ? $_POST['lName'] : null;
            $email  = isset($_POST['email']) ? $_POST['email'] : null;
            $pass   = isset($_POST['pass']) ? $_POST['pass'] : null;

            $data = array(
                "first_name"=>$f_name, 
                "middle_name"=>$m_name, 
                "last_name"=>$l_name, 
                "email"=>$email, 
                "password"=>$pass,
                "user_role"=>2
            );

            $user = $db->insertUser($data);
            
            $result = ($user > 0) ? true : false;
            return $result;
            break;

        case 'updateUser':
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $f_name = isset($_POST['fName']) ? $_POST['fName'] : null;
            $m_name = isset($_POST['mName']) ? $_POST['mName'] : null;
            $l_name = isset($_POST['lName']) ? $_POST['lName'] : null;
            $email  = isset($_POST['email']) ? $_POST['email'] : null;
            $pass   = isset($_POST['pass']) ? $_POST['pass'] : null;

            $data = array(
                "id"=>$id,
                "first_name"=>$f_name, 
                "middle_name"=>$m_name, 
                "last_name"=>$l_name, 
                "email"=>$email, 
                "password"=>$pass,
                "user_role"=>2
            );

            $result = $db->updateUser($data);

            if($result === 0){
                $user = $db->getUser($id);

                $_SESSION['loggedIn'] = true;
                $_SESSION['account_id'] = $user['id'];
                $_SESSION['account_first_name'] = $user['first_name'];
                $_SESSION['account_middle_name'] = $user['middle_name'];
                $_SESSION['account_last_name'] = $user['last_name'];
                $_SESSION['account_email'] = $user['email'];
                $_SESSION['account_type'] = $user['user_role'];

                return true;
            } else{
                return false;
            }
            break;

        case 'insertPaymentMethod':
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
            $card_number = isset($_POST['card_number']) ? $_POST['card_number'] : null;
            $expiration_date = isset($_POST['expiration_date']) ? $_POST['expiration_date'] : null;
            $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : null;

            $data = array(
                "user_id"=>$user_id, 
                "card_number"=>$card_number, 
                "expiration_date"=>$expiration_date, 
                "cvv"=>$cvv
            );

            $card = $db->insertPaymentMethod($data);
            
            $result = ($card > 0) ? true : false;
            echo $result;
            break;

        case 'performLogout':
            $db->performLogOut();
            break;

        case 'performSearch':
            $query = isset($_POST['query']) ? $_POST['query'] : null;
            $results = $db->performSearch($query);
            echo json_encode($results);
            break;
        
    }
}
    class DB {

        /**
         *  __constructor - will create a database connection using mysqli
         * with the given information in the dbInfo.php file.
         */
        function __construct() {
            // Loading the dbInfo file for database credentials.
            require_once(__DIR__."../../../../db_info.php");

            // Create db object with the mysqli connection.
            $this->db = new mysqli($host,$user,$pass,$db);
        }

        // USER =====================================================================

        /**
         *  getAllUsers - will return all current existing users in the 'user' table.
         * 
         *  @return array $data - array containing all users.
         */
        public function getAllUsers() {
            $data = array();

            if ($stmt = $this->db->query("SELECT * FROM user")) {
                while($obj = $stmt->fetch_assoc()){
                    array_push($data, $obj);
                }
            }
            return $data;
        }

        /**
         *  getUser - will return user that currently exist in the 'user' table 
         * that matches the provided id.
         * 
         * @param  integer $_id - user id to match.
         * @return array $data - array containing the user information.
         */
        public function getUser($_id) {
            $data = array();

            if($stmt = $this->db->query("SELECT * FROM user WHERE id=".$_id)) {
                array_push($data, $stmt->fetch_assoc());
            }
            return $data;
        }

        /**
         *	getUserByEmail - will return the user information that currently 
         * exist in the 'user' table and matches the provided email.
         *
         * @param  string $_email - user email to match.
         * @return array $data - array containing the user information.
         **/
        public function getUserByEmail($_email) {
            $data = array();

            if($stmt = $this->db->query("SELECT * 
                                         FROM user 
                                         WHERE email='".$_email."'")) {
                array_push($data, $stmt->fetch_assoc());
            }
            return $data;
        }

        /**
         *	getUserEmail - will return the user's email that currently 
         * exist in the 'user' table and matches the provided id.
         *
         * @param  integer $_id - user id to match.
         * @return string $data - user email that matched the id.
         **/
        public function getUserEmail($_id) {
            $data = array();

            if($stmt = $this->db->query("SELECT email 
                                         FROM user 
                                         WHERE id='".$_id."'")) {
                array_push($data, $stmt->fetch_row());
            }
            return $data[0][0];
        }

        public function getUserPassword($_id) {
            $data = array();

            if($stmt = $this->db->query("SELECT password 
                                         FROM user 
                                         WHERE id='".$_id."'")) {
                array_push($data, $stmt->fetch_row());
            }
            return $data[0][0];
        }

        /**
         * getUserRole - will return the user's userRole that currently 
         * exist in the 'user' table and matches the provided id. 
         * 
         * @param  integer $_id - user id to match.
         * @return integer $data - userRole id for the matched user.
         */
        public function getUserRole($_id) {
            $data = array();

            if($stmt = $this->db->query("SELECT user_role
                                         FROM user 
                                         WHERE id='".$_id."'")) {
                array_push($data, $stmt->fetch_row());
            }
            return $data[0][0];
        }

        /**
         * 	insertUser - will insert a new record to the 'user' table with the 
         * provided information.
         *
         * @param  array $_values - array containing the user information to be added.
         * @return string text to be displayed when a new user is created.
         **/
        public function insertUser($_values) {

            if($this->db->query("INSERT INTO user 
            (first_name,middle_name,last_name,email,password,user_role) 
            VALUES('".$_values['first_name']."','"
                    .$_values['middle_name']."','"
                    .$_values['last_name']."','"
                    .$_values['email']."','"
                    .$_values['password']."','"
                    .$_values['user_role']."')")) {

                return $this->db->insert_id;
            }else{
                return $this->db->error;
            }
        }

        /**
         * 	updateUser - will update a record from the user table with the provided
         * information.
         *
         * @param  array $_values - array containing the user information to be added.
         * @return string text to be displayed when a user is updated.
         **/
        public function updateUser($_values) {

            if(is_null($_values['password'])){
                $password = $this->getUserPassword($_values['id']);
            } else {
                $password = $_values['password'];
            }

            if($this->db->query("UPDATE user SET
                first_name='".$_values['first_name'].
                "', middle_name='".$_values['middle_name'].
                "', last_name='".$_values['last_name'].
                "', email='".$_values['email'].
                "', password='".$password.
                "', user_role='".$_values['user_role'].
                "', updated_at=now()".
                " WHERE id=".$_values['id'])) {

                $result = ($this->db->insert_id === 0) ? true : false;

                return $result;
            } else{
                return $this->db->error;
            }
        }

        /**
         * 	deleteUser - will delete a record from the user table that matches the
         * provided user id.
         *
         * @param  integer $_id - user id to match.
         * @return string text to be displayed when a user is deleted.
         **/
        public function deleteUser($_id) {
            if($this->db->query("DELETE 
                                 FROM user 
                                 WHERE id=".$_id)) {
                return "Record has been deleted.";
            } else{
                return $this->db->error;
            }
        }

        // USER ROLE ================================================================

        /**
         *  getAllUserRoles - will return all current existing user roles in the 'user_role' table.
         * 
         *  @return array $data - array containing all userRoles.
         */
        public function getAllUserRoles() {
            $data = array();

            if ($stmt = $this->db->query("SELECT * FROM user_role")) {
                while($obj = $stmt->fetch_assoc()){
                    array_push($data, $obj);
                }
            }
            return $data;
        }

        /**
         *  getUserRoleById - will return a current existing user roles in the 'user_role' table
         * that matches the provided id.
         * 
         *  @param int $_id - user_role id to match.
         *  @return array $data - array containing all userRoles.
         */
        public function getUserRoleById($_id) {
            $data = array();

            if ($stmt = $this->db->query("SELECT * FROM user_role 
                                          WHERE id=".$_id."'")) {
                while($obj = $stmt->fetch_assoc()){
                    array_push($data, $obj);
                }
            }
            return $data;
        }

        /**
         * 	insertUser - will insert a new record to the 'user' table with the 
         * provided information.
         *
         * @param  array $_values - array containing the userRole information to be added.
         * @return string text to be displayed when a new user is created.
         **/
        public function insertUserRole($_values) {

            if($this->db->query("INSERT INTO user_role (role) VALUES(".$_values['role'].")")) {
                return "Record with id=".$this->db->insert_id." has been created.";
            }else{
                return $this->db->error;
            }
        }

        // Products =================================================================

        public function getAllProducts() {
            $data = array();

            if ($stmt = $this->db->query("SELECT * FROM product")) {
                while($obj = $stmt->fetch_assoc()){
                    array_push($data, $obj);
                }
            }
            return $data;
        }

        public function getProduct($_id) {
            $data = array();

            if($stmt = $this->db->query("SELECT * FROM product WHERE id=".$_id)) {
                array_push($data, $stmt->fetch_assoc());
            }
            return $data;
        }

        // PAYMENT ==================================================================

        public function getAllPaymentOptionsForUser($_user_id) {
            $data = array();

            if ($stmt = $this->db->query("SELECT * FROM payment_detail
                                        WHERE user_id=".$_user_id)) {
                while($obj = $stmt->fetch_assoc()){
                    array_push($data, $obj);
                }
            }
            return $data;
        }

        public function insertPaymentMethod($_values) {

            if($this->db->query("INSERT INTO payment_detail 
            (user_id,card_number,expiration_date,cvv) 
            VALUES('".$_values['user_id']."','"
                    .$_values['card_number']."','"
                    .$_values['expiration_date']."','"
                    .$_values['cvv']."')")) {

                return $this->db->insert_id;
            }else{
                return $this->db->error;
            }
        }

        // BEHAVIOR =================================================================

        public function performLogin($_email, $_password) {
            $data = array();

            if($stmt = $this->db->query("SELECT * 
                                         FROM user 
                                         WHERE email=\"".$_email."\"".
                                        "AND password=\"".$_password."\"")){ 
                array_push($data, $stmt->fetch_assoc());
            }
            return $data;
        }

        public function performSearch($_query) {
            $data = array();

            if($stmt = $this->db->query("SELECT * 
                                         FROM product 
                                         WHERE name like \"%".$_query."%\"")){ 
                array_push($data, $stmt->fetch_assoc());
            }
            return $data;
        }

        public function performDrop() {
            $data = array();

            if($stmt = $this->db->query("DROP TABLE test")){ 
                array_push($data, $stmt->fetch_assoc());
            }
            return $data;
        }

        /**
        *	performLogOut - will logout the currently logged
        * user, and destroy their user session.
        **/
        function performLogOut(){
            session_unset();
            session_destroy();
        }
    }