<?php
session_start();
if (isset($_SESSION['user_id'])){
   $mysqli = require __DIR__ . "/database.php";
   include "database.php";
   $connection = mysqli_connect('localhost', 'root', '', 'login');
   $select = "SELECT * FROM user";
   $sql = "SELECT * FROM user
   $query = mysqli_query($connection, $select);
   $num = mysqli_num_rows($query);
   if ($num > 0){
      $result = mysqli_fetch_assoc($query);
   }
   $skipped = $result['skipped'];
}
?>

<!DOCTYPE html>
<html>
   <head>
      <title>timer</title>
      <link rel = "stylesheet" href = "style.css">
   </head>
   <body>
      <div class = "navbar">
            <div class = "logo">
                <h1>Student Bathroom Tracker</h1>
                <p>Helps keep the education and bathroom breaks in check</p>
            </div>
            <ul>
                <li><a href = "home.php">Home</a></li>
                <li><a href = "timer.php">Timer</a></li>
                <!-- Checks if the user is already logged in -->
                <!-- If user is logged in, the nav bar will display "Log Out" -->
                <!-- Else, the nav bar will display "Log in" -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Log Out</a></li>
                <?php else: ?>
                    <li><a href="login.php">Log in</a></li>
                <?php endif; ?>
            </ul>

        </div>
        <?php

    // Connects with database to verify login
    $is_invalid = false;

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $mysqli = require __DIR__ . "/database.php";

        // Checks if password matches with encryption key
        // If matches, a session begins using a user's broswer cookies
        if ($user){
            if ((isset($_GET['id'])) && ($_POST["email"] = $result["email"])
            && ($_POST["name"] = $result["name"]) && ($result["title"] === "student")){
            $id = $_GET['id'];
                <h1><?php echo $result['name']?> is successfully reported to the database.</h1>
                /* $skippedUpdated = mysqli_query($connection, "UPDATE 'user' SET 'skipped' = [$skipped] + 1 WHERE `id` = '$id'"); */
                exit;
            } else {
                $is_invalid = true;
            }
        }
    }

?>
        <!-- Heading 1 -->
        <div class = "content">
            <h1>Report</h1>
            <?php if ($is_invalid): ?>
                <em>Invalid report</em>
            <?php endif; ?>
            
            <!-- Displays email and password input boxes -->
            <form>
                <div>
                    <label for = "name">Student's name</label>
                    <input type = "text" name = "name" id = "name">
                </div>
                <div>
                    <label for "email">Student's email</label>
                    <input type = "email" name = "email" id = "email"
                        value = "<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                </div>

                  <a href = 'report-student.php?". $result['id']."' class = 'submit_student'><button>Submit</button></a>
            </form>
        </div>
    </body>
</html>
