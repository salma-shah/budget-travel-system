<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="/tripzly_test/views/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($attraction->name) ?> – Tripzly</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f9fafa;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      max-width: 1100px;
      margin: auto;
      padding: 20px;
    }
    h1 {
      color: #2c3e50;
      margin-bottom: 10px;
    }
    .main-image {
      width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .details {
      margin-top: 20px;
      line-height: 1.8;
    }
    .details h2 {
      color: #0077cc;
      margin-top: 30px;
    }
    .external-links {
      margin-top: 30px;
      padding: 15px;
      background: #e8f4fd;
      border-radius: 8px;
      border-left: 4px solid #0077cc;
      font-size: 1rem;
    }
    .external-links ul {
      list-style-type: disc;
      padding-left: 20px;
    }
    .external-links a {
      color: #0077cc;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    .external-links a:hover {
      text-decoration: underline;
      color: #005fa3;
    }
    .contact-info {
      margin-top: 30px;
      font-size: 16px;
      background: #e8f4fd;
      padding: 15px 20px;
      border-left: 4px solid #0077cc;
      border-radius: 5px;
    }
    .contact-info strong {
      color: #0077cc;
    }
  </style>
</head>
<body>
   <?php include 'navbar.php'; ?>  

  <div class="container">
    <h1><?= htmlspecialchars($attraction->name) ?></h1>

  <img class="main-image" src="/tripzly_test/<?= htmlspecialchars($attraction->image->image ?? 'default-image.jpg') ?>" alt="<?= htmlspecialchars($attraction->image->alt_text ?? 'Attraction Image') ?>" />

<div class="details">
  <p>
    <?= nl2br(htmlspecialchars($attraction->description)) ?>
  </p>

  <h2>Historical Overview</h2>
  <p>
    <?= nl2br(htmlspecialchars($attraction->overview ?? 'History section not available.')) ?>
  </p>

<h2>Architectural Highlights</h2>
<ul>
  <?php 
  $highlights = [
    $attraction->highlight1 ?? null,
    $attraction->highlight2 ?? null,
    $attraction->highlight3 ?? null,
  ];
  $hasHighlights = false;
  foreach ($highlights as $highlight) {
    if (!empty($highlight)) {
      $hasHighlights = true;
      // split the highlight text values by the first : to seepratet title and description
      $parts = explode(':', $highlight, 2);
      $title = htmlspecialchars(trim($parts[0]));
      $desc = isset($parts[1]) ? htmlspecialchars(trim($parts[1])) : '';
      echo "<li><strong>{$title}:</strong> {$desc}</li>";
    }
  }
  if (!$hasHighlights) {
    echo "<li>No architectural highlights available.</li>";
  }
  ?>
</ul>

  <h2>Visitor Experience</h2>
  <p>
    <?= nl2br(htmlspecialchars($attraction->visitor_exp ?? 'Details not provided.')) ?>
  </p>

  <div class="external-links">
    <p><strong>Explore detailed Wikipedia pages with images and more info:</strong></p>
    <ul>
      <?php foreach ($attraction->reference_links as $link): ?>
        <li><a href="<?= htmlspecialchars($link->url) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($link->title) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>

  <div class="contact-info">
    <p><strong>To book a tour guide:</strong><br>
      Call or WhatsApp <strong>
        <a href="tel:<?= htmlspecialchars($attraction->contact_number) ?>"><?= htmlspecialchars($attraction->contact_number) ?></a>
      </strong> for English-speaking guides at <?= htmlspecialchars($attraction->name) ?>.
    </p>
  </div>
</div>

  </div>

  <!-- Footer -->
  <footer>
    <div class="footer-container">
      <div class="footer-section">
        <h4>Company</h4>
        <ul>
          <li><a href="about.php">About Tripzly</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Newsroom</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Explore</h4>
        <ul>
          <li><a href="stays.php">Stays</a></li>
          <li><a href="attractions.php">Attractions</a></li>
          <li><a href="restaurants.php">Restaurants</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Help</h4>
        <ul>
          <li><a href="contact.php">Customer Support</a></li>
          <li><a href="about.php">Terms & Conditions</a></li>
          <li><a href="about.php#">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Connect With Us</h4>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Instagram</a></li>
          <li><a href="#">YouTube</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2025 Tripzly. All rights reserved.
    </div>
  </footer>
</body>
</html>
