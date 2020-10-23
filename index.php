<?php
session_start();
include_once('products.php');
include_once('cart.php');

$product = new Products();
$productsArr = $product->getProductsArray();

$cart = new Cart();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  // Detect Submit button pressed
  if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // if adding to cart
    if ($_POST['submit'] == 'buy') {
      // store index of matching item in variable
      $checkCart = $cart->checkCartForItem($_POST['name']);
      // if item is found in cart
      if ($checkCart !== -1) {
        // increment quantity and update total price
        $cart->updateItemQuantity($checkCart, 1);
      } else {
        // otherwise the item is new and adds it to the cart
        $cart->addToCart($_POST['name'], $_POST['price']);
      }
      // if removing from cart
    } else if ($_POST['submit'] == 'remove') {
      // decrement quantity and update total price
      $cart->updateItemQuantity($_POST['index'], -1);
    }
    // redirect to / to avoid resubmitting forms on refresh
    header('Location: http://' . $_SERVER['HTTP_HOST']);
    exit();
  }
  ?>

  <!-- Products display -->
  <h1>Products</h1>
  <?php
  // formats prices to have 2 decimal places and $ in front.
  $format = new NumberFormatter('en', NumberFormatter::CURRENCY);
  foreach ($productsArr as $key => $value) { ?>
    <form method='POST' action='index.php'>
      <input type='hidden' name='name' value='<?php echo $productsArr[$key]['name'] ?>'><?php echo $productsArr[$key]['name'] ?></input>
      <input type='hidden' name='price' value='<?php echo $productsArr[$key]['price'] ?>'><?php echo $format->formatCurrency($productsArr[$key]['price'], 'USD') ?></input>
      <input type='submit' name='submit' value='buy' />
    </form>
  <?php
  }

  ?>
  <!-- Cart Display -->
  <h2>Cart</h2>
  <?php
  if ($cart->getCartLength() == 0) { ?>
    <p>Cart is empty.</p>
  <?php
  }
  for ($i = 0; $i < $cart->getCartLength(); $i++) { ?>
    <form method='POST' action='index.php'>
      <span><?php echo $cart->getCartItem($i)['name'] ?></span>
      <span>price: <?php echo $format->formatCurrency($cart->getCartItem($i)['price'], 'USD') ?></span>
      <span>x<?php echo $cart->getCartItem($i)['quantity'] ?></span>
      <span>total: <?php echo $format->formatCurrency($cart->getCartItem($i)['total'], 'USD') ?></span>
      <input type='hidden' name='index' value='<?php echo $i ?>' />
      <input type='submit' name='submit' value='remove' />
    </form>
  <?php
  }
  ?>
  <p>total: <?php echo $format->formatCurrency($cart->getTotalPrice(), 'USD') ?>
</body>

</html>