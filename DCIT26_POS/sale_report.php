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
    .content-box {
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    }

    .first-column {
        background-color: white;  /* Light blue for the first column */
        border: 2px solid #ad9d92;  /* Blue border */
    }

    .second-column {
        background-color: white;  /* Soft peach for the second column */
        border: 2px solid #ad9d92;  /* Coral border */
    }

    .third-column {
        background-color: white;  /* Light green for the third column */
        border: 2px solid #ad9d92;  /* Green border */
    }

    /* First column in the second row */
    .distinct-first-column {
        background-color: white;  /* Soft coral color */
        border: 3px solid #ad9d92;  /* Dark red border */
    }

    /* Second column in the second row */
    .distinct-second-column {
        background-color: white;  /* Soft blue color */
        border: 3px solid #ad9d92;  /* Dark blue border */    }
    p {
        font-size: 16px;
        color: #333;
        line-height: 1.6;
    }
    .hover-grow {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-grow:hover {
        transform: scale(1.03); /* Grows slightly */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Adds a shadow for emphasis */
    }
    canvas {
    width: 100%;
    height: 100%;
}
    </style>
    <head>
    <title>Sales Report</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <h1 style="background-color:rgb(229, 214, 209); padding: 10px; border-radius: 5px;">Sale Reports</h1>
                <div class="custom-line"></div>
                <!-- Two rows below the custom line -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <!-- First column content -->
                        <div class="content-box first-column hover-grow">
                            <h7 style="background-color: #ed8a86; color: white; padding: 10px; border-radius: 5px; display: block; width: 100%; margin-bottom: 10px;">Sales Daily</h7>
                            <canvas id="salesChart" width="800" height="400"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Second column content -->
                        <div class="content-box second-column hover-grow">
                            <h7 style="background-color: #ed8a86; color: white; padding: 10px; border-radius: 5px; display: block; width: 100%; margin-bottom: 10px;">Sales Weekly</h7>
                            <canvas id="weeklySalesChart" width="800" height="400"></canvas> <!-- Line chart placeholder for weekly sales -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Third column content -->
                        <div class="content-box third-column hover-grow">
                            <h7 style="background-color: #ed8a86; color: white; padding: 10px; border-radius: 5px; display: block; width: 100%; margin-bottom: 10px;">Sales Monthly</h7>
                            <canvas id="monthlySalesChart" width="800" height="400"></canvas>
                        </div>
                    </div>
                </div>
                <div class="row mt-10">
                    <div class="col-md-6">
                        <!-- First column content of the second row -->
                        <div class="content-box distinct-first-column hover-grow">
                            <h7 style="background-color: rgba(255, 159, 64, 0.7); color: white; padding: 10px; border-radius: 5px; display: block; width: 100%; margin-bottom: 10px;">Top 5 Selling Products</h7>
                            <canvas id="topProductsChart" width="800" height="400"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Second column content of the second row -->
                        <div class="content-box distinct-second-column hover-grow">
                            <h7 style="background-color: rgba(255, 159, 64, 0.7); color: white; padding: 10px; border-radius: 5px; display: block; width: 100%; margin-bottom: 10px;">Average Payable Amount</h7>
                            <canvas id="overallATVChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Footer-->
        <!-- Bootstrap core JS-->
<script>
// Fetch sales data from the last 7 days
fetch('fetch_sales_data.php?_=' + new Date().getTime())
    .then(response => response.json())
    .then(data => {
        // Process the fetched data
        const dates = data.map(item => item.date); // Assuming 'date' is formatted as YYYY-MM-DD
        const sales = data.map(item => item.total_sales); // Assuming 'total_sales' is the sum of sales per day

        // Reverse the order of dates so the latest date is on the right side
        dates.reverse();
        sales.reverse();

        // Create the chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates, // X-axis labels (dates)
                datasets: [{
                    label: 'Total Sales',
                    data: sales, // Y-axis data (sales)
                    fill: false,
                    borderColor: '#ed8a86',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        },
                        ticks: {
                            font: {
                                size: 9 // Adjust the size of the date labels here
                            }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Sales'
                        }
                    }
                }
            }
        });
    })
    .catch(error => {
        console.error('Error fetching sales data:', error);
    });
</script>
<script>
    // Fetch weekly sales data for the last 5 weeks
    fetch('fetch_weekly_sales_data.php')
        .then(response => response.json())
        .then(data => {
            // Process the fetched data
            const weeks = data.map(item => item.week); // X-axis labels (weeks)
            const sales = data.map(item => item.total_sales); // Y-axis data (sales)

            // Create the weekly sales chart
            const ctx = document.getElementById('weeklySalesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: weeks, // X-axis labels (weeks)
                    datasets: [{
                        label: 'Total Sales (Weekly)',
                        data: sales, // Y-axis data (sales)
                        fill: false,
                        borderColor: '#ed8a86', // Different color for this chart
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Weeks'
                            },
                            ticks: {
                                font: {
                                    size: 10 // Adjust the font size if necessary
                                }
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sales'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching weekly sales data:', error);
        });
</script>
<script>
    // Fetch monthly sales data
    fetch('fetch_monthly_sales_data.php')
        .then(response => response.json())
        .then(data => {
            // Extract months and sales
            const months = Object.keys(data); // X-axis labels (months)
            const sales = Object.values(data); // Y-axis data (sales)

            // Create the chart
            const ctx = document.getElementById('monthlySalesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Total Sales (Monthly)',
                        data: sales,
                        fill: false,
                        borderColor: '#ed8a86',
                        tension: 0.1,
                        backgroundColor: 'rgba(255, 127, 80, 0.2)',
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Months'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Sales'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching monthly sales data:', error);
        });
</script>
<script>
    // Fetch data from PHP script
    fetch('top_selling_products.php') // Replace with the correct path to your PHP file
        .then(response => response.json())
        .then(data => {
            // Prepare data for the chart
            const productNames = data.map(item => item.product);
            const quantities = data.map(item => item.quantity);
            const revenues = data.map(item => item.revenue);

            // Render the bar chart
            const ctx = document.getElementById('topProductsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: productNames,
                    datasets: [
                        {
                            label: 'Quantity Sold',
                            data: quantities,
                            backgroundColor: '#c1867e',
                            borderColor: '#c1867e',
                            borderWidth: 1
                        },
                        {
                            label: 'Revenue (₱)',
                            data: revenues,
                            backgroundColor: 'rgba(255, 159, 64, 0.6)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.raw;
                                    if (label === 'Revenue (₱)') {
                                        return `${label}: ₱${value.toLocaleString()}`;
                                    }
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
</script>
<script>
    // Fetch data from PHP script
    fetch('overall_atv.php') // Replace with the correct path to your PHP file
        .then(response => response.json())
        .then(data => {
            const overallATV = data.overall_atv;

            // Render the bar chart
            const ctx = document.getElementById('overallATVChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // You can switch to 'gauge' or another chart type if desired
                data: {
                    labels: ['Overall ATV'],
                    datasets: [
                        {
                            label: 'Average Transaction Value (₱)',
                            data: [overallATV],
                            backgroundColor: 'rgba(255, 159, 64, 0.6)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true, // Fixed dimensions
                    maintainAspectRatio: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Metric'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: '₱ (Average Transaction Value)'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `₱${context.raw.toLocaleString()}`;
                                }
                            }
                        }
                    }
                },
                
            });
        })
        .catch(error => console.error('Error fetching data:', error));
</script>
<script>
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    src="js/scripts.js"
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
