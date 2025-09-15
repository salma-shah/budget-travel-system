<?php

require_once __DIR__ . '/../Connection.php';

class Restaurant {
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;    
    }

    // save restaurants to db
    public function addRestaurant($data) 
    {

       $this->pdo->query('INSERT INTO restaurant (destination_id, business_id, name, address,
          contacts, description, availability, status, open_from, open_to)
        VALUES (:destination_id, :business_id, :name, :address,
        :contacts, :description, :availability, :status, :open_from, :open_to)');
        
          $this->pdo->bind(':business_id', $data['business_id']);
          $this -> pdo -> bind(':destination_id', $data['destination_id']);
          $this -> pdo -> bind(':name', $data['name']);
          $this -> pdo -> bind(':address', $data['address']);
          $this -> pdo -> bind(':description', $data['description']);
          $this -> pdo -> bind(':contacts', $data['contacts']);
          $this -> pdo -> bind(':availability', $data['availability']);
          $this -> pdo -> bind(':status', $data['status']);
           $this->pdo->bind(':open_from', $data['open_from']);
           $this->pdo->bind(':open_to', $data['open_to']);

            if ( $this->pdo ->execute())
         {
             return  $this->pdo->lastInsertedId();
         }
         else { return false;}
  }


  // add food types to restaurant
   public function addFoodTypeToRestaurant($restaurantId, $foodTypeId)
    {
      $this->pdo->query('INSERT INTO restaurant_food_type(restaurant_id, id) VALUES (:restaurant_id, :id)');
      $this -> pdo -> bind(':restaurant_id', $restaurantId);
      $this -> pdo -> bind(':id', $foodTypeId);
       return $this->pdo->execute();
    }

    // add cuisines to restaurant
   public function addCuisineToRestaurant($restaurantId, $cuisineId)
    {
      $this->pdo->query('INSERT INTO restaurant_cuisine(restaurant_id, id) VALUES (:restaurant_id, :id)');
      $this -> pdo -> bind(':restaurant_id', $restaurantId);
      $this -> pdo -> bind(':id', $cuisineId);
       return $this->pdo->execute();
    }

    // add diestary restrictions to restaurant
   public function addDietaryRestrictionToRestaurant($restaurantId, $dietRestrictionId)
    {
      $this->pdo->query('INSERT INTO restaurant_dietary_restriction(restaurant_id, id) VALUES (:restaurant_id, :id)');
      $this -> pdo -> bind(':restaurant_id', $restaurantId);
      $this -> pdo -> bind(':id', $dietRestrictionId);
       return $this->pdo->execute();
    }

    // upating restaurant
    public function updateRestaurantDetails($restaurantId, $data)
{
    $this->pdo->query('UPDATE restaurant SET name = :name, address = :address, description = :description,
                       contacts = :contacts, open_from = :open_from, open_to = :open_to WHERE restaurant_id = :id');

    $this->pdo->bind(':id', $restaurantId);
    $this->pdo->bind(':name', $data['name']);
    $this->pdo->bind(':address', $data['address']);
    $this->pdo->bind(':description', $data['description']);
    $this->pdo->bind(':contacts', $data['contacts']);
    $this->pdo->bind(':open_from', $data['open_from']);
    $this->pdo->bind(':open_to', $data['open_to']);
   
   return $this->pdo->execute();
}


    // viewing all restaurants
    public function viewAllRestaurants(){
        $this->pdo->query("
        SELECT r.restaurant_id, r.name, r.address, i.file_path AS image, i.alt_text
        FROM restaurant r 
        LEFT JOIN image i 
        ON i.imageable_id = r.restaurant_id AND i.imageable_type = 'restaurant'
        WHERE r.status =:status");
      $this->pdo->bind(':status', "Approved");
      return $this->pdo->resultSet();}

    // viewing all restaurants for specific destination 
    public function viewAllRestaurantsByDestination($destinationId)
    {
        $this->pdo->query('SELECT * FROM restaurant WHERE destination_id = :destination_id');  // adjust it accordingly
        $this->pdo->bind(':destination_id', $destinationId);
        return $this->pdo->resultSet();
    }

    public function viewRestaurantDetails($restaurantId)
    {
      $this->pdo->query('SELECT r.restaurant_id, r.name, r.address, r.description, r.contacts, 
        i.file_path AS image, i.alt_text
        FROM restaurant r
        LEFT JOIN image i 
        ON i.imageable_id = r.restaurant_id AND i.imageable_type = "restaurant"
        WHERE restaurant_id = :restaurant_id
        LIMIT 1');
        $this->pdo->bind(':restaurant_id', $restaurantId);
        return $this->pdo->single();
    }

 public function getRestaurantById($restaurantId){
    $this->pdo->query('SELECT * FROM restaurant WHERE restaurant_id = :restaurant_id');
    $this->pdo->bind(':restaurant_id', $restaurantId);
    return $this->pdo->single();}

    public function isMarkedAvailable($restaurantId){
    $this->pdo->query('SELECT availability FROM restaurant WHERE restaurant_id = :restaurant_id');
    $this->pdo->bind(':restaurant_id', $restaurantId);
    $row = $this->pdo->single();
    return $row && $row->availability == 1;}

}
?>