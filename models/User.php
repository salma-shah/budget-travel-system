<?php

require_once __DIR__ . '/../Connection.php';

class User 
{
    // connecting to database and using the database which already exists, which we have access to
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    // creating a user account
    public function registerUser($data){

        // query to insert data
        $this -> pdo -> query('INSERT INTO user(name, contact_number, email, password, role, address)
        VALUES (:name, :contact_number, :email, :password, :role, :address)');

        // bind the values
         $this -> pdo -> bind(':name', $data['name']);
         $this -> pdo -> bind(':contact_number', $data['contact_number']);
         $this -> pdo -> bind(':email', $data['email']);
         $this -> pdo -> bind(':password', $data['password']);
           $this -> pdo -> bind(':address', $data['address']);
         $this -> pdo -> bind(':role', $data['role']);

        // excuting
         if ( $this -> pdo -> execute())
         {
            return true;
         }
         else { return false;}

    }

    // finding the user by their unique email
    public function findUserByEmail($email){
        $this -> pdo -> query('SELECT * FROM user WHERE email = :email');
        $this -> pdo -> bind('email', $email);

        $row = $this -> pdo -> single();

        // checking the rows
        if ($this -> pdo -> rowCount() > 0){
            return $row;
        }
        else { return false;}
    }

    // user login through email
    public function userLogin($email, $password)
    {
        $row = $this->findUserByEmail($email);

        // if email does not exist
    if ($row == false) { return false; }

    // if email exists, check password
    // since we stored password as hashed, let us verify it first
    $hashedPassword = $row->password;

    if (password_verify($password, $hashedPassword))
    {
        return $row;
    }
    else { return false;}
    }

     // reset password
     public function updatePassword($hashedPassword, $email)
     {
       $this -> pdo -> query('UPDATE user SET password = :password WHERE email= :email');
       $this -> pdo -> bind(':password', $hashedPassword);
       $this -> pdo -> bind(':email', $email);

        // executing
         return $this -> pdo -> execute();
     }

     // creating a business account, they have added field for address
    public function registerBusiness($data){

        // query to insert data
        $this -> pdo -> query('INSERT INTO user(name, contact_number, email, password, role, address)
        VALUES (:name, :contact_number, :email, :password, :role, :address)');

        // bind the values
         $this -> pdo -> bind(':name', $data['name']);
         $this -> pdo -> bind(':contact_number', $data['contact_number']);
         $this -> pdo -> bind(':email', $data['email']);
         $this -> pdo -> bind(':password', $data['password']);
         $this -> pdo -> bind(':role', $data['role']);
         $this -> pdo -> bind(':address', $data['address']);

        // excuting
         if ( $this -> pdo -> execute())
         {
            return true;
         }
         else { return false;}
    }

     // this is for user profile
    public function getUserById($userId) 
    {
        $this->pdo->query('SELECT * FROM user WHERE user_id = :user_id');
        $this->pdo->bind(':user_id', $userId);
        return $this->pdo->single();
    }

    public function updateUserDetails($userId, $data)
    {
        $this->pdo->query('UPDATE user SET name = :name, email=:email, password=:password, contact_number = :contact_number, address=:address WHERE user_id = :user_id');
        $this->pdo->bind(':user_id', $userId);
        $this->pdo->bind(':name', $data['name']);
        $this->pdo->bind(':email', $data['email']);
        $this->pdo->bind(':password', $data['password']);
        $this->pdo->bind(':address', $data['address']);
        $this->pdo->bind(':contact_number', $data['contact_number']);

        // excuting
         if ( $this -> pdo -> execute())
         {
            return true;
         }
         else { return false;}
    }



}

?>