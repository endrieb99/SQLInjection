<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $db = new DB();

    switch ($action) {
        case 'performLogin':
            $user = isset($_POST['email']) ? $_POST['email'] : null;
            $pass = isset($_POST['pass']) ? $_POST['pass'] : null;
            $user = $db->performLogin($user, $pass);

            if (!empty($user)) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['account_id'] = $user->getID();
                $_SESSION['account_first_name'] = $user->getFirstName();
				$_SESSION['account_middle_name'] = $user->getMiddleName();
                $_SESSION['account_last_name'] = $user->getLastName();
                $_SESSION['account_email'] = $user->getEmail();
                $_SESSION['account_type'] = $user->getRole();

                echo true;
            } else {
                echo false;
            }
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
            $value = $db->performSearch($query);
            echo json_encode($value);
            break;
    }
}
class DB
{

    /**
     *  __constructor - will create a database connection using mysqli
     * with the given information in the dbInfo.php file.
     */
    function __construct()
    {
        // Loading the model object classes.
        require_once(__DIR__ . "/../models/user.class.php");

        // Loading the model object classes.
        require_once(__DIR__ . "/../models/product.class.php");

		// Loading the model object classes.
		require_once(__DIR__ . "/../models/payment_detail.class.php");

        // Loading the dbInfo file for database credentials.
        require(__DIR__ . "../../../../db_info.php");

        try {
            //initiate PDO connection to the database
            $this->db = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            //change error reporting
            $this->db->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    // USER =====================================================================

    /**
     *  getAllUsers - will return all current existing users in the 'user' table.
     * 
     *  @return array $data - array containing all users.
     */
    public function getAllUsers()
    {
        try {
            $data = array();
            $stmt = $this->db->prepare("SELECT * FROM user");
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, 'user');

            return $data;
        } catch (PDOException $e) {
            echo "getAllUsers - " . $e->getMessage();
            die();
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
    public function getUser($_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT *
                                            FROM user u
                                            WHERE u.id = :id");
            $stmt->bindParam(":id", $_id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, 'user');

            return $data;
        } catch (PDOException $e) {
            echo "getUser - " . $e->getMessage();
            die();
        }
    }

    /**
     *	getUserByEmail - will return the user information that currently 
     * exist in the 'user' table and matches the provided email.
     *
     * @param  string $_email - user email to match.
     * @return array $data - array containing the user information.
     **/
    public function getUserByEmail($_email)
    {
        try {
            $stmt = $this->db->prepare("SELECT *
                                            FROM user
                                            WHERE email = :email");
            $stmt->bindParam(":email", $_email, PDO::PARAM_STR);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, 'user');

            return $data;
        } catch (PDOException $e) {
            echo "getUser - " . $e->getMessage();
            die();
        }
    }

    /**
     *	getUserEmail - will return the user's email that currently 
     * exist in the 'user' table and matches the provided id.
     *
     * @param  integer $_id - user id to match.
     * @return string $data - user email that matched the id.
     **/
    public function getUserEmail($_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT *
                                            FROM user
                                            WHERE id = :id");
            $stmt->bindParam(":id", $_id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, 'user');

            return $data;
        } catch (PDOException $e) {
            echo "getUser - " . $e->getMessage();
            die();
        }
    }

	public function getUserPassword($_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT password
                                            FROM user
                                            WHERE id = :id");
            $stmt->bindParam(":id", $_id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchColumn();

            return $data;
        } catch (PDOException $e) {
            echo "getUser - " . $e->getMessage();
            die();
        }
    }

    /**
     * getUserRole - will return the user's userRole that currently 
     * exist in the 'user' table and matches the provided id. 
     * 
     * @param  integer $_id - user id to match.
     * @return integer $data - userRole id for the matched user.
     */
    public function getUserRole($_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT user_role
                                            FROM user
                                            WHERE id = :id");
            $stmt->bindParam(":id", $_id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data;
        } catch (PDOException $e) {
            echo "getUserRole - " . $e->getMessage();
            die();
        }
    }

    /**
     * 	insertUser - will insert a new record to the 'user' table with the 
     * provided information.
     *
     * @param  array $_values - array containing the user information to be added.
     * @return string text to be displayed when a new user is created.
     **/
    public function insertUser($_values)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO user (first_name,middle_name,last_name,email,password,user_role) VALUES (:fName,:mName,:lName,:email,:pWord,:uRole)");
            $stmt->bindParam(":fName", $_values['first_name'], PDO::PARAM_STR);
            $stmt->bindParam(":mName", $_values['middle_name'], PDO::PARAM_STR);
            $stmt->bindParam(":lName", $_values['last_name'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $_values['email'], PDO::PARAM_STR);
            $stmt->bindParam(":pWord", $_values['password'], PDO::PARAM_STR);
            $stmt->bindParam(":uRole", $_values['user_role'], PDO::PARAM_STR);
            $stmt->execute();

            $insertedId = $this->db->lastInsertId();
            print "Record with id=" . $insertedId . " has been created.";
        } catch (PDOException $e) {
            echo "insertNewUser - " . $e->getMessage();
            die();
        }
    }

