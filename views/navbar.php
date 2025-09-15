<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tripzly Navbar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      line-height: 1.6;
      background: linear-gradient(to bottom, #fdfbfb, #ebedee);
      color: #333;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #ffffff;
      padding: 1rem 2rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
      flex-wrap: wrap;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: bold;
      text-decoration: none;
      color: #003366;
    }

    .nav-links {
      display: flex;
      gap: 1.5rem;
      align-items: center;
    }

    .nav-links a {
      text-decoration: none;
      color: #444;
      font-weight: 500;
      padding: 0.3rem 0.5rem;
    }

    .nav-links a:hover {
      color: #003366;
    }

    .nav-buttons {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

      .btn {
  padding: 0.5rem 1rem;
  background: #003366;
  color: white;
  text-decoration: none;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

    .dropdown {
      position: relative;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      top: 120%;
      right: 0;
      background: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      border-radius: 5px;
      overflow: hidden;
      min-width: 160px;
      z-index: 999;
    }

    .dropdown-content a {
      display: block;
      padding: 0.7rem 1rem;
      text-decoration: none;
      color: #333;
      white-space: nowrap;
    }

    .dropdown-content a:hover {
      background: #f1f1f1;
    }

    /* Hamburger menu styles */
    .hamburger {
      display: none;
      font-size: 1.5rem;
      cursor: pointer;
      color: #003366;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
      .nav-links,
      .nav-buttons {
        display: none;
        flex-direction: column;
        width: 100%;
        margin-top: 1rem;
      }

      .nav-links.show,
      .nav-buttons.show {
        display: flex;
      }

      .navbar {
        align-items: flex-start;
      }

      .hamburger {
        display: block;
      }
    }

    /* Sticky nav shadow effect */
    nav.top {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>

  <nav class="navbar">
    <a href="/tripzly_test/home" class="logo">Tripzly</a>
    <div class="hamburger" id="hamburger"><i class="fas fa-bars"></i></div>

    <div class="nav-links" id="navLinks">
      <?php
      $components = array(
        "Stays" => "/tripzly_test/stays",
        "Tours" => "/tripzly_test/tours",
        "Attractions" => "/tripzly_test/attractions",
        "Restaurants" => "/tripzly_test/restaurants",
        "About Us" => "/tripzly_test/about_us",
        "Contact Us" => "/tripzly_test/contact"
      );

      foreach ($components as $pageName => $url) {
        echo "<a href='$url'>$pageName</a>";
      }
      ?>
    </div>

    <div class="nav-buttons" id="navButtons">
      <a href="/tripzly_test/register" class="btn">Register</a>
      <a href="/tripzly_test/admin/login" class="btn">Admin Login</a>
      <a href="/tripzly_test/user/login" class="btn">User Login</a>
      <a href="/tripzly_test/business/login" class="btn">Business Login</a>
   </div>

  </nav>

 
</body>

</html>
