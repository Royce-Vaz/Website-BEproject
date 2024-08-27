<?php
require_once "database.php";

if (isset($_POST["submit"])) {
    $principalInvestigator = mysqli_real_escape_string($conn, $_POST["principalInvestigator"]);
    $projectStart = mysqli_real_escape_string($conn, $_POST["projectStart"]);
    $projectEnd = mysqli_real_escape_string($conn, $_POST["projectEnd"]);
    $researchProject = mysqli_real_escape_string($conn, $_POST["researchProject"]);
    $amountReceived = mysqli_real_escape_string($conn, $_POST["amountReceived"]);
    $fundingAgency = mysqli_real_escape_string($conn, $_POST["fundingAgency"]);
    $yearOfSanction = mysqli_real_escape_string($conn, $_POST["yearOfSanction"]);
    $department = mysqli_real_escape_string($conn, $_POST["department"]);

    // File upload handling
    $file_name = $_FILES['file']['name'];

    // Get the current year
    $current_year = date('Y');

    // Append current year to the file name
    $file_name_with_year = $current_year . "_" . $file_name;

    // Destination path with appended year
    $file_destination = "C:/xampp/htdocs/login-register-main/UPLOAD/" . $researchProject . "_" . $file_name_with_year;

    if (empty($principalInvestigator) || empty($projectStart) || empty($projectEnd) || empty($researchProject) || empty($amountReceived) || empty($fundingAgency) || empty($yearOfSanction) || empty($department) || empty($file_name)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_destination)) {
            $sql = "INSERT INTO 2second (principalInvestigator, projectStart, projectEnd, researchProject, amountReceived, fundingAgency, yearOfSanction, department , file_name) VALUES ('$principalInvestigator', '$projectStart', '$projectEnd', '$researchProject', '$amountReceived', '$fundingAgency', '$yearOfSanction', '$department', '$file_name')";

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
    <title>Resource Mobilization for Research</title>
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
        <form action="3.1.3.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="principalInvestigator">Name of the Principal Investigator:</label>
                <input type="text" class="form-control" name="principalInvestigator" required>
            </div>
            <div class="form-group">
                <label for="projectStart">Project Start Date:</label>
                <input type="text" class="form-control" name="projectStart" required>
            </div>
            <div class="form-group">
                <label for="projectEnd">Project End Date:</label>
                <input type="text" class="form-control" name="projectEnd" required>
            </div>
            <div class="form-group">
                <label for="researchProject">Name of the Research Project:</label>
                <input type="text" class="form-control" name="researchProject" required>
            </div>
            <div class="form-group">
                <label for="amountReceived">Amount/Fund Received:</label>
                <input type="number" class="form-control" name="amountReceived" required>
            </div>
            <div class="form-group">
                <label for="fundingAgency">Name of Funding Agency:</label>
                <input type="text" class="form-control" name="fundingAgency" required>
            </div>
            <div class="form-group">
                <label for="yearOfSanction">Year of Sanction:</label>
                <input type="text" class="form-control" name="yearOfSanction" required>
            </div>
            <div class="form-group">
                <label for="department">Department of Recipient:</label>
                <input type="text" class="form-control" name="department" required>
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
</body>

</html>