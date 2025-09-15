<?php

require_once __DIR__ . '/../helpers/session_helper.php';

class RoomController 
{
    private $roomModel;
    public function __construct(){
        $this->roomModel = new Room;
    }

    // room avaialbilty
    public function checkRoomAvailability()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            // taking user data
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $roomType = $_POST['room_type'];
        $roomCount = (int) $_POST['room_count'];

        // checking
        $availableRooms = $this->roomModel->getAvailableRooms($checkin, $checkout, $roomType, $roomCount);

        // if rooms are avaialble for booking, lets send it to the check avaiblitiy function as TRUE
        if (count($availableRooms) >= $roomCount) {
            echo json_encode([
                'available' => true,
                'rooms' => $availableRooms
            ]);
        } 
        // no rooms means it is false
        else {
            echo json_encode(['available' => false]);
        }
        exit;
        }
    }

    public function viewAllRoomsByStays()
    {
        $stayId = $_SESSION['destinationId'];
        $rooms = $this->roomModel->viewAllRoomsByStays($stayId);
        return $rooms;
    }

    // adding a room
    public function addRoom()
    {
         if (($_SERVER['REQUEST_METHOD'] == 'POST'))
      {
            try 
        {
           $stayId = filter_var(trim($_POST['stayId']), FILTER_SANITIZE_NUMBER_INT);
           $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $type = filter_var(trim($_POST['type']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $pricePerNight = filter_var(trim($_POST['pricePerNight']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
           $isAvailableRaw = trim($_POST['isAvailable']);
          
           // validating
           if (empty($name) || empty($description) || empty($type) || empty($pricePerNight)) {throw new Exception("All fields are required.");}
           if ( !is_numeric($stayId) || $stayId < 0) { throw new Exception("Invalid destination."); }  
           $isAvailable = ($isAvailableRaw === '1' || strtolower($isAvailableRaw) === 'yes') ? 1 : 0;  
           
           // data array
           $data = [
            'stay_id' => $stayId,
            'name' => $name,
            'type' => $type,
            'description' => $description,
            'is_available' => $isAvailable,
            'property_type'=> $propertyType ,
            'status' => 'Pending'         
        ];

           // calling the method from model and getting its id 
           if ($this->roomModel->addRoom($data))
           {
             flash('room', 'Room was successfully added for the stay!', 'form-message form-message-green');
           } else { flash('room', 'Something went wrong. Please try again.', 'form-message form-message-red');}
        } 
        
        catch (Exception $ex) {echo "Error: " . $ex->getMessage();}
        }
        else {
            return false;
        }
    }
        
}