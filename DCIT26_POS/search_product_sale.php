<?php
// Assuming you're connected to the database
include('db.php');

// Get the search query from the request
$searchQuery = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';

// Build the SQL query to search for products
$query = "SELECT PRODUCT_ID, IMAGE, PRODUCT_NAME, PRICE, UPDATED_AT FROM product_tbl WHERE PRODUCT_NAME LIKE '%$searchQuery%' OR CATEGORY LIKE '%$searchQuery%'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="product-container mt-4">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="product-item">';
        echo '<div class="product-image"><img src="' . $row['IMAGE'] . '" alt="' . $row['PRODUCT_NAME'] . '"></div>';
        echo '<div class="product-name">' . $row['PRODUCT_NAME'] . '</div>';
        echo '<div class="product-price">₱' . number_format($row['PRICE'], 2) . '</div>';

        // Add to Cart button
        echo    '<div class="product-actions">
                <button class="add-to-cart-btn" onclick="addToCart(' . $row['PRODUCT_ID'] . ')">Add to Cart</button>
            </div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo 'No products found.';
}
?>
