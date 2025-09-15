<?php
include_once __DIR__ . '/../helpers/session_helper.php';

class SearchController {
    private $searchModel;
    public function __construct(){
        $this->searchModel = new Search;
    }

    public function handleSearch()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') 
        {
            $searchValue = trim($_POST['searchValue'] ?? '');
            
            // if search bar is empty
            if(empty($searchValue)){
                flash('search', 'Please enter a search term.');
                redirect('../views/search.php');
            }

            // searching
            $destinationResults = $this->searchModel->searchDestinations($searchValue);
            $tourResults = $this->searchModel->searchTours($searchValue);

            $_SESSION['destinationResults'] = $destinationResults;
            $_SESSION['tourResults'] = $tourResults;
            $_SESSION['searchValue'] = $searchValue;

            // loading the view
            // redirect ('../views/search_results.php');
            redirect('/tripzly_test/views/search_results.php');

        }
    }

    public function searchUsers($searchTerm){
    $users = $this->searchModel->searchUsers($searchTerm);
    $usersForView = $users;
    include __DIR__ . '/../views/partials/user_rows.php';  
    }

    public function searchBusinesses($searchTerm){
    $businesses = $this->searchModel->searchBusinesses($searchTerm);
    $businessesForView = $businesses;
    include __DIR__ . '/../views/partials/businesses_rows.php';  
    }

    public function searchListings($searchTerm){
    $listings = $this->searchModel->searchListings($searchTerm);
    include __DIR__ . '/../views/partials/listings_rows.php';  
    }

     public function searchStays()
     {
        $checkin = $_POST['checkin'] ?? '';
        $checkout = $_POST['checkout'] ?? '';

        if (empty($checkin) || empty($checkout)) {
        echo "<p>Missing input fields.</p>";
        return; }

        $stays = $this->searchModel->searchAllAvailableStays($checkin, $checkout);
       include __DIR__ . '/../views/partials/stay_grid.php';

     }

     

}
    
?>
