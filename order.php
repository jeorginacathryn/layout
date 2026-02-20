<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = intval($_POST['id']);
    $quantity = intval($_POST['quantity']);
    $name = $conn->real_escape_string($_POST['user']);
    $contact = $conn->real_escape_string($_POST['contact_num']);

    /* get product from database*/
    $sql = "SELECT product_name, price, stocks, image 
            FROM products 
            WHERE id = $id";

    $result = $conn->query($sql);

    if (!$result || $result->num_rows === 0) {
        die("Product not found.");
    }

    $product = $result->fetch_assoc();

    /* conditions */
    if ($quantity <= 0) {
        die("Invalid quantity.");
    }

    if ($quantity > $product['stocks']) {
        die("Not enough stock available.");
    }

    /*total equation*/
    $total = $product['price'] * $quantity;

    
    $product_name = $conn->real_escape_string($product['product_name']);
    $image = $conn->real_escape_string($product['image']);

   /*Insert order records*/
    $insert = "INSERT INTO orders
        (product_name, quantity, image, total, name, contact_num)
        VALUES
        (
            '$product_name',
            $quantity,
            '$image',
            $total,
            '$name',
            '$contact'
        )";

    if (!$conn->query($insert)) {
        die("Order Error: " . $conn->error);
    }

    /*Stock update*/
    $newStock = $product['stocks'] - $quantity;

    $update = "UPDATE products 
               SET stocks = $newStock 
               WHERE id = $id";
    
    if (!$conn->query($update)) {
        die("Stock Update Error: " . $conn->error);
    }

    echo "<script>
        alert('Thank you for purchasing!');
        window.location.href = 'products.php';
    </script>";
}

$conn->close();
?>