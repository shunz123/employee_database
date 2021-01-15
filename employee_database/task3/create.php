<?php
// Include config file
require_once "config.php";

$statusMsg = '';

// Define variables and initialize with empty values
$FirstName = $LastName = $BirthDate = $Notes = "";
$FirstName_err = $LastName_err = $BirthDate_err = $Notes_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate FirstName
    $input_FirstName = trim($_POST["FirstName"]);
    if(empty($input_FirstName)){
        $FirstName_err = "Please enter a FirstName.";
    } elseif(!filter_var($input_FirstName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $FirstName_err = "Please enter a valid FirstName.";
    } else{
        $FirstName = $input_FirstName;
    }
    
    // Validate LastName
    $input_LastName = trim($_POST["LastName"]);
    if(empty($input_LastName)){
        $LastName_err = "Please enter a LastName.";
    } elseif(!filter_var($input_LastName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $LastName_err = "Please enter a valid LastName.";
    } else{
        $LastName = $input_LastName;
    }

    // Validate BirthDate
    $input_BirthDate = trim($_POST["BirthDate"]);
    if(empty($input_BirthDate)){
        $BirthDate_err = "Please enter a BirthDate.";
    //} elseif(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$input_BirthDate)) {
        //$BirthDate = $input_BirthDate;
    } else {
        //$BirthDate_err = "Please enter a valid BirthDate.";
        $BirthDate = $input_BirthDate;
    }


    /*$input_BirthDate = trim($_POST["BirthDate"]);
    if(empty($input_BirthDate)){
        $BirthDate_err = "Please enter a BirthDate. (DD-MM-YY)";
    } elseif(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$input_BirthDate)) {
        $BirthDate = $input_BirthDate;
    } else {
        $BirthDate_err = "Please enter a valid BirthDate.";
    }*/

    // Validate notes
    $input_Notes = trim($_POST["Notes"]);
    if(empty($input_Notes)){
        $Notes_err = "Please enter Notes.";     
    } elseif (preg_match('/^[a-zA-Z0-9]+$/', $input_Notes)) {
        $Notes = $input_Notes;
    } else{
        $Notes_err = "Alphanumeric characters only.";
    }

    
    // Check input errors before inserting in database
    if(empty($FirstName_err) && empty($LastName_err) && empty($BirthDate_err) && empty($Notes_err) && !empty($_FILES["file"]["name"])){
        // File upload path
        $targetDir = "uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

        //$Photo = file_get_contents($_FILES['file']['name']);

        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif','pdf');
        if(in_array($fileType, $allowTypes)){
            // Upload file to server
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                // Prepare an insert statement
                $sql = "INSERT INTO employees (FirstName, LastName, BirthDate, Photo, Notes) VALUES (?, ?, ?, ?, ?)";    
                if($stmt = $mysqli->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("sssss", $param_FirstName, $param_LastName, $param_BirthDate, $param_Photo, $param_Notes);
                    // Set parameters
                    $param_FirstName = $FirstName;
                    $param_LastName = $LastName;
                    $param_BirthDate = $BirthDate;
                    $param_Photo = $fileName;
                    $param_Notes = $Notes;
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Records created successfully. Redirect to landing page
                        $message = "Record created successfully";
                        echo "<script type='text/javascript'>alert('$message');window.location.href = 'create.php';</script>";
                        //header("location: create.php");
                        exit();
                    } else{
                        $statusMsg = "File upload failed, please try again.";
                    }
                // Close statement
                $stmt->close();
                }
            }else{
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }else{
            $statusMsg = "Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.";
        }
    }else{
        $statusMsg = "Please select a file to upload.";
    }  
} //else{
    //echo "Something went wrong. Please try again later.";
//}       
        

    
// Close connection
$mysqli->close();


 
        
            
            
            
            



                






                /*if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
                    // File upload path
                    $targetDir = "uploads/";
                    $fileName = basename($_FILES["file"]["name"]);
                    $targetFilePath = $targetDir . $fileName;
                    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                    // Allow certain file formats
                    $allowTypes = array('jpg','png','jpeg','gif','pdf');
                    if(in_array($fileType, $allowTypes)){
                        // Upload file to server
                        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                            // Insert image file name into database
                            $insert = $mysqli->query("INSERT into employees (Photo) VALUES ('".$fileName."'");
                            if($insert){
                                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                                // Records created successfully. Redirect to landing page
                                header("location: index1.php");
                                exit();









                            }else{
                                $statusMsg = "File upload failed, please try again.";
                            } 
                        }else{
                            $statusMsg = "Sorry, there was an error uploading your file.";
                        }
                    }else{
                        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
                    }
                }else{
                    $statusMsg = 'Please select a file to upload.';
                }
                
                // Display status message
                echo $statusMsg;















                
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        //$stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}*/
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $( function() {
        $( "#datepicker" ).datepicker({
        dateFormat: 'dd|mm|y',//check change
        changeMonth: true,
        changeYear: true   
    });
    });
    </script>


    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($FirstName_err)) ? 'has-error' : ''; ?>">
                            <label>FirstName</label>
                            <input type="text" name="FirstName" class="form-control" value="<?php echo $FirstName; ?>">
                            <span class="help-block"><?php echo $FirstName_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($LastName_err)) ? 'has-error' : ''; ?>">
                            <label>LastName</label>
                            <input type="text" name="LastName" class="form-control" value="<?php echo $LastName; ?>">
                            <span class="help-block"><?php echo $LastName_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($BirthDate_err)) ? 'has-error' : ''; ?>">
                            <label for="datepicker">BirthDate</label>
                            <input readonly id="datepicker" type="text" name="BirthDate" class="form-control" value="<?php echo $BirthDate; ?>">
                            <span class="help-block"><?php echo $BirthDate_err;?></span>
                        </div>
                        
                        





                        <div class="form-group">
                            <label>Photo</label>
                            <input type="file" name="file" class="form-control">
                            <!--<input form="submitImage" type="submit" name="submit1" value="Upload">-->
                            <span class="help-block"><?php echo $statusMsg;?></span>
                        </div>
                        
                        





                        
                        <div class="form-group <?php echo (!empty($Notes_err)) ? 'has-error' : ''; ?>">
                            <label>Notes</label>
                            <textarea name="Notes" class="form-control"><?php echo $Notes; ?></textarea>
                            <span class="help-block"><?php echo $Notes_err;?></span>
                        </div>



                        
                      





                        <!--<input type="submit" name="submit1" value="Upload">-->
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        <a href="index1.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>