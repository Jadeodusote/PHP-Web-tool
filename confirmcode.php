
<?php session_start();

// error reporting used for debugging

// ini_set('display_errors','1');
// ini_set('display_statrup_errors','1');
// error_reporting(E_ALL);

$expire = 2700;
$_SESSION['start'] = time();

// students has 45 mins before the page times out
if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > $expire)) {

  session_unset();     // unset $_SESSION variable
  session_destroy();   // destroy session data in storage preventing random hash from being used after this time has passed
}

// Setting variables to be used on this page

$P1 = " P1 ";
$P2 = " P2 ";
$P3 = " P3 ";

$paperId = '';
$title = '';
$link = '';
$status = '';
$GroupId = '';
$random_hash = '';
$checking = '';
$Booked = "Booked";
$Temp = 'Temp';

$_SESSION[$random_hash];
$_SESSION['studentid'];
$_SESSION['checked'];


// Passing the values from checked box into a variable, making it a string instead of array

  foreach ($_SESSION['checked'] as $checking ){

  list($paperId, $title, $link, $status, $GroupId) = explode(',', $checking); // exploding the string into seperate variables for using the commas as identifiers

}

// initialising database connection
$dbServername = 'localhost';
$dbUsername = 'root';
$dbPassword = 'root';
$dbName = 'Dissertation1';

$connect = mysqli_connect('localhost', 'root', 'root', 'Dissertation1');

// if ($connect) {
//   echo "<br> connection established! <br>";
//
// } else {
//     die("connection failed. Reason:".mysqli_connect_error());
// }


?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="myStyle-sheet.css">
   </head>

   <body>
     <main>

       <h2> Please confirm your code here! </h2>



   <form method='post'>

     Insert unique code here: <input type='text' name='code'>

     <input type='submit' value ='Submit' >

   </body>
   </html>

 <?php



if ($_POST['code'] != $_SESSION[$random_hash]){

echo "<br>";
echo "Incorrect code!";
echo "<br>";
echo "If its been <strong>45 mins</strong> since you recieved your code your session will have timed out, please start again";

}

// update status to free once group space has been confirmed if not booked

$sql = " UPDATE Papers SET status = 'Free' Where paperId = 'P1' ";

if(($_POST['code'] == $_SESSION[$random_hash]) && ($status != $Booked) && ($paperId == $P1 )){

    mysqli_query($connect, $sql);

    header ("Location: Finished.php");

  }


   $sql = " UPDATE Papers SET status = 'Free' Where paperId = 'P2' ";

   if(($_POST['code'] == $_SESSION[$random_hash]) && ($status != $Booked) && ($paperId == $P2 )){

       mysqli_query($connect, $sql);

       header ("Location: Finished.php");

  }

    $sql = " UPDATE Papers SET status = 'Free' Where paperId = 'P3' ";

    if(($_POST['code'] == $_SESSION[$random_hash]) && ($status != $Booked) && ($paperId == $P3 )){

      mysqli_query($connect, $sql);

          header ("Location: Finished.php");

  }



  // if session times out and code has not been set, remove inserted data and return status of paper to free

  $sql = "UPDATE Papers SET status = 'Free' Where paperId = 'P1';
          DELETE FROM Students WHERE studentid = '$sid' ";


         if (!isset($_POST['code']) && (time() - $_SESSION['start'] > $expire) && ($paperId == $P1)) {

           mysqli_multi_query($connect, $sql);

  }

  $sql = "UPDATE Papers SET status = 'Free' Where paperId = 'P2';
          DELETE FROM Students WHERE studentid = '$sid' ";

          if (!isset($_POST['code']) && (time() - $_SESSION['start'] > $expire) && ($paperId == $P2)) {

            mysqli_multi_query($connect, $sql);

  }


 $sql = "UPDATE Papers SET status = 'Free' Where paperId = 'P3';
         DELETE FROM Students WHERE studentid = '$sid' ";

         if (!isset($_POST['code']) && (time() - $_SESSION['start'] > $expire) && ($paperId == $P3)) {

           mysqli_multi_query($connect, $sql);

  }


?>
