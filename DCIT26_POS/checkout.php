<?php
// Include the database connection file
include 'db.php';

session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Get the logged-in user's username
    
    // Fetch cart items for the user
    $query = "SELECT p.PRODUCT_NAME, c.QUANTITY, p.PRICE, p.CATEGORY
              FROM cart_tbl c
              JOIN product_tbl p ON c.PRODUCT_ID = p.PRODUCT_ID
              WHERE c.username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Prepare item details and calculate total payable
        $item_details = [];
        $total_payable = 0;

        while ($row = $result->fetch_assoc()) {
            $quantity = $row['QUANTITY'];
            $price = $row['PRICE'];
            $category = $row['CATEGORY'];
            $product_name = $row['PRODUCT_NAME'];
            
            // Handle pricing logic for "Cookies" category
            if ($category === 'Cookies' && $quantity >= 5) {
                $box_count = intdiv($quantity, 5); // Calculate number of boxes
                $remaining_cookies = $quantity % 5; // Calculate leftover cookies
                
                // Add cost of boxes
                $total_payable += $box_count * 180;
                $item_details[] = [
                    'product_name' => "Box of 5 $product_name",
                    'quantity' => $box_count,
                    'unit_price' => 180,
                    'total_price' => $box_count * 180
                ];
                
                // Add cost of remaining cookies
                if ($remaining_cookies > 0) {
                    $total_payable += $remaining_cookies * $price;
                    $item_details[] = [
                        'product_name' => $product_name,
                        'quantity' => $remaining_cookies,
                        'unit_price' => $price,
                        'total_price' => $remaining_cookies * $price
                    ];
                }
            } else {
                // For other products, calculate total price normally
                $total_price = $quantity * $price;
                $total_payable += $total_price;
                $item_details[] = [
                    'product_name' => $product_name,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'total_price' => $total_price
                ];
            }
        }

        // Get the paid amount and change from the POST request (e.g., from the checkout form)
        $paid_amount = isset($_POST['paid_amount']) ? $_POST['paid_amount'] : 0.00;
        $change = $paid_amount - $total_payable;

        // Debugging: Output the values
        echo "Total Payable: ₱" . number_format($total_payable, 2) . "<br>";
        echo "Paid Amount: ₱" . number_format($paid_amount, 2) . "<br>";
        echo "Change: ₱" . number_format($change, 2) . "<br>";

        // Insert the sale into sales_tbl, including paid amount and change
        $insert_query = "INSERT INTO sales_tbl (USERNAME, TOTAL_PAYABLE, ITEM_DETAILS, PAID_AMOUNT, `CHANGED`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $item_details_json = json_encode($item_details); // Convert item details to JSON
        $stmt->bind_param("sdsdd", $username, $total_payable, $item_details_json, $paid_amount, $change);
        
        if ($stmt->execute()) {
            // Clear the user's cart
            $clear_cart_query = "DELETE FROM cart_tbl WHERE username = ?";
            $clear_cart_stmt = $conn->prepare($clear_cart_query);
            $clear_cart_stmt->bind_param("s", $username);
            $clear_cart_stmt->execute();
            
            // Redirect to sale_transaction.php with success flag
            header("Location: sale_transaction.php?checkout_success=true");
            exit;
        } else {
            echo "Error: Could not complete the transaction.";
        }
    } else {
        echo "Your cart is empty.";
    }
} else {
    echo "You need to log in to checkout.";
}
?>
