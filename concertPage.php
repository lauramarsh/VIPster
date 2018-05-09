<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags came directly from the bootstrap website -->
    <title>Vipster: Concert Page</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  </head>

  <body class="body">
    <div class="header">
      <ul class="nav nav-tabs nav-left">
        <li role="presentation"><a href="../index.html">VIPster</a></li>
      </ul>
      <ul class="nav nav-tabs nav-right">
        <li role="presentation"><a href="../concerts.php">concerts</a></li>
        <li role="presentation"><a href="../about.html">about</a></li>
      </ul>
    </div>

    <div class="concerts">
      <div class="categories categories-return">
        <a href="concerts.php" class="btn btn-danger btn-sml">Back to Shop</a>
      </div>
      <div class="concerts-info">

        <?php

        $servername = "matt-smith-v4.ics.uci.edu";
        $username = "inf124db040";
        $password = "!Qaz2wsx";
        $dbname = "inf124db040";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve artist name from url
        $artistName = $_GET['artist'];

        $sql = "SELECT concerts.concertID, headliners.name, date, venue, price, GROUP_CONCAT(artists.name) AS `lineup` FROM concerts, headliners, artists_in_lineup, artists WHERE concerts.concertID = headliners.concertID AND artists.artistID = artists_in_lineup.artistID AND artists_in_lineup.concertID = concerts.concertID AND headliners.name = '" . $artistName . "' GROUP BY concerts.concertID, headliners.name, concerts.date, concerts.venue, concerts.price";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          // create concertID variable for form submission
          $concertID = '';

          while($row = $result->fetch_assoc()) {
            // store $concertID
            $concertID .= $row["concertID"];
            // get image url from $name string
            $picname = str_replace(' ', '', strtolower($row["name"]));
            // get lineup array from $lineup
            $lineupArtists = explode(',', $row["lineup"]);

            echo "<img class=\"slideshow\" src=\"img/" . $picname . ".jpg\">";
            echo "<img class=\"slideshow\" src=\"img/" . $picname . "2.jpg\">";
            echo "<img class=\"slideshow\" src=\"img/" . $picname . "3.jpg\">";
            echo "<div class=\"concerts-info_details\">";
            echo "<h2>" . $row["name"] . "</h2>";
            echo "<h5>" . $row["date"] . "</h5>";
            echo "<h5>" . $row["venue"] . "</h5>";
            echo "<div class=\"concerts-info_lineup\">";
            echo "<h4>Lineup:</h4>";
            foreach($lineupArtists as $artist) {
              echo "<h5>" . $artist . "</h5>";
            }
            echo "</div>";
            echo "<h3>$" . $row["price"] . ".00</h3>";
            echo "</div>";
            echo "</div>";

          }

        }
        else {
          echo "0 results";
        }
        $conn->close();
        ?>

      <div class="concerts-info">
        <h2>Purchase Tickets</h2>
        <form name="ticketForm" action="sale.php" class="concerts-form" method="post" onsubmit="return validateForm()">
          (up to 5) Num of Tickets:<br>
          <select name="ticketnum" class="concerts-info_form">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
          <br><br>
          Phone Number:<br>
          <input class="concerts-info_form" type="text" name="phonenumber"><br>
          Email Address:<br>
          <input class="concerts-info_form" type="text" name="emailaddress" id="email"><br>
          <div id="suggestion-box"></div>
          Preferred delivery method:<br>
          <select class="concerts-info_form" name="deliverymethod">
            <option value="text">text</option>
            <option value="email">email</option>
            <option value="mail">mail</option>
          </select>
          <br><br>
          Street Address:<br>
          <input class="concerts-info_form" type="text" name="streetaddress"><br>
          City, State, ZIP:<br>
          <input class="concerts-info_form" type="text" name="citystatezip"><br>
          <br><br>
          Name on Card:<br>
          <input class="concerts-info_form" type="text" name="name"><br>
          Card Number:<br>
          <input class="concerts-info_form" type="text" name="cardnumber"><br>
          Exp Date:<br>
          <input class="concerts-info_form" type="text" name="cardexp"><br>
          Security Code:<br>
          <input class="concerts-info_form" type="text" name="cardsec"><br>
          <?php
          echo "<input type=\"hidden\" name=\"concert\" value=\"" . $concertID . "\">"
          ?>
          <br><br>
          <input class="concerts-info_form" type="submit">
        </form>
      </div>

    </div>


    <script>
    var slideIndex = 0;
    slideshow();

    function slideshow() {
      var i;
      var x = document.getElementsByClassName("slideshow");
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > x.length) {slideIndex = 1}
      x[slideIndex-1].style.display = "block";

      setTimeout(slideshow, 4000);
    }

    $(document).ready(function(){
      $('#email').focus();
    });

    $(document).ready(function() {
      $('#email').autocomplete({
        source: "suggestEmail.php"
      });
    });

    function validateForm() {
      var phone = document.forms["ticketForm"]["phonenumber"].value;
      if (isNaN(phone)) {
        alert("Please enter a numerical phone number.");
        return false;
      }

      var email = document.forms["ticketForm"]["emailaddress"].value;
      var reEmail = RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
      if (!reEmail.test(String(email).toLowerCase())) {
        alert("Please enter a valid email.");
        return false;
      }

      var address = document.forms["ticketForm"]["streetaddress"].value;
      var reAddress = RegExp(/^\s*\S+(?:\s+\S+){2}/);
      if (!reAddress.test(String(address).toLowerCase())) {
        alert("Please enter a valid street address.");
        return false;
      }

      var csz = document.forms["ticketForm"]["citystatezip"].value;
      var reCSZ = RegExp(/((\w+),\s)+(\d+)/);
      if (!reCSZ.test(String(csz).toLowerCase())) {
        alert("Please follow the format of City, State, Zip.");
        return false;
      }

      var name = document.forms["ticketForm"]["name"].value;
      var reName = RegExp(/\d/);
      if (reName.test(name)) {
        alert("Please enter your name as it appears on your card.")
        return false;
      }

      var cardNum = document.forms["ticketForm"]["cardnumber"].value;
      if (isNaN(cardNum)) {
        alert("Please enter your card number.");
        return false;
      }

      var cardNum = document.forms["ticketForm"]["cardnumber"].value;
      if (isNaN(cardNum)) {
        alert("Please enter your card number.");
        return false;
      }

      var cardExp = document.forms["ticketForm"]["cardexp"].value;
      var reExp = RegExp(/([0-9][0-9])\/([0-9][0-9])/);
      if (!reExp.test(cardExp)) {
        alert("Please enter your card expiration date like '12/12'.");
        return false;
      }

      var cardSec = document.forms["ticketForm"]["cardsec"].value;
      if (isNaN(cardNum) || cardSec.length > 3) {
        alert("Please enter your card security key.");
        return false;
      }
    }
    </script>

  </body>
</html>
