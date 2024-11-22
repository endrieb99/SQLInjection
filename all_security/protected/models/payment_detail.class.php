<?php
/**
 *  product.class.php
 * A class of a Payment_Detail information
 * 
 * @author     Anthony Perez
 * @version    Release: 1.0
 * @date       25/12/2021
 **/

class Payment_Detail{

private $id, $user_id, $card_number, $expiration_date, $cvv;

// Get the id of the Product
public function getID(){return $this->id;}
// Get the Product name
public function getUserID(){return $this->user_id;}
// Get the Product description
public function getCardNumber(){return $this->card_number;}
// Get the Product price
public function getExpirationDate(){return $this->expiration_date;}
// Get the Product size
public function getCVV(){return $this->cvv;}

}