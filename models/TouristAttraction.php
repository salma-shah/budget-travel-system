<?php
require_once __DIR__ . '/../Connection.php';

class TouristAttraction {
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    public function addAttraction($data) 
    {
        // query to insert data
        $this -> pdo -> query('INSERT INTO attraction(name, location, description, open_hours, destination_id)
        VALUES (:name, :location, :description, :open_hours, :destination_id)');

         $this -> pdo -> bind(':name', $data['name']);
         $this -> pdo -> bind(':location', $data['location']);
         $this -> pdo -> bind(':description', $data['description']);
         $this -> pdo -> bind(':open_hours', $data['open_hours']);
         $this -> pdo -> bind(':destination_id', $data['destination_id']);

         // image uploading

           if ( $this -> pdo -> execute())
         {
            return true;
         }
         else { return false;}
    }

     public function viewAllTouristAttractions()
     {
        $this->pdo->query("
        SELECT t.attraction_id, t.name, i.file_path AS image, i.alt_text
        FROM tourist_attraction t 
        LEFT JOIN image i 
        ON i.imageable_id = t.attraction_id AND i.imageable_type = 'attraction'");
        return $this->pdo->resultSet();
    }

    // specific attraction
    public function viewAttractionDetails($attractionId)
    {
        // tour details first
         $this->pdo->query("SELECT * FROM tourist_attraction WHERE attraction_id = :attraction_id LIMIT 1");
         $this->pdo->bind(':attraction_id', $attractionId);
         $attraction = $this->pdo->single();

         // images
        $this->pdo->query('
        SELECT alt_text , file_path AS image
        FROM image 
        WHERE imageable_id = :attraction_id AND imageable_type = "attraction"
        ');
        $this->pdo->bind(':attraction_id', $attractionId);
        $attraction->image = $this->pdo->single();

         // links
        $this->pdo->query('
        SELECT title, url 
        FROM reference_link 
        WHERE linkable_id = :attraction_id AND linkable_type = "attraction"');
        $this->pdo->bind(':attraction_id', $attractionId);
        $attraction->reference_links = $this->pdo->resultSet();
        
        return $attraction;
    }

    public function viewAllTouristAttractionsByDestintion($destinationId)
    {
        
     $this -> pdo -> query('SELECT * FROM attraction WHERE destination_id = :destination_id');
     $this->pdo->bind(':favouritable_id', $destinationId);
    // returning the results
    return $this->pdo->resultSet();
    }
} 




?>