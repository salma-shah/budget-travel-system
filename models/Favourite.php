<?php

require_once __DIR__ . '/../Connection.php';

class Favourite {
 private $pdo;
    public function __construct(){
        $this->pdo = new Connection;
    }

    // add a favourite item
    public function favouriteItem($data){
        $this -> pdo -> query('INSERT IGNORE INTO favourite(user_id, favouritable_id)
        VALUES (:user_id, :favouritable_id)');

        $this -> pdo -> bind(':user_id', $data['user_id']);
         $this -> pdo -> bind(':favouritable_id', $data['favouritable_id']);

         // excuting
         if ( $this -> pdo -> execute())
         {
            return true;
         }
         else { return false;}
    }

    // remove it
     public function removeFavouriteItem($userId,$favouritableId){
        $this -> pdo -> query('DELETE FROM favourite WHERE user_id = :user_id
        AND favouritable_id = :favouritable_id');

        $this -> pdo -> bind(':user_id', $userId);
         $this -> pdo -> bind(':favouritable_id', $favouritableId);

       return $this->pdo->execute();
    }

    // check if it exists
    public function isItemAlreadyFavourite($userId,$favouritableId){
        $this -> pdo -> query('SELECT favourite_id FROM favourite WHERE user_id = :user_id 
        AND favouritable_id = :favouritable_id');

         $this -> pdo -> bind(':user_id', $userId);
         $this -> pdo -> bind(':favouritable_id', $favouritableId);
         
         // return whether it exists or not
         // fetch one row
         $result = $this -> pdo ->single();
         if ($result !== false){return true;}
         else {return false;}
    }

    // gettting all of the user's favs
    public function listAllFavourites($userId)
    {
        $this -> pdo -> query('SELECT * FROM favourite WHERE user_id = :user_id');
        $this -> pdo -> bind(':user_id', $userId);
        return $this->pdo->resultSet();
    }


}

?>