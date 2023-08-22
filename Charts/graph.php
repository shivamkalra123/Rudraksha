<?php
session_start();
// Retrieve data from MySQL
$servername = "localhost";
$username = "root";
$password = "shivam";
$dbname = "rudra_675";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentDate = date('Y-m-d');

// Generate the options for the dropdown
$options = [
    'week' => date('Y-m-d', strtotime('-1 week', strtotime($currentDate))),
    'month' => date('Y-m-d', strtotime('-1 month', strtotime($currentDate))),
    'quarter' => date('Y-m-d', strtotime('-3 months', strtotime($currentDate))),
    'year' => date('Y-m-d', strtotime('-1 year', strtotime($currentDate))),
];

// Use the selected interval in your MySQL query
$selectedInterval = isset($_POST['interval']) ? $_POST['interval'] : 'week';

// Close the connection

$query = "SELECT gender, COUNT(*) as count FROM joining WHERE start_date >= '$options[$selectedInterval]' GROUP BY gender ";

$result = $conn->query($query);

// Prepare data for the pie chart
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[$row['gender']] = $row['count'];
}

// Generate the pie chart
$chartData = "['Gender', 'Count'],";
foreach ($data as $gender => $count) {
    $chartData .= "['" . $gender . "', " . $count . "],";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>   
    <script type="module" src="https://cdn.jsdelivr.net/npm/html2canvas"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
            

    </style>
      <script type="module" src="https://cdn.jsdelivr.net/npm/html2canvas"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
       <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                <?php echo $chartData; ?>
            ]);

            var options = {
                title: 'Male and Female Distribution',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
        function generatePDF() {
            var doc = new jsPDF('landscape', 'mm', 'a4');
    var pageWidth = doc.internal.pageSize.getWidth();
  var pageHeight = doc.internal.pageSize.getHeight() + 1050; 
 

    // Set the font size and add the header text
    var textWidth = doc.getStringUnitWidth('RUDRAKSHA WELFARE FOUNDATION') * doc.internal.getFontSize() / doc.internal.scaleFactor;

    // Calculate the box dimensions
    var boxWidth = textWidth + 25; // Add some padding
    var boxHeight = 20;

    // Calculate the starting point for the box
    var x = (doc.internal.pageSize.getWidth() - boxWidth) / 2; // Center horizontally
    var y = 10; // Adjust the Y-coordinate as needed

    // Draw the box
    var textWidth = doc.getStringUnitWidth('Gender Report') * doc.internal.getFontSize() / doc.internal.scaleFactor;
    var rectWidth = textWidth + 8; // Add some padding
    var rectHeight = 15;

    // Calculate the starting point for the rectangle
    var rectX = 115; // Adjusted X-coordinate to align with the text
    var rectY = 40 - 9; // Adjusted Y-coordinate to align with the text

    // Draw the rectangle
    doc.setFontSize(18);
    // Add the text inside the box
    doc.text('RUDRAKSHA WELFARE FOUNDATION', x + 5, y + 8);
    doc.setFontSize(12);
    doc.text('A Section 8 Non Profit Organisation under Ministry of Corporate Affairs, Govt. Of INDIA', x - 25, y + 15);
    doc.setFontSize(14);
    doc.rect(rectX, rectY, rectWidth, rectHeight);
    doc.text('Employee Gender Report', x + 35, y + 30);

    // Load the logo image
    var logoImg = new Image();
    logoImg.src = 'https://media.licdn.com/dms/image/C4D0BAQH4od9HG2K7bw/company-logo_200_200/0/1661484397513?e=2147483647&v=beta&t=Fjcwl5mywA_9FtdgJTX6v9US4EI4pAi5j24FCw7xefs';

    logoImg.onload = function() {
        var logoWidth = 40; // Adjust the logo width as needed
        var logoHeight = logoWidth * (logoImg.height / logoImg.width);

        // Add the logo to the PDF
        doc.addImage(logoImg, 'PNG', 10, 5, 25, 25);

        // Capture the HTML content using HTML2Canvas
      html2canvas(document.getElementById('content')).then(function(canvas) {
        // Convert the canvas to an image and add it to the PDF document
        var imgData = canvas.toDataURL('image/png');
        doc.addImage(imgData, 'PNG', 50, 50, 300, 340);

        // Add the "Logged in as" text
        var adminText = 'Logged in as: <?php echo $_SESSION['AdminLoginId']; ?>';
        doc.setFontSize(12);
        doc.text(adminText, 20, 200);
        doc.text('Page 1/1',140,200);
        var time='<?php echo $currentDate ?>';
        doc.text(time,260,200);
        // Add the black border
        doc.setLineWidth(1); // Border width
        doc.rect(5, 2, pageWidth - 10, pageHeight - 10); // Draw the border

        // Save the PDF
        doc.save('chart.pdf');
    });
    }
}

    </script>
    
      <style>
        body{
          margin:0px;
          overflow:hidden;
         
        }
        #piechart {
            width: 1000px;
            height: 1000px;
            display: flex;
  justify-content: center;
            
        }
        form{
            position:absolute;
            left:80%;
        }
        select{
            width: 100%;
      padding: 5px;
        }
        input{
            padding: 10px 15px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
      margin:10px;
        }
        button.a{
            position:absolute;
            left:86%;
            top:30%;
            
            background-color: transparent;
    border: 2px solid blue;
    border-radius: 5px;
    color: black;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
        }
        .a:hover{
            background-color:blue;
            color:white;
        }
    </style>
</head>
<body>

   
</head>

<body>

<?php include "C:/xampp/htdocs/Rudraksha-main/admin-navbar.php"?>
<form method="post" action="">
        <label for="interval">Select Interval:</label>
        <br>
        <select name="interval" id="interval">
            <option value="week" <?php if ($selectedInterval === 'week') echo 'selected'; ?>>One Week</option>
            <option value="month" <?php if ($selectedInterval === 'month') echo 'selected'; ?>>One Month</option>
            <option value="quarter" <?php if ($selectedInterval === 'quarter') echo 'selected'; ?>>One Quarter</option>
            <option value="year" <?php if ($selectedInterval === 'year') echo 'selected'; ?>>One Year</option>
        </select>
        <input type="submit" value="Submit" name="submit">
    </form>


    
    
    
    <button class="a" onclick="generatePDF()">Generate PDF</button>
    <div id="content">
    <div id="piechart">
   
    </div>
    <?php echo 'Logged in as: ' . $_SESSION['AdminLoginId'] ?>;
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
      
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        
    </div>
    
    <script>
        // Prepare the data for the chart
      

        
    </script>
</body>
</html>

