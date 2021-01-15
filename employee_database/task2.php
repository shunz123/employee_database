<!-- This php file displays all records from the database -->
 <!DOCTYPE html>
 <html>
 <head>
<link href="task2.css" rel="stylesheet">
</head>
<body>


<?php

 /* Attempt MySQL server connection. Assuming you are running MySQL

 server with default setting (user 'root' with no password) */

 $mysqli = new mysqli("localhost", "root", "", "testdb");


 // Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}


 // Attempt select query execution
 $sql = "SELECT * FROM Employees";
if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){

        echo "<table border='1'>";
            echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>FirstName</th>";
                echo "<th>LastName</th>";
                echo "<th>BirthDate</th>";
                echo "<th>Photo</th>";
                echo "<th>Notes</th>";
            echo "</tr>";
        while($row = $result->fetch_array()){
            echo "<tr>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['BirthDate'] . "</td>";
                echo "<td>" . "<img src=\"uploads/" . $row['Photo'] . "\" alt='xxx' />" . "</td>";
                echo "<td>" . $row['Notes'] . "</td>";
                

            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        $result->free();
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}
 
// Close connection
$mysqli->close();
?>