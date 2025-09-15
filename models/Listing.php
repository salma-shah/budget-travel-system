<?php

require_once __DIR__ . '/../Connection.php';

class Listing {
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;    
    }

public function createListing($listingId, $type, $businessId)
{
    $this->pdo->query("INSERT INTO listings (listable_type, listable_id, business_id)
                       VALUES (:listable_type, :listable_id, :business_id)");

    $this->pdo->bind(':listable_id', $listingId);
    $this->pdo->bind(':listable_type', $type);
    $this->pdo->bind(':business_id', $businessId);

    return $this->pdo->execute();
}

}


?>