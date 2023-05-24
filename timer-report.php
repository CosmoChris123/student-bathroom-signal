<?php
session_start();

if (isset($_SESSION["user_id")){
   $mysqli = require __DIR__ . "/database.php";

   $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";

   $result = $mysqli->query($sql);

   $user = $result->fetch_assoc();
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
                <li><a href = "report.php">Report</a></li>
                <!-- Checks if the user is already logged in -->
                <!-- If user is logged in, the nav bar will display "Log Out" -->
                <!-- Else, the nav bar will display "Log in" -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Log Out</a></li>
                <?php else: ?>
                    <li><a href="login.php">Log in</a></li>
                <?php endif; ?>
            </ul>
    <div class = "content">
        <div class="stopwatch">
            <h1 id="displayTime">00:00:00</h1>
            <div class="buttons">
               <button onclick="watchStop()">Stop</button>
               <button onclick="watchStart()">Start</button>
               <button onclick="watchReset()">Reset</button>
            </div>
         </div>
         <script>
            // Creates variables to set up seconds, minutes & hours
            // displayTime variable displays the timer
            // timer variable determines if the timer starts or stops
            let seconds = 0;
            let minutes = 0;
            let hours = 0;
            let displayTime = document.getElementById("displayTime");
            let timer = null;
            let alert = 0;
            
            // A function that creates a timer using HTML-->
            function stopwatch() {
               seconds++;
               if (seconds === 60) {
                  seconds = 0;
                  minutes++;
               }
               let h = hours < 10 ? "0" + hours : hours;
               let m = minutes < 10 ? "0" + minutes : minutes;
               let s = seconds < 10 ? "0" + seconds : seconds;
               
               displayTime.innerHTML = h + ":" + m + ":" + s;
               
               if (m = 10) {
                  alert++;
               }
               
            }
            
            // A function that starts the timer
            // If timer is null, the timer starts. Else, the timer stops
            function watchStart() {
               if (timer !== null) {
                  clearInterval(timer);
               }
               timer = setInterval(stopwatch, 1000);
            }
            
            // A function that ends the timer
            // Uses the clearInterval statement to stop the timer
            function watchStop() {
               clearInterval(timer);
            }
            
            function watchReset(){
               clearInterval(timer);
               [seconds, minutes, hours] = [0,0,0];
               displayTime.innerHTML = "00:00:00";
            }
         </script>
         <div>
            <!-- Will display a different interface if the user is a teacher or student -->
            <?php if(isset($user["title"]) === "student"): ?>
               <label for = "teacher_select">Select a teacher</label>
            <?php else: ?>
               <label for = "teacher_select">Select a student</label>
            <?php endif ?>
         </div>
    </div>
   </body>
</html>
