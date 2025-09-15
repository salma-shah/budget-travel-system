<?php
require_once __DIR__ . '/../helpers/session_helper.php';

class StayController 
{
    private $stayModel;
    private $reviewModel;
    private $amenityModel;
    private $filterModel;
    private $listingModel;
    private $imageModel;
    private $roomModel;
    public function __construct(){
        $this->stayModel = new Stay;
        $this->reviewModel = new Review;
        $this->amenityModel = new Amenity;
        $this->filterModel = new Filter;
         $this->roomModel = new Room;
        $this->listingModel = new Listing;
       $this->imageModel = new Image;
    }

    public function viewAllStays(){
       return $this->stayModel->viewAllStays();
    }

    public function showAllStaysPage()
     {
          $stays= $this->stayModel->viewAllStays();
          $amenities = $this->amenityModel->viewAllAmenities();
          require_once __DIR__ . '/../views/stays.php';
     }

    // specfifc stay
    public function showStayDetails($stayId)
    {
        $stay= $this->stayModel->viewStayDetails($stayId);

        // fetching reviews too
         $reviewableType = 'stay';
         $reviews = $this->reviewModel->getAllReviewsForItem($stayId, $reviewableType);

        if (!$stay) {die('Stay not found.');}
        require_once __DIR__ . '/../views/stay_details.php';
    }

    public function viewAllApprovedStays(){
       return $this->stayModel->viewAllApprovedStays();
    }

    public function viewAllStaysByDestination()
    {
        $destinationId = $_SESSION['destinationId'];
        $stays = $this->stayModel->viewAllStaysByDestination($destinationId);
        return $stays;
    }

    public function filterStaysByAmenities()
     {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $amenities = $_POST['amenities'] ?? [];

        if (empty($amenities)) {
            echo "<p>Please select at least one amenity.</p>";
            return;
        }

        // only using staying from stay grid with results
        if (!isset($_SESSION['current_stays']) || empty($_SESSION['current_stays'])) {
            echo "<p>No stay results to filter.</p>";
            return;
        }

        $gridStays = $_SESSION['current_stays'];
        $stayIds = array_map(fn($s) => $s->stay_id, $gridStays);

        $filtered = $this->filterModel->filterByAmenity($stayIds, $amenities);

        // show updated grid
        $_SESSION['current_stays'] = $filtered; 
        include __DIR__ . '/../views/partials/stay_grid.php';
    }
     }

    public function addStay()
    {
         if (($_SERVER['REQUEST_METHOD'] == 'POST'))
      {
            try 
        {
           $businessId = $_SESSION['userId'];
           $destinationId = filter_var(trim($_POST['destinationId']), FILTER_SANITIZE_NUMBER_INT);
           $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $address = filter_var(trim($_POST['address']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          
           $freeCancellationRaw = trim($_POST['freeCancellation']); 
           $propertyType = isset($_POST['propertyType']) ? filter_var(trim($_POST['propertyType']), FILTER_SANITIZE_FULL_SPECIAL_CHARS): '';
           $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : [];

           $contacts = "$email | $phone";
           // validating
           if (empty($name) || empty($address) || empty($contacts)) {throw new Exception("All fields are required.");}
           if ( !is_numeric($destinationId) || $destinationId < 0) { throw new Exception("Invalid destination."); }
           if (!is_array($amenities)) {throw new Exception("Invalid amenities data.");}   
           
           $freeCancellation = ($freeCancellationRaw === '1' || strtolower($freeCancellationRaw) === 'yes') ? 1 : 0;  
           
           // data array
           $data = [
            'destination_id' => $destinationId,
            'name' => $name,
            'address' => $address,
            'contacts' => $contacts,
            'description' => $description,
            'free_cancellation' => $freeCancellation,
            'property_type'=> $propertyType ,
            'status' => 'Pending'         ];

           // calling the method from model and getting its id 
            $stayId = $this->stayModel->addStay($data);
            $this->listingModel->createListing($stayId, 'stay', $businessId);
            if ($stayId)
            {
                // saving amenities
               foreach ($amenities as $amenityId)
               {
                $this->stayModel->addAmenityToStay($stayId, (int)$amenityId);
               }

               // saving images
               if (!empty($_FILES['property_images']['name'][0])) {
                $imageDir = __DIR__ . '/../images/';
                $publicPath = 'images/';
                if (!file_exists($imageDir)) mkdir($imageDir, 0777, true);

                foreach ($_FILES['property_images']['tmp_name'] as $key => $tmpName) {
                    $originalName = $_FILES['property_images']['name'][$key];
                    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                    $newName = uniqid('stay_', true) . '.' . $ext;
                    $destination = $imageDir . $newName;

                    if (move_uploaded_file($tmpName, $destination)) {
                        $relativePath = $publicPath . $newName;
                        $this->imageModel->saveImage($stayId, 'stay',  $relativePath, $originalName);
                    }
                }
            }

            // saving the rooms
            if (!empty($_POST['rooms_data'])) {
                $rooms = json_decode($_POST['rooms_data'], true);
                foreach ($rooms as $room) {
                    $this->roomModel->addRoom([
                        'stay_id' => $stayId,
                        'name' => $room['name'],
                        'type' => $room['type'],
                        'description' => $room['description'],
                        'price_per_night' => $room['price'],
                        'status' => 'Available'
                    ]);
                }
            }

            // final success and redirection
            flash('stay', 'The stay and its rooms were created successfully, and are pending for admin approval!');
             redirect('/tripzly_test/add_listing');

            }
            else {  flash('stay', 'Something went wrong. Please try again.');}

            }
            catch(Exception $ex) { echo "Error: " . $ex->getMessage(); }
         }
         else {
            return false;
         }
    }
}

?>

