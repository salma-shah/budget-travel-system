<?php
require_once __DIR__ . '/../Connection.php';

class ImageModel {
    private $pdo;

    public function __construct() {
        $this->pdo = new Connection;
    }

    // uploading and saving the image
    public function saveImage( $filePath, $alternativeText = null) 
    {
        $this->pdo->query("INSERT INTO image (file_path, alt_text) VALUES (:file_path, :alt_text)");
        $this->pdo->bind(':file_path', $filePath);
        $this->pdo->bind(':alt_text', $altText);
        if ($this->pdo->execute()) {
            return $this->pdo->lastInsertedId(); // we return the image_id that was just inserted
        }
        return false;
    }

    // attaching the img to its respected listing item
    public function attachImageToListing($imageId, $type, $listingId)
    {
          $this->pdo->query("INSERT INTO imageable (image_id, imageable_type, listing_id) VALUES (:image_id, :type, :listing_id)");
        $this->pdo->bind(':image_id', $imageId);
        $this->pdo->bind(':type', $type);
        $this->pdo->bind(':listing_id', $listingId);
       if ($this->pdo->execute()) {
            return true;
        }
        return false;
    }

     public function getImagesForListing($type, $listingId) {
        $this->pdo->query("
            SELECT i.* FROM image i
            JOIN imageable im ON i.image_id = im.image_id
            WHERE im.imageable_type = :type AND im.listing_id = :listing_id
        ");
        $this->pdo->bind(':type', $type);
        $this->pdo->bind(':listing_id', $listingId);
        return $this->pdo->resultSet();
    }

}

// contr
foreach ($stays as &$stay) {
    $stay['images'] = $imageModel->getImagesForListing('stay', $stay['stay_id']);
}