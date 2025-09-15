<?php
include_once __DIR__ . '/../helpers/session_helper.php';

class UserController {

    private $userModel;
    private $bookingModel;
    public function __construct(){
        $this->userModel = new User;
        $this->bookingModel = new Booking;
    }

    public function showRegistration()
    {
    include __DIR__ . '/../views/signup.php';
    }
    
    public function showUserLogin()
    {
    include __DIR__ . '/../views/user_login.php';
    }

    // register user
    public function registerUser()
    {
          // if register button was clicked in the form  
        if (($_SERVER['REQUEST_METHOD'] == 'POST'))  
        {
            // lets sanitize the data to remove any unneccesary data
         $firstName = filter_var(trim($_POST['userFirstName']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $lastName = filter_var(trim($_POST['userLastName']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $address = filter_var(trim($_POST['userAddress']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $contactNumber = filter_var(trim($_POST['userContact']), FILTER_SANITIZE_NUMBER_INT);
         $email = filter_var(trim($_POST['userEmail']), FILTER_SANITIZE_EMAIL);
         $password = filter_var(trim($_POST['userPassword']));
         $confirmPassword = trim($_POST['userConfirmPassword']);

         // validate the inputs before saving
            if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($contactNumber)) {
        flash("register", "Please fill in all fields");
       redirect("/tripzly_test/register");
        exit;
    }

    if (strlen($password) < 6) {
        flash("register", "Please enter a password with at least 6 characters");
        redirect("/tripzly_test/register");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash("register", "Invalid email");
        redirect("/tripzly_test/register");
        exit;
    }

    if ($this->userModel->findUserByEmail($email)) {
        flash("register", "This email is already in use. Please use another email.");
        redirect("/tripzly_test/register");
        exit;
    }

    if ($password !== $confirmPassword) {
        flash('register', "Passwords do not match.");
        redirect("/tripzly_test/register");
        exit;
    }
            // initalize data
            $data = [
               'name' => $firstName . ' ' . $lastName,
               'contact_number' => $contactNumber,
               'email' => $email,
               'password' => password_hash($password, PASSWORD_DEFAULT),
               'address' => $address,
               'role' => 'user'
            ];

            if($this->userModel->registerUser($data)){
                flash("register", "The account was created sucessfully!");
                redirect("/tripzly_test/register");
            }else{
                die("Something went wrong");
            }
        }
    }

    // register business account
    public function registerBusiness()
    {

        // if register button was clicked in the form  // LOOK
        if (($_SERVER['REQUEST_METHOD'] == 'POST'))  
        {
            // lets sanitize the data to remove any unneccesary data
         $organizationName = filter_var(trim($_POST['businessName']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $contactNumber    = filter_var(trim($_POST['businessContact']), FILTER_SANITIZE_NUMBER_INT);
         $email            = filter_var(trim($_POST['businessEmail']), FILTER_SANITIZE_EMAIL);
         $password         = filter_var(trim($_POST['businessPassword']));
         $confirmPassword  = trim($_POST['businessConfirmPassword']); 
         $address          = filter_var(trim($_POST['businessAddress']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

           // validate the inputs before saving
          if (empty($organizationName) || empty($email) || empty($password) || empty($contactNumber)) {
        flash("register", "Please fill in all fields");
           redirect("/tripzly_test/register");
        exit;
    }

    if (strlen($password) < 6) {
        flash("register", "Please enter a password with at least 6 characters");
           redirect("/tripzly_test/register");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash("register", "Invalid email");
           redirect("/tripzly_test/register");
        exit;
    }

    if ($this->userModel->findUserByEmail($email)) {
        flash("register", "This email is already in use. Please use another email.");
         redirect("/tripzly_test/register");
        exit;
    }

    if ($password !== $confirmPassword) {
        flash('register', "Passwords do not match.");
          redirect("/tripzly_test/register");
        exit;
    }
            // initalize data
            $data = [
               'name' => $organizationName,
               'contact_number' => $contactNumber,
               'email' => $email,
               'password' => password_hash($password, PASSWORD_DEFAULT),
               'role' => 'business',
               'address' => $address
            ];

            if($this-> userModel->registerBusiness($data)){
                flash("register", "The account was created sucessfully!");
                   redirect("/tripzly_test/register");
            }else{
                die("Something went wrong");
            }
        }
    }

    // account login
    public function userLogin(){
        if ($_SERVER['REQUEST_METHOD'] == "POST") 
        {   
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password'])
            ];

            if (empty($data['password'])  || empty($data['email'])) {
                flash("login", "Please fill in the fields");
                redirect("/tripzly_test/user/login");
                exit();
            }

            $this->userModel->findUserByEmail($data['email']);

            // check for the user email
            if ($this->userModel->findUserByEmail($data['email'])) 
            {
                // if found true
                $loggedInUser = $this->userModel->userLogin($data['email'], $data['password']);
                // var_dump($loggedInUser);

                //if user is logged in, let's create a session for them 
                if($loggedInUser)
                {
                    $this->createUserSession($loggedInUser);
                }
                else 
                {
                    flash("login", "Invalid credentials.");
                    redirect("/tripzly_test/user/login");
                }
            }
            else
            {
                flash("login", "No user found. Please create an account!");
                redirect("/tripzly_test/user/login");
            }
        }
    }

    // creating user session function
    public function createUserSession($user)
    {
        $_SESSION['userId'] = $user->user_id;
        $_SESSION['email'] = $user->email;
        $_SESSION['name'] = $user->name;
        $_SESSION['role'] = $user->role;

        // redriecting to different dashboards
        if ($_SESSION['role'] === 'User')
        { 
            redirect("/tripzly_test/user_dashboard");
            exit; 
        }
         if ($_SESSION['role'] === 'Business')
        { 
            redirect("/tripzly_test/business_dashboard");
            exit; 
        }
         if ($_SESSION['role'] === 'Administrator')
        { 
            redirect("/tripzly_test/admin_dashboard");
            exit; 
        }
       
    }

    // logout
    public function logout(){
    $_SESSION = [];
    session_destroy();
    redirect("/tripzly_test/home"); 

    }

    // user profile
    public function getUserProfile()
    {

    // user id in session
    $userId =$_SESSION['userId'];
    
    // user details
    $user= $this->userModel->getUserById($userId);

    // booking counts
    $bookingsCount = $this->bookingModel->getBookingsByStatusForUser($userId);
    $total = array_sum($bookingsCount);

    // bookings
    $bookings = $this->bookingModel->getBookingsForUser($userId);

    // if no user id, then error
    if (!$user) {die('User was not found.');}
    require_once __DIR__ . '/../views/user-dashboard.php';
    }
    
    // updating profile details
    public function updateUserProfile()
    {
         if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $userId = $_SESSION['userId'];

         $name = filter_var(trim($_POST['fullName']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $address = filter_var(trim($_POST['address']), FILTER_SANITIZE_EMAIL);
         $contactNumber = filter_var(trim($_POST['contactNumber']), FILTER_SANITIZE_NUMBER_INT);
         $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
         
         // seperate passwords and hashed one
         $newPassword = $_POST['password'];
         $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

         // validate the inputs before updating details
            if (empty($data['name']) || empty($data['password']) || empty($data['email']) || empty($data['address']) || empty($data['contact_number'])) {
                flash("user_profile", "Please fill in all fields");
                redirect("/tripzly_test/user_dashboard");
            } 

            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                flash("user_profile", "Invalid email");
                redirect("/tripzly_test/user_dashboard");
            }

             if (strlen($password) < 6) {
                 flash("register", "Please enter a password with at least 6 characters");
                  redirect("/tripzly_test/user_dashboard");
            }
       
            // if email is already registered
             $existingUser = $this->userModel->findUserByEmail($email);
        if ($existingUser && $existingUser->user_id != $userId) {
            flash("user_profile", "This email is already in use.");
            redirect("/tripzly_test/user_dashboard");
        }
            
            // initalize data
            $data = [
               'name' => $name,
               'contact_number' => $contactNumber,
               'email' => $email,
               'password'=>$hashedPassword,
               'address'=> $address
            ];

            // update user profile
            if($this->userModel->updateUserDetails($userId, $data))
            {
                flash("user_profile", "The details were updated successfully!");
            }
            else
            {
                die("Something went wrong");
            }
        }
    }

}

?> 
