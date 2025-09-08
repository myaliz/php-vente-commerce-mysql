<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #e0f7fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .admin-icons-top {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
            opacity: 0.7;
            font-size: 24px;
            color: #78909c;
            flex-wrap: wrap; /* Permet aux icônes de passer à la ligne si l'espace est insuffisant */
        }

        .login-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            width: 100%;
            max-width: 800px;
        }

        .login-image-section {
            background: url('../../public/images/login-background.jpg') center/cover no-repeat; /* Ajuster le chemin si nécessaire */
            width: 45%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .login-image-content {
            text-align: center;
            padding: 30px;
        }

        .login-image-content h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .login-form-section {
            padding: 40px;
            width: 55%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            color: #37474f;
            margin-bottom: 30px;
            font-size: 2.2em;
            font-weight: 500;
            text-align: center;
        }

       .input-group {
            margin-bottom: 25px;
            text-align: left;
            margin-right: 35px; /* Ajoute une marge à gauche */
        }
        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #546e7a;
            font-size: 14px;
            font-weight: 500;
        }

        .input-field-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0bec5;
            font-size: 16px;
        }

        .input-group input[type="text"],
        .input-group input[type="password"] {
            width: 100%;
            padding: 12px 15px 12px 35px;
            border: 1px solid #cfd8dc;
            border-radius: 8px;
            font-size: 16px;
            color: #37474f;
            transition: border-color 0.3s ease;
        }

        .input-group input[type="text"]::placeholder,
        .input-group input[type="password"]::placeholder {
            color: #90a4ae;
        }

        .input-group input[type="text"]:focus,
        .input-group input[type="password"]:focus {
            outline: none;
            border-color: #00bcd4;
            box-shadow: 0 0 5px rgba(0, 188, 212, 0.5);
        }

        .input-field-wrapper:focus-within .input-icon {
            color: #00bcd4;
        }

        .btn-login {
            width: 100%;
            padding: 12px 15px;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 20px;
        }

        .btn-login:hover {
            background-color: #0097a7;
            transform: translateY(-2px);
        }

        .btn-login:active {
            transform: translateY(0);
            background-color: #00838f;
        }

        .back-to-home {
            position: absolute;
            bottom: 20px;
            left: 20px;
            font-size: 14px;
        }

        .back-to-home a {
            color: #546e7a;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-to-home a:hover {
            color: #37474f;
            text-decoration: underline;
        }

        #error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="admin-icons-top">
        <i class="fas fa-book"></i>
        <i class="fas fa-desktop"></i>
        <i class="fas fa-mobile-alt"></i>
        <i class="fas fa-pencil-alt"></i>
        <i class="fas fa-clipboard"></i>
        <i class="fas fa-folder-open"></i>
        <i class="fas fa-calculator"></i>
        <i class="fas fa-chart-bar"></i>
        <i class="fas fa-envelope"></i>
        <i class="fas fa-key"></i>
        <i class="fas fa-cog"></i>
        <i class="fas fa-user-shield"></i>
    </div>
    <div class="login-container">
        <div class="login-image-section">
            <div class="login-image-content">
                <h1>Welcome Back!</h1>
                <p>Log in to access your administrative area.</p>
            </div>
        </div>
        <div class="login-form-section">
            <h2>Admin Login</h2>
            <?php if (isset($error)): ?>
                <div id="error-message"><?= $error ?></div>
            <?php endif; ?>
            <form id="authForm" action="index.php?action=adminLogin" method="post">
                <div class="input-group">
                    <label for="username">Username or Email</label>
                    <div class="input-field-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-field-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>
                <button type="submit" class="btn-login">Log In</button>
            </form>
        </div>
    </div>
    <div class="back-to-home">
        <a href="index.php?action=showAds">Back to Home</a>
    </div>
</body>
</html>