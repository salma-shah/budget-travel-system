<?php
// calling vendor so we can use the profanity filter
// require '../vendor/autoload.php'; 
// using profanity filter library
// use ConsoleTVs\Profanity\Profanity;

include_once __DIR__ . '/../helpers/session_helper.php';

class ReviewController 
{
    private $reviewModel;
    public function __construct(){
        $this->reviewModel = new Review;
    }

    // save the review
    public function submitReview(){
        if (($_SERVER['REQUEST_METHOD'] == 'POST'))  
        {
            error_log('submitReview() is called');

            // sanitize
            $reviewableId = filter_var(trim($_POST['reviewableId']), FILTER_SANITIZE_NUMBER_INT);
            $reviewableType = filter_var(trim($_POST['reviewableType']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $rating = filter_var(trim($_POST['rating']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $comment = filter_var(trim($_POST['comment']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
             
              error_log("reviewableId: $reviewableId, reviewableType: $reviewableType, rating: $rating");

            // validating
            if (empty($rating) || empty($reviewableId) || empty($reviewableType)) 
            {
            flash('review', 'Please enter a rating and specify which property you are reviewing.');
            // redirect('../views/contact.php');
            }

            // checking for bad words 
            if ($this->containsProfanity($comment))
            {
            flash('review_error', 'Please remove inappropriate language from your review.');
            return;
            }

             // initalize data
            $data = [
                'user_id' => $_SESSION['userId'],
                'reviewable_id' => $reviewableId,
                'reviewable_type' =>  $reviewableType,
                'rating' => $rating,
                'comment' => $comment
            ];

            if ($this->reviewModel->saveReview($data)) 
            {
            flash('review', 'The review was submitted successfully! Thank you for your review!', 'form-message form-message-green');
            redirect('/tripzly_test/stay/' . $reviewableId);
            } 
            else {  flash('review', 'Something went wrong. Please try again.'); }

        }
    }

    // we create a custom function to spot profanity
    public function containsProfanity($text)
    {
        $badWords = ['damn', 'hell', 'shit', 'fuck', 'idiot', 'bastard'];
        foreach ($badWords as $badWord)
        {
            if (stripos($text, $badWord) !== false)
            {
                return true;
            }
        }
        return false;
    }
}

?>