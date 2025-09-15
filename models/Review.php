<?php

require_once __DIR__ . '/../Connection.php';

class Review {
    private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    public function saveReview($data){
         $this -> pdo -> query("INSERT INTO review (user_id, reviewable_id, reviewable_type,
         	rating, comment) VALUES (:user_id, :reviewable_id,:reviewable_type,
         	:rating, :comment)");

            // bind the values
         $this -> pdo -> bind(':user_id', $data['user_id']);
         $this -> pdo -> bind(':reviewable_id', $data['reviewable_id']);
         $this -> pdo -> bind(':reviewable_type', $data['reviewable_type']);
         $this -> pdo -> bind(':rating', $data['rating']);
         $this -> pdo -> bind(':comment', $data['comment']);

          if ( $this -> pdo -> execute())
         {
            return true;
         }
         else { return false;}
    }

    public function getAllReviewsForItem($reviewableId,$reviewableType)
    {
         $this->pdo->query('SELECT r.* , u.name AS username 
         FROM review r 
         JOIN user u ON r.user_id = u.user_id
         WHERE reviewable_id = :reviewable_id 
         AND r.reviewable_type = :reviewable_type
         ORDER BY date DESC');
         $this->pdo->bind(':reviewable_id', $reviewableId);
         $this->pdo->bind(':reviewable_type', $reviewableType);
         return $this->pdo->resultSet();   
    }


}




?>