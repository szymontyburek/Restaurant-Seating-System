<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="reservationSystem.css">
    <title>Reservation System</title>
  </head>
  <body>
    <h1>Reservation System</h1>
    <h2>Reserve a Time:</h2>

    <section>
      <?php
      //use php and sql database to list available reservation times
      //connect to mysql database
      require("sql_info.php");
      $db = new mysqli($server, $username, $password, $database);
      //select all reservation times
      $query = "SELECT Time FROM Reservations";
      $stmt = $db->prepare($query);
      $stmt->execute();
      $stmt->store_result();

      $stmt->bind_result($reservation_time);
      //create an array that holds every single possible reservation time


      $reservation_times = ["11:00:00", "11:30:00", "12:00:00", "12:30:00", "13:00:00", "13:30:00", "14:00:00", "14:30:00", "15:00:00", "15:30:00", "16:00:00","16:30:00", "17:00:00","17:30:00", "18:00:00","18:30:00","19:00:00", "19:30:00","20:00:00", "20:30:00","21:00:00",
      "21:30:00", "22:00:00", "22:30:00"];


      //use a while loop and eliminate the reservation times that are taken from $reservation_times and add booked times to a seperate array
      $booked_times = [];
      while($stmt->fetch()){
        //find the index of $reservation_time in $reservation_times
        $index = array_search($reservation_time, $reservation_times);
        //remove element from array using unset()
        unset($reservation_times[$index]);
        //add elements to $booked_times
        array_push($booked_times, $reservation_time);
      }
      $reservations_left = count($reservation_times);
      echo "<p>Number of Reservations <strong>Available</strong>: $reservations_left / 24</p><br>";
      echo "<p>Open Times:</p><br>";
      //display available reservations in standard time
      function am_or_pm($array){
        echo "<div class='display_times'><br>";
        foreach($array as $time){
          $timestamp = substr($time, 0, -3); //string slice the time so seconds don't show, since they'll always be zero
          //determine whether it is am or pm
          if(intval($timestamp) == 11){
            $timestamp = $timestamp." am";
          }
          else{
            $timestamp = $timestamp." pm";
          }
          //display $timestamp
          echo "<p>$timestamp</p><br>";
          //display a vertical line between each time
          echo "<div class='vertical_line'></div><br>";
        }
        echo "</div><br>";
      }
      am_or_pm($reservation_times);
       ?>
       <div>
         <form class="" action="reserve_a_time.php" method="post">
           <table>
           <tr class="header">
             <td style="width: 200px; text-align: center;">Time(HH:MM)</td>
             <td style="width: 120px; text-align: center;">Name</td>
             <td style="width: 200px; text-align: center;">Number Of People</td>
           </tr>
           <tr>
             <td><input type="text" name="time" id="time" size="25"></td>
             <td><input type="text" name="name" id="name"></td>
             <td><input type="text" name="num_of_people" id="num_of_people"></td>
           </tr>
          </table>
          <input class="button" type="submit" id="reserve" name="reserve" value="Reserve Time">
         </form>
       </div>
    </section>

    <section>
      <h2>Close a Time:</h2>
      <?php
      $booked_count = count($booked_times);
      echo "<p>Number of Reservations: $booked_count / 24</p><br>";
      echo "<p>Reservation Times:</p><br>";
      //display booked reservation times
      am_or_pm($booked_times);
       ?>
    </section>

    <section>
      <div>
        <form class="" action="reserve_a_time.php" method="post">
          <table>
          <tr class="header">
            <td style="width: 200px; text-align: center;">Time(HH:MM)</td>
          </tr>
          <tr>
            <td><input type="text" name="close_time" id="close_time" size="25"></td>
          </tr>
         </table>
         <input class="button" type="submit" name="close" id="close" value="Close Reservation">
        </form>
      </div>
    </section>

    <section>
      <h2>Make a Table Available:</h2>
      <div>
        <form class="" action="reserve_a_time.php" method="post">
          <table>
          <tr class="header">
            <td style="width: 200px; text-align: center;">Table Number(1-28)</td>
          </tr>
          <tr>
            <td><input type="text" name="table_num" id="table_num" size="25"></td>
          </tr>
         </table>
         <input class="button" type="submit" name="make_table_available" id="make_table_available" value="Make Table Available">
        </form>
      </div>
    </section>

    <section>
      <h2>Change Bar Occupancy:</h2>
      <div>
        <form class="" action="reserve_a_time.php" method="post">
          <table>
          <tr class="header">
            <td style="width: 200px; text-align: center;">Bar Occupancy(?/20)</td>
          </tr>
          <tr>
            <td><input type="text" name="bar_occupancy" id="bar_occupancy" size="25"></td>
          </tr>
         </table>
         <input class="button" type="submit" name="change_bar_occupancy" id="change_bar_occupancy" value="Change Bar Occupancy">
        </form>
      </div>
    </section>

    <section>
      <h2>Assign a Server:</h2>
      <div>
        <form class="" action="reserve_a_time.php" method="post">
          <table>
          <tr class="header">
            <td style="width: 200px; text-align: center;">Table Number</td>
            <td style="width: 200px; text-align: center;">Server</td>
          </tr>
          <tr>
            <td><input type="text" name="assign_table_num" id="assign_table_num" size="25"></td>
            <td><input type="text" name="server" id="server" size="25"></td>
          </tr>
         </table>
         <input class="button" type="submit" name="assign_server" id="assign_server" value="Assign Server">
        </form>
      </div>
    </section>

    <section class="bottom_button">
      <a href="index.php"><button type="button" name="button">Back To Table Sections</button></a>
    </section>
  </body>
</html>
