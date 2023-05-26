<?php
// This section outputs "Name is required"
// when user doesn't input anything in the name section
if (empty($_POST["name"])){
    <em>('Name is required')</em>
}

// This section outputs "Valid email is required"
// when user doesn't input a valid email in the email section
if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die ('Valid email is required');
}

// Checks if user password is at least 8 characters long
if (strlen($_POST["password"]) < 8) {
    die ('Password must be at least 8 characters long');
}

// Checks if user password has at least one letter
if ( ! preg_match("/[a-z]/i", $_POST["password"])){
    die ('Password must contain at least one letter');
}

// Checks if user password has at least one number
if ( ! preg_match("/[0-9]/i", $_POST["password"])){
    die ('Password must contain at least one number');
}

// Checks if there are duplicate accounts
$connect = mysqli_connect("localhost", "root", "", "login");
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string ($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    // Checks if password matches with encryption key
    // If matches, a session begins using a user's broswer cookies
    if ($user){
        if ($_POST["email"] . $user["email"]){
            die("Email is already taken");
        }
    }
}

// Checks if user is a student or teacher
if (empty($_POST["title"])){
    die ("Please choose if you're a teacher or student");
}

//A variable that encrypts the user's password
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Connects with database
$mysqli = require __DIR__ . "/database.php";

// Creates a record for the user in the database with placeholders
$sql = "INSERT INTO user (name, email, password_hash, title) VALUES (?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

// Checks any syntax errors when adding values to the databse
if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

// Replaces placeholder values in the database with user login details
$stmt->bind_param("ssss", $_POST["name"], $_POST["email"], $password_hash, $_POST["title"]);

// Checks if signup was successful
if ($stmt->execute()){
    header("Location: signup-success.html");
    exit;

} else {
        die($mysqli->error . " " . $mysqli->errno);
}

?>
