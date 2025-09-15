<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login as Admin – Tripzly</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 350px;
    }

    h2 {
      text-align: center;
      color: #003366;
      margin-bottom: 20px;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    .login-btn {
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

    .login-btn:hover {
      background-color: #002244;
    }

    .bottom-link {
      text-align: center;
      margin-top: 15px;
    }

    .bottom-link a {
      color: #003366;
      text-decoration: none;
    }

    .bottom-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Admin Login</h2>
    <form id="adminLoginForm" action="/tripzly_test/user/login" method="post">
      <input type="email" id="email" name="email" placeholder="Email" required />
      <input type="password" id="password" name="password" placeholder="Password" required />
      <button type="submit" class="login-btn">Login</button>
    </form>
    </div>

  <script>
    document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();

      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

      if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        e.preventDefault();
        return;
      }

      if (password.length < 6) {
        alert('Password must be at least 6 characters long.');
        e.preventDefault();
        return;
      }
    });
  </script>
</body>
</html>
