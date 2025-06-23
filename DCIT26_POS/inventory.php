<?php
session_start(); // Start the session
include 'db.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to sweetthumb.php if the user is not logged in
    header('Location: sweetthumb.php');
    exit(); // Stop further script execution
}

// Optionally, fetch the username for display or use within the page
$username = $_SESSION['username'];
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

    /* Style for the buttons */
    
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

    /* Style for the Add button */
    .btn-add {
        background-color: #efa39b;
        border-color: #efa39b;
        color: white;
        padding: 10px 27px; /* Adjust the padding to make the button larger or smaller */
        font-size: 12px; /* Adjust the font size */
        border-radius: 5px; /* Optional: for rounded corners */
    }

    .btn-add:hover {
        background-color: #F9B4A8; /* Lighter shade of green */
        border-color: #F9B4A8;
        color: white;
    }
    /* Modal Styles */
    /* Modal container */
    .modal {
        display: none; 
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%;
        overflow: auto; 
        background-color: rgba(0, 0, 0, 0.5);
    }
    /* Modal content box */
    .modal-content {
        background-color: #FAD4CF; /* Match the background from the image */
        margin: auto; /* Centered horizontally and vertically */
        padding: 20px;
        border-radius: 20px; /* Rounded corners */
        width: 500px; /* Fixed width */
        max-height: 90vh; /* Prevent it from exceeding viewport height */
        text-align: center; /* Center-align content */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add subtle shadow */
        overflow-y: auto; /* Add scroll only if necessary */
        position: relative;
        top: 50%;
        transform: translateY(-50%); /* Vertically center */
    }

    /* File input wrapper */
    .file-input-wrapper {
        position: relative;
        width: 120px; /* Adjusted size */
        height: 120px;
        margin: 0 auto; /* Center the input */
        border: 2px dashed #FCEAE5; /* Dashed border with lighter color */
        border-radius: 16px; /* Rounded corners */
        background-color: #FFF5F3; /* Light background */
        text-align: center;
        cursor: pointer;
        overflow: hidden; /* Prevent overflow */
        margin-bottom: 40px;
    }

    /* Hide the actual file input */
    .file-input-wrapper input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0; /* Hide the input */
        cursor: pointer;
    }

    /* Placeholder text */
    .file-input-wrapper .placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-size: 12px;
        color: #AA7371; /* Muted text color */
        font-family: Arial, sans-serif;
        pointer-events: none;
    }

    /* Image preview */
    .file-input-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: none; /* Initially hidden */
        border-radius: 16px; /* Match the border radius */
    }
    /* Input fields */
    .modal-content input[type="text"], input[type="number"] {
        width: calc(100% - 0px);
        padding: 10px;
        margin: -5px 0px; /* Reduced margin to make fields closer */
        border: none;
        border-radius: 5px;
        background-color: #FFF5F3; /* Match the light input background */
        font-size: 16px;
        font-family: Arial, sans-serif;
        text-align: center;
        color: #AA7371;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Buttons container */
    .modal-content .button-container {
        display: flex;
        justify-content: space-evenly;
        margin-top: 20px;
    }

    /* Buttons */
    .modal-content button {
        width: 100px;
        padding: 10px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-family: Arial, sans-serif;
        cursor: pointer;
        margin-left:10px
    }

    .modal-content button.add {
        background-color: #efa39b; /* Match modal background */
        color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .modal-content button.add:hover {
        background-color: #F9B4A8; /* Slightly darker on hover */
    }

    .modal-content button.cancel {
        background-color: #efa39b; /* Light cancel button background */
        color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .modal-content button.cancel:hover {
        background-color: #F9B4A8; /* Slightly darker on hover */
    }
    input[type="text"], input[type="number"] {
        width: 100%; /* Make input fields the same width */
        padding: 10px; /* Add padding for uniformity */
        border: 1px solid #ccc; /* Standard border */
        border-radius: 4px; /* Smooth corners */
        font-size: 16px; /* Standardize font size */
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
        appearance: textfield; /* Hide spinner for Firefox */
    }
    h3 {
        margin-bottom: 20px;
    }
    .custom-line {
        border-top: 4px solid #ddc1b9; /* Set the line thickness and color */
        margin: 20px 0; /* Add spacing above and below the line */
        border-radius: 5px;
    }

    /*fetch data */
    .product-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Reduced gap for both horizontal and vertical spacing */
    justify-content: flex-start; /* Align items at the start of the container */
    align-items: flex-start; /* Align items at the top of the container */
}

.product-item {
    width: 290px;  /* Set a specific width for the product item */
    height: 400px; /* Set a specific height for the product item */
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
}

.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.product-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    border-radius: 16px;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-name {
    font-size: 1.2em;
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

.update-btn, .delete-btn {
    padding: 8px 12px;
    margin: 5px;
    border: none;
    background-color: #c1867e;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.update-btn:hover, .delete-btn:hover {
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
    <head>
    <title>Product Inventory</title>
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
                                            $redirect_url = 'admin.php';
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
            <h1 style="background-color:rgb(229, 214, 209); padding: 10px; border-radius: 5px;">Product Inventory</h1>

                <div class="d-flex justify-content-between align-items-center">
                    <!-- Search bar with button -->
                    <div class="search-bar d-flex flex-grow-1 me-3">
                        <input type="text" class="form-control me-2 flex-grow-1" placeholder="Search Product Name or Category" aria-label="Search">
                        <button class="btn btn-search">Search Product</button>
                    </div>

                    <!-- Add button -->
                    <button class="btn btn-add" id="addProductButton">Add New Product</button>

                    <!-- Popup Modal -->
                    <div id="productModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h3>Add New Product</h3>
                            <form action="add_product.php" method="POST" enctype="multipart/form-data">
                                <label for="addProductImage">Product Image:</label>
                                <div class="file-input-wrapper">
                                    <input type="file" id="addProductImage" name="productImage" accept="image/*" required>
                                    <span class="placeholder">Click to Upload</span>
                                    <img id="addPreviewImage" src="" alt="Image Preview" style="display: none;">
                                </div>

                                <input type="text" id="addProductName" name="productName" placeholder="Enter product name" required><br><br>
                                <input type="text" id="addProductCategory" name="productCategory" placeholder="Enter product category" required><br><br>
                                <input type="number" step="0.01" id="addProductPrice" name="productPrice" placeholder="Enter product price" required><br><br>

                                <button type="submit" class="add">Save</button>
                                <button id="addCancelButton" class="cancel" onclick="closeAddForm()">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>

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
                        echo '<div class="product-id">Product ID: ' . $row['PRODUCT_ID'] . '</div>';
                        echo '<div class="product-name">' . $row['PRODUCT_NAME'] . '</div>';
                        echo '<div class="product-price">₱' . number_format($row['PRICE'], 2) . '</div>';
                        echo '<div class="product-updated">Updated on: ' . date('F j, Y', strtotime($row['UPDATED_AT'])) . '</div>';
                        
                        // Update and Delete buttons
                        echo '<div class="product-actions">
                                <button class="update-btn" onclick="openUpdateForm(' . $row['PRODUCT_ID'] . ')">Update</button>
                                <button class="delete-btn" onclick="deleteProduct(' . $row['PRODUCT_ID'] . ')">Delete</button>
                            </div>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo 'No products found.';
                }
                ?>
            </div>
            <!-- Popup Modal update -->
            <div id="updateModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeUpdateForm()">&times;</span>
                <h3>Update Product</h3>
                <form action="update_product.php" method="POST" enctype="multipart/form-data" onsubmit="return handleUpdate(event)">
                    <input type="hidden" id="updateProductId" name="productId"> <!-- Hidden field for product ID -->
                    <label for="updateProductImage">Product Image:</label>
                    <div class="file-input-wrapper">
                        <input type="file" id="updateProductImage" name="productImage" accept="image/*">
                        <span class="placeholder">Click to Upload</span>
                        <img id="updatePreviewImage" src="" alt="Image Preview" style="display: none;">
                    </div>

                    <input type="text" id="updateProductName" name="productName" placeholder="Enter product name" required><br><br>
                    <input type="text" id="updateProductCategory" name="productCategory" placeholder="Enter product category" required><br><br>
                    <input type="number" step="0.01" id="updateProductPrice" name="productPrice" placeholder="Enter product price" required><br><br>

                    <button type="submit" class="add">Save</button>
                    <button type="button" id="updateCancelButton" class="cancel" onclick="closeUpdateForm()">Cancel</button>
                </form>
            </div>
        </div>

        </main>
        <!-- Footer-->
        <!-- Bootstrap core JS-->

<script>
    // Get modal elements
    var modal = document.getElementById('productModal');
    var btn = document.getElementById('addProductButton');
    var closeBtn = document.getElementsByClassName('close')[0];
    var cancelBtn = document.getElementById('cancelButton');

    // Show the modal when the "Add Product" button is clicked
    btn.onclick = function() {
        modal.style.display = 'block';
    }

    function closeAddForm() {
        document.getElementById('productModal').style.display = 'none';
    }

    // Close the modal when the close button (×) is clicked
    closeBtn.onclick = function() {
        modal.style.display = 'none';
    }

    // Close the modal when clicking outside the modal content
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
<script>
    document.getElementById('addProductImage').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const previewImage = document.getElementById('addPreviewImage');
    const placeholder = document.querySelector('.file-input-wrapper .placeholder');

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            // Display the image preview inside the square
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
            placeholder.style.display = 'none'; // Hide placeholder text
        };

        reader.readAsDataURL(file);
    } else {
        // Reset preview and show placeholder if no file is selected
        previewImage.style.display = 'none';
        previewImage.src = '';
        placeholder.style.display = 'flex';
    }
});
</script>
<script>
function openUpdateForm(productId) {
    // Fetch product details via AJAX
    fetch(`get_product.php?product_id=${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                // Populate fields in the Update Modal
                document.getElementById('updateProductId').value = data.data.PRODUCT_ID;
                document.getElementById('updateProductName').value = data.data.PRODUCT_NAME;
                document.getElementById('updateProductCategory').value = data.data.CATEGORY;
                document.getElementById('updateProductPrice').value = data.data.PRICE;

                // Show the image preview
                const previewImage = document.getElementById('updatePreviewImage');
                previewImage.src = data.data.IMAGE; // Assuming the IMAGE column contains the image URL
                previewImage.style.display = 'block';

                // Show the Update Modal
                document.getElementById('updateModal').style.display = 'block';
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error fetching product details:', error));
}

function closeUpdateForm() {
    document.getElementById('updateModal').style.display = 'none';
}

function handleUpdate(event) {
    event.preventDefault(); // Prevent default form submission

    const form = event.target;
    const formData = new FormData(form);

    // First, close the form immediately
    closeUpdateForm();

    // Then, send the form data to the server
    fetch('update_product.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const messageBox = document.getElementById('message-box');
            const messageText = document.getElementById('message-text');

            if (data.status === 200) {
                // Display success message
                messageBox.style.backgroundColor = '#968276'; //  for success
                messageText.innerText = data.message;
                messageBox.style.display = 'block';

                // Hide the message box after 3 seconds
                setTimeout(() => {
                    messageBox.style.display = 'none'; // Hide message after 3 seconds
                    location.reload(); // Reload the page to see updated data
                }, 1500); // 3 seconds delay
            } else {
                // Display error message
                messageBox.style.backgroundColor = '#ed8a86'; // Red for error
                messageText.innerText = data.message;
                messageBox.style.display = 'block';

                // Hide the error message box after 3 seconds
                setTimeout(() => {
                    messageBox.style.display = 'none'; // Hide message after 3 seconds
                }, 1500);
            }
        })
        .catch(error => {
            console.error('Error updating product:', error);
            alert('An error occurred while updating the product');
        });
}

</script>
<script>
    window.onload = function() {
    const message = "<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?>";
    const messageType = "<?php echo isset($_SESSION['message_type']) ? $_SESSION['message_type'] : ''; ?>";

    if (message) {
        const messageBox = document.getElementById('message-box');
        const messageText = document.getElementById('message-text');
        
        messageText.textContent = message;
        messageBox.style.display = 'block';
        
        // Apply different styles based on the message type (success or error)
        if (messageType === 'success') {
            messageBox.style.backgroundColor = '#968276'; //  for success
        } else {
            messageBox.style.backgroundColor = '#ed8a86'; //  for error
        }

        // Hide the message box after 5 seconds
        setTimeout(() => {
            messageBox.style.display = 'none';
        }, 1500);

        // Clear session message after displaying it
        <?php
            // Clear session variables after displaying the message
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        ?>
    }
}
</script>
<script>
   function deleteProduct(productId) {
    if (confirm("Are you sure you want to delete this product?")) {
        // Send the delete request to the server using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_product.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText); // Parse the JSON response

                // Get the message box and message text elements
                const messageBox = document.getElementById('message-box');
                const messageText = document.getElementById('message-text');

                // Set the message text and style based on the response
                messageText.textContent = response.message;

                if (response.status === 'success') {
                    messageBox.style.backgroundColor = ' #968276'; // Success color
                } else {
                    messageBox.style.backgroundColor = '#ed8a86'; // Error color
                }

                // Display the message box
                messageBox.style.display = 'block';

                // Optionally, hide the message box after a few seconds
                setTimeout(function () {
                    messageBox.style.display = 'none';
                    location.reload(); // Reload the page to reflect the changes
                }, 1500); // 3 seconds
            }
        };
        xhr.send("product_id=" + productId); // Send the product ID to the server
    }
}
</script>
<script>
    document.querySelector('.btn-search').addEventListener('click', function() {
    let searchQuery = document.querySelector('.search-bar input').value;

    // Send the search query to the server using AJAX
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'search_product.php?query=' + searchQuery, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.querySelector('.product-container').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});
</script>
<script>
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    src="js/scripts.js"
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
