<?php
$hostname = "localhost";
$username = "root";
$password = "shivam";
$database = "rudra_675";

$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["create1"])) {
    require_once "admin_header.php";

    $dateType = $_POST['date_type'];
    $singleDate = $_POST['single_date'];
    $startDate = $_POST['start_date'];
       
    $endDate = $_POST['end_date'];


    if ($dateType === "Single Date") {
        $singleDate = $_POST['single_date'];
      
        $query = "SELECT * FROM rms WHERE date_time = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $singleDate);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } elseif ($dateType === "Date Range") {
        $startDate = $_POST['start_date'];
       
        $endDate = $_POST['end_date'];
       
        $query = "SELECT * FROM rms WHERE date_time BETWEEN ? AND ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $startDate, $endDate);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }

    echo '<table>';
    echo '<thead>';
    echo '<th>Serial Number</th>';
    echo '<th>ID</th>';
    echo '<th>Type</th>';
    echo '<th>Date and Time</th>';
    echo '<th>Full Detail</th>';
    echo '</thead>';
    echo '<tbody>';

    $serialNumber = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $serialNumber . '</td>';
        echo '<td>' . $row['Guest_ID'] . '</td>';
        echo '<td>' . $row['Courier_type'] . '</td>';
        echo '<td>' . $row['date_time'] . '</td>';

        $imagePath = "C:/xampp/htdocs/Rudraksha-main/cvms/photos/" . $row['image'];
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

        echo '<td><img src="' . $imageSrc . '" height="120"></td>';
        echo '</tr>';
        $serialNumber++;
    }

    echo '</tbody>';
    echo '</table>';
    
    // Generate PDF when the button is clicked
    echo '<form action="generate_pdf.php" method="post">';
    echo '<input type="hidden" name="date_type" value="' . $dateType . '">';
    echo '<input type="hidden" name="single_date" value="' . $singleDate . '">';
    echo '<input type="hidden" name="start_date" value="' . $startDate . '">';
    echo '<input type="hidden" name="end_date" value="' . $endDate . '">';
    echo '<button name="create2" id="g_pdf">Generate PDF</button>';
    echo '</form>';
}
?>

<style>
  #g_pdf{
    padding: 10px 20px;
  font-size: 16px;
  background-color: #4C489D;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  }
table {
    width: 97%;
    border-collapse: collapse;
    margin: 100px auto;
}
th, td {
    height: 50px;
    vertical-align: center;
    border: 3px solid black;
    text-align: center;
}
</style>


<script>
function showDateFields() {
  var dateType = document.getElementById("date_type").value;
  var singleDateField = document.getElementById("single_date_field");
  var dateRangeField = document.getElementById("date_range_field");
  
  if (dateType === "Single Date") {
    singleDateField.style.display = "block";
    dateRangeField.style.display = "none";
  } else if (dateType === "Date Range") {
    singleDateField.style.display = "none";
    dateRangeField.style.display = "block";
  }
}
window.addEventListener('DOMContentLoaded', function() {
  var table = document.getElementById('myTable');
  var rows = table.getElementsByTagName('tr');

  for (var i = 1; i < rows.length; i++) {
    var cell = document.createElement('td');
    cell.textContent = i;
    rows[i].insertBefore(cell, rows[i].firstChild);
  }
});
</script>
