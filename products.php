<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>S&R Membership Shopping</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="style.css?v=2">

</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-custom">
    <div class="nav-container">
        <img class="logo" src="img/logooo.png" alt="Logo">
        <div class="nav-links">
            <a href="index.html">HOME</a>
            <a href="products.php">PRODUCTS</a>
            <a href="about.html">ABOUT</a>
            <a href="contact.php">CONTACT</a>
        </div>
    </div>
</nav>

<?php
include "db.php";

$sql = "SELECT * FROM products WHERE stocks > 0";
$result = $conn->query($sql);
?>

<!-- PRODUCTS SECTION -->
<section class="product-container">

<?php
if ($result && $result->num_rows > 0) {
    while ($product = $result->fetch_assoc()) {
?>

    <div class="product-grid">

        <div class="product-card">
            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" 
                 alt="<?php echo htmlspecialchars($product['product_name']); ?>">
        </div>

        <div class="product-label">
            <h5><?php echo htmlspecialchars($product['product_name']); ?></h5>
            <p class="fw-bold text-primary">
                ₱<?php echo number_format($product['price'], 2); ?>
            </p>
            <p>Stocks: <?php echo $product['stocks']; ?></p>
        </div>

        <div class="buy-btn">
            <button class="btn btn-dark w-100"
                onclick="openbuynow(
                    <?php echo $product['id']; ?>,
                    '<?php echo addslashes($product['product_name']); ?>',
                    <?php echo $product['price']; ?>,
                    <?php echo $product['stocks']; ?>,
                    '<?php echo $product['image']; ?>'
                )">
                Buy Now
            </button>
        </div>

    </div>

<?php
    }
} else {
    echo "<div class='container mt-5'><h4>No products available.</h4></div>";
}

$conn->close();
?>

</section>

<!-- BUY NOW MODAL -->
<div class="modal fade" id="buynowmodal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title">Buy Now</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<form method="POST" action="order.php">

<input type="hidden" name="id" id="modalproductid">

<div class="text-center mb-3">
    <img id="modalproductimage"
         class="img-fluid"
         style="max-height:200px; object-fit:contain;">
</div>

<p><strong>Product:</strong> <span id="modalproductname"></span></p>
<p><strong>Price:</strong> ₱<span id="modalprice"></span></p>
<p><strong>Available Stocks:</strong> <span id="modalstocks"></span></p>

<div class="mb-3">
    <label class="form-label"><strong>Quantity</strong></label>
    <input type="number"
           id="modalquantity"
           name="quantity"
           class="form-control"
           value="1"
           min="1"
           required
           oninput="updateTotal()">
</div>

<div class="mb-3">
    <label class="form-label"><strong>Name</strong></label>
    <input type="text" class="form-control" name="user" required>
</div>

<div class="mb-3">
    <label class="form-label"><strong>Contact Number</strong></label>
    <input type="text" class="form-control" name="contact_num" required>
</div>

<p class="fw-bold">
    Total Amount: ₱<span id="modaltotalamount">0.00</span>
</p>

<button type="submit" class="btn btn-success w-100">
    Confirm Purchase
</button>

</form>
</div>
</div>
</div>
</div>

<!-- FOOTER -->
<footer>
    Copyright © 2025 S&R Membership Shopping.
</footer>

<script src="js/bootstrap.min.js"></script>

<script>
let currentPrice = 0;
let maxStocks = 0;

function openbuynow(id, name, price, stocks, image) {

    currentPrice = parseFloat(price);
    maxStocks = parseInt(stocks);

    document.getElementById("modalproductid").value = id;
    document.getElementById("modalproductname").innerText = name;
    document.getElementById("modalprice").innerText = currentPrice.toFixed(2);
    document.getElementById("modalstocks").innerText = stocks;
    document.getElementById("modalproductimage").src = "images/" + image;

    const qtyInput = document.getElementById("modalquantity");
    qtyInput.value = 1;
    qtyInput.max = stocks;

    updateTotal();

    let modal = new bootstrap.Modal(document.getElementById("buynowmodal"));
    modal.show();
}

function updateTotal() {
    let qty = parseInt(document.getElementById("modalquantity").value);

    if (qty > maxStocks) {
        qty = maxStocks;
        document.getElementById("modalquantity").value = maxStocks;
    }

    if (qty < 1 || isNaN(qty)) {
        qty = 1;
        document.getElementById("modalquantity").value = 1;
    }

    let total = currentPrice * qty;
    document.getElementById("modaltotalamount").innerText = total.toFixed(2);
}
</script>

</body>
</html>