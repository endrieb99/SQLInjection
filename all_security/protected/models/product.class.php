<?php
/**
 *  product.class.php
 * A class of a User's information
 * 
 * @author     Anthony Perez
 * @version    Release: 1.0
 * @date       25/12/2021
 **/

class Product{

private $id, $name, $description, $price, $size, $category, $images;

// Get the id of the Product
public function getID(){return $this->id;}
// Get the Product name
public function getName(){return $this->name;}
// Get the Product description
public function getDescription(){return $this->description;}
// Get the Product price
public function getPrice(){return $this->price;}
// Get the Product size
public function getSize(){return $this->size;}
// Get the Product category
public function getCategory(){return $this->category;}
// Get the Product images
public function getImages(){return $this->images;}

}