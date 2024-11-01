<!DOCTYPE html>
<html>
<head>
    <title>All Departments</title>
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
            text-align: center;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h4 {
            color: #333;
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
    </style>
</head>
<body>

<div class="container">
    <?php
        $servername = "course-mysql";
        $username = "user";
        $password = "userpassword";
        $dbname = "mydatabase";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query the database
        $query = "SELECT dnumber, dname FROM DEPARTMENT ORDER BY dnumber";
        $result = $conn->query($query);
    ?>
    
    <h4>Departments of the Company</h4>
    <table>
        <tr>
            <th>Department Number</th> 
            <th>Department Name</th>
        </tr>
        
        <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $dno = htmlspecialchars($row['dnumber']);
                    $dname = htmlspecialchars($row['dname']);
                    echo "<tr>
                            <td><a href=\"deptView.php?dno=$dno\">$dno</a></td>
                            <td>$dname</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No departments found.</td></tr>";
            }
            $conn->close();
        ?>
    </table>
</div>

</body>
</html>

