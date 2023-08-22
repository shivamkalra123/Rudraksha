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

        // Query to retrieve the count of graduates
        $query = "SELECT college_graduation, COUNT(*) AS count FROM graduation,admin,joining where admin.job_location=joining.job_location GROUP BY college_graduation";
        $result = $conn->query($query);
        
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['college_graduation']] = $row['count'];
        }

        // Close the connection
        $conn->close();
    ?>
  
<!DOCTYPE html>
<html>
<head>
    <title>Graduation and Joining Count</title>
    <script type="module" src="https://cdn.jsdelivr.net/npm/html2canvas"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'college_graduation');
            data.addColumn('number', 'Count');

            data.addRows([
                <?php foreach ($data as $college_graduation => $count) {
                    echo "['" . $college_graduation . "', " . $count . "],";
                } ?>
            ]);

            var options = {
                title: 'college_graduation Distribution',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
        function generatePDF() {
    var doc = new jsPDF('landscape');
    var pageWidth = doc.internal.pageSize.getWidth();
    var pageHeight = doc.internal.pageSize.getHeight() + 450;

    // Set the font size and add the header text
    var textWidth = doc.getStringUnitWidth('RUDRAKSHA WELFARE FOUNDATION') * doc.internal.getFontSize() / doc.internal.scaleFactor;

    // Calculate the box dimensions
    var boxWidth = textWidth + 25; // Add some padding
    var boxHeight = 20;

    // Calculate the starting point for the box
    var x = (doc.internal.pageSize.getWidth() - boxWidth) / 2; // Center horizontally
    var y = 10; // Adjust the Y-coordinate as needed

    // Draw the box
    var textWidth = doc.getStringUnitWidth('Employee Graduate Report') * doc.internal.getFontSize() / doc.internal.scaleFactor;
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
    doc.text('Gender Report', x + 35, y + 30);

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
            margin:0;
            overflow:hidden;
        }
        #piechart {
            width: 1000px;
            height: 1000px;
        
           
            
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
<?php include "C:/xampp/htdocs/Rudraksha-main/admin-navbar.php"?>
 
 
    <button class="a" onclick="generatePDF()">Generate PDF</button>
    <div id="content">
        <div id="piechart"></div>
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
  
</body>
</html>
