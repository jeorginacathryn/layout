<?php
include "db.php";

$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $contact = htmlspecialchars($_POST['contact']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contacts (name, email, contact, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $contact, $subject, $message);

    if ($stmt->execute()) {
        $success = "Message sent successfully!";
    } else {
        $success = "Error sending message.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact - S&R Membership Shopping</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="style.css?v=2">

</head>
<body>

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

<section class="contact-section">
<div class="form-container">

<h2>Contact Us</h2>

<?php if ($success != ""): ?>
    <div class="alert alert-info">
        <?php echo $success; ?>
    </div>
<?php endif; ?>

<form method="POST" action="">

<div class="mb-3">
<label class="form-label">Full Name</label>
<input type="text" class="form-control" name="name" required>
</div>

<div class="mb-3">
<label class="form-label">Email Address</label>
<input type="email" class="form-control" name="email" required>
</div>

<div class="mb-3">
<label class="form-label">Contact Number</label>
<input type="text" class="form-control" name="contact">
</div>

<div class="mb-3">
<label class="form-label">Subject</label>
<input type="text" class="form-control" name="subject">
</div>

<div class="mb-3">
<label class="form-label">Message</label>
<textarea class="form-control" name="message" rows="4" required></textarea>
</div>

<button type="submit" class="btn btn-dark w-100">
Send Message
</button>

</form>
</div>
</section>

<footer>
Copyright © 2025 S&R Membership Shopping.
</footer>

<script src="js/bootstrap.min.js"></script>
</body>
</html>