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
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    if (empty($email) || empty($password)) {
        $response['error'] = "Будь ласка, введіть електронну пошту та пароль";
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                header("Location: index.php");
                exit();
            } else {
                $response['error'] = "Неправильна електронна пошта або пароль";
            }
        } else {
            $response['error'] = "Неправильна електронна пошта або пароль";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Увійти в профіль</title>
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
css
Copy code
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

.login-form {
  width: 300px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.login-form h2 {
  margin-top: 0;
}

.login-form label {
  display: block;
  margin-bottom: 10px;
}

.login-form input[type="email"],
.login-form input[type="password"] {
  width: 100%;
  padding: 5px;
  margin-bottom: 10px;
}

.login-form input[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.login-form input[type="submit"]:hover {
  background-color: #45a049;
}

.error {
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
  </nav>
  <section>
    <div class="login-form">
      <h2>Увійти в профіль</h2>
      <?php if (isset($response['error'])): ?>
        <p class="error"><?php echo $response['error']; ?></p>
      <?php endif; ?>
      <form action="" method="POST">
        <label for="email">Електронна пошта:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Увійти">
      </form>
    </div>
  </section>
  <footer>
    &copy; 2023 CoffeeKing. Усі права захищено.
  </footer>
</body>
</html>