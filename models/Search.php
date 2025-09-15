<?php

class Search {

    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    public function searchAvailableStays($destination, $checkin, $checkout){

        // selcting image id by the top one for the stay, and the rooms which belong to the stay
        // we check if room is avialbable and can be booked
    $this->pdo->query("
       SELECT DISTINCT s.*,
       (SELECT i.file_path FROM image i
       WHERE i.imageable_id = s.stay_id
       AND i.imageable_type = 'stay'
       ORDER BY i.image_id ASC
       LIMIT 1) AS image,
      (SELECT i.alt_text FROM image i
      WHERE i.imageable_id = s.stay_id
      AND i.imageable_type = 'stay'
      ORDER BY i.image_id ASC
      LIMIT 1) AS alt_text  FROM stay s
      JOIN room r ON s.stay_id = r.stay_id
      WHERE s.address LIKE :destination
      AND r.status = 'Available'
      AND NOT EXISTS (
      SELECT 1 FROM booking b WHERE b.bookable_type = 'room'AND b.bookable_id = r.room_id
      AND b.status = 'Confirmed'
      AND (:checkin < b.booking_end AND :checkout > b.booking_start))
      GROUP BY s.stay_id
    ");
    $this->pdo->bind(':destination', '%' . $destination . '%');
    $this->pdo->bind(':checkin', $checkin);
    $this->pdo->bind(':checkout', $checkout);

    return $this->pdo->resultSet();
}


    // searching users
    public function searchUsers($searchValue)
    {
        $this -> pdo -> query("SELECT * FROM user 
        WHERE role = :role AND
       ( name LIKE :searchValue1
        OR email LIKE :searchValue2)
        LIMIT 7");
        
         $this-> pdo -> bind(':role', "User");
        $this-> pdo -> bind(':searchValue1', '%'. $searchValue . '%');
        $this-> pdo -> bind(':searchValue2', '%'. $searchValue . '%');
        return  $this-> pdo -> execute() ? $this->pdo->resultSet() : [];
    }

    // searching businesses
      public function searchBusinesses($searchValue)
    {
        $this -> pdo -> query("SELECT * FROM user 
        WHERE role = :role AND
        (name LIKE :searchValue1
        OR email LIKE :searchValue2)
        LIMIT 7");
        
         $this-> pdo -> bind(':role', "Business");
        $this-> pdo -> bind(':searchValue1', '%'. $searchValue . '%');
        $this-> pdo -> bind(':searchValue2', '%'. $searchValue . '%');
        return  $this-> pdo -> execute() ? $this->pdo->resultSet() : [];
    }

    // searching for listings - stays, tours, restaurants
         public function searchListings($searchValue)
    {
        $this -> pdo -> query("SELECT l.*, u.name AS business_name,
         COALESCE(s.name, t.name, r.name) AS name,
          COALESCE(s.status, t.status, r.status) AS status
        FROM listings l
        JOIN user u ON l.business_id = u.user_id
        LEFT JOIN stay s ON (l.listable_type = 'stay' AND l.listable_id = s.stay_id)
        LEFT JOIN tour t ON (l.listable_type = 'tour' AND l.listable_id = t.tour_id)
        LEFT JOIN restaurant r ON (l.listable_type = 'restaurant' AND l.listable_id = r.restaurant_id)
        WHERE u.role = 'Business'
        AND (
            u.name LIKE :searchValue
            OR s.name LIKE :searchValue
            OR t.name LIKE :searchValue
            OR r.name LIKE :searchValue
        )
        LIMIT 7");
        
        $this-> pdo -> bind(':searchValue', '%'. $searchValue . '%');
        return  $this-> pdo -> execute() ? $this->pdo->resultSet() : [];
    }

       public function searchAllAvailableStays($checkin, $checkout){

        // selcting image id by the top one for the stay, and the rooms which belong to the stay
        // we check if room is avialbable and can be booked
    $this->pdo->query("
       SELECT DISTINCT s.*,
       (SELECT i.file_path FROM image i
       WHERE i.imageable_id = s.stay_id
       AND i.imageable_type = 'stay'
       ORDER BY i.image_id ASC
       LIMIT 1) AS image,
      (SELECT i.alt_text FROM image i
      WHERE i.imageable_id = s.stay_id
      AND i.imageable_type = 'stay'
      ORDER BY i.image_id ASC
      LIMIT 1) AS alt_text  FROM stay s
      JOIN room r ON s.stay_id = r.stay_id
      WHERE r.status = 'Available'
      AND NOT EXISTS (
      SELECT 1 FROM booking b WHERE b.bookable_type = 'room'AND b.bookable_id = r.room_id
      AND b.status = 'Confirmed'
      AND (:checkin < b.booking_end AND :checkout > b.booking_start))
      GROUP BY s.stay_id
    ");
  
    $this->pdo->bind(':checkin', $checkin);
    $this->pdo->bind(':checkout', $checkout);

    return $this->pdo->resultSet();
}
}




?>