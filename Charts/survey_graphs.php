<?php include 'header.php' ?>
<?php
// Retrieve data from MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rudra_675";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$currentDate = date('Y-m-d');
if(isset($_POST["submit"])){
// Use the selected interval in your MySQL query
$interval=$_POST["interval"];

// Close the connection
if($_POST["interval"]==="teacups"){
$query = "SELECT teacups_perday, COUNT(*) as count FROM survey  GROUP BY teacups_perday ";

$result = $conn->query($query);

// Prepare data for the pie chart
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[$row['teacups_perday']] = $row['count'];
}

// Generate the pie chart
$chartData = "['Gender', 'Count'],";
foreach ($data as $gender => $count) {
    $chartData .= "['" . $gender . "', " . $count . "],";
}
}
if($_POST["interval"]==="quality"){
    $query = "SELECT quality_product, COUNT(*) as count FROM survey  GROUP BY quality_product ";
    
    $result = $conn->query($query);
    
    // Prepare data for the pie chart
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[$row['quality_product']] = $row['count'];
    }
    
    // Generate the pie chart
    $chartData = "['Gender', 'Count'],";
    foreach ($data as $gender => $count) {
        $chartData .= "['" . $gender . "', " . $count . "],";
    }
    }
    if($_POST["interval"]==="price"){
        $query = "SELECT price_perkg, COUNT(*) as count FROM survey  GROUP BY price_perkg ";
        
        $result = $conn->query($query);
        
        // Prepare data for the pie chart
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row['price_perkg']] = $row['count'];
        }
        
        // Generate the pie chart
        $chartData = "['Gender', 'Count'],";
        foreach ($data as $gender => $count) {
            $chartData .= "['" . $gender . "', " . $count . "],";
        }
        }
        if($_POST["interval"]==="quantity"){
            $query = "SELECT quantity_permonth, COUNT(*) as count FROM survey  GROUP BY quantity_permonth ";
            
            $result = $conn->query($query);
            
            // Prepare data for the pie chart
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[$row['quantity_permonth']] = $row['count'];
            }
            
            // Generate the pie chart
            $chartData = "['Gender', 'Count'],";
            foreach ($data as $gender => $count) {
                $chartData .= "['" . $gender . "', " . $count . "],";
            }
            }
            if($_POST["interval"]==="taste"){
                $query = "SELECT taste, COUNT(*) as count FROM survey  GROUP BY taste ";
                
                $result = $conn->query($query);
                
                // Prepare data for the pie chart
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[$row['taste']] = $row['count'];
                }
                
                // Generate the pie chart
                $chartData = "['Gender', 'Count'],";
                foreach ($data as $gender => $count) {
                    $chartData .= "['" . $gender . "', " . $count . "],";
                }
                }
                if($_POST["interval"]==="gift"){
                    $query = "SELECT gift, COUNT(*) as count FROM survey  GROUP BY gift ";
                    
                    $result = $conn->query($query);
                    
                    // Prepare data for the pie chart
                    $data = array();
                    while ($row = $result->fetch_assoc()) {
                        $data[$row['gift']] = $row['count'];
                    }
                    
                    // Generate the pie chart
                    $chartData = "['Gender', 'Count'],";
                    foreach ($data as $gender => $count) {
                        $chartData .= "['" . $gender . "', " . $count . "],";
                    }
                    }
          
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
    <link rel="stylesheet" href="../style.css">
    </style>
    <script type="module" src="https://cdn.jsdelivr.net/npm/html2canvas"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                <?php echo $chartData; ?>
            ]);

            <?php if($_POST["interval"]==="teacups"){ ?>
            var options = {
                title: 'Tea Cups Per Day',
                is3D: true,
            };
            <?php }?>
            <?php if($_POST["interval"]==="quality"){ ?>
            var options = {
                title: 'Quality Product',
                is3D: true,
            };
            <?php }?>
            <?php if($_POST["interval"]==="price"){ ?>
            var options = {
                title: 'Price Per Kg',
                is3D: true,
            };
            <?php }?>
            <?php if($_POST["interval"]==="quantity"){ ?>
            var options = {
                title: 'Quantity Per Month',
                is3D: true,
            };
            <?php }?>
            <?php if($_POST["interval"]==="taste"){ ?>
            var options = {
                title: 'Taste',
                is3D: true,
            };
            <?php }?>
            <?php if($_POST["interval"]==="gift"){ ?>
            var options = {
                title: 'Gifts',
                is3D: true,
            };
            <?php }?>

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
            var textWidth = doc.getStringUnitWidth('Interview Gender Report') * doc.internal.getFontSize() / doc.internal.scaleFactor;
            var rectWidth = textWidth + 15; // Add some padding
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
            doc.setFontSize(18);
            <?php if($_POST["interval"]==="teacups"){ ?>
                doc.rect(rectX, rectY, 65, 15);
   doc.text('Tea Cups Per Days',x+35,y+30);
<?php }?>
<?php if($_POST["interval"]==="quality"){ ?>
    doc.rect(rectX, rectY, 54, 15);
  doc.text('Quality Product',x+35,y+30);
<?php }?>
<?php if($_POST["interval"]==="price"){ ?>
    doc.rect(rectX, rectY, 54, 15);
  doc.text('Price Per Kg',x+35,y+30);
<?php }?>
<?php if($_POST["interval"]==="quantity"){ ?>
    doc.rect(rectX, rectY, 62, 15);
  doc.text('Quantity Per Month',x+35,y+30);
<?php }?>
<?php if($_POST["interval"]==="taste"){ ?>
    doc.rect(rectX, rectY, 70, 15);
  doc.text('Taste Survey Report',x+35,y+30);
<?php }?>
<?php 
if($_POST["interval"]==="gift"){ ?>
      doc.rect(rectX, rectY, 58, 15);
  doc.text('Freebees Report',x+35,y+30);
<?php }?>

            // Load the logo image
            var logoImg = new Image();
            logoImg.src = 'https://media.licdn.com/dms/image/C4D0BAQH4od9HG2K7bw/company-logo_200_200/0/1661484397513?e=2147483647&v=beta&t=Fjcwl5mywA_9FtdgJTX6v9US4EI4pAi5j24FCw7xefs';

            logoImg.onload = function() {
                var logoWidth = 40; // Adjust the logo width as needed
                var logoHeight = logoWidth * (logoImg.height / logoImg.width);

                // Add the logo to the PDF
                doc.addImage(logoImg, 'PNG', 10, 5, 25, 25);
                // Capture the HTML content using HTML2Canvas
                html2canvas(document.getElementById('content1')).then(function(canvas) {

                    // Create a new PDF document


                    // Convert the canvas to an image and add it to the PDF document
                    var imgData = canvas.toDataURL('image/png');
        doc.addImage(imgData, 'PNG', 30, 50, 420, 450);
        doc.setFontSize(12);
        doc.text('Page 1/1',140,200);
        doc.setFontSize(12);
        var time='<?php echo $currentDate ?>';
        doc.text(time,260,200);
        // Add the black border
        doc.setLineWidth(1); // Border width
        doc.rect(5, 2, pageWidth - 10, 206); 

        // Save the PDF
        doc.save('chart.pdf');

                });
            }
        }
    </script>

    <style>
        body {
            margin: 0px;
            overflow-y: hidden;
            

        }
        #content{
            overflow:hidden;
        }
        #piechart {
            display: flex;
        justify-content: center;
        align-items: center;
        height: 400px;
        width:1000px;

        }
        
    </style>
    <style>
    /* Style the select element */
    

    select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        margin-right: 10px;
    }

    input[type="submit"] {
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    /* Style the button */
    .a {
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        position: fixed;
        bottom: 20px;
        right: 20px;
    }
</style>
</head>

<body>


    </head>

        

<div class="my-div">
<form method="post" action="">
        
        <select name="interval" id="interval">
        <option value="" ></option>
            <option value="teacups" >Tea Cups Per Day</option>
            <option value="quality">Quality Product</option>
            <option value="price">Price Per Kg</option>
            <option value="quantity">Quantity Per Month</option>
            <option value="taste">Taste</option>
            <option value="gift">Gift</option>
        </select>
        <input type="submit" value="Submit" name="submit">
    </form>
    
    <button class="a" onclick="generatePDF()">Generate PDF</button>
</div>
        <div id="content1">
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

        <script>
            // Prepare the data for the chart
        </script>
    </body>

</html>