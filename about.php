<?php
session_start();

// Перевірка, чи існує користувач у сесії
if (isset($_SESSION['user_id'])) {
  $loggedIn = true;
  $username = $_SESSION['name'];
} else {
  $loggedIn = false;
}
// Перевірка, чи існує масив корзини в сесії
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array(); // Якщо масив корзини не існує, створюємо його
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>CoffeeKing - Про нас</title>
  <style>
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

    h2 {
      text-align: center;
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
          <input type="submit" value="Вхід">
        </form>
        <form action="registration.php" method="post">
          <input type="submit" value="Реєстрація">
        </form>
      <?php endif; ?>
    </div>
  </nav>
  <section>
  <h2>Про нас</h2>
  <p>Ми - команда професіоналів, яка працює над розробкою інноваційного хмарного сервісу для автоматизації замовлень в сфері обслуговування.</p>
  <p>Наша мета - спростити процес замовлення послуг для клієнтів і покращити ефективність роботи компаній, що надають обслуговування.</p>
  <p>Ми працюємо в тісному співробітництві з нашими клієнтами, щоб розробити рішення, яке відповідає їх потребам та допомагає досягати успіху.</p>
</section>

<section>
  <h2>Наш кавовий магазин</h2>
  <p>Ласкаво просимо в наш кавовий магазин! Ми пропонуємо вам великий вибір найсмачнішої кави з усього світу.</p>
  <p>У нашому асортименті ви знайдете каву різних сортів та обсмажень. Ми працюємо тільки з високоякісними зернами та партнерами, що дбають про якість своїх продуктів.</p>
  <p>Наші кавові експерти з радістю допоможуть вам з вибором кави, підкажуть найкращі способи приготування та з радістю відповідатимуть на ваші запитання.</p>
  <p>Завітайте до нашого магазину та насолоджуйтесь ароматом та смаком справжньої кави разом з нами!</p>
</section>
  
</body>
</html>