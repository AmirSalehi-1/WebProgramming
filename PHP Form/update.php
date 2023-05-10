<?php
// Include employeeDAO file
require_once('./dao/employeeDAO.php');

// Define variables and initialize with empty values
$number = $date = $text = $image = "";
$number_err = $date_err = $text_err = $image_err = "";
$employeeDAO = new employeeDAO();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate number
    $input_number = trim($_POST["number"]);
    if (empty($input_number)) {
        $number_err = "Please enter a number.";
    } elseif ($input_number < 1 || $input_number > 100) {
        $number_err = "Please enter a number between 1 and 100.";
    } else {
        $number = $input_number;
    }
  // Validate text
  $input_text = trim($_POST["text"]);
  if (empty($input_text)) {
      $text_err = "Please enter some text.";
  } elseif (strlen($input_text) < 3 || strlen($input_text) > 20) {
      $text_err = "Text should be between 3 and 20 characters.";
  } elseif (!preg_match('/^[a-zA-Z\s]+$/', $input_text)) {
      $text_err = "Text can only contain letters and spaces.";
  } else {
      $text = $input_text;
  }
    // Validate date
    $input_date = trim($_POST["date_input"]);
    $current_date = date("Y-m-d");
    if (empty($input_date)) {
        $date_err = "Please enter a date.";
    } elseif ($input_date < $current_date) {
        $date_err = "Date should be greater than or equal to the current date.";
    } else {
        $date = (new DateTime($input_date))->format('Y-m-d');
    }


    // Validate image
    if (!empty($_FILES["image"]["name"])) {
        $upload_dir = "uploads/";

        $tmp_name = $_FILES["image"]["tmp_name"];
        $filename = basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $newFilename = pathinfo($filename, PATHINFO_FILENAME) . "_" . time() . "." . $imageFileType;
        $target_file = $upload_dir . $newFilename;

        // Check if the file is an actual image
        $check = getimagesize($tmp_name);
        if ($check !== false) {
            if ($_FILES["image"]["size"] > 500000) {
                $image_err = "Sorry, your file is too large.";
            }
    
            // Upload file
            if (move_uploaded_file($tmp_name, $target_file)) {
                $image = $newFilename;
            } else {
                $image_err = "Sorry, there was an error uploading your file.";
            }
        } else {
            $image_err = "File is not an image.";
        }
    }

    // Check input errors before inserting in database
    if (empty($number_err) && empty($date_err) && empty($text_err) && empty($image_err)) {
        $employee = new Employee($id, $number, $text, $date, isset($image) ? $image : NULL);

        $result = $employeeDAO->updateEmployee($employee);
        header("refresh:2; url=index.php");
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';
        // Close connection
        $employeeDAO->getMysqli()->close();
    }

} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);
        $employee = $employeeDAO->getEmployee($id);

        if ($employee) {
            // Retrieve individual field value
            $number = $employee->getNumber();
            $date = $employee->getDate();
            $text = $employee->getText();
            $image = $employee->getImage();
        } else {
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    // Close connection
    $employeeDAO->getMysqli()->close();
}
?>

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the Vehicle record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Number</label>
                            <input type="text" name="number" class="form-control <?php echo (!empty($number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number; ?>">
                            <span class="invalid-feedback"><?php echo $number_err;?></span>
                        </div>
                       
                    <div class="form-group">
                        <label>Text</label>
                        <textarea name="text" class="form-control <?php echo (!empty($text_err)) ? 'is-invalid' : ''; ?>"><?php echo $text; ?></textarea>
                        <span class="invalid-feedback"><?php echo $text_err;?></span>
                    </div>
                    <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date_input" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">                        <span class="invalid-feedback"><?php echo $date_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" accept="image/*">
                        <span class="invalid-feedback"><?php echo $image_err;?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>        
    </div>
</div>
</body>
</html>