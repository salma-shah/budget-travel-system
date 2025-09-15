<?php

include_once __DIR__ . '/../helpers/session_helper.php';

class AdminController {

    private $adminModel;
    public function __construct(){
        $this->adminModel = new Admin;
    }

    // admin login page
     public function showAdminLogin()
    {
    include __DIR__ . '/../views/login-admin.php';
    }

    // dahsboard statistics count
   public function getDashboardStats() {
      // ensuring admin is logged in and not any other type of user role
      if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'Administrator') {
        redirect ('/tripzly_test/home');
    }
    
    try {
        $stats = [
            'totalUsers' => $this->adminModel->countUsers()->total ?? 0,
            'registeredBusinesses' => $this->adminModel->countBusinesses()->total ?? 0,
            // 'totalListings' => $this->adminModel->countListings()->total ?? 0,
            'pendingApprovals' => $this->adminModel->countAllPendingListings()->total ?? 0
        ];
        return $stats;
    } catch (Exception $e) {
        return [
            'totalUsers' => 0,
            'registeredBusinesses' => 0,
            // 'totalListings' => 0,
            'pendingApprovals' => 0
        ];
    }
   
}


// delete a user
public function deleteUserById($userId)
{
    try {
         if ($this->adminModel->deleteUserById($userId)) 
            {
                echo "User deleted successfully.";
            } else 
            {
                echo "Failed to delete user.";
            }
    }
    catch (Exception $ex)
    {
        echo "There was an error in deleting the user account: " . $ex->getMessage();
    }
}

// delete a item listing
public function deleteListingById($listingId)
{
    try {
         if ($this->adminModel->deleteListingById($listingId)) 
            {
                echo "Item deleted successfully.";
            } else 
            {
                echo "Failed to delete the listing item.";
            }
    }
    catch (Exception $ex)
    {
        echo "There was an error in deleting the item: " . $ex->getMessage();
    }
}

// show all users and their info
public function getAllUserDetails()
{
      // ensuring admin is logged in and not any other type of user role
      if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'Administrator') {
        redirect ('/tripzly_test/home');
    }
    $users = $this->adminModel->getAllUserDetails();
    require_once __DIR__ . '/../views/manage_users.php';

}

// show all businesses and their info
public function getAllBusinessesDetails()
{
     // ensuring admin is logged in and not any other type of user role
      if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'Administrator') {
        redirect ('/tripzly_test/home');
    }
    $businesses= $this->adminModel->getAllBusinessesDetails();
    require_once __DIR__ . '/../views/manage_businesses.php';
     
 

}

// show the business' listings
 public function viewListingsByBusiness($businessId = null)
 {
      // ensuring admin is logged in and not any other type of user role
      if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'Administrator') {
        redirect ('/tripzly_test/home');
    }
    if ($businessId)
    {
        $listings= $this->adminModel->getListingsByBusiness($userId);
        $title = "Listings by Business ID: $budinessId"; 
    }
    else 
    {
         $listings= $this->adminModel->getAllListings();
         $title = "All Listings."; 
    } 
 }

 public function viewListings($businessId = null) {

    // ensuring admin is logged in and not any other type of user role
      if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'Administrator') {
        redirect ('/tripzly_test/home');
    }

    if ($businessId) {
        $listings = $this->adminModel->getListingsByBusiness($businessId);
    } else {
        $listings = $this->adminModel->getAllListings();
    };
    
    // pass to to the view 
    require_once __DIR__ . '/../views/manage_listings.php';
}

// approving a listing
public function approveListing($listingId)
{
     if ($this->adminModel->approveListing($listingId)) {
        echo "Listing approved successfully.";
    } else {
        echo "Failed to approve the listing.";
    }
}

// rejecting a listing
public function rejectListing($listingId)
{
     if ($this->adminModel->rejectListing($listingId)) {
        echo "Listing rejected successfully.";
    } else {
        echo "Failed to reject the listing.";
    }
}

// viewing one listings details
public function viewListingDetails($listingId)
   {
     
    // mkaing sure we have a listing id
     $listingId = $_POST['listingID'] ?? null;

    if (!$listingId) {
        echo json_encode(['error' => 'Listing ID not provided.']);
        return;
    }

    // getting the listing then passing to frontend jscript
    $listing = $this->adminModel->viewListingDetails($listingId);
   if ($listing) 
    {
        echo json_encode($listing);
    } 
    else 
    {
        echo json_encode(['error' => 'Listing not found.']);
    }
   }


}