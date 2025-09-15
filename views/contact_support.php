<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Support - Tripzly Business Dashboard</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #eef3f7;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    form {
      max-width: 600px;
      margin: auto;
      background-color: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    label {
      font-weight: 600;
      display: block;
      margin-bottom: 8px;
      color: #333;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
    }

    textarea {
      resize: vertical;
      min-height: 100px;
    }

    button {
      background-color: #007acc;
      color: #fff;
      padding: 12px 20px;
      border: none;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #005fa3;
    }

    @media (max-width: 600px) {
      form {
        padding: 15px;
      }
    }
  </style>
</head>
<body>

  <h1>Contact Tripzly Support</h1>

  <form method="POST" action="/tripzly_test/submit_contact_support">
    <?php flash('contact')?>
    <label for="name">Your Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your full name" required />

    <label for="email">Your Email</label>
    <input type="email" id="email" name="email" placeholder="Enter your email address" required />

    <label for="message">Subject</label>
    <textarea id="subject" name="subject" placeholder="Write your message here..." required></textarea>

    <button type="submit">Send Message</button>
  </form>

</body>
</html>
