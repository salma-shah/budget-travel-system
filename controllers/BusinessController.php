<?php

include_once __DIR__ . '/../helpers/session_helper.php';

class BusinessController {
    private $businessModel;
    private $destinationModel;
    private $amenityModel;
    private $roomModel;
    private $stayModel;
    private $restaurantModel;
    public function __construct(){
        $this->businessModel = new Business;
        $this->roomModel = new Room;
        $this->stayModel = new Stay;
        $this->restaurantModel = new Restaurant;
        $this->destinationModel = new Destination;
        $this->amenityModel = new Amenity;
    }

      // business login page
     public function showBusinessLogin()
    {
    include __DIR__ . '/../views/login-business.php';
    }


    // bsuiness profile
    public function getBusinessProfile()
    {
      // ensuring business is logged in and not any other type of user role
      if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'Business') {
        redirect ('/tripzly_test/home');
    }
    
     $businessId =$_SESSION['userId'];

    // getting business profile details and its listings
    $business= $this->businessModel->getBusinessById($businessId);
    $listings = $this->businessModel->getListingsByBusiness($businessId);
    
    if (!$business) {die('Business was not found.');}
    include __DIR__. '/../views/business-dashboard.php'; 
   }
    
    public function updateBusinessProfile() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $businessId = $_SESSION['userId'];

         $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $address = filter_var(trim($_POST['address']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $contactNumber = filter_var(trim($_POST['contactNumber']), FILTER_SANITIZE_NUMBER_INT);
         $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

        // validate the inputs before saving
            if (empty($data['name'])  || empty($data['email']) || empty($data['address']) || empty($data['contact_number'])) {
                flash("business_profile", "Please fill in all fields");
                redirect("../user_profile.php");
            } 

            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                flash("business_profile", "Invalid email");
                redirect("../signup.php");
            }

           // if email is already registered
             $existingUser = $this->userModel->findUserByEmail($email);
        if ($existingUser && $existingUser->user_id != $userId) {
            flash("business_profile", "This email is already in use. Please use another one.");
            redirect("../business_profile.php");
        }
            
            // initalize data
            $data = [
               'name' => $name,
               'address' => $address,
               'contact_number' => $contactNumber,
               'email' => $email,
            ];

            // update business profile
            if($this->businessModel->updateBusinessDetails($businessId, $data)){
                flash("business_profile", "The details were updated successfully!");
                redirect('/business_dashboard');
            }else{
                die("Something went wrong");
            }
        }
        }

// delete a item listing
public function deleteListingById($listingId)
{
    try {
         if ($this->businessModel->deleteListingById($listingId)) 
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

// add listing page
    public function getAddListingPage()
    {
        // destinatoins and amenities
   $destinations = $this->destinationModel->showAllDestinationNames(); 
   $amenities = $this->amenityModel->viewAllAmenities();
   $roomTypeResults = $this->roomModel->getRoomTypes();
   $stayTypeResults = $this->stayModel->getPropertyTypes();

   require_once __DIR__ . '/../views/list_property.php';

   }

   // getting the listing details
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
    $listing = $this->businessModel->viewListingDetails($listingId);
   if ($listing) 
    {
        echo json_encode($listing);
    } 
    else 
    {
        echo json_encode(['error' => 'Listing not found.']);
    }
   }

   // updating a listing
   public function updateListing()
   {

    // getting json data and validation of listing id
    $json =  file_get_contents('php://input');
    $data = json_decode($json, true);

    $listingId = $data['id'] ?? null;
    $type = $data['type'] ?? null;

     if (!$listingId) {
        echo json_encode(['error' => 'Listing ID not provided.']);
        return;
    }

    error_log("Raw JSON: " . $json); // to see if input is received

    // updating based on listing type
    try 
    {
        if ($type == 'stay')
        {
            $successUpdating = $this->stayModel->updateStayDetails($listingId, $data);
        }
        elseif ($type == 'tour')
        {
            $successUpdating = $this->tourModel->updateTourDetails($listingId, $data);
        }
        elseif ($type == 'restaurant')
        {
            $successUpdating = $this->restaurantModel->updateRestaurantDetails($listingId, $data);
        }
        else 
        {
            echo json_encode(['error' => 'Invalid listing type.']);
            return;
        }

        // if updating successful
        if ($successUpdating)
        {
            echo json_encode(['success' => true, 'message' => 'Listing updated successfully.']);
        } 
        else 
        {
            echo json_encode(['error' => 'Failed to update listing.']);
        }
        
    }
    catch (Exception $e)
    {
         echo json_encode(['error' => 'Exception occurred: ' . $e->getMessage()]);
    }

   }
 
}