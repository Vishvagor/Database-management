<!DOCTYPE html>
<html>
<head>
    <title>Department Employee Details</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h3, h4 {
            color: #333;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="number"] {
            padding: 8px;
            width: 100%;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        input[type="submit"] {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="container">
    <h3>Enter Department Number</h3>
    <form method="GET" action="p2.php">
        <label for="dno">Department Number:</label>
        <input type="number" id="dno" name="dno" required>
        <input type="submit" value="Get Employee Details">
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

        $query = "SELECT lname, salary FROM EMPLOYEE WHERE dno = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $dno);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        echo "<h4>Employees in Department $dno</h4>";

        if (mysqli_num_rows($result) > 0) {
    ?>
        <table>
            <tr>
                <th>Last Name</th>
                <th>Salary</th>
            </tr>

            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $lname = htmlspecialchars($row["lname"]);
                    $salary = htmlspecialchars($row["salary"]);
            ?>
            <tr>
                <td><?php echo $lname; ?></td>
                <td><?php echo $salary; ?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    <?php
        } else {
            echo "<p>No employees found in department $dno.</p>";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo "<p>Please enter a department number above.</p>";
    }
    ?>
</div>

</body>
</html>

