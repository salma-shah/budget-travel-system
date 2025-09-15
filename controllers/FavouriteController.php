<?php
session_start();

require_once '../models/Favourite.php';
include_once __DIR__ . '/../helpers/session_helper.php';

class FavouriteController {

 private $favouriteModel;
    public function __construct(){
        $this->favouriteModel = new Favourite;
    }

    // save the review
     public function favouriteItem()
     {
        if (($_SERVER['REQUEST_METHOD'] == 'POST'))
        {
        $favouritableId = filter_var(trim($_POST['favouritableId']), FILTER_SANITIZE_NUMBER_INT);
        $userId = $_SESSION['userId']; 

        // validating
        // favouritable_id
        // if (!filter_var($favouritable_id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
        //     flash('favourite', 'Invalid item ID.');
        //     redirect('../views/welcome.php');
        //     return;
        // }

        // checking if its already a favourite
        if ($this->favouriteModel->isItemAlreadyFavourite($userId,$favouritableId))
        {
             flash('favourite', 'You’ve already added this to your favorites.');
            redirect('../views/welome.php');
            return;
        }

          // initalize data
            $data = [
                'user_id' => $_SESSION['userId'],
                'favouritable_id' => $favouritableId
            ];

            if ($this->favouriteModel->favouriteItem($data)) 
            {
                 flash('favorite', 'Added to favorites successfully!', 'alert-success');
            } 
            else { flash('favorite', 'Could not add favorite. Please try again.');}
        }
    }

        public function listAllFavourites()
    {
       return $this->favouriteModel->listAllFavourites();
    }

    public function removeFavourite()
    {
        if (isset($_POST['removeFav']))
        {
            // taking the ids of the fav and info
            $userId = $_SESSION['userId'] ?? null;
            $favouritableId = $_POST['favouritableId'] ?? null;

            // if all present then we remove it
            if ($userId && $favouritableId) 
            {
                $removed = $this->favouriteModel->removeFavouriteItem($userId,$favouritableId);
                if ($removed) 
                {
                    exit();
                }
                else 
                {
                    exit();
                }
            }
            else { exit(); }
        }
    }

}

     // initalize
     $init = new FavouriteController();
     if (isset($_POST['removeFav'])) 
     {
    $init->removeFavourite(); 
     } else {
    $init->favouriteItem();
            }
?>