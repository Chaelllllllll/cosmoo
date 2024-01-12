<?php
include 'database.php';

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newFirstName = isset($_POST['newFirstName']) ? $_POST['newFirstName'] : '';
    $newMiddleName = isset($_POST['newMiddleName']) ? $_POST['newMiddleName'] : '';
    $newLastName = isset($_POST['newLastName']) ? $_POST['newLastName'] : '';
    $newGradeLevel = isset($_POST['newGradeLevel']) ? $_POST['newGradeLevel'] : '';
    $newLrn = isset($_POST['newLrn']) ? $_POST['newLrn'] : '';
    $newMobileNumber = isset($_POST['newMobileNumber']) ? $_POST['newMobileNumber'] : '';
    $newAge = isset($_POST['newAge']) ? $_POST['newAge'] : '';
    $newCitizenship = isset($_POST['newCitizenship']) ? $_POST['newCitizenship'] : '';
    $newBirthdate = isset($_POST['newBirthdate']) ? $_POST['newBirthdate'] : '';
    $newPlaceOfBirth = isset($_POST['newPlaceOfBirth']) ? $_POST['newPlaceOfBirth'] : '';
    $newGender = isset($_POST['newGender']) ? $_POST['newGender'] : '';

    $updateQuery = "UPDATE registeredusers SET 
                    firstname=?, middlename=?, lastname=?, gradelevel=?,
                    lrn=?, mobilenumber=?, age=?, citizenship=?, 
                    birthdate=?, placeofbirth=?, gender=?
                    WHERE username=?";
    $updateStmt = mysqli_prepare($conn, $updateQuery);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, "ssssssssssss", 
            $newFirstName, $newMiddleName, $newLastName, 
            $newGradeLevel, $newLrn, $newMobileNumber, $newAge, $newCitizenship, 
            $newBirthdate, $newPlaceOfBirth, $newGender, $_SESSION["username"]);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);
        header("Location: user.php");
    } else {
        echo("<script> alert('[Sorry] Database Error'); </script>");
    }
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
    $oldFirstName = $row['firstname'];
    $oldMiddleName = $row['middlename'];
    $oldLastName = $row['lastname'];
    $oldGradeLevel = $row['gradelevel'];
    $oldLrn = $row['lrn'];
    $oldMobileNumber = $row['mobilenumber'];
    $oldAge = $row['age'];
    $oldCitizenship = $row['citizenship'];
    $oldBirthdate = $row['birthdate'];
    $oldPlaceOfBirth = $row['placeofbirth'];
    $oldGender = $row['gender'];
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
    <link rel="stylesheet" href="update.css">
    <title>Muntinlupa Cosmopolitan School</title>
</head>
<body>

    <form method="post" action="" autocomplete="off">

        <h1>Update Information</h1>

        <label for="newFirstName">First Name:</label> <br>
        <input type="text" id="newFirstName" name="newFirstName" value="<?php echo $oldFirstName; ?>" required>
        <br>

        <label for="newMiddleName">Middle Name:</label> <br>
        <input type="text" id="newMiddleName" name="newMiddleName" value="<?php echo $oldMiddleName; ?>">
        <br>

        <label for="newLastName">Last Name:</label> <br>
        <input type="text" id="newLastName" name="newLastName" value="<?php echo $oldLastName; ?>" >
        <br>

        <label for="newGradeLevel">Grade Level:</label> <br>
        <select id="newGradeLevel" name="newGradeLevel">
            <option value="Pre-kinder" <?php echo ($oldGradeLevel == 'pre_kinder') ? 'selected' : ''; ?>>Pre-Kinder</option>
            <option value="Kinder" <?php echo ($oldGradeLevel == 'kinder') ? 'selected' : ''; ?>>Kinder</option>

            <option value="Grade 1" <?php echo ($oldGradeLevel == 'grade_1') ? 'selected' : ''; ?>>Grade 1</option>
            <option value="Grade 2" <?php echo ($oldGradeLevel == 'grade_2') ? 'selected' : ''; ?>>Grade 2</option>
            <option value="Grade 3" <?php echo ($oldGradeLevel == 'grade_3') ? 'selected' : ''; ?>>Grade 3</option>
            <option value="Grade 4" <?php echo ($oldGradeLevel == 'grade_4') ? 'selected' : ''; ?>>Grade 4</option>
            <option value="Grade 5" <?php echo ($oldGradeLevel == 'grade_5') ? 'selected' : ''; ?>>Grade 5</option>
            <option value="Grade 6" <?php echo ($oldGradeLevel == 'grade_6') ? 'selected' : ''; ?>>Grade 6</option>

            <option value="Grade 7" <?php echo ($oldGradeLevel == 'grade_7') ? 'selected' : ''; ?>>Grade 7</option>
            <option value="Grade 8" <?php echo ($oldGradeLevel == 'grade_8') ? 'selected' : ''; ?>>Grade 8</option>
            <option value="Grade 9" <?php echo ($oldGradeLevel == 'grade_9') ? 'selected' : ''; ?>>Grade 9</option>
            <option value="Grade 10" <?php echo ($oldGradeLevel == 'grade_10') ? 'selected' : ''; ?>>Grade 10</option>

            <option value="Grade 11" <?php echo ($oldGradeLevel == 'grade_11') ? 'selected' : ''; ?>>Grade 11</option>
            <option value="Grade 12" <?php echo ($oldGradeLevel == 'grade_12') ? 'selected' : ''; ?>>Grade 12</option>
        </select> 
        <br>

        <label for="newLrn">Lrn:</label> <br>
        <input type="number" min="1" id="newLrn" name="newLrn" value="<?php echo $oldLrn; ?>" >
        <br>

        <label for="newMobileNumber">Mobile Number:</label> <br>
        <input type="text" id="newMobileNumber" name="newMobileNumber" value="<?php echo $oldMobileNumber; ?>">
        <br>

        <label for="newAge">Age:</label> <br>
        <input type="text" id="newAge" name="newAge" value="<?php echo $oldAge; ?>">
        <br>

        <label for="newCitizenship">Citizenship:</label> <br>
        <input type="text" id="newCitizenship" name="newCitizenship" value="<?php echo $oldCitizenship; ?>">
        <br>

        <label for="newBirthdate">Birthdate:</label> <br>
        <input type="date" id="newBirthdate" name="newBirthdate" value="<?php echo $oldBirthdate; ?>">
        <br>

        <label for="newPlaceOfBirth">Place of Birth:</label> <br>
        <input type="text" id="newPlaceOfBirth" name="newPlaceOfBirth" value="<?php echo $oldPlaceOfBirth; ?>">
        <br>

        <label for="newGender">Gender:</label> <br>
        <input type="text" id="newGender" name="newGender" value="<?php echo $oldGender; ?>">
        <br>
        
        <button type="submit" value="Update">Update</button> <br>
        <br>
        <a href="user.php">Back to User Page</a>
    </form>
</body>
</html>
