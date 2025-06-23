<?php
session_start(); // Start the session
include 'db.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to sweetthumb.php if the user is not logged in
    header('Location: sweetthumb.php');
    exit(); // Stop further script execution
}

// Fetch username
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
        height: 590px;
        overflow: hidden;
    }
    .custom-line {
        border-top: 4px solid #ddc1b9; /* Set the line thickness and color */
        margin: 20px 0; /* Add spacing above and below the line */
        border-radius: 5px;
    } 
</style>
    <head>
    <title>Home</title>
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
                <h1 style="background-color:rgb(229, 214, 209); padding: 10px; border-radius: 5px;">Home</h1>
                <div class="custom-line"></div>
                <div style="text-align: center; margin-top: 50px;">
                    <img src="logo1.jpg" alt="Sweet Thumb Logo" style="max-width: 180px; height: auto; border-radius: 20px;">
                </div>
                <!-- Welcome message below the custom line -->
                <p style="font-size: 30px; text-align: center; font-weight: bold; margin-top: 5px;">Welcome to Sweet Thumb</p>
                <!-- Bible Verse displayed below the Sweet Thumb message -->
                <div id="bible-verse-container" style="text-align: center; margin-top: 50px;">
                    <p id="bible-verse" style="font-size: 20px; font-weight: bold;"></p>
                    <p id="bible-reference" style="font-size: 16px; color: gray;"></p>
                </div>
            </div>
        </main>
        <!-- Footer-->
        <!-- Bootstrap core JS-->

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Function to fetch a Bible verse by reference
    function fetchBibleVerse() {
        // URL for fetching a random Bible verse (or you can customize to get different verses)
        const randomVerse = getRandomVerseReference();  // Function to get a random verse reference
        const url = `https://bible-api.com/${randomVerse}`;

        // Fetch Bible verse from the API
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Check if the verse is successfully returned
                if (data && data.text && data.reference) {
                    const verse = data.text;
                    const reference = data.reference;

                    // Display the verse and reference inside the container
                    document.getElementById('bible-verse').textContent = verse;
                    document.getElementById('bible-reference').textContent = reference;
                } else {
                    document.getElementById('bible-verse').textContent = 'No verse available.';
                    document.getElementById('bible-reference').textContent = '';
                }
            })
            .catch(error => {
                console.error('Error fetching Bible verse:', error);
                document.getElementById('bible-verse').textContent = 'Error loading verse.';
                document.getElementById('bible-reference').textContent = '';
            });
    }

    // Function to generate a random Bible verse reference (you can modify this logic)
    function getRandomVerseReference() {
    // Here are some example verses, you can expand this array as needed
    const verses = [
        'John%203:16',       // John 3:16
        'Genesis%201:1',     // Genesis 1:1
        'Matthew%205:14',    // Matthew 5:14
        'Philippians%204:13', // Philippians 4:13
        'Psalm%201:1',       // Psalm 1:1
        'Romans%2012:2',     // Romans 12:2
        'Psalm%20107:9',     // Psalms 107:9 (NIV)
        'Isaiah%2053:5',     // Isaiah 53:5
        'Proverbs%203:5',    // Proverbs 3:5
        'Jeremiah%2911:29',  // Jeremiah 29:11
        'Romans%2812:1',     // Romans 12:1
        'Ephesians%202:8',   // Ephesians 2:8
        'Psalm%2019:14',     // Psalms 19:14
        'Colossians%203:23', // Colossians 3:23
        'Hebrews%202:1'      // Hebrews 2:1
    ];

    // Pick a random verse from the list
    const randomIndex = Math.floor(Math.random() * verses.length);
    return verses[randomIndex];
}

    // Fetch a Bible verse immediately when the page loads
    fetchBibleVerse();

    // Set up a timer to change the Bible verse every 10 seconds (10000ms)
    setInterval(fetchBibleVerse, 20000); // Change every 10 seconds (you can adjust this time)
});
</script>

<script>
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    src="js/scripts.js"
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
