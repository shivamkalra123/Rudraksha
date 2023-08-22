<?php include 'filesLogic.php';?>
<?php include "generatepdf.php";?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="style.css">
  <title>Download files</title>
  <style>
    table {
    width: 100%;
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
.a{
  background-color:#66FF99;
  text-decoration:none;
  padding:5px 15px;
}
.b{
  text-decoration:none;
  padding:5px 15px;
  background-color:#A4ACA7;

}
.c{
  background-color:#FF3F3F; 
  text-decoration:none;
  padding:5px 15px;
}
.changes{
  color:#FF3F3F;
  text-align:right;
}
  </style>
</head>
<head>
    <!-- Required meta tags-->
    
<table>
<thead>
    
    <th>FirstName</th>
    <th>LastName</th>
    <th>Current Company</th>
    <th>Designation</th>
    <th>Work Experience</th>
    <th>AP_ID</th>
    <th>Resume</th>
    
    <th>Selection</th>
    <th>Current Status</th>
   
 
</thead>
<tbody>

  <?php 
 
  foreach ($files as $file): ?>
    
      <tr>
      
      
      <td><?php echo $file['first_name']; ?></td>
      <td><?php echo $file['last_name']; ?></td>
      <td><?php echo $file['designation']; ?></td>
      <td><?php echo $file['experience']; ?></td>
      <td><?php echo $file['current_company']; ?></td>
      <td><?php echo $file['AP_ID']; ?></td>


      <td><a href="recruit.php?file_id=<?php echo $file['id'] ?>">Download</a></td>
      
      <form method="POST">
            <td>

            <a class="a" href="download.php?file_id1=<?php echo $file['id'] ?>">Accept</a>
            <a class="b" href="download.php?file_id2=<?php echo $file['id'] ?>">On Hold</a>
            <a class="c" href="download.php?file_id3=<?php echo $file['id'] ?>">Reject</a>
          </td>
          </form>
          <td><?php echo $file['selection']; ?></td>
         
    </tr>
    <p class="changes">*Refresh to see changes</p>
  
  <?php  endforeach;  ?>
  
 

</tbody>
</table>
<h5 class="changes">*Refresh to see changes</h5>
<form action="download.php" method="post">
<input type="submit" name="create" value="Generate Report"></input>

</form>



</body>
</html>