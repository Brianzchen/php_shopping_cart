<?php
  session_start();
  // ######## please do not alter the following code ########
  $products = array(
    array("name" => "Sledgehammer", "price" => 125.75),
    array("name" => "Axe", "price" => 190.50),
    array("name" => "Bandsaw", "price" => 562.13),
    array("name" => "Chisel", "price" => 12.9),
    array("name" => "Hacksaw", "price" => 18.45)
  );
  // ##################################################

  $page = "index.php";
  if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = new Cart();
  }

  if (isset($_GET["add"])) {
    $_SESSION["cart"]->addItem($_GET["add"]);
    header("Location: " . $page);
  }

  if (isset($_GET["remove"])) {
    $_SESSION["cart"]->removeItem($_GET["remove"]);
    header("Location: " . $page);
  }

  function products() {
    global $products;

    echo "Products to choose from:<br><br>";
    foreach($products as $value) {
      echo "<div>Name " . $value["name"] . "<br>";
      echo "Price " . number_format($value["price"], 2) . "<br>";
      echo "<a href='cart.php?add=" . $value["name"] . "'>Add</a><br>";
      echo "<br></div>";
    }
  }

  function cart() {
    global $products;
    echo "Cart Items:<br><br>";
    $total = 0;
    foreach($_SESSION["cart"]->getItems() as $name => $value) {
      echo $name."<br>";

      foreach($products as $product) {
        if ($product["name"] == $name) {
          echo "$" . number_format($product["price"], 2) . "<br>";
          echo "Quantity: " . $value."<br>";
          echo "Total: $" . number_format($value*$product["price"], 2) . "<br>";
          echo "<a href='cart.php?remove=" . $name . "'>Remove</a><br>";

          $total += $value*$product["price"];
        }
      }
      echo "<br>";
    }
    if ($total == 0) {
      echo "Your cart is empty!";
    } else {
      echo "Total: $" . number_format($total, 2);
    }
    echo "<br>";
  }

  class Cart {
    private $items = array();

    public function addItem($addItem) {
      if (!empty($this->items[$addItem])){
        $this->items[$addItem] += "1";
      } else {
        $this->items[$addItem] = "1";
      }
    }

    public function removeItem($removeItem) {
      unset($this->items[$removeItem]);
    }

    public function getItems() {
      return $this->items;
    }
  }
?>
