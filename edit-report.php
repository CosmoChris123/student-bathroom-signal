<?php
// Connects with PHP database that contains all user info
session_start();
include('database.php');
$connection = mysqli_connect("localhost", "root", "", "login");
$id = $_GET['id'];
$query = mysqli_query($connection, "SELECT * FROM `user` WHERE id = '$id'");
$row = mysqli_fetch_array($query);

// Checks if the user inputted anything in the input box
// Updates a PHP database to include new data the user inputted
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $skipped = $_POST['skipped'];
    mysqli_query($connection, "UPDATE user SET skipped = '$skipped' WHERE id = $id");
    header("Location: report-student.php");
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit</title>
        <link rel = "stylesheet" href= "style.css">
    </head>
    <body>
        <div class = "content">
            <!-- An input box that is used to edit the student's # of times they skipped class -->
            <!-- Takes only integers and not strings -->
            <!-- Takes the user back to the report-student.php page -->
            <form method = "POST">
            <label>Skipped:</label><input type = "text"
            value = "<?php echo $row['skipped']; ?>" name = "skipped">
            <input type = "submit" name = "submit">
            <a href = "report-student.php">Back</a>
            </form>
        </div>
        
    </body>
</html>
