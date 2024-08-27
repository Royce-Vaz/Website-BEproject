<?php
require_once "database.php";

if (isset($_POST["submit"])) {
    $organizationWithMoU = mysqli_real_escape_string($conn, $_POST["organizationWithMoU"]);
    $institutionName = mysqli_real_escape_string($conn, $_POST["institutionName"]);
    $yearOfSigning = mysqli_real_escape_string($conn, $_POST["yearOfSigning"]);
    $mouDurationStart = mysqli_real_escape_string($conn, $_POST["mouDurationStart"]);
    $mouDurationEnd = mysqli_real_escape_string($conn, $_POST["mouDurationEnd"]);
    $activities = mysqli_real_escape_string($conn, $_POST["activities"]);
    $studentsParticipated = mysqli_real_escape_string($conn, $_POST["studentsParticipated"]);
    $teachersParticipated = mysqli_real_escape_string($conn, $_POST["teachersParticipated"]);

    // File upload handling
    $file_name = $_FILES['file']['name'];

    // Get the current year
    $current_year = date('Y');

    // Append current year to the file name
    $file_name_with_year = $current_year . "_" . $file_name;

    // Destination path with appended year
    $file_destination = "C:/xampp/htdocs/login-register-main/UPLOAD/" . $institutionName . "_" . $file_name_with_year;

    if (empty($organizationWithMoU) || empty($institutionName) || empty($yearOfSigning) || empty($mouDurationStart) || empty($mouDurationEnd) || empty($activities) || empty($studentsParticipated) || empty($teachersParticipated) || empty($file_name)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_destination)) {
            $sql = "INSERT INTO 94thirteen (organizationWithMoU, institutionName, yearOfSigning, mouDurationStart, mouDurationEnd, activities, studentsParticipated, teachersParticipated, file_name) 
                VALUES ('$organizationWithMoU', '$institutionName', '$yearOfSigning', '$mouDurationStart', '$mouDurationEnd', '$activities', '$studentsParticipated', '$teachersParticipated', '$file_name')";

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
    <title>MoU Information Form</title>
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

    <div class="container">
        <form action="3.5.2.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="organizationWithMoU">Organization with which MoU is signed:</label>
                <input type="text" class="form-control" name="organizationWithMoU" required>
            </div>
            <div class="form-group">
                <label for="institutionName">Name of the Institution/Industry/Corporate House:</label>
                <input type="text" class="form-control" name="institutionName" required>
            </div>
            <div class="form-group">
                <label for="yearOfSigning">Year of Signing:</label>
                <input type="number" class="form-control" name="yearOfSigning" required>
            </div>
            <div class="form-group">
                <label for="mouDurationStart">MoU Duration Start:</label>
                <input type="date" class="form-control" name="mouDurationStart" required>
            </div>
            <div class="form-group">
                <label for="mouDurationEnd">MoU Duration End:</label>
                <input type="date" class="form-control" name="mouDurationEnd" required>
            </div>
            <div class="form-group">
                <label for="activities">List of Activities (Year-wise):</label>
                <textarea class="form-control" name="activities" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="studentsParticipated">Number of Students Participated:</label>
                <input type="number" class="form-control" name="studentsParticipated" required>
            </div>
            <div class="form-group">
                <label for="teachersParticipated">Number of Teachers Participated:</label>
                <input type="number" class="form-control" name="teachersParticipated" required>
            </div>
            <div class="form-group">
                <label for="file">Upload File:</label>
                <input type="file" class="form-control" name="file" required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
            </div>
        </form>
    </div>
</body>

</html>