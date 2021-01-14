<?php
// Include config file
require_once "config.php";

    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT FirstName, LastName, DATE_FORMAT(BirthDate, '%d|%m|%y'), Photo, Notes FROM employees WHERE ID = ?";
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $FirstName = $row["FirstName"];
                    $LastName = $row["LastName"];
                    $BirthDate = $row["DATE_FORMAT(BirthDate, '%d|%m|%y')"];
                    $Photo = $row["Photo"];
                    $Notes = $row["Notes"];
    
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        $stmt->close();
        
        // Close connection
        $mysqli->close();
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>FirstName</label>
                        <p class="form-control-static"><?php echo $row["FirstName"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>LastName</label>
                        <p class="form-control-static"><?php echo $row["LastName"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>BirthDate</label>
                        <p class="form-control-static"><?php echo $row["DATE_FORMAT(BirthDate, '%d|%m|%y')"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Photo</label><br>
                        <img src="uploads/<?php echo $Photo; ?>" style="width:100px;height:100">
                        <p class="form-control-static"><?php echo $row["Photo"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <p class="form-control-static"><?php echo $row["Notes"]; ?></p>
                    </div>
                    <p><a href="index1.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>