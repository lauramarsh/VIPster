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
        <li role="presentation" class="active"><a href="#">concerts</a></li>
        <li role="presentation"><a href="about.html">about</a></li>
      </ul>
    </div>

    <div class="concerts">
      <div class="categories">
        <h5>Categories</h5>
      </div>
      <div class="listings">
        <h2>Concerts</h2>
        <table class="table table-dark">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Artist</th>
              <th scope="col">Date</th>
              <th scope="col">Venue</th>
              <th scope="col">Price</th>
            </tr>
          </thead>

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
          $sql = "SELECT headliners.name, date, venue, price FROM concerts, headliners, artists_in_lineup, artists WHERE concerts.concertID = headliners.concertID GROUP BY headliners.name, date, venue, price";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {

            // table body html
            echo "<tbody>";

            // output data of each row
            while($row = $result->fetch_assoc()) {
              // get image url from $name string
              $picname = str_replace(' ', '', strtolower($row["name"]));

              echo "<tr>";
              echo "<td scope=\"row\"><a href=\"concertPage.php?artist=" . $row["name"] . "\"><img src=\"img/" . $picname . ".jpg\" class=\"img-thumbnail\"></a></td>";
              echo "<td>" . $row["name"] . "</td>";
              echo "<td>" . $row["date"] . "</td>";
              echo "<td>" . $row["venue"] . "</td>";
              echo "<td>$" . $row["price"] . "</td>";
              echo "</tr>";
            }
            echo "</tbody>";
          }
          else {
            echo "0 results";
          }
          $conn->close();
          ?>

        </table>
      </div>
    </div>

  </body>
</html>
