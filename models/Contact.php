<?php
require_once __DIR__ . '/../Connection.php';


class Contact {
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    public function submitContactForm($data) 
    {
        // query to insert data
        $this -> pdo -> query('INSERT INTO contact_form(email, name, subject)
        VALUES (:email, :name, :subject)');

         $this -> pdo -> bind(':email', $data['email']);
         $this -> pdo -> bind(':name', $data['name']);
         $this -> pdo -> bind(':subject', $data['subject']);

           if ( $this -> pdo -> execute())
         {
            return true;
         }
         else { return false;}
    }

    public function viewAllContactForms()
    {
        // selecting all contact forms with the user details, using user id as FK
        $this -> pdo -> query("SELECT c.*,
        u.name AS customer_name,
        u.email AS user_email,
        u.contact_number
        FROM contact_form c 
        JOIN user u ON c.user_id = u.user_id
        ORDER BY c.submitted_at DESC ");

    // returning the results
    return $this->pdo->resultSet();
    }
} 




?>