<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Login & Register</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('BG2.png');
            background-size: cover;
        }
        .container {
            display: flex;
            width: 800px;
            height: 500px;
            background: #fdf7f4;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .sidebar {
            width: 35%;
            background: #e5b5a4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: white;
        }
        .sidebar button {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            margin-left: 50px;
            margin-right: -20px;
            cursor: pointer;
            padding: 7px 35px;
            margin-bottom: 5px;
            text-align: left;
            padding-left: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        .sidebar button.active {
            background: #fdf7f4;
            color: #e5b5a4;
            border-radius: 10px;
        }
        .sidebar .logo {
            width: 150px;
            height: auto;
            margin-top: -100px;
            margin-bottom: 50px;
            border-radius: 40px;
        }
        .form-area {
            width: 65%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .form-area h3 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .form-area input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-area button {
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            background-color: #e5b5a4;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .form-area button:hover {
            background-color: #d19d8b;
        }
        .icon {
            margin-right: 10px;
            font-size: 18px;
            color: #624837;
        }
        .message-box {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            background-color: #e5b5a4;
            color: white;
            padding: 10px;
            border-radius: 5px;
            width: 50%;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            margin-bottom: 15px;
        }
        
    </style>
</head>
<body>
    <div class="message-box" id="message-box">
        <p id="message-text"></p>
    </div>
    <div class="container">
        <div class="sidebar">
            <img src="logo.jpg" alt="Logo" class="logo">
            <button id="login-tab" class="active" onclick="switchTab('login')">Login</button>
            <button id="register-tab" onclick="switchTab('register')">Register</button>
        </div>

        <div id="login" class="form-area">
            <h3>Login</h3>
            <div style="width: 100%; display: flex; align-items: center;">
                <span class="icon"><i class="fas fa-id-badge"></i></span>
                <input type="text" id="login-username" placeholder="Username" required>
            </div>
            <div style="width: 100%; display: flex; align-items: center;">
                <span class="icon"><i class="fas fa-lock"></i></span>
                <input type="password" id="login-password" placeholder="Password" required>
            </div>
            <button onclick="loginUser()">Login</button>
        </div>

        <div id="register" class="form-area" style="display: none;">
            <h3>Register</h3>
            <div style="width: 100%; display: flex; align-items: center;">
                <span class="icon"><i class="fas fa-user"></i></span>
                <input type="text" id="name" placeholder="Name" required>
            </div>
            <div style="width: 100%; display: flex; align-items: center;">
                <span class="icon"><i class="fas fa-id-badge"></i></span>
                <input type="text" id="username" placeholder="Username" required>
            </div>
            <div style="width: 100%; display: flex; align-items: center;">
                <span class="icon"><i class="fas fa-envelope"></i></span>
                <input type="email" id="email" placeholder="Email" required>
            </div>
            <div style="width: 100%; display: flex; align-items: center;">
                <span class="icon"><i class="fas fa-lock"></i></span>
                <input type="password" id="password" placeholder="Password" required>
            </div>
            <div style="width: 100%; display: flex; align-items: center;">
                <span class="icon"><i class="fas fa-lock"></i></span>
                <input type="password" id="confirm_password" placeholder="Re-type Password" required>
            </div>
            <button id="register-btn" onclick="registerUser()">Register</button>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');
            const loginForm = document.getElementById('login');
            const registerForm = document.getElementById('register');

            if (tab === 'login') {
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
                loginForm.style.display = 'flex';
                registerForm.style.display = 'none';
            } else {
                registerTab.classList.add('active');
                loginTab.classList.remove('active');
                registerForm.style.display = 'flex';
                loginForm.style.display = 'none';
            }
        }

        function registerUser() {
            const name = document.getElementById('name').value;
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (username == '' || email == '' || password == '' || confirmPassword == '') {
                displayMessage('Please fill all the fields', 'error');
                return;
            }

            if (password !== confirmPassword) {
                displayMessage('Passwords do not match', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'register');
            formData.append('name', name);
            formData.append('username', username);
            formData.append('email', email);
            formData.append('password', password);

            fetch('register.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                if (data == 'success') {
                    displayMessage('Registration successful!', 'success');
                    document.getElementById('name').value = '';
                    document.getElementById('username').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('password').value = '';
                    document.getElementById('confirm_password').value = '';
                } else {
                    displayMessage(data, 'error');
                }
            })
            .catch(error => {
                displayMessage('An error occurred. Please try again.', 'error');
            });
        }

        function displayMessage(message, type) {
            const messageBox = document.getElementById('message-box');
            const messageText = document.getElementById('message-text');
            messageText.textContent = message;

            if (type === "success") {
                messageBox.style.backgroundColor = "#968276";
            } else if (type === "error") {
                messageBox.style.backgroundColor = "#ed8a86";
            } else {
                messageBox.style.backgroundColor = "#e5b5a4";
            }

            messageBox.style.display = 'block';
            setTimeout(() => {
                messageBox.style.display = 'none';
            }, 3000);
        }

        function loginUser() {
            const username = document.getElementById('login-username').value;
            const password = document.getElementById('login-password').value;

            if (username == '' || password == '') {
                displayMessage('Please fill all the fields', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'login');
            formData.append('username', username);
            formData.append('password', password);

            fetch('login.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                if (data == 'success') {
                    window.location.href = 'main.php';
                } else {
                    displayMessage(data, 'error');
                }
            })
            .catch(error => {
                displayMessage('An error occurred. Please try again.', 'error');
            });
        }
    </script>
</body>
</html>
