<?php
// Include employeeDAO file
require_once('./dao/employeeDAO.php');

// Define variables and initialize with empty values
$number = $text = $date = $image = "";
$number_err = $text_err = $date_err = $image_err = "";

// Processing form data when form is submitted
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data and store it in variables
    $number = $_POST['number'];
    $text = $_POST['text'];
    $date = $_POST['date'];
  

}

    // Validate number (range validation)
if (empty($number)) {
        $number_err = "Please enter a number.";
    } elseif ($number < 1 || $number > 100) {
        $number_err = "Please enter a number between 1 and 100.";
    }
        // Validate text (min-max character validation and regular expression)
        if (empty($text)) {
            $text_err = "Please enter some text.";
        } elseif (strlen($text) < 3 || strlen($text) > 20) {
            $text_err = "Text should be between 3 and 20 characters.";
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $text)) {
            $text_err = "Text can only contain letters and spaces.";
        }
 // Validate date (greater than or less than logic)
 $current_date = date("Y-m-d");
 if (empty($date)) {
     $date_err = "Please enter a date.";
 } elseif ($date < $current_date) {
     $date_err = "Date should be greater than or equal to the current date.";
 }

    // Validate image upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $image_dir = "uploads/";

        $target_file = $image_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $image_err = "File is not an image.";
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $image_err = "Sorry, your file is too large.";
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $image_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $image_err = "Sorry, file already exists.";
        }

        // If everything is okay, try to upload the file
        if (empty($image_err)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = basename($_FILES["image"]["name"]);
            } else {
                $image_err = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $image_err = "Please upload an image.";
    }

// Check input errors before inserting in database
if (empty($number_err) && empty($text_err) && empty($date_err) && empty($image_err)) {
    $employeeDAO = new employeeDAO();
    $employee = new Employee(0, $number, $text, $date, $image);
    $addResult = $employeeDAO->addEmployee($employee);
    header("refresh:2; url=index.php");
    echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';
    // Close connection
    $employeeDAO->getMysqli()->close();
}

    ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
					
									<!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Number</label>
        <input type="number" name="number" class="form-control <?php echo (!empty($number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number; ?>">
        <span class="invalid-feedback"><?php echo $number_err;?></span>
    </div>

    <div class="form-group">
        <label>Text</label>
        <input type="text" name="text" class="form-control <?php echo (!empty($text_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $text; ?>">
        <span class="invalid-feedback"><?php echo $text_err;?></span>
    </div>
    <div class="form-group">
        <label>Date</label>
        <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
        <span class="invalid-feedback"><?php echo $date_err;?></span>
    </div>
    <div class="form-group">
        <label>Image</label>
        <input type="file" name="image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>">
        <span class="invalid-feedback"><?php echo $image_err;?></span>
    </div>
    <input type="submit" class="btn btn-primary" value="Submit">
    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
</form>


            
            </div>
        </div>        
    </div>
    <?php include 'footer.php'; ?>

</div>

</body>
</html>