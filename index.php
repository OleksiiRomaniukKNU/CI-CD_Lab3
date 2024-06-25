<?php
session_start();

$loggedIn = false;
$userName = '';

if (isset($_SESSION['user_id'])) {
    $loggedIn = true;
    $userName = $_SESSION['name'];
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>CoffeeKing - Головна</title>
  <style>
    /* Add your site's styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('img/background2.jpg'); 
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
      font-size: 28px;
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
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    nav ul li {
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
    
    section {
      padding: 50px;
      text-align: center;
    }
    
    footer {
      background-color: #f2f2f2;
      padding: 20px;
      text-align: center;
    }

    p {
      font-size: 18px;
      line-height: 1.5;
      text-align: center;
      margin-bottom: 20px;
    }
    
    .coffee-button {
      display: inline-block;
      background-color: #4CAF50;
      color: #ffffff;
      padding: 10px 20px;
      font-size: 18px;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }
    
    .coffee-button:hover {
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
      <?php if ($loggedIn): ?>
        <form action="profile.php" method="post">
          <input type="submit" value="Профіль">
        </form>
        <form action="logout.php" method="post">
          <input type="submit" value="Вийти">
        </form>
      <?php else: ?>
        <form action="login.php" method="post">
          <input type="submit" value="Увійти">
        </form>
        <form action="registration.php" method="post">
          <input type="submit" value="Зареєструватись">
        </form>
      <?php endif; ?>
    </div>
  </nav>
  
  <section>
    <h2>Ласкаво просимо в CoffeeKing!</h2>
    <p>Наш магазин пропонує широкий асортимент кави найвищої якості. Ми працюємо з найкращими постачальниками кави, щоб ви могли насолоджуватися справжнім смаком цього чудового напою.</p>
    <p>Замовляйте нашу каву вже сьогодні і отримуйте незабутнє задоволення від кожної чашки!</p>
    <a class="coffee-button" href="coffee.php">Дізнатися більше про нашу каву</a>
  </section>

</body>
</html>