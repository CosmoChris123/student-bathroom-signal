<?php
// A session begins using the user's browser cookies
session_start();

// Connects with PHP database if the user is logged in
if (isset($_SESSION['user_id'])){
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user
    WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    $title = $user['title'];
    $skipped = $user['skipped'];
 
 }
?>

<html>
    <head>
        <title>Home</title>
        <link rel = "stylesheet" href = "style.css">
    </head>
    <body>
        <!-- A navigation bar for the user -->
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
        <div>
            <!-- Will display a different interface if the user is a teacher or student -->
            <!-- Will display if the user is a "student" -->
            <?php if(isset($_SESSION['user_id']) && $title === "student"): ?>
                <h1>Hello, <?php echo htmlspecialchars($user['name'])?></h1>
                <h1 id = "skipped">You have skipped class <?php echo htmlspecialchars($skipped) ?> times</h1>
            <?php endif; ?>

            <!-- Will display if the user is a "teacher" -->
            <?php if (isset($_SESSION['user_id']) && $title === "teacher"): ?>
                <h1>Hello, <?php echo htmlspecialchars($user['name'])?></h1>
                <h1 for = "teacher_select">Go to the <a href = "timer.php">TIMER</a> page
                to log how long your students use the bathroom.
                </h1>
            <?php endif; ?>
            <?php if (!isset($_SESSION['user_id'])): ?>
                  <h1 for = "login_check">Please log in first</h1>
               <?php endif; ?>

        </div>
    </body>
</html>
