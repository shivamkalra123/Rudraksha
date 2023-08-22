<?php
// Include the FPDF library
require('C:/xampp/htdocs/Rudraksha-main/cvms/employee/assests/fpdf.php');
require('dataconnect.php');

// Assuming you have established a database connection
// ...

if(isset($_GET['id'])){
// Fetch employee data from the database
$id = $_GET['id'];

$query = "SELECT j.*,s.*,g.* FROM skills s INNER JOIN joining j ON s.Pancard = j.pancard INNER JOIN graduation g ON g.pancard = j.pancard and j.id='$id'";
$result = mysqli_query($conn, $query);
$employees = [];


// Check if records were found
if (mysqli_num_rows($result) > 0) {
    // Loop through each employee record
    while ($employee = mysqli_fetch_assoc($result)) {
        // Generate a unique filename for the employee report
       
       
        // Generate the PDF report using FPDF
        $pdf = new FPDF('L');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pageWidth = $pdf->GetPageWidth();

// Add report title
$pdf->Image('C:/xampp/htdocs/Rudraksha-main/cvms/insertion/download (1).png', 10, 10, 20, 0, 'PNG');
$pdf->SetFont('Arial','B',12);
            $pdf->SetY(10);
            $pdf->Cell(0, 5, 'RUDRAKSHA WELFARE FOUNDATION', 0, 1, 'C');
            $pdf->SetX(60);
            $pdf->Cell(0, 5, 'A Section 8 Non Profit Organisation under Ministry of Corporate Affairs, Govt. Of INDIA', 0, 1, 'L');
            $pdf->SetX(30);

            $pdf->SetFont('Arial','B',13);

            $pdf->Cell(100);
            $pdf->Ln(5);
            $pdf->SetX(100);
            $pdf->Cell(80,10,'Employee Report',1,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'BU', 16);
        $pdf->setY(45);
        $pdf->Cell(20, 10, 'Personal Information', 0, 1, 'L');
        
        $pdf->SetFont('Arial', 'B', 12); // Set font style for table header

        // Table headers
      
        $pdf->Ln(); // Move to the next line
        
        $pdf->SetFont('Arial', '', 12); // Set font style for table content
        
        $data = array(
            'Name' => $employee['candidate_name'],
            'Date Of Birth' => $employee['candidate_dob'],
            'Guardian/Father Name' => $employee['guardian_name'],
            'Guardian/Father Occupation' => $employee['father_occupation'],
            'Mother Name' => $employee['mother_name'],
            'Mother Occupation' => $employee['mother_occupation'],
            'Phone' => $employee['phone'],
            'Alternate Phone' => $employee['alt_phone'],
            'Email' => $employee['email'],
            'Permanent Address' => $employee['permanent_add'],
            'Gender' => $employee['gender'],
        );
        
        // Table rows
        foreach ($data as $field => $value) {
            $pdf->Cell(90, 10, $field, 1);
            $pdf->Cell(90, 10, $value, 1);
            $pdf->Ln(); // Move to the next line
        }
        
        $pdf->SetLineWidth(0.2);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 270, $pdf->GetY());
        $pdf->Ln(9);
        $pdf->SetFont('Arial', 'BU', 16);
        $pdf->Cell(20, 10, 'Education Qualification', 0, 1, 'L');
        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 12);
     
       
        
        $pdf->SetFont('Arial', '', 12); // Set font style for table content
        
        $data = array(
            'Secondary School Name' => $employee['sec_school_name'],
            'Secondary School Address' => $employee['sec_school_add'],
            'Secondary School Pass Year' => $employee['sec_school_pass_year'],
            'Secondary School Marks' => $employee['sec_school_percentage'],
            'High School Name' => $employee['high_school_name'],
    'High School Address' => $employee['high_school_add'],
    'High School Pass Year' => $employee['high_school_pass_year'],
    'High School Marks' => $employee['high_school_percentage'],
    'Graduation College' => $employee['college_name'],
    'Graduation Degree' => $employee['college_degree'],
    'Graduation Start Year' => $employee['college_start_year'],
    'Graduation End Year' => $employee['college_end_year'],
    'Skill Name' => $employee['skill_name'],
    'Skill Institute' => $employee['skill_institution'],
    'Skill Start Date' => $employee['start_date'],
    'Skill End Date' => $employee['end_date'],
        );
        
        // Table rows for Secondary School
        foreach ($data as $field => $value) {
            $pdf->Cell(90, 10, $field, 1);
            $pdf->Cell(90, 10, $value, 1);
            $pdf->Ln(); // Move to the next line
        }
        
      
          
       
        $pdf->SetLineWidth(0.2);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 270, $pdf->GetY());
        $pdf->SetFont('Arial', 'BU', 16);
        $pdf->Ln(10);
       
        $pdf->Cell(20, 10, 'Work Experience ', 0, 1, 'L');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', 12,'C');
        $pdf->SetFont('Arial', '', 12); // Set font style for table content

        $data = array(
            'Company Name' => $employee['company_name'],
            'Designation' => $employee['designation'],
            'Department' => $employee['department'],
            'Office Address' => $employee['off_address'],
            'Start Date' => $employee['start_date'],
            'End Date' => $employee['end_date'],
            'CTC' => $employee['CTC'],
            'Monthly' => $employee['monthly'],
    'Take Home Salary' => $employee['take_home_salary'],
    'Date Of Resignation' => $employee['date_resignation'],
    'NTP' => $employee['NTP'],
    'Date Of Relieving' => $employee['Date_of_Relieving'],
    'Reason' => $employee['Reason'],
    'Remarks' => $employee['remarks'],
        );
        
        // Table rows for Employment Details
        foreach ($data as $field => $value) {
            $pdf->Cell(90, 10, $field, 1,0);
            $pdf->Cell(90, 10, $value, 1,0);
            $pdf->Ln(); // Move to the next line
        }
     
        
        
        // Output the PDF to a specific directory
        $pdf->Output();
    }
} else {
    // No records found
    echo "No employee records found.";
}


// Close the database connection
mysqli_close($conn);
}
?>
