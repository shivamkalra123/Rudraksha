<?php
$hostname = "localhost";
$username = "root";
$password = "shivam";  
$database = "rudra_675";   
$conn=mysqli_connect($hostname,$username,$password,$database);    
?>   
<?php
// display_table.php
$sql = "SELECT * FROM rms";
$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);
foreach ($files as $file) {
    $courier = $file["Courier_type"];
    // Use the $courier value as needed
}

// Assuming you have a database connection established in this file
// Retrieve the file_id from the URL parameter
if (isset($_GET['file_id'])) {
  $id = $_GET['file_id'];
 
  // Fetch data from the database based on the file_id
  $sql = "SELECT * FROM guest WHERE guest_id='$id'";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    // Display the table
    echo '<table style="width: 100%; border-collapse: collapse; margin: 100px auto;">';
    echo '<tr>';
    echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Guest ID</th>';
    echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Guest Name</th>';
    echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Guest Phone</th>';
    echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Aquitances</th>';
    echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Guest Meet</th>';
    echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Other</th>';
    echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Purpose</th>';
    echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Remarks</th>';
    echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Gender</th>';
    echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Image</th>';
    // Add more table headers as needed
    echo '</tr>';

    while ($row = mysqli_fetch_assoc($result)) {
      echo '<tr>';
      echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['guest_id'] . '</td>';
      echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['guest_name'] . '</td>';
      echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['guest_phone'] . '</td>';
      echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['guest_aquitance'] . '</td>';
      echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['guest_meet'] . '</td>';
      echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['other_name'] . '</td>';
      echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['purpose'] . '</td>';
      echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['remarks'] . '</td>';
      echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['guest_gender'] . '</td>';
      echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;"><img src="' . $row['guest_image'] . '" alt="Guest Image" style="max-width: 100px; max-height: 100px;"></td>';

      // Add more table cells as needed
      echo '</tr>';
    }
    echo '</table>';
  } 
}

  else {
    echo 'No results found.';
  }



?>
