<?php

$dbServername = 'localhost';
$dbUsername = 'root';
$dbPassword = 'root';
$dbName = 'Dissertation1';

$connect = mysqli_connect('localhost', 'root', 'root', 'Dissertation1');

// if ($connect) {
//   echo "connection established! <br>";
//   // code...
// } else {
//     die("connection failed. Reason:".mysqli_connect_error());
//   // code...
// }

?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Main Page</title>
    <link rel="stylesheet" href="myStyle-sheet.css">
    <img src="css bits/tree-silhouette-green-23.png'" alt="">
  </head>
  <body>

    <main>



      <?php  echo "<h1>Paper Selection</h1>"; ?>

      <p>Please enter your Student ID and Email address to begin.</p>

      <form class="Main form" action="Select.php" method="post">

        Student ID: <input type="text" name="studentid" required>

        Email: <input type="email" name="emailaddress" required>

        <input type="submit" name="submit" value="Submit">

      </form>



      <?php

      // checking how many have booked according to Group ID
      // setting status to booked if result returns 3 rows i.e 3 bookings

      $query = "SELECT * FROM Students
                WHERE GroupId = 'G1'";

      $result = mysqli_query($connect, $query);

      $rowcount=mysqli_num_rows($result);

      $sql = "UPDATE Papers SET status = 'Booked' Where paperId = 'P1'";

            if($rowcount >= 3) {

              // echo " <script>
              //         document.getElementById('P1').disabled = true;
              //       </script>";

              mysqli_query($connect, $sql);
      }


      $query = "SELECT * FROM Students
                WHERE GroupId = 'G2'";

      $result = mysqli_query($connect, $query);

      $rowcount=mysqli_num_rows($result);

      $sql = "UPDATE Papers SET status = 'Booked' Where paperId = 'P2'";

      if($rowcount >= 3) {

        // echo " <script>
        //         document.getElementById('P2').disabled = true;
        //       </script>";

        mysqli_query($connect, $sql);
      }


        $query = "SELECT * FROM Students
                  WHERE GroupId = 'G3'";

        $result = mysqli_query($connect, $query);

        $rowcount=mysqli_num_rows($result);

        $sql = "UPDATE Papers SET status = 'Booked' Where paperId = 'P3'";

        if($rowcount >= 3) {

          // echo " <script>
          //         document.getElementById('P3').disabled = true;
          //       </script>";

          mysqli_query($connect, $sql);
        }


      ?>
    </main>


  </body>
  </html>
