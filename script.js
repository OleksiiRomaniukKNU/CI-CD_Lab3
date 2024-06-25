document.addEventListener('DOMContentLoaded', () => {
  const cartIcon = document.querySelector('.cart-icon');
  const cartContainer = document.querySelector('.cart-container');
  const cartCloseBtn = document.querySelector('.cart-close');
  const cartItems = document.querySelector('.cart-items');


  cartIcon.addEventListener('click', () => {
    cartContainer.style.display = 'block';
  });

  cartCloseBtn.addEventListener('click', () => {
    cartContainer.style.display = 'none';
  });

  const coffeeItems = document.querySelectorAll('.coffee-item');

  coffeeItems.forEach(item => {
    const addToCartBtn = item.querySelector('.add-to-cart');
    addToCartBtn.addEventListener('click', () => {
      const coffeeName = addToCartBtn.getAttribute('data-name');
      const coffeePrice = addToCartBtn.getAttribute('data-price');
      const cartItem = findCartItem(coffeeName, coffeePrice);

      if (cartItem) {
        // Якщо товар вже є в корзині, збільшуємо його кількість
        cartItem.quantity += 1;
        updateCartItem(cartItem);
      } else {
        // Якщо товару немає в корзині, додаємо новий елемент
        const newCartItem = {
          name: coffeeName,
          price: coffeePrice,
          quantity: 1
        };
        addCartItem(newCartItem);
      }

      renderCart();
    });
  });

  // Додавання товару до корзини в сесії
  function addCartItem(item) {
    if (!item || !item.name || !item.price || !item.quantity) {
      return;
    }

    let cart = [];
    if (sessionStorage.cart) {
      cart = JSON.parse(sessionStorage.cart);
    }

    cart.push(item);
    sessionStorage.cart = JSON.stringify(cart);
  }

  // Оновлення товару в корзині в сесії
  function updateCartItem(item) {
    if (!item || !item.name || !item.price || !item.quantity) {
      return;
    }

    let cart = [];
    if (sessionStorage.cart) {
      cart = JSON.parse(sessionStorage.cart);
    }

    const index = cart.findIndex(cartItem => cartItem.name === item.name && cartItem.price === item.price);
    if (index !== -1) {
      cart[index] = item;
      sessionStorage.cart = JSON.stringify(cart);
    }
  }

  // Видалення товару з корзини в сесії
  function removeCartItem(item) {
    if (!item || !item.name || !item.price) {
      return;
    }

    let cart = [];
    if (sessionStorage.cart) {
      cart = JSON.parse(sessionStorage.cart);
    }

    const index = cart.findIndex(cartItem => cartItem.name === item.name && cartItem.price === item.price);
    if (index !== -1) {
      cart.splice(index, 1);
      sessionStorage.cart = JSON.stringify(cart);
    }
  }

  // Пошук товару в корзині
  function findCartItem(name, price) {
    let cart = [];
    if (sessionStorage.cart) {
      cart = JSON.parse(sessionStorage.cart);
    }

    return cart.find(item => item.name === name && item.price === price);
  }

  // Відображення товарів з сесії у корзині
  function renderCart() {
    let cart = [];
    if (sessionStorage.cart) {
      cart = JSON.parse(sessionStorage.cart);
    }

    cartItems.innerHTML = '';

    cart.forEach(item => {
      const cartItem = createCartItem(item.name, item.price, item.quantity);

      const removeBtn = document.createElement('button');
      removeBtn.textContent = 'Remove';
      removeBtn.classList.add('remove-from-cart');
      removeBtn.addEventListener('click', () => {
        cartItems.removeChild(cartItem);
        removeCartItem(item);
        renderCart();
      });

      const decreaseBtn = document.createElement('button');
      decreaseBtn.textContent = '-';
      decreaseBtn.classList.add('decrease-quantity');
      decreaseBtn.addEventListener('click', () => {
        if (item.quantity > 1) {
          item.quantity -= 1;
          updateCartItem(item);
          renderCart();
        }
      });

      const increaseBtn = document.createElement('button');
      increaseBtn.textContent = '+';
      increaseBtn.classList.add('increase-quantity');
      increaseBtn.addEventListener('click', () => {
        item.quantity += 1;
        updateCartItem(item);
        renderCart();
      });

      cartItem.appendChild(removeBtn);
      cartItem.appendChild(decreaseBtn);
      cartItem.appendChild(increaseBtn);
      cartItems.appendChild(cartItem);
    });

    updateCartCount();
  }

  // Оновлення лічильника товарів у корзині
  function updateCartCount() {
    let count = 0;
    let cart = [];
    if (sessionStorage.cart) {
      cart = JSON.parse(sessionStorage.cart);
    }

    cart.forEach(item => {
      count += item.quantity;
    });

    const cartCount = document.querySelector('.cart-count');
    cartCount.textContent = count;
  }

  // Створення елементу товару в корзині
function createCartItem(name, price, quantity) {
  const cartItem = document.createElement('div');
  cartItem.classList.add('cart-item');

  const itemName = document.createElement('span');
  itemName.textContent = name;
  itemName.classList.add('cart-item-name');
  cartItem.appendChild(itemName);

  const itemPrice = document.createElement('span');
  itemPrice.textContent = price + ' грн';
  itemPrice.classList.add('cart-item-price');
  cartItem.appendChild(itemPrice);

  const itemQuantity = document.createElement('span');
  itemQuantity.textContent = 'Кількість: ' + quantity;
  itemQuantity.classList.add('cart-item-quantity');
  cartItem.appendChild(itemQuantity);

  return cartItem;
}

  renderCart(); // Відображення товарів з сесії у корзині
});
// Отримати всі кнопки "Додати в корзину"
var addToCartButtons = document.querySelectorAll('.add-to-cart');

// Обробник події для кнопок "Додати в корзину"
addToCartButtons.forEach(function(button) {
  button.addEventListener('click', function() {
    var name = button.getAttribute('data-name');
    var price = button.getAttribute('data-price');

    // Викликати функцію додавання товару в корзину
    addToCart(name, price);
  });
});

// Функція додавання товару в корзину
function addToCart(name, price) {
  // Відправити POST-запит на сервер, щоб додати товар у сесію
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'add_to_cart.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Обновити значення лічильника товарів у корзині
      var cartCount = document.querySelector('.cart-count');
      cartCount.textContent = xhr.responseText;
    }
  };
  xhr.send('name=' + name + '&price=' + price);
}