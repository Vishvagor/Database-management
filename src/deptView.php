<!DOCTYPE html>
<html>
<head>
    <title>Department View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
            margin: 0;
        }
        .container {
            width: 80%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h3, h4 {
            color: #333;
            margin-bottom: 15px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            margin-right: 10px;
        }
        input[type="number"], input[type="submit"] {
            padding: 8px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td a {
            color: #4CAF50;
            text-decoration: none;
        }
        td a:hover {
            text-decoration: underline;
        }
        .section-title {
            font-weight: bold;
            color: #555;
            margin-top: 20px;
        }
        .no-data {
            color: #777;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h3>Enter Department Number</h3>
    <form method="GET" action="deptView.php">
        <label for="dno">Department Number:</label>
        <input type="number" id="dno" name="dno" required>
        <input type="submit" value="Submit">
    </form>

    <?php
    $servername = "course-mysql";
    $username = "user";
    $password = "userpassword";
    $database = "mydatabase";

    if (isset($_GET['dno'])) {
        $dno = $_GET['dno'];
        $conn = mysqli_connect($servername, $username, $password, $database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Query for department information
        $query = "SELECT Dname, Mgr_ssn, Mgr_start_date, Lname, Fname 
                  FROM DEPARTMENT, EMPLOYEE 
                  WHERE Dnumber = ? AND Mgr_ssn = Ssn";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $dno);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $dname = htmlspecialchars($row["Dname"]);
            $mssn = htmlspecialchars($row["Mgr_ssn"]);
            $mstart = htmlspecialchars($row["Mgr_start_date"]);
            $mlname = htmlspecialchars($row["Lname"]);
            $mfname = htmlspecialchars($row["Fname"]);

            echo "<h4>Department: $dname</h4>";
            echo "<p>Manager: <a href=\"empView.php?ssn=$mssn\">$mlname, $mfname</a></p>";
            echo "<p>Manager Start Date: $mstart</p>";
        } else {
            echo "<p class='no-data'>No department found with number $dno.</p>";
        }

        // Query for department locations
        $query = "SELECT Location FROM DEPT_LOCATION WHERE Dnumber = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $dno);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        echo "<h4 class='section-title'>Department Locations:</h4>";
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo htmlspecialchars($row["Location"]) . "<br>";
            }
        } else {
            echo "<p class='no-data'>No locations found.</p>";
        }

        // Query for employees
        $query = "SELECT Ssn, Lname, Fname FROM EMPLOYEE WHERE Dno = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $dno);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        echo "<h4 class='section-title'>Employees:</h4>";
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Employee SSN</th><th>Last Name</th><th>First Name</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                $ssn = htmlspecialchars($row["Ssn"]);
                $lname = htmlspecialchars($row["Lname"]);
                $fname = htmlspecialchars($row["Fname"]);
                echo "<tr><td><a href=\"empView.php?ssn=$ssn\">$ssn</a></td><td>$lname</td><td>$fname</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-data'>No employees found.</p>";
        }

        // Query for projects
        $query = "SELECT Pnumber, Pname, Plocation FROM PROJECT WHERE Dnum = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $dno);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        echo "<h4 class='section-title'>Projects:</h4>";
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>Project Number</th><th>Project Name</th><th>Location</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                $pnum = htmlspecialchars($row["Pnumber"]);
                $pname = htmlspecialchars($row["Pname"]);
                $ploc = htmlspecialchars($row["Plocation"]);
                echo "<tr><td><a href=\"projView.php?pnum=$pnum\">$pnum</a></td><td>$pname</td><td>$ploc</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-data'>No projects found.</p>";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo "<p class='no-data'>Please enter a department number above.</p>";
    }
    ?>

</div>

</body>
</html>

