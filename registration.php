<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registeruser";

$conn = new mysqli($servername, $username, $password, $dbname);

$response = array();

if ($conn->connect_error) {
    $response['error'] = "Помилка з'єднання з базою даних: " . $conn->connect_error;
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = mysqli_real_escape_string($conn, $email);

    // Перевірка, чи існує користувач з такою ж електронною поштою
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailResult = $conn->query($checkEmailQuery);

    if ($checkEmailResult->num_rows > 0) {
        $response['error'] = "Ця електронна пошта вже зареєстрована";
    } else {
        $name = mysqli_real_escape_string($conn, $name);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertQuery = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

        if ($conn->query($insertQuery) === TRUE) {
            $_SESSION['email'] = $email;
            header("Location: login.php");
            exit();
        } else {
            $response['error'] = "Помилка при реєстрації: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Реєстрація</title>
  <style>
    /* Додайте стилі для вашого сайту */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('img/background1.jpg'); 
      background-repeat: no-repeat;
      background-size: cover;
    }
    
    header {
      background-color: #f2f2f2;
      padding: 20px;
      text-align: center;
    }
    
    h1 {
      color: #333333;
      margin: 0;
    }
    
    nav {
      background-color: #333333;
      color: #ffffff;
      padding: 10px;
      text-align: center;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }
    
    nav ul li {
      display: inline-block;
      margin-right: 20px;
    }
    
    nav ul li a {
      color: #ffffff;
      text-decoration: none;
      transition: color 0.3s;
    }
    nav ul li a:hover {
      color: #cccccc;
    }
    
    section {
      padding: 50px;
      text-align: center;
    }
    
    footer {
      background-color: #f2f2f2;
      padding: 20px;
      text-align: center;
    }

    .logo {
      margin-right: 10px;
    }

    .login-buttons {
      display: flex;
      align-items: center;
    }

    .login-buttons form {
      display: flex;
      align-items: center;
    }

    .login-buttons input[type="submit"] {
      background-color: #333333;
      color: #ffffff;
      border: none;
      padding: 10px 20px;
      margin-left: 10px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .login-buttons input[type="submit"]:hover {
      background-color: #45a049;
    }

    /* Додайте інші стилі за потреби */
    
    .registration-form {
      width: 300px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f2f2f2;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .registration-form h2 {
      margin-top: 0;
    }

    .registration-form label {
      display: block;
      margin-bottom: 10px;
    }

    .registration-form input[type="text"],
    .registration-form input[type="email"],
    .registration-form input[type="password"] {
      width: 100%;
      padding: 5px;
      margin-bottom: 10px;
    }

    .registration-form input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .registration-form .error {
      color: #ff0000;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  
  <nav>
    <ul>
      <li><a href="index.php">Головна</a></li>
      <li><a href="coffee.php">Кава</a></li>
      <li><a href="about.php">Про нас</a></li>
      <li><a href="contact.php">Контакти</a></li>
    </ul>
    <img class="logo" src="img/logo(2).png" alt="CoffeeKing Logo">
    <div class="login-buttons">
      <form action="login.php" method="post">
        <input type="submit" value="Увійти">
      </form>
    </div>
  </nav>
  
  <section>
    <div class="registration-form">
      <h2>Реєстрація</h2>
      <?php if (isset($response['error'])): ?>
        <p class="error"><?php echo $response['error']; ?></p>
      <?php endif; ?>
      <form action="" method="POST">
        <label for="name">Ім'я:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Електронна пошта:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Зареєструватись">
      </form>
    </div>
  </section>

  <footer>
    &copy; 2023 CoffeeKing. Усі права захищено.
  </footer>

</body>
</html>