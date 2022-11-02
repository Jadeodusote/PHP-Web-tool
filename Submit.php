
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

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Code genrator</title>
    <link rel="stylesheet" href="myStyle-sheet.css">
  </head>
  <body>

    <h3> Confirmation email sent</h3>

</body>
</html>


<?php

// declaring variables to be used in code

$P1 = " P1 ";
$P2 = " P2 ";
$P3 = " P3 ";

$paperId = '';
$title = '';
$link = '';
$status = '';
$GroupId = '';
$checking = '';
$random_hash = '';

$_SESSION['studentid'];
$_SESSION['emailaddress'];
$_SESSION['checked'];


foreach ($_SESSION['checked'] as $checking) {

  list($paperId, $title, $link, $status, $GroupId) = explode(',', $checking);
}



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


$sid = mysqli_real_escape_string($connect, $_SESSION['studentid']); // preventing sql injections
$emad = mysqli_real_escape_string($connect, $_SESSION['emailaddress']); // preventing sql injections

// inserting students information and temporarily updating status to reflect temp conditional booking

  $sql = "INSERT INTO Students (studentid, emailAddress, GroupId)
          VALUES ( '$sid', '$emad' , 'G1');
          UPDATE Papers SET status = 'Temp' Where paperId = 'P1'";

  if ($paperId == $P1) {
        mysqli_multi_query($connect, $sql);
        echo "Your details have been inserted into the database and paper 1 provisionally booked!<br><br>";
      }

      //else {
      //     die("connection failed. Reason:".mysqli_connect_error());



  $sql = "INSERT INTO Students (studentid, emailAddress, GroupId)
          VALUES ( '$sid', '$emad' , 'G2');
          UPDATE Papers SET status = 'Temp' Where paperId = 'P2'";

  if ($paperId == $P2) {
        mysqli_multi_query($connect, $sql);
        echo "Your details have been inserted into the database and paper 2 provisionally booked!!<br><br>";
      }
      //else {
      //     die("connection failed. Reason:".mysqli_connect_error());


  $sql = "INSERT INTO Students (studentid, emailAddress, GroupId)
          VALUES ( '$sid', '$emad' , 'G3');
          UPDATE Papers SET status = 'Temp' Where paperId = 'P3'";

   if ($paperId == $P3) {
          mysqli_multi_query($connect, $sql);
          echo "Your details have been inserted into the database and paper 3 provisionally booked!<br><br>";
      }
      //else {
      //     die("connection failed. Reason:".mysqli_connect_error());


// creating a random hash as code
  $_SESSION[$random_hash] = substr(md5(uniqid(rand(), true)), 16, 16);


  // sending an email using sendgrid API (php mail was being rejected)

  require_once'config.php';
  require 'vendor/autoload.php';

  $email = new \SendGrid\Mail\Mail();

  $email->setFrom("joao2@kent.ac.uk", "Team Kent");
  $email->setSubject("Please confirm your project choice!");
  $email->addTo($_SESSION['emailaddress']);
  $email->addContent("text/plain","You have chosen the following paper ".$title."

  Please confirm your choice within 45mins of recieving this email to secure your space.

  Your confirmation code is ". $_SESSION[$random_hash] ." please input your code here http://localhost:8888/disso/confirmcode.php.

  Unconfirmed choices will be made free again for other students to choose, so please adhere to the time constraints.

  Many thanks,

  Team Kent" );

  $email->addContent(
      "text/html", " You have chosen the following paper <strong> ".$title." </strong>  <br><br>

      Please confirm your choice within 45 mins of recieving this email to secure your space. <br><br>

      Your confirmation code is <strong> ". $_SESSION[$random_hash] ." </strong>, please enter your code here :

      <a href= http://localhost:8888/disso/confirmcode.php > Please confirm here! </a> <br><br>

      Unconfirmed choices will be made free again for other students to choose, so please adhere to the time constraints. <br><br>

      Many thanks, <br><br>
      <strong> Team Kent </strong>");

  $sendgrid = new \SendGrid(SENDGRID_API_KEY);


      $response = $sendgrid->send($email);
      echo "Please check your emails. A confirmation has now been sent.";

  // try {
  //     print $response->statusCode() . "\n";
  //     print_r( $response->headers() );
  //     print $response->body() . "\n";
  // } catch ( Exception $e ) {
  //     echo 'Caught exception: '. $e->getMessage() ."\n";
  // }



  $sid = mysqli_real_escape_string($connect, $_SESSION['studentid']); // preventing sql injections

  // if session times out remove inserted data and return status of paper to free

  $sql = "UPDATE Papers SET status = 'Free' Where paperId = 'P1';
          DELETE FROM Students WHERE studentid = '$sid' ";


         if ((time() - $_SESSION['start'] > $expire) && ($paperId == $P1)) {

           mysqli_multi_query($connect, $sql);

  }

  $sql = "UPDATE Papers SET status = 'Free' Where paperId = 'P2';
          DELETE FROM Students WHERE studentid = '$sid' ";

          if ((time() - $_SESSION['start'] > $expire) && ($paperId == $P2)) {

            mysqli_multi_query($connect, $sql);

  }


 $sql = "UPDATE Papers SET status = 'Free' Where paperId = 'P3';
         DELETE FROM Students WHERE studentid = '$sid' ";

         if ((time() - $_SESSION['start'] > $expire) && ($paperId == $P3)) {

           mysqli_multi_query($connect, $sql);

  }

  ?>
