<?php

class Filter {

    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    public function filterByBudget($budget)
    {
          $this -> pdo -> query("SELECT * FROM room WHERE price_per_night=:budget OR price_per_night<:budget");
          $this-> pdo ->bind(':budget', $budget);

         if ($this->pdo->execute()) {
            // return values that fit the budget
            return $this->pdo->resultSet(); }
             else {  return [];  }  // or empty array
    }

       public function filterByAmenity(array $stayIds, array $amenities)
       {
        if (empty($stayIds)) return [];

        $stayPlaceholders = implode(',', array_fill(0, count($stayIds), '?'));
        $amenityPlaceholders = implode(',', array_fill(0, count($amenities), '?'));
        $amenityCount = count($amenities);

        // the query
         $this -> pdo -> query
         ("SELECT s.* 
         FROM stay s
         JOIN stay_amenity sa ON sa.stay_id = s.stay_id
         JOIN amenity a ON a.id = sa.id
         WHERE s.stay_id IN ($stayPlaceholders)
         AND sa.amenity_id IN ($amenityPlaceholders)
         GROUP BY s.stay_id
         HAVING COUNT(DISTINCT sa.amenity_id) = ?");

         // binding

         $i = 1;
    foreach ($stayIds as $stayId) {
        $this->pdo->bind($i++, $stayId);
    }

    // Bind amenity IDs
    foreach ($amenities as $amenityId) {
        $this->pdo->bind($i++, $amenityId);
    }

    // Bind count of amenities for HAVING clause
    $this->pdo->bind($i, $amenityCount);

        return $this->pdo->resultSet();
    }


    // filtering by BOTH
    public function filterByBudgetAndAmenities($budget, $amenityIds = [])
    {
        // first getting the stays
        $this->pdo->query('SELECT DISTINCT s.*
        FROM stay s
        JOIN room r ON s.stay_id = r.stay_id');

        // checking if any amenities are present
        if (!empty($amenityIds))
        {
            // a temproary placeholder for the amenities
            $amenityPlaceholders = [];
             foreach ($amenityIds as $index => $amenityId) {
                 $amenityPlaceholders[] = ":amenity_$index"; 
             } 

             // seperating by commas
            $placeholdersString = implode(',', $amenityPlaceholders);

            // join the stays where the amenities match according to what user gave
            $this->pdo->query('JOIN stay_amenity sa ON s.stay_id = sa.stay_id
            WHERE r.price_per_night <= ?
            AND sa.amenity_id IN ($placeholders)
            GROUP BY s.stay_id
            HAVING COUNT(DISTINCT sa.amenity_id) = ?');
        }
        
        // if no amenities entered, only filter by price
        else 
        {
            $this->pdo->query('WHERE r.price_per_night = :budget ');
        }

        // bind and execture
        // budget
        $this->pdo->bind(':budget', $budget);

        // amenities
        if (!empty($amenityIds)) 
        {
        foreach ($amenityIds as $index => $amenityId) {
            $this->pdo->bind(":amenity_$index", $amenityId);
        }
        $this->pdo->bind(':amenity_count', count($amenityIds));
    }

    // exectuing
    if ($this->pdo->execute())
    {
        return $this->pdo->resultSet();
    }
    else { return []; }
    }
    
public function filterAvailableStays($filters)
{
    // creating the array of filters
    $budget = $filters['budget'];
    $checkin = $filters['checkin'];
    $checkout = $filters['checkout'];
    $amenities = $filters['amenities'];

    // putting the values that should be bound into another array
    $params = [
        ':budget' => $budget,
        ':checkin' => $checkin,
        ':checkout' => $checkout,
        ':status' => 'approved'
    ];

    //  using BASE SQL for developer clarity
    // this query selects the stays, pairs it with its images / alt text
    // then checks the rooms that belong to the stay
    // for room availibility 
    // if a booking with the room id is CONFIRMED and matches the dates entered
    //  then it will not display
    // otherwise it will
    $sql = "
        SELECT DISTINCT s.stay_id, s.name, s.property_type, r.price_per_night,
          (
            SELECT i.file_path 
            FROM image i 
            WHERE i.imageable_id = s.stay_id AND i.imageable_type = 'stay'
            ORDER BY i.image_id ASC LIMIT 1
          ) AS image,
          (
            SELECT i.alt_text 
            FROM image i 
            WHERE i.imageable_id = s.stay_id AND i.imageable_type = 'stay'
            ORDER BY i.image_id ASC LIMIT 1
          ) AS alt_text
        FROM stay s
        JOIN room r ON s.stay_id = r.stay_id
          AND r.status = 'Available'
          AND NOT EXISTS (
            SELECT 1 FROM booking b
            WHERE b.bookable_id = r.room_id
              AND b.bookable_type = 'room'
              AND b.status IN ('Confirmed', 'Pending')
              AND (:checkin < b.booking_end AND :checkout > b.booking_start)
          )
        WHERE r.price_per_night <= :budget
          AND s.status = :status
    ";

    // checking if any amentiies were entered and creating a placeholder array for them
    if (!empty($amenities)) {
        $placeholderList = [];
        foreach ($amenities as $index => $amenityId) {
            $key = ":amenity$index";
            $placeholderList[] = $key;
            $params[$key] = $amenityId;
        }

        // amenities are seperated by a ',;
        // checking of amenities match the stay
        // absed on stay amenity data
        $inClause = implode(',', $placeholderList);
        $sql .= "
            AND s.stay_id IN (
              SELECT sa.stay_id
              FROM stay_amenity sa
              WHERE sa.amenity_id IN ($inClause)
              GROUP BY sa.stay_id
              HAVING COUNT(DISTINCT sa.amenity_id) = " . count($amenities) . "
            )
        ";
    }

    // executing the full query
    $this->pdo->query($sql);

    // binding values
    foreach ($params as $key => $value) {
        $this->pdo->bind($key, $value);
    }

    // returning results
    return $this->pdo->resultSet();
}

// this function is similiar to the above one
// additional parameter of DESTINATION
public function filterAvailableStaysByDestination($filters)
{
    $destination = $filters['destination'];
    $budget = $filters['budget'];
    $checkin = $filters['checkin'];
    $checkout = $filters['checkout'];
    $amenities = $filters['amenities'];

    $params = [
        ':destination' => '%'.$destination.'s%',
        ':budget' => $budget,
        ':checkin' => $checkin,
        ':checkout' => $checkout,
        ':status' => 'approved'
    ];

    $sql = "
        SELECT DISTINCT s.stay_id, s.name, s.property_type, r.price_per_night,
          (
            SELECT i.file_path 
            FROM image i 
            WHERE i.imageable_id = s.stay_id AND i.imageable_type = 'stay'
            ORDER BY i.image_id ASC LIMIT 1
          ) AS image,
          (
            SELECT i.alt_text 
            FROM image i 
            WHERE i.imageable_id = s.stay_id AND i.imageable_type = 'stay'
            ORDER BY i.image_id ASC LIMIT 1
          ) AS alt_text
        FROM stay s
        JOIN room r ON s.stay_id = r.stay_id
          AND r.status = 'Available'
          AND NOT EXISTS (
            SELECT 1 FROM booking b
            WHERE b.bookable_id = r.room_id
              AND b.bookable_type = 'room'
              AND b.status IN ('Confirmed', 'Pending')
              AND (:checkin < b.booking_end AND :checkout > b.booking_start)
          )
        WHERE r.price_per_night <= :budget
          AND s.status = :status
          AND s.address LIKE :destination
    ";

    if (!empty($amenities)) {
        $placeholderList = [];
        foreach ($amenities as $index => $amenityId) {
            $key = ":amenity$index";
            $placeholderList[] = $key;
            $params[$key] = $amenityId;
        }

        $inClause = implode(',', $placeholderList);
        $sql .= "
            AND s.stay_id IN (
              SELECT sa.stay_id
              FROM stay_amenity sa
              WHERE sa.amenity_id IN ($inClause)
              GROUP BY sa.stay_id
              HAVING COUNT(DISTINCT sa.amenity_id) = " . count($amenities) . "
            )
        ";
    }

    $this->pdo->query($sql);

    foreach ($params as $key => $value) {
        $this->pdo->bind($key, $value);
    }

    return $this->pdo->resultSet();
}

}

?>