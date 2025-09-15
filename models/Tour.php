<?php

require_once __DIR__ . '/../Connection.php';

class Tour {
    private $pdo;
 
    public function __construct(){
        $this->pdo = new Connection;
       
    }

    // viewing all tours
    public function viewAllTours()
     {
        $this->pdo->query("
        SELECT t.tour_id, t.name, t.description, t.price_per_adult, i.file_path AS image, i.alt_text
        FROM tour t 
        LEFT JOIN image i 
        ON i.imageable_id = t.tour_id AND i.imageable_type = 'tour'");
        return $this->pdo->resultSet();
    }

    // this is for a specfic tour
    public function viewTourDetails($tourId)
    {
        $this->pdo->query("SELECT t.tour_id, t.name, t.description, t.included, t.price_per_adult, t.highlights, t.contacts, 
        t.duration,
        i.file_path AS image, i.alt_text
        FROM tour t
        LEFT JOIN image i 
        ON i.imageable_id = t.tour_id AND i.imageable_type = 'tour'
        WHERE tour_id = :tour_id
        LIMIT 1");
        $this->pdo->bind(':tour_id', $tourId);
        return $this->pdo->single();
    }

    // viewing all tours for specific destination 
    public function viewAllToursByDestination($destinationId)
    {
        $this->pdo->query('SELECT * FROM tour WHERE destination_id = :destination_id');  // adjust it accordingly
        $this->pdo->bind(':destination_id', $destinationId);
        return $this->pdo->resultSet();
    }

    // saving a tour into database
    public function addTour($data)
    {
        $this->pdo->query('INSERT INTO tour (destination_id, name, address, type, price_per_adult,
         price_per_child, duration, contacts, avg_rating, free_cancellation, is_available, status)
        VALUES (:destination_id, :name, :address,:type, :price_per_adult,
         :price_per_child, :duration, :contacts, :avg_rating, :free_cancellation, :is_available, :status)');

          $this -> pdo -> bind(':destination_id', $data['destination_id']);
          $this -> pdo -> bind(':name', $data['name']);
          $this -> pdo -> bind(':type', $data['type']);
          $this -> pdo -> bind(':address', $data['address']);
          $this -> pdo -> bind(':price_per_adult', $data['price_per_adult']);
          $this -> pdo -> bind(':price_per_child', $data['price_per_child']);
          $this -> pdo -> bind(':duration', $data['duration']);
          $this -> pdo -> bind(':contacts', $data['contacts']);
          $this -> pdo -> bind(':avg_rating', $data['avg_rating']);
          $this -> pdo -> bind(':free_cancellation', $data['free_cancellation']);
          $this -> pdo -> bind(':is_available', $data['is_available']);
          $this -> pdo -> bind(':status', $data['status']);
          
          if ( $this->pdo ->execute())
         {
            // inserting into bookable table
             $tourId = $this->pdo->lastInsertedId();
             $type = 'tour';
             $businessId = $_SESSION['userId'];
             $bookableInserted = $this->bookableModel->makeBookable($type, $businessId, $tourId);
         }
         else { return false;}
    
}  
     // get the tour details by their bookable Id
     public function getTourByBookableId($bookableId) 
    {
    $this->pdo->query('SELECT * FROM tour WHERE bookable_id = :bookable_id LIMIT 1');
    $this->pdo->bind(':bookable_id', $bookableId);
    return $this->pdo->single(); }
    
    // adult prices
    public function getTourPricesForAdult($tourId) {
    $this->pdo->query("SELECT price_per_adult FROM tour WHERE tour_id = :tour_id");
    $this->pdo->bind(':tour_id', $tourId);
    return $this->pdo->single(); }
    

    public function isTourAvailaible($tourId, $date)
    {
        $this->pdo->query("
        SELECT COUNT(*) as total
        FROM booking
        WHERE bookable_id = :tour_id
          AND bookable_type = 'tour'
          AND booking_start = :date
          AND status IN ('Confirmed')
    ");
    $this->pdo->bind(':tour_id', $tourId);
    $this->pdo->bind(':date', $date);

    $result = $this->pdo->single();
    return ($result && $result->total == 0);
    }
}
?>