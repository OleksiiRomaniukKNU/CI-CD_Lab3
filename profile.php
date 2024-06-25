<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registeruser";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Помилка з'єднання з базою даних: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $userId = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE id = '$userId'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            $hashedNewPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE users SET name = '$name', email = '$email', password = '$hashedNewPassword' WHERE id = '$userId'";
            if ($conn->query($updateQuery) === TRUE) {
                $response['success'] = true;
                $_SESSION['email'] = $email; // Update session email if changed
            } else {
                $response['error'] = "Помилка при оновленні профілю: " . $conn->error;
            }
        } else {
            $response['error'] = "Неправильний пароль";
        }
    } else {
        header("Location: login.php");
        exit();
    }
}

$userId = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$userId'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
} else {
    header("Location: login.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Профіль</title>
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

.profile-form {
  width: 400px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.profile-form h2 {
  margin-top: 0;
}

.profile-form label {
  display: block;
  margin-bottom: 10px;
}

.profile-form input[type="text"],
.profile-form input[type="email"],
.profile-form input[type="password"] {
  width: 100%;
  padding: 5px;
  margin-bottom: 10px;
}

.profile-form input[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.profile-form input[type="submit"]:hover {
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
    <div class="login-buttons">
      <form action="profile.php" method="post">
        <input type="submit" value="Профіль">
      </form>
      <form action="logout.php" method="post">
        <input type="submit" value="Вийти">
      </form>
    </div>
  </nav>
  <section>
    <div class="profile-form">
      <h2>Профіль</h2>
      <?php if (isset($response['error'])): ?>
        <p class="error"><?php echo $response['error']; ?></p>
      <?php elseif (isset($response['success'])): ?>
        <p class="success">Профіль оновлено успішно.</p>
      <?php endif; ?>
      <form action="" method="POST">
        <label for="name">Ім'я:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
        <label for="email">Електронна пошта:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        <label for="password">Поточний пароль:</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="Зберегти зміни">
      </form>
    </div>
  </section>
  <footer>
    &copy; 2023 CoffeeKing. Усі права захищено.
  </footer>
</body>
</html>