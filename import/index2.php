<?php
$conn = mysqli_connect("localhost","dikwon79","ab0612abcD!@","dikwon79");
require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');

if (isset($_POST["import"]))
{
    
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
		
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $center = "";
                if(isset($Row[0])) {
                    $center = mysqli_real_escape_string($conn,$Row[0]);
                }
             
                $itemcode = "";
                if(isset($Row[1])) {
                    $itemcode = mysqli_real_escape_string($conn,$Row[1]);
                }
				$itemname = "";
                if(isset($Row[2])) {
                    $itemname = mysqli_real_escape_string($conn,$Row[2]);
                }
				$customer = "";
                if(isset($Row[3])) {
                    $customer = mysqli_real_escape_string($conn,$Row[3]);
                }
				$deadtype = "";
                if(isset($Row[4])) {
                    $deadtype = mysqli_real_escape_string($conn,$Row[4]);
                }
				$unit = "";
                if(isset($Row[5])) {
                    $unit = mysqli_real_escape_string($conn,$Row[5]);
                }
				$surang = "";
                if(isset($Row[6])) {
                    $surang = mysqli_real_escape_string($conn,$Row[6]);
                }
				$chanum = "";
                if(isset($Row[7])) {
                    $chanum = mysqli_real_escape_string($conn,$Row[7]);
                }
				$deliver = "";
                if(isset($Row[8])) {
                    $deliver = mysqli_real_escape_string($conn,$Row[8]);
                }
				$mcode = "";
                if(isset($Row[9])) {
                    $mcode = mysqli_real_escape_string($conn,$Row[9]);
                }
                $mcondition = "";
                if(isset($Row[10])) {
                    $mcondition = mysqli_real_escape_string($conn,$Row[10]);
                }
				$special = "";
                if(isset($Row[11])) {
                    $special = mysqli_real_escape_string($conn,$Row[11]);
                }
				$deaddate = "";
                if(isset($Row[12])) {
                    $deaddate = mysqli_real_escape_string($conn,$Row[12]);
                }
                $barcode = "";
                if(isset($Row[13])) {
                    $barcode = mysqli_real_escape_string($conn,$Row[13]);
                }
				$orderY = "";
                if(isset($Row[14])) {
                    $orderY = mysqli_real_escape_string($conn,$Row[14]);
                }
				$cancelY = "";
                if(isset($Row[15])) {
                    $cancelY = mysqli_real_escape_string($conn,$Row[15]);
                }
				$emergenY = "";
                if(isset($Row[16])) {
                    $emergenY = mysqli_real_escape_string($conn,$Row[16]);
                }
                  

                if (!empty($center) || !empty($itemcode)) {
                    $query = "insert into testcj(center,itemcode,itemname,customer,deadtype,unit,surang, 
                              chanum,deliver,mcode,mcondition,special,deaddate,barcode,orderY,cancelY,emergenY ) 
							  values('".$center."','".$itemcode."','".$itemname."','".$customer."','".$deadtype."','".$unit."'
							  ,'".$surang."','".$chanum."','".$deliver."','".$mcode."','".$mcondition."','".$special."'
							  ,'".$deaddate."','".$barcode."','".$orderY."','".$cancelY."','".$emergenY."')";
                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
                }
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
?>



<!DOCTYPE html>
<html>    
<head>
<style>    
body {
	font-family: Arial;
	width: 550px;
}

.outer-container {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 40px 20px;
	border-radius: 2px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
    border-radius: 2px;
	color: #f0f0f0;
	cursor: pointer;
    padding: 5px 20px;
    font-size:0.9em;
}

.tutorial-table {
    margin-top: 40px;
    font-size: 0.8em;
	border-collapse: collapse;
	width: 100%;
}

.tutorial-table th {
    background: #f0f0f0;
    border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.tutorial-table td {
    background: #FFF;
	border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
</head>

<body>
    <h2>엑셀파일 DB작업</h2>
    
    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
        
            </div>
        
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    
         
<?php
    $sqlSelect = "SELECT * FROM testcj";
    $result = mysqli_query($conn, $sqlSelect);

if (mysqli_num_rows($result) > 0)
{
?>
        
    <table class='tutorial-table'>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>

            </tr>
        </thead>
<?php
    while ($row = mysqli_fetch_array($result)) {
?>                  
        <tbody>
        <tr>
            <td><?php  echo $row['center']; ?></td>
            <td><?php  echo $row['itemcode']; ?></td>
        </tr>
<?php
    }
?>
        </tbody>
    </table>
<?php 
} 
?>

</body>
</html>