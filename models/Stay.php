<?php

require_once __DIR__ . '/../Connection.php';

class Stay 
{
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    // getting property types
    public function getPropertyTypes()
    {
        $this->pdo->query('SELECT DISTINCT property_type from stay');
        $stayTypeResults = $this->pdo->resultSet();
        return $stayTypeResults;
    }
    
    // viewing all approved stays
      public function viewAllStays(){
        $this->pdo->query("
        SELECT s.stay_id, s.name, s.property_type, 
         (SELECT i.file_path FROM image i 
          WHERE i.imageable_id = s.stay_id AND i.imageable_type = 'stay' 
          ORDER BY i.image_id ASC LIMIT 1) AS image,
        (SELECT i.alt_text FROM image i 
          WHERE i.imageable_id = s.stay_id AND i.imageable_type = 'stay' 
          ORDER BY i.image_id ASC LIMIT 1) AS alt_text
        FROM stay s
        WHERE s.status =:status");
      $this->pdo->bind(':status', "Approved");
    return $this->pdo->resultSet();
    }

    // viewing specific stays
    public function viewStayDetails($stayId)
    {
      $this->pdo->query('SELECT s.stay_id, s.name, s.destination_id, d.name AS destination_name, s.address, s.description, s.contacts, s.free_cancellation
        FROM stay s
        LEFT JOIN destination d ON s.destination_id = d.destination_id
        WHERE stay_id = :stay_id
        LIMIT 1');
        $this->pdo->bind(':stay_id', $stayId);
        $stay= $this->pdo->single();

        // now lets get the amenities
        $this->pdo->query('
        SELECT a.name 
        FROM amenity a
        INNER JOIN stay_amenity sa ON sa.amenity_id = a.id
        WHERE sa.stay_id = :stay_id');
        $this->pdo->bind(':stay_id', $stayId);
        $stay->amenities = $this->pdo->resultSet(); // attach the amenities to the stay result

        $this->pdo->query('
        SELECT alt_text , file_path AS image
        FROM image 
        WHERE imageable_id = :stay_id AND imageable_type = "stay"
        ');
        $this->pdo->bind(':stay_id', $stayId);
        $stay->images = $this->pdo->resultSet(); // now images

        return $stay;
    }
 

    // viewing all stays for specific destination 
    public function viewAllStaysByDestination($destinationId)
    {
        $this->pdo->query('SELECT * FROM stay WHERE destination_id = :destination_id');  // adjust it accordingly
        $this->pdo->bind(':destination_id', $destinationId);
        return $this->pdo->resultSet();
    }

    // adding amenities to a stay 
    public function addAmenityToStay($stayId, $amenityId)
    {
      $this->pdo->query('INSERT INTO stay_amenity(stay_id, amenity_id) VALUES (:stay_id, :amenity_id)');
      $this -> pdo -> bind(':stay_id', $stayId);
      $this -> pdo -> bind(':amenity_id', $amenityId);
       return $this->pdo->execute();
    }

    // saving a stay into db
    public function addStay($data) 
    {
        $this->pdo->query('INSERT INTO stay (destination_id, name, address,description,
          contacts,  free_cancellation, property_type, status)
        VALUES (:destination_id, :name, :address, :description,
        :contacts, :free_cancellation, :property_type, :status)');

          $this -> pdo -> bind(':destination_id', $data['destination_id']);
          $this -> pdo -> bind(':name', $data['name']);
          $this -> pdo -> bind(':address', $data['address']);
          $this -> pdo -> bind(':description', $data['description']);
          $this -> pdo -> bind(':contacts', $data['contacts']);
          $this -> pdo -> bind(':free_cancellation', $data['free_cancellation']);
          $this -> pdo -> bind(':property_type', $data['property_type']);
          $this -> pdo -> bind(':status', $data['status']);

         if ( $this->pdo ->execute())
         {
            // inserting 
            return $stayId = $this->pdo->lastInsertedId();
            }
         else { return false;}
  }

  // create stay listing
  public function createStayListing($stayId, $businessId)
{
    $type = 'stay';
    $this->pdo->query("INSERT INTO listings (listable_type, listable_id, business_id)
                       VALUES (:listable_type, :listable_id, :business_id)");

    $this->pdo->bind(':listable_id', $stayId);
    $this->pdo->bind(':listable_type', $type);
    $this->pdo->bind(':business_id', $businessId);

    return $this->pdo->execute();
}

// updating a stay info
public function updateStayDetails($stayId, $data)
{
  $this->pdo->query('UPDATE stay SET name = :name, address = :address, description = :description,
                       contacts = :contacts WHERE stay_id = :id');

    $this->pdo->bind(':name', $data['name']);
    $this->pdo->bind(':address', $data['address']);
    $this->pdo->bind(':description', $data['description']);
    $this->pdo->bind(':contacts', $data['contacts']);
    $this->pdo->bind(':id', $stayId);

    return $this->pdo->execute();
}

}

?>