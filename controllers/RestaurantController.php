<?php
require_once __DIR__ . '/../helpers/session_helper.php';

class RestaurantController 
{
    private $restaurantModel;
    private $listingModel;
    private $imageModel;
    public function __construct(){
       $this->restaurantModel = new Restaurant;
       $this->listingModel = new Listing;
       $this->imageModel = new Image;
    }

    public function showAllRestaurantsPage(){
       $restaurants= $this->restaurantModel->viewAllRestaurants();
      
       require_once __DIR__ . '/../views/restaurants.php';
    }

    // specfifc item
    public function showRestaurantDetails($restaurantId)
    {
        $restaurant= $this->restaurantModel->viewRestaurantDetails($restaurantId);
        if (!$restaurant) {die('Restaurant not found.');}
        require_once __DIR__ . '/../views/restaurant_details.php';
    }

    public function viewAllRestaurantsByDestination()
    {
        $destinationId = $_SESSION['destination_id'];
        $restaurants = $this->restaurantModel->viewAllRestaurantsByDestination($destinationId);
        return $restaurants;
    }

    public function addRestaurant()
    {
         if (($_SERVER['REQUEST_METHOD'] === 'POST'))
      {
            try 
            {
            // getting business Id from session user id 
            $businessId = $_SESSION['userId'];
                // sanitize
            $destinationId = filter_var(trim($_POST['destinationId']), FILTER_SANITIZE_NUMBER_INT);
            $name = filter_var(trim($_POST['restaurantName']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_var(trim($_POST['restaurantDescription']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $address = filter_var(trim($_POST['restaurantAddress']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var(trim($_POST['restaurantEmail']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $phone = filter_var(trim($_POST['restaurantPhone']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $openFrom = filter_var(trim($_POST['openFrom']));
            $openTo = filter_var(trim($_POST['openTo']));
          
            $availability= 1;
            $contacts = "$email | $phone";
            
            $cuisines = isset($_POST['cuisines']) ? $_POST['cuisines'] : [];
            $foodTypes = isset($_POST['foodTypes']) ? $_POST['foodTypes'] : [];
            $dietaryRestrictions = isset($_POST['dietaryRestrictions']) ? $_POST['dietaryRestrictions'] : [];

            // validate to make sure all values are valid
            if (!is_numeric($destinationId) || $destinationId <= 0) throw new Exception("Invalid destination ID.");
            if (empty($name)) throw new Exception("Restaurant name is required.");
            if (!is_array($dietaryRestrictions)) {throw new Exception("Invalid Dietary Restrictions data.");}    
            if (!is_array($foodTypes)) {throw new Exception("Invalid Food Types data.");}    
            if (!is_array($cuisines)) {throw new Exception("Invalid cuisines data.");}    
           
             $data = [
            'destination_id' => $destinationId,
            'business_id' => $businessId,
            'name' => $name,
            'address' => $address,
            'description' => $description,
            'contacts' => $contacts,
            'availability'=> $availability ,
            'open_from' => $openFrom,
             'open_to' => $openTo,
            'status' => 'Pending'         
        ];

            // now we call model
            // restaurant model
            $restaurantId = $this->restaurantModel->addRestaurant($data);
            if ($restaurantId)
            {
                // let's save the food types, cuisines, and dietary restritcitons of the restaurant
                // aka the many to many relationships
                // foreach ($foodTypes as $foodTypeId) 
                // {
                // $this->restaurantModel->addFoodTypeToRestaurant($restaurantId, (int)$foodTypeId);
                // }
                // foreach ($cuisines as $cuisineId)
                // {
                // $this->restaurantModel->addCuisineToRestaurant($restaurantId, (int)$cuisineId);
                // }
                // foreach ($dietaryRestrictions as $dietRestrictionId)
                // {
                // $this->restaurantModel->addDietaryRestrictionToRestaurant($restaurantId, (int)$dietRestrictionId);
                // }

                // saving images
                if (!empty($_FILES['restaurant_images']['name'][0])) {
                $imageDir = __DIR__ . '/../images/';  // image folder to be added to
                $publicPath = 'images/';  // setting file path
               
              
                if (!file_exists($imageDir)) mkdir($imageDir, 0777, true);

                foreach ($_FILES['restaurant_images']['tmp_name'] as $key => $tmpName) {
                    $originalName = $_FILES['restaurant_images']['name'][$key];
                    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                    $newName = uniqid('rest_', true) . '.' . $extension;
                    $destination = $imageDir . $newName;
                    $relativePath = $publicPath . $newName;

                    if (move_uploaded_file($tmpName, $destination)) {
                        // save image in db
                        $this->imageModel->saveImage(
                            $restaurantId,
                            'restaurant',
                            $relativePath,
                            htmlspecialchars($originalName)
                        );
                    }
                }
            }
                flash('restaurant', 'The restaurant was created successfully, with all its categories.');
                
                // listing model
                $listingCreated = $this->listingModel->createListing($restaurantId, 'restaurant', $businessId);
            if (!$listingCreated) throw new Exception("Failed to create restaurant listing.");
            redirect('/tripzly_test/add_listing');

            }
            else { flash('restaurant', 'Something went wrong. Please try again.');}
        }
            catch (Exception $ex)
            {
                echo "Error: " . $ex->getMessage();
            }
    }
}

// check if resturant is avaialble
public function checkRestaurantAvailability()
{
     if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            header('Content-Type: application/json');

            // post values from frontend
            $timeInput = $_POST['time'];
            $restaurantId = $_POST['restaurantId'];

            // validating
            $validatedTime = DateTime::createFromFormat('H:i', $timeInput);
            if (!$validatedTime) {
                echo json_encode(['available' => false, 'message' => 'Invalid time format']);
                return;
            }
            
            $time = $validatedTime->format('H:i'); 

            // checking if restuant is avialable
            // by open hours
            $restaurant = $this->restaurantModel->getRestaurantById($restaurantId);
            $acceptingReservations = $this->restaurantModel->isMarkedAvailable($restaurantId);
            // whether actually accepting reservations

          if (!$restaurant) {
            echo json_encode(['available' => false, 'message' => 'Restaurant not found']);
            return;
        }
        
        if (!$acceptingReservations) {
            echo json_encode(['available' => false, 'message' => 'The restaurant is currently not accepting reservations.']);
            return;
        }

        $openFrom = $restaurant->open_from; 
        $openTo = $restaurant->open_to;    

        if ($time >= $openFrom && $time <= $openTo) {
            echo json_encode(['available' => true]);
        } else {
            echo json_encode([
                'available' => false,
                'message' => "Restaurant is closed at $time. Open from $openFrom to $openTo."
            ]);
        }
        }
}
}

?>

