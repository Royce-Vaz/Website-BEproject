<?php
require_once "database.php";

if (isset($_POST["submit"])) {
    $slNo = mysqli_real_escape_string($conn, $_POST["slNo"]);
    $firstName = mysqli_real_escape_string($conn, $_POST["firstName"]);
    $lastName = mysqli_real_escape_string($conn, $_POST["lastName"]);
    $bookTitle = mysqli_real_escape_string($conn, $_POST["bookTitle"]);
    $paperTitle = mysqli_real_escape_string($conn, $_POST["paperTitle"]);
    $proceedingsTitle = mysqli_real_escape_string($conn, $_POST["proceedingsTitle"]);
    $conferenceName = mysqli_real_escape_string($conn, $_POST["conferenceName"]);
    $nationalOrInternational = mysqli_real_escape_string($conn, $_POST["nationalOrInternational"]);
    $yearOfPublication = mysqli_real_escape_string($conn, $_POST["yearOfPublication"]);
    $issnNumber = mysqli_real_escape_string($conn, $_POST["issnNumber"]);
    $affiliatingInstitute = mysqli_real_escape_string($conn, $_POST["affiliatingInstitute"]);
    $publisherName = mysqli_real_escape_string($conn, $_POST["publisherName"]);

    // File upload handling
    $file_name = $_FILES['file']['name'];

    // Get the current year
    $current_year = date('Y');

    // Append current year to the file name
    $file_name_with_year = $current_year . "_" . $file_name;

    // Destination path with appended year
    $file_destination = "C:/xampp/htdocs/login-register-main/UPLOAD/" . $paperTitle . "_" . $file_name_with_year;

    if (empty($slNo) || empty($firstName) || empty($lastName) || empty($bookTitle) || empty($paperTitle) || empty($proceedingsTitle) || empty($conferenceName) || empty($nationalOrInternational) || empty($yearOfPublication) || empty($issnNumber) || empty($affiliatingInstitute) || empty($publisherName) || empty($file_name)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file_destination)) {
            $sql = "INSERT INTO 8eight (slNo, firstName, lastName, bookTitle, paperTitle, proceedingsTitle, conferenceName, nationalOrInternational, yearOfPublication, issnNumber, affiliatingInstitute, publisherName, file_name) VALUES ('$slNo', '$firstName', '$lastName', '$bookTitle', '$paperTitle', '$proceedingsTitle', '$conferenceName', '$nationalOrInternational', '$yearOfPublication', '$issnNumber', '$affiliatingInstitute', '$publisherName', '$file_name')";

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
    <title>Book and Paper Information Form</title>
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
        <form action="3.3.5.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="slNo">Sl. No.:</label>
                <input type="text" class="form-control" name="slNo">
            </div>
            <div class="form-group">
                <label for="firstName">First Name of the Teacher:</label>
                <input type="text" class="form-control" name="firstName">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name of the Teacher:</label>
                <input type="text" class="form-control" name="lastName">
            </div>
            <div class="form-group">
                <label for="bookTitle">Title of the Book/Chapters Published:</label>
                <input type="text" class="form-control" name="bookTitle">
            </div>
            <div class="form-group">
                <label for="paperTitle">Title of the Paper:</label>
                <input type="text" class="form-control" name="paperTitle">
            </div>
            <div class="form-group">
                <label for="proceedingsTitle">Title of the Proceedings of the Conference:</label>
                <input type="text" class="form-control" name="proceedingsTitle">
            </div>
            <div class="form-group">
                <label for="conferenceName">Name of the Conference (National/International):</label>
                <input type="text" class="form-control" name="conferenceName">
            </div>
            <div class="form-group">
                <label>National/International:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="nationalOrInternational" id="nationalRadio"
                        value="National" required>
                    <label class="form-check-label" for="nationalRadio">National</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="nationalOrInternational" id="internationalRadio"
                        value="International" required>
                    <label class="form-check-label" for="internationalRadio">International</label>
                </div>
            </div>
            <div class="form-group">
                <label for="yearOfPublication">Year of Publication:</label>
                <input type="number" class="form-control" name="yearOfPublication">
            </div>
            <div class="form-group">
                <label for="issnNumber">ISBN/ISSN Number of the Proceeding:</label>
                <input type="text" class="form-control" name="issnNumber">
            </div>
            <div class="form-group">
                <label for="affiliatingInstitute">Affiliating Institute at the Time of Publication:</label>
                <input type="text" class="form-control" name="affiliatingInstitute">
            </div>
            <div class="form-group">
                <label for="publisherName">Name of the Publisher:</label>
                <input type="text" class="form-control" name="publisherName">
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