    /**
     * 	updateUser - will update a record from the user table with the provided
     * information.
     *
     * @param  array $_values - array containing the user information to be added.
     * @return string text to be displayed when a user is updated.
     **/
    public function updateUser($_values)
    {
		if(is_null($_values['password'])){
			$password = $this->getUserPassword($_values['id']);
		} else {
			$password = $_values['password'];
		}

        try {
            $stmt = $this->db->prepare("UPDATE user SET first_name=:fName, middle_name=:mName, last_name=:lName, email=:email, password=:pWord, user_role=:uRole WHERE id=:id");
            $stmt->bindParam(":id", $_values['id'], PDO::PARAM_INT);
            $stmt->bindParam(":fName", $_values['first_name'], PDO::PARAM_STR);
            $stmt->bindParam(":mName", $_values['middle_name'], PDO::PARAM_STR);
            $stmt->bindParam(":lName", $_values['last_name'], PDO::PARAM_STR);
            $stmt->bindParam(":email", $_values['email'], PDO::PARAM_STR);
            $stmt->bindParam(":pWord", $password, PDO::PARAM_STR);
            $stmt->bindParam(":uRole", $_values['user_role'], PDO::PARAM_STR);
            $stmt->execute();

            $insertedId = $this->db->lastInsertId();
            print "Record with id=" . $insertedId . " has been created.";
        } catch (PDOException $e) {
            echo "updateUser - " . $e->getMessage();
            die();
        }
    }

