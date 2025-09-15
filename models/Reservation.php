<?php

require_once __DIR__ . '/../Connection.php';

class Reservation {
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

     // check if reservation spot is avaialble
     public function isRestaurantAvailable($restaurantId)
    {
        // we take the reservations which are CONFIRMED and check the dates for the specific item
        $this->pdo->query('SELECT availability FROM restaurant WHERE restaurant_id = :restaurant_id AND availability= 1 ');
        $this -> pdo -> bind(':restaurant_id', $restaurantId);
        
         // if avaialble
         $isAvailable = $this -> pdo ->single();
         if (!$isAvailable) { return false;}
         else { return true;}
    }

    // making the booking so business can accept or reject
    public function makeReservation($data)
    {
        // inserting data into db
        $this->pdo->query('INSERT INTO reservation (restaurant_id, user_id,date,number_guests,status)
        VALUES (:restaurant_id, :user_id, :date,:number_guests, :status)');

       // binding values
       $this->pdo->bind(':restaurant_id', $data['restaurant_id']);
       $this->pdo->bind(':user_id', $data['user_id']);
       $this->pdo->bind(':date', $data['date']);
       $this->pdo->bind(':number_guests', $data['number_guests']);
       $this->pdo->bind(':status', $data['status']);

        // executing
         if ( $this -> pdo -> execute())
         { return true;}
         else { return false;}
    }
}

?>