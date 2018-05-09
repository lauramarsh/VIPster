<?php
// gather form params
$concertID = $_POST["concert"];
$ticketNum = $_POST["ticketnum"];
$phone = $_POST["phonenumber"];
$email = $_POST["emailaddress"];
$delivery = $_POST["deliverymethod"];
$address = $_POST["streetaddress"];
$citystatezip = $_POST["citystatezip"];
$name = $_POST["name"];
$cardNum = $_POST["cardnumber"];
$cardExp = $_POST["cardexp"];
$cardSec = $_POST["cardsec"];

// create db connection
$servername = "matt-smith-v4.ics.uci.edu";
$username = "inf124db040";
$password = "!Qaz2wsx";
$dbname = "inf124db040";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO sales (ticket_num, phone, email, delivery, address, city_state_zip, name, card_num, card_exp, card_sec, concertID)
        VALUES ('" . $ticketNum . "', '" . $phone . "', '" . $email . "', '" . $delivery . "', '" . $address . "', '" . $citystatezip . "', '" . $name . "', '" . $cardNum . "', '" . $cardExp . "', '" . $cardSec . "', '" . $concertID . "')";

$conn->close();
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags came directly from the bootstrap website -->
    <title>Vipster: Purchase VIP tickets</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  </head>

  <body class="body">
    <div class="header">
      <ul class="nav nav-tabs nav-left">
        <li role="presentation"><a href="index.html">VIPster</a></li>
      </ul>
      <ul class="nav nav-tabs nav-right">
        <li role="presentation"><a href="concerts.php">concerts</a></li>
        <li role="presentation"><a href="about.html">about</a></li>
      </ul>
    </div>

    <div class="concerts">
      <div class="categories categories-return">
        <a href="concerts.php" class="btn btn-danger btn-sml">Back to Shop</a>
      </div>
      <div class="listings">
        <h2>Order Confirmed!</h2>
        <table class="table table-dark">
          <thead>
            <tr>
              <th scope="col">Artist</th>
              <th scope="col">Date</th>
              <th scope="col">Venue</th>
              <th scope="col">Price</th>
              <th scope="col">Quantity</th>
            </tr>
          </thead>

          <?php
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
          $sql = "SELECT headliners.name, date, venue, price FROM concerts, headliners WHERE headliners.concertID = concerts.concertID AND concerts.concertID = '" . $concertID . "'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              // get confirmation results
              $artist = $row["name"];
              $date = $row["date"];
              $venue = $row["venue"];
              $price = $row["price"];

              echo "<tbody>";
              echo "<tr>";
              echo "<td scope=\"row\">" . $artist . "</td>";
              echo "<td>" . $date . "</td>";
              echo "<td>" . $venue . "</td>";
              echo "<td>$" . $price . "</td>";
              echo "<td>" . $ticketNum . "</td>";
              echo "</tr>";

            }
            echo "</tbody>";
            echo "</table>";
            echo "<h3>Thank you for your purchase! You will receive your ticket & receipt via " . $delivery . ".</h3>";
          }
          else {
            echo "<h2>Purchase not confirmed</h2>";
          }
          $conn->close();
          ?>

      </div>
    </div>

  </body>
</html>
