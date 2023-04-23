<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}
table, td, th {
    border: 1px solid black;
    padding: 5px;
}
th {text-align: left;}
</style>
</head>
<body>
 
<?php
$q = intval($_GET['q']);
 
 

$servername = "localhost";
$username = "jjukkh";
$password = "admin3393!";
$dbname = "jjukkh";
 
// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
 
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
 
mysqli_select_db($con,"jjukkh");
$sql="SELECT * FROM user  id = ".$q;
$result = mysqli_query($con,$sql);
 
echo "<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['firstname'] . "</td>";
    echo "<td>" . $row['lastname'] . "</td>";
    echo "<td>" . $row['age'] . "</td>";
    echo "<td>" . $row['hometown'] . "</td>";
    echo "<td>" . $row['job'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($con);
?>
</body>
</html>


