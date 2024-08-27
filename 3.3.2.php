<?php
require_once "database.php";

if (isset($_POST["submit"])) {
    $awardeeName = mysqli_real_escape_string($conn, $_POST["awardeeName"]);
    $contactDetails = mysqli_real_escape_string($conn, $_POST["contactDetails"]);
    $awardName = mysqli_real_escape_string($conn, $_POST["awardName"]);
    $awardingAgency = mysqli_real_escape_string($conn, $_POST["awardingAgency"]);
    $yearOfAward = mysqli_real_escape_string($conn, $_POST["yearOfAward"]);
    $incentiveDetails = mysqli_real_escape_string($conn, $_POST["incentiveDetails"]);

    // File upload handling
    $file_name = $_FILES['file']['name'];

    // Get the current year
    $current_year = date('Y');

    // Append current year to the file name
    $file_name_with_year = $current_year . "_" . $file_name;

    // Destination path with appended year
    $file_destination = "C:/xampp/htdocs/login-register-main/UPLOAD/" . $awardeeName . "_" . $file_name_with_year;

    if (empty($awardeeName) || empty($contactDetails) || empty($awardName) || empty($awardingAgency) || empty($yearOfAward) || empty($incentiveDetails) || empty($file_name)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_destination)) {
            $sql = "INSERT INTO 5fifth (awardeeName, contactDetails, awardName, awardingAgency, yearOfAward, incentiveDetails, file_name) VALUES ('$awardeeName', '$contactDetails', '$awardName', '$awardingAgency', '$yearOfAward', '$incentiveDetails', '$file_name')";

            if (mysqli_query($conn, $sql)) {
                echo "<div class='alert alert-success'>Data submitted successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
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
    <title>Form Title</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="forms.css/3.css">
    <script src="dynamic-reports-scripts.js"></script>
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

    </div>
    <div class="container">
        <form action="3.3.2.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="awardeeName">Name of the Awardees:</label>
                <input type="text" class="form-control" name="awardeeName" required>
            </div>
            <div class="form-group">
                <label for="contactDetails">Contact Details:</label>
                <input type="text" class="form-control" name="contactDetails" required>
            </div>
            <div class="form-group">
                <label for="awardName">Name of the Award:</label>
                <input type="text" class="form-control" name="awardName" required>
            </div>
            <div class="form-group">
                <label for="awardingAgency">Name of the Awarding Agency:</label>
                <input type="text" class="form-control" name="awardingAgency" required>
            </div>
            <div class="form-group">
                <label for="yearOfAward">Year of Award:</label>
                <input type="number" class="form-control" name="yearOfAward" required>
            </div>
            <div class="form-group">
                <label for="incentiveDetails">Incentive Details:</label>
                <textarea class="form-control" name="incentiveDetails" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="file">Upload File:</label>
                <input type="file" class="form-control" name="file" required>
            </div>
            <br>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
            </div>
        </form>
    </div>
</body>

</html>