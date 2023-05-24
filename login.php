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
        if (password_verify($_POST["password"], $user["password_hash"])){
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];

            header("Location: home.php");
            exit;
        } else {
            $is_invalid = true;
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <!-- The title with set font -->
        <title>Login</title>
        <link rel = "stylesheet" href= "style.css">
    </head>
    <body>
        <div class = "navbar">
            <div class = "logo">
                <h1>Student Bathroom Tracker</h1>
                <p>Helps keep the education and bathroom breaks in check</p>
            </div>
            <ul>
                <li><a href = "home.php">Home</a></li>
                <li><a href = "report.php">Report</a></li>
                <li><a href = "login.php">Log in</a></li>
            </ul>
        </div>
        <!-- Heading 1 -->
        <div class = "content">
            <h1>Login</h1>
            <?php if ($is_invalid): ?>
                <em>Invalid login</em>
            <?php endif; ?>
            
            <!-- Displays email and password input boxes -->
            <form method = "post">
                <div>
                    <label for = "email">email</label>
                    <!-- Doesn't make the email disappear only if -->
                    <!-- email is correct but password isn't -->
                    <input type = "email" name = "email" id = "email"
                        value = "<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                </div>
                <div>
                    <label for "password">password</label>
                    <input type = "password" name = "password" id = "password">
                </div>

                <button>Log in</button>
            </form>
            <label>Don't have an account? <a href = "signup.html">Sign up</a></label>
        </div>
    </body>
</html>
