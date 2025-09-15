<?php
session_start();
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/helpers/Autoloader.php';
require_once __DIR__ . '/vendor/autoload.php';
spl_autoload_register('Autoloader::autoload');

// router = BRAMUS
use Bramus\Router\Router;
$router = new Router();

// creating instances of the controllers 
$pdo = new Connection;
$userController = new UserController;
$searchController = new SearchController;
$homeController = new HomeController;
$restaurantController = new RestaurantController;
$attractionController = new TouristController;
$tourController = new TourController;
$stayController = new StayController;
$roomController = new RoomController;
$bookingController = new BookingController;
$reviewController = new ReviewController;
$reservationController= new ReservationController;
$adminController = new AdminController;
$businessController = new BusinessController;
$contactController = new ContactController;
$paymentController = new PaymentController;
$filterController= new FilterController;


// routes for user functions

$router->get('/register', function () use ($userController)
{
    $userController->showRegistration();
});

$router->post('/user/register', function () use ($userController) 
{   
    $userController->registerUser($_POST);
});

$router->post('/business/register', function () use ($userController) 
{
    $userController->registerBusiness($_POST);
});

// user login
$router->get('/user/login', function () use ($userController) 
{
    $userController->showUserLogin();
});

// admin login
$router->get('/admin/login', function () use ($adminController) 
{
    $adminController->showAdminLogin();
});
// business login
$router->get('/business/login', function () use ($businessController) 
{
    $businessController->showBusinessLogin();
});

$router->post('/user/login', function () use ($userController)
{
    $userController->userLogin($_POST);
});

$router->post('/search', function () use ($searchController) {
    $searchController->handleSearch();
});

// these are to display many RESULTS for items
$router->get('/home', function () use ($homeController) {
    $homeController->showHomePage();
});

$router->get('/restaurants', function () use ($restaurantController) {
    $restaurantController->showAllRestaurantsPage();
});

$router->get('/attractions', function () use ($attractionController) {
    $attractionController->showAllAttractionsPage();
});

$router->get('/tours', function () use ($tourController) {
    $tourController->showAllToursPage();
});

$router->get('/stays', function () use ($stayController) {
    $stayController->showAllStaysPage();
});

// these are to display views of SINGLE items
$router->get('/tour/(\d+)', function ($tourId) use ($tourController) {
    $tourController->showTourDetails($tourId);
});

$router->get('/restaurant/(\d+)', function ($restaurantId) use ($restaurantController) {
    $restaurantController->showRestaurantDetails($restaurantId);
});

$router->get('/stay/(\d+)', function ($stayId) use ($stayController) {
    $stayController->showStayDetails($stayId);
});

$router->get('/attraction/(\d+)', function ($attractionId) use ($attractionController) {
    $attractionController->showAttractionDetails($attractionId);
});

// these are for checking availibities
// room
$router->post('/booking/check', function () use ($roomController) {
    $roomController->checkRoomAvailability();
});

// tour
$router->post('/tour/check', function () use ($tourController) {
    $tourController->checkTourAvailability();
});

// restuarant
$router->post('/reservation/check', function () use ($restaurantController) {
    $restaurantController->checkRestaurantAvailability();
});

// user submitting forms related to bookings, reviews, and so on
// making booking for room
$router->post('/make_booking', function () use ($bookingController) 
{   
    $bookingController->makeBooking();
});

// make booking for tour
$router->post('/make_tour_booking', function () use ($bookingController) 
{   
    $bookingController->makeTourBooking();
});

$router->post('/make_reservation', function () use ($reservationController) 
{   
    $reservationController->makeReservation();
});

// leaving a review
$router->post('/leave_review', function () use ($reviewController) 
{   
    $reviewController->submitReview();
});

// dashboards
// admin dashboard
$router->get('/logout', function () use ($userController) {
    $userController->logout();
});

$router->get('/admin_dashboard', function () use ($adminController) {
    $dashboardStats = $adminController->getDashboardStats(); 
     require_once __DIR__ . '../views/admin-dashboard.php';
});

// viewing all users
$router->get('/manage_users', function() use ($adminController){
    $adminController->getAllUserDetails();
});

// viewing all businessees
$router->get('/manage_businesses', function() use ($adminController){
    $adminController->getAllBusinessesDetails();
});

// deleting a user
$router->post('/delete_user', function() use ($adminController){
    if (isset($_POST['userID']))
   { $adminController->deleteUserById($_POST['userID']); }
   else { echo "User ID is not provided";}
});

// searching for user
$router->post('/search_users', function() use ($searchController) {
    if (isset($_POST['search'])) {
        $searchController->searchUsers($_POST['search']);
    } else {
        echo "";
    }
});

// viewing listings by either business id
$router->get('/manage_listings/(\d+)', function($businessId) use ($adminController){
    $adminController->viewListings($businessId);
});

