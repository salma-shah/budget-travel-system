<?php
require_once __DIR__ . '/../Connection.php';

class Room 
{
    private $pdo;

    public function __construct(){
        $this->pdo = new Connection;

    }

    // getting rooms types
    public function getRoomTypes()
    {
        $this->pdo->query('SELECT DISTINCT type from room');
        $roomTypeResults = $this->pdo->resultSet();
        return $roomTypeResults;
    }
    

    // checking for avilable rooms
    public function getAvailableRooms($checkin, $checkout, $roomType, $roomCount) {
    $this->pdo->query("
        SELECT r.* FROM room r WHERE r.type = :type
        AND r.status = 'Available'
        AND NOT EXISTS (
              SELECT 1 FROM booking b
              WHERE b.bookable_id = r.room_id
              AND b.bookable_type = 'room'
              AND b.status = 'Confirmed'
              AND (
                (:check_in < b.booking_end AND :check_out > b.booking_start))
              )
        LIMIT :roomCount");
    $this->pdo->bind(':type', $roomType);
    $this->pdo->bind(':check_in', $checkin);
    $this->pdo->bind(':check_out', $checkout);
    $this->pdo->bind(':roomCount', $roomCount, PDO::PARAM_INT);
    return $this->pdo->resultSet();
}

    // viewing all rooms for specific stay 
    public function viewAllRoomsByStays($stayId)
    {
        $this->pdo->query('SELECT * FROM room WHERE stay_id = :stay_id');  // adjust it accordingly
        $this->pdo->bind(':stay_id', $stayId);
        return $this->pdo->resultSet();
    }

     // saving a room into db
    public function addRoom($data) 
    {
    $type = 'stay';
    
        $this->pdo->query('INSERT INTO room (stay_id, name, type, price_per_night, description,
          status)
        VALUES (:stay_id, :name, :type,:price_per_night, :description,
         :status)');

          $this -> pdo -> bind(':stay_id', $data['stay_id']);
          $this -> pdo -> bind(':name', $data['name']);
          $this -> pdo -> bind(':type', $data['type']);
          $this -> pdo -> bind(':description', $data['description']);
          $this -> pdo -> bind(':price_per_night', $data['price_per_night']);
          $this -> pdo -> bind(':status', $data['status']);

          if ( $this->pdo ->execute())
         {
            return true;
           
         }
         else { return false;}

  }
}