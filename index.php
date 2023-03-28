<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="index.css">
    <title>Sections</title>
  </head>
  <body>
    <h1>Table Sections</h1>
    <?php
    //connect to mysql database
    require("sql_info.php");
    $db = new mysqli($server, $username, $password, $database);
     ?>
    <section class="bar">
      <?php
      //display the number of people occupying the bar
      $query = "SELECT Table_Num, Occupied FROM table_info WHERE Location = ?";
      $stmt = $db->prepare($query);
      $location = "Bar";
      $stmt->bind_param('s', $location);
      $stmt->execute();
      $stmt->store_result();

      $stmt->bind_result($table_num, $barPersons);

      //display results
      while($stmt->fetch()){
        echo "<h3>Bar: $barPersons / 20</h3>";
      }
       ?>
    </section>


    <section class="dining">
      <h3>Dining Room(5 people a table):</h3>
      <?php
      function displayOccupancy($location){
        //connect to mysql database
        require("sql_info.php");
        $db = new mysqli($server, $username, $password, $database);
        //extract info for dining room occupancy
        $query = "SELECT Occupied, Table_Num FROM table_info WHERE Location = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $location);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($occupation, $table_num);
        //display results
        $counter = 1;
        while($stmt->fetch()){
          echo "<p>Table #$table_num($location): $occupation<p>";
          $counter++;
        }
        //disconnect from the database
        $stmt->free_result();
        $db->close();
      }
      displayOccupancy("Dining");
       ?>
    </section>
    <section class="corner">
      <h3>Corner Tables(8 people a table)</h3>
      <?php
      displayOccupancy("Corner");
       ?>
    </section>
    <section class="patio">
      <h3>Patio(8 people a table)</h3>
      <?php
      //call displayOccupancy function with "Patio" as parameter
      displayOccupancy("Patio");
       ?>
    </section>
    <section class="reservations">
      <h3>Upcoming Reservations</h3>
      <?php
      //extract info for reservations
      $query = "SELECT Name, Number_Of_People, Time FROM Reservations";
      $stmt = $db->prepare($query);
      $stmt->execute();
      $stmt->store_result();

      $stmt->bind_result($name, $numOfPeople, $time);
      echo "<p>Number of Reservations: $stmt->num_rows</p><br>";
       ?>
       <div>
         <table>
         <tr class="header">
           <td style="width: 70px; text-align: center;">Name</td>
           <td style="width: 200px; text-align: center;">Number Of People</td>
           <td style="width: 120px; text-align: center;">Time</td>
         </tr>
         <?php
         //display reservations
         while($stmt->fetch()){
           echo "<tr><br>";
           echo "<td>$name</td><br>";
           echo "<td>$numOfPeople</td><br>";
           $timestamp = substr($time, 0, -3); //string slice the time so seconds don't show, since they'll always be zero
           //determine whether it is am or pm
           if(intval($timestamp) == 11){
             $timestamp = $timestamp." am";
           }
           else{
             $timestamp = $timestamp." pm";
           }
           echo "<td>$timestamp<td><br>";
           echo "</tr><br>";
         }
         echo "</div><br>";
         //disconnect from the database
         $stmt->free_result();
         $db->close();
          ?>
    </section>
    <section>
      <div class="go_to_reservation_system">
        <?php
        //create a button that links to reversation system page
        echo "<a href='reservationSystem.php'><button>Reservation System</button></a>";
         ?>
      </div>
    </section>
  </body>
</html>
