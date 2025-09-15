<?php

require_once __DIR__ . '/../helpers/session_helper.php';

class ContactController {

  private $contactModel;
    public function __construct(){
        $this->contactModel = new Contact;
    }

    
     public function showContactSupportPage()
     {
        require_once __DIR__ . '/../views/contact_support.php';
     }
     
    public function submitContactForm(){
        if (($_SERVER['REQUEST_METHOD'] == 'POST'))  
        {
            // lets sanitize the data to remove any unneccesary data
           $subject = filter_var(trim($_POST['subject']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           
            // initalize data
            $data = [
                'email' => $email,
                'name' => $name,
                'subject' => $subject,
            ];

            // validating
            if (empty($data['subject']) || empty($data['name']) || empty($data['email'])) {
            flash('contact', 'All fields are required');
            redirect('/tripzly_test/contact');
        }

        if ($this->contactModel->submitContactForm($data)) {
            flash('contact', 'Contact form was submitted successfully! We will get back to you soon!', 'form-message form-message-green');
        } else {
            flash('contact', 'Something went wrong. Please try again.');
        }

        redirect('/tripzly_test/contact');
    }
}    

  public function submitContactSupportForm(){
        if (($_SERVER['REQUEST_METHOD'] == 'POST'))  
        {
            // lets sanitize the data to remove any unneccesary data
           $subject = filter_var(trim($_POST['subject']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           
            // initalize data
            $data = [
                'email' => $email,
                'name' => $name,
                'subject' => $subject,
            ];

            // validating
            if (empty($data['subject']) || empty($data['name']) || empty($data['email'])) {
            flash('contact', 'All fields are required');
            redirect('/tripzly_test/contact');
        }

        if ($this->contactModel->submitContactForm($data)) {
            flash('contact', 'Contact form was submitted successfully! We will get back to you soon!', 'form-message form-message-green');
        } else {
            flash('contact', 'Something went wrong. Please try again.');
        }
        
        redirect('/tripzly_test/contact_support');
    }
}
     
    public function viewAllContactForms(){
       return $this->contactModel->viewAllContactForms();
    }



}


?>