// or all of them
$router->get('/manage_listings', function() use ($adminController){
    $adminController->viewListings();
});

// deleting a listing
$router->post('/delete_listing', function() use ($adminController){
    if (isset($_POST['listingID']))
   { $adminController->deleteListingById($_POST['listingID']); }
   else { echo "Listing ID is not provided";}
});

// searching for listings route
$router->post('/search_listings', function() use ($searchController) {
    if (isset($_POST['search'])) {
        $searchController->searchListings($_POST['search']);
    } else {
        echo "";
    }
});

// approving and rejecting listing items
$router->post('/approve_listing', function() use ($adminController) {
    if (isset($_POST['listingID'])) {
        $adminController->approveListing($_POST['listingID']);
    } else {
        echo "Listing ID is missing.";
    }
});

$router->post('/reject_listing', function() use ($adminController) {
    if (isset($_POST['listingID'])) 
    {
        $adminController->rejectListing($_POST['listingID']);
    } 
    else { echo "Listing ID is missing.";}
});

// viewing the listings in detail
$router->post('/listing_details', function () use ($adminController)
{
    if (isset($_POST['listingID'])) 
 {   $adminController->viewListingDetails($_POST['listingID']); }
  else { echo "Listing ID is missing.";}
});

// searching for business route
$router->post('/search_businesses', function() use ($searchController) {
    if (isset($_POST['search'])) {
        $searchController->searchBusinesses($_POST['search']);
    } else {
        echo "";
    }
});

//  user dashboard
$router->get('/user_dashboard', function () use ($userController) {
    $userController->getUserProfile();
});

// updating details
$router->post('/update_user_details', function () use ($userController) {
    $userController->updateUserProfile();
});

// business dashboard
$router->get('/business_dashboard', function () use ($businessController) {
    $businessController->getBusinessProfile();
});

// updating details
$router->post('/update_business_details', function () use ($businessController) {
    $businessController->updateBusinessProfile();
});

// viewing bookings
$router->get('/manage_bookings', function() use ($bookingController){
    $bookingController->viewBookingsForBusiness();
});

// approving and rejecting bookings
$router->post('/approve_booking', function() use ($bookingController) {
    if (isset($_POST['bookingID'])) 
    {
        $bookingController->approveBooking($_POST['bookingID']);
    } 
    else {  echo "Booking ID is missing.";   }
});

$router->post('/reject_booking', function() use ($bookingController) {
    if (isset($_POST['bookingID'])) 
    {
        $bookingController->rejectBooking($_POST['bookingID']);
    } 
    else {  echo "Booking ID is missing.";   }
});

// viewing the bookings in detail
$router->post('/booking_details', function () use ($bookingController)
{
    if (isset($_POST['bookingID'])) 
 {   $bookingController->viewBookingDetails($_POST['bookingID']); }
  else { echo "booking ID is missing.";}
});


// deleting a litsing item
$router->post('/delete_business_listing', function() use ($businessController){
    if (isset($_POST['listingID']))
   { $businessController->deleteListingById($_POST['listingID']); }
   else { echo "Listing ID is not provided";}
});

// listing add page
$router->get('/add_listing', function () use ($businessController)
{
    $businessController->getAddListingPage();
});

// adding restaurant
$router->post('/restaurant/add', function () use ($restaurantController)
{
    $restaurantController->addRestaurant();
});

// adding a stay listing
$router->post('/listing/add', function () use ($stayController)
{
    $stayController->addStay();
});

// viewing and updating a listing
$router->post('/listing/view', function () use ($businessController)
{
     if (isset($_POST['listingID']))
     { 
    $businessController->viewListingDetails($_POST['listingID']);
     }
});

$router->post('/listing/update', function () use ($businessController) {
    $businessController->updateListing();
});

// showing about page
$router->get('/about_us', function () use ($homeController)
{
    $homeController->showAboutPage();
});

// showing contact form for users
$router->get('/contact', function () use ($homeController)
{
    $homeController->showContactPage();
});

// this is for businesses
$router->get('/contact_support', function () use ($contactController)
{
    $contactController->showContactSupportPage();
});

// submitting queries
$router->post('/submit_query', function () use ($contactController)
{
    $contactController->submitContactForm();
});

// submitting queries
$router->post('/submit_contact_support', function () use ($contactController)
{
    $contactController->submitContactSupportForm();
});

// showing payment form
$router->get('/payment_form', function () use ($paymentController)
{
    $paymentController->showPaymentForm();
});

// making payment
$router->post('/make_payment', function () use ($paymentController)
{
    $paymentController->makePayment();
});

// filtering and searchning methods
// filter stays 
$router->post('/filter_stays', function () use ($filterController) {
    $filterController->filterAvailableStays();
});

// filtering stays by dstination after checking availibilty 
$router->post('/search_filter_stays', function () use ($homeController) {
    $homeController->filterAvailableStaysByDestination();
});


// running the router
$router->run();

?>