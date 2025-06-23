<?php
session_start();

// Database connection (Update with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pos_dcit26";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $productCategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $productPrice = mysqli_real_escape_string($conn, $_POST['productPrice']);
    
    // Handle the image upload
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['productImage']['name'];
        $imageTmpName = $_FILES['productImage']['tmp_name'];
        $imageSize = $_FILES['productImage']['size'];
        $imageError = $_FILES['productImage']['error'];
        $imageType = $_FILES['productImage']['type'];

        // Generate a unique name for the image
        $imageExtension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($imageExtension, $allowedExtensions)) {
            if ($imageSize < 5000000) { // 5MB max size
                // Generate a unique name for the file
                $newImageName = uniqid('', true) . "." . $imageExtension;
                $targetDir = "uploads/"; // Directory to save uploaded images
                $targetFile = $targetDir . $newImageName;

                // Move the uploaded image to the target directory
                if (move_uploaded_file($imageTmpName, $targetFile)) {
                    // Image upload successful, save details to the database
                    $query = "INSERT INTO product_tbl (PRODUCT_NAME, CATEGORY, PRICE, IMAGE) 
                              VALUES ('$productName', '$productCategory', '$productPrice', '$targetFile')";
                    
                    if ($conn->query($query) === TRUE) {
                        // Set success message in session
                        $_SESSION['message'] = 'Product added successfully!';
                        $_SESSION['message_type'] = 'success'; // Optional: Set the type to 'success'
                        
                        // Redirect to inventory.php after successful product addition
                        header('Location: inventory.php');
                        exit();
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo "Error uploading the image.";
                }
            } else {
                echo "Image size exceeds the limit of 5MB.";
            }
        } else {
            echo "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "No image uploaded or there was an error during the upload.";
    }
}
?>