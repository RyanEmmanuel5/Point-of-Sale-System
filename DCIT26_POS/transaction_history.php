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
    .custom-line {
        border-top: 4px solid #ddc1b9; /* Set the line thickness and color */
        margin: 20px 0; /* Add spacing above and below the line */
        border-radius: 5px;
    } 
    /* 2nd row */
    .two-containers {
        display: flex;
        gap: 20px; /* Add spacing between containers */
        margin-top: 20px;
        flex-wrap: wrap; /* Allow wrapping of children */
    }
    .two-containers .col-md-6 {
        flex: 1; /* Ensure equal width for both containers */
        padding: 15px;
        background-color: white;
        border: 2px solid #ad9d92;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    .two-containers .col-md-6 h4 {
        margin-top: 0;
        color: #333;
    }
    .two-containers .col-md-6 p {
        color: #555;

    }

    /* Responsive behavior */
    @media (max-width: 768px) {
        .two-containers {
            flex-direction: column; /* Stack vertically on small screens */
        }
        .two-containers .col-md-6 {
            margin-bottom: 20px; /* Add spacing between stacked containers */
        }
        .two-containers .col-md-6:last-child {
            margin-bottom: 0; /* Remove spacing after the last container */
        }
    /* third row */
    }
    .single-container {
        padding: 20px;
        background-color: #f5f5f5; /* Light gray background */
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    .single-container h4 {
        margin-top: 0;
        color: #333;
    }
    .single-container p {
        color: #555;
    }
    /* button styling */
    .button-group {
        display: flex;
        gap: 10px; /* Adds spacing between the buttons */
        justify-content: flex-start; /* Aligns the buttons to the left; use `center` for center alignment */
        align-items: center; /* Vertically centers the buttons */
        width: 100%;
    }

    .button-group button, #search-date-range-btn, #search-button {
        padding: 10px 15px; /* Optional: Add padding for better button appearance */
        font-size: 14px;
        border: none;
        border-radius: 4px; /* Optional: Adds rounded corners */
        cursor: pointer;
        width: 100%;

    }

    #view-all-btn, #search-button, #search-date-range-btn{
        background-color: #968276;
        color: white;
    
    }
    #view-all-btn:hover, #search-button:HOVER, #search-date-range-btn:hover{
        background-color:rgb(175, 162, 154); /* Darker blue on hover */
        color: white;
    }

    .btn-refresh {
        background-color: #968276;
        color: white;
    }
    .btn-refresh:hover{
        background-color:rgb(175, 162, 154); /* Darker blue on hover */
        color: white;
    }
    /* table style */
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    table th {
        background-color: #624837;
        color: white;
        font-weight: bold;
    }

    table tbody tr:nth-child(even) {
        background-color: rgb(224,218,214); /* Light gray for even rows */
    }

    table tbody tr:nth-child(odd) {
        background-color: rgb(244,239,238); /* White for odd rows */
    }
    .pagination {
        text-align: center;
        margin: 10px 0;
    }

    .pagination button {
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #ddd;
        background-color: #f2f2f2;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination button:hover {
        background-color: #ddd;
    }

    .pagination button.active {
        background-color: rgb(224,218,214);
        color: black;
        border: 1px solid #333;
        font-weight: bold;
    }
    </style>
    <style>
    .search-wrapper {
        margin-top: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-label {
        font-weight: bold;
    }

    .form-control {
        padding: 5px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-primary {
        padding: 5px 10px;
        font-size: 14px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
    .date-range-inputs {
    display: flex;
    align-items: center;
    gap: 10px;
    }

    .date-range-inputs label {
        margin-right: 5px;
    }

    input[type="date"] {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 150px; /* Adjust width as needed */
        box-sizing: border-box;
    }
    label {
    font-size: 12px; /* Reduced font size */
    margin-right: 5px;  /* Adjust spacing if needed */
}
.content-wrapper {
    display: flex;
    flex-direction: column;
    width: 100%;  /* Ensure it takes full width */
    overflow-x: auto;  /* Prevent horizontal overflow */
}

#transaction-table,
#transaction-data-table {
    width: 100%;  /* Ensure full width */
    box-sizing: border-box;
    padding: 10px;
}

@media (max-width: 768px) {
    #transaction-table,
    #transaction-data-table {
        padding: 5px;  /* Reduce padding for smaller screens */
    }
}

</style>
    <head>
    <title>Transaction History</title>
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
                <h1 style="background-color:rgb(229, 214, 209); padding: 10px; border-radius: 5px;">Transaction History</h1>
                <div class="custom-line"></div>
        
                <div class="row two-containers">
                    <div class="col-md-6 container-left">
                        <div class="content-wrapper">
                            <h7 style="background-color: #ed8a86; color: white; padding: 10px; border-radius: 5px; display: block; width: 100%; margin-bottom: 10px;">Search with Specific Date</h7>
                            <div class="search-wrapper">
                                <input type="date" id="date-search" class="form-control" style="width: 100%;" />
                                <button id="search-button" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 container-right">
                        <div class="content-wrapper">
                            <h7 style="background-color: #ed8a86; color: white; padding: 10px; border-radius: 5px; display: block; width: 100%; margin-bottom: 30px;">Search with Date Range</h7>
                                    
                            <!-- Date From and To Input Fields -->
                            <div class="date-range-inputs">
                                <label for="date-from">From Date:</label>
                                <input type="date" id="date-from" name="date-from" required style="width: 135px; font-size: 14px;">
                                
                                <label for="date-to">To Date:</label>
                                <input type="date" id="date-to" name="date-to" required style="width: 135px; font-size: 14px;">
                                
                                <!-- Search Button -->
                                <button id="search-date-range-btn">Search</button>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6 container-left">
                        <div class="content-wrapper">
                            <h7 style="background-color: #ed8a86; color: white; padding: 10px; border-radius: 5px; display: block; width: 100%; margin-bottom: 10px;">Other Search Options</h7>
                            <div class="search-wrapper">
                                <div class="button-group">
                                    <button id="view-all-btn">View All</button>
                                    <button class="btn btn-refresh" onclick="location.reload();">Reset Searches</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-container mt-4">
                    <div class="content-wrapper">
                        <div id="transaction-table" style="display: none;"></div>
                        <div id="transaction-data-table"></div>
                        <div id="transaction-date-range"></div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Footer-->
        <!-- Bootstrap core JS-->
        <script>
// Declare shared variables once for both functionalities
let currentPage = 1;
const rowsPerPage = 10;
let globalData = [];

document.addEventListener('DOMContentLoaded', function() {
    const viewAllButton = document.getElementById('view-all-btn');
    const transactionTable = document.getElementById('transaction-table');
    const transactionDataTable = document.getElementById('transaction-data-table');
    const dateSearchButton = document.getElementById('search-button');
    const dateSearchInput = document.getElementById('date-search');
    const searchDateRangeButton = document.getElementById('search-date-range-btn');
    const dateFromInput = document.getElementById('date-from');
    const dateToInput = document.getElementById('date-to');
    const transactionDateRange = document.getElementById('transaction-date-range');

    // Hide both tables initially
    transactionTable.style.display = 'none';
    transactionDataTable.style.display = 'none';

    // Event listener for the "View All" button
    viewAllButton.addEventListener('click', function() {
        if (transactionTable.style.display === 'none') {
            transactionTable.style.display = 'block';
            fetchAllData(); // Fetch all data when View All is clicked
        } else {
            transactionTable.style.display = 'none';
        }
    });

    // Event listener for the "Search" button (date filter)
    dateSearchButton.addEventListener('click', function() {
        const selectedDate = dateSearchInput.value;
        if (selectedDate) {
            transactionDataTable.style.display = 'block'; // Show the data table
            fetchDataByDate(selectedDate); // Fetch data for the selected date
        } else {
            alert("Please select a date.");
        }
    });

    // Event listener for the "Search" button (date range filter)
    searchDateRangeButton.addEventListener('click', function() {
        const fromDate = dateFromInput.value;
        const toDate = dateToInput.value;

        // Validate the date range inputs
        if (fromDate && toDate) {
            transactionDateRange.style.display = 'block'; // Show the data table
            fetchDataByDateRange(fromDate, toDate); // Fetch data for the selected date range
        } else {
            alert("Please select both From Date and To Date.");
        }
    });
});

// Fetch all data for the "View All" functionality
function fetchAllData() {
    fetch('fetch_all_history.php') // Your backend endpoint for fetching all sales
        .then(response => response.json())
        .then(data => {
            globalData = data;
            renderTable(globalData.slice(0, rowsPerPage), 'transaction-table'); // Render for main table
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Fetch data filtered by the selected date
function fetchDataByDate(date) {
    fetch(`fetch_sales_by_date.php?date=${date}`) // Your backend endpoint for date-based fetching
        .then(response => response.json())
        .then(data => {
            globalData = data;
            renderTable(globalData.slice(0, rowsPerPage), 'transaction-data-table'); // Render for date filter table
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Fetch data filtered by date range
function fetchDataByDateRange(fromDate, toDate) {
    fetch(`fetch_sales_by_date_range.php?from=${fromDate}&to=${toDate}`) // Your backend endpoint for date range-based fetching
        .then(response => response.json())
        .then(data => {
            globalData = data;
            renderTable(globalData.slice(0, rowsPerPage), 'transaction-date-range'); // Render for date range filter table
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Render table and handle pagination
function renderTable(pageData, tableId) {
    if (pageData.length === 0) {
        document.getElementById(tableId).innerHTML = `<p>No data available.</p>`;
        return;
    }

    const allColumns = Object.keys(pageData[0]); // Get all columns from the data
    let tableHTML = `
        <table>
            <thead>
                <tr>
                    ${allColumns.map(column => `<th>${column}</th>`).join('')}
                </tr>
            </thead>
            <tbody>
    `;

    // Add rows to the table
    pageData.forEach(sale => {
        tableHTML += `
            <tr>
                ${allColumns.map(column => `<td>${sale[column] || '-'}</td>`).join('')}
            </tr>
        `;
    });

    tableHTML += `
        </tbody>
    </table>
    <div class="pagination">
        ${generatePagination(globalData.length, currentPage, rowsPerPage)}
    </div>
    `;

    document.getElementById(tableId).innerHTML = tableHTML;
}

// Pagination function to generate buttons
function generatePagination(totalItems, currentPage, itemsPerPage) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    let paginationHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const activeClass = i === currentPage ? 'active' : '';
        paginationHTML += `<button class="${activeClass}" onclick="changePage(${i})">${i}</button>`;
    }

    return paginationHTML;
}

// Change page function for pagination
function changePage(page) {
    currentPage = page;
    const offset = (currentPage - 1) * rowsPerPage;
    const pageData = globalData.slice(offset, offset + rowsPerPage);
    
    // Determine which table to update based on visibility
    if (document.getElementById('transaction-table').style.display === 'block') {
        renderTable(pageData, 'transaction-table');
    } else if (document.getElementById('transaction-data-table').style.display === 'block') {
        renderTable(pageData, 'transaction-data-table');
    } else if (document.getElementById('transaction-date-range').style.display === 'block') {
        renderTable(pageData, 'transaction-date-range');
    }
}
</script>



<script>
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    src="js/scripts.js"
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
