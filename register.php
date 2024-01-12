<?php

include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "uname", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        echo("<script> alert('Please fill in all required fields.'); </script>");
    } else {
        $checkUsernameQuery = "SELECT username FROM registeredusers WHERE username = ?";
        $checkStmt = mysqli_prepare($conn, $checkUsernameQuery);

        if (!$checkStmt) {
            echo("<script> alert('[Sorry] Database Error'); </script>");
        }

        mysqli_stmt_bind_param($checkStmt, "s", $username);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            echo("<script> alert('Username already exists.'); </script>");
        } else {
            mysqli_stmt_close($checkStmt);

            $sql = "INSERT INTO registeredusers (username, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if (!$stmt) {
                echo("<script> alert('[Sorry] Database Error'); </script>");
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt, "ss", $username, $hash);

            if (mysqli_stmt_execute($stmt)) {
                echo("<script> alert('Registration Success'); </script>");
            } else {
                echo("<script> alert('[Sorry] Database Error'); </script>");
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muntinlupa Cosmopolitan School</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="register.css">
</head>
<body>

    <header>
        <h1>Muntinlupa Cosmopolitan School</h1>
    </header>

    <nav>
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="course.php">Courses</a>
        <a href="login.php">Login</a>
    </nav>

    <section>
    
        <div class="registration-form">
                <h2>REGISTRATION</h2>
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="off">
                    
                <label for="uname">Username</label>
                <input type="text" name="uname" value="<?= htmlspecialchars($_POST["uname"] ?? "") ?>" placeholder="Username" required>

                <label for="password">Password</label>
                        <input type="password" name="password" value="<?= htmlspecialchars($_POST["password"] ?? "") ?>" placeholder="Password" required>

                <button type="submit">Register</button>

                <div id="loginnow">
                    <h5>Already have an account? <a href="login.php"> Login now</a></h5>
                </div>
            </form>
        </div>

    </section>

</body>
</html>