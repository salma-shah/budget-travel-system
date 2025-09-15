<?php
require_once __DIR__ . '/../Connection.php';

class Business 
{
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

// business profile
    public function getBusinessById($businessId) 
    {
        $this->pdo->query('SELECT * FROM user WHERE user_id = :user_id');
        $this->pdo->bind(':user_id', $businessId);
        return $this->pdo->single();
    }

    public function updateBusinessDetails($businessId, $data)
    {
        $this->pdo->query('UPDATE user SET name = :name, email=:email, contact_number = :contact_number, address= :address 
        WHERE user_id = :user_id');

        $this->pdo->bind(':user_id', $businessId);
        $this->pdo->bind(':name', $data['name']);
        $this->pdo->bind(':email', $data['email']);
        $this->pdo->bind(':contact_number', $data['contact_number']);
        $this->pdo->bind(':address', $data['address']);

        // excuting
         if ( $this -> pdo -> execute())
         {
            return true;
         }
         else { return false;}
    }

    // by business
  public function getListingsByBusiness($userId) {

   $this->pdo->query("
    SELECT listings.*, u.name as business_name 
    FROM listings
    JOIN user u ON listings.business_id = u.user_id
    WHERE business_id = :business_id");
    $this->pdo->bind(':business_id', $userId);
    $listings = $this->pdo->resultSet();


    $fullListings = [];

    foreach ($listings as $listing) {
    $type = $listing->listable_type;
    $id = $listing->listable_id;
    $details = null;

    if ($type === 'stay') {
        $this->pdo->query("SELECT name, status FROM stay WHERE stay_id = :id");
      
      
    } elseif ($type === 'restaurant') {
        $this->pdo->query("SELECT name, status FROM restaurant WHERE restaurant_id = :id");
      
    } elseif ($type === 'tour') {
        $this->pdo->query("SELECT name, status FROM tour WHERE tour_id = :id");  
    }

     $this->pdo->bind(':id', $id);
    $details = $this->pdo->single();

    // assign listing name and status
    $listing->name = $details->name ?? 'Untitled';
    $listing->status = $details->status ?? 'Pending';

    $fullListings[] = $listing;
    
}

return $fullListings;
}

// delete the listing
    public function deleteListingById($listingId)
    {
    $this->pdo->query("SELECT * FROM listings WHERE id = :id");
    $this->pdo->bind(':id', $listingId);
    $listing= $this->pdo->single();

    if ($listing)
    {
         // delete from table based on type, whether stay or tour or whatever
        $type = $listing->listable_type;
        $itemId = $listing->listable_id;

        if ($type === 'stay') {
            $this->pdo->query("DELETE FROM stay WHERE stay_id = :id");
        } elseif ($type === 'tour') {
            $this->pdo->query("DELETE FROM tour WHERE tour_id = :id");
        } elseif ($type === 'restaurant') {
            $this->pdo->query("DELETE FROM restaurant WHERE restaurant_id = :id");
        }

        $this->pdo->bind(':id', $itemId);
        $this->pdo->execute();

        // delete the listing itself
        $this->pdo->query("DELETE FROM listings WHERE id = :id");
        $this->pdo->bind(':id', $listingId);
        return $this->pdo->execute();
    }
}

// view one lisitng's details
   public function viewListingDetails($listingId)
   {
    $this->pdo->query('
    SELECT l.*
    FROM listings l
    WHERE l.id = :id');
    $this->pdo->bind(':id', $listingId);
    $listing = $this->pdo->single();


    if (!$listing) return null;

     $type = $listing->listable_type;
     $itemId = $listing->listable_id;
    // now that we know what type and id it is, we can get its details

     if ($type === 'stay') 
    {
        $this->pdo->query("SELECT * FROM stay WHERE stay_id = :id");
    } 
    elseif ($type === 'tour') 
    {
        $this->pdo->query("SELECT * FROM tour WHERE tour_id = :id");
    } 
    elseif ($type === 'restaurant') 
    {
        $this->pdo->query("SELECT * FROM restaurant WHERE restaurant_id = :id");
    } 
    else {
        return $listing; 
    }
    
    // binding
    $this->pdo->bind(':id', $itemId);
    $details= $this->pdo->single();
    $listing->details = $details;

    return $listing;  
   }
}
?>
