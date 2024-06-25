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
  <title>CoffeeKing - Кава</title>
  <style>
    /* Додайте стилі для вашого сайту */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('img/background1.jpg'); ц
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
    
    .coffee-item {
      position: relative;
      display: inline-block;
      margin: 20px;
      text-align: center;
      width: 300px;
      vertical-align: top;
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    
    .coffee-item:hover {
      transform: scale(1.1);
    }
    
    .coffee-item img {
      max-width: 100%;
      height: auto;
    }
    
    .coffee-item h2 {
      margin-top: 10px;
    }
    
    .coffee-item p {
      margin-top: 5px;
      font-style: italic;
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

    /* Стилі для корзини */
    .cart-icon {
      position: fixed;
      top: 20px;
      right: 20px;
      width: 40px;
      height: 40px;
      background-color: #f2f2f2;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      z-index: 1;
    }

    .cart-icon img {
      width: 24px;
      height: 24px;
    }

    .cart-count {
      position: absolute;
      top: -10px;
      right: -10px;
      background-color: #ff0000;
      color: #ffffff;
      font-size: 12px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .cart-container {
      position: fixed;
      top: 80px;
      right: 20px;
      width: 350px; /* Змінений розмір */
      max-height: 400px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      overflow-y: auto;
      display: none;
      z-index: 1;
    }

    .cart-container h3 {
      margin-top: 0;
    }

    .cart-items {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #ccc;
    }

    .cart-item-name {
      flex-grow: 1;
      margin-right: 10px;
    }

    .cart-item-price {
      font-weight: bold;
    }

    .cart-close {
      margin-top: 10px;
      background-color: #333333;
      color: #ffffff;
      border: none;
      padding: 5px 10px;
      border-radius: 3px;
      cursor: pointer;
    }

    .cart-close:hover {
      background-color: #222222;
    }

    /* Оновлені стилі для клавіш */
    .add-to-cart {
      background-color: #4CAF50;
      color: #ffffff;
      border: none;
      padding: 10px 20px;
      font-size: 18px;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
      cursor: pointer;
    }
    
    .add-to-cart:hover {
      background-color: #45a049;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 600px;
    }

    .modal-close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .modal-close:hover,
    .modal-close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }

    .modal-description {
      margin-top: 20px;
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
    <h2>Зернова кава</h2>
    <div class="coffee-column">
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 1">
        <h2>Accord Coffee</h2>
        <p>Ціна: 250 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Кава Accord Coffee" data-price="250">Додати в корзину</button>
        <?php endif; ?>
      </div>
      
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 4">
        <h2>Espresso Coffee</h2>
        <p>Ціна: 220 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Кава Espresso Coffee" data-price="220">Додати в корзину</button>
        <?php endif; ?>
      </div>
      
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 7">
        <h2>Lucky Day Coffee</h2>
        <p>Ціна: 250 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Кава Lucky Day Coffee" data-price="250">Додати в корзину</button>
        <?php endif; ?>
      </div>
      
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 10">
        <h2>Арабіка Болівія</h2>
        <p>Ціна: 250 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Кава Арабіка Болівія" data-price="250">Додати в корзину</button>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section>
    <h2>Мелена кава</h2>
    <div class="coffee-column">
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 2">
        <h2>Accord Coffee</h2>
        <p>Ціна: 280 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Кава Accord Coffee" data-price="280">Додати в корзину</button>
        <?php endif; ?>
      </div>
    
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 5">
        <h2>Espresso Coffee</h2>
        <p>Ціна: 260 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Кава Espresso Coffee" data-price="260">Додати в корзину</button>
        <?php endif; ?>
      </div>
    
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 8">
        <h2>Lucky Day Coffee</h2>
        <p>Ціна: 280 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Кава Lucky Day Coffee" data-price="280">Додати в корзину</button>
        <?php endif; ?>
      </div>
    
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 11">
        <h2>Арабіка Болівія</h2>
        <p>Ціна: 300 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Кава Арабіка Болівія" data-price="300">Додати в корзину</button>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section>
    <h2>Розчинна кава</h2>
    <div class="coffee-column">
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 3">
        <h2>Порошкова</h2>
        <p>Ціна: 200 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Порошкова" data-price="200">Додати в корзину</button>
        <?php endif; ?>
      </div>
    
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 6">
        <h2>Гранульована</h2>
        <p>Ціна: 180 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Гранульована" data-price="180">Додати в корзину</button>
        <?php endif; ?>
      </div>
    
      <div class="coffee-item" data-description="Опис кави" data-weight="250 г" data-ingredients="Склад кави" data-taste="Смакові властивості">
        <img src="img/coffee1.png" alt="Кава 9">
        <h2>Сублімована</h2>
        <p>Ціна: 200 грн</p>
        <?php if ($loggedIn) : ?>
          <button class="add-to-cart" data-name="Сублімована" data-price="200">Додати в корзину</button>
        <?php endif; ?>
      </div>
    
    </div>
  </section>
  
  

  
  <!-- Решта контенту -->
  <div class="cart-icon">
    <img src="img/cart-icon.png" alt="Shopping Cart">
    <span class="cart-count">
      <?php echo count($_SESSION['cart']); ?>
    </span>
  </div>

  <div class="cart-container">
    <h3>Корзина товарів</h3>
    <ul class="cart-items">
      <?php
      // Відображення товарів з сесії у корзині
      foreach ($_SESSION['cart'] as $item) {
        echo '<li>' . $item['name'] . ' - ' . $item['price'] . ' грн</li>';
      }
      ?>
    </ul>
    <button class="cart-close">Закрити</button>
    <a href="submit_order.php" class="checkout-button">Замовити</a>
  </div>

  <div class="modal" id="modal">
    <div class="modal-content">
      <span class="modal-close">&times;</span>
      <h2 id="modal-title"></h2>
      <p id="modal-description" class="modal-description"></p>
      <p id="modal-weight" class="modal-description"></p>
      <p id="modal-ingredients" class="modal-description"></p>
      <p id="modal-taste" class="modal-description"></p>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>