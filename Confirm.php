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

$paperId = '';
$title = '';
$link = '';
$status = '';
$GroupId = '';
$checking = '';

$_SESSION['studentid'];
$_SESSION['emailaddress'];
$_SESSION['checked'] = $_POST['checked'];

// splitting the comma seperated value and storing them into respective variables

foreach ($_SESSION['checked'] as $checking) {

  list($paperId, $title, $link, $status, $GroupId) = explode(',', $checking);

}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Confirm</title>
    <link rel="stylesheet" href="myStyle-sheet.css">
  </head>
  <body>

<p>
 You have selected the following paper  <?php echo" <h3> $title </h3>";  ?>
</p>


   <form action="Submit.php">

 <input type= "submit" name= "submit" value= "Proceed"> <br>


   </form>
 </body>
</html>
