<?php
session_start(); // Start the session once at the top
include 'db.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to sweetthumb.php if the user is not logged in
    header('Location: sweetthumb.php');
    exit(); // Stop further script execution
}

$username = $_SESSION['username']; // Fetch the username
// Fetch username
//eto ang kukunin

// Query to get the user's role
$query = $conn->prepare("SELECT role FROM users_tbl WHERE username = ?");
$query->bind_param("s", $username); // Bind the parameter
$query->execute(); // Execute the query
$result = $query->get_result(); // Get the result set
$role = $result->fetch_assoc()['role']; // Fetch the role from the result set

if (!$role) {
    // Handle undefined role scenario if necessary
    header('Location: home.php'); // Default page if role is undefined
    exit();
}
?>


<!DOCTYPE html>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
<body>
<!DOCTYPE html>
<html lang="en">
    <style>
    .navbar-toggler {
        border-color: rgba(215, 211, 195, 1); /* Change border color */
    }
    .navbar-toggler-icon {
        background-color: rgba(215, 211, 195, 1); /* Change the button icon color */
    }
    body {
        background: url(BG2.png);
        background-size: cover;
    }
    /* Adjust spacing between nav items */
    .nav-item {
        margin-right: 10px; /* Default space between items */
    }
    /* Apply margin only to items with the nav-spacing class */
    .nav-spacing {
        margin-right: 13px; /* Adjust the distance as needed for specific items */
    }
    /* Adjust navbar text (username) styling */
    .navbar-text {
        margin-left: 10px;  /* Adjust distance between username and previous item */
        margin-right: 30px; /* Space between the username and logout */
        font-size: 1.5rem;   /* Adjust the font size of username */
    }
    /* Make sure the logout button stays on the far right */
    .nav-item:last-child {
        margin-right: -50px; /* Push logout item to the far right */
    }
    /* Optional: Adjust icon size in nav items */
    .nav-link i {
        font-size: 1.5rem; /* Set default icon size */
    }
    /*babaguhin na tong part na to */
    /* Style for the container */
    .styled-container {
        background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
        border-radius: 15px; /* Rounded corners */
        padding: 20px; /* Add space inside the container */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow effect */
        text-align: center; /* Center the text inside */
        color: #624837; /* Match the navbar's brown theme */
        width: 100%;
        height: auto;
        overflow: hidden;
    }
    /* Spacing between search input and button */
    .search-bar input {
        max-width: 100%; /* Adjust the width of the search bar */
        height: 40px; /* Set a consistent height */
    }
    /* Style for the Search button */
    .btn-search {
        background-color: #efa39b;
        border-color: #efa39b;
        color: white;
        padding: 5px 20px; /* Adjust the padding to make the button larger or smaller */
        font-size: 12px; /* Adjust the font size */
        border-radius: 5px; /* Optional: for rounded corners */
        margin-right: -7px;
        width: 180px;
    }
    .btn-search:hover {
        background-color:#F9B4A8; /* Lighter shade of the base color */
        border-color: #F9B4A8;
        color: white;
    }
    .custom-line {
        border-top: 4px solid #ddc1b9; /* Set the line thickness and color */
        margin: 10px 0; /* Add spacing above and below the line */
        border-radius: 5px;
    }
    /*fetch data */
    .product-container {
        display: flex;
        flex-wrap: wrap;
        gap: 5px; /* Reduced gap for both horizontal and vertical spacing */
        justify-content: flex-start; /* Align items at the start of the container */
        align-items: flex-start; /* Align items at the top of the container */
    }
    .product-item {
        width: 170px;  /* Set a specific width for the product item */
        height: 250px; /* Set a specific height for the product item */
        padding: 10px;
        border: 2px solid #ad9d92;
        border-radius: 16px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background-color: #FFF5F3;
        text-align: center;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-left:12px;
        justify-content: center;
        margin-right:9px;
        margin-bottom: 10px;
    }
    .product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    .product-image {
        width: 100%;
        height: 100px;
        overflow: hidden;
        border-radius: 16px;
    }
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-name {
        font-size: 0.8em;
        margin-top: 10px;
        font-weight: bold;
        color: #624837;
    }
    .product-price {
        color: #ed8a86;
        font-size: 1em;
        margin-top: 5px;
    }
    .product-updated {
        font-size: 0.9em;
        color: gray;
        margin-top: 5px;
    }
    .product-actions {
        margin-top: 10px;
    }
    .update-btn, .delete-btn, .add-to-cart-btn{
        padding: 8px 12px;
        margin: 5px;
        border: none;
        background-color: #c1867e;
        color: white;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .update-btn:hover, .delete-btn:hover, .add-to-cart-btn:hover {
        background-color: #c1a092;
    }
    .btn-check-out, .btn-void, .btn-print-receipt {
        padding: 8px 12px;
        margin: 5px;
        border: none;
        background-color: #c1867e;
        color: white;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        width: 100%;
    }
    .btn-check-out:hover, .btn-void:hover, .btn-print-receipt:hover{
        background-color: #c1a092;
    }

    @media (max-width: 768px) {
        .product-item {
            flex: 1 1 calc(50% - 20px);
        }
    }

    @media (max-width: 480px) {
        .product-item {
            flex: 1 1 calc(100% - 20px);
        }
    }
    .message-box {
        background-color: #968276; /* Default background color for success */
        color: white;
        padding-top: 10px;
        padding-bottom: 10px; /* Adjust bottom padding */
        width: 100%;
        height: auto;
        border-radius: 5px;
        font-size: 14px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: none; /* Hidden by default */
        margin-top: 5px;
        margin-bottom: 20px;
    }
    .message-box.error {
        background-color: #ed8a86; /* Background color for errors */
    }
    </style>
    <style>
    .columns {
    display: flex;
    gap: 20px; /* Space between columns */
    flex-wrap: wrap; /* Allow wrapping for smaller screens */
    }

    .column-one {
        flex: 2; /* Column one takes 2 parts */
        padding: 20px;
        background-color:rgb(244, 239, 238); /* Light blue */
        border: 2px solid  #ad9d92;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .column-two {
        flex: 1; /* Column two takes 1 part */
        padding: 20px;
        background-color: rgb(244, 239, 238); /* Light pink */
        border: 2px solid #ad9d92;
        border-radius: 5px;
        box-sizing: border-box;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .columns {
            flex-direction: column; /* Stack columns vertically */
        }

        .column-one,
        .column-two {
            flex: none; /* Remove flex-grow */
            width: 100%; /* Make columns take full width */
        }
    }
    /* Modal Style */
    .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
            animation: fadeIn 0.5s ease-in-out; /* Animation to fade in */
        }

        .modal-content {
            background-color: #ddc1b9;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
            border-radius: 8px;
            animation: slideUp 0.5s ease-in-out; /* Slide-in animation */
        }

        /* Close Button */
        .close-button {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            border-radius: 5px;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Fade In Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Slide Up Animation */
        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .purchase-button, .btn-print-receipt{
        background-color: #968276;
        color: white; /* White text */
        padding: 15px 30px; /* Spacing inside the button */
        font-size: 16px; /* Font size */
        border: none; /* Remove border */
        border-radius: 8px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        text-align: center; /* Center the text */
        transition: background-color 0.3s ease, transform 0.2s ease; /* Smooth transition */
        margin-bottom: 10px;
        width: 100%
    }

    .purchase-button:hover, .btn-print-receipt:hover {
        background-color:rgb(172, 158, 150); /* Darker green when hovered */
        transform: scale(1.05); /* Slightly enlarge the button */
    }

    .purchase-button:active, .btn-print-receipt {
        background-color: #968276; /* Even darker green when clicked */
        transform: scale(1); /* Reset the button size */
    }
    
    </style>
    <head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <title>Sale Transaction</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
    </head>
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg py-3" style="background-color: #624837">
                <div class="container px-5">
                    <!-- Navbar Button -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" 
                        style="border-color: rgba(215, 211, 195, 1);">
                        <span class="navbar-toggler-icon" style="background-color: rgba(215, 211, 195, 1);"></span>
                    </button>

                    <!-- Logo -->
                    <a class="navbar-brand" href="main.php">
                        <img src="logo1.jpg" alt="Logo" style="height: 50px; width: auto; border-radius: 5px; margin-left: -40px;">
                    </a>
                    <!-- Collapsible Menu -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Group of items: Transaction History, Transaction Report, Inventory, Logout -->
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                                <li class="nav-item nav-spacing">
                                    <a class="nav-link" href="sale_transaction.php" style="color: rgba(215, 211, 195, 1);">
                                        <i class="fa-solid fa-cash-register d-none d-lg-inline" style="font-size: 2rem;"></i>
                                        <span class="d-lg-none">Sales Transaction</span>
                                    </a>
                                </li>

                                <li class="nav-item nav-spacing">
                                    <a class="nav-link" href="transaction_history.php" style="color: rgba(215, 211, 195, 1);">
                                        <i class="fa-solid fa-clipboard d-none d-lg-inline" style="font-size: 2rem;"></i>
                                        <span class="d-lg-none">Transaction History</span>
                                    </a>
                                </li>

                                <li class="nav-item nav-spacing">
                                    <a class="nav-link" href="sale_report.php" style="color: rgba(215, 211, 195, 1);">
                                        <i class="fa-solid fa-chart-line d-none d-lg-inline" style="font-size: 2rem;"></i>
                                        <span class="d-lg-none">Transaction Report</span>
                                    </a>
                                </li>

                                <li class="nav-item nav-spacing">
                                    <a class="nav-link" href="inventory.php" style="color: rgba(215, 211, 195, 1);">
                                        <i class="fa-solid fa-boxes-stacked d-none d-lg-inline" style="font-size: 2rem;"></i>
                                        <span class="d-lg-none">Inventory</span>
                                    </a>
                                </li>
                                
                                <?php if ($username): ?>
                                    <?php 
                                        if ($role == 'employee') {
                                            $redirect_url = 'employee.php';
                                        } elseif ($role == 'admin') {
                                            $redirect_url = 'inventory.php';
                                        }
                                    ?>
                                    <a href="<?php echo $redirect_url; ?>" 
                                    class="navbar-text" 
                                    style="color: rgba(215, 211, 195, 1); 
                                            font-size: 1.5rem; 
                                            margin-right: 5px; 
                                            padding-left: 30px; /* Adds spacing between the line and text */
                                            border-left: 2px solid rgba(215, 211, 195, 1); /* Creates the line */">
                                        <i class="fa-solid fa-circle-user" style="font-size: 1.5rem; margin-right: 5px;"></i> 
                                        <?php echo htmlspecialchars($username); ?>
                                    </a>
                                <?php endif; ?>

                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php" style="color: rgba(215, 211, 195, 1);">
                                        <i class="fas fa-sign-out-alt d-none d-lg-inline" style="font-size: 2rem; margin-left: 20px;"></i>
                                        <span class="d-lg-none">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Container below the navbar // this is the only thing that will change everytime-->
            <div class="container mt-4 styled-container">
            <div class="message-box" id="message-box">
                <p id="message-text"></p>
            </div>
            <h1 style="background-color:rgb(229, 214, 209); padding: 10px; border-radius: 5px;">Sale Transaction</h1>

            <?php
            if (isset($_GET['checkout_success']) && $_GET['checkout_success'] == 'true') {
                // Show success modal if checkout was successful
                echo '<script>window.onload = function() { showModal(); }; </script>';
            }
            ?>

            <!-- Success Modal -->
            <div id="success-modal" class="modal">
                <div class="modal-content" style="display: flex; justify-content: center; align-items: center;">
                    <span class="close-button" onclick="closeModal()">&times;</span>
                    <h2>Checkout Successful!</h2>
                    <p>Your transaction has been completed.</p>
                    <button onclick="redirectToSales()" class="purchase-button">Make another purchase</button>
                    <button class="btn btn-print-receipt" onclick="printReceipt()">
                        Print Receipt
                    </button>
                </div>
            </div>
           <!-- Include the get_receipt.php to fetch the latest sale data -->
            <?php include('get_receipt.php'); ?>

            <!-- Hidden div to hold receipt content -->
            <div id="receipt-content" style="display: none; font-family: Arial, sans-serif; width: 100%; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #000;">
                <!-- Centered Logo with circular shape -->
                <div style="text-align: center;">
                    <img src="logo1.jpg" alt="Sweet Thumb Logo" style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 10px;">
                </div>
                
                <!-- Centered "Sweet Thumb" and "Official Receipt" -->
                <div style="text-align: center; margin-bottom: 20px;">
                    <h1 style="margin: 3; font-size: 24px;">Sweet Thumb</h1>
                    <h5 style="margin: 5px 0; font-size: 20px;">Official Receipt</h5>
                </div>

                <!-- Horizontal line below "Official Receipt" -->
                <hr style="border: none; border-top: 2px dashed #000; width: 100%; margin: 10px auto; background-image: repeating-linear-gradient(to right, transparent, transparent 8px, #000 8px, #000 16px);">

                <!-- Content aligned to the left -->
                <div style="text-align: left;">
                    <p style="margin: 3;"><strong>Sales ID:</strong> <?php echo $sale_id; ?></p>
                    <p style="margin: 3;"><strong>Employee:</strong> <?php echo $username; ?></p>

                    <!-- Horizontal line below "Sale Date" -->
                    <p style="margin: 3;"><strong>Sale Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($created_at)); ?></p>
                    <hr style="border: none; border-top: 2px dashed #000; width: 100%; margin: 10px auto; background-image: repeating-linear-gradient(to right, transparent, transparent 8px, #000 8px, #000 16px);">

                    <!-- Items Table -->
                    <h4>Items:</h4>
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                        <thead>
                            <tr style="border-bottom: 1px solid #000;">
                                <th style="padding: 8px; text-align: left;">Product</th>
                                <th style="padding: 8px; text-align: left;">Quantity</th>
                                <th style="padding: 8px; text-align: left;">Unit Price</th>
                                <th style="padding: 8px; text-align: left;">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($items) {
                                foreach ($items as $item) {
                                    echo "<tr>";
                                    echo "<td style='padding: 8px;'>" . htmlspecialchars($item['product_name']) . "</td>";
                                    echo "<td style='padding: 8px;'>" . htmlspecialchars($item['quantity']) . "</td>";
                                    echo "<td style='padding: 8px;'>₱" . number_format($item['unit_price'], 2) . "</td>";
                                    echo "<td style='padding: 8px;'>₱" . number_format($item['total_price'], 2) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' style='padding: 8px; text-align: center;'>No items available.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <hr style="border: none; border-top: 2px dashed #000; width: 100%; margin: 10px auto; background-image: repeating-linear-gradient(to right, transparent, transparent 8px, #000 8px, #000 16px);">


                    <p style="margin: 3;"><strong>Total Payable:</strong> ₱<?php echo number_format($total_payable, 2); ?></p>
                    <p style="margin: 3;"><strong>Paid Amount:</strong> ₱<?php echo number_format($paid_amount, 2); ?></p>
                    

                    <!-- Horizontal line below "Change" -->
                    <p style="margin: 3;"><strong>Change:</strong> ₱<?php echo number_format($changed, 2); ?></p>
                    <hr style="border: none; border-top: 2px dashed #000; width: 100%; margin: 10px auto; margin-bottom: 30px; background-image: repeating-linear-gradient(to right, transparent, transparent 8px, #000 8px, #000 16px);">

                    <div style="text-align: center; margin-bottom: 10px;">
                        <p style="margin: 0;">Facebook: Sweet Thumb</p>
                        <p style="margin: 0;">Tiktok: sweet.thumb</p>
                        <p style="margin: 0; margin-bottom: 20px;">Phone: 0947-337-1500</p>
                        <p style="margin: 0;">Thank you for purchasing!</p>
                    </div>

                </div>
            </div>


                <div class="columns">
                    <div class="column-one">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Search bar with button -->
                            <div class="search-bar d-flex flex-grow-1 me-3">
                                <input type="text" class="form-control me-2 flex-grow-1" placeholder="Search Product Name or Category" aria-label="Search">
                                <button class="btn btn-search">Search Product</button>
                            </div>
                        </div>
                        <!-- Content for the first column -->
                        <div class="custom-line"></div>
                        <h3>Menu</h3>
                        <div class="custom-line"></div>
                        <?php
                            // Assuming you're connected to the database
                            include('db.php');

                            // Fetch products from product_tbl
                            $query = "SELECT PRODUCT_ID, IMAGE, PRODUCT_NAME, PRICE, UPDATED_AT FROM product_tbl";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                echo '<div class="product-container mt-4">';  // Added a margin-top for spacing
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
                    </div>
                    <div class="column-two">
                        <!-- Content for the second column -->
                        <h3>Cart</h3>
                        <div class="custom-line"></div>

                        <!-- Cart Items -->
                        <div id="cart-items">
                            <?php
                            // Check if the user is logged in (with the username from the session)
                            if (isset($_SESSION['username'])) {
                                $username = $_SESSION['username'];  // Get the username from the session

                                // Fetch cart items for the logged-in user
                                $query = "SELECT p.PRODUCT_NAME, p.IMAGE, p.PRICE, c.QUANTITY, p.PRODUCT_ID
                                        FROM cart_tbl c
                                        JOIN product_tbl p ON c.PRODUCT_ID = p.PRODUCT_ID
                                        WHERE c.username = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("s", $username);  // Bind the username to the query
                                $stmt->execute();
                                $result = $stmt->get_result();  // Get the result set

                                // Initialize total payable price
                                $total_payable = 0;

                                // Check if the cart has items
                                if ($result->num_rows > 0) {
                                    echo '<table class="cart-table" style="width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px;">';
                                    echo '<thead style="background-color: #624837; color: white; text-align: left; font-size: 12px;">';
                                    echo '<tr>';
                                    echo '<th style="padding: 7px; border: 1px solid #ddd;">Qty</th>';
                                    echo '<th style="padding: 7px; border: 1px solid #ddd;">Product Name</th>';
                                    echo '<th style="padding: 7px; border: 1px solid #ddd;">Unit Price</th>';
                                    echo '<th style="padding: 7px; border: 1px solid #ddd;">Total Price</th>';
                                    echo '<th style="padding: 7px; border: 1px solid #ddd;">Action</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';

                                    $row_number = 0; // Counter for alternating row colors

                                    while ($row = $result->fetch_assoc()) {
                                        // Calculate total price for each product
                                        $total_price = $row['PRICE'] * $row['QUANTITY'];
                                        $total_payable += $total_price;  // Add to total payable price

                                        // Alternate row colors based on row number
                                        $row_color = ($row_number % 2 == 0) ? 'style="background-color:rgb(224, 218, 214);"' : 'style="background-color: rgb(244, 239, 238);"';

                                        echo '<tr ' . $row_color . '>';
                                        echo '<td style="padding: 7px; border: 1px solid #ddd; text-align: center;">';
                                        // Spinner for Quantity
                                        echo '<input type="number" class="quantity-spinner" value="' . $row['QUANTITY'] . '" data-product-id="' . $row['PRODUCT_ID'] . '" min="1" style="width: 55px; font-size: 11px; padding: 5px; border: 1px solid #ccc; border-radius: 4px; text-align: center; -moz-appearance: textfield; -webkit-appearance: none;">';
                                        echo '</td>';
                                        echo '<td style="padding: 5px; border: 1px solid #ddd; font-size: 13px;">' . $row['PRODUCT_NAME'] . '</td>';
                                        echo '<td style="padding: 5px; border: 1px solid #ddd; font-size: 13px;">₱' . number_format($row['PRICE'], 2) . '</td>';
                                        echo '<td style="padding: 5px; border: 1px solid #ddd; font-size: 13px;" class="total-price-' . $row['PRODUCT_ID'] . '">₱' . number_format($total_price, 2) . '</td>';
                                        echo '<td style="padding: 5px; border: 1px solid #ddd; text-align: center;">';
                                        // Remove Button for Action
                                        echo '<button class="remove-item" data-product-id="' . $row['PRODUCT_ID'] . '" style="background-color: #ff4d4d; color: white; border: none; padding: 2px 5px; cursor: pointer; border-radius: 3px; font-size: 11px;">Remove</button>';
                                        echo '</td>';
                                        echo '</tr>';

                                        $row_number++; // Increment row number for alternating color
                                    }

                                    echo '</tbody>';
                                    echo '</table>';
                                    
                                     // Display "Check Out" button above the payable price
                                    echo '<button class="btn btn-check-out" type="button" onclick="location.reload();" style="margin-bottom: 10px;">Check Out</button>';
                                    

                                    // Display total payable price
                                    echo '<div id="total-payable" class="total-payable" style="text-align: left; font-size: 16px; font-weight: bold; margin-top: 10px;">';
                                    echo 'Total Payable: ₱' . number_format($total_payable, 2);
                                    echo '</div>';
                                } else {
                                    echo '<p style="font-size: 14px; color: #555; text-align: center;">Your cart is empty.</p>';
                                }
                            }
                            ?>
                        </div>
                        <!-- Check Out and Void Buttons -->
                        <div class="product-actions" style="margin-top: 20px;">
                            <form method="POST" action="checkout.php">
                                <!-- Hidden input for paid amount -->
                                <input type="hidden" id="paid-amount-hidden" name="paid_amount" value="0.00">
                                
                                <!-- Paid Amount Input Field (Only one now) -->
                                <div style="margin-top: 20px; text-align: left; display: flex; align-items: center; justify-content: flex-start;">
                                    <label for="paid-amount" style="font-size: 14px; font-weight: bold; margin-right: 10px;">Paid Amount: ₱</label>
                                    <input type="number" id="paid-amount-input" name="paid_amount_input" style="font-size: 12px; padding: 10px; width: 120px; border: 2px solid #ccc; border-radius: 5px; outline: none; box-sizing: border-box;" oninput="updatePaidAmount(); calculateChange();" placeholder="Enter amount" required>
                                </div>
                                <!-- Paid Amount and Change Calculation -->
                                <div id="change" style="text-align: left; font-size: 16px; font-weight: bold; margin-top: 10px;">
                                    Change: ₱0.00
                                </div>
                                
                                <!-- Submit Button -->
                                <button class="btn btn-check-out" type="submit" style="margin-right: 10px;">Pay</button>
                            </form>
                            <button class="btn btn-void" onclick="voidCart()" style="background-color: #ff4d4d; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">
                                Void
                            </button>
                        </div>
                        </div>
                        <script>
                            // Update the hidden paid amount field when the user enters a value
                        function updatePaidAmount() {
                            var paidAmount = document.getElementById('paid-amount').value || 0;
                            document.getElementById('paid-amount-hidden').value = paidAmount;
                        }
                        </script>
                        <script>
                         // Update the hidden paid amount field when the user enters a value in the visible paid amount input field
                        function updatePaidAmount() {
                            var paidAmount = document.getElementById('paid-amount-input').value || 0;
                            
                            // Update the hidden paid amount input field
                            document.getElementById('paid-amount-hidden').value = paidAmount;
                        }

                        // Function to calculate the change dynamically based on paid amount
                        function calculateChange() {
                            var totalPayable = <?php echo $total_payable; ?>; // Total payable value from PHP
                            
                            // Get the paid amount from the input field
                            var paidAmount = parseFloat(document.getElementById('paid-amount-input').value) || 0;
                            
                            // Calculate the change
                            var change = paidAmount - totalPayable;

                            // Update the change display dynamically
                            document.getElementById('change').textContent = 'Change: ₱' + change.toFixed(2);
                        }
                        // Function to clear the cart (Void)
                        function voidCart() {
                            if (confirm("Are you sure you want to void the cart?")) {
                                // Code to remove all cart items (clear cart) should go here
                                // Example: Call an API or AJAX request to clear cart
                                window.location.reload(); // Reload page to reflect changes
                            }
                        }
                        </script>
                    </div>
                </div>

            </div>
        </div>
    </main>
<script>
    document.querySelector('.btn-search').addEventListener('click', function() {
    let searchQuery = document.querySelector('.search-bar input').value;

    // Send the search query to the server using AJAX
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'search_product_sale.php?query=' + searchQuery, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.querySelector('.product-container').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});
</script>
<script>
    function addToCart(productId) {
    // AJAX request to add the product to the cart
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_to_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send productId to add to cart
    xhr.send("product_id=" + productId);

    // On successful response, reload the page
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Check for success message
            if (xhr.responseText === "Item added to cart!") {
                // Reload the page after adding the item to the cart
                location.reload();
            } else {
                alert('Failed to add to cart');
            }
        }
    };
}
</script>
<script>
   document.querySelectorAll('.quantity-spinner').forEach(function(input) {
    input.addEventListener('change', function() {
        var productId = this.getAttribute('data-product-id');
        var newQuantity = this.value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_quantity.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("product_id=" + productId + "&quantity=" + newQuantity);

        xhr.onload = function() {
    if (xhr.status === 200) {
        try {
            const response = JSON.parse(xhr.responseText);

            console.log(response); // Check what is returned by the PHP script

            // Check if the response contains valid numbers
            if (!isNaN(response.productTotal) && !isNaN(response.totalPayable)) {
                // Update the total price for this product based on the new quantity
                var totalPriceElement = document.querySelector('.total-price-' + productId);
                totalPriceElement.textContent = "₱" + parseFloat(response.productTotal).toFixed(2);

                // Update the total payable dynamically
                document.getElementById('total-payable').textContent = "Total Payable: ₱" + parseFloat(response.totalPayable).toFixed(2);
            } else {
                alert('Invalid response data received');
            }
        } catch (error) {
            alert('Error processing the response');
        }
    } else {
        alert('Failed to update quantity');
    }
};

    });
});
</script>
<script>
document.body.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('remove-item')) {
        const productId = event.target.getAttribute('data-product-id');
        console.log("Remove button clicked for productId:", productId);

        // Send AJAX request to remove product from cart
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'remove_from_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    console.log("Response from remove_from_cart.php:", response);

                    // Check if there is an error in the response
                    if (response.error) {
                        alert(response.error);
                    } else if (response.totalPayable !== undefined) {
                        // On success, remove the row from the table
                        const row = event.target.closest('tr');
                        row.remove();

                        // Update the total payable
                        document.getElementById('total-payable').textContent = "Total Payable: ₱" + parseFloat(response.totalPayable).toFixed(2);
                    }
                } catch (error) {
                    alert('Error processing the response');
                    console.error(error); // Log the error to the console for debugging
                }
            }
        };
        xhr.send('product_id=' + productId);
    }
});
</script>
<script>
    function voidCart() {
    if (confirm('Are you sure you want to void the cart?')) {
        // Example AJAX request to clear the cart or navigate to a void action
        window.location.href = 'clear_cart.php';  // Redirect to a PHP file that handles cart clearing
    }
}
</script>
<script>
        // Show modal
        function showModal() {
            var modal = document.getElementById("success-modal");
            modal.style.display = "block";
        }

        // Close modal
        function closeModal() {
            var modal = document.getElementById("success-modal");
            modal.style.display = "none";
        }

        // Redirect to sales page
        function redirectToSales() {
            window.location.href = "sale_transaction.php"; // Replace with your sales page URL
        }
    </script>
<script>
  function printReceipt() {
    // Get the content of the receipt
    var receiptContent = document.getElementById('receipt-content').innerHTML;

    // Replace any dollar signs with Philippine Peso symbol (₱)
    receiptContent = receiptContent.replace(/\$/g, '₱');

    // Open a new window and write the receipt content
    var printWindow = window.open('', '', 'height=600,width=800');
    
    // Write the head and body content for the new window
    printWindow.document.write('<html><head><title>Receipt</title>');
    printWindow.document.write('<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">');
    printWindow.document.write('</head><body style="font-family: \'Roboto\', sans-serif;">');
    printWindow.document.write(receiptContent);
    printWindow.document.write('</body></html>');
    
    // Print the window content
    printWindow.document.close();
    printWindow.print();
  }
</script>
<script>
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    src="js/scripts.js"
</script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
