# Tripzly - built with PHP PDO, HTML, CSS, mySQL

## About
Tripzly is a web-based budget travel planning platform designed to meet the needs of Sri Lankan travelers. This website offers a centralized solution that helps users plan, book, and manage travel efficiently, while accommodating personal budgets and preferences.

The system supports three main user roles: administrator, user, and business, each with tailored functionalities. Admins manage and verify user, business accounts and the visibility of listings, while users can search, book, and review services, from tours to stays, and restaurants and attractions. Businesses can register their account and manage their listings through a dedicated dashboard, which allows them to approve or reject bookings/reservations.

Furthermore, Users and Businesses will receive emails about booking/reservation information.

## Built With
* PHP PDO
* HTML
* CSS
* JavaScript
* mySQL
* Bramus Router
* PHP Mailer

This followed the MVC architecture and clean URL routing, instead of the .php extension. I downloaded Bramus Router to achieve this.  

Since this was a team project, the frontend of the application was handled by the frontend developer. It was built using HTML, CSS, and JavaScript. It also includes the OpenWeather and Location third-party APIs. 

I was the backend developer of the budget travel platform. The website was developed with Object-oriented PHP, where the queries that interacted with the database were written in the models. The controller acted as the communicator between the view and the model. Thus, this successfully followed the principles of the MVC architecture.

To email users, PHP Mailer was used, and this was achieved by downloading Composer into the folder of my project. Using my email, I generated a password in order to be able to use that as the primary email account to send emails to the user/business, so those steps are neccessary for the SMTP server to work.

The database used was MySQL. The name of the database is 'tripzly'. 

## Lessons Learned

* This was my first role as a backend developer, instead of full-stack, and as this was my final project for my Higher Diploma, I self-learned the MVC architecture, clean URL routing, and followed PHP PDO, all in a matter of four weeks.
* Learning how to send emails through PHPMailer was a challenging task, just as figuring out how to do URL routing through Bramus router was, but with the help of platforms like StackOverflow and Reddit, where other developers helped me with my doubts, I managed to accomplish it.
* The time constraint for this project was taxing, yet also gave me an example of what durations and deadlines for projects in coporate environments will be like, and allowed me to prepare for it. Furthermore, I also worked with a group for this final project, where our tasks were balanced according to our roles.
