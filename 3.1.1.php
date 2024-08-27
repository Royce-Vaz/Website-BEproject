<?php
require_once "database.php";

if (isset($_POST["submit"])) {
    $projectName = mysqli_real_escape_string($conn, $_POST["projectName"]);
    $principalInvestigator = mysqli_real_escape_string($conn, $_POST["principalInvestigator"]);
    $department = mysqli_real_escape_string($conn, $_POST["department"]);
    $yearOfAward = mysqli_real_escape_string($conn, $_POST["yearOfAward"]);
    $fundsProvided = mysqli_real_escape_string($conn, $_POST["fundsProvided"]);
    $projectStart = mysqli_real_escape_string($conn, $_POST["projectStart"]);
    $projectEnd = mysqli_real_escape_string($conn, $_POST["projectEnd"]);

    // File upload handling
    $file_name = $_FILES['file']['name'];

    // Get the current year
    $current_year = date('Y');

    // Append current year to the file name
    $file_name_with_year = $current_year . "_" . $file_name;

    // Destination path with appended year
    $file_destination = "C:/xampp/htdocs/login-register-main/UPLOAD/" . $projectName . "_" . $file_name_with_year;

    if (empty($projectName) || empty($principalInvestigator) || empty($department) || empty($yearOfAward) || empty($fundsProvided) || empty($projectStart) || empty($projectEnd) || empty($file_name)) {
        echo "<div class='alert alert-danger'>All fields including file upload are required.</div>";
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_destination)) {
            $sql = "INSERT INTO 1first (projectName, principalInvestigator, department, yearOfAward, fundsProvided, projectStart, projectEnd, file_name) VALUES ('$projectName', '$principalInvestigator', '$department', '$yearOfAward', '$fundsProvided', '$projectStart', '$projectEnd', '$file_name')";

            if (mysqli_query($conn, $sql)) {
                echo "<div class='alert alert-success'>Data submitted successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error uploading file.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Mobilization for Research</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="forms.css/3.css">
    <script src="dynamic-reports-scripts.js"></script>

    <style>
        .navbar {
            background-color: #f0f0f0;
            padding-left: 10px;
            padding-right: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(to right, #4CAF50, #64ad49);
            color: white;
            z-index: 2;
        }

        .logo img {
            height: 40px;
            /* Adjusted logo height */
        }

        .menu-user-wrapper {
            display: flex;
            align-items: center;
        }

        .menu-btn button {
            padding: 4px 16px;
            background-color: #3099;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        /* Animation styles (if using animated gradient as previously mentioned) */
        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
            display: none;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            height: fit-content;
            max-width: 100%;
            max-height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            overflow: auto;
        }

        .modal-content {
            padding: 20px;
            text-align: center;
        }

        .modal-content button {
            display: block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        .modal-content button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="index.php">
                    <img src="images/dbit_logo.png" alt="Logo">
                </a>
            </div>
            <div class="menu-user-wrapper">
                <div class="menu-btn">
                    <button onclick="openMenu()">Menu</button>
                </div>
            </div>
        </nav>
    </header>


    <!-- Overlay behind the modal -->
    <div class="overlay" onclick="closeModal()" id="overlay"></div>

    <!-- Modal for menu options -->
    <div class="modal" id="menuModal">
        <div class="modal-content">
            <button onclick="report()">Report</button>
            <button onclick="goBack()">Go Back</button>
        </div>
    </div>



    <div class="container">
        <form action="3.1.1.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="projectName">Name of the Project/Endowments, Chairs:</label>
                <input type="text" class="form-control" name="projectName" required>
            </div>
            <div class="form-group">
                <label for="principalInvestigator">Name of the Principal Investigator:</label>
                <input type="text" class="form-control" name="principalInvestigator" required>
            </div>
            <div class="form-group">
                <label for="department">Department of Principal Investigator:</label>
                <input type="text" class="form-control" name="department" required>
            </div>
            <div class="form-group">
                <label for="yearOfAward">Year of Award:</label>
                <input type="text" class="form-control" name="yearOfAward" required>
            </div>
            <div class="form-group">
                <label for="fundsProvided">Funds provided:</label>
                <input type="text" class="form-control" name="fundsProvided" required>
            </div>
            <div class="form-group">
                <label for="projectStart">Project Start:</label>
                <input type="text" class="form-control" name="projectStart" required>
            </div>
            <div class="form-group">
                <label for="projectEnd">Project End:</label>
                <input type="text" class="form-control" name="projectEnd" required>
            </div>
            <div class="form-group">
                <label for="file">Upload File:</label>
                <input type="file" class="form-control" name="file" required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btnn" value="Submit" name="submit">
            </div>
        </form>
    </div>

    <script>
        // Open the menu modal with dynamically populated report button
        function openMenu() {
            const modal = document.getElementById("menuModal");
            const overlay = document.getElementById("overlay");
            modal.style.display = "block";
            overlay.style.display = "block";
        }
        function report() {
            const currentPageUrl = window.location.href;
            const filename = currentPageUrl.substring(currentPageUrl.lastIndexOf("/") + 1);
            const pageNumber = filename.replace(".php", "");
            const reportPageUrl = `report${pageNumber}.php`;
            window.location.href = reportPageUrl;
        }

        function goBack() {
            window.location.href = 'index.php';
        }

        function closeModal() {
            const modal = document.getElementById("menuModal");
            const overlay = document.getElementById("overlay");
            modal.style.display = "none";
            overlay.style.display = "none";
        }

        // Close the modal and overlay if user clicks outside the modal
        window.onclick = function (event) {
            const modal = document.getElementById("menuModal");
            const overlay = document.getElementById("overlay");
            if (event.target === overlay) {
                modal.style.display = "none";
                overlay.style.display = "none";
            }
        };
    </script>
</body>

</html>