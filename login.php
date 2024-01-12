<?php
    include("database.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
    
        $stmt = $conn->prepare("SELECT * FROM registeredusers WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row["password"];
    
            if (password_verify($password, $hashedPassword)) {
    
                if ($row["usertype"] == "user") {
                    $_SESSION["username"] = $username;
                    header("Location: user.php");                  
                } elseif ($row["usertype"] == "admin") {
                    $_SESSION["username"] = $username;
                    header("Location: admin.php"); 
                } 
                elseif ($row["usertype"] == "cashier") {
                    $_SESSION["username"] = $username;
                    header("Location: cashier.php"); 
                } else {
                    header("Location: loginvalidation.php");
                }
            } else {
                echo("<script> alert('Username or password is incorrect'); </script>");
            }
        } else {
            echo("<script> alert('Username or password is incorrect'); </script>");
        }
    
        $stmt->close();
        $conn->close();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muntinlupa Cosmopolitan School</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="login.css">
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
        <div class="login">
        <h2>Login</h2>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="off">
            <div class="form-group">
                <label for="username">Username</label> <br>
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="<?= htmlspecialchars($_POST["username"] ?? "") ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label> <br>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>

            <div id="registernow">
            <h5>Don't have an account? <a href="register.php"> Register now</a></h5> <br>
            </div>
        </form>
    </div>

    </section>

</body>
</html>
