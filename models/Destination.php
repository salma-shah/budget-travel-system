<?php

require_once __DIR__ . '/../Connection.php';

class Destination 
{
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    // viewing all destinations
    public function viewAllDestinations()
{
    $this->pdo->query("
        SELECT d.destination_id, d.name, i.file_path AS image, i.alt_text
        FROM destination d
        LEFT JOIN image i 
        ON i.imageable_id = d.destination_id AND i.imageable_type = 'destination'");
    
    return $this->pdo->resultSet();
}

    // getting destination values in a dropdown list
    public function showAllDestinationNames()
    {
         $this->pdo->query('SELECT destination_id, name FROM destination'); 
        $destinations= $this->pdo->resultSet();
        return $destinations;
    }

}

?>
