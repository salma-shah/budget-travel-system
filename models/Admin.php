 <?php

require_once __DIR__ . '/../Connection.php';

class Admin 
{
    // connecting to database and using the database which already exists, which we have access to
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }
    
    // counting functions
    public function countUsers() { 
    $this->pdo->query('SELECT COUNT(*) AS total FROM user WHERE role= :role');
    $this->pdo->bind(':role', 'User');
    return $this->pdo->single(); 
}

    public function countBusinesses()
    {
    $this->pdo->query('SELECT COUNT(*) AS total FROM user WHERE role= :role');
    $this->pdo->bind(':role', 'Business');
    return $this->pdo->single();
    }

    public function countAllPendingListings(){
    $this->pdo->query('
        SELECT (
            (SELECT COUNT(*) FROM tour WHERE status = "Pending") +
            (SELECT COUNT(*) FROM stay WHERE status = "Pending") +
            (SELECT COUNT(*) FROM room WHERE status = "Pending") +
            (SELECT COUNT(*) FROM restaurant WHERE status = "Pending")
        ) AS total
    ');
    return $this->pdo->single();}

    // deleting the user 
    public function deleteUserById($userId)
    {
        $this->pdo->query("DELETE FROM user WHERE user_id = :user_id");
        $this->pdo->bind(':user_id', $userId);
        return $this->pdo->execute();
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

        // Delete the listing itself
        $this->pdo->query("DELETE FROM listings WHERE id = :id");
        $this->pdo->bind(':id', $listingId);
        return $this->pdo->execute();
    }

    return false;
    }

    // getting users detais
     public function getAllUserDetails() 
    {
        $this->pdo->query('SELECT * FROM user WHERE role=:role');
        $this->pdo->bind(':role', "User");
        return $this->pdo->resultSet();
    }

    // getting all businesses
    public function getAllBusinessesDetails() 
    {
        $this->pdo->query('SELECT * FROM user WHERE role=:role');
        $this->pdo->bind(':role', "Business");
        return $this->pdo->resultSet();
    }

    // this is to get listings

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
            $this->pdo->query("SELECT * FROM stay WHERE stay_id = :id");
        } elseif ($type === 'restaurant') {
            $this->pdo->query("SELECT * FROM restaurant WHERE restaurant_id = :id");
        } elseif ($type === 'tour') {
            $this->pdo->query("SELECT * FROM tour WHERE tour_id = :id");
        } else {
            // for unknwon error type
            $details = null;
        }

        if ($details === null && in_array($type, ['stay', 'restaurant', 'tour'])) {
            $this->pdo->bind(':id', $id);
            $details = $this->pdo->single();
        }

        // ff no details found, use defaults
        if ($details) {
            $listing->name = $details->name ?? 'Untitled';
            $listing->status = $details->status ?? 'Pending';
        } else {
            $listing->name = 'Untitled';
            $listing->status = 'Pending';
        }

        $fullListings[] = $listing;
    }

    return $fullListings;
}

// all
    public function getAllListings() 
    {
        $this->pdo->query("
        SELECT listings.*, u.name as business_name
        FROM listings
        JOIN user u ON listings.business_id = u.user_id");
    $listings = $this->pdo->resultSet();

    $fullListings = [];

    foreach ($listings as $listing) {
        $type = $listing->listable_type;
        $id = $listing->listable_id;
        $details = null;

        if ($type === 'stay') {
            $this->pdo->query("SELECT * FROM stay WHERE stay_id = :id");
        } elseif ($type === 'restaurant') {
            $this->pdo->query("SELECT * FROM restaurant WHERE restaurant_id = :id");
        } elseif ($type === 'tour') {
            $this->pdo->query("SELECT * FROM tour WHERE tour_id = :id");
        } else {
            // for unknwon error type
            $details = null;
        }

        if ($details === null && in_array($type, ['stay', 'restaurant', 'tour'])) {
            $this->pdo->bind(':id', $id);
            $details = $this->pdo->single();
        }

        // If no details found, use defaults
        if ($details) {
            $listing->name = $details->name ?? 'Untitled';
            $listing->status = $details->status ?? 'Pending';
        } else {
            $listing->name = 'Untitled';
            $listing->status = 'Pending';
        }

        $fullListings[] = $listing;
    }

    return $fullListings;
}

   // approving listing
   public function approveListing($listingId)
   {
    // we take the details from listings first, based on the id
    $this->pdo->query('SELECT listable_id,listable_type FROM listings WHERE id= :id');
    $this->pdo->bind(':id', $listingId);
    $listing = $this->pdo->single();

    if ($listing)
    {
        $type = $listing->listable_type;
        $itemId = $listing->listable_id;

        // now that we know which id and type it is, lets update respective status
        if ($type === 'stay') 
        {
            $this->pdo->query("UPDATE stay SET status = 'Approved' WHERE stay_id = :id");
        } 
        elseif ($type === 'tour') 
        {
            $this->pdo->query("UPDATE tour SET status = 'Approved' WHERE tour_id = :id");
        } 
        elseif ($type === 'restaurant') 
        {
            $this->pdo->query("UPDATE restaurant SET status = 'Approved' WHERE restaurant_id = :id");
        } 
        else {return false; }

        $this->pdo->bind(':id', $itemId);
        return $this->pdo->execute();
    }
    return false ; // if no listing found
   
   }

   // reject listings
    public function rejectListing($listingId)
   {
    // we take the details from listings first, based on the id
    $this->pdo->query('SELECT listable_id,listable_type FROM listings WHERE id= :id');
    $this->pdo->bind(':id', $listingId);
    $listing = $this->pdo->single();

    if ($listing)
    {
        $type = $listing->listable_type;
        $itemId = $listing->listable_id;

        // now that we know which id and type it is, lets update respective status
        if ($type === 'stay') 
        {
            $this->pdo->query("UPDATE stay SET status = 'Rejected' WHERE stay_id = :id");
        } 
        elseif ($type === 'tour') 
        {
            $this->pdo->query("UPDATE tour SET status = 'Rejected' WHERE tour_id = :id");
        } 
        elseif ($type === 'restaurant') 
        {
            $this->pdo->query("UPDATE restaurant SET status = 'Rejected' WHERE restaurant_id = :id");
        } 
        else {return false; }

        // binding
        $this->pdo->bind(':id', $itemId);
        return $this->pdo->execute();
    }
    return false ; // if no listing found
   
   }

   // view one lisitng's details
   public function viewListingDetails($listingId)
   {
    $this->pdo->query('
    SELECT l.*, u.name AS business_name 
    FROM listings l
    JOIN user u ON l.business_id = u.user_id
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