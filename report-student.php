<?php
session_start();
if (isset($_SESSION['user_id'])){
   $mysqli = require __DIR__ . "/database.php";
   $sql = "SELECT * FROM user
   WHERE id = {$_SESSION["user_id"]}";
   $result = $mysqli->query($sql);
   $user = $result->fetch_assoc();
   $title = $user['title'];

   /* $skippedUpdated = "UPDATE 'user' SET 'skipped' = [$skipped]"; */    
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

        $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string ($_POST["email"]));

        $result = $mysqli->query($sql);

        $user = $result->fetch_assoc();

        // Checks if password matches with encryption key
        // If matches, a session begins using a user's broswer cookies
        if ($user){
            if (($_POST["email"] = $user["email"]) && ($_POST["name"] = $user["name"])){

                
                /* $skippedUpdated = "UPDATE 'user' SET 'skipped' = [$skipped]"; */
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
            <form method = "post">
                <div>
                    <label for = "name">Student's name</label>
                    <input type = "text" name = "name" id = "name">
                </div>
                <div>
                    <label for "email">Student's email</label>
                    <input type = "email" name = "email" id = "email"
                        value = "<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                </div>

                <button>Log in</button>
            </form>
        </div>
    </body>
</html>