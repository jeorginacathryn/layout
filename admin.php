<?php
include "db.php";

/* ================= ADD PRODUCT ================= */
if (isset($_POST['add_product'])) {

    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $stocks = $_POST['stocks'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("INSERT INTO products (product_name, price, stocks, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $name, $price, $stocks, $image);

    if (!$stmt->execute()) {
        die("Insert Error: " . $stmt->error);
    }

    $stmt->close();
    header("Location: admin.php");
    exit();
}

/* ================= UPDATE PRODUCT ================= */
if (isset($_POST['update_product'])) {

    $id = $_POST['id'];
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $stocks = $_POST['stocks'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE products 
                            SET product_name=?, price=?, stocks=?, image=? 
                            WHERE id=?");
    $stmt->bind_param("sdisi", $name, $price, $stocks, $image, $id);

    if (!$stmt->execute()) {
        die("Update Error: " . $stmt->error);
    }

    $stmt->close();
    header("Location: admin.php");
    exit();
}

/* ================= DELETE PRODUCT ================= */
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die("Delete Error: " . $stmt->error);
    }

    $stmt->close();
    header("Location: admin.php");
    exit();
}

/* ================= EDIT FETCH ================= */
$editData = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editData = $result->fetch_assoc();
    $stmt->close();
}

/* ================= FETCH PRODUCTS ================= */
$products = $conn->query("SELECT * FROM products ORDER BY id");

if (!$products) {
    die("Fetch Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Helvetica, Arial;
            background: #f4f4f4;
            margin: 0;
        }

        h1 {
            margin-top: 30px;
        }

        table {
            border-collapse: collapse;
            background: #fff;
            margin: 20px auto;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background: #222;
            color: #fff;
        }

        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .btn {
            padding: 6px 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .edit { background: #3498db; }
        .delete { background: #e74c3c; }
        .add { background: #27ae60; }

        .display-wrapper {
            width: 90%;
            margin: auto;
            overflow-x: auto;
        }

        .form-table {
            margin-top: 40px;
        }

        input[type="text"],
        input[type="number"] {
            width: 95%;
            padding: 6px;
        }

        button {
            cursor: pointer;
        }
    </style>
</head>

<body>

<center>
<h1>ADMIN PANEL</h1>

<!-- ADD / EDIT FORM -->
<form method="post">
<table class="form-table">
<tr>
<th colspan="2">
<?= $editData ? "EDIT PRODUCT" : "ADD PRODUCT"; ?>
</th>
</tr>

<?php if ($editData): ?>
<tr>
<td>ID</td>
<td>
<input type="number" name="id"
value="<?= htmlspecialchars($editData['id']); ?>"
readonly>
</td>
</tr>
<?php endif; ?>

<tr>
<td>Product Name</td>
<td>
<input type="text" name="product_name"
value="<?= htmlspecialchars($editData['product_name'] ?? ''); ?>"
required>
</td>
</tr>

<tr>
<td>Price</td>
<td>
<input type="number" step="0.01" name="price"
value="<?= htmlspecialchars($editData['price'] ?? ''); ?>"
required>
</td>
</tr>

<tr>
<td>Stocks</td>
<td>
<input type="number" name="stocks"
value="<?= htmlspecialchars($editData['stocks'] ?? ''); ?>"
required>
</td>
</tr>

<tr>
<td>Image Filename</td>
<td>
<input type="text" name="image"
value="<?= htmlspecialchars($editData['image'] ?? ''); ?>"
required>
</td>
</tr>

<tr>
<td colspan="2">
<?php if ($editData): ?>
<button type="submit" name="update_product" class="btn edit">Update</button>
<a href="admin.php" class="btn delete">Cancel</a>
<?php else: ?>
<button type="submit" name="add_product" class="btn add">Add Product</button>
<?php endif; ?>
</td>
</tr>
</table>
</form>

<!-- PRODUCT TABLE -->
<div class="display-wrapper">
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Price</th>
<th>Stocks</th>
<th>Image</th>
<th>Action</th>
</tr>

<?php while ($row = $products->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['id']); ?></td>
<td><?= htmlspecialchars($row['product_name']); ?></td>
<td>₱<?= number_format($row['price'], 2); ?></td>
<td><?= htmlspecialchars($row['stocks']); ?></td>
<td><img src="images/<?= htmlspecialchars($row['image']); ?>"></td>
<td>
<a href="?edit=<?= $row['id']; ?>" class="btn edit">Edit</a>
<a href="?delete=<?= $row['id']; ?>"
   class="btn delete"
   onclick="return confirm('Delete this product?')">
Delete
</a>
</td>
</tr>
<?php endwhile; ?>

</table>
</div>

</center>
</body>
</html>