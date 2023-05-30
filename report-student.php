<?php
// Starts session using the user's cookies
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- The title with set font -->
        <title>Report</title>
        <link rel = "stylesheet" href= "style.css">
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Log Out</a></li>
                <?php else: ?>
                    <li><a href="login.php">Log in</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- Heading 1 -->
        <div>
            <h1>Report</h1>
            <div>
                <!-- A filter box that filters out the table to find a specific student -->
                <?php
                    // Checks if the user typed anything in the filter box
                    // Searches through the various columns in the PHP database
                    // Calls the filterTable function to filter the data
                    if(isset($_POST['search'])){
                        $searchValue = $_POST["searchValue"];
                        $query = "SELECT * FROM `user` WHERE CONCAT(`id`, `name`, `email`,`skipped`)
                        LIKE '%".$searchValue."%'";
                        $search_result = filterTable($query);
                        
                    // Displays all columns of data if the user doesn't input anything
                    } else {
                        $query = "SELECT * FROM user";
                        $search_result = filterTable($query);
                    }

                    // A function that is used to filter a table about all students' information
                    // Requires a string as its parameter
                    // Returns a filtered table
                    function filterTable($query){
                        $connection = mysqli_connect("localhost", "root", "", "login");
                        $filter_result = mysqli_query($connection, $query);
                        return $filter_result;
                    }

                    // A function that resets the table to show all data
                    // Returns the default table
                    function resetSearch(){
                        $searchValue = "";
                    }
                ?>

                <!-- A filter text box with "Filter" and "Reset" buttons -->
                <form method = "POST">
                    <input type = "text" name = "searchValue"
                    placeholder = "Search for student">
                    <input type = "submit" name = "search" value = "Filter">
                    <button onclick = "resetSearch()">Reset</button>
                </form>
            </div>
            <table>
                <!-- A table that shows the student's ID, Name, Email and the amount of times they skipped class -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th># of Times Skipped Class</th>
                        <th>Edit # of Times Skipped</th>
                    </tr>
                </thead>
               <tbody>
                    <tr>
                        <!-- A loop that goes through the database and displays information about the students only -->
                        <?php while($row = mysqli_fetch_array($search_result)): ?>
                            <?php if($row["title"] === "student"): ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["email"]; ?></td>
                                    <td><?php echo $row["skipped"]; ?></td>
                                    <td><a href = "edit-skipped.php?id=<?php echo $row["id"]; ?>" >
                                    <button>Edit</button></a>
                                </tr>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </tr>
               </tbody>
                
            </table>
            <script>

            </script>
        </div>
    </body>
</html>
