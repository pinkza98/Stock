<?php include 'con_db.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index_Stock</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<head>
	<title>CRUD: CReate, Update, Delete</title>
</head>
<body>
<?php
	ini_set('display_errors', 1);
	error_reporting(~0);

	$strKeyword = null;

	if(isset($_POST["txtKeyword"]))
	{
		$strKeyword = $_POST["txtKeyword"];
	}
?>
<?php include 'layout/nav.php'?>
    <form name="frmSearch" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">    
    <table width="599" border="1">
        <tr>
            <th>บาร์โค้ด
            <input name="txtKeyword" type="text" id="txtKeyword" value="<?php echo $strKeyword;?>">
            <div class="btn btn-success">
			<button class="btn" type="submit" velue="Search" >ค้นหา</button>
		</div></th>
        </tr>
    </table>

		
    
        <br> 
      
        <hr>  
        

        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">รหัสบาร์โค้ด : </span>
            </div>
        </div>

        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">รายการ : </span>
            </div>
        </div>
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">ส่วนกลาง : </span>
                
            </div>
        </div>
        <table class="table">
	
</table>

	</form>
</body>
</html>