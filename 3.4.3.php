<?php
require_once "database.php";

if (isset($_POST["submit"])) {
    $activityName = mysqli_real_escape_string($conn, $_POST["activityName"]);
    $organizingUnit = mysqli_real_escape_string($conn, $_POST["organizingUnit"]);
    $yearOfActivity = mysqli_real_escape_string($conn, $_POST["yearOfActivity"]);
    $teachersParticipated = mysqli_real_escape_string($conn, $_POST["teachersParticipated"]);
    $studentsParticipated = mysqli_real_escape_string($conn, $_POST["studentsParticipated"]);

    // File upload handling
    $file_name = $_FILES['file']['name'];

    // Get the current year
    $current_year = date('Y');

    // Append current year to the file name
    $file_name_with_year = $current_year . "_" . $file_name;

    // Destination path with appended year
    $file_destination = "C:/xampp/htdocs/login-register-main/UPLOAD/" . $activityName . "_" . $file_name_with_year;

    if (empty($activityName) || empty($organizingUnit) || empty($yearOfActivity) || empty($teachersParticipated) || empty($studentsParticipated) || empty($file_name)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_destination)) {
            $sql = "INSERT INTO 91ten (activityName, organizingUnit, yearOfActivity, teachersParticipated, studentsParticipated, file_name) 
                VALUES ('$activityName', '$organizingUnit', '$yearOfActivity', '$teachersParticipated', '$studentsParticipated', '$file_name')";

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
    <title>Activity Information Form</title>
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
        <form action="3.4.3.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="activityName">Name of the Activity:</label>
                <input type="text" class="form-control" name="activityName" required>
            </div>
            <div class="form-group">
                <label for="organizingUnit">Organizing Unit/Agency/Collaborating Agency:</label>
                <input type="text" class="form-control" name="organizingUnit" required>
            </div>
            <div class="form-group">
                <label for="yearOfActivity">Year of the Activity:</label>
                <input type="number" class="form-control" name="yearOfActivity" required>
            </div>
            <div class="form-group">
                <label for="teachersParticipated">Number of Teachers Participated:</label>
                <input type="number" class="form-control" name="teachersParticipated" required>
            </div>
            <div class="form-group">
                <label for="studentsParticipated">Number of Students Participated:</label>
                <input type="number" class="form-control" name="studentsParticipated" required>
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