    /**
     * 	deleteUser - will delete a record from the user table that matches the
     * provided user id.
     *
     * @param  integer $_id - user id to match.
     * @return string text to be displayed when a user is deleted.
     **/
    public function deleteUser($_id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM user WHERE id = :id");
            $stmt->bindParam(":id", $_id, PDO::PARAM_INT);
            $stmt->execute();

            return "Record has been deleted.";
        } catch (PDOException $e) {
            echo "deleteUser - " . $e->getMessage();
            die();
        }
    }

    // USER ROLE ================================================================

    /**
     *  getAllUserRoles - will return all current existing user roles in the 'user_role' table.
     * 
     *  @return array $data - array containing all userRoles.
     */
    public function getAllUserRoles()
    {
        try {
            $data = array();
            $stmt = $this->db->prepare("SELECT * FROM user_role");
            $stmt->execute();

            $data = $stmt->fetchAll();

            return $data;
        } catch (PDOException $e) {
            echo "getAllUserRoles - " . $e->getMessage();
            die();
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
    public function getUserRoleById($_id)
    {
        $data = array();
        try {
            $stmt = $this->db->prepare("SELECT *
                                            FROM user_role
                                            WHERE id = :id");
            $stmt->bindParam(":id", $_id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, 'user_role');

            return $data;
        } catch (PDOException $e) {
            echo "getUserRoleById - " . $e->getMessage();
            die();
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
    public function insertUserRole($_values)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO user_role (role) VALUES (:role)");
            $stmt->bindParam(":role", $_values['role'], PDO::PARAM_STR);
            $stmt->execute();

            $insertedId = $this->db->insert_id;
            return "Record with id=" . $insertedId . " has been created.";
        } catch (PDOException $e) {
            echo "insertUserRole - " . $e->getMessage();
            die();
        }
    }

    // Products =================================================================

    public function getAllProducts()
    {
        $data = array();

        try {
            $stmt = $this->db->prepare("SELECT * 
										FROM product");
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, 'product');

            return $data;
        } catch (PDOException $e) {
            echo "getAllProducts - " . $e->getMessage();
            die();
        }

        return $data;
    }

    public function getProduct($_id)
    {
        $data = array();

        try {
            $stmt = $this->db->prepare("SELECT * 
										FROM product 
										WHERE id = :id");
            $stmt->bindParam(":id", $_id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, 'product');

            return $data;
        } catch (PDOException $e) {
            echo "getProduct - " . $e->getMessage();
            die();
        }

        return $data;
    }

	// PAYMENT ==================================================================

	public function getAllPaymentOptionsForUser($_user_id) {
		$data = array();

		try {
            $stmt = $this->db->prepare("SELECT * 
										FROM payment_detail 
										WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $_user_id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, 'payment_detail');

            return $data;
        } catch (PDOException $e) {
            echo "getProduct - " . $e->getMessage();
            die();
        }

        return $data;
	}

	public function insertPaymentMethod($_values) {

		try {
            $stmt = $this->db->prepare("INSERT INTO payment_detail (user_id,card_number,expiration_date,cvv) VALUES (:user_id,:card_number,:expiration_date,:cvv)");
            $stmt->bindParam(":user_id", $_values['user_id'], PDO::PARAM_INT);
            $stmt->bindParam(":card_number", $_values['card_number'], PDO::PARAM_STR);
            $stmt->bindParam(":expiration_date", $_values['expiration_date'], PDO::PARAM_STR);
            $stmt->bindParam(":cvv", $_values['cvv'], PDO::PARAM_STR);
            $stmt->execute();

            $insertedId = $this->db->lastInsertId();
            print "Record with id=" . $insertedId . " has been created.";
        } catch (PDOException $e) {
            echo "insertPaymentMethod - " . $e->getMessage();
            die();
        }
	}

    // BEHAVIOR =================================================================

    public function performLogin($_email, $_password)
    {
        try {
            $stmt = $this->db->prepare("SELECT *
                                            FROM user 
                                            WHERE email=:email
                                            AND password=:password");
            $stmt->bindParam(":email", $_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $_password, PDO::PARAM_STR);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, 'user');

            return $data[0];
        } catch (PDOException $e) {
            echo "performLogin - " . $e->getMessage();
            die();
        }
    }

    public function performSearch($_query)
    {
        $data = array();

        try {
            $query = "%" . $_query . "%";
            $stmt = $this->db->prepare("SELECT * 
                                            FROM product 
											WHERE name like :query");
            $stmt->bindParam(":query", $query, PDO::PARAM_STR);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, 'product');

            return $data;
        } catch (PDOException $e) {
            echo "performSearch - " . $e->getMessage();
            die();
        }

        return $data;
    }

    public function performDrop()
    {
        try {
            $stmt = $this->db->prepare("DROP TABLE  test ");
            $stmt->execute();

            print "Table test dropped";

        } catch (PDOException $e) {
            echo "performDrop - " . $e->getMessage();
            die();
        }
    }

    /**
     *	performLogOut - will logout the currently logged
     * user, and destroy their user session.
     **/
    function performLogOut()
    {
        session_unset();
        session_destroy();
    }
}
