<?php
// Assuming you have a database connection
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'shivam';
$dbName = 'rudra_675';

// Create a connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // Prepare the SQL statement with a placeholder for the ID
    $sql = "SELECT Guest_ID, Courier_type, date_time, image FROM rms WHERE Guest_ID = ?";
    
    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the ID parameter to the prepared statement
    $stmt->bind_param("i", $id);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the data from the first row (assuming there's only one row)
        $row = $result->fetch_assoc();
        $guestID = $row['Guest_ID'];
        $courierType = $row['Courier_type'];
        $dateTime = $row['date_time'];
        $imageData = $row['image'];

        // Generate a unique filename for the downloaded image
        $filename = 'downloaded_image_' . $guestID . '_' . $courierType . '_' . $dateTime . '.jpg';

        // Set the appropriate headers for download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Output the image data
        echo $imageData;
    } else {
        echo "No image found in the database.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database
