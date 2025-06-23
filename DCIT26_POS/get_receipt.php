<?php
// Fetch latest sale from sales_tbl
include('db.php');

// Adjusted query to use the correct column names based on your table structure
$query = "SELECT * FROM sales_tbl ORDER BY CREATED_AT DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $sale_id = $row['SALE_ID'];
    $username = $row['USERNAME'];
    $total_payable = $row['TOTAL_PAYABLE'];
    $item_details = $row['ITEM_DETAILS'];
    $created_at = $row['CREATED_AT'];
    $paid_amount = $row['PAID_AMOUNT'];
    $changed = $row['CHANGED'];
    
    // Decode the JSON item details
    $items = json_decode($item_details, true);
    $formatted_items = '';
    if ($items) {
        foreach ($items as $item) {
            $formatted_items .= "<p><strong>Product:</strong> {$item['product_name']}<br>
                                 <strong>Quantity:</strong> {$item['quantity']}<br>
                                 <strong>Unit Price:</strong> \${$item['unit_price']}<br>
                                 <strong>Total Price:</strong> \${$item['total_price']}</p>";
        }
    } else {
        $formatted_items = 'No items available.';
    }
} else {
    echo "No sale data available.";
}
?>
