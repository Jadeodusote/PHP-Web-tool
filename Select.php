<?php session_start();

// error reporting used for debugging

// ini_set('display_errors','1');
// ini_set('display_statrup_errors','1');
// error_reporting(E_ALL);

$expire = 600;
$_SESSION['start'] = time();

// students has 10 mins before the page times out
if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > $expire)) {

  session_unset();     // unset $_SESSION variable
  session_destroy();   // destroy session data in storage
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Selection</title>
    <link rel="stylesheet" href="myStyle-sheet.css">
  </head>
  <body>

    <h1>Selection Page</h1>


<?php

// passing post information into session for constant use on multiple pages

$_SESSION['emailaddress'] = $_POST['emailaddress'];
$_SESSION['studentid'] = $_POST['studentid'];

echo "Hello Student <strong> ".$_SESSION['studentid']." </strong> <br><br> ";


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


$sql = "SELECT * FROM Papers";
$result = mysqli_query($connect, $sql);

echo "<table style= 'border: 1px solid black'>

      <form action='Confirm.php' method='post'>

              <tr>

            <th style= 'border: 1px solid black'> Paper ID </th>
            <th style= 'border: 1px solid black'> Title </th>
            <th style= 'border: 1px solid black'> Access Link </th>
            <th style= 'border: 1px solid black'> Availability </th>
            <th style= 'border: 1px solid black'> GroupId </th>
            <th style= 'border: 1px solid black'> Select </th>

              </tr>";

// echoing results from query as rows

foreach($result as $row) {

        echo "  <tr>
        <td style= 'border: 1px solid black'> ".$row['paperId']." </td>
        <td style= 'border: 1px solid black'> ".$row['title']."   </td>
        <td style= 'border: 1px solid black'> <a href = ".$row['link']." > ".$row['link']." </td>
        <td style= 'border: 1px solid black'> ".$row['status']."  </td>
        <td style= 'border: 1px solid black'> ".$row['GroupId']."  </td>

        <td style= 'border: 1px solid black'>

        <input type='radio' name='checked[]' id = '".$row['paperId']."'  value= ' ".$row['paperId']." , ".$row['title']." , ".$row['link']." , ".$row['status']." , ".$row['GroupId']."' >

        </td>
        </tr> ";

        }

        echo "
        <table/>
          <form/> <br>
            <input type='submit' name='Submit'";

            echo "<br><br><br>";

// checking how many have booked according to Group ID
//Disabling radio button based on count



        $query = "SELECT * FROM Students
                  WHERE GroupId = 'G1'";

        $result = mysqli_query($connect, $query);

        $rowcount=mysqli_num_rows($result);

              if($rowcount >= 3) {

          echo " <script>
                  document.getElementById('P1').disabled = true;
                 </script>";

        }


        $query = "SELECT * FROM Students
                  WHERE GroupId = 'G2'";

        $result = mysqli_query($connect, $query);

        $rowcount=mysqli_num_rows($result);

        if($rowcount >= 3) {

          echo " <script>
                  document.getElementById('P2').disabled = true;
                </script>";

        }


          $query = "SELECT * FROM Students
                    WHERE GroupId = 'G3'";

          $result = mysqli_query($connect, $query);

          $rowcount=mysqli_num_rows($result);

          if($rowcount >= 3) {

            echo " <script>
                    document.getElementById('P3').disabled = true;
                  </script>";
          }

            ?>

          </body>
          </html>
