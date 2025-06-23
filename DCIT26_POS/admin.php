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
// Query to get the user's data
$query = $conn->prepare("SELECT id, name, username, email FROM users_tbl WHERE username = ?");
$query->execute([$username]);

// Use get_result() to fetch the results
$result = $query->get_result();
$user = $result->fetch_assoc();

// Fetch only employees from users_tbl
$query = $conn->prepare("SELECT id, name, username, email, role FROM users_tbl WHERE role = 'employee'");
$query->execute();
$result = $query->get_result();

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
        height: AUTO;
        overflow: hidden;
    }
    .custom-line {
        border-top: 4px solid #ddc1b9; /* Set the line thickness and color */
        margin: 20px 0; /* Add spacing above and below the line */
        border-radius: 5px;
    } 
</style>
    <head>
    <title>Admin Profile</title>
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
                                            $redirect_url = 'sale_transaction.php';
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
                <h1 style="background-color:rgb(229, 214, 209); padding: 10px; border-radius: 5px;">Admin Profile</h1>

                <div class="custom-line"></div>

                <div class="mt-1">
                    

                <table class="table mt-4" style="border-collapse: separate; width: 100%;">
                    <thead style="background-color: #624837; color: white;">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="row-<?php echo $user['id']; ?>">
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td contenteditable="true"><?php echo htmlspecialchars($user['name']); ?></td>
                            <td contenteditable="true"><?php echo htmlspecialchars($user['username']); ?></td>
                            <td contenteditable="true"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a href="#" 
                                    class="btn btn-primary" 
                                    style="background-color: #efa39b; color: white; border: 1px solid #efa39b;" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModal" 
                                    onclick="populateModal(<?php echo htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8'); ?>)">
                                    Update
                                </a>
                                <!-- Update Modal -->
                                <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <form id="updateForm">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel">Update User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" 
                                                    class="btn" 
                                                    style="background-color: #efa39b; color: white; border: 1px solid #efa39b;" 
                                                    data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" 
                                                    class="btn" 
                                                    style="background-color: #efa39b; color: white; border: 1px solid #efa39b;">
                                                Save changes
                                            </button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button class="btn btn-danger" style="background-color: #d9534f; color: white; border: 1px solid #d9534f; width: 70%" onclick="deleteLoggedInUser()">
                        Delete My Account
                    </button>
                    <script>
                function deleteLoggedInUser() {
                    if (confirm('Are you sure you want to delete your account?')) {
                        fetch('delete_user.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ id: <?php echo $user['id']; ?> })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Your account has been successfully deleted.');
                                window.location.href = 'logout.php'; // Redirect to logout page or homepage
                            } else {
                                alert('Failed to delete account: ' + (data.error || 'Unknown error.'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while deleting the account.');
                        });
                    }
                }
                </script>
                                    
                <div class="custom-line"></div>

                <h1 style="background-color:rgb(229, 214, 209); padding: 10px; border-radius: 5px;">Employee Management</h1>


                <!-- Search Bar -->
                <div class="mb-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search employees..." onkeyup="filterTable()">
                </div>

                <table class="table mt-4" style="border-collapse: separate; width: 100%; overflow-x: auto;">
                    <thead style="background-color: #624837; color: white;">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTable">
                        <?php while ($user = $result->fetch_assoc()): ?>
                        <tr id="row-<?php echo $user['id']; ?>">
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td>
                                <a href="#" 
                                class="btn btn-primary" 
                                style="background-color: #efa39b; color: white; border: 1px solid #efa39b;" 
                                data-bs-toggle="modal" 
                                data-bs-target="#updateModal" 
                                onclick="populateModal(<?php echo htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8'); ?>)">
                                    Update
                                </a>
                                <a href="#" 
                                class="btn btn-danger" 
                                style="background-color: #d9534f; color: white; border: 1px solid #d9534f;" 
                                onclick="deleteUser(<?php echo $user['id']; ?>)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <!-- Footer-->
        <!-- Bootstrap core JS-->
<script>
function populateModal(user) {
    document.getElementById('name').value = user.name;

    // Add user ID to the form (hidden input)
    if (!document.getElementById('userId')) {
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'id';
        hiddenInput.id = 'userId';
        hiddenInput.value = user.id;
        document.getElementById('updateForm').appendChild(hiddenInput);
    } else {
        document.getElementById('userId').value = user.id;
    }
}

document.getElementById('updateForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('update_user.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User updated successfully!');
            location.reload(); // Refresh page or update UI dynamically
        } else {
            alert('Failed to update user: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the user.');
    });
});
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        fetch('delete_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User deleted successfully!');
                document.getElementById(`row-${userId}`).remove(); // Remove the row from the table
            } else {
                alert('Failed to delete user: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the user.');
        });
    }
}

</script>
<script>
    function filterTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const table = document.getElementById('employeeTable');
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let match = false;
        for (let j = 0; j < cells.length; j++) {
            if (cells[j]) {
                if (cells[j].innerHTML.toLowerCase().indexOf(input) > -1) {
                    match = true;
                    break;
                }
            }
        }
        rows[i].style.display = match ? '' : 'none';
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
