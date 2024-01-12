<?php
    include 'database.php';

    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }

    $searchLastName = isset($_GET['searchLastName']) ? $_GET['searchLastName'] : '';
    $searchGradeLevel = isset($_GET['gradeLevel']) ? $_GET['gradeLevel'] : '';

    if (empty($searchLastName) && empty($searchGradeLevel)) {
        $selectUsersQuery = "SELECT * FROM registeredusers WHERE usertype = 'user'";
        $selectUsersStmt = mysqli_prepare($conn, $selectUsersQuery);
    } elseif (empty($searchLastName) && !empty($searchGradeLevel)) {
        $selectUsersQuery = "SELECT * FROM registeredusers WHERE usertype = 'user' AND gradelevel = ?";
        $selectUsersStmt = mysqli_prepare($conn, $selectUsersQuery);
        mysqli_stmt_bind_param($selectUsersStmt, 's', $searchGradeLevel);
    } elseif (!empty($searchLastName) && empty($searchGradeLevel)) {
        $selectUsersQuery = "SELECT * FROM registeredusers WHERE usertype = 'user' AND lastname LIKE ?";
        $selectUsersStmt = mysqli_prepare($conn, $selectUsersQuery);
        mysqli_stmt_bind_param($selectUsersStmt, 's', $searchLastName);
    } else {
        $selectUsersQuery = "SELECT * FROM registeredusers WHERE usertype = 'user' AND lastname LIKE ? AND gradelevel = ?";
        $selectUsersStmt = mysqli_prepare($conn, $selectUsersQuery);
        mysqli_stmt_bind_param($selectUsersStmt, 'ss', $searchLastName, $searchGradeLevel);
    }

    if (!$selectUsersStmt) {
        echo("<script> alert('[Sorry] Database Error'); </script>");
    }

    mysqli_stmt_execute($selectUsersStmt);
    $usersResult = mysqli_stmt_get_result($selectUsersStmt);

    mysqli_stmt_close($selectUsersStmt);
    mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Muntinlupa Cosmopolitan School</title>
    <script>
        function handleInputChange() {
            document.getElementById('searchForm').submit();
        }
    </script>
</head>
<body>

    <div class="welcome">
        <h1 id="welcome">Welcome, MCSAdmin</h1>
        <a id="logoutButton" href="logout.php">Logout</a>
    </div>

    <div class="search">
        <form id="searchForm" method="get">
            <label for="searchLastName">Student Search</label> <br>
            <input type="text" id="searchLastName" name="searchLastName" placeholder="Search by Last Name" value="<?= htmlspecialchars($searchLastName) ?>" onchange="handleInputChange()">
        
            
                <select id="gradeLevel" name="gradeLevel" onchange="handleInputChange()">
                    <option value="">All</option>
                        <?php
                             $grades = array('Pre-Kinder', 'Kinder', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12');

                            foreach ($grades as $grade) {
                            $selected = (isset($_GET['gradeLevel']) && $_GET['gradeLevel'] == $grade) ? 'selected' : '';
                            echo "<option value=\"$grade\" $selected>$grade</option>";
                            }
                        ?>
                </select>
        </form>
    </div>

    <div class="infoTable">
    <table>
        <tr id="label">
            <th>Username</th>
            <th>First Name</th>     
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Grade Level</th>
            <th>LRN</th>
            <th>Mobile Number</th>
            <th>Age</th>
            <th>Citizenship</th>
            <th>Birthdate</th>
            <th>Place of Birth</th>
            <th>Gender</th>
            <th>Status</th>

        </tr>

        <?php while ($userRow = mysqli_fetch_assoc($usersResult)) : ?>
            <tr id="data">
                <td><?= $userRow['username'] ?></td>
                <td><?= $userRow['firstname'] ?></td>
                <td><?= $userRow['middlename'] ?></td>
                <td><?= $userRow['lastname'] ?></td>
                <td><?= $userRow['gradelevel'] ?></td>
                <td><?= $userRow['lrn'] ?></td>
                <td><?= $userRow['mobilenumber'] ?></td>
                <td><?= $userRow['age'] ?></td>
                <td><?= $userRow['citizenship'] ?></td>
                <td><?= $userRow['birthdate'] ?></td>
                <td><?= $userRow['placeofbirth'] ?></td>
                <td><?= $userRow['gender'] ?></td>
                <td><?= $userRow['status'] ?></td>

                <td id="updateButton"><a href="admin_update_user.php?id=<?= $userRow['id'] ?>">Update</a></td>
                <td id="deleteButton"><a href="delete_user.php?id=<?= $userRow['id'] ?>" onclick="">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>

    

</body>
</html>