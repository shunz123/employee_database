<?php

/* This php file sets up the connection to the database */

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$mysqli = new mysqli("localhost", "root", "");
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error. "<br>");
}
 
/* print server version */
printf("Server version: %s\n", $mysqli->server_info);
echo "<br>". date("d/m/Y") . "<br>";

// Attempt create database query execution
$sql = "CREATE DATABASE testdb";
if($mysqli->query($sql) === true){
    echo "Database created successfully". "<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error. "<br>";
}
 
// Close connection
$mysqli->close();
?>

<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$mysqli = new mysqli("localhost", "root", "", "testdb");
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error. "<br>");
}
 
// Attempt create table query execution
$sql = "CREATE TABLE Employees(
    ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(30) NOT NULL,
    LastName VARCHAR(30) NOT NULL,
    BirthDate date NOT NULL,
    Photo VARCHAR(255) NOT NULL,
    Notes VARCHAR(255)
    )";
if($mysqli->query($sql) === true){
    echo "Table created successfully.". "<br>";
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error. "<br>";
}
 
// Close connection
$mysqli->close();
?>

<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$mysqli = new mysqli("localhost", "root", "", "testdb");
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error. "<br>");
}
 
// Prepare an insert statement
$sql = "INSERT INTO Employees (FirstName, LastName, BirthDate, Photo, Notes) VALUES (?, ?, ?, ?, ?)";
 
if($stmt = $mysqli->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("sssss", $FirstName, $LastName, $BirthDate, $Photo, $Notes);
    


    /* Set the parameters values and execute
    the statement again to insert another row */
    $FirstName = "Ashley";
    $LastName = "Cole";
    $BirthDate = "2020-12-21";
    $Photo = "fb3.jpg"; 
    $Notes = "x";
    $stmt->execute();
    
    /* Set the parameters values and execute
    the statement to insert a row */
    $FirstName = "John";
    $LastName = "Terry";
    $BirthDate = "2020-12-21";
    $Photo = "fb3.jpg"; 
    $Notes = "x";
    $stmt->execute();

    $FirstName = "David";
    $LastName = "Beckham";
    $BirthDate = "2020-12-21";
    $Photo = "fb3.jpg"; 
    $Notes = "x";
    $stmt->execute();

    $FirstName = "Wayne";
    $LastName = "Rooney";
   $BirthDate = "2020-12-21";
    $Photo = "fb3.jpg"; 
    $Notes = "x";
    $stmt->execute();

    $FirstName = "Joe";
    $LastName = "Cole";
    $BirthDate = "2020-12-21";
    $Photo = "fb3.jpg"; 
    $Notes = "x";
    $stmt->execute();

    echo "Records inserted successfully.". "<br>";
} else{
    echo "ERROR: Could not prepare query: $sql. " . $mysqli->error. "<br>";
}
 
// Close statement
$stmt->close();
 
// Close connection
$mysqli->close();
?>