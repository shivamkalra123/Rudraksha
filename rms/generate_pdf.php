<?php
$hostname = "localhost";
$username = "root";
$password = "shivam";  
$database = "rudra_675";   
$conn=mysqli_connect($hostname,$username,$password,$database);    
?>  
<?php

ob_start();

if (isset($_POST['create2'])){ 
    session_start();
    include_once('C:/xampp/htdocs/Rudraksha-main/cvms/insertion/assests/fpdf.php');
    $dateType = $_POST['date_type'];
    var_dump($dateType);
    class PDF extends FPDF
    {
        public $serialNumber = 1;

        function Header()
        {
            $this->Image('C:/xampp/htdocs/Rudraksha-main/cvms/insertion/download (1).png', 10, 10, 20);
            $this->SetFont('Arial','B',12);
            $this->SetY(14);
            $this->Cell(0, 5, 'RUDRAKSHA WELFARE FOUNDATION', 0, 1, 'C');
            $this->SetX(60);
            $this->Cell(0, 5, 'A Section 8 Non Profit Organisation under Ministry of Corporate Affairs, Govt. Of INDIA', 0, 1, 'L');
            $this->SetX(30);

            $this->SetX(30);

            $this->SetFont('Arial','B',13);

            $this->Cell(100);
            $this->Ln(5);
            $this->SetX(100);
            $this->Cell(100,10,'Receiption Management System Report',1,0,'C');

            $this->Ln(20);
            $dateType = $_POST['date_type'];
            if($dateType === "Single Date"){
                $singleDate = $_POST['single_date'];
                $this->SetFont('Arial','I',10);
                $this->SetX(250);
                $this->Cell(0, 5, $singleDate, 0, 1, 'L');


            }
            if($dateType === "Date Range"){
                $startDate = $_POST['start_date'];
                $endDate = $_POST['end_date'];
                $this->SetFont('Arial','I',10);
                $this->SetX(250);
                $this->Cell(0, 5, ' ' . $startDate . ' - ' . $endDate . ' ', 0, 1, 'L');
            



            }
        }

        function Footer()
        {
            $this->SetY(-15);

            $this->SetFont('Arial','I',8);

            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            $timeZone = new DateTimeZone('Asia/Kolkata');
            $currentDateTime = new DateTime('now', $timeZone);
            $formattedDateTime = $currentDateTime->format("Y-m-d H:i:s");

            $this->SetFont('Arial','B',8);
            $this->Cell(0,10,$formattedDateTime,0,0,'R');
            if (isset($_SESSION['username'])) {
                $this->SetFont('Arial', 'B', 10);
                $this->SetX(40);
                $this->Cell(0, 10, 'Logged in as: ' . $_SESSION['username'], 0, 1, 'L');
            }
        }
        
        static function DisplayImage($pdf, $imagePath, $x, $y)
        {
            $pdf->Image($imagePath, $x, $y, 30, 30);
        }
        
      
    }
  

  
   
    
    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->SetLeftMargin(4); // Set left margin to 0
    $pdf->AddPage();
    if ($dateType === "Single Date") {
        $singleDate = $_POST['single_date'];
        $query = mysqli_query($conn, "SELECT rms.Guest_ID, guest.guest_name, guest.guest_phone, guest.guest_aquitance, guest.guest_gender, guest.guest_meet, guest.other_name, guest.remarks, courier.courier_name, courier.courier_to, courier.courier_from, courier.courier_gender, courier.courier_aquitance, courier.courier_remarks
            FROM rms
            LEFT JOIN guest ON rms.Guest_ID = guest.guest_id
            LEFT JOIN courier ON rms.Guest_ID = courier.courier_id WHERE rms.date_time = '$singleDate'") or die("database error:" . mysqli_error($conn));

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Ln();

        $headers = array(
            'Guest ID',
            'Guest Name',
            'Phone',
            'G_Acq',
            'Gender',
            'Meet',
            'Other Name',
            'Remarks',
            'Name',
            'To',
            'From',
            'Gender',
            'C_Acq',
            'Remarks',
            
        );

        foreach ($headers as $index => $header) {
            if ($index == 0) {
                $pdf->SetTextColor(204, 51, 139, 1.00);
                $pdf->Cell(30, 10, $header, 1, '', 'C');

              } 
            else {
                $pdf->SetTextColor(204, 51, 139, 1.00);
                $pdf->Cell(18.5, 10, $header, 1, '', 'C');
            }
        }

        $counter = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $pdf->SetFont('Arial', '', 8);
            $pdf->Ln();
        
            foreach ($row as $columnName => $columnValue) {
                if ($counter == 0) {
                    $pdf->SetFont('Arial', '', 8);
        
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->Cell(30, 10, $columnValue, 1, '', 'C'); // Modify the dimensions for the first column
                } else {
                    // Add "Mr." or "Ms." based on gender
                    if ($columnName === 'guest_name') {
                        $gender = $row['guest_gender'];
                        $salutation = $gender === 'Male' ? 'Mr.' : 'Ms.';
                        $columnValue = $salutation . ' ' . $columnValue;
                    }
                    $pdf->Cell(18.5, 10, $columnValue, 1, '', 'C'); // Use the default dimensions for the rest of the columns
                }
                $counter++;
            }
            $counter = 0;

        }

    
        $pdf->Output('RMS_Report.pdf', 'D');
    }
    
    elseif ($dateType === "Date Range") {
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $query = mysqli_query($conn, "SELECT rms.Guest_ID, guest.guest_name, guest.guest_phone,guest.guest_aquitance,guest.guest_gender,guest.guest_meet,guest.other_name,guest.remarks,courier.courier_name,courier.courier_to,courier.courier_from,courier.courier_gender,courier.courier_aquitance,courier.courier_remarks
FROM rms
LEFT JOIN guest ON rms.Guest_ID = guest.guest_id
LEFT JOIN courier ON rms.Guest_ID = courier.courier_id where rms.date_time >= '$startDate' AND rms.date_time <= '$endDate';
");
    
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln();

$headers = array(
    'Guest ID',
    'Guest Name',
    'Phone',
    'G_Acq',
    'Gender',
    'Meet',
    'Other Name',
    'Remarks',
    'Name',
  
    'To',
    'From',
    'Gender',
    'C_Acq',
    'Remarks',
   
    
);
foreach ($headers as $index => $header) {
    if ($index == 0) {
        $pdf->SetTextColor(204, 51, 139, 1.00);
        $pdf->Cell(30, 10, $header, 1, '', 'C');

      } 
    else {
        $pdf->SetTextColor(204, 51, 139, 1.00);
        $pdf->Cell(18.5, 10, $header, 1, '', 'C');
    }
}

$counter = 0; // Initialize a counter variable

while ($row = mysqli_fetch_assoc($query)) {
    $pdf->SetFont('Arial', '', 8);
    $pdf->Ln();

    foreach ($row as $columnName => $columnValue) {
        if ($counter == 0) {
            $pdf->SetFont('Arial', '', 8);

            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(30, 10, $columnValue, 1, '', 'C'); // Modify the dimensions for the first column
        } else {
            // Add "Mr." or "Ms." based on gender
            if ($columnName === 'guest_name') {
                $gender = $row['guest_gender'];
                $salutation = $gender === 'Male' ? 'Mr.' : 'Ms.';
                $columnValue = $salutation . ' ' . $columnValue;
            }
            $pdf->Cell(18.5, 10, $columnValue, 1, '', 'C'); // Use the default dimensions for the rest of the columns
        }
        $counter++;
    }
    $counter = 0; // Reset the counter for each row
// Reset the counter for each row

    // Check if the row has image data
}
$pdf->Output('RMS_Report.pdf', 'D');
}



    
}
?>
