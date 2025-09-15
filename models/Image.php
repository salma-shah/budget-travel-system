<?php

require_once __DIR__ . '/../Connection.php';

class Image {
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;    
    }


// saving the  images
public function saveImage($imageableId, $imageableType, $filePath, $altText)
{
    $this->pdo->query("INSERT INTO image (imageable_id, imageable_type, alt_text, file_path) VALUES (:imageable_id, :imageable_type, :alt_text, :file_path)");
    
    $this->pdo->bind(':imageable_id', $imageableId);
    $this->pdo->bind(':file_path', $filePath);     
    $this->pdo->bind(':imageable_type', $imageableType);
    $this->pdo->bind(':alt_text', $altText);
    return $this->pdo->execute();
}
}


?>