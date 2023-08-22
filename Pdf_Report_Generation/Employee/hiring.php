<?php
// Include the FPDF library
require ("C:/xampp/htdocs/Rudraksha-main/cvms/RMS_admin/admin_header.php");
require('dataconnect.php');
include "logic.php";

// Assuming you have established a database connection
// ...

// Fetch employee data from the database
$query = "SELECT * FROM joining";
$result = mysqli_query($conn, $query);

// Initialize the employees array
$employees = [];

// Check if records were found
if (mysqli_num_rows($result) > 0) {
    // Loop through each employee record
    while ($employee = mysqli_fetch_assoc($result)) {
        // Add the employee record to the employees array
        $employees[] = $employee;
    }
} else {
    // No records found
    echo "No employee records found.";
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Reports</title>
    <style>

table {
    width: 80%;
    border-collapse: collapse;
    margin: 100px auto;
  }
  th,
  td {
    height: 50px;
    vertical-align: center;
    border: 3px solid purple;
    text-align:center;
  }
    </style>
</head>
<body>
    <h1>Employee Reports</h1>

    <?php if (!empty($employees)) { ?>
<table>
<thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company Name</th>
                    <th>Designation</th>
                    <th>Department Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Download Report</th>
                </tr>
</thead>
<tbody>
                <?php foreach ($employees as $employee) { ?>
      <tr>
                        <td><?php echo $employee['candidate_name']; ?></td>
                        <td><?php echo $employee['email']; ?></td>
                        <td><?php echo $employee['company_name']; ?></td>
                        <td><?php echo $employee['designation']; ?></td>
                        <td><?php echo $employee['Department_name']; ?></td>
                        <td><?php echo $employee['start_date']; ?></td>
                        <td><?php echo $employee['end_date']; ?></td>
                        <td>
                            <a href="hiring.php?id=<?php echo $employee['id']; ?>">Download</a>
                        </td>
    </tr>
                <?php } ?>
</tbody>
</table>
    <?php } else {
        echo "No employee records found.";
    } ?>
</body>
</html>
