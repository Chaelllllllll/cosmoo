<?php
include 'database.php';

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
$selectQuery = "SELECT * FROM registeredusers WHERE username = ?";
$selectStmt = mysqli_prepare($conn, $selectQuery);

if (!$selectStmt) {
    echo("<script> alert('[Sorry] Database Error'); </script>");
}

mysqli_stmt_bind_param($selectStmt, "s", $username);
mysqli_stmt_execute($selectStmt);
$result = mysqli_stmt_get_result($selectStmt);

if ($row = mysqli_fetch_assoc($result)) {
    $firstname = $row['firstname'];
    $middlename = $row['middlename'];
    $lastname = $row['lastname'];
    $gradelevel = $row['gradelevel'];
    $lrn = $row['lrn'];
    $mobilenumber = $row['mobilenumber'];
    $age = $row['age'];
    $citizenship = $row['citizenship'];
    $birthdate = $row['birthdate'];
    $placeofbirth = $row['placeofbirth'];
    $gender = $row['gender'];
    $id = $row['id'];
    $status = $row['status'];


}

mysqli_stmt_close($selectStmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="user.css">
    <title>Muntinlupa Cosmopolitan School</title>
</head>
<body>

    <header >
        <?php 
            echo "<h1>Welcome, $username </h1>"; 
            echo "<p><b>Status:</b> $status </p>";
        ?>
    </header>

    <section class="info">
        <div>
            <h2>Student Information</h2>
            <br>
            <?php
                echo "<p><b>First Name:</b> $firstname</p>";
                echo "<p><b>Middle Name:</b> $middlename</p>";
                echo "<p><b>Last Name:</b> $lastname</p>";
                echo "<p><b>Grade Level:</b> $gradelevel</p>";
                echo "<p><b>Lrn:</b> $lrn</p>";
                echo "<p><b>Contact Number: </b> $mobilenumber</p>";
                echo "<p><b>Age: </b> $age</p>";
                echo "<p><b>Citizenship: </b> $citizenship</p>";
                echo "<p><b>Birthdate: </b> $birthdate</p>";
                echo "<p><b>Place of Birth: </b> $placeofbirth</p>";
                echo "<p><b>Gender: </b> $gender</p>";
            ?>
            <a href="logout.php" id="log">Logout</a>
            <a href="update.php" id="up">Update Information</a>
        </div>
    </section>
</body>
</html>
