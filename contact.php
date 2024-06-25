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
  <title>CoffeeKing - Контакти</title>
  <style>
    /* Add your site's styles */
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
      display: flex;
      justify-content: center;
      align-items: center;
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
    
    #map {
      height: 400px;
      width: 100%;
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
    <h2>Контакти</h2>
    <p>Якщо у вас виникли будь-які питання або ви бажаєте зв'язатися з нами, будь ласка, скористайтеся наступними контактними даними:</p>
    
    <p>Email: romaniuk.oleksii@knu.ua</p>
    <p>Телефон: +38(067)555-91-42</p>
    <p>Адреса: пр-т. Академіка Глушкова, 14 , м. Київ, Україна</p>
    
    <div id="map"></div>
    
    <script>
      function initMap() {
        var latitude = 50.36969; // Широта
        var longitude = 30.45513; // Довгота

        var mapOptions = {
          center: { lat: latitude, lng: longitude },
          zoom: 14
        };

        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
        var marker = new google.maps.Marker({
          position: { lat: latitude, lng: longitude },
          map: map,
          title: "проспект Академіка Глушкова, 14, м. Київ, Україна"
        });
      }
    </script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB84c0OTR2EuDUDl4w6z9y3yt68YjDFqnc&callback=initMap" async defer></script>
  </section>
  
  
</body>
</html>
