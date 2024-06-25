<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

// Отримання даних з форми оформлення замовлення
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$postOffice = $_POST['post_office'];

// Отримання товарів з корзини
$cartItems = json_decode($_POST['cart'], true);

// Відправка листа через PHPMailer
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'osromanuk0405@gmail.com';
$mail->Password = 'orkmzmcpwzhzbbbc'; // Спеціальний пароль для додатку

$mail->setFrom('osromanuk0405@gmail.com', 'Олексій');
$mail->addAddress($email, $name);
$mail->Subject = 'Замовлення на сайті CoffeeKing';
$mail->CharSet = 'UTF-8'; // Встановлення кодування

$mail->isHTML(true);

// Створення тіла листа з даними про замовлення
$message = "
    <h2>Підтвердження замовлення</h2>
    <p>Ім'я: $name</p>
    <p>Email: $email</p>
    <p>Адреса: $address</p>
    <p>Відділення Нової Пошти: $postOffice</p>
    <p>Товари:</p>";

if (!empty($cartItems)) {
    $message .= "<ul>";
    foreach ($cartItems as $item) {
        $productName = $item['name'];
        $price = $item['price'];

        $message .= "<li>$productName - $price грн</li>";
    }
    $message .= "</ul>";
}

$mail->Body = $message;

if (!$mail->send()) {
    
} else {
    // Очищення корзини після оформлення замовлення
    $_SESSION['cart'] = array();
    // Перенаправлення на сторінку підтвердження замовлення
    header("Location: submit_order.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>CoffeeKing - Оформлення замовлення</title>
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
    
    .order-form {
      width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f2f2f2;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .order-form label {
      display: block;
      margin-bottom: 10px;
      text-align: left;
      font-weight: bold;
    }

    .order-form input[type="text"],
    .order-form textarea {
      width: 100%;
      padding: 5px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    .order-form select {
      width: 100%;
      padding: 5px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    .order-form button[type="submit"] {
      background-color: #4CAF50;
      color: #ffffff;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
      cursor: pointer;
    }

    .order-form button[type="submit"]:hover {
      background-color: #45a049;
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
    <h2>Оформлення замовлення</h2>
    <form class="order-form" action="submit_order.php" method="post">
      <label for="name">Ім'я:</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email:</label>
      <textarea id="email" name="email" rows="2" required></textarea>

      <label for="address">Адреса:</label>
      <textarea id="address" name="address" required></textarea>

      <label for="post_office">Відділення Нової Пошти:</label>
      <select id="post_office" name="post_office" required>
        <option value="">Оберіть відділення</option>
        <option value="1">Відділення 1</option>
        <option value="2">Відділення 2</option>
        <option value="3">Відділення 3</option>
        <!-- Додайте додаткові варіанти відділень Нової Пошти -->
      </select>

      <!-- Передача корзини через приховане поле форми -->
      <input type="hidden" name="cart" value="<?php echo htmlspecialchars(json_encode($_SESSION['cart']), ENT_QUOTES, 'UTF-8'); ?>">

      <button type="submit">Замовити</button>
    </form>
  </section>



</body>
</html>