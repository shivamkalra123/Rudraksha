<?php
$hostname = "localhost";
$username = "root";
$password = "shivam";  
$database = "rudra_675";   
$conn=mysqli_connect($hostname,$username,$password,$database);    
?>  
<?php 
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];
    
    // Fetch data from the database based on the file_id
    $sql = "SELECT * FROM courier WHERE courier_id='$id'";
    $result = mysqli_query($conn, $sql);
  
    if ($result) {
      // Display the table
      echo '<table style="width: 100%; border-collapse: collapse; margin: 100px auto;">';
      echo '<tr>';
      echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Courier ID</th>';
      echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Courier Name</th>';
      echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Courier Type</th>';
      echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Courier From</th>';
      echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Courier To</th>';
      echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Gender</th>';
      echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Aquitance</th>';
      echo '<th style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">Remarks</th>';
  
      // Add more table headers as needed
      echo '</tr>';
  
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['courier_id'] . '</td>';
        echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['courier_name'] . '</td>';
        echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['courier_type'] . '</td>';
        echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['courier_from'] . '</td>';
        echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['courier_to'] . '</td>';
        echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['courier_gender'] . '</td>';
        echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['courier_aquitance'] . '</td>';
        echo '<td style="height: 50px; vertical-align: center; border: 3px solid purple; text-align: center;">' . $row['courier_remarks'] . '</td>';
  
        // Add more table cells as needed
        echo '</tr>';
      }
  
  
      echo '</table>';
    } 
  
    else {
      echo 'No results found.';
    }
  }
  

?>