<?php
 
ob_start();
include_once('assests/fpdf.php');
include "dbconnection.php";
if (isset($_POST['create'])){ 
   
   
    session_start();
    class PDF extends FPDF
    {
        public $serialNumber = 1;

        function Header()
        {
            $this->Image('download (1).png', 10, 10, 20);
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
            $this->Cell(80,10,'Resume Recieved Report',1,0,'C');

            $this->Ln(20);
        }

        function Footer()
        {
            $this->SetY(-15);

            $this->SetFont('Arial','I',8);

            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            $currentDateTime = new DateTime();
            $formattedDateTime = $currentDateTime->format("Y-m-d H:i:s");

            $this->SetFont('Arial','B',8);
            $this->Cell(0,10,$formattedDateTime,0,0,'R');
            if (isset($_SESSION['AdminLoginId'])) {
                $this->SetFont('Arial', 'B', 10);
                $this->SetX(40);
                $this->Cell(0, 10, 'Logged in as: ' . $_SESSION['AdminLoginId'], 0, 1, 'L');
                
            }
        }

        function addRow($data)
        {
            $this->SetFont('Arial', '', 8);
            $this->Cell(10, 10, $this->serialNumber, 1, 0, 'C');
            foreach ($data as $column) {
                $this->Cell(28, 10, $column, 1, 0, 'C');
            }
            $this->Ln();
            $this->serialNumber++; 
        }
    }

    $display_heading = array('first_name'=>'First Name', 'last_name'=> 'Last Name','age'=> 'Age', 'experience'=> 'Experience','designation'=> 'Designation','AP_ID'=> 'AP_ID','selection'=> 'Selection','vacc_type'=>'Vacc Type','first_dose'=>'First Dose','second_dose'=>'Second Dose');

    $result = mysqli_query($conn, "SELECT first_name, last_name,age,designation,experience,r.AP_ID,selection,vacc_type,first_dose,second_dose FROM recruitments r, files f where f.AP_ID=r.AP_ID") or die("database error:". mysqli_error($conn));
    $header = mysqli_query($conn, "SHOW columns FROM recruitments where field != 'id' and field != 'date' and field != 'middle_name' and  field != 'dob' and field != 'current_company'  and field != 'gender' and field != 'email' and field != 'father_name' and field != 'mother_name' and field != 'contact' and field != 'address1' and field != 'address2' and field != 'city' and field != 'pincode' and field != 'state' and field != 'education' and field != 'stream' and field != 'degree' and field != 'board_name' and field != 'college_name' and field!='uni_name' and field != 'vaccination' and field!='remarks'");

    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->SetLeftMargin(4); // Set left margin to 0
    $pdf->AddPage();

    $pdf->AliasNbPages();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, 'S.No', 1, 0, 'C');
    $pdf->SetFont('Arial','B',12);
    foreach($header as $heading) {
        $pdf->Cell(28,10,$display_heading[$heading['Field']],1,'','C');
    }
    foreach($result as $row) {
        $pdf->SetFont('Arial','',8);
        $pdf->Ln();
        foreach ($result as $row) {
            $pdf->addRow($row);
        }
        // $pdf->Cell(10, 10, $pdf->serialNumber, 1, 0, 'C');
        // foreach($row as $column)
            // $pdf->Cell(28,10,$column,1,'','C');
    }

    $pdf->Output();
     
    ob_end_flush(); 
}
?>
