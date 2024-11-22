<?php
/**
 *  user.class.php
 * A class of a User's information
 * 
 * @author     Anthony Perez
 * @version    Release: 1.0
 * @date       25/12/2021
 **/

class User{

private $id, $first_name, $middle_name, $last_name, $user_role, $email, $password;

// Get the id of the User
public function getID(){return $this->id;}
// Get the User's first name
public function getFirstName(){return $this->first_name;}
// Get the User's middle name
public function getMiddleName(){return $this->middle_name;}
// Get the User's last name
public function getLastName(){return $this->last_name;}
// Get the User's whole name
public function getWholeName(){return $this->first_name." ".$this->middle_name." ".$this->last_name;}
// Get the User's email
public function getEmail(){return $this->email;}
// Get the User's password
public function getPassword(){return $this->password;}
// Get the User's current role in the system
public function getRole(){return $this->user_role;}
}