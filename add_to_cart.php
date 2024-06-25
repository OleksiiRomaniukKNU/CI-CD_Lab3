
<?php
session_start();

if (isset($_POST['name']) && isset($_POST['price'])) {
  $name = $_POST['name'];
  $price = $_POST['price'];

  $item = array(
    'name' => $name,
    'price' => $price
  );

  // Додати товар до масиву корзини в сесії
  $_SESSION['cart'][] = $item;

  // Повернути нову кількість товарів у корзині
  echo count($_SESSION['cart']);
}
?>