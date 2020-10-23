<?php
// Cart class that deals with the shopping cart functionality
class Cart
{
  function __construct()
  {
    if (empty($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
    }
  }

  /*
  addToCart function:
    Description: Creates an associative array that is then stored in the 'cart' session array.

    Parameters: $itemName  : string
                $itemPrice : float -- Note: this is so totalling the prices can be done easily,
                                              and currency formatting is done on the front end.)
    
    Return value: Nothing -- Note: modifies 'cart' "in place".
  */
  function addToCart($itemName, $itemPrice)
  {
    $temp_array = ['name' => $itemName, 'price' => $itemPrice, 'quantity' => 1, 'total' => $itemPrice];
    array_push($_SESSION['cart'], $temp_array);
  }

  function getCartItem($index)
  {
    return $_SESSION['cart'][$index];
  }

  function getCartLength()
  {
    return count($_SESSION['cart']);
  }

  /*
  checkCartForItem function:
    Description:  Iterates through the 'cart' array to look for items with names
                  that match the $item parameter.

    Parameters: $item : string
    
    Return value: Index of the matching item -- Note: If no matches are found returns -1.
  */
  function checkCartForItem($item)
  {
    foreach ($_SESSION['cart'] as $key => $value) {
      if ($_SESSION['cart'][$key]['name'] == $item) {
        return $key;
      }
    }
    return -1;
  }

  /*
  updateItemQuantity function:
    Description:  Modifies the 'quantity' value for the item at the index of $index
                  and updates the 'total' value. If 'quantity' is now 0, removes that
                  item from 'cart', and adjusts the indices of the other items.

    Parameters: $index  : int
                $amount : int
    
    Return value: Nothing -- Note: modifies 'cart' "in place".
  */
  function updateItemQuantity($index, $amount)
  {
    $_SESSION['cart'][$index]['quantity'] += $amount;
    $_SESSION['cart'][$index]['total'] += $_SESSION['cart'][$index]['price'] * $amount;
    if ($_SESSION['cart'][$index]['quantity'] == 0) {
      unset($_SESSION['cart'][$index]);
      $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
  }

  /*
  getTotalPrice function:
    Description:  Adds all the totals for each item in 'cart' and returns that value.

    Parameters: Nothing
    
    Return value: Total price for all items -- Note: returns float as currency formatting is done on the front end.
  */
  function getTotalPrice()
  {
    $total = 0;
    foreach ($_SESSION['cart'] as $key => $value) {
      $total += $_SESSION['cart'][$key]['total'];
    }
    return $total;
  }
}
