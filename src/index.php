<!DOCTYPE html>
<html>
<head>
    <title>Simple Data Access</title>
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
        h4 {
            margin-bottom: 20px;
            color: #333;
        }
        select {
            padding: 8px;
            width: 100%;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h4>Employee Details for:</h4> 
    <form method="post" action="p1.php">
        <select name="ssn">
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

                $query = "SELECT ssn FROM EMPLOYEE";
                $result = $conn->query($query);

                if ($result === false) {
                    echo "Error: " . $conn->error;
                    exit();
                }

                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"" . htmlspecialchars($row['ssn']) . "\">" . htmlspecialchars($row['ssn']) . "</option>";
                }

                $conn->close();
            ?>
        </select>
        <input type="submit" value="Get Employee Details">
    </form>
</div>

</body>
</html>

