<?php 
    // include_once 'header.php';
include_once __DIR__ . '/../helpers/session_helper.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Tripzly – Register</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 400px;
      margin: 50px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #003366;
    }

    .toggle-buttons {
      display: flex;
      justify-content: space-between;
      margin: 20px 0;
    }

    .toggle-buttons button {
      flex: 1;
      padding: 10px;
      background-color: #eee;
      border: none;
      cursor: pointer;
      font-weight: bold;
      border-radius: 5px;
    }

    .toggle-buttons button.active {
      background-color: #003366;
      color: white;
    }

    form {
      display: none;
    }

    form.active {
      display: block;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    .submit-btn {
      width: 100%;
      background-color: #003366;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      margin-top: 20px;
      font-size: 16px;
      cursor: pointer;
    }

    .submit-btn:hover {
      background-color: #002244;
    }

    .login-link {
      text-align: center;
      margin-top: 15px;
    }

    .login-link a {
      color: #003366;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Register to Tripzly</h2>

    <div class="toggle-buttons">
      <button id="userBtn" class="active" onclick="showForm('user')">Register as User</button>
      <button id="businessBtn" onclick="showForm('business')">Register as Business</button>
    </div>

    <!-- User Form -->
    <form id="userForm" action="/tripzly_test/user/register" method="post" class="active" onsubmit="return validateUserForm()" >
        <?php flash('register'); ?>
      <input type="hidden" name="registerUser" value="registerUser">
      <input type="text" id="userFirstName" name="userFirstName" placeholder="First Name" required />
      <input type="text" id="userLastName" name="userLastName" placeholder="Last Name" required />
      <input type="text" id="userAddress" name="userAddress" placeholder="Address" required />
      <input type="text" id="userContact" name="userContact" placeholder="Contact Number" required />
      <input type="email" id="userEmail" name="userEmail" placeholder="Email" required />
      <input type="password" id="userPassword" name="userPassword" placeholder="Password" required />
      <input type="password" id="userConfirmPassword" name="userConfirmPassword"placeholder="Confirm Password" required />
      <button type="submit" class="submit-btn">Register as User</button>
    </form>

    <!-- Business Form -->
    <form id="businessForm" onsubmit="return validateBusinessForm()" action="/tripzly_test/business/register" method="post">
      <?php flash('register'); ?>
      <input type="hidden" name="registerBusiness" value="registerBusiness">
      <input type="text" id="businessName" name="businessName" placeholder="Company Name" required />
      <input type="text" id="businessAddress" name="businessAddress" placeholder="Address" required />
      <input type="text" id="businessContact" name="businessContact" placeholder="Contact Number" required />
      <input type="email" id="businessEmail" name="businessEmail" placeholder="Email" required />
      <input type="password" id="businessPassword" name="businessPassword" placeholder="Password" required />
      <input type="password" id="businessConfirmPassword" name="businessConfirmPassword" placeholder="Confirm Password" required />
      <button type="submit" class="submit-btn">Register as Business</button>
    </form>

    <div class="login-link">
      Already have an account? <a href="/tripzly_test/user/login">Login</a>
    </div>
  </div>

  <script>
    function showForm(type) {
      const userForm = document.getElementById('userForm');
      const businessForm = document.getElementById('businessForm');
      const userBtn = document.getElementById('userBtn');
      const businessBtn = document.getElementById('businessBtn');

      if (type === 'user') {
        userForm.classList.add('active');
        businessForm.classList.remove('active');
        userBtn.classList.add('active');
        businessBtn.classList.remove('active');
      } else {
        businessForm.classList.add('active');
        userForm.classList.remove('active');
        businessBtn.classList.add('active');
        userBtn.classList.remove('active');
      }
    }

    function validateEmail(email) {
      const pattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
      return pattern.test(email);
    }

    function validateUserForm() {
      const email = document.getElementById('userEmail').value.trim();
      const password = document.getElementById('userPassword').value;
      const confirmPassword = document.getElementById('userConfirmPassword').value;

      if (!validateEmail(email)) {
        alert("Please enter a valid email address.");
        return false;
      }

      if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
      }

      if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
      }

      return true;
    }

    function validateBusinessForm() {
      const email = document.getElementById('businessEmail').value.trim();
      const password = document.getElementById('businessPassword').value;
      const confirmPassword = document.getElementById('businessConfirmPassword').value;

      if (!validateEmail(email)) {
        alert("Please enter a valid email address.");
        return false;
      }

      if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
      }

      if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
      }

      return true;
    }
  </script>
</body>
</html>

