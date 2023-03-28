<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Reservation Confirmation</title>
  </head>
  <body>
    <h1>Reservation Confirmation</h1>
    <?php
    //connect to the database
    require("sql_info.php");
    $db = new mysqli($server, $username, $password, $database);

    //determine which submit button was chosen on the previous form
    if(isset($_POST["reserve"])){
      //check and make sure the fields were all filled out
      if(empty($_POST["name"]) || empty($_POST["num_of_people"]) || empty($_POST["time"])){
        echo "Not all information was filled out on the previous page. Please go back and try again.";
      }
      else{
        //create short name variables for user input on previous page
        $name = $_POST["name"];
        $num_of_people = $_POST["num_of_people"];
        $time = $_POST["time"];
        $time = $time.":00"; //add seconds to time


        //add reservation to sql database
        $query = "INSERT INTO Reservations VALUES(?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sis', $name, $num_of_people, $time);
        $stmt->execute();

        //let the user know whether it was a success or not
        if($stmt->affected_rows > 0){
          echo "<p>Reservation booked.</p>";
        }
        else{
          echo "<p>An error has occurred. Please go back and make sure:</p><br>";
          echo "<p>1) All the fields were filled out <strong>correctly</strong></p><br>";
          echo "<p>2) The reservation time is available</p><br>";
        }
      }
    }
    else if(isset($_POST["close"])){
      //check and make sure the time was filled out
      if(empty($_POST["close_time"])){
        echo "To close a reservation, a time must be entered. Please go back and try again.";
      }
      //if the field has a value, attempt to delete the row from the database
      else{
        $time = $_POST["close_time"];

        //delete reservation from sql database
        $query = "DELETE FROM Reservations WHERE Time = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $time);
        $stmt->execute();

        //let the user know whether it was a success or not
        if($stmt->affected_rows > 0){
          echo "<p>Reservation closed.</p>";
        }
        else{
          echo "<p>An error has occurred. Please go back and make sure: </p><br>";
          echo "<p>1) The time was filled out in the correct format</p><br>";
          echo "<p>2) The reservation time is booked</p><br>";
        }
      }
    }
    else if(isset($_POST["make_table_available"])){
      //check and make sure a number was entered
      if(empty($_POST["table_num"])){
        echo "To make a table available, a table number must be entered. Please go back and try again.";
      }
      else{
        $table_num = $_POST["table_num"];

        //delete reservation from sql database
        $query = "UPDATE table_info SET Occupied = ?, Server_Name = ? WHERE Table_Num = ?;";
        $stmt = $db->prepare($query);
        $occupied = "N";
        $server_name = "N/A";
        $stmt->bind_param('ssi', $occupied, $server_name, $table_num);
        $stmt->execute();

        //let the user know whether it was a success or not
        if($stmt->affected_rows > 0){
          echo "<p>Table now available</p>";
        }
        else{
          echo "<p>An error has occurred. Please go back and make sure: </p><br>";
          echo "<p>1) The correct table number was entered</p><br>";
          echo "<p>2) The table is not already available</p><br>";
        }
      }
    }
    else{
      //check and make sure a table number and server name was entered
      if(empty($_POST["assign_table_num"]) && empty($_POST["server"])){
        echo "To assign a server to a table, a table number and server name must be entered. Please go back and try again.";
      }
      else{
        $table_num = $_POST["assign_table_num"];
        $server = $_POST["server"];

        //delete reservation from sql database
        $query = "UPDATE table_info SET Occupied = ?, Server_Name = ? WHERE Table_Num = ?;";
        $stmt = $db->prepare($query);
        $occupied = "Y";
        $server_name = $server;
        $stmt->bind_param('ssi', $occupied, $server_name, $table_num);
        $stmt->execute();

        //let the user know whether it was a success or not
        if($stmt->affected_rows > 0){
          echo "<p>$server_name assigned to Table #$table_num</p>";
        }
        else{
          echo "<p>An error has occurred. Please go back and make sure: </p><br>";
          echo "<p>1) A valid table number was entered</p><br>";
          echo "<p>2) The table is not already available</p><br>";
        }
      }
    }

    //disconnect from the database
    $stmt->free_result();
    $db->close();

     ?>
  </body>
</html>
