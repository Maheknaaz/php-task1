<?php
session_start();

// Initialize product list if not set
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = [];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = trim($_POST['product_name']);
    $productPrice = floatval($_POST['product_price']);

    if (!empty($productName) && $productPrice > 0) {
        $product = [
            'name' => $productName,
            'price' => $productPrice
        ];
        $_SESSION['products'][] = $product;
    }
}

// Calculate total price
$totalPrice = 0;
foreach ($_SESSION['products'] as $p) {
    $totalPrice += $p['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Price Tracker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main-container">
    <div class="card">
        <h1>🛒 Product Price Tracker</h1>
        <p class="subtext">Enter product name and price. Your entries will be listed and totaled below using PHP.</p>

        <form method="POST" action="" class="product-form">
            <label for="product_name">Product Name <span>*</span></label>
            <input type="text" id="product_name" name="product_name" placeholder="e.g., Notebook" required>

            <label for="product_price">Product Price <span>*</span></label>
            <input type="number" step="0.01" id="product_price" name="product_price" placeholder="e.g., 99.99" required>

            <button type="submit">➕ Add Product</button>
        </form>

        <div class="output-section">
            <h2>🧾 Product List</h2>
            <ul class="product-list">
                <?php if (empty($_SESSION['products'])): ?>
                    <li>No products added yet.</li>
                <?php else: ?>
                    <?php foreach ($_SESSION['products'] as $item): ?>
                        <li>
                            <span class="name"><?php echo htmlspecialchars($item['name']); ?></span>
                            <span class="price">₹<?php echo number_format($item['price'], 2); ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <h3 class="total">💰 Total Price: ₹<?php echo number_format($totalPrice, 2); ?></h3>
        </div>
    </div>
</div>
</body>
</html>
