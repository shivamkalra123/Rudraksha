<?php

require_once "dbconnection.php";



if (isset($_POST["submit"])) { 

    $filename = $_FILES['myfile']['name'];


    $destination = 'C:/xampp/htdocs/Rudraksha-main/cvms/insertion/uploads/' . $filename;

    
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

   
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        echo "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['myfile']['size'] > 1000000) { 
        echo "File too large!";
    } else {
        
        if (move_uploaded_file($file, $destination)) {
            $currentDateTime = new DateTime();
            $formattedDateTime = $currentDateTime->format("Y-m-d H:i:s");
            $cleanDateString = preg_replace("/[:-]/", "", $formattedDateTime);
            $result = "AP:" . $cleanDateString;
            $sql = "INSERT INTO files (name, size, downloads,AP_ID) VALUES ('$filename', $size, 0,'$result')";
            mysqli_query($conn,$sql);
        }
    }
   
}

$sql = "SELECT * FROM files f,recruitments r where f.AP_ID=r.AP_ID";
$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);


if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    
    $sql = "SELECT * FROM files f,recruitments r where f.AP_ID=r.AP_ID";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'C:/xampp/htdocs/Rudraksha-main/cvms/insertion/uploads/' . $file['name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('C:/xampp/htdocs/Rudraksha-main/cvms/insertion/uploads/' . $file['name']));
        readfile('C:/xampp/htdocs/Rudraksha-main/cvms/insertion/uploads/' . $file['name']);

        
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }

}
if (isset($_GET['file_id1'])) {
    $id = $_GET['file_id1'];
    $text1="Accepted";
            $sql = "update recruitments set selection='$text1' where id=$id";
          mysqli_query($conn,$sql);
}
if (isset($_GET['file_id2'])) {
    $id = $_GET['file_id2'];
    $text1="On:hold";
            $sql = "update recruitments set selection='$text1' where id=$id";
            mysqli_query($conn,$sql);
}
if (isset($_GET['file_id3'])) {
    $id = $_GET['file_id3'];
    $text1="Rejected";
            $sql = "update recruitments set selection='$text1' where id=$id";
            mysqli_query($conn,$sql);
}
if (isset($_GET['submit']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $filteredFiles = array_filter($files, function($file) use ($search) {
        return stripos($file['AP_ID'], $search) !== false;
    });
    
    
    if (!empty($filteredFiles)) {
        $files = $filteredFiles;
    } else {
       
        echo '<p>No matching files found.</p>';
    }
}
    
    





?>
