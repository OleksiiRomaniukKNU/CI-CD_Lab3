<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Отримання даних з форми оформлення замовлення
  $name = $_POST['name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $postOffice = $_POST['post_office'];

  // Перевірка заповненості полів
  if (empty($name) || empty($email) || empty($address) || empty($postOffice)) {
    $errorMessage = 'Будь ласка, заповніть всі поля форми';
    echo '<script>alert("'.$errorMessage.'");</script>';
  } else {
    // Збереження даних у сесію
    $_SESSION['checkout_data'] = array(
      'name' => $name,
      'email' => $email,
      'address' => $address,
      'post_office' => $postOffice
    );

    // Перенаправлення на сторінку submit_order.php
    header("Location: submit_order.php");
    exit();
  }
}

// Ініціалізація даних за замовчуванням
$name = '';
$email = '';
$address = '';
$postOffice = '';

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
    <form class="order-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <label for="name">Ім'я:</label>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

      <label for="email">Email:</label>
      <textarea id="email" name="email" rows="2" required><?php echo $email; ?></textarea>

      <label for="address">Адреса:</label>
      <textarea id="address" name="address" required><?php echo $address; ?></textarea>

      <label for="post_office">Відділення Нової Пошти:</label>
      <select id="post_office" name="post_office" required>
        <option value="">Оберіть відділення</option>
        <option value="1" <?php if ($postOffice == '1') echo 'selected'; ?>>Відділення 1</option>
        <option value="2" <?php if ($postOffice == '2') echo 'selected'; ?>>Відділення 2</option>
        <option value="3" <?php if ($postOffice == '3') echo 'selected'; ?>>Відділення 3</option>
        <!-- Додайте додаткові варіанти відділень Нової Пошти -->
      </select>

      <button type="submit">Замовити</button>
    </form>
  </section>

  <footer>
    &copy; 2023 CoffeeKing. Усі права захищено.
  </footer>

</body>
</html>