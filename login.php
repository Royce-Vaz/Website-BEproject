<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit(); // Stop further execution
}

// Handle login form submission
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Include database connection
    require_once "database.php"; // Make sure to replace "database.php" with your actual database connection script

    // Fetch user record by email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user["id"]; // Store user ID in session
            header("Location: index.php");
            exit(); // Stop further execution
        } else {
            $errorMessage = "Password does not match";
        }
    } else {
        $errorMessage = "Email not found";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>

    <style>
        body {
            background-image: url("images/collegepic.webp.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 100vh;
            filter: drop-shadow(10%);
            size-adjust: 100%;
            margin: 0;
            background-attachment: fixed;
            /* Add this line to make the background image fixed */
        }


        /* this is for alert message  */
        .alert {
            margin-top: 20px;
        }

        .login {
            width: fit-content;
            height: fit-content;
            margin: 0 auto;
            padding: 10px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            /* Add this line to move the container to the left */
            border-radius: 6px;
            background-color: #e3e3e391;
            backdrop-filter: blur(10px);
        }

        .form-group {
            margin-bottom: 8px;
        }

        .container {
            width: fit-content;
            height: fit-content;
            margin: 0 auto;
            padding: 20px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            /* Add this line to move the container to the left */
            position: center center;
            margin-top: 250px;
            border-radius: 6px;
            background-color: #e3e3e3cb;
            backdrop-filter: blur(10px);
        }

        #overlay.show {
            background-color: rgba(255, 255, 255, 0.536);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            text-align: center;
            /* Center text horizontally */
            display: flex;
            align-items: center;
            /* Center content vertically */
            justify-content: center;
            /* Center content horizontally */
            z-index: 1;
        }

        #greetingMessage {
            font-size: 28px;
            font-weight: 100vh;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="overlay" id="greetingOverlay" style="display: none;">
        <div id="greetingMessage"></div>
    </div>

    <div class="container">
        <div class="login-form">
            <h2>Login Form</h2>
            <form action="login.php" method="post" onsubmit="return showOverlay();">
                <div class="mb-3">
                    <input type="email" placeholder="Enter Email:" class="form-control" id="email" name="email"
                        required>
                </div>
                <div class="mb-3">
                    <input type="password" placeholder="Enter Password:" class="form-control" id="password"
                        name="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </form>
            <hr>
            <p>Not registered yet? <a href="registration.php">Register Here</a></p>

            <?php
            if (isset($errorMessage)) {
                echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
            }
            ?>
        </div>
    </div>



    <script>

        function showOverlay() {
            const currentTime = new Date().getHours();
            let greetingMessage;

            if (currentTime < 12) {
                greetingMessage = "Good morning!";
            } else if (currentTime < 16) {
                greetingMessage = "Good afternoon!";
            } else {
                greetingMessage = "Good evening!";
            }

            const overlay = document.getElementById("greetingOverlay");
            const messageElement = document.getElementById("greetingMessage");
            messageElement.textContent = greetingMessage;

            overlay.style.display = "flex";
            // Delay before redirecting to index.php (in milliseconds)
            const delayInMilliseconds = 3000; // 3 seconds

            setTimeout(function () {
                window.location.href = "index.php";
            }, delayInMilliseconds);

        }
    </script>
</body>

